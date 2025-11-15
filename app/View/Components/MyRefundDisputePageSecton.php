<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Payment\Entities\Checkout;
use Modules\Store\Entities\RefundRequest;
use Modules\Subscription\Entities\SubscriptionCheckout;

class MyRefundDisputePageSecton extends Component
{

    public function render()
    {
        $enrolls = RefundRequest::with('refund_details', 'refund_details.refund_products', 'order')->where('customer_id', auth()->user()->id)->latest()->paginate(10);
        return view(theme('components.my-refund-dispute-page-secton'), compact('enrolls'));
    }
}
