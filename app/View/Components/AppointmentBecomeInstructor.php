<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Appointment\Entities\AppointmentFrontendPage;

class AppointmentBecomeInstructor extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data['hasDescription'] = AppointmentFrontendPage::where('status', 1)
        ->where('type', 'become_instructor_page')->whereNotNull('description')->pluck('name')->toArray();

        return view(theme('components.appointment-become-instructor'), $data);
    }
}
