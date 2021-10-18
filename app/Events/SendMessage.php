<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $data = null;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
    
        $this->data = $data;
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

        return [ 'to_user'=>[$this->data['data']['reciever_id']] , 'data'=> $this->data['data']];
        
    }
}
