<?php

namespace Modules\PayStack\Http\Controllers;

use App\Http\Controllers\DepositController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionPaymentController;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;

class PayStackController extends Controller
{
    public function index()
    {
        return view('paystack::index');
    }

    public function create()
    {
        return view('paystack::create');
    }

    public function redirectToGateway(Request $request)
    {

        try {
            return Paystack::getAuthorizationUrl()->redirectNow();

        } catch (\Exception $e) {

            return Redirect::back()->withMessage(['msg' => 'The paystack token has expired. Please refresh the page and try again.', 'type' => 'error']);
        }
    }

    /**
     * Obtain Paystack payment information
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGatewayCallback()
    {


        try {

            $paymentDetails = Paystack::getPaymentData();
            $payWithPayStack = false;
            if ($paymentDetails['status']) {
                $response = $paymentDetails['data'];

                if ($response['metadata']['type'] == "Test") {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    return redirect()->route('paymentmethodsetting.test');
                } elseif ($response['metadata']['type'] == "Payment") {
                    $payment = new PaymentController();
                    $payWithPayStack = $payment->payWithGateWay($response, "PayStack");
                } elseif ($response['metadata']['type'] == "Deposit") {
                    $payment = new DepositController();
                    $amount = round(convertCurrency($response['currency'], strtoupper(Settings('currency_code') ?? 'BDT'), $response['amount'] / 100));

                    $payWithPayStack = $payment->depositWithGateWay($amount, $response, "PayStack");
                } elseif ($response['metadata']['type'] == "Subscription") {
                    $payment = new SubscriptionPaymentController();
                    $amount = round(convertCurrency($response['currency'], strtoupper(Settings('currency_code') ?? 'BDT'), $response['amount'] / 100));

                    $payWithPayStack = $payment->payWithGateWay($response, "PayStack");
                }

                if ($payWithPayStack) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (currentTheme() == 'tvt') {
                        return redirect('/');
                    } else {
                        return redirect(route('studentDashboard'));
                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return Redirect::back();
                }

            } else {

                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }
}
