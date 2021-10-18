<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class ChatInboxList implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $data = null;

    private $unseen_count = null;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data,$unseen_count)
    {
        $this->data = $data;
        // dd($this->data['data']['user']['id']);
        $this->unseen_count = $unseen_count;
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
    // dd($this->data->user->id);
        return [ 'to_user'=>[$this->data['data']['recieveruser']['id']] ,'data' => [ 'type'=>'receiving' ,'data'=> $this->data['data'],'unseen_count' => $this->unseen_count ] ];
    }
}
