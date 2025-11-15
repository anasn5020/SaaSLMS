<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BecomeInstructorPageJoin extends Component
{
    public $icon_left, $icon_mid, $icon_right;

    public function __construct($becomeInstructor)
    {
        $this->icon_left = $becomeInstructor->where('id', '1')->first();
        $this->icon_mid = $becomeInstructor->where('id', '2')->first();
        $this->icon_right = $becomeInstructor->where('id', '3')->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view(theme('components.become-instructor-page-join'));
    }
}
