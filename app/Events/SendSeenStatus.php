<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendSeenStatus implements ShouldBroadcast
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
        $this->data = $data;
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
        // dd($this->data);
        $to_user = $this->data->reciever_id  ==  $this->auth_id ? $this->data->sender_id : $this->data->reciever_id;
        
        return [ 'to_user'=>[$to_user] , 'data'=> $this->data ];
    }

}
