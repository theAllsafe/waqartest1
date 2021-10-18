<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;
use App\Models\Users;
use App\Models\ChatList;

use App\Events\SendDeliverStatus;
use App\Http\Controllers\Controller;
use Auth;

class SocketController extends Controller
{
    public function join(Request $request)
    {
        $request->validate(
            [
                'socket_id' => 'required|regex:/^[^.]+$/',
            ]
        );
        $user_id = Auth::check() ? Auth::id() : $request->user ;
        
        $old_socket = Auth::user()->socket_id;
       
        $socket_id = $request->socket_id;

        $joining_key = "active.users.{$user_id}.{$old_socket}";
        Redis::del($joining_key);

        $joining_key = "active.users.{$user_id}.{$socket_id}";
        Redis::set($joining_key, 1);
        $active_user_keys = Redis::keys('active.users.*.*');
        Users::where('id',$user_id)->update(['is_online'=>'yes','socket_id' => $request->socket_id]);

          $data_id['data']=ChatList::where(['reciever_id'=>$user_id,'seen_status'=>'Sent'])->with('recieveruser','user')->whereHas('recieveruser', function ($query) use($user_id){
                                $query->where('on_chat_screen', $user_id);
                             })->get();
          if($data_id){
            foreach ($data_id['data'] as $key => $value) {
                  $value['photo_url']=env('APP_URL').'/img/profile/';
              event(new SendDeliverStatus($value));
            }
          }

         return response()->json([
                'active_users' => $active_user_keys,
            ]);
    }
}
