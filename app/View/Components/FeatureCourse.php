<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;

class FeatureCourse extends Component
{

    public function render()
    {
        $query = Course::with('user', 'category', 'subCategory', 'enrolls', 'comments', 'reviews', 'lessons', 'activeReviews', 'enrollUsers', 'cartUsers','courseLevel');
        $query->where('feature', 1);
        $course = $query->first();
        return view(theme('components.feature-course'), compact('course'));
    }
}
