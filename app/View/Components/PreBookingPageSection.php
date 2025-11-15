<?php

namespace App\View\Components;


use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;

class PreBookingPageSection extends Component
{

    public $course_id;

    public function __construct($id)
    {
        $this->course_id = $id;
    }


    public function render()
    {
        $course = Course::find($this->course_id);
        $methods = PaymentMethod::where('active_status', 1)->where('module_status', 1)->where('method', '!=', 'Bank Payment')->where('method', '!=', 'Offline Payment')->get(['method', 'logo']);
        $amount = $course->booking_amount ?? 0;
        return view(theme('components.pre-booking-page-section'), compact('amount', 'course', 'methods'));
    }
}
