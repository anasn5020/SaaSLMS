<?php

namespace App\View\Components;

use App\BillingDetails;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Modules\PaymentMethodSetting\Entities\PaymentMethod;

use Modules\LmsSaas\Entities\SaasCart;
use Modules\LmsSaasMD\Entities\SaasCart as SaasCartMD;

class SaasCheckoutPageSection extends Component
{
    public $request, $s_plan, $price;

    public function __construct($request, $plan, $price)
    {
        $this->request = $request;
        $this->s_plan = $plan;
        $this->price = $price;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        $type = $this->request->type;
        if (!empty($type)) {
            $current = BillingDetails::on(config('database.default'))->where('user_id', Auth::id())->latest()->first();
        } else {
            $current = '';
        }
        $profile = Auth::user();
        $bills = BillingDetails::on(config('database.default'))->with('country')->where('user_id', Auth::id())->latest()->get();
        $countries = DB::connection(config('database.default'))->table('countries')->select('id', 'name')->get();
        $states = DB::connection(config('database.default'))->table('states')->where('country_id', $profile->country)->where('id', $profile->state)->select('id', 'name')->get();
        $cities = DB::connection(config('database.default'))->table('spn_cities')->where('state_id', $profile->state)->where('id', $profile->city)->select('id', 'name')->get();
        if (isModuleActive('LmsSaas')) {
            $cart = SaasCart::where('user_id', Auth::id())->first();
        } else {
            $cart = SaasCartMD::where('user_id', Auth::id())->first();
        }
        $methods = PaymentMethod::on(config('database.default'))->where('active_status', 1)->where('module_status', 1)->where('method', '!=', 'Bank Payment')->where('method', '!=', 'Offline Payment')->get(['method', 'logo']);

        return view(theme('components.saas-checkout-page-section'), compact('cart', 'profile', 'current', 'bills', 'countries', 'cities', 'methods', 'states'));

    }
}
