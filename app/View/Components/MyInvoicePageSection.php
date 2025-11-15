<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Payment\Entities\Checkout;

class MyInvoicePageSection extends Component
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $enroll = Checkout::where('id', $this->id)
            ->where('user_id', Auth::user()->id)
            ->with('courses', 'user', 'courses.course.enrollUsers', 'bill')->first();
        if (!$enroll) {
            abort(404);
        }

        return view(theme('components.my-invoice-page-section'), compact('enroll'));
    }
}
