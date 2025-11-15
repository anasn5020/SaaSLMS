<?php

namespace Modules\PaymentMethodSetting\Http\Controllers;

use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Bryceandy\Laravel_Pesapal\Facades\Pesapal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\AstraPay\Services\AstraPayService;
use Modules\AuthorizeNet\Repositories\AuthorizeNetRepository;
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
use Modules\ModuleManager\Entities\InfixModuleManager;
use Modules\ModuleManager\Entities\Module;
use Modules\Mollie\Repositories\MollieRepository;
use Modules\Payeer\Http\Controllers\PayeerController;
use Modules\PaymentMethodSetting\Entities\PaymentGatewaySetting;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;
use Modules\PaymentMethodSetting\Entities\PaymentMethodCredential;
use Modules\RazerMS\Http\Controllers\RazerMSController;
use Modules\Razorpay\Http\Controllers\RazorpayController;
use Modules\Sslcommerz\Http\Controllers\SslcommerzController;
use Modules\TapPayment\Http\Controllers\TapPaymentController;
use Modules\Tranzak\Services\TranzakService;
use Omnipay\Omnipay;
use Throwable;
use Twilio\TwiML\Voice\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentMethodSettingController extends Controller
{
    use ImageStore;

    public $payPalGateway;

    public function __construct()
    {

        $this->payPalGateway = Omnipay::create('PayPal_Rest');
        $this->payPalGateway->setClientId(getPaymentEnv('PAYPAL_CLIENT_ID'));
        $this->payPalGateway->setSecret(getPaymentEnv('PAYPAL_CLIENT_SECRET'));
        $this->payPalGateway->setTestMode(getPaymentEnv('IS_PAYPAL_LOCALHOST') == 'true');
    }

    public function index()
    {
        $payment_methods = DB::table('payment_methods')->where('module_status', '=', 1)->where('lms_id', 1)->get();

        $payment_method_status = PaymentMethod::where('module_status', '=', 1)->pluck('method');


        foreach ($payment_methods->whereNotIn('method', $payment_method_status) as $method) {
            $new = new PaymentMethod();
            $new->method = $method->method;
            $new->type = $method->type;
            $new->active_status = $method->active_status;
            $new->module_status = $method->module_status;
            $new->logo = $method->logo;
            $new->created_by = $method->created_by;
            $new->updated_by = $method->updated_by;
            $new->save();
        }


        $payment_methods = PaymentMethod::where('module_status', '=', 1)->get();


        return view('paymentmethodsetting::index', compact('payment_methods'));
    }

    public function update(Request $request)
    {
        // return $request;
        if (demoCheck()) {
            return redirect()->back();
        }
        try {

            $method = PaymentMethod::find($request->payment_method_id);
            if ($request->hasFile('logo')) {
                $method->logo = $this->saveImage($request->logo);
            }
            $method->save();


            if ($method->method == 'Sslcommerz') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->STORE_ID = trim($request->ssl_store_id);
                    $method_setup->STORE_PASSWORD = trim($request->ssl_store_password);
                    if ($request->ssl_mode == 2) {
                        $value3 = "false";
                    } else {
                        $value3 = "true";
                    }
                    $method_setup->IS_LOCALHOST = $value3;
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'Pesapal') {

                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->PESAPAL_KEY = trim($request->pesapal_client_id);
                    $method_setup->PESAPAL_SECRET = trim($request->pesapal_client_secret);
                    if ($request->pesapal_mode == 2) {

                        $value3 = "true";
                    } else {
                        $value3 = "false";
                    }
                    $method_setup->PESAPAL_IS_LIVE = $value3;
                    $method_setup->PESAPAL_CALLBACK = url('pesapal/success');
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'PayPal') {

                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->PAYPAL_CLIENT_ID = trim($request->paypal_client_id);
                    $method_setup->PAYPAL_CLIENT_SECRET = trim($request->paypal_client_secret);
                    if ($request->paypal_mode == 2) {
                        $value3 = "false";
                    } else {
                        $value3 = "true";
                    }
                    $method_setup->IS_PAYPAL_LOCALHOST = $value3;
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'Stripe') {

                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->STRIPE_SECRET = trim($request->client_secret);
                    $method_setup->STRIPE_KEY = trim($request->client_publisher_key);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'RazorPay') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->RAZOR_KEY = trim($request->razor_key);
                    $method_setup->RAZOR_SECRET = trim($request->razor_secret);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'PayStack') {

                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->PAYSTACK_PUBLIC_KEY = trim($request->paystack_key);
                    $method_setup->PAYSTACK_SECRET_KEY = trim($request->paystack_secret);
                    $method_setup->PAYSTACK_PAYMENT_URL = trim($request->paystack_payment_url);
                    $method_setup->MERCHANT_EMAIL = trim($request->merchant_email);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'Instamojo') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->Instamojo_API_AUTH = trim($request->instamojo_api_auth);
                    $method_setup->Instamojo_API_AUTH_TOKEN = trim($request->instamojo_auth_token);
                    $method_setup->Instamojo_URL = trim($request->instamojo_url);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'Midtrans') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->MIDTRANS_SERVER_KEY = trim($request->midtrans_server_key);
                    $method_setup->MIDTRANS_ENV = trim($request->midtrans_env);
                    $method_setup->MIDTRANS_SANITIZE = trim($request->midtrans_sanitiz);
                    $method_setup->MIDTRANS_3DS = trim($request->midtrans_3ds);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'Payeer') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->PAYEER_MERCHANT = trim($request->payeer_marchant);
                    $method_setup->PAYEER_KEY = trim($request->payeer_key);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'MercadoPago') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));
                    $method_setup->MERCADO_PUBLIC_KEY = trim($request->public_key);
                    $method_setup->MERCADO_ACCESS_TOKEN = trim($request->access_token);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'Mobilpay') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    if ($request->mobilpay_mode == '2') {
                        $value4 = "false";
                    } else {
                        $value4 = "true";
                    }


                    if ($request->hasFile('public_key')) {
                        $file = $request->file('public_key');
                        $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $path = $request->file('public_key')->storeAs('mobilpay', $fileName, 'local');
                        $fileName = 'storage/app/' . $path;
                        $fileName = base_path($fileName);
                        $value2 = str_replace('\\', '/', $fileName);
                        $method_setup->MOBILPAY_PUBLIC_KEY_PATH = $value2;


                    }
                    if ($request->hasFile('private_key')) {
                        $file = $request->file('private_key');
                        $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $path = $request->file('private_key')->storeAs('mobilpay', $fileName, 'local');
                        $fileName = 'storage/app/' . $path;
                        $fileName = base_path($fileName);
                        $value3 = str_replace('\\', '/', $fileName);
                        $method_setup->MOBILPAY_PRIVATE_KEY_PATH = $value3;

                    }

                    $method_setup->MOBILPAY_MERCHANT_ID = trim($request->mobilpay_merchant_id);
                    $method_setup->MOBILPAY_TEST_MODE = $value4;
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'PayTM') {

                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->PAYTM_ENVIRONMENT = trim($request->paytm_mode);
                    $method_setup->PAYTM_MERCHANT_ID = trim($request->paytm_merchant_id);
                    $method_setup->PAYTM_MERCHANT_KEY = trim($request->paytm_merchant_key);
                    $method_setup->PAYTM_MERCHANT_WEBSITE = trim($request->paytm_merchant_website);
                    $method_setup->PAYTM_CHANNEL = trim($request->paytm_channel);
                    $method_setup->PAYTM_INDUSTRY_TYPE = trim($request->industry_type);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'RazerMS') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->RAZERMS_ENVIRONMENT = trim($request->razerms_mode);
                    $method_setup->RAZERMS_MERCHANT_ID = trim($request->razer_ms_merchant_id);
                    $method_setup->RAZERMS_VERIFY_KEY = trim($request->razerms_verify_key);
                    $method_setup->RAZERMS_PRIVATE_KEY = trim($request->razerms_private_key);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'Bkash') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->BKASH_APP_KEY = trim($request->bkash_app_key);
                    $method_setup->BKASH_APP_SECRET = trim($request->bkash_app_secret);
                    $method_setup->BKASH_USERNAME = trim($request->bkash_username);
                    $method_setup->BKASH_PASSWORD = trim($request->bkash_password);
                    if ($request->bkash_mode == 2) {
                        $value5 = "false";
                    } else {
                        $value5 = "true";
                    }
                    $method_setup->IS_BKASH_LOCALHOST = $value5;
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }


            } elseif ($method->method == 'AmazonPayment') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->AmazonPayment_merchant_identifier = trim($request->AmazonPayment_merchant_identifier);
                    $method_setup->AmazonPayment_access_code = trim($request->AmazonPayment_access_code);
                    $method_setup->AmazonPayment_SHARequestPhrase = trim($request->AmazonPayment_SHARequestPhrase);
                    $method_setup->AmazonPayment_SHAResponsePhrase = trim($request->AmazonPayment_SHAResponsePhrase);
                    $method_setup->AmazonPayment_SHAType = trim($request->AmazonPayment_SHAType);

                    $method_setup->AmazonPayment_ENVIRONMENT = !empty(trim($request->AmazonPayment_ENVIRONMENT)) ? trim($request->AmazonPayment_ENVIRONMENT) : 'sandbox';

                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }


            } elseif ($method->method == 'TapPayment') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));
                    $method_setup->TAP_PAYMENT_API_KEY = trim($request->TAP_PAYMENT_API_KEY);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }


            } elseif ($method->method == 'Bank Payment') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                    $method_setup->BANK_NAME = trim($request->bank_name);
                    $method_setup->BRANCH_NAME = trim($request->branch_name);
                    $method_setup->ACCOUNT_NUMBER = trim($request->account_number);
                    $method_setup->ACCOUNT_HOLDER = trim($request->account_holder);
                    $method_setup->ACCOUNT_TYPE = trim($request->type);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'Easy Paisa') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));
                    $method_setup->EASY_PAISA_STORE_ID = trim($request->EASY_PAISA_STORE_ID);
                    $method_setup->EASY_PAISA_HASH_KEY = trim($request->EASY_PAISA_HASH_KEY);
                    $method_setup->EASY_PAISA_AUTO_REDIRECT = trim($request->EASY_PAISA_AUTO_REDIRECT);
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'Authorize.Net') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));
                    $method_setup->AUTHORIZE_NET_API_KEY = trim($request->AUTHORIZE_NET_API_KEY);
                    $method_setup->AUTHORIZE_NET_TRANSACTION_KEY = trim($request->AUTHORIZE_NET_TRANSACTION_KEY);
                    $method_setup->AUTHORIZE_NET_ENVIRONMENT = $request->AUTHORIZE_NET_ENVIRONMENT == 'true' ? '1' : '0';
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == 'Braintree') {
                try {
                    $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));
                    $method_setup->BRAINTREE_MERCHANT_ID = trim($request->BRAINTREE_MERCHANT_ID);
                    $method_setup->BRAINTREE_PUBLIC_KEY = trim($request->BRAINTREE_PUBLIC_KEY);
                    $method_setup->BRAINTREE_PRIVATE_KEY = trim($request->BRAINTREE_PRIVATE_KEY);
                    $method_setup->BRAINTREE_ENVIRONMENT = $request->BRAINTREE_ENVIRONMENT;
                    $method_setup->save();
                } catch (Throwable $th) {
                                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                }
            } elseif ($method->method == "Mollie") {
                $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));
                $method_setup->MOLLIE_SECRET_KEY = trim($request->MOLLIE_SECRET_KEY);
                $method_setup->MOLLIE_PROFILE_ID = trim($request->MOLLIE_PROFILE_ID);
                $method_setup->MOLLIE_PARTNER_ID = trim($request->MOLLIE_PARTNER_ID);
                $method_setup->save();
            } elseif ($method->method == 'Flutterwave') {
                $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));
                $method_setup->FLW_PUBLIC_KEY = trim($request->FLW_PUBLIC_KEY);
                $method_setup->FLW_SECRET_KEY = trim($request->FLW_SECRET_KEY);
                $method_setup->FLW_SECRET_HASH = trim($request->FLW_SECRET_HASH);
                $method_setup->FLW_ENVIRONMENT = trim($request->FLW_ENVIRONMENT);
                $method_setup->save();
            } elseif ($method->method == 'Coinbase') {
                $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));
                $method_setup->COINBASE_API_KEY = trim($request->COINBASE_API_KEY);
                $method_setup->COINBASE_API_VERSION = trim($request->COINBASE_API_VERSION);
                $method_setup->COINBASE_WEBHOOK_SECRET = trim($request->COINBASE_WEBHOOK_SECRET);
                $method_setup->save();
            } elseif ($method->method == 'Jazz Cash') {
                $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));
                $method_setup->JAZZ_CASH_MERCHANT_ID = trim($request->JAZZ_CASH_MERCHANT_ID);
                $method_setup->JAZZ_CASH_PASSWORD = trim($request->JAZZ_CASH_PASSWORD);
                $method_setup->JAZZ_CASH_INTEGRITY_SALT = trim($request->JAZZ_CASH_INTEGRITY_SALT);
                $method_setup->JAZZ_CASH_ENVIROMENT = !empty($request->JAZZ_CASH_ENVIROMENT) ? trim($request->JAZZ_CASH_ENVIROMENT) : 'SANDBOX';
                $method_setup->save();
            } elseif ($method->method == "CCAvenue") {
                $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));
                $method_setup->CCA_KEY = trim($request->CCA_KEY);
                $method_setup->CCA_ACCESS_CODE = trim($request->CCA_ACCESS_CODE);
                $method_setup->CCA_MERCHANT_ID = trim($request->CCA_MERCHANT_ID);
                $method_setup->save();
            } elseif ($method->method == "Tranzak") {
                $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                $method_setup->Tranzak_API_KEY = trim($request->Tranzak_API_KEY);
                $method_setup->Tranzak_APP_ID = trim($request->Tranzak_APP_ID);
                $method_setup->Tranzak_ENVIRONMENT = !empty(trim($request->Tranzak_ENVIRONMENT)) ? trim($request->Tranzak_ENVIRONMENT) : 'sandbox';
                $method_setup->save();
            } elseif ($method->method == "AstraPay") {
                $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

                $method_setup->AstraPay_CLIENT_ID = trim($request->AstraPay_CLIENT_ID);
                $method_setup->AstraPay_MERCHANT_KEY = trim($request->AstraPay_MERCHANT_KEY);
                $method_setup->AstraPay_SECRET_KEY = trim($request->AstraPay_SECRET_KEY);
                $method_setup->AstraPay_ENVIRONMENT = !empty(trim($request->AstraPay_ENVIRONMENT)) ? trim($request->AstraPay_ENVIRONMENT) : 'sandbox';

                if ($request->hasFile('astrapay_private_key')) {
                    $file = $request->file('astrapay_private_key');
                    $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                    $path = $request->file('astrapay_private_key')->storeAs('astrapay', $fileName, 'local');
                    $fileName = 'storage/app/' . $path;
                    $fileName = base_path($fileName);
                    $value3 = str_replace('\\', '/', $fileName);
                    $method_setup->AstraPay_PRIVATE_KEY = $value3;

                }
                $method_setup->save();
            }


            GeneratePaymentSetting(SaasDomain());
            Artisan::call('config:clear',[
                '--no-interaction' => true,
            ]);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function changePaymentGatewayStatus(Request $request)
    {
        try {
            $gateway_ids = $request->gateways;
            $allGateways = PaymentMethod::all();

            foreach ($allGateways as $gateway) {

                if (in_array($gateway->id, $gateway_ids)) {

                    if ($gateway->type != "System") {
                        $valid = InfixModuleManager::where('name', $gateway->method)->first();

                        if (!empty($valid)) {
                            $active = Module::where('name', $gateway->method)->first();
                            if (!empty($active) && $active->status == 1) {
                                $gateway->active_status = 1;
                            } else {
                                Toastr::error($gateway->method . ' '.trans('frontend.Not Active'),  trans('common.Error')
);
                                return redirect()->back();
                            }
                        } else {
                            Toastr::error($gateway->method . ' '.trans('frontend.Not Verified yet'),  trans('common.Error')
);
                            return redirect()->back();
                        }
                    } else {
                        $gateway->active_status = 1;

                    }


                } else {
                    $gateway->active_status = 0;
                }
                $gateway->save();

            }

            Cache::forget('payment_methods_'.SaasDomain());
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function testSubmit(Request $request)
    {
        $data = $request->validate([
            'test_amount' => 'required|numeric',
            'method' => 'required',
        ]);


        if ($data['method'] == "Sslcommerz") {
            $ssl = new SslcommerzController();
            $ssl->test($data['test_amount']);

        } elseif ($data['method'] == "PayPal") {
            $response = $this->payPalGateway->purchase(array(
                'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', Settings('currency_code'), $data['test_amount']),
                'currency' => Settings('currency_code'),
                'returnUrl' => route('paypalTestSuccess'),
                'cancelUrl' => route('paypalTestFailed'),

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
                $request->merge(['type' => 'Test']);
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
                $request->merge(['type' => 'Test']);
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
            $response = $instamojo->testProcess($request);
            if ($response) {
                return \redirect()->to($response);
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return \redirect()->back();
            }

        } elseif ($data['method'] == "Stripe") {

            if (empty($request->get('stripeToken'))) {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return redirect(route('studentDashboard'));
            }

            $token = $request->stripeToken;
            $gatewayStripe = Omnipay::create('Stripe');
            $gatewayStripe->setApiKey(getPaymentEnv('STRIPE_SECRET'));


            $response = $gatewayStripe->purchase(array(
                'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', Settings('currency_code'), $data['test_amount']),
                'currency' => Settings('currency_code'),
                'token' => $token,
            ))->send();

            if ($response->isRedirect()) {
                // redirect to offsite payment gateway
                $response->redirect();
            } elseif ($response->isSuccessful()) {

                Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                return redirect()->route('paymentmethodsetting.test');

            } else {

                if ($response->getCode() == "amount_too_small") {
                    $amount = number_format(convertCurrency(Settings('currency_code'), strtoupper(Settings('currency_code') ?? 'BDT'), 0.5), 2);
                    $message = "Amount must be at least " . Settings('currency_symbol') . ' ' . $amount;
                    Toastr::error($message,  trans('common.Error')
);
                } else {
                    Toastr::error($response->getMessage(),  trans('common.Error')
);
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
                Toastr::error($response['message'],  trans('common.Error')
);
                return \redirect()->back();
            }

            Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
            return redirect()->route('paymentmethodsetting.test');

        }
//        elseif ($data['method'] == "PayTM") {
//            $phone = Auth::user()->phone;
//            $email = Auth::user()->email;
//            if (empty($phone)) {
//                Toastr::error('Phone number is required. Please update your profile ', 'Error');
//                return redirect()->back();
//            }
//
//            $payment = new PaytmController();
//            $userData = [
//                'user' => Auth::user()->id,
//                'mobile' => $phone,
//                'email' => $email,
//                'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $data['test_amount']),
//                'order' => Auth::user()->phone . "_" . rand(1, 1000),
//            ];
//            return $payment->test($userData);
//        }

        elseif ($data['method'] == "PayStack") {
            try {
                return Paystack::getAuthorizationUrl()->redirectNow();
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

            }
        } elseif ($data['method'] == "Pesapal") {
            try {
                $paymentData = [
                    'amount' => $request->test_amount,
                    'currency' => Settings('currency_code'),
                    'description' => 'Test',
                    'type' => 'MERCHANT',
                    'reference' => 'Test|'.md5(time()).'|' . $request->test_amount,
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
            return $mobilpay->testProcess($request);

        } elseif ($data['method'] == "RazerMS") {
            $pay = new RazerMSController();
            $url = $pay->generatePaymentUrl($request->test_amount, 'test');
            return \redirect($url);
        } elseif ($data['method'] == 'Authorize.Net') {
            $authorize = new AuthorizeNetRepository();
            $response = $authorize->payNow($request, $data['test_amount']);

            if ($response != null) {
                if ($response->getMessages()->getResultCode() == "Ok") {
                    $tresponse = $response->getTransactionResponse();
                    if ($tresponse != null && $tresponse->getMessages() != null) {
                        Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                        return redirect()->route('paymentmethodsetting.test');
                    } else {
                        $msg = 'here were some issue with the payment. Please try again later.';
                        if ($tresponse->getErrors() != null) {
                            $msg = $tresponse->getErrors()[0]->getErrorText();
                        }
                        Toastr::error($msg, trans('common.Failed'));
                        return redirect()->route('paymentmethodsetting.test');
                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return redirect()->route('paymentmethodsetting.test');
                }
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return redirect()->route('paymentmethodsetting.test');
            }
        } elseif ($data['method'] == 'Braintree') {
            $braintree = new BraintreeRepository();
            $result = $braintree->payNow($request, $data['test_amount']);

            if ($result->success) {
                Toastr::success('Payment successfull', 'Success');
                return redirect()->route('paymentmethodsetting.test');
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return redirect()->route('paymentmethodsetting.test');
            }

        } elseif ($data['method'] == 'Mollie') {
            $mollie = new MollieRepository();
            $pay_info = [
                "order_id" => time(),
                "details" => "Test Payment",
                "amount" => $data['test_amount'],
                "success_url" => route('testPaymentSuccess'),
            ];
            $result = $mollie->preparePayment($pay_info);
            session()->put('mollie_id', $result->id);
            return redirect($result->getCheckoutUrl(), 303);

        } elseif ($data['method'] == 'Flutterwave') {
            $flutterewave = new FlutterwaveRepository();
            $payment_info = [
                "webhook" => route('flutterwaveTestWebhook'),
                "name" => Auth::user()->name,
                "phone" => Auth::user()->phone,
                "email" => Auth::user()->email,
                "title" => "Test Payment",
                "description" => "Admin test payment "];

            $payment = $flutterewave->PayNow($payment_info, $data['test_amount']);

            if ($payment->status == 'success') {
                return redirect()->to($payment->data->link);
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return back();
            }
        } elseif ($data['method'] == 'Coinbase') {

            $coinbase = new CoinbaseRepository();
            $payment_info = [
                "name" => "Test Payment",
                "description" => "Test payment for coinbase account",
                "currency" => "USD",
                "charge_type" => "test"


            ];
            $result = $coinbase->makePayment($payment_info, $data['test_amount']);

            session()->get('pay_from', 'test_payment');
            session()->get('charge_id', $result['data']['id'] ?? '');


            if (isset($result['data']) && isset($result['data']['hosted_url'])) {
                return redirect()->to($result['data']['hosted_url']);
            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                return back();
            }
        } elseif ($data['method'] == 'Jazz Cash') {
            try {
                $jazz = new JazzcashRepository();
                $payment_info = [
                    "billref" => time(),
                    "description" => "Test Payment",
                    "email" => Auth::user()->email,
                    "mobile" => Auth::user()->phone,
                ];
                $result = $jazz->getArray($payment_info, $data['test_amount']);
                $post_url = $jazz->getPostUrl();
                return view('jazzcash::payment', compact('post_url'));
            } catch (Exception $e) {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                return back();
            }
        } elseif ($data['method'] == 'CCAvenue') {
            $ccavenue = new CCAvenue();
          return $ccavenue->prepare('test', $data['test_amount']);
        } elseif ($data['method'] == 'Tranzak') {

            $paymentData = [
                'amount' => $request->test_amount,
                'currencyCode' => Settings('currency_code'),
                'description' => 'Test',
                'mchTransactionRef' => 'Test|' . $request->test_amount,
            ];
            $service = new TranzakService();
            $payment_url = $service->paymentRequest($paymentData);
            if ($payment_url) {
                \redirect($payment_url)->send();
            } else {
                return back();
            }
        } elseif ($data['method'] == 'TapPayment') {
            (new TapPaymentController())->charge([
                'amount' => $data['test_amount'],
                'type' => 'test',
                'currency' => Settings('currency_code'),
                'user_id' => Auth::id(),
                "customer" => [
                    "first_name" => "test",
                    "email" => "test@test.com",
                ],
            ]);
                            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

            return redirect()->back();
        }elseif ($data['method'] == 'AstraPay') {

            $service = new AstraPayService();
             $service->paymentRequest([
                 'amount' => $request->test_amount,
                 'currency' => Settings('currency_code'),
                 'description' => 'Test',
             ]);

        }
        elseif ($data['method'] == 'Bkash') {

            $service = new BkashService();
             $service->paymentRequest([
                 'amount' => $request->test_amount,
                 'currency' => Settings('currency_code'),
                 'description' => 'Test',
             ]);

        }
 return back();

    }

    public function test()
    {
        $payment_methods = PaymentMethod::where('module_status', '=', 1)
            ->where('method', '!=', 'Wallet')
            ->where('method', '!=', 'Bank Payment')
            ->where('method', '!=', 'Offline Payment')->get(['method', 'logo']);
        return view('paymentmethodsetting::test', compact('payment_methods'));
    }

    public function paypalTestSuccess(Request $request)
    {

        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->payPalGateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                return redirect()->route('paymentmethodsetting.test');
            } else {
                $msg = str_replace("'", " ", $response->getMessage());
                Toastr::error($msg, trans('common.Failed'));
                return redirect()->route('paymentmethodsetting.test');
            }
        } else {
            Toastr::error(trans('frontend.Transaction is declined'));
            return redirect()->route('paymentmethodsetting.test');
        }


    }

    public function paypalTestFailed()
    {
        Toastr::error(trans('frontend.User is canceled the payment'), trans('common.Failed'));
        return redirect()->route('paymentmethodsetting.test');
    }


    public function recurring()
    {
//        $pay = new RazerMSPlanController();
//        $pay->getPlanList();

        $pay = new RazerMSController();
        $result = $pay->recurring();

//        return $result;
    }
}
