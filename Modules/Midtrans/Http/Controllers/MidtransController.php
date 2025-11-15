<?php

namespace Modules\Midtrans\Http\Controllers;

use App\Http\Controllers\DepositController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionPaymentController;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Midtrans\Entities\MidtransOrder;
use Modules\Payeer\Entities\PayeerOrder;
use Modules\UpcomingCourse\Http\Controllers\PrebookingController;

class MidtransController extends Controller
{


    public function __construct()
    {
        \Midtrans\Config::$serverKey = getPaymentEnv('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = getPaymentEnv('MIDTRANS_ENV');
        \Midtrans\Config::$isSanitized = getPaymentEnv('MIDTRANS_SANITIZE');
        \Midtrans\Config::$is3ds = getPaymentEnv('MIDTRANS_3DS');
    }

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

        $order_id = uniqid();
        if ($request->type == "Test") {
            $payAmount = $amount = $request->test_amount;
        } elseif ($request->type == "Deposit") {
            $payAmount = $request->deposit_amount;
            $amount = $request->deposit_amount;
        } elseif ($request->type == "prebooking") {
            $payAmount = $request->deposit_amount;
            $amount = $request->deposit_amount;
        } else {
            $payAmount = $request->amount;
            $amount = $request->amount;
        }
        $order = new MidtransOrder();
        $order->type = $request->type;
        $order->order_id = $order_id;
        $order->user_id = Auth::user()->id;
        $order->amount = $payAmount;
        $order->save();

        $params = array(
            'transaction_details' => array(
                'order_id' => $order_id,
                'gross_amount' => $amount,
            )
        );

        $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;

        return \redirect()->to($paymentUrl);

    }


    public function paymentSuccess(Request $request)
    {

        $order = MidtransOrder::where('order_id', $request->order_id)->where('user_id', Auth::user()->id)->first();

        if ($order) {
            if ($request->transaction_status == 'settlement') {
                if ($order->type == "Test") {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    return redirect()->route('paymentmethodsetting.test');
                } elseif ($order->type == "Deposit") {
                    $deposit = new DepositController();
                    $payWithMidtrans = $deposit->depositWithGateWay($order->amount, $request, "Midtrans");

                } elseif ($order->type == "prebooking") {
                    $booking = new PrebookingController();
                    $payWithMidtrans = $booking->bookingWithGateWay($order->amount, $request, "Midtrans");

                } elseif ($order->type == "Subscription") {
                    $deposit = new SubscriptionPaymentController();
                    $payWithMidtrans = $deposit->payWithGateWay($request, "Midtrans");

                } else {
                    $payment = new PaymentController();
                    $payWithMidtrans = $payment->payWithGateWay($request, "Midtrans");
                }

                $order->delete();

                if ($payWithMidtrans) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    return $this->redirectToDashboard();
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return $this->redirectToDashboard();
                }
            }
        } else {
            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
            return $this->redirectToDashboard();
        }

        if (empty($response)) {
            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
            return $this->redirectToDashboard();
        }

    }


    public function paymentPending()
    {
        Toastr::error(trans('frontend.Payment is pending'), trans('frontend.Pending'));
        return redirect()->back();
    }

    public function paymentFailed()
    {
        $order = PayeerOrder::where('user_id', Auth::user()->id)->latest()->first();
        if ($order) {
            $order->delete();
        }
        Toastr::error(trans('frontend.Payment Failed'), trans('common.Failed'));
        return redirect()->back();
    }
}
