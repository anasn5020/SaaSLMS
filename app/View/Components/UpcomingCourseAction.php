<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\UpcomingCourse\Entities\UpcomingCourseBooking;
use Modules\UpcomingCourse\Entities\UpcomingCourseFollower;

class UpcomingCourseAction extends Component
{
    public $course;

    public function __construct($course)
    {
        $this->course = $course;
    }


    public function render()
    {
        $is_following = false;
        $is_booked = false;
        if (auth()->check()) {
            $following = UpcomingCourseFollower::where('course_id', $this->course->id)->where('user_id', auth()->user()->id)->first();
            if ($following) {
                $is_following = true;
            }
            $booking = UpcomingCourseBooking::where('course_id', $this->course->id)->where('user_id', auth()->user()->id)->first();
            if ($booking) {
                $is_booked = true;
            }
        }
        return view(theme('components.upcoming-course-action'), compact('is_following', 'is_booked'));
    }
}
