<?php

namespace App\View\Components;


use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class InstructorPageSection extends Component
{
    public $id, $instructor;

    public function __construct($id, $instructor)
    {
        $this->instructor = $instructor;
        $this->id = $id;
    }


    public function render()
    {
        $students = DB::table('course_enrolleds')
            ->join('courses', 'course_enrolleds.course_id', '=', 'courses.id')
            ->where('courses.user_id', $this->id)
            ->distinct('course_enrolleds.user_id')->count();
        return view(theme('components.instructor-page-section'), compact('students'));
    }
}
