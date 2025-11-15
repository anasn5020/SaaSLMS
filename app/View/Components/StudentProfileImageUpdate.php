<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StudentProfileImageUpdate extends Component
{
    public $profile;

    public function __construct($profile)
    {
        $this->profile = $profile;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view(theme('components.student-profile-image-update'));
    }
}
