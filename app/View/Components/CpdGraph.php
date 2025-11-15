<?php

namespace App\View\Components;

use App\User;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;
use Modules\CPD\Entities\AssignStudent;

class CpdGraph extends Component
{

    public function render()
    {
        $students = User::where('role_id', 3)->get(['name', 'id']);
        $course_ids = AssignStudent::where('student_id', auth()->user()->id)->pluck('course_id')->toArray();
        $courses = Course::whereIn('id', $course_ids)->get();
        return view(theme('components.cpd-graph'), compact('courses', 'students'));
    }
}
