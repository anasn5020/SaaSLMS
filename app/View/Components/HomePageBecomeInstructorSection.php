<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HomePageBecomeInstructorSection extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        return view(theme('components.home-page-become-instructor-section'));
    }
}
