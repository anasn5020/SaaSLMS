<?php

namespace App\Http\Controllers;

use App\DepositRecord;
use App\Traits\SendNotification;
use Brian2694\Toastr\Facades\Toastr;
use Bryceandy\Laravel_Pesapal\Facades\Pesapal;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Modules\AstraPay\Services\AstraPayService;
use Modules\AuthorizeNet\Repositories\AuthorizeNetRepository;
use Modules\BankPayment\Http\Controllers\BankPaymentController;
use Modules\Bkash\Services\BkashService;
use Modules\Braintree\Repositories\BraintreeRepository;
use Modules\CCAvenue\Libraries\CCAvenue;
use Modules\Coinbase\Repositories\CoinbaseRepository;
use Modules\Flutterwave\Repositories\FlutterwaveRepository;
use Modules\Instamojo\Http\Controllers\InstamojoController;
use Modules\JazzCash\Repositories\JazzcashRepository;
use Modules\MercadoPago\Http\Controllers\MercadoPagoController;
use Modules\Midtrans\Http\Controllers\MidtransController;
use Modules\Mobilpay\Http\Controllers\MobilpayController;
use Modules\Mollie\Repositories\MollieRepository;
use Modules\Organization\Entities\OrganizationFinance;
use Modules\Organization\Events\CourseSellCommissionEvent;
use Modules\Payeer\Http\Controllers\PayeerController;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;
use Modules\Paytm\Http\Controllers\PaytmController;
use Modules\RazerMS\Http\Controllers\RazerMSController;
use Modules\Razorpay\Http\Controllers\RazorpayController;
use Modules\Sslcommerz\Http\Controllers\SslcommerzController;
use Modules\TapPayment\Http\Controllers\TapPaymentController;
use Modules\Tranzak\Services\TranzakService;
use Netopia\Payment\Address;
use Netopia\Payment\Invoice;
use Netopia\Payment\Request\Card;
use Omnipay\Omnipay;
use Unicodeveloper\Paystack\Facades\Paystack;

class DepositController extends Controller
{
    use SendNotification;

    public $payPalGateway;

    public function __construct()
    {
        $this->middleware(['maintenanceMode', 'onlyAppMode']);

        $this->payPalGateway = Omnipay::create('PayPal_Rest');
        $this->payPalGateway->setClientId(getPaymentEnv('PAYPAL_CLIENT_ID'));
        $this->payPalGateway->setSecret(getPaymentEnv('PAYPAL_CLIENT_SECRET'));
        $this->payPalGateway->setTestMode(getPaymentEnv('IS_PAYPAL_LOCALHOST') == 'true'); //set it to 'false' when go live
    }

    public function depositSelectOption(Request $request)
    {
        $data = $request->validate([
            'deposit_amount' => 'required|numeric',
        ]);
        $amount = $request->deposit_amount;
        $records = DepositRecord::where('user_id', Auth::user()->id)->paginate(5);
        $methods = PaymentMethod::where('active_status', 1)->where('method', '!=', 'Wallet')->get(['method', 'logo']);
        return view(theme('depositSelect'), compact('records', 'methods', 'amount'));
    }

