<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Category;
use Modules\FrontendManage\Entities\Sponsor;
use Modules\Appointment\Entities\AppointmentFrontendPage;

class Appointment extends Component
{
    public $pages;
    public $categories;
    public function __construct($pages, $categories)
    {
        $this->pages = $pages;
        $this->categories = $categories;
    }

    public function render()
    {
        $data['categories'] = Category::get();
        $data['partner'] = AppointmentFrontendPage::where('status', 1)
        ->where('name', 'partner')
        ->where('type', 'appointment_page')
        ->first();

        $data['hasDescription'] = AppointmentFrontendPage::where('status', 1)
        ->where('type', 'appointment_page')->whereNotNull('description')->pluck('name')->toArray();

        $data['sponsors'] = Sponsor::where('status', 1)->get();

        return view(theme('components.appointment'), $data);
    }
}
