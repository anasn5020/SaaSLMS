<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class NewNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type, $message, $link, $user, $login_user_id;

    public function __construct($type, $message, $link = null, $user_id = null)
    {
        config()->set('broadcasting.default', 'pusher');

        $this->type = $type;
        $this->message = $message;
        $this->link = $link;
        $this->user = $user_id;
        $this->login_user_id = Auth::id();
    }

    public function broadcastOn()
    {
        return ['new-notification-channel'];
    }

    public function broadcastAs()
    {
        return 'new-notification';
    }
}
