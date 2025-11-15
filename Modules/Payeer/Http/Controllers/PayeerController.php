<?php

namespace Modules\Payeer\Http\Controllers;

use App\Http\Controllers\DepositController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionPaymentController;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Payeer\Entities\PayeerOrder;
use Modules\UpcomingCourse\Http\Controllers\PrebookingController;

class PayeerController extends Controller
{
    public function redirectToDashboard()
    {
        if (\auth()->user()->role_id == 3) {
            return redirect(route('studentDashboard'));
        } else {
            return redirect(route('dashboard'));
        }

    }

    public function makePayment($request)
    {
        $responce = '';
        $order_id = uniqid();

        if ($request->type == "Test") {
            $m_desc = base64_encode('Test');
            $payAmount = $request->test_amount;
        } elseif ($request->type == "Deposit") {
            $m_desc = base64_encode('Deposit');
            $payAmount = $request->deposit_amount;
//            $amount = convertCurrency(Settings('currency_code') ?? 'USD', 'USD', $request->deposit_amount);
        } elseif ($request->type == "prebooking") {
            $m_desc = base64_encode('prebooking');
            $payAmount = $request->deposit_amount;
//            $amount = convertCurrency(Settings('currency_code') ?? 'USD', 'USD', $request->deposit_amount);
        } elseif ($request->type == "Subscription") {
            $m_desc = base64_encode('Subscription');
            $payAmount = $request->amount;
//            $amount = convertCurrency(Settings('currency_code') ?? 'USD', 'USD', $request->deposit_amount);
        } else {
            $m_desc = base64_encode('Payment');
            $payAmount = $request->amount;
//            $amount = convertCurrency(Settings('currency_code') ?? 'USD', 'USD', $request->amount);
        }

        $m_shop = getPaymentEnv('PAYEER_MERCHANT') ?? '';
        $m_orderid = $order_id;
        $m_amount = number_format($payAmount, 2, '.', '');
        $m_curr = Settings('currency_code');

        $m_key = getPaymentEnv('PAYEER_KEY') ?? '';


        $arHash = array(
            $m_shop,
            $m_orderid,
            $m_amount,
            $m_curr,
            $m_desc,
            $m_key
        );
        $sign = strtoupper(hash('sha256', implode(":", $arHash)));


        $arGetParams = array(
            'm_shop' => $m_shop,
            'm_orderid' => $m_orderid,
            'm_amount' => $m_amount,
            'm_curr' => $m_curr,
            'm_desc' => $m_desc,
            'm_sign' => $sign,

        );

        $order = new PayeerOrder();
        $order->type = $request->type;
        $order->order_id = $order_id;
        $order->user_id = Auth::user()->id;
        $order->amount = $payAmount;
        $order->save();
        return 'https://payeer.com/merchant/?' . http_build_query($arGetParams);
    }


    public function paymentSuccess(Request $request)
    {


        $order = PayeerOrder::where('user_id', Auth::user()->id)->latest()->first();

        if ($order) {

            if ($order->type == "Test") {
                $payWithMidtrans = true;

            } elseif ($order->type == "Deposit") {
                $deposit = new DepositController();
                $payWithMidtrans = $deposit->depositWithGateWay($order->amount, $request, "Payeer");

            } elseif ($order->type == "prebooking") {
                $deposit = new PrebookingController();
                $payWithMidtrans = $deposit->bookingWithGateWay($order->amount, $request, "Payeer");

            } elseif ($order->type == "Subscription") {

                $deposit = new SubscriptionPaymentController();
                $payWithMidtrans = $deposit->payWithGateWay($request, "Payeer");

            } else {
                $payment = new PaymentController();
                $payWithMidtrans = $payment->payWithGateWay($request, "Payeer");
            }

            $order->delete();

            if ($payWithMidtrans) {
                Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                return $this->redirectToDashboard();
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                return $this->redirectToDashboard();
            }

        } else {
            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
            return $this->redirectToDashboard();
        }


    }


    public function paymentFailed()
    {
        $order = PayeerOrder::where('user_id', Auth::user()->id)->latest()->first();
        if ($order) {
            $order->delete();
        }
        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
        return redirect()->back();
    }
}
