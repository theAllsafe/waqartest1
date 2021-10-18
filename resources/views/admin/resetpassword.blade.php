<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reset Password </title>
  
	<!-- Bootstrap 4.0-->
	<link rel="stylesheet" href="{{ URL::asset('admin_assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">
	
	<!-- Bootstrap extend-->
	<link rel="stylesheet" href="{{ URL::asset('admin_assets/css/bootstrap-extend.css') }}">
	
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ URL::asset('admin_assets/css/master_style.css') }}">

	<!-- Ekan Admin skins -->
	<link rel="stylesheet" href="{{ URL::asset('admin_assets/css/skins/_all-skins.css') }}">	


</head>
<body class="hold-transition dark bg-img" style="background-image: url({{ URL::asset('admin_assets/images/auth-bg/bg.jpg') }})" data-overlay="3">
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">	
			
			<div class="col-12">
				<div class="row no-gutters">
					<div class="col-lg-4 col-md-5 col-12">
						<div class="content-top-agile p-10">					
						</div>
					</div>
					<div class="col-lg-4 col-md-5 col-12">
						<div class="content-top-agile p-10">
							<h2><img src="{{ URL::asset('admin_assets/images/School.png') }}" alt="logo" style="width: 251px;"></h2>					
						</div>
						
						<div class="p-30 content-bottom rounded bg-img box-shadowed" style="background-image: url(../../images/auth-bg/bg-1.jpg);" data-overlay="8">
							
								<input id="email" value="{{$data['email']}}" type="hidden">
								<input name="token" value="{{$data['token']}}" type="hidden">
								<div class="form-group">
									<div class="input-group mb-3">
										<input name="password" type="password" class="form-control pl-15 bg-transparent bt-0 bl-0 br-0 text-white" placeholder="New Password" id="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group mb-3">
										<input name="confirmpassword" id="confirmpassword" type="password" class="form-control pl-15 bg-transparent bt-0 bl-0 br-0 text-white" placeholder="Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
									</div>
								</div>
								  <div class="row">
									<!-- /.col -->
									<div class="col-12 text-center">
									  <button class="submit btn btn-info btn-block margin-top-10">Submit</button>
									</div>
									<!-- /.col -->
								  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	

	<!-- jQuery 3 -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
	
	<!-- popper -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/popper/dist/popper.min.js') }}"></script>
	
	<!-- Bootstrap 4.0-->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function(){
     $('.submit').on('click',function(){
         
         var psw = $('#psw').val();
         var email = $('#email').val();
         var confirmpassword = $('#confirmpassword').val();
         if(psw){
         if(psw==confirmpassword){
            alert("Password & confirm password match")
            $.ajax({
            type: "get",
            dataType: "json",
            url: "{{ url('reset/response') }}",
            data: {'password':psw,'email':email},
    
            success: function (response) {
               if(response=='0')
    		    {
    		        alert("Successfully");
    		    }
    		    else{
    		        alert("Try again");
    		    }
            }
            });
         }else{
             alert("Password & confirm password not match")
         }
         }else{
             alert("Please enter password")
         }
    	
    });
 });
</script>
</body>
</html>
