<?php

namespace App\Jobs;

use App\Traits\SendNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class EventNotification
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SendNotification;


    public $event;
    public $user;

    public function __construct($event, $user)
    {
        $this->event = $event;
        $this->user = $user;
    }

    public function handle()
    {
        $this->sendNotification('Event_Invitation', $this->user, [
            'name' => $this->user->name,
            'event_title' => $this->event->title,
            'event_host' => $this->event->host,
            'event_url' => $this->event->url,
            'start_date' => showDate($this->event->from_date),
            'end_date' => showDate($this->event->to_date),
            'start_time' => $this->event->start_time,
            'end_time' => $this->event->end_time,
            'description' => $this->event->event_des,
            'event_location' => $this->event->event_location,
        ]);
    }
}
