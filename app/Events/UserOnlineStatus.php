<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Auth;

class UserOnlineStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $data = null;
    private $status = null;
    private $auth_id = null;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data,$status,$auth_id)
    {
       
        $this->data = $data;
       // dd($this->data);
        $this->status = $status;
        $this->auth_id = $auth_id;
       
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['chat'];
    }

    public function broadcastWith()
    {
        // dd(env('BROADCAST_DRIVER'));
        //     $to_user = []; $to_user_key = 0;  $communication_ids = []; $communication_key = 0; 
        // foreach ($this->data as $key => $chat) {

        //     $to_user[$to_user_key++] = $chat->reciever_id  ==  \Auth::id() ? $chat->sender_id : $chat->reciever_id;

        //     $communication_ids[$communication_key++] = $chat->communication_id;
             
        // }
        // dd($this->data);
        $data['user_id']=$this->auth_id;
        $data['status']=$this->status;
        
        return [ 'to_user'=>$this->data , 'data'=> $data ];
    }
}
