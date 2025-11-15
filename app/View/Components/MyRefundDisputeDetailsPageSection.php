<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Payment\Entities\Checkout;
use Modules\Store\Entities\CancelReason;
use Modules\Store\Entities\RefundProcess;
use Modules\Store\Entities\RefundRequest;

class MyRefundDisputeDetailsPageSection extends Component
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $order = RefundRequest::findOrFail($this->id);
        $enroll = Checkout::where('id', $order->order_id)
            ->where('user_id', Auth::user()->id)
            ->with('courses', 'user', 'courses.course.enrollUsers', 'bill')->first();
        if (!$enroll) {
            abort(404);
        }
        $data['cancel_reasons'] = CancelReason::all();
        $data['refund_request'] = RefundRequest::with('refund_details', 'refund_details.refund_products', 'order')->findOrFail($this->id);
        $data['processes'] = RefundProcess::all();

        return view(theme('components.my-refund-dispute-details-page-section'), compact('enroll'))->with($data);
    }
}
