<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportSampleCommonCoupon    implements FromView
{
    public function view(): View
    {
        return view('coupons::common_coupons_sample');
    }
}
