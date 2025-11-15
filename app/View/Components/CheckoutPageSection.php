<?php

namespace App\View\Components;

use App\BillingDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\Component;
use Modules\Payment\Entities\Cart;
use Modules\Payment\Entities\Checkout;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;
use Modules\Store\Entities\ProductSku;
use Modules\Store\Entities\ShippingMethod;

class CheckoutPageSection extends Component
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function render()
    {
        $type = $this->request->type;
        $shipping_method = $this->request->shipping_method;

        if (!empty($type)) {
            $current = BillingDetails::where('user_id', Auth::id())->latest()->first();
        } else {
            $current = '';
        }

        $profile = Auth::user();
        $profile->cityName = $profile->cityName();
        $bills = BillingDetails::with('country')->where('user_id', Auth::id())->latest()->get();

        $countries = DB::table('countries')->select('id', 'name')->get();
        $states = DB::table('states')->where('country_id', (int)$profile->country)->where('id', (int)$profile->state)->select('id', 'name')->get();

        $cities = DB::table('spn_cities')->where('state_id', (int)$profile->c)->where('id', (int)$profile->city)->select('id', 'name')->get();


        $cart = Cart::where('user_id', Auth::id())->latest()->first();
        if ($cart) {
            $tracking = $cart->tracking;
        } else {
            $tracking = '';
        }

        $this->resetCartPrice();

        $is_store = 0;
        $is_physical = 0;
        if (isModuleActive('Store')) {
            $price = Cart::where('user_id', Auth::user()->id)->get();
            $total = 0;
            $total_qty = 0;
            foreach ($price as $item) {
                $is_physical += isset($item->course->product->type) ? $item->course->product->type == 2 ? 1 : 0 : 0;
                if ($item->qty == 0) {
                    $total += $item->price;
                } else {
                    $total += $item->price * $item->qty;
                }
                $is_store += $item->is_store;
                $total_qty += $item->qty;
            }
        } else {
            $total = Cart::where('user_id', Auth::user()->id)->sum('price');
        }


        $shipping_methods = [];
        $shipping_charge = '';
        $shipping_cost = 0;
        if (isModuleActive('Store') && $is_physical > 0) {
            $shipping_methods = ShippingMethod::where('is_active', 1)->where('minimum_shopping', '<=', $total)->get();
            if ($shipping_method) {
                $ship_cost = $shipping_methods->where('id', $shipping_method)->first();
                $shipping_cost = $ship_cost->cost;
                $shipping_charge = $ship_cost;
            } else {
                $shipping_cost = $shipping_methods[0]->cost??0;
                $shipping_charge = $shipping_methods[0]??'';
            }
        }

        $checkout = Checkout::where('tracking', $tracking)->where('user_id', Auth::id())->latest()->first();
        if (!$checkout) {
            $checkout = new Checkout();
        }

        $checkout->discount = 0.00;

        $checkout->tracking = $tracking;
        $checkout->user_id = Auth::id();
        $checkout->price = $total;
        if (hasTax()) {
            $checkout->purchase_price = applyTax($total) + @$shipping_charge->cost;
            $checkout->tax = taxAmount($total);
        } else {
            $checkout->purchase_price = $total + @$shipping_charge->cost;
        }
        if (isModuleActive('UpcomingCourse') && $profile->role_id == 3) {
            $pre_booking_amount = Cart::where('user_id', Auth::user()->id)->sum('pre_booking_amount');
            $checkout->pre_booking_amount = $pre_booking_amount;
            $checkout->purchase_price -= $pre_booking_amount;
        }
        if (isModuleActive('Store')) {
            $checkout->is_paid = $is_store ? 1 : 0;
            $checkout->is_store = $is_store ? 1 : 0;
            $checkout->shipping_id = $shipping_charge ? $shipping_charge->id : 0;
            $checkout->order_number = rand(11, 99) . date('ymdhis');
            $checkout->shipping_cost = $shipping_cost > 0 ? $shipping_charge->cost : 0;
        }

        $checkout->status = 0;
        $checkout->coupon_id = null;

        if (isModuleActive('UserGroup') && $profile->userGroup && $profile->userGroup->group->status && $profile->userGroup->group->discount) {
            $group_discount = Cart::where('user_id', $profile->id)->sum('group_discount');
            $checkout->group_discount = $group_discount;
            $checkout->purchase_price -= $group_discount;
        }
        if (Schema::hasColumn('checkouts', 'lms_id')) {
        $checkout->lms_id = (int)Auth::user()->lms_id;
        }

        $checkout->save();
        $methods = PaymentMethod::where('active_status', 1)->get(['method', 'logo']);

        $carts = Cart::where('user_id', Auth::id())->with('course', 'course.user')->get();

        return view(theme('components.checkout-page-section'), compact('checkout', 'carts', 'methods', 'current', 'bills', 'countries', 'cities', 'profile', 'states', 'shipping_methods', 'is_physical', 'shipping_charge'));
    }

    function resetCartPrice()
    {
        $carts = Cart::where('user_id', Auth::id())->get();
        foreach ($carts as $key => $cart) {
            if ($cart->course_id != 0) {
                if ($cart->course?->discount_price != null) {
                    $price = $cart->course?->discount_price;
                } else {
                    $price = $cart->course?->price;
                }


            } else {
                $price = $cart->bundle?->price;
            }
            $cart->price = (int)$price;
            if (isModuleActive('EarlyBird') && $cart->is_earlybird_offer == 1) {
                $cart->price = verifyEarlybirdOffer($cart->course, auth()->user()->id, $cart)['price'];
            } elseif (isModuleActive('Installment') && $cart->is_installment == 1) {
                $cart->price = installmentProductPrice($cart->course_id, $cart->plan_id, $price);
            }
            elseif (isModuleActive('Store') && $cart->is_store && $cart->product_sku_id) {
                $sku =ProductSku::find($cart->product_sku_id);
                $cart->price =$sku->price??0;
            }else{
                $cart->price = $price;
            }

            if (hasCouponApply($cart->course_id)) {
                $cart->price =  getCouponPrice($cart->course_id);
            }
            $cart->save();
         }
    }
}