    public function depositSubmit(Request $request)
    {
        $data = $request->validate([
            'deposit_amount' => 'required|numeric',
            'method' => 'required',
        ]);

        if (Settings('hide_multicurrency') == 1) {
            $amount = convertCurrency(auth()->user()->currency->code ?? Settings('currency_code'), Settings('currency_code'), $data['deposit_amount']);
        } else {
            $amount = $data['deposit_amount'];
        }
        $system_currency = Settings('currency_code');

        $request->merge([
            "deposit_amount" => $amount
        ]);

        $data['deposit_amount'] = $amount;

        if ($data['method'] == "Sslcommerz") {
            $ssl = new SslcommerzController();
            $ssl->deposit($amount);

        } elseif ($data['method'] == "PayPal") {

            $response = $this->payPalGateway->purchase(array(
                'amount' => $amount,
                'currency' => $system_currency,
                'returnUrl' => route('paypalDepositSuccess'),
                'cancelUrl' => route('paypalDepositFailed'),

            ))->send();

            if ($response->isRedirect()) {
                $response->redirect(); // this will automatically forward the customer
            } else {
                Toastr::error($response->getMessage(), trans('common.Failed'));
                return \redirect()->back();
            }
        } elseif ($data['method'] == "Midtrans") {

            try {
                $midtrans = new MidtransController();
                $request->merge(['type' => 'Deposit']);
                $response = $midtrans->makePayment($request);

                if ($response) {
                    return $response;
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return \redirect()->back();
                }
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

            }


        } elseif ($data['method'] == "Payeer") {

            try {
                $payeer = new PayeerController();
                $request->merge(['type' => 'Deposit']);
                $response = $payeer->makePayment($request);
                if ($response) {
                    return \redirect()->to($response);
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return \redirect()->back();
                }
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

            }


        } elseif ($data['method'] == "MercadoPago") {
            $mercadoPagoController = new MercadoPagoController();
            $response = $mercadoPagoController->payment($request->all());
            return response()->json(['target_url' => $response]);
        } elseif ($data['method'] == "Instamojo") {
            $instamojo = new InstamojoController();
            $response = $instamojo->depositProcess($request);
            if ($response) {
                return \redirect()->to($response);
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return \redirect()->back();
            }

        } elseif ($data['method'] == "Stripe") {

            if (empty($request->get('stripeToken'))) {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return $this->redirectToDashboard();
            }

            $token = $request->stripeToken;
            $gatewayStripe = Omnipay::create('Stripe');
            $gatewayStripe->setApiKey(getPaymentEnv('STRIPE_SECRET'));


            $response = $gatewayStripe->purchase(array(
                'amount' => $amount,
                'currency' => $system_currency,
                'token' => $token,
            ))->send();

            if ($response->isRedirect()) {
                // redirect to offsite payment gateway
                $response->redirect();
            } elseif ($response->isSuccessful()) {
                // payment was successful: update database

//                $amount = number_format($response->getData()['amount'] / 100, 2);

                $payWithStripe = $this->depositWithGateWay($amount, $response, "Stripe");
                if ($payWithStripe) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    return $this->redirectToDashboard();
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return $this->redirectToDashboard();
                }

            } else {

                if ($response->getCode() == "amount_too_small") {
                    Toastr::error($response->getData()['error']['message'], trans('common.Error'));
                } else {
                    Toastr::error($response->getMessage(), trans('common.Error'));
                }
                return redirect()->back();

            }
        } elseif ($data['method'] == "RazorPay") {

            if (empty($request->razorpay_payment_id)) {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return \redirect()->back();
            }

            $payment = new RazorpayController();
            $response = $payment->payment($request->razorpay_payment_id);
            if ($response['type'] == "error") {
                Toastr::error($response['message'], 'Error');
                return \redirect()->back();
            }


            $amount = number_format($response['response']['amount'] / 100, 2);

            $payWithRazorPay = $this->depositWithGateWay($amount, $response['response'], "RazorPay");

            if ($payWithRazorPay) {
                Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                return $this->redirectToDashboard();
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return $this->redirectToDashboard();
            }
        } elseif ($data['method'] == "PayTM") {

            $phone = Auth::user()->phone;
            $email = Auth::user()->email;
            if (empty($phone)) {
                Toastr::error(trans('frontend.Phone number is required. Please update your profile'), trans('common.Error'));

                return redirect()->back();
            }

            $payment = new PaytmController();
            $userData = [
                'user' => Auth::user()->id,
                'mobile' => $phone,
                'email' => $email,
                'amount' => $amount,
                'order' => Auth::user()->phone . "_" . rand(1, 1000),
            ];
            return $payment->deposit($userData);
        } elseif ($data['method'] == "PayStack") {
            try {
                return Paystack::getAuthorizationUrl()->redirectNow();
            } catch (Exception $e) {
                Toastr::error(trans('frontend.Currency not supported by merchant'), trans('common.Failed'));
                if (Auth::user()->role_id==3){
                    return redirect()->route('deposit');
                }else{
                    return \redirect()->route('users.deposit.index');
                }
            }
        } elseif ($data['method'] == "RazerMS") {
            try {
                $payment = new RazerMSController();
                $url = $payment->generatePaymentUrl($data['deposit_amount'], 'deposit');
                return redirect($url);
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

            }
        } elseif ($data['method'] == "TapPayment") {
            try {
                (new TapPaymentController())->charge([
                    'amount' => $data['deposit_amount'],
                    'type' => 'deposit',
                    'currency' => Settings('currency_code'),
                    'user_id' => Auth::id(),
                    "customer" => [
                        "first_name" => Auth::user()->name,
                        "email" => Auth::user()->email,
                    ],
                ]);
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return redirect()->back();
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

            }
        } elseif ($data['method'] == "AstraPay") {
            try {

                $service = new AstraPayService();
                $service->paymentRequest([
                    'amount' => $data['deposit_amount'],
                    'currency' => Settings('currency_code'),
                    'description' => 'Deposit',
                ]);
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return redirect()->back();
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

            }
        } elseif ($data['method'] == "Bank Payment") {


            if (Settings('bank_max_fund_deposit') && Settings('bank_max_fund_deposit')<$request->deposit_amount){
                Toastr::error(trans('setting.Maximum Fund Deposit').' '.getPriceFormat(Settings('bank_max_fund_deposit')), trans('common.Error'));
                return back();
            }

            $rules = [
//                'bank_name' => 'required',
//                'branch_name' => 'required',
//                'type' => 'required',
//                'account_number' => 'required',
//                'account_holder' => 'required',
                'image' => 'mimes:jpeg,jpg,png,gif,pdf|required',
            ];
            $this->validate($request, $rules, validationMessage($rules));


            try {

                $payment = new BankPaymentController();
                $result = $payment->store($request);

                if ($result) {
                    return $this->redirectToDashboard();
                } else {
                    return redirect()->back();
                }

            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

            }
        } elseif ($data['method'] == "Pesapal") {
            try {
                $paymentData = [
                    'amount' => $request->deposit_amount,
                    'currency' => Settings('currency_code'),
                    'description' => 'Deposit',
                    'type' => 'MERCHANT',
                    'reference' => 'Deposit|'.md5(time()).'|' . $request->deposit_amount,
                    'first_name' => Auth::user()->first_name,
                    'last_name' => Auth::user()->last_name,
                    'email' => Auth::user()->email,
                ];

                $iframe_src = Pesapal::getIframeSource($paymentData);

                return view('laravel_pesapal::iframe', compact('iframe_src'));

            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

            }
        } elseif ($data['method'] == "Mobilpay") {
            $mobilpay = new MobilpayController();
            return $mobilpay->depositProcess($request);

        } elseif ($data['method'] == 'Authorize.Net') {
            $authorize = new AuthorizeNetRepository();
            $response = $authorize->payNow($request, $data['deposit_amount']);
            if ($response != null) {
                if ($response->getMessages()->getResultCode() == "Ok") {
                    $tresponse = $response->getTransactionResponse();
                    if ($tresponse != null && $tresponse->getMessages() != null) {
                        $payWithStripe = $this->depositWithGateWay($data['deposit_amount'], $response, "Authorize.Net");
                        if ($payWithStripe) {
                            Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                            return $this->redirectToDashboard();
                        } else {
                            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                            return $this->redirectToDashboard();
                        }
                    } else {
                        $msg = 'There were some issue with the payment. Please try again later.';
                        if ($tresponse->getErrors() != null) {
                            $msg = $tresponse->getErrors()[0]->getErrorText();
                        }
                        Toastr::error($msg, trans('common.Error'));
                        return Redirect::back();
                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return Redirect::back();
                }
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return Redirect::back();
            }
        } elseif ($data['method'] == 'Braintree') {
            $braintree = new BraintreeRepository();
            $result = $braintree->payNow($request, $data['deposit_amount']);
            if ($result->success) {
                $payWithBrain = $this->depositWithGateWay($data['deposit_amount'], $result, "Braintree");
                if ($payWithBrain) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    return $this->redirectToDashboard();
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return $this->redirectToDashboard();
                }
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return $this->redirectToDashboard();
            }
        } elseif ($data['method'] == "Mollie") {
            $mollie = new MollieRepository();
            $payment_info = [
                "amount" => $data['deposit_amount'],
                'success_url' => route('mollieDepositSuccess'),
                "order_id" => time(),
                "details" => "Balance Deposit",
            ];
            $result = $mollie->preparePayment($payment_info);
            session()->put('mollie_id', $result->id);
            return redirect($result->getCheckoutUrl(), 303);
        } elseif ($data['method'] == 'Flutterwave') {
            $flutterwave = new FlutterwaveRepository();
            $pay_info = [
                "name" => Auth::user()->name,
                "phone" => Auth::user()->phone,
                "email" => Auth::user()->email,
                "title" => "Balance Deposit",
                "description" => "Deposit Money on your Account",
                "webhook" => route('flutterwaveDepositWebhook')
            ];
            $payment = $flutterwave->payNow($pay_info, $request->deposit_amount);
            if ($payment->status == 'success') {
                return redirect()->to($payment->data->link);
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return back();
            }
        } elseif ($data['method'] == 'CCAvenue') {
            $ccavenue = new CCAvenue();
            return $response = $ccavenue->prepare('deposit', $request->deposit_amount);
        } elseif ($data['method'] == 'Tranzak') {

            $paymentData = [
                'amount' => $data['deposit_amount'],
                'currencyCode' => Settings('currency_code'),
                'description' => 'Deposit',
                'mchTransactionRef' => 'Deposit|' . $data['deposit_amount'],
            ];
            $service = new TranzakService();
            $payment_url = $service->paymentRequest($paymentData);
            if ($payment_url) {
                \redirect($payment_url)->send();
            } else {
                return back();
            }
        } elseif ($data['method'] == 'Bkash') {

            $paymentData = [
                'amount' => $data['deposit_amount'],
                'currencyCode' => Settings('currency_code'),
                'description' => 'Deposit',
             ];
            $service = new BkashService();
            $payment_url = $service->paymentRequest($paymentData);
            if ($payment_url) {
                \redirect($payment_url)->send();
            } else {
                return back();
            }
        } elseif ($data['method'] == 'Jazz Cash') {
            try {
                $jazz = new JazzcashRepository();
                $payment_info = [
                    "billref" => time(),
                    "description" => "Deposit Amount",
                    "email" => Auth::user()->email,
                    "mobile" => Auth::user()->phone,
                ];
                $result = $jazz->getArray($payment_info, $request->deposit_amount);
                $post_url = $jazz->getPostUrl();
                session()->put('from', 'deposit');
                return view('jazzcash::payment', compact('post_url'));
            } catch (Exception $e) {
                Toastr::error($e->getMessage(), trans('common.Error'));
                return back();
            }
        } elseif ($data['method'] == 'Coinbase') {
            $coinbase = new CoinbaseRepository();
            $payment_info = [
                "name" => "Deposit Balance",
                "description" => "Deposit Balance",
                "currency" => "USD",
                "charge_type" => "deposit"
            ];


            $result = $coinbase->makePayment($payment_info, $request->deposit_amount);

            session()->get('pay_from', 'deposit');
            session()->get('charge_id', $result['data']['id']);


            if (isset($result['data']) && isset($result['data']['hosted_url'])) {
                return redirect()->to($result['data']['hosted_url']);
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return back();
            }
        }


    }

    public function redirectToDashboard()
    {
        if (\auth()->user()->role_id == 3) {
            return redirect(route('studentDashboard'));
        } else {
            return redirect(route('dashboard'));
        }

    }

    public function depositWithGateWay($amount, $response, $gateWayName, $user = null)
    {
        $amount = str_replace(',', '', $amount);
        try {
            if (Auth::check()) {
                $user = Auth::user();
            }

            if ($user) {

                DB::beginTransaction();
                $user->balance += (float)$amount;
                $user->save();
                $depositRecord = new DepositRecord();
                $depositRecord->user_id = $user->id;
                $depositRecord->method = $gateWayName;
                $depositRecord->amount = (float)$amount;
                $depositRecord->response = json_encode($response);
                $depositRecord->save();

                $notificationTemplate = 'Wallet_Credited';
                $notificationTemplateData = [
                    'name' => $user->name,
                    'amount' => (float)$amount,
                    'date_time' => Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
                ];

                $this->sendNotification($notificationTemplate, $user, $notificationTemplateData,);

                if (isModuleActive('Cashback') && $depositRecord) {
                    generateCashback($depositRecord->user_id, $depositRecord->amount, 'recharge', $depositRecord);
                }
                if (isModuleActive('Organization') && $user->isOrganization()) {
                    $data = [
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'status' => true,
                        'type' => OrganizationFinance::$credit,
                        'description' => OrganizationFinance::$deposit_description,
                        'data_type' => OrganizationFinance::$type_deposit,
                        'payment_type' => OrganizationFinance::$payment_completed,
                    ];
                    event(new CourseSellCommissionEvent($data));
                }
//

                $notificationTemplate = 'Deposit_Successful';
                $notificationTemplateData = [
                    'name' => $user->name,
                    'amount' => $amount,
                    'date_time' => Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
                ];

                self::sendNotification($notificationTemplate, $user, $notificationTemplateData);

                Toastr::success(trans('frontend.Deposit done successfully'), trans('common.Success'));
                DB::commit();
                return true;

            } else {

                 Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return false;
            }


        } catch (Exception $e) {

            $notificationTemplate = 'Deposit_Unsuccessful';
            $notificationTemplateData = [
                'name' => $user->name,
                'amount' => $amount,
                'date_time' => Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
            ];

            self::sendNotification($notificationTemplate, $user, $notificationTemplateData);

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);
        }
    }

    public function paypalDepositSuccess(Request $request)
    {

        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->payPalGateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                // The customer has successfully paid.
                $arr_body = $response->getData();
                $paymentAmount = $arr_body['transactions'][0]['amount'];
                $amount = number_format($paymentAmount['total'], 2);

                $payWithPapal = $this->depositWithGateWay($amount, $arr_body, "PayPal");
                if ($payWithPapal) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    return $this->redirectToDashboard();
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return $this->redirectToDashboard();
                }

            } else {
                $msg = str_replace("'", " ", $response->getMessage());
                Toastr::error($msg, trans('common.Error'));
                return redirect()->back();
            }
        } else {
            Toastr::error(trans('frontend.Transaction is declined'),  trans('common.Error'));

             return redirect()->back();
        }


    }

    public function paypalDepositFailed()
    {

        Toastr::error(trans('frontend.User is canceled the payment'),  trans('common.Error'));
        return redirect()->back();
    }
}
