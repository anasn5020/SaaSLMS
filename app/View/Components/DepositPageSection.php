<?php

namespace App\View\Components;

use App\DepositRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;

class DepositPageSection extends Component
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }


    public function render()
    {
        $records = DepositRecord::where('user_id', Auth::user()->id)->latest()->paginate(5);
        $methods = PaymentMethod::where('active_status', 1)->where('module_status', 1)->where('method', '!=', 'Wallet')->where('method', '!=', 'Offline Payment')->get(['method', 'logo']);
        $amount = $this->request->deposit_amount;
        return view(theme('components.deposit-page-section'), compact('amount', 'records', 'methods'));
    }
}
