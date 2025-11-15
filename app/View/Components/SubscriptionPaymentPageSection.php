<?php

namespace App\View\Components;

use App\BillingDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;
use Modules\Subscription\Entities\SubscriptionCheckout;

class SubscriptionPaymentPageSection extends Component
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
        $bills = BillingDetails::with('country')->where('user_id', Auth::id())->get();

        $countries = DB::table('countries')->select('id', 'name')->get();
        $states = DB::table('states')->where('country_id', $profile->country)->where('id', $profile->state)->select('id', 'name')->get();
        $cities = DB::table('spn_cities')->where('state_id', $profile->state)->where('id', $profile->city)->select('id', 'name')->get();
        $this->cart->billing_detail_id = $this->bill->id;
        $this->cart->save();
        $methods = PaymentMethod::where('active_status', 1)->where('module_status', 1)->where('method', '!=', 'Bank Payment')->where('method', '!=', 'Offline Payment')->get(['method', 'logo']);
        $checkout = SubscriptionCheckout::where('tracking', $this->cart->tracking)->where('user_id', Auth::id())->latest()->first();
        return view(theme('components.subscription-payment-page-section'), compact('checkout', 'methods', 'bills', 'profile', 'countries', 'cities', 'states'));
    }
}
