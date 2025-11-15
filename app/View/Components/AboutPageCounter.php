<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AboutPageCounter extends Component
{
    public $about;

    public function __construct($about)
    {
        $this->about = $about;
    }

    public function render()
    {
        return view(theme('components.about-page-counter'));
    }
}
