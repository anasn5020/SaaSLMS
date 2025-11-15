<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;

class HomePagePopulerCourse extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        $courses = Course::where('status', 1)->orderBy('total_enrolled', 'desc')->take(5)->get();
        return view(theme('components.home-page-populer-course'), compact('courses'));
    }
}
