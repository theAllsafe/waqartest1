<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SelectedSeenStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $data = null;
    private $auth_id = '';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data,$auth_id)
    {
        $this->data = $data->distinct('communication_id')->get();
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
        /*dd($this->data);
        dd($this->data->groupBy('communication_id')->get());*/

        $to_user = []; $to_user_key = 0;  $communication_ids = []; $communication_key = 0; 
        foreach ($this->data as $key => $chat) {

            $to_user[$to_user_key++] = $chat->reciever_id  ==  $this->auth_id ? $chat->sender_id : $chat->reciever_id;

            $communication_ids[$communication_key++] = $chat->communication_id;
             
        }
        
        return [ 'to_user'=>$to_user , 'data'=> $communication_ids ];
    }
}
