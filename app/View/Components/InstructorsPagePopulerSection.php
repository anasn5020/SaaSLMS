<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InstructorsPagePopulerSection extends Component
{
    public $instructors;

    public function __construct($instructors)
    {
        $this->instructors = $instructors;
    }

    public function render()
    {
        return view(theme('components.instructors-page-populer-section'));
    }
}
