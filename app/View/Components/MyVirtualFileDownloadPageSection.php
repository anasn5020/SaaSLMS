<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Payment\Entities\Checkout;
use Modules\Store\Entities\OrderPackageDetail;

class MyVirtualFileDownloadPageSection extends Component
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $enroll = Checkout::where('id', $this->id)->first();
        if (!$enroll) {
            abort(404);
        }
        $data['packages'] = OrderPackageDetail::with('course')->where('order_id', $this->id)->get();
        return view(theme('components.my-virtual-file-download-page-section'), compact('enroll'))->with($data);
    }
}
