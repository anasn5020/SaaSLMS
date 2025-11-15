<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\CourseEnrolled;

class SubscriptionMyCoursePageSection extends Component
{

    public function render()
    {
        $courses = CourseEnrolled::where('user_id', Auth::user()->id)
            ->whereHas('course', function ($query) {
                $query->whereIn('type', [1, 2, 3]);
            })->latest()
            ->with('course', 'course.lessons', 'course.activeReviews','course.quiz','course.quiz.assign')->paginate(9);
        return view(theme('components.subscription-my-course-page-section'), compact('courses'));
    }
}
