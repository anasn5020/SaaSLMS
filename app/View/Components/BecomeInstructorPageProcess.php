<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\FrontendManage\Entities\WorkProcess;

class BecomeInstructorPageProcess extends Component
{
    public $work;

    public function __construct($becomeInstructor)
    {
        $this->work = $becomeInstructor->where('id', '6')->first();

    }

    public function render()
    {
        $processes = WorkProcess::where('status', '1')->get();
        return view(theme('components.become-instructor-page-process'), compact('processes'));
    }
}
