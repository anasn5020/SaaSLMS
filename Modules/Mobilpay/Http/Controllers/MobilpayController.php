<?php

namespace Modules\Mobilpay\Http\Controllers;


use Adrianbarbos\Mobilpay\Mobilpay;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\PaymentController;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Mobilpay\Entities\MobilPayOrder;
use Modules\UpcomingCourse\Http\Controllers\PrebookingController;

class MobilpayController extends Controller
{

    public function redirectToDashboard()
    {
        if (\auth()->user()->role_id == 3) {
            return redirect(route('studentDashboard'));
        } else {
            return redirect(route('dashboard'));
        }

    }

    public function bookingProcess(Request $request)
    {
        $amount = convertCurrency(Settings('currency_code') ?? 'BDT', 'RON', $request->deposit_amount);
        $orderId = md5(uniqid(rand()));

        $order = new MobilPayOrder();
        $order->user_id = Auth::user()->id;
        $order->orderId = $orderId;
        $order->amount = $request->deposit_amount;
        $order->type = "prebooking";
        $order->save();
        Mobilpay::setOrderId($orderId)
            ->setAmount($amount)
            ->setDetails('prebooking')
            ->setConfirmUrl(url('mobilpay/confirm/booking'))
            ->setReturnUrl(url('mobilpay/return'))
            ->purchase();
        return;
    }


    public function paymentProcess($amount)
    {
        $orderId = md5(uniqid(rand()));

        $order = new MobilPayOrder();
        $order->user_id = Auth::user()->id;
        $order->orderId = $orderId;
        $order->amount = $amount;
        $order->type = "Payment";
        $order->save();
        Mobilpay::setOrderId($orderId)
            ->setAmount($amount)
            ->setDetails('Payment')
            ->setConfirmUrl(url('mobilpay/confirm/payment'))
            ->setReturnUrl(url('mobilpay/return'))
            ->purchase();
        return;
    }

    public function depositProcess(Request $request)
    {
        $amount = convertCurrency(Settings('currency_code') ?? 'BDT', 'RON', $request->deposit_amount);
        $orderId = md5(uniqid(rand()));

        $order = new MobilPayOrder();
        $order->user_id = Auth::user()->id;
        $order->orderId = $orderId;
        $order->amount = $request->deposit_amount;
        $order->type = "Deposit";
        $order->save();
        Mobilpay::setOrderId($orderId)
            ->setAmount($amount)
            ->setDetails('Deposit')
            ->setConfirmUrl(url('mobilpay/confirm/deposit'))
            ->setReturnUrl(url('mobilpay/return'))
            ->purchase();
        return;
    }

    public function testProcess(Request $request)
    {
        try {
            $amount = convertCurrency(Settings('currency_code') ?? 'BDT', 'RON', $request->deposit_amount);
            $orderId = md5(uniqid(rand()));

            $order = new MobilPayOrder();
            $order->user_id = Auth::user()->id;
            $order->orderId = $orderId;
            $order->amount = 10;
            $order->type = "Test";
            $order->save();
            Mobilpay::setOrderId($orderId)
                ->setAmount($amount)
                ->setDetails('Test')
                ->setConfirmUrl(url('mobilpay/confirm/test'))
                ->setReturnUrl(url('mobilpay/return'))
                ->purchase();
            return;
        } catch (\Exception $exception) {
            Toastr::error($exception->getMessage(), trans('common.Error'));
        }
    }

    public function return(Request $request)
    {
        Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
        return $this->redirectToDashboard();
    }

    public function confirmBooking(Request $request)
    {
        $response = Mobilpay::response();

        $data = $response->getData();
        $status = $response->getMessage();

        $orderId = $data['orderId'];

        $check = MobilPayOrder::where('orderId', $orderId)->where('status', 'pending')->first();
        if ($check) {
            if ($status == "confirmed") {
                $check->status = 'confirmed';
                $check->save();
                $user = User::find($check->user_id);
                $deposit = new PrebookingController();
                $payWithMobilPay = $deposit->bookingWithGateWay($check->amount, null, "Mobilpay", $user);
                Log::info('pay with mobilpay=' . $payWithMobilPay);
                if ($payWithMobilPay) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                }
            }
        }
        return response()->json(['ok' => 'ok']);
    }

    public function confirmDeposit(Request $request)
    {
        $response = Mobilpay::response();

        $data = $response->getData();
        $status = $response->getMessage();

        $orderId = $data['orderId'];

        $check = MobilPayOrder::where('orderId', $orderId)->where('status', 'pending')->first();
        if ($check) {
            if ($status == "confirmed") {
                $check->status = 'confirmed';
                $check->save();
                $user = User::find($check->user_id);
                $deposit = new DepositController();
                $payWithMobilPay = $deposit->depositWithGateWay($check->amount, null, "Mobilpay", $user);
                Log::info('pay with mobilpay=' . $payWithMobilPay);
                if ($payWithMobilPay) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                }
            }
        }


        return response()->json(['ok' => 'ok']);
    }


    public function confirmPayment(Request $request)
    {
        $response = Mobilpay::response();

        $data = $response->getData();
        $status = $response->getMessage();

        $orderId = $data['orderId'];

        $check = MobilPayOrder::where('orderId', $orderId)->where('status', 'pending')->first();
        if ($check) {
            if ($status == "confirmed") {
                $check->status = 'confirmed';
                $check->save();
                $user = User::find($check->user_id);
                $payment = new PaymentController();
                $payWithMobilPay = $payment->payWithGateWay($response, "Mobilpay", $user);

                if ($payWithMobilPay) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    return $this->redirectToDashboard();
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return $this->redirectToDashboard();
                }
            }
        }


        return response()->json(['ok' => 'ok']);
    }

}
