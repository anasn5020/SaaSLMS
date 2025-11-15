<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Appointment\Entities\AppointmentFrontendPage;

class AppointmentBreadcrumb extends Component
{
    public $request;


    public function __construct($request)
    {
        $this->request = $request;
    }

    public function render()
    {
        $data['breadcrumb'] = AppointmentFrontendPage::where('name', 'instructor-breadcrumb')->where('status', 1)
        ->first();
        return view(theme('components.appointment-breadcrumb'), $data);
    }
}
