<?php

namespace App\View\Components;

use App\BillingDetails;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\Cart;
use Illuminate\Support\Facades\Auth;
use Modules\Appointment\Entities\AppointmentSettings;
use Modules\Payment\Entities\Checkout;
use Modules\Appointment\Entities\Schedule;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;

class AppointmentCheckoutPageSection extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $type = '';
        $total=0;
        $current = BillingDetails::where('user_id', auth()->id())
            ->latest()->first();


        $profile = Auth::user();
        $profile->cityName = $profile->cityName();


        $bills = BillingDetails::with('country')->where('user_id', auth()->user()->id)
//        ->where('type', 'appointment')
            ->latest()->get();

        $countries = DB::table('countries')->select('id', 'name')->get();
        $states = DB::table('states')->where('country_id', $profile->country)
            ->where('id', $profile->state)->select('id', 'name')->get();
        $cities = DB::table('spn_cities')->where('state_id', $profile->state)
            ->where('id', $profile->city)->select('id', 'name')->get();


        $cart = Cart::where('user_id', auth()->user()->id)
            ->where('type', 'appointment')->whereNotNull('schedule_id')->first();

        $schedule = Schedule::with('userInfo', 'slotInfo')
            ->where('id', $cart->schedule_id)->first();

        $instructor = $schedule->userInfo;
        $slotInfo = $schedule->slotInfo;

        if ($cart) {
            $tracking = $cart->tracking;
        } else {
            $tracking = '';
        }

        if ($profile->role_id == 3) {
            $total = Cart::where('user_id', Auth::user()->id)->where('type', 'appointment')
                ->whereNotNull('schedule_id')->sum('price');
        }
        $checkout = Checkout::where('tracking', $tracking)->where('user_id', auth()->user()->id)
            ->where('type', 'appointment')->latest()->first();
        if (!$checkout) {
            $checkout = new Checkout();
        }

        $checkout->discount = 0.00;

        $checkout->tracking = $tracking;
        $checkout->user_id = auth()->user()->id;
        $checkout->price = $total;
        if (hasTax()) {
            $checkout->purchase_price = applyTax($total);
            $checkout->tax = taxAmount($total);
        } else {
            $checkout->purchase_price = $total;
        }
        $checkout->status = 0;
        $checkout->coupon_id = null;
        $checkout->type = 'appointment';
        $checkout->save();
        $methods = PaymentMethod::where('active_status', 1)->get(['method', 'logo']);


        $carts = Cart::where('user_id', auth()->user()->id)->with('course', 'course.user')->get();
        $settings = AppointmentSettings::first();
        return view(theme('components.appointment-checkout-page-section'), compact('checkout', 'carts', 'methods', 'current', 'bills', 'countries', 'cities', 'profile', 'states', 'schedule', 'instructor', 'slotInfo', 'settings'));
    }
}
