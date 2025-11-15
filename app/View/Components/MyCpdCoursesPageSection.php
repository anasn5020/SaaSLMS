<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CPD\Entities\AssignStudent;
use Modules\CPD\Entities\Cpd;

class MyCpdCoursesPageSection extends Component
{
    protected $request;
    protected $cpd_id;

    public function __construct($request, $cpdId)
    {
        $this->request = $request;
        $this->cpd_id = $cpdId;
    }

  
    public function render()
    {
        $per_page = 15;
        $cpd_id = $this->cpd_id;
        $with = ['course', 'quiz'];
        $cpd_title = Cpd::where('id', $cpd_id)->first()->title;
        $courses = AssignStudent::where('student_id', auth()->user()->id)->where('cpd_id', $cpd_id)
            ->latest()
            ->with($with)->paginate($per_page);

        return view(theme('components.my-cpd-courses-page-section'), compact('courses', 'cpd_title'));
    }
}
