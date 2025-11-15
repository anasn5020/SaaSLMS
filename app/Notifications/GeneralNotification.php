<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => @$this->details['title'] ?? "",
            'body' => $this->details['body'] ?? "",
            'actionText' => $this->details['actionText'] ?? "",
            'actionURL' => $this->details['actionURL'] ?? "",
            'id' => $this->details['id'] ?? '',
            'notification_type' => $this->details['notification_type'] ?? "",
        ];
    }
}
