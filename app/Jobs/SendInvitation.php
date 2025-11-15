<?php

namespace App\Jobs;

use App\Traits\SendNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendInvitation
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SendNotification;

    public $course;
    public $user;

    public function __construct($course, $user)
    {
        $this->course = $course;
        $this->user = $user;
    }

    public function handle()
    {
        $this->sendNotification('Course_Invitation', $this->user, [
            'name' => $this->user->name,
            'course_name' => $this->course->getTranslation('title', $this->user->language_code ?? config('app.fallback_locale')),
            'instructor_name' => $this->course->user->name,
            'course_url' => route('courseDetailsView', $this->course->slug),
            'price' => $this->course->price,
            'about' => $this->course->about,
        ]);

    }
}
