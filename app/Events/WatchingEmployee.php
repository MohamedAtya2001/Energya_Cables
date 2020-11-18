<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WatchingEmployee implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $sheet_name;
    public $sheet_item;
    public $attribute;
    public $value;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sheet_name, $sheet_item,$attribute, $value)
    {
        $this->sheet_name = $sheet_name;
        $this->sheet_item = $sheet_item;
        $this->attribute = $attribute;
        $this->value = $value;
    }

    /** 
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('channel-WatchingEmployee');
    }

    public function broadcastAs(){
        return 'WatchingEmployee'; 
    }

}
