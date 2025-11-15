<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseLevel;

class HomePageCourseLevel extends Component
{
    public function render()
    {
        $levels = CourseLevel::where('status', 1)->get();
        $courses = Course::select('id', 'title', 'level', 'thumbnail', 'image','type','slug')->where('status', 1)->get();
        return view(theme('components.home-page-course-level'), compact('levels', 'courses'));
    }
}
