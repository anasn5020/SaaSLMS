<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BecomeInstructorPageJoinTop extends Component
{
    public $joining_part;

    public function __construct($becomeInstructor)
    {
        $this->joining_part = $becomeInstructor->where('id', '4')->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view(theme('components.become-instructor-page-join-top'));
    }
}
