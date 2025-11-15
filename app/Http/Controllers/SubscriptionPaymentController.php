<?php

namespace App\Http\Controllers;

use App\BillingDetails;
use App\Events\OneToOneConnection;
use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Bryceandy\Laravel_Pesapal\Facades\Pesapal;
use DrewM\MailChimp\MailChimp;
use Exception;
use GetResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Modules\Affiliate\Events\ReferralPayment;
use Modules\AuthorizeNet\Repositories\AuthorizeNetRepository;
use Modules\Bkash\Services\BkashService;
use Modules\Braintree\Repositories\BraintreeRepository;
use Modules\CCAvenue\Libraries\CCAvenue;
use Modules\Coinbase\Repositories\CoinbaseRepository;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Flutterwave\Repositories\FlutterwaveRepository;
use Modules\Instamojo\Http\Controllers\InstamojoController;
use Modules\JazzCash\Repositories\JazzcashRepository;
use Modules\MercadoPago\Http\Controllers\MercadoPagoController;
use Modules\Midtrans\Http\Controllers\MidtransController;
use Modules\Mollie\Repositories\MollieRepository;
use Modules\Payeer\Http\Controllers\PayeerController;
use Modules\Payment\Entities\InstructorPayout;
use Modules\Paytm\Http\Controllers\PaytmController;
use Modules\RazerMS\Http\Controllers\RazerMSController;
use Modules\Razorpay\Http\Controllers\RazorpayController;
use Modules\Sslcommerz\Http\Controllers\SslcommerzController;
use Modules\Subscription\Entities\CourseSubscription;
use Modules\Subscription\Entities\SubscriptionCart;
use Modules\Subscription\Entities\SubscriptionCheckout;
use Modules\Subscription\Entities\SubscriptionCourseList;
use Modules\Subscription\Entities\SubscriptionSetting;
use Modules\TapPayment\Http\Controllers\TapPaymentController;
use Modules\Tranzak\Services\TranzakService;
use Modules\Wallet\Http\Controllers\WalletController;
use Omnipay\Omnipay;
use Unicodeveloper\Paystack\Facades\Paystack;
use function redirect;

class SubscriptionPaymentController extends Controller
{
    use SendNotification;

    public $payPalGateway;
    public $allow;


    public function __construct()
    {
        $this->middleware(['maintenanceMode', 'onlyAppMode']);

        $this->payPalGateway = Omnipay::create('PayPal_Rest');
        $this->payPalGateway->setClientId(getPaymentEnv('PAYPAL_CLIENT_ID'));
        $this->payPalGateway->setSecret(getPaymentEnv('PAYPAL_CLIENT_SECRET'));
        $this->payPalGateway->setTestMode(getPaymentEnv('IS_PAYPAL_LOCALHOST') == 'true');
    }

