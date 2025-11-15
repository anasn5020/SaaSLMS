<?php

namespace Modules\Paytm\Http\Controllers;

use App\Http\Controllers\DepositController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionPaymentController;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\UpcomingCourse\Http\Controllers\PrebookingController;
use Paytm\JsCheckout\Facades\Paytm;

class PaytmController extends Controller
{

    public function index()
    {
        return view('paytm::index');
    }

    public function redirectToDashboard()
    {
        if (\auth()->user()->role_id == 3) {
            return redirect(route('studentDashboard'));
        } else {
            return redirect(route('dashboard'));
        }

    }

    public function pay(Request $request)
    {
        if ($request->type == 'payment') {
            $amount = convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $request->amount);
            $callback_url = route('paytmStatus');
        } elseif ($request->type == 'booking') {
            $amount = convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $request->amount);
            $callback_url = route('paytmBookingStatus');
        } elseif ($request->type == 'deposit') {
            $amount = convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $request->amount);
            $callback_url = route('paytmDepositStatus');
        } elseif ($request->type == 'subscription') {
            $amount = convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $request->amount);
            $callback_url = route('paytmSubscriptionStatus');
        } else {
            $amount = 1;
            $callback_url = route('paytmTestStatus');
        }

        $phone = Auth::user()->phone;
        $email = Auth::user()->email;
        $name = Auth::user()->name;
        $user_id = Auth::user()->id;
        if (empty($phone)) {
            return response()->json(array(
                'code' => 404,
                'message' => trans('payment.Phone number is required. Please update your profile')
            ), 404);
        }

        $userData = [
            'name' => $name,
            'mobile' => $phone,
            'email' => $email,
            'fee' => $amount,
            'order_id' => Auth::user()->phone . "_" . rand(1, 1000000),
        ];
        $payment = Paytm::with('receive');
        $payment->prepare([
            'order' => $userData['order_id'],
            'user' => $user_id,
            'mobile_number' => $userData['mobile'],
            'email' => $userData['email'],
            'amount' => $amount,
            'callback_url' => $callback_url
        ]);
        return $payment->receive();
    }


    public function testCallback()
    {
        try {
            $transaction = Paytm::with('receive');


            $transaction->response();


            if ($transaction->isSuccessful()) {
                Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
            } else if ($transaction->isFailed()) {
                Toastr::error(trans('frontend.Your payment is failed'),  trans('common.Error'));


            }
            return Redirect::back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function paymentCallback()
    {
        try {

            $transaction = Paytm::with('receive');

            $response = $transaction->response();


            if ($transaction->isSuccessful()) {
                $payment = new PaymentController();
                $payWithPayTM = $payment->payWithGateWay($response, "PayTM");
                if ($payWithPayTM) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (currentTheme() == 'tvt') {
                        return redirect('/');
                    } else {
                        return $this->redirectToDashboard();

                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return Redirect::back();
                }

            } else if ($transaction->isFailed()) {
                Toastr::error(trans('frontend.Your payment is failed'),  trans('common.Error'));

                return Redirect::back();

            } else {

                Toastr::error($transaction->getResponseMessage(),  trans('common.Error')
);
                if (currentTheme() == 'tvt') {
                    return redirect('/');
                } else {
                    return $this->redirectToDashboard();

                }
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }


    public function depositCallback()
    {
        try {

            $transaction = Paytm::with('receive');


            $response = $transaction->response();


            if ($transaction->isSuccessful()) {
                $payment = new DepositController();
                $amount = round(convertCurrency($response['CURRENCY'], strtoupper(Settings('currency_code') ?? 'BDT'), $response['TXNAMOUNT']));

                $payWithPayTM = $payment->depositWithGateWay($amount, $response, "PayTM");
                if ($payWithPayTM) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (currentTheme() == 'tvt') {
                        return redirect('/');
                    } else {
                        return $this->redirectToDashboard();

                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return Redirect::back();
                }

            } else if ($transaction->isFailed()) {
                Toastr::error(trans('frontend.Your payment is failed'),  trans('common.Error'));

                return Redirect::back();

            } else {

                Toastr::error($transaction->getResponseMessage(),  trans('common.Error')
);
                if (currentTheme() == 'tvt') {
                    return redirect('/');
                } else {
                    return $this->redirectToDashboard();

                }
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }

    public function subscriptionCallback()
    {
        try {
            $transaction = Paytm::with('receive');


            $response = $transaction->response();

            if ($transaction->isSuccessful()) {
                $payment = new SubscriptionPaymentController();

                $payWithPayTM = $payment->payWithGateWay($response, "PayTM");
                if ($payWithPayTM) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (currentTheme() == 'tvt') {
                        return redirect('/');
                    } else {
                        return $this->redirectToDashboard();

                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return Redirect::back();
                }

            } else if ($transaction->isFailed()) {
                Toastr::error(trans('frontend.Your payment is failed'),  trans('common.Error'));
                return Redirect::back();

            } else {

                Toastr::error($transaction->getResponseMessage(),  trans('common.Error')
);
                if (currentTheme() == 'tvt') {
                    return redirect('/');
                } else {
                    return $this->redirectToDashboard();

                }
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }

    public function bookingCallback()
    {
        try {

            $transaction = Paytm::with('receive');


            $response = $transaction->response();


            if ($transaction->isSuccessful()) {
                $payment = new PrebookingController();
                $amount = round(convertCurrency($response['CURRENCY'], strtoupper(Settings('currency_code') ?? 'BDT'), $response['TXNAMOUNT']));

                $payWithPayTM = $payment->bookingWithGateWay($amount, $response, "PayTM");
                if ($payWithPayTM) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (currentTheme() == 'tvt') {
                        return redirect('/');
                    } else {
                        return $this->redirectToDashboard();

                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return Redirect::back();
                }

            } else if ($transaction->isFailed()) {
                Toastr::error(trans('frontend.Your payment is failed'),  trans('common.Error'));
                return Redirect::back();

            } else {

                Toastr::error($transaction->getResponseMessage(),  trans('common.Error'));
                if (currentTheme() == 'tvt') {
                    return redirect('/');
                } else {
                    return $this->redirectToDashboard();

                }
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }


}
