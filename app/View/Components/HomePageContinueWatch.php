<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\CourseEnrolled;

class HomePageContinueWatch extends Component
{
    public function render()
    {
        $courses = CourseEnrolled::where('user_id', Auth::user()->id)
            ->whereHas('course', function ($query) {
                $query->whereIn('type',  [1, 2, 3]);
                $query->where('status', '=', 1);
            })->get();
        return view(theme('components.home-page-continue-watch'), compact('courses'));
    }
}
