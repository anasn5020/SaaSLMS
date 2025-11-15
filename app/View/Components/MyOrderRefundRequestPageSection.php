<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Store\Entities\CancelReason;
use Modules\Store\Entities\DeliveryProcess;
use Modules\Store\Entities\OrderPackageDetail;
use Modules\Store\Entities\RefundReason;

class MyOrderRefundRequestPageSection extends Component
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $id = decrypt($this->id);
        $package = OrderPackageDetail::with('order','product_details.getCourse', 'products.course')->find($id);
        $order =$package->order;

        if (!$order || $order->user_id != Auth::id()) {
            abort(404);
        }
        $data['order_status'] = [];
        $data['order'] =$order;
        $data['package'] =$package;
        $data['processes'] = DeliveryProcess::all();
        $data['reasons'] = RefundReason::all();
        $data['cancel_reasons'] = CancelReason::all();
        return view(theme('components.my-order-refund-request-page-section'))->with($data);
    }
}
