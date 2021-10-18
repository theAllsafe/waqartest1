<div class="row">
<div id="message_row">
<div class="row">
<input type="text" name="" id="message" class="form-control" style="width:80%;" required> &nbsp;<a href="#" class="btn btn-info" id="send_message" >Send Message</a>
</div>
</div>
<div id="demo"></div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<style type="text/css">
  #message_row {
      float:  right; 
      width: 100%;
  }
  #demo{
    margin-left: 30px;
  }
  #my{
    float: left;
  }
  #other{
    float: right;
  }
</style>
<script type="text/javascript">
  var x = '';
  var index = 1;

  // var socket = io('https://live.com:8081');
  var socket = io('http://localhost:8081');

  console.log(socket);

  socket.on('connect', () => {
    $.ajax({
        type: "POST",
        url: "{{url('/socket/join')}}",
        data: {
            "_token": "{{ csrf_token() }}",
              socket_id: socket.id,
              user: 3,
        },
        success: function (response) {
          console.log('sucess');
        }
    });
    console.log(socket.id);
  });

  // socket.on('connect', connectUser); console.log(socket);

  socket.on('notification.user_offline', function (data) {
    console.log(data);
  });

  $('#send_message').click(function(){
    if($('#message').val()){
      $.ajax({
        type: "POST",
        url: "{{url('/store-message')}}",
        data: {
            "_token": "{{ csrf_token() }}",
            reciever_id:  56,
            sender_id:  57,
            communication_id : 1,
            message : $('#message').val(),
            communication_id : 1,
            type: 'text'
        },
        success: function (response) {
          if(response.success == true){
            // console.log(response.success);
            $('#message').val('');
            $('#demo').append('<p id="my">'+response.data.message+'</p><br>')
           } 
        }
      });
    }
  });

  // console.log(socket.id);
  // console.log(socket.connected[socketId]);

  // socket.on('connect', connectUser);
  //   console.log('Socket server');
  //   console.log(socket);
  //   function connectUser () {  // Called whenever a user signs in
  //   var userId = 104;
  //   if (!userId) return;
  //   socket.emit('connection', userId);
  //   console.log('connected');
  // }

  function connectUser () {  // Called whenever a user signs in
    var socket_id = 104 ;// Retrieve userId
    if (!socket_id) return;
    socket.emit('userConnected', socket_id);
  }

  function disconnectUser () {  // Called whenever a user signs out
    var userId = 104 ;// Retrieve userId
    if (!userId) return;
    socket.emit('userDisconnected', userId);
  }

  socket.on('chat.App\\Events\\SendMessage', function(data)
  {
    console.log("chat.App\\Events\\SendMessage");
    console.log(data.data);
    $('#demo').append('<p id="other"> '+data.data.data.message+'</p><br>');
  });

  socket.on('chat.App\\Events\\SendSeenStatus', function(data)
  {  
    console.log('chat.App\\Events\\SendSeenStatus');
    console.log(data);   
  });

  socket.on('chat.App\\Events\\ChatInboxList', function(data)
  {  
    console.log('chat.App\\Events\\ChatInboxList');
    console.log(data);
  });

  socket.on('chat.App\\Events\\TypingEvent', function(data)
  {  
    console.log('chat.App\\Events\\TypingEvent');
    console.log(data);   
  });

  socket.on('chat.App\\Events\\UserOnlineStatus', function(data)
  {  
    console.log('chat.App\\Events\\UserOnlineStatus');
    console.log(data);
  });

  socket.on('chat.App\\Events\\DeleteChatMessage', function(data)
  {  
    console.log('chat.App\\Events\\DeleteChatMessage');
    console.log(data);
  });

  socket.on('chat.App\\Events\\DeleteSenderChatMessage', function(data)
  {  
    console.log('chat.App\\Events\\DeleteSenderChatMessage');
    console.log(data);
  });

  socket.on('chat.App\\Events\\SendDeliverStatus', function(data)
  {  
    console.log('chat.App\\Events\\SendDeliverStatus');
    console.log(data);
  });

  socket.on('clientEvent', function(data)
  {
    console.log("clientEvent");
    console.log(data);
  });    

  socket.on('message', function(data)
  {
    console.log("New test");
    console.log(data);
  });

  socket.on('chat.send.message', function($data,callback){
    console.log("send message");    
  });

</script>