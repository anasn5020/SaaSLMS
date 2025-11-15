<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InstructorsPageSection extends Component
{

    public function render()
    {
        return view(theme('components.instructors-page-section'));
    }
}
