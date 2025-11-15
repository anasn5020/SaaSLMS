<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;

class HomePageCourseSection extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        $query = Course::orderBy('total_enrolled', 'desc')
            ->where('status', 1)
            ->where('type', 1)
            ->where('scope', 1)
            ->take(4)->with('lessons', 'activeReviews', 'enrollUsers', 'cartUsers');
        $top_courses = $query->get();
        return view(theme('components.home-page-course-section'), compact('top_courses'));
    }
}
