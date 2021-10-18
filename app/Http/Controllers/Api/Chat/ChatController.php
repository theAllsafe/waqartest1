<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;
use App\Models\ChatList;
use App\Models\Users;

use App\Events\ChatInboxList;
use App\Events\DeleteChatMessage;
use App\Events\DeleteSenderChatMessage;
use App\Events\SelectedSeenStatus;
use App\Events\SendDeliverStatus;
use App\Events\SendMessage;
use App\Events\SendSeenStatus;
use App\Events\TypingEvent;
use App\Events\UserOnlineStatus;

use Auth;

class ChatController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 500;
    public $errorUnAuthorisedStatus = 401;
    
    public function ChatList(Request $request)
    {
        $id=$request['auth_id'];
        Users::where('id',$id)->update(['is_online' => 'yes','on_chat_screen' => null]);

        $data_id=ChatList::where('sender_id',$id)->orWhere('reciever_id',$id)->select('communication_id')->orderBy('communication_id','desc')->distinct('communication_id')->pluck('communication_id')->toArray();
           $comm_id=[];  

        foreach ($data_id as $key => $value) {
            $comm_id[]=ChatList::where('communication_id',$value)->max('id');
        }

        $data=ChatList::whereIn('id',$comm_id)->whereJsonDoesntContain('deleted_by',$id)->with('recieveruser','user','parentJob','parentJobnew')->orderBy('id','desc')->paginate(10);
        $count=[];

        foreach ($data as $key => $value) {
            $count[] =  ChatList::where(['communication_id'=> $value->communication_id, 'reciever_id' => $id,'status' => 'unread'])->count();
        }

        foreach ($count as $key => $value) {
            $data[$key]['unread_count']=$value;
        }

        $message = 'No have data to change seen status.';
        $a=Users::where('on_chat_screen',$id)->pluck('id')->toArray();
        if($a)
        {     
            Users::where('id',$id)->update(['is_online'=>'yes']);
            $online_status='Online';
            event(new UserOnlineStatus($a,$online_status,$id)); 
        }
        $status='true';
        $message='chat_list';
    
        return response()->json(['success' => true, 'message' => 'List fetched Successfully.','data' => $data], $this->successStatus);
    }

    public function exitChatScreen(Request $request)
    {
        $id=$request['auth_id'];
        $user = Users::where('id',$id)->first();
        if(empty($request->id))
        {
            $user->update(['is_online' => 'no','on_chat_screen' => null]);
            $a=Users::where('on_chat_screen',$id)->pluck('id')->toArray();
            if($a)
            {     
                $user->update(['is_online'=>'no']);
                $online_status='Offline';
                event(new UserOnlineStatus($a,$online_status,$id));
            }
        }

        if(!empty($request->id))
        {
            $user->update(['on_chat_screen' => null]);
            $a=Users::where('on_chat_screen',$id)->pluck('id')->toArray();
            if($a)
            {     
                $user->update(['is_online'=>'no']);
                $online_status='Offline';
                event(new UserOnlineStatus($a,$online_status,$id));
            }
        }

        $status='true';
        $message='Offline';
        return response()->json(['success' => true, 'message' => 'Offline','data' => []], $this->successStatus);
    }

    public function onChatScreen(Request $request)
    {
        $auth_id=$request['auth_id'];
        $id=$request->id;
        Users::where('id',$auth_id)->update(['is_online' => 'yes','on_chat_screen' => $id]);
        $data_id=ChatList::where('sender_id',$id)->orWhere('reciever_id',$id)->select('communication_id')->orderBy('communication_id','desc')->distinct('communication_id')->pluck('communication_id')->toArray();
        $comm_id=[];   

        foreach ($data_id as $key => $value) {
            $comm_id[]=ChatList::where('communication_id',$value)->max('id');
        }

        $data=ChatList::whereIn('id',$comm_id)->with('recieveruser','user')->orderBy('id','desc')->get();
        
        if($data)
        {     
            $user = Users::find($request->id);
            $user->update(['is_online'=>'yes']);
            $online_status='Online';
            event(new UserOnlineStatus($data,$online_status,$auth_id));
        }
        return $this->returnResponse(true, 200, 'You entered the chat screen', '');
    }

    public function ChatDetail(Request $request,$reciever_id)
    {
        $id=$request['auth_id'];
        $comm_id = ChatList::where(function($q) use($id, $reciever_id){
                $q->where(['sender_id'=>$id,'reciever_id'=>$reciever_id])
                ->orWhere(function($q) use($id, $reciever_id){
                    $q->where('sender_id',$reciever_id)
                        ->where('reciever_id',$id);
                    });
            })->first();

        if($comm_id) {
            $data['communication_id'] = $comm_id->communication_id;            
        }else {
          $max_id=ChatList::max('communication_id');
          $data['communication_id']= $max_id+1;
        } 

        $data['data']=ChatList::where(function($q) use($id, $reciever_id){
            $q->where(['sender_id'=>$id,'reciever_id'=>$reciever_id])
            ->orWhere(function($q) use($id, $reciever_id){
                $q->where('sender_id',$reciever_id)
                    ->where('reciever_id',$id);
                });
        })->whereJsonDoesntContain('deleted_by',$id)
        ->with('recieveruser','user')
        ->orderBy('id','desc')
        ->paginate(10);


        Users::where('id',$id)->update(['on_chat_screen' => $reciever_id,'is_online' => 'yes']);
        $a=Users::where('on_chat_screen',$id)->pluck('id')->toArray();
        
        if($a){               
            $online_status='Online';
            event(new UserOnlineStatus($a,$online_status,$id)); 
        }

        $online=Users::where('id',$reciever_id)->select('is_online')->first();
        $data['online_status']=$online->is_online == 'yes' ? 'yes' : 'no';
        $status='true';
        $message='chat_detail';

        return response()->json(['success' => true, 'message' => 'Detail fetched Successfully.','data' => $data], $this->successStatus);
    }

    public function storeSocketId(Request $request)
    {
        $user_id = $request['auth_id'];
        Users::where('id',$user_id)->update(['socket_id' => $request->socket_id]);
        $status='true';
        $message='Socket Id ';
        return $this->returnResponse($status,$message,$data=[]);
    }

    public function StoreMessage(Request $request)
    {
        $id=$request['auth_id'];
        $reciever_id=$request->reciever_id;

        if($request->communication_id_1) {
            $data['communication_id']=$request->communication_id;
        }else {
            $com_id=ChatList::where(function($q) use($reciever_id){
                $q->where(['sender_id'=>$id,'reciever_id'=>$reciever_id])
                ->orWhere(function($q) use($reciever_id){
                    $q->where('sender_id',$reciever_id)
                        ->where('reciever_id',$id);
                    });
            })->orderBy('id','desc')->first();

            if(empty($com_id->communication_id)){
              $max_id=ChatList::max('communication_id');
              $data['communication_id']= $max_id+1;
            }
            else{
               $data['communication_id']=$com_id->communication_id;
            }
        }

        $int=[];
        $data['sender_id']=$id ? $id : $request->sender_id;
        $data['reciever_id']=$request->reciever_id;
        $data['message']=$request->message;
        $data['seen_status']='Sent';
        $data['deleted_by']= json_encode(array_values($int));
        $data['type'] = $request->type;
        $data['docs']='txt';
        $data['status']='unread';

        if ($request->hasFile('media')) {
            $document=$request->media;      
            // $url = s3ImageUpload($document, '/chat/');
            $url="";
            $data['docs']=$url;
        }

        $chat_id=ChatList::create($data);
        $chat=ChatList::where('id',$chat_id->id)->with('recieveruser','user')->first();
        $chat->photo_url=env('APP_URL').'/img/profile/';
        $user=Users::where('id',$reciever_id)->first();
        $sender_id = $id ? $id : $request->sender_id;
        $sender_name=Users::where('id',$sender_id)->first();
        $name=$sender_name->first_name.' '.$sender_name->last_name;
        $data=ChatList::where('id',$chat_id->id)->with('recieveruser','user')->first();
        $active_user_keys = Redis::keys('active.users.*.*');
        $str=[];

        foreach ($active_user_keys as $key => $value) {
            $str[]= explode(".",$value);
        }

        $b=array_column($str, 2);
        $c=array_column($str, 3);

        foreach ($c as $key => $value) {
            if($value == $user->socket_id){
                ChatList::where(['id'=>$chat_id->id])->where('seen_status','!=','Seen')->update(['seen_status' => 'Delivered']);
                $data=ChatList::where('id',$chat_id->id)->with('recieveruser','user')->first();
                  event(new SendDeliverStatus($data,$id));
            }
        }        
       
        $chat1['data']=ChatList::where('id',$chat_id->id)->with('recieveruser','user')->first();
        event(new SendMessage($chat1));

        $sender_name=Users::where('id',$reciever_id)->first();
        $data1['data']=ChatList::where('id',$chat_id->id)->with('recieveruser','user')->first();
        $data1['data']['unread_count'] = ChatList::where(['communication_id'=> $data['communication_id'], 'reciever_id' => $sender_name->id,'status' => 'unread'])->count();
        $unseen_count='';
        
        if($user->is_online == 'yes' && $user->on_chat_screen == null){   
            event(new ChatInboxList($data1,$unseen_count));
        }

        // if ($user->on_chat_screen != $id) {
            // $notiData['body']='sent a new '.$request->type;
            // if (isset($request->message)) {
            //     $notiData['body']= $request->message;
            // }
            // $notiData['user_id']=$request->reciever_id;
            // $notiData['notify_key'] = 'chat_message';
            // chatMessageNoti($notiData);   
        // }

        $status='true';
        $message='store';
        $chat_id1=ChatList::where('id',$chat_id->id)->first();
    
        return response()->json(['success' => true, 'message' => 'Message Stored Successfully.','data' => $chat_id1 ], $this->successStatus);
    }

    public function DeleteMessage(Request $request,$id)
    {
        $delete=ChatList::where('id',$id)->with('user','recieveruser')->first();
        event(new DeleteChatMessage($delete));  

        $data=ChatList::where('id',$id)->delete();
        $status='true';
        $data=[];
        $message='Message Deleted Successfully ';
        return response()->json(['success' => true, 'message' => 'Message Deleted Successfully.','data' => []], $this->successStatus);     
    }

    public function DeleteChatListMessage(Request $request,$id)
    {
        $user_id = $request['auth_id'];
        $int=ChatList::where('communication_id',$id)->first();

        if($int->deleted_by == []){
             $int1[0]=$user_id;
             $data=ChatList::where('communication_id',$id)->update(['deleted_by' => json_encode(array_values($int1))]);
        }else {
            $int1=json_decode($int->deleted_by);
            $count=count($int1);
            $int1[$count]=$user_id;
            $data=ChatList::where('communication_id',$id)->update(['deleted_by' => json_encode(array_values($int1))]);
        }

        $status='true';
        $data=[];
        $message='User Message Deleted Successfully ';
        return response()->json(['success' => true, 'message' => 'User Message Deleted Successfully.','data' => []], $this->successStatus);      
    }

    public function changeStatusSeen(Request $request)
    {
        $id=$request['auth_id'];

        $this->validate($request, 
        [
            'communication_id' => 'required',
        ]);

        $data = ChatList::with('recieveruser')
                ->where('communication_id',$request->communication_id)
                ->where('seen_status','<>','Seen')
                ->where('reciever_id',$id)
                ->orderBy('id','desc')
                ->first();

        ChatList::where('communication_id',$request->communication_id)
            ->where('seen_status','<>','Seen')
            ->where('reciever_id',$id)
            ->update(['status' => 'read','seen_status'=>'Seen']);

        $message = 'No have data to change seen status.';
        
        if($data){     
            event(new SendSeenStatus($data,$id));
            $message = 'Seen status change successfully.';
        }
       
        $status='true';
        $data=[];
        $message = 'Seen status change successfully.';
        return response()->json(['success' => true, 'message' => 'Seen status change successfully.','data' => []], $this->successStatus);
    }

    public function changeSelectedStatusSeen(Request $request)
    {
        $id=$request['auth_id'];

        $this->validate($request, 
             ['communication_ids'    => 'required',
              'communication_ids.*'  => 'string|exists:chat_lists,communication_id'
        ]);
        $data = ChatList::whereIn('communication_id',$request->communication_ids)
                 ->where('seen_status','<>','Seen')
                 ->where('reciever_id',$id);

        $response_data   = clone $data;
        $response_socket = clone $data;
        $a=$response_socket->distinct('communication_id')->get();
        $response  = $response_data->orderBy('id','desc')->first();
        $message = 'No have data to change seen status.';

        if($response) {     
            event(new SelectedSeenStatus($response_socket,$id));
            $data->update(['seen_status'=>'Seen']);
            $message = 'Seen status change successfully.';
        }

        $status='true';
        $data=[];
        $message = 'Seen status change successfully.';
        return response()->json(['success' => true, 'message' => 'Seen status change successfully.','data' => []], $this->successStatus);
    }

    public function changeStatusDeliver(Request $request)
    {
        $id=$request['auth_id'];

        $this->validate($request, 
             ['communication_id' => 'required|exists:chat_lists',
        ]);
         
        $data = ChatList::with('recieveruser')->where('communication_id',$request->communication_id)
                ->where('seen_status','Sent')
                ->where('reciever_id',$id)->orderBy('id','desc')->first();

        $message = 'No have data to change deliver status.';
        $active_user_keys = Redis::keys('active.users.*.*');
        $str=[];

        foreach ($active_user_keys as $key => $value) {
            $str[]= explode(".",$value);
        }

        $b=array_column($str, 2);
        $c=array_column($str, 3);
        $user=Users::where('id',$id)->first();

        foreach ($c as $key => $value) {
            if($value == $user->socket_id){
                if($data){
                    $data->update(['seen_status'=>'Delivered']);
                    event(new SendDeliverStatus($data,$id));
                    $message = 'Deliver status change successfully.';
                }        
            }
        }        
       
        $status='true';
        $data=[];
        return response()->json(['success' => true, 'message' => 'Deliver status change successfully.','data' => []], $this->successStatus);
    }

    public function Typing(Request $request)
    {
        $id=$request['auth_id'];

        if($request->typing_status == 'start'){
            $data['id']=Users::where('id',$request->id)->first();
            $data['typing']=$request->typing_status;
            $data['type']='text';

            if($data['id']->on_chat_screen == $id){
                event(new TypingEvent($data));
            }

            $status='true';
            $data=[];
            $message='Typing event start ';
            return response()->json(['success' => true, 'message' => 'Typing event start ','data' => []], $this->successStatus);
        }

        if($request->typing_status == 'stop'){
            $data['id']=Users::where('id',$request->id)->first();
            $data['typing']=$request->typing_status;
            $data['type']='text';

            if($data['id']->on_chat_screen == $id){
                event(new TypingEvent($data));
            }

            $status='true';
            $data=[];
            $message='Typing event stopped ';
            return response()->json(['success' => true, 'message' => 'Typing event stopped ','data' => []], $this->successStatus);
        }
    }

    public function AudioRecord(Request $request)
    {
        $id=$request['auth_id'];

        if($request->typing_status == 'start'){
            $data['id']=Users::where('id',$request->id)->first();
            $data['typing']=$request->typing_status;
            $data['type']='audio';

            if($data['id']->on_chat_screen == $id){
                event(new TypingEvent($data));
            }

            $status='true';
            $data=[];
            $message='Typing event start ';
            return response()->json(['success' => true, 'message' => 'Typing event start ','data' => []], $this->successStatus);
        }

        if($request->typing_status == 'stop'){
            $data['id']=Users::where('id',$request->id)->first();
            $data['typing']=$request->typing_status;
            $data['type']='audio';

            if($data['id']->on_chat_screen == $id){
                event(new TypingEvent($data));
            }

            $status='true';
            $data=[];
            $message='Typing event stopped ';
            return response()->json(['success' => true, 'message' => 'Typing event stopped ','data' => []], $this->successStatus);
        }
    }

    public function TotalUnreadCount(Request $request)
    {
        $id=$request['auth_id'];
        $data_id=ChatList::where('sender_id',$id)->orWhere('reciever_id',$id)->select('communication_id')->orderBy('communication_id','desc')->distinct('communication_id')->pluck('communication_id')->toArray();
        $comm_id=[];   
        
        foreach ($data_id as $key => $value) {
            $comm_id[]=ChatList::where('communication_id',$value)->max('id');
        }

        $data=ChatList::whereIn('id',$comm_id)->with('recieveruser','user')->orderBy('id','desc')->paginate(10);
        $count=[];

        foreach ($data as $key => $value) {
            $count[] =  ChatList::where(['communication_id'=> $value->communication_id, 'reciever_id' => $id,'status' => 'unread'])->count();
        }

        $total=array_sum($count);
        $status='true';
        $data1['unread_count']=$total;
        $message='unread count';
        return response()->json(['success' => true, 'message' => 'unread count','data' => $data1], $this->successStatus);
    }
}