    public function subscriptionSubmit(Request $request)
    {
        if (!Auth::check()) {
            Toastr::error(trans('frontend.You must login'), trans('common.Error'));
            $this->allow = false;
            return redirect()->to('/');
        }


        $cart = SubscriptionCart::where('user_id', Auth::user()->id)->first();
        if (!$cart) {
            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
            return redirect()->route('courseSubscription');
        }
        $checkout = SubscriptionCheckout::where('tracking', $cart->tracking)->first();

        if (Settings('hide_multicurrency') == 1) {
            if ($checkout) {
                $price = (float)number_format(convertCurrency(auth()->user()->currency->code ?? Settings('currency_code'), Settings('currency_code'), $checkout->purchase_price), 2);
            } else {
                $price = (float)number_format(convertCurrency(auth()->user()->currency->code ?? Settings('currency_code'), Settings('currency_code'), $cart->price), 2);
            }

        } else {
            if ($checkout) {
                $price = $checkout->purchase_price;
            } else {
                $price = $cart->price;
            }
        }

        try {
            if ($request->payment_method == "Sslcommerz") {
                try {
                    $userData = [
                        'user' => Auth::user()->name,
                        'mobile' => Auth::user()->phone,
                        'email' => Auth::user()->email,
                        'amount' => $price,
                        'order' => uniqid() . "_" . rand(1, 1000),
                    ];

                    $sslc = new SslcommerzController();
                    $sslc->subscription($userData);

                } catch (Exception $e) {

                    Toastr::error($e->getMessage(), trans('common.Failed'));
                    return redirect()->route('courseSubscriptionCheckout');
                }

            } elseif ($request->payment_method == "RazerMS") {
                try {
                    $payment = new RazerMSController();
                    $url = $payment->generatePaymentUrl($price, 'subscription');
                    return redirect($url);
                } catch (Exception $e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

                }
            } elseif ($request->payment_method == "TapPayment") {
                try {
                    (new TapPaymentController())->charge([
                        'amount' => $price,
                        'type' => 'subscription',
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
            } elseif ($request->payment_method == "Payeer") {

                try {
                    $payeer = new PayeerController();
                    $request->merge(['type' => 'Subscription']);
                    $request->merge(['amount' => $price]);
                    $response = $payeer->makePayment($request);

                    if ($response) {
                        return redirect()->to($response);
                    } else {
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                        return redirect()->back();
                    }
                } catch (Exception$e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

                }

            } elseif ($request->payment_method == "Midtrans") {

                try {
                    $midtrans = new MidtransController();
                    $request->merge(['type' => 'Subscription']);
                    $request->merge(['amount' => $price]);
                    $response = $midtrans->makePayment($request);

                    if ($response) {
                        return $response;
                    } else {
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                        return redirect()->back();
                    }
                } catch (Exception $e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

                }


            } elseif ($request->payment_method == "Pesapal") {

                try {
                    $paymentData = [
                        'amount' => $price,
                        'currency' => Settings('currency_code'),
                        'description' => 'Subscription',
                        'type' => 'MERCHANT',
                        'reference' => 'Subscription|'.md5(time()).'|' . $price,
                        'first_name' => Auth::user()->first_name,
                        'last_name' => Auth::user()->last_name,
                        'email' => Auth::user()->email,
                    ];

                    $iframe_src = Pesapal::getIframeSource($paymentData);

                    return view('laravel_pesapal::iframe', compact('iframe_src'));
                } catch (Exception $e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
                }

            } elseif ($request->payment_method == "PayPal") {

                try {
                    $response = $this->payPalGateway->purchase(array(
                        'amount' => $price,
                        'currency' => Settings('currency_code'),
                        'returnUrl' => route('paypalSubscriptionSuccess'),
                        'cancelUrl' => route('paypalSubscriptionFailed'),

                    ))->send();
                    if ($response->isRedirect()) {
                        $response->redirect(); // this will automatically forward the customer
                    } else {
                        Toastr::error($response->getMessage(), trans('common.Failed'));
                        return redirect()->route('courseSubscriptionCheckout');
                    }
                } catch (Exception $e) {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return redirect()->route('courseSubscriptionCheckout');
                }

            } //paypel payment getaway
            elseif ($request->payment_method == "Stripe") {

                $request->validate([
                    'stripeToken' => 'required'
                ]);
                $token = $request->stripeToken ?? '';
                $gatewayStripe = Omnipay::create('Stripe');
                $gatewayStripe->setApiKey(getPaymentEnv('STRIPE_SECRET'));

                $response = $gatewayStripe->purchase(array(
                    'amount' => $price,
                    'currency' => Settings('currency_code'),
                    'token' => $token,
                ))->send();

                if ($response->isRedirect()) {
                    // redirect to offsite payment gateway
                    $response->redirect();
                } elseif ($response->isSuccessful()) {
                    // payment was successful: update database

                    $payWithStripe = $this->payWithGateWay($response->getData(), "Stripe");
                    if ($payWithStripe) {
                        Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                        if (currentTheme() == 'tvt') {
                            return redirect('/');
                        } else {
                            return redirect(route('studentDashboard'));
                        }
                    } else {
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                        return redirect()->route('courseSubscriptionCheckout');
                    }
                } else {

                    if ($response->getCode() == "amount_too_small") {
                        $amount = round(convertCurrency(Settings('currency_code'), strtoupper(Settings('currency_code') ?? 'BDT'), 0.5));
                        $message = "Amount must be at least " . Settings('currency_symbol') . ' ' . $amount;
                        Toastr::error($message, trans('common.Error'));
                    } else {
                        Toastr::error($response->getMessage(), trans('common.Error'));
                    }
                    return redirect()->back();
                }


            } //payment getway
            elseif ($request->payment_method == "RazorPay") {

                if (empty($request->razorpay_payment_id)) {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return redirect()->route('courseSubscriptionCheckout');
                }

                $payment = new RazorpayController();
                $response = $payment->payment($request->razorpay_payment_id);

                if ($response['type'] == "error") {
                    Toastr::error($response['message'], trans('common.Error'));
                    return redirect()->route('courseSubscriptionCheckout');
                }

                $payWithRazorPay = $this->payWithGateWay($response['response'], "RazorPay");

                if ($payWithRazorPay) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (currentTheme() == 'tvt') {
                        return redirect('/');
                    } else {
                        return redirect(route('studentDashboard'));
                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return redirect()->route('courseSubscriptionCheckout');
                }


            } //payment getway
            elseif ($request->payment_method == "PayTM") {


                $userData = [
                    'user' => Auth::user()->name,
                    'mobile' => Auth::user()->phone,
                    'email' => Auth::user()->email,
                    'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $price),
                    'order' => uniqid() . "_" . rand(1, 1000),
                ];

                $payment = new PaytmController();
                return $payment->subscription($userData);


            } elseif ($request->payment_method == "Instamojo") {

                $amount = $price;
                $instamojo = new InstamojoController();
                $response = $instamojo->subscriptionProcess($amount);
                if ($response) {
                    return redirect()->to($response);
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return redirect()->back();
                }

            } elseif ($request->payment_method == "MercadoPago") {
                $mercadoPagoController = new MercadoPagoController();
                $response = $mercadoPagoController->payment($request->all());
                return response()->json(['target_url' => $response]);
            } elseif ($request->payment_method == "PayStack") {

                try {
                    return Paystack::getAuthorizationUrl()->redirectNow();

                } catch (Exception $e) {
                    Toastr::error(trans('frontend.Currency not supported by merchant'), trans('common.Failed'));
                    return redirect()->route('courseSubscriptionCheckout');
                }


            } elseif ($request->payment_method == 'CCAvenue') {
                $ccavenue = new CCAvenue();
                return $response = $ccavenue->prepare('subscription', $price);
            } elseif ($request->payment_method == 'Tranzak') {

                $paymentData = [
                    'amount' => $price,
                    'currencyCode' => Settings('currency_code'),
                    'description' => 'Subscription',
                    'mchTransactionRef' => 'Subscription|' . $price,
                ];
                $service = new TranzakService();
                $payment_url = $service->paymentRequest($paymentData);
                if ($payment_url) {
                    redirect($payment_url)->send();
                } else {
                    return back();
                }
            }elseif ($request->payment_method == 'Bkash') {

                $paymentData = [
                    'amount' => $price,
                    'currencyCode' => Settings('currency_code'),
                    'description' => 'Subscription',
                ];
                $service = new BkashService();
                $payment_url = $service->paymentRequest($paymentData);
                if ($payment_url) {
                    redirect($payment_url)->send();
                } else {
                    return back();
                }
            } elseif ($request->payment_method == "Wallet") {
                $payment = new WalletController();
                $request->merge(['price'=>$price]);
                $response = $payment->subscription($request);

                if ($response['type'] == "error") {
                    Toastr::error($response['message'], trans('common.Error'));
                    return redirect()->to('course/subscription');
                }

                $payWithWallet = $this->payWithGateWay($response['response'], "Wallet");

                if ($payWithWallet) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (currentTheme() == 'tvt') {
                        return redirect('/');
                    } else {
                        return redirect(route('studentDashboard'));
                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return redirect()->to('course/subscription');
                }

            } elseif ($request->payment_method == 'Mollie') {
                $mollie = new MollieRepository();
                $payment_info = [
                    'success_url' => route('mollieSubscriptionSuccess'),
                    "order_id" => time(),
                    "amount" => $price,
                    "details" => "Subscription Payment",
                ];
                $result = $mollie->preparePayment($payment_info);
                session()->put('mollie_id', $result->id);
                return redirect($result->getCheckoutUrl(), 303);
            } elseif ($request->payment_method == 'Jazz Cash') {
                try {
                    $jazz = new JazzcashRepository();
                    $payment_info = [
                        "billref" => time(),
                        "description" => "Subscription Payment",
                        "email" => Auth::user()->email,
                        "mobile" => Auth::user()->phone,
                    ];
                    $result = $jazz->getArray($payment_info, $price);
                    $post_url = $jazz->getPostUrl();
                    session()->put('from', 'subscription');
                    return view('jazzcash::payment', compact('post_url'));
                } catch (Exception $e) {
                    Toastr::error($e->getMessage(), trans('common.Error'));
                    return back();
                }
            } elseif ($request->payment_method == 'Coinbase') {
                $coinbase = new CoinbaseRepository();
                $payment_info = [
                    "name" => "Subscrption Payment",
                    "description" => "Payment for subscription",
                    "currency" => "USD",
                    "charge_type" => "subscription"

                ];
                $result = $coinbase->makePayment($payment_info, $price);

                session()->get('pay_from', 'subscription');
                session()->get('charge_id', $result['data']['id']);


                if (isset($result['data']) && isset($result['data']['hosted_url'])) {
                    return redirect()->to($result['data']['hosted_url']);
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return back();
                }
            } elseif ($request->payment_method == "Wallet") {


                $payment = new WalletController();
                $response = $payment->subscription($request);

                if ($response['type'] == "error") {
                    Toastr::error($response['message'], trans('common.Error'));
                    return redirect()->route('courseSubscriptionCheckout');
                }

                $payWithWallet = $this->payWithGateWay($response['response'], "Wallet");

                if ($payWithWallet) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (currentTheme() == 'tvt') {
                        return redirect('/');
                    } else {
                        return redirect(route('studentDashboard'));
                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return redirect()->route('courseSubscriptionCheckout');
                }

            } elseif ($request->payment_method == 'Authorize.Net') {
                $authorize = new AuthorizeNetRepository();
                $response = $authorize->payNow($request, $price);
                if ($response != null) {
                    if ($response->getMessages()->getResultCode() == "Ok") {
                        $tresponse = $response->getTransactionResponse();
                        if ($tresponse != null && $tresponse->getMessages() != null) {
                            $payWithAuthor = $this->payWithGateWay($response, "Authorize.Net");
                            if ($payWithAuthor) {
                                Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                                if (currentTheme() == 'tvt') {
                                    return redirect('/');
                                } else {
                                    return redirect(route('studentDashboard'));
                                }
                            } else {
                                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                                return redirect()->route('courseSubscriptionCheckout');
                            }

                        } else {
                            $msg =trans('frontend.There were some issue with the payment. Please try again later');
                            if ($tresponse->getErrors() != null) {
                                $msg = $tresponse->getErrors()[0]->getErrorText();
                            }
                            Toastr::error($msg, trans('common.Error'));
                            return redirect(route('courseSubscriptionCheckout'));
                        }
                    } else {
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                        return redirect(route('courseSubscriptionCheckout'));
                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return redirect(route('courseSubscriptionCheckout'));
                }
            } elseif ($request->payment_method == 'Braintree') {
                $braintree = new BraintreeRepository();
                $result = $braintree->payNow($request, $price);

                if ($result->success) {
                    $payWithBrain = $this->payWithGateWay($result, "Braintree");

                    if ($payWithBrain) {
                        Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                        return redirect(route('studentDashboard'));
                    } else {
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                        return redirect(route('courseSubscriptionCheckout'));
                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return redirect(route('courseSubscriptionCheckout'));
                }
            } elseif ($request->payment_method == 'Flutterwave') {
                $flutterwave = new FlutterwaveRepository();
                $pay_info = [
                    "name" => Auth::user()->name,
                    "phone" => Auth::user()->phone,
                    "email" => Auth::user()->email,
                    "title" => "Subscription Payment",
                    "description" => "Payment for Course Subscription",
                    "webhook" => route('flutterwaveSubscriptionWebhook')
                ];
                $payment = $flutterwave->payNow($pay_info, $price);
                if ($payment->status == 'success') {
                    return redirect()->to($payment->data->link);
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return back();
                }
            }


        } catch (Exception $e) {

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }


    }

    public function payWithGateWay($response, $gateWayName)
    {
        try {
            DB::beginTransaction();
            if (Auth::check()) {
                $user = Auth::user();
                $cart = SubscriptionCart::where('user_id', $user->id)->first();

                if ($cart) {
                    $plan = SubscriptionCart::where('plan_id', $cart->plan_id)->first();
                    $bill = BillingDetails::where('id', $cart->billing_detail_id)->first();
                     if (!$bill) {
                        Toastr::error(trans('frontend.Billing address not found'), trans('common.Error'));
                        return false;
                    }
                    if ($plan) {
                        $start_date = Carbon::now();
                        $end_date = $start_date->addDays($plan->days);
                        $subCheckout = SubscriptionCheckout::where('tracking', $cart->tracking)->first();


                        $subCheckout->billing_detail_id = $bill->id;
                        $subCheckout->tracking = $bill->tracking_id;
                        $subCheckout->start_date = Carbon::now();
                        $subCheckout->end_date = $end_date;
                        $subCheckout->days = $plan->days;
                        $subCheckout->payment_method = $gateWayName;
                        $subCheckout->status = 1;
                        $subCheckout->response = json_encode($response);
                        $subCheckout->save();

                        $subscripitonPayment = new SubscriptionPaymentController();
                        $subscripitonPayment->coursesEnrollBySubscription($cart->plan_id);
                        //    $payment= $subscripitonPayment->coursesEnrollBySubscription($cart->plan_id);

                        //payment confirm
                        if ($subCheckout->price > 0) {
                            $notificationTemplate = 'Payment_Done';
                            $notificationTemplateData = [
                                'name' => $user->name,
                                'amount' => $subCheckout->price,
                                'txn_id' => $subCheckout->tracking,
                                'payment_date' => showDate(\Carbon\Carbon::now()),
                            ];

                            $this->sendNotification($notificationTemplate, $user, $notificationTemplateData);
                        }

                        if (isModuleActive('Affiliate')) {
                            if ($user->isReferralUser) {
                                Event::dispatch(new ReferralPayment($user->id, $plan->plan_id, $subCheckout->price,'subscription'));
                            }
                        }
                        Toastr::success(trans('frontend.Checkout Successfully Done'), trans('common.Success'));

                        $user->subscription_validity_date = $end_date;
                        $user->save();
                        $plan->delete();


                        DB::table('course_enrolleds')
                            ->where('subscription', '=', 1)
                            ->where('user_id', $user->id)
                            ->update(['subscription_validity_date' => $end_date]);

                        DB::commit();

                        return true;

                    } else {
                        DB::rollBack();
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                        return false;
                    }
                } else {
                    DB::rollBack();
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return false;
                }


            } else {
                DB::rollBack();
                Toastr::error(trans('frontend.You must login'), trans('common.Error'));
                return false;
            }


        } catch (Exception $e) {
            DB::rollBack();
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());


        }
    }

    public function coursesEnrollBySubscription($plan_id)
    {

        try {
            $setting = SubscriptionSetting::getData();
            $plan = CourseSubscription::find($plan_id);

            $ids = [];
            if ($setting->type == 2) {

                $courses_ids = SubscriptionCourseList::Where('plan_id', $plan_id)->select('course_id')->get();
                foreach ($courses_ids as $courses_id) {
                    $ids[] = $courses_id['course_id'];
                }
            } else {
                $courses_ids = Course::where('status', 1)->select('id')->get();
                foreach ($courses_ids as $courses_id) {
                    $ids[] = $courses_id['id'];
                }
            }

            if ($ids) {

                //enroll start
                $user = Auth::user();
                foreach ($ids as $course_id) {

                    $course = Course::findOrFail($course_id);
                    $instractor = User::findOrFail($course->user_id);
                    $check = CourseEnrolled::where('user_id', $user->id)->where('course_id', $course_id)->first();
                    if (!$check) {

                        $enrolled = $course->total_enrolled;
                        $course->total_enrolled = ($enrolled + 1);
                        $enrolled = new CourseEnrolled();
                        $enrolled->user_id = $user->id;
                        $enrolled->course_id = $course_id;

                        if (isModuleActive('Subscription')) {
                            if (isSubscribe()) {
                                $enrolled->subscription = 1;
                                $enrolled->subscription_validity_date = $user->subscription_validity_date;
                            }
                        }

                        $enrolled->save();

                        $plan_price = $plan->price;

                        $itemPrice = $plan_price / count($ids);
                        $enrolled->purchase_price = $itemPrice;

                        if (!is_null($course->special_commission) && $course->special_commission != 0) {
                            $commission = $course->special_commission;
                            $reveune = ($itemPrice * $commission) / 100;
                            $enrolled->reveune = $reveune;
                        } elseif (!is_null($instractor->special_commission) && $instractor->special_commission != 0) {
                            $commission = $instractor->special_commission;
                            $reveune = ($itemPrice * $commission) / 100;
                            $enrolled->reveune = $reveune;
                        } else {
                            $commission = 100 - Settings('commission');
                            $reveune = ($itemPrice * $commission) / 100;
                            $enrolled->reveune = $reveune;
                        }
                        $payout = new InstructorPayout();
                        $payout->instructor_id = $course->user_id;
                        $payout->reveune = $reveune;
                        $payout->status = 0;
                        $payout->save();


                        $enrolled->save();

                        if (isModuleActive('Cashback')) {
                            $course = Course::find($course_id);
                            generateCashback(Auth::user()->id, $enrolled->purchase_price, 'subscription', $course, $enrolled, $plan_price);
                        }
                        $course->reveune = (($course->reveune) + ($enrolled->reveune));

                        $course->save();

                        if (isModuleActive('Chat')) {
                            event(new OneToOneConnection($instractor, $user, $course));
                        }

                        //start email subscription
                        if ($instractor->subscription_api_status == 1) {
                            try {
                                if ($instractor->subscription_method == "Mailchimp") {
                                    $list = $course->subscription_list;
                                    $MailChimp = new MailChimp($instractor->subscription_api_key);
                                    $MailChimp->post("lists/$list/members", [
                                        'email_address' => Auth::user()->email,
                                        'status' => 'subscribed',
                                    ]);

                                } elseif ($instractor->subscription_method == "GetResponse") {

                                    $list = $course->subscription_list;
                                    $getResponse = new GetResponse($instractor->subscription_api_key);
                                    $getResponse->addContact(array(
                                        'email' => Auth::user()->email,
                                        'campaign' => array('campaignId' => $list),

                                    ));
                                }
                            } catch (Exception $exception) {
                                GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);

                            }
                        }

                    }

                }


            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function payment(Request $request)
    {

        $rules = [
            'old_billing' => 'required_if:billing_address,previous',
            'first_name' => 'required_if:billing_address,new',
             'country' => 'required_if:billing_address,new',
             'phone' => 'required_if:billing_address,new',
            'email' => 'required_if:billing_address,new',
        ];
        $this->validate($request, $rules, validationMessage($rules));


        try {
            $data = [];
            if (currentTheme() != 'tvt') {
                $data['plan'] = CourseSubscription::where('id', $request->plan_id)->first();
                if (!$data['plan']) {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return redirect()->route('courseSubscription');
                }

                $data['cart'] = SubscriptionCart::where('user_id', Auth::user()->id)->with('plan')->first();

                if (!$data['cart']) {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return redirect()->route('courseSubscription');
                }
            }



            if ($request->billing_address == 'new') {
                $bill = BillingDetails::where('tracking_id', $request->tracking_id)->first();

                if (empty($bill)) {
                    $bill = new BillingDetails();
                    $bill->tracking_id = $data['cart']->tracking ?? "";
                    $bill->user_id = Auth::id();
                }


                $bill->first_name = $request->first_name;
                $bill->last_name = $request->last_name;
                $bill->company_name = $request->company_name;
                $bill->country = $request->country;
                $bill->address1 = $request->address1;
                $bill->address2 = $request->address2;
                $bill->city = $request->city;
                $bill->state = $request->state;
                $bill->zip_code = $request->zip_code;
                $bill->phone = $request->phone;
                $bill->email = $request->email;
                $bill->details = $request->details;
                $bill->payment_method = null;
                $bill->save();
            } else {
                $bill = BillingDetails::where('id', $request->old_billing)->first();
            }

            return view(theme('pages.subscriptionPayment'), $data, compact('bill'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function paypalSubscriptionSuccess(Request $request)
    {


        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->payPalGateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                // The customer has successfully paid.
                $arr_body = $response->getData();
                $payWithPapal = $this->payWithGateWay($arr_body, "PayPal");
                if ($payWithPapal) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (currentTheme() == 'tvt') {
                        return redirect('/');
                    } else {
                        return redirect(route('studentDashboard'));
                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    if (currentTheme() == 'tvt') {
                        return redirect('/');
                    } else {
                        return redirect(route('studentDashboard'));
                    }
                }

            } else {
                $msg = str_replace("'", " ", $response->getMessage());
                Toastr::error($msg, trans('common.Error',));
                return redirect()->back();
            }
        } else {
            Toastr::error(trans('frontend.Transaction is declined'),trans('common.Error'));
            return redirect()->back();
        }


    }

    public function paypalSubscriptionFailed()
    {
        Toastr::error(trans('frontend.User is canceled the payment'), trans('common.Error'));
        return redirect()->back();
    }


}
