<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TypingEvent implements ShouldBroadcast
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
        // dd($this->data['typing']);
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
        
        $type=[];
        $type['typing']=$this->data['typing'];
        $type['type']=$this->data['type'];
        
        return [ 'to_user'=>[$this->data['id']['id']] , 'data'=> $type];
        
    }
}
