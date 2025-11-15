<?php

namespace App\Jobs;

use App\Traits\SendNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpireSoonNotificaiton implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SendNotification;

    public $enrolls;

    public function __construct($enrolls)
    {
        $this->enrolls = $enrolls;
    }

    public function handle(): void
    {
        $enrolls = $this->enrolls;

        foreach ($enrolls as $enroll) {
            $user = $enroll->user;
            $course = $enroll->course;


            $this->sendNotification('CourseExpireSoon', $user, [
                'course' => $course->getTranslation('title', $user->language_code ?? config('app.fallback_locale')),
                'name' => $user->name,
                'date' => showDate($enroll->created_at),
                'link' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),

            ]);

            $enroll->send_expire_notification = 1;
            $enroll->save();
        }
    }
}
