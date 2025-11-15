<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BecomeInstructorPageJoinBottom extends Component
{
    public $cta_part;

    public function __construct($becomeInstructor)
    {
        $this->cta_part = $becomeInstructor->where('id', '5')->first();
    }


    public function render()
    {
        return view(theme('components.become-instructor-page-join-bottom'));
    }
}
