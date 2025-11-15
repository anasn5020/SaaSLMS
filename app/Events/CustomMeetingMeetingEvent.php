<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomMeetingMeetingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;


    public function __construct($message)
    {
        config()->set('broadcasting.default', 'pusher');

        $this->message = $message;
    }


    public function broadcastOn()
    {
        return ['custom-class-message-channel'];
    }

    public function broadcastAs()
    {
        return 'new-class-message-' . $this->message['id'] ?? '';
    }

}
