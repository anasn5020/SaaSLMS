<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InstructorsPageBecomeInstructorSection extends Component
{

    public function render()
    {
        $data['homeContent'] = app('getHomeContent');
        return view(theme('components.instructors-page-become-instructor-section'), $data);
    }
}
