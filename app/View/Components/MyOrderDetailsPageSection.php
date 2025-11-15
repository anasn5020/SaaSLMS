<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Payment\Entities\Checkout;
use Modules\Store\Entities\CancelReason;
use Modules\Store\Entities\DeliveryProcess;
use Modules\Store\Entities\OrderPackageDetail;

class MyOrderDetailsPageSection extends Component
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
        $data['order_status'] = [];
        $data['order'] = Checkout::find($this->id);
        $data['packages'] = OrderPackageDetail::with('product_details.getCourse', 'products.course')->where('order_id', $this->id)->groupby('seller_id')->distinct()->get();
        $data['processes'] = DeliveryProcess::all();
        $data['cancel_reasons'] = CancelReason::all();
        return view(theme('components.my-order-details-page-section'), compact('enroll'))->with($data);
    }
}
