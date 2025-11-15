<?php

namespace App\View\Components;

use App\BillingDetails;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;

class SaasPaymentPageSection extends Component
{
    public $cart, $bill, $plan;

    public function __construct($cart, $bill, $plan)
    {
        $this->cart = $cart;
        $this->bill = $bill;
        $this->plan = $plan;
    }

    public function render()
    {
        $profile = Auth::user();
        $bills = BillingDetails::on(config('database.default'))->with('country')->where('user_id', Auth::id())->get();

        $countries = DB::connection(config('database.default'))->table('countries')->select('id', 'name')->get();

        $states = DB::connection(config('database.default'))->table('states')->where('country_id', $profile->country)->where('id', $profile->state)->select('id', 'name')->get();
        $cities = DB::connection(config('database.default'))->table('spn_cities')->where('state_id', $profile->state)->where('id', $profile->city)->select('id', 'name')->get();
        $this->cart->billing_detail_id = $this->bill->id;
        $this->cart->save();

        $methods = PaymentMethod::on(config('database.default'))->where('active_status', 1)->where('module_status', 1)->where('method', '!=', 'Bank Payment')->where('method', '!=', 'Offline Payment')->where('method', '!=', 'Wallet')->get(['method', 'logo']);

        return view(theme('components.saas-payment-page-section'), compact('methods', 'bills', 'profile', 'countries', 'cities', 'states'));

    }
}
