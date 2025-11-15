<?php

namespace App\Repositories;

use Modules\MercadoPago\Http\Controllers\MercadoPagoController;
use Modules\RazerMS\Http\Controllers\RazerMSController;
use Omnipay\Omnipay;
use Illuminate\Support\Facades\Auth;
use Unicodeveloper\Paystack\Facades\Paystack;
use Bryceandy\Laravel_Pesapal\Facades\Pesapal;
use Modules\Membership\Entities\MembershipCart;
use app\Repositories\PaymentRepositoryInterface;
use Modules\Paytm\Http\Controllers\PaytmController;
use Modules\Payeer\Http\Controllers\PayeerController;
use Modules\Midtrans\Http\Controllers\MidtransController;
use Modules\Mobilpay\Http\Controllers\MobilpayController;
use Modules\Razorpay\Http\Controllers\RazorpayController;
use Modules\Instamojo\Http\Controllers\InstamojoController;

class PaymentRepository implements PaymentRepositoryInterface
{
    public $payPalGateway;

    public function __construct()
    {
        $this->payPalGateway = Omnipay::create('PayPal_Rest');
        $this->payPalGateway->setClientId(getPaymentEnv('PAYPAL_CLIENT_ID'));
        $this->payPalGateway->setSecret(getPaymentEnv('PAYPAL_CLIENT_SECRET'));
        $this->payPalGateway->setTestMode(getPaymentEnv('IS_PAYPAL_LOCALHOST') == 'true');
    }

    public function paymentWithWallet($request, $type)
    {
        $user = Auth::user();
        $cart = null;

        $cart = MembershipCart::where('user_id', $user->id)->first();

        if (!$cart) {
            $response['type'] = 'error';
            $response['message'] = 'Data Not Found';
            return $response;
        }
        if ($type == 'membership' && isModuleActive('Membership')) {
            if ($user->balance < $cart->price) {
                $response['type'] = 'error';
                $response['message'] = 'Insufficient balance';
                return $response;
            } else {
                $newBalance = ($user->balance - $cart->price);
                $this->balance($user, $newBalance);
                $response['type'] = 'success';
                $response['response'] = [];
                return $response;
            }
        }

    }

    public function paymentWithPaypal($amount)
    {
        $response = $this->payPalGateway->purchase(array(
            'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', Settings('currency_code'), $amount),
            'currency' => Settings('currency_code'),
            'returnUrl' => route('paypalSuccess'),
            'cancelUrl' => route('paypalFailed'),

        ))->send();
        return $response;
        // if ($response->isRedirect()) {
        //     $response->redirect(); // this will automatically forward the customer
        // } else {
        //     Toastr::error($response->getMessage(), trans('common.Failed'));
        //     return \redirect()->back()->send();
        // }
    }

    public function paymentWithPayeer($request, $amount)
    {
        $payeer = new PayeerController();
        $request->merge(['type' => 'Payment']);
        $request->merge(['amount' => $amount]);
        $response = $payeer->makePayment($request);
        return $response;
        // if ($response) {
        //     return \redirect()->to($response);
        // } else {
        //     Toastr::error('Something went wrong', 'Failed');
        //     return \redirect()->back()->send();
        // }
    }

    public function paymentWithMidtrans($request, $amount)
    {
        $midtrans = new MidtransController();
        $request->merge(['type' => 'Payment']);
        $request->merge(['amount' => $amount]);
        $response = $midtrans->makePayment($request);
        return $response;
        // if ($response) {
        //     return $response;
        // } else {
        //     Toastr::error('Something went wrong', 'Failed');
        //     return \redirect()->back()->send();
        // }
    }

    public function paymentWithMercadoPago($request)
    {
        $mercadoPagoController = new MercadoPagoController();
        $response = $mercadoPagoController->payment($request->all());
        return $response;
    }

    public function paymentWithInstamojo($amount)
    {
        $amount = convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $amount);
        $instamojo = new InstamojoController();
        $response = $instamojo->paymentProcess($amount);
        return $response;
    }

    public function paymentWithMobilPay($amount)
    {
        $amount = convertCurrency(Settings('currency_code') ?? Settings('currency_code'), 'RON', $amount);
        $mobilpay = new MobilpayController();
        $mobilpay->paymentProcess($amount);
    }

    public function paymentWithStripe($request, $amount)
    {
        $token = $request->stripeToken ?? '';
        $gatewayStripe = Omnipay::create('Stripe');
        $gatewayStripe->setApiKey(getPaymentEnv('STRIPE_SECRET'));

        //$formData = array('number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2030', 'cvv' => '123');
        $response = $gatewayStripe->purchase(array(
            'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', Settings('currency_code'), $amount),
            'currency' => Settings('currency_code'),
            'token' => $token,
        ))->send();

        return $response;

    }

    public function paymentWithRazorPay($request)
    {
        $payment = new RazorpayController();
        $response = $payment->payment($request->razorpay_payment_id);
        return $response;
    }

    public function paymentWithPayTM(array $userData)
    {
        $payment = new PaytmController();
        return $payment->payment($userData);
    }

    public function paymentWithPayStack()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    public function paymentWithRazerMS($amount)
    {
        $payment = new RazerMSController();
        $url = $payment->generatePaymentUrl($amount, 'payment');
        return $url;
    }

    public function paymentWithPesapal($amount, $type = 'payment')
    {
        $paymentData = [
            'amount' => $amount,
            'currency' => Settings('currency_code'),
            'description' => 'Payment',
            'type' => 'MERCHANT',
            'reference' => $type . '|'.md5(time()).'|' . $amount,
            'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
            'email' => Auth::user()->email,
        ];
        $iframe_src = Pesapal::getIframeSource($paymentData);
        return $iframe_src;
    }

    public function payWithGateWay()
    {

    }

    private function balance($user, $newBalance)
    {
        $user->balance = $newBalance;
        $user->save();
    }
}
