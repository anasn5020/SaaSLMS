<?php

namespace Modules\Instamojo\Http\Controllers;

use App\Http\Controllers\DepositController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionPaymentController;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class InstamojoController extends Controller
{
    public $url, $key, $token;

    public function __construct()
    {
        $this->url = getPaymentEnv('Instamojo_URL');
        $this->key = getPaymentEnv('Instamojo_API_AUTH');
        $this->token = getPaymentEnv('Instamojo_API_AUTH_TOKEN');
    }

    public function redirectToDashboard()
    {
        if (\auth()->user()->role_id == 3) {
            return redirect(route('studentDashboard'));
        } else {
            return redirect(route('dashboard'));
        }

    }

    public function testProcess(Request $request)
    {

        $amount = $request->test_amount;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . 'payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:" . $this->key,
                "X-Auth-Token:" . $this->token));
        $payload = array(
            'purpose' => 'Test',
            'amount' => $amount,
            'buyer_name' => Auth::user()->name,
            'redirect_url' => route('instamojoTestSuccess'),
            'send_email' => true,
            'email' => Auth::user()->email,
            'allow_repeated_payments' => false
        );

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        if (isset($response->payment_request)) {
            return $response->payment_request->longurl;
        } elseif (isset($response->message)) {
            Toastr::error($response->message, 'Error');
            return false;
        } else {
            Toastr::error('Something went wrong! Check your Instamojo URL', 'Error');
            return false;
        }
    }

    public function testSuccess(Request $request)
    {


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url . 'payments/' . $request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:" . $this->key,
                "X-Auth-Token:" . $this->token));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->route('paymentmethodsetting.test');
        } else {
            $data = json_decode($response);

        }


        if ($data->success == true) {
            if ($data->payment->status == 'Credit') {
                Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                return redirect()->route('paymentmethodsetting.test');
            }
        }
    }


    public function depositProcess(Request $request)
    {

        $amount = $request->deposit_amount;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . 'payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:" . $this->key,
                "X-Auth-Token:" . $this->token));
        $payload = array(
            'purpose' => 'Deposit',
            'amount' => $amount,
            'buyer_name' => Auth::user()->name,
            'redirect_url' => route('instamojoDepositSuccess'),
            'send_email' => true,
            'email' => Auth::user()->email,
            'allow_repeated_payments' => false
        );


        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);


        if (isset($response->payment_request)) {
            return $response->payment_request->longurl;
        } elseif (isset($response->message)) {
            Toastr::error($response->message, 'Error');
            return false;
        } else {
            Toastr::error('Something went wrong! Check your Instamojo URL', 'Error');
            return false;
        }
    }

    public function depositSuccess(Request $request)
    {


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url . 'payments/' . $request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:" . $this->key,
                "X-Auth-Token:" . $this->token));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->route('deposit');
        } else {
            $data = json_decode($response);

        }


        if ($data->success == true) {
            if ($data->payment->status == 'Credit') {
                $deposit = new DepositController();
                $amount = round(convertCurrency($data->payment->currency, strtoupper(Settings('currency_code') ?? 'BDT'), $data->payment->amount));
                $payWithInstamojo = $deposit->depositWithGateWay($amount, $response, "Instamojo");

                if ($payWithInstamojo) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    return $this->redirectToDashboard();
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return $this->redirectToDashboard();
                }
            }
        }
    }

    public function paymentProcess($amount)
    {

        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url . 'payment-requests/');
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                array("X-Api-Key:" . $this->key,
                    "X-Auth-Token:" . $this->token));
            $payload = array(
                'purpose' => 'Payment',
                'amount' => $amount,
                'buyer_name' => Auth::user()->name,
                'redirect_url' => route('instamojoPaymentSuccess'),
                'send_email' => true,
                'email' => Auth::user()->email,
                'allow_repeated_payments' => false
            );

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);
            if ($response->success) {
                return $response->payment_request->longurl;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function paymentSuccess(Request $request)
    {


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url . 'payments/' . $request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:" . $this->key,
                "X-Auth-Token:" . $this->token));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->route('orderPayment');
        } else {
            $data = json_decode($response);

        }


        if ($data->success == true) {
            if ($data->payment->status == 'Credit') {
                $payment = new PaymentController();
                $payWithInstamojo = $payment->payWithGateWay($response, "Instamojo");

                if ($payWithInstamojo) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    return $this->redirectToDashboard();
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return $this->redirectToDashboard();
                }
            }
        }
    }


    public function subscriptionProcess($amount)
    {

        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url . 'payment-requests/');
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                array("X-Api-Key:" . $this->key,
                    "X-Auth-Token:" . $this->token));
            $payload = array(
                'purpose' => 'Payment',
                'amount' => $amount,
                'buyer_name' => Auth::user()->name,
                'redirect_url' => route('instamojoSubscriptionSuccess'),
                'send_email' => true,
                'email' => Auth::user()->email,
                'allow_repeated_payments' => false
            );

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);
            if ($response->success) {
                return $response->payment_request->longurl;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function subscriptionSuccess(Request $request)
    {


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url . 'payments/' . $request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:" . $this->key,
                "X-Auth-Token:" . $this->token));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->route('courseSubscriptionCheckout');
        } else {
            $data = json_decode($response);

        }


        if ($data->success == true) {
            if ($data->payment->status == 'Credit') {
                $payment = new SubscriptionPaymentController();
                $payWithInstamojo = $payment->payWithGateWay($response, "Instamojo");

                if ($payWithInstamojo) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                }

                if (currentTheme() == 'tvt') {
                    return redirect('/');
                } else {
                    return $this->redirectToDashboard();
                }
            }
        }
    }
}
