<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\CourseSetting\Entities\Course;

class OneToOneConnection
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $course;
    public $student;
    public $instructor;

    public function __construct($instructor, $student, $course)
    {
        $this->instructor = $instructor;
        $this->student = $student;
        $this->course = $course;
    }
}
