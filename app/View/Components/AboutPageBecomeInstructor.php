<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AboutPageBecomeInstructor extends Component
{
    public $frontendContent;

    public function __construct($frontendContent)
    {
        $this->frontendContent = $frontendContent;
    }

    public function render()
    {
        return view(theme('components.about-page-become-instructor'));
    }
}
