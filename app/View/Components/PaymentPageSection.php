<?php

namespace App\View\Components;

use App\BillingDetails;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Modules\Payment\Entities\Cart;
use Modules\Payment\Entities\Checkout;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;

class PaymentPageSection extends Component
{
    protected $invoice;

    public function __construct($invoice = null)
    {
        $this->invoice = $invoice;
    }

    public function render()
    {
        session()->forget('order_type');
        session()->forget('invoice');

        $certificate = null;
        if (Route::currentRouteName() === "prc.order.now") {
            $certificate = session()->get('certificate_order');
        } else {
            session()->forget('certificate_order');
        }
          $invoice = $this->invoice;
        $data['methods'] = PaymentMethod::where('active_status', 1)
            ->where('module_status', 1)
            ->where('method', '!=', 'Offline Payment')
            ->get(['method', 'logo']);

        $data['profile'] = $invoice ? $invoice->user : Auth::user();

        $data['countries'] = DB::table('countries')->select('id', 'name')->get();
        $data['states'] = DB::table('states')
            ->where('country_id', $data['profile']->country)
            ->where('id', $data['profile']->state)
            ->select('id', 'name')->get();
        $data['cities'] = DB::table('spn_cities')
            ->where('state_id', $data['profile']->state)
            ->where('id', $data['profile']->city)
            ->select('id', 'name')->get();

        if ($invoice) {
            $data['type'] = 'invoice';
            $data['carts'] = $invoice->courses;
            $this->storeCheckout($invoice);
            $data['checkout'] = Checkout::with('bill')->where('tracking', $invoice->tracking)
                ->where('user_id', $invoice->user_id)->latest()->first();

            session()->put('order_type', 'invoice');
            session()->put('invoice', $invoice);
        } elseif ($certificate) {
            $data['type'] = 'certificate';
            $data['carts'][] = $certificate;
            $this->storeCheckout(null, false, $certificate);
            $data['checkout'] = Checkout::with('bill')->where('tracking', $certificate->tracking)
                ->where('user_id', $certificate->user_id)->where('type', 'certificate')->latest()->first();
        } else {
            $data['type'] = 'default';
            $data += $this->defaultPayment();
        }
        $data['is_physical'] = 0;
        if (isModuleActive('Store')) {
            $store_product = $data['checkout']->carts;
            foreach ($store_product as $item) {
                if ($item->course?->type == 5) {
                    $data['is_physical'] += $item->course->product?->type == 2 ? 1 : 0;
                }
            }
            if ($data['checkout']->carts->count() == $data['is_physical']) {
                $data['all_physical'] = true;
            } else {
                $data['all_physical'] = false;
            }
        }

        return view(theme('components.payment-page-section'), $data);
    }

    private function defaultPayment()
    {
        $data['bills'] = BillingDetails::with('country')->where('user_id', Auth::id())->get();
        $tracking = Cart::where('user_id', Auth::id())->first()->tracking;
        $total = Cart::where('user_id', Auth::user()->id)->sum('price');
        $data['checkout'] = Checkout::where('tracking', $tracking)->where('user_id', Auth::id())->latest()->first();
        if (empty($data['checkout']->billing_detail_id)) {
            Toastr::error(trans('frontend.Billing Details'), trans('common.Failed'));

            return redirect()->route('CheckOut')->send();
        }
        $data['carts'] = Cart::where('user_id', Auth::id())->with('course', 'course.user')->get();
        return $data;
    }

    private function storeCheckout($invoice = null, $tax = true, $certificate = null)
    {
        $checkout_type = $certificate ? 'certificate' : 'invoice';
        $oldBilling = BillingDetails::where('user_id', auth()->user()->id)->latest()->first();

        $exitBilling = null;
        if ($certificate) {
            $exitBilling = BillingDetails::where('user_id', auth()->user()->id)->where('tracking_id', $certificate->tracking)->latest()->first();
        }
        $oldBilling = $exitBilling ?? $oldBilling;

        $checkout_billing = $certificate ? $oldBilling : $invoice->billing;

        $tracking = $certificate ? $certificate->tracking : $invoice->tracking;
        $checkoutDetail = $certificate ? $certificate : $invoice;

        $bill = BillingDetails::where('tracking_id', $tracking)
            ->where('user_id', $checkoutDetail->user_id)
            ->first();

        if (empty($bill)) {
            $bill = new BillingDetails();
        }
        $bill->user_id = $checkout_billing->user_id;
        $bill->tracking_id = $tracking;
        $bill->first_name = $checkout_billing->first_name;
        $bill->last_name = $checkout_billing->last_name;
        $bill->company_name = $checkout_billing->company_name;
        $bill->country = $checkout_billing->country;
        $bill->address1 = $checkout_billing->address1;
        $bill->address2 = $checkout_billing->address2;
        $bill->city = $checkout_billing->city;
        $bill->state = $checkout_billing->state;

        $bill->zip_code = $checkout_billing->zip_code;
        $bill->phone = $checkout_billing->phone;
        $bill->email = $checkout_billing->email;
        $bill->details = $checkout_billing->details;
        $bill->payment_method = null;
        $bill->save();

        $checkout = Checkout::where('tracking', $tracking)
            ->where('user_id', $checkoutDetail->user_id)->latest()->first();
        if (!$checkout) {
            $checkout = new Checkout();
        }

        $checkout->discount = 0.00;

        $checkout->tracking = $tracking;
        $checkout->user_id = Auth::id();
        $checkout->price = $checkoutDetail->price;
        if (hasTax() && $tax == true) {
            $checkout->purchase_price = applyTax($checkoutDetail->price);
            $checkout->tax = taxAmount($checkoutDetail->price);
        } else {
            $checkout->purchase_price = $checkoutDetail->price;
        }
        $checkout->status = 0;
        $checkout->type = $checkout_type;
        if ($certificate) {
            $checkout->order_certificate_id = $checkoutDetail->id;
        } elseif ($invoice) {
            $checkout->invoice_id = $checkoutDetail->id;
        }

        $checkout->coupon_id = null;
        $checkout->billing_detail_id = $bill->id;
        $checkout->save();
    }
}
