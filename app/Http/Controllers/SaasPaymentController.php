<?php

namespace App\Http\Controllers;

use App\BillingDetails;
use App\Traits\SendNotification;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\LmsSaas\Entities\SaasCart;
use Modules\LmsSaas\Entities\SaasCheckout;
use Modules\LmsSaas\Entities\SaasInstitutePlanManagement;
use Modules\LmsSaas\Entities\SaasInstitutePlanPurchase;
use Modules\LmsSaas\Entities\SaasPlan;
use Modules\LmsSaasMD\Entities\SaasCart as SaasCartMD;
use Modules\LmsSaasMD\Entities\SaasCheckout as SaasCheckoutMD;
use Modules\LmsSaasMD\Entities\SaasInstitutePlanManagement as SaasInstitutePlanManagementMD;
use Modules\LmsSaasMD\Entities\SaasInstitutePlanPurchase as SaasInstitutePlanPurchaseMD;
use Modules\LmsSaasMD\Entities\SaasPlan as SaasPlanMD;
use Modules\MercadoPago\Http\Controllers\MercadoPagoController;
use Modules\Paytm\Http\Controllers\PaytmController;
use Modules\Razorpay\Http\Controllers\RazorpayController;
use Modules\Wallet\Http\Controllers\WalletController;
use Omnipay\Omnipay;
use Unicodeveloper\Paystack\Facades\Paystack;

class SaasPaymentController extends Controller
{
    use SendNotification;

    public $payPalGateway;
    public $allow;


    public function __construct()
    {
        $this->middleware(['maintenanceMode', 'onlyAppMode']);

        $this->allow = true;


        $this->payPalGateway = Omnipay::create('PayPal_Rest');
        $this->payPalGateway->setClientId(getMainPaymentEnv('PAYPAL_CLIENT_ID'));
        $this->payPalGateway->setSecret(getMainPaymentEnv('PAYPAL_CLIENT_SECRET'));
        $this->payPalGateway->setTestMode(getMainPaymentEnv('IS_PAYPAL_LOCALHOST') == 'true'); //set it to 'false' when go live


    }


    public function payment(Request $request)
    {
        if (isModuleActive('LmsSaas')) {
            $plan = SaasPlan::on(config('database.default'))->where('id', $request->plan_id)->first();
        } else {
            $plan = SaasPlanMD::on(config('database.default'))->where('id', $request->plan_id)->first();
        }
        if (!$plan) {
            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
            return \redirect()->route('saasPackages');
        }

        if (isModuleActive('LmsSaas')) {

            $cart = SaasCart::on(config('database.default'))->where('user_id', Auth::user()->id)->with('plan')->first();
        } else {
            $cart = SaasCartMD::on(config('database.default'))->where('user_id', Auth::user()->id)->with('plan')->first();

        }


        if (!$cart) {
            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
            return \redirect()->route('saasPackages');
        }

        $rules = [
            'old_billing' => 'required_if:billing_address,previous',
            'first_name' => 'required_if:billing_address,new',
            'last_name' => 'required_if:billing_address,new',
            'country' => 'required_if:billing_address,new',
            'address1' => 'required_if:billing_address,new',
            'city' => 'required_if:billing_address,new',
            'phone' => 'required_if:billing_address,new',
            'email' => 'required_if:billing_address,new',
        ];
        $this->validate($request, $rules, validationMessage($rules));
        try {
// return $request;


            if ($request->billing_address == 'new') {
                $bill = BillingDetails::where('tracking_id', $request->tracking_id)->first();

                if (empty($bill)) {
                    $bill = new BillingDetails();
                    $bill->tracking_id = $cart->tracking;
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
                $bill = BillingDetails::on(config('database.default'))->where('id', $request->old_billing)->first();
            }
            if ($cart->price == 0) {
                $this->payWithGateWay(null, "None");
                return redirect()->to('home');
            }


            return view(theme('pages.saasPayment'), compact('plan', 'cart', 'bill'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function subscriptionSubmit(Request $request)
    {
        if (!Auth::check()) {
            Toastr::error(trans('frontend.You must login'), trans('common.Error'));;

             $this->allow = false;
            return redirect()->back();
        }

        if (demoCheck()) {
            return redirect()->back();
        }
        if (!$this->allow) {
            return redirect()->back();
        }


        if (isModuleActive('LmsSaas')) {

            $cart = SaasCart::where('user_id', Auth::user()->id)->first();
        } else {
            $cart = SaasCartMD::where('user_id', Auth::user()->id)->first();

        }

        if (!$cart) {
            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
            return redirect()->route('saasPackages');
        }
        try {
            if ($request->payment_method == "Sslcommerz") {


            } elseif ($request->payment_method == "PayPal") {


                try {
                    $response = $this->payPalGateway->purchase(array(
                        'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', 'USD', $cart->price),
                        'currency' => Settings('currency_code'),
                        'returnUrl' => route('paypalSaasSuccess'),
                        'cancelUrl' => route('paypalSaasFailed'),

                    ))->send();


                    if ($response->isRedirect()) {
                        $response->redirect(); // this will automatically forward the customer
                    } else {
                        Toastr::error($response->getMessage(), trans('common.Failed'));
                        return redirect()->route('saasCheckout');
                    }
                } catch (\Exception $e) {

                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return redirect()->route('saasCheckout');
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
                    'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', 'USD', $cart->price),
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
                        return redirect(route('saas.myPlan'));
                    } else {
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                        return redirect()->route('saasCheckout');
                    }
                } else {

                    if ($response->getCode() == "amount_too_small") {
                        $amount = round(convertCurrency('USD', strtoupper(Settings('currency_code') ?? 'BDT'), 0.5));
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
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return redirect()->route('saasCheckout');
                }

                $payment = new RazorpayController();
                $response = $payment->payment($request->razorpay_payment_id);

                if ($response['type'] == "error") {
                    Toastr::error($response['message'], trans('common.Error'));
                    return redirect()->route('saasCheckout');
                }

                $payWithRazorPay = $this->payWithGateWay($response['response'], "RazorPay");

                if ($payWithRazorPay) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    return redirect(route('saas.myPlan'));
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return redirect()->route('saasCheckout');
                }


            } //payment getway
            elseif ($request->payment_method == "PayTM") {


                $userData = [
                    'user' => Auth::user()->name,
                    'mobile' => Auth::user()->phone,
                    'email' => Auth::user()->email,
                    'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $cart->price),
                    'order' => uniqid() . "_" . rand(1, 1000),
                ];

                $payment = new PaytmController();
                return $payment->subscription($userData);


            } //payment getway


            elseif ($request->payment_method == "PayStack") {


                try {
                    return Paystack::getAuthorizationUrl()->redirectNow();

                } catch (\Exception $e) {
                    Toastr::error(trans('frontend.Currency not supported by merchant'), trans('common.Failed'));
                    return redirect()->route('saasCheckout');
                }


            } elseif ($request->payment_method == "MercadoPago") {
                $mercadoPagoController = new MercadoPagoController();
                $response = $mercadoPagoController->payment($request->all());
                return response()->json(['target_url' => $response]);
            } elseif ($request->payment_method == "Wallet") {


                $payment = new WalletController();
                $response = $payment->saasPlan($request);

                if ($response['type'] == "error") {
                    Toastr::error($response['message'], trans('common.Error'));
                    return redirect()->route('saasCheckout');
                }

                $payWithWallet = $this->payWithGateWay($response['response'], "Wallet");
                if ($payWithWallet) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    return redirect(route('saas.myPlan'));
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return redirect()->route('saasCheckout');
                }

            }
        } catch (\Exception $e) {
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
                    return redirect(route('saas.myPlan'));
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return redirect(route('saas.myPlan'));
                }

            } else {
                $msg = str_replace("'", " ", $response->getMessage());
                Toastr::error($msg, trans('common.Error'));
                return redirect()->back();
            }
        } else {
            Toastr::error(trans('frontend.Transaction is declined',trans('common.Error')));
            return redirect()->back();
        }


    }

    public function paypalSubscriptionFailed()
    {
        Toastr::error(trans('frontend.User is canceled the payment'), trans('common.Error'));
        return redirect()->back();
    }

    public   function payWithGateWay($response, $gateWayName)
    {

        try {

            if (Auth::check()) {
                $user = Auth::user();
                if (isModuleActive('LmsSaas')) {

                    $cart = SaasCart::where('user_id', $user->id)->first();
                } else {
                    $cart = SaasCartMD::where('user_id', $user->id)->first();

                }
                if ($cart) {
                    if (isModuleActive('LmsSaas')) {

                        $plan = SaasCart::where('plan_id', $cart->plan_id)->first();
                    } else {
                        $plan = SaasCartMD::where('plan_id', $cart->plan_id)->first();

                    }
                    $bill = BillingDetails::where('id', $cart->billing_detail_id)->first();

                    if (!$bill) {
                        $bill = BillingDetails::where('user_id', Auth::user()->id)->first();;
//                        Toastr::error('Billing address not found', trans('common.Error'));
//                        return false;
                    }

                    if ($plan) {
                        $start_date = Carbon::now();
                        $end_date = $start_date->addDays($plan->days);
                        if (isModuleActive('LmsSaas')) {
                            $subCheckout = SaasCheckout::where('tracking', $cart->tracking)->first();
                        } else {
                            $subCheckout = SaasCheckoutMD::where('tracking', $cart->tracking)->first();

                        }

                        if (!$subCheckout) {
                            if (isModuleActive('LmsSaas')) {
                                $subCheckout = new SaasCheckout();
                            } else {
                                $subCheckout = new SaasCheckoutMD();
                            }
                        }
                        if (isModuleActive('LmsSaas')) {
                            $user_id = $user->id;
                        } else {
                            $user_id = SaasInstitute()->user_id;
                        }
                        $subCheckout->user_id = $user_id;

                        $subCheckout->plan_id = $plan->plan_id;
                        $subCheckout->price = $plan->price;
                        $subCheckout->billing_detail_id = $bill->id;
                        $subCheckout->tracking = $bill->tracking_id;
                        $subCheckout->start_date = Carbon::now();
                        $subCheckout->end_date = $end_date;
                        $subCheckout->days = $plan->days;
                        $subCheckout->payment_method = $gateWayName;
                        $subCheckout->status = 1;
                        $subCheckout->lms_id = Auth::user()->lms_id;
                        $subCheckout->response = json_encode($response);
                        $subCheckout->save();

                        $subscripitonPayment = new SaasPaymentController();
                        $subscripitonPayment->saasPlanPurchaseRecord($cart->plan_id, $subCheckout);


                        //payment confirm
                        if ($plan->price > 0) {
                            $notificationTemplate = 'Payment_Done';
                            $notificationTemplateData = [
                                'name' => $user->name,
                                'amount' => $plan->price,
                                'txn_id' => $subCheckout->tracking,
                                'payment_date' => showDate(\Carbon\Carbon::now()),
                            ];

                            $this->sendNotification($notificationTemplate, $user, $notificationTemplateData);

                        }

                        Toastr::success(trans('frontend.Checkout Successfully Done'), trans('common.Success'));


//                        $user->save();
                        $plan->delete();


                        return true;

                    } else {
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                        return false;
                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));;
                    return false;
                }


            } else {
                Toastr::error(trans('frontend.You must login'), trans('common.Error'));
                return false;
            }


        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());


        }
    }

    public function saasPlanPurchaseRecord($plan_id, $checkout_info, $user = null, $isChange = false)
    {
        if (empty($user)) {
            $user = Auth::user();
        }
        try {
            if (isModuleActive('LmsSaas')) {
                $plan_info = SaasPlan::find($plan_id);
            } else {
                $plan_info = SaasPlanMD::find($plan_id);
            }
            if ($plan_info->days == 0) {
                $unlimited = 1;
            } else {
                $unlimited = 0;
            }

            if ($isChange) {
                $saas_purchase = SaasInstitutePlanPurchase::where('lms_id', $user->lms_id)->latest()->first();
            } else {
                if (isModuleActive('LmsSaas')) {
                    $saas_purchase = new SaasInstitutePlanPurchase();
                } else {
                    $saas_purchase = new SaasInstitutePlanPurchaseMD();
                }
            }

            $saas_purchase->lms_id = $user->lms_id;
            $saas_purchase->plan_id = $checkout_info->plan_id;
            $saas_purchase->purchase_price = $checkout_info->price;
            $saas_purchase->purchase_date = Carbon::now();
            $saas_purchase->save();

            if (isModuleActive('LmsSaas')) {
                $check_plan = SaasInstitutePlanManagement::where('lms_id', $user->lms_id)->first();
            } else {
                $check_plan = SaasInstitutePlanManagementMD::where('lms_id', $user->lms_id)->first();
            }
            $purchase_date = Carbon::now();
            if ($check_plan) {

                if ($isChange) {
                    $service_end_date = $purchase_date->addDays($plan_info->days);
                    $course = $plan_info->course_limit;
                    $student = $plan_info->student_limit;
                    $instructor = $plan_info->instructor_limit;
                    $meeting = $plan_info->meeting_limit;
                    $upload_limit = $plan_info->upload_limit;
                    $quiz = $plan_info->quiz_question_limit;
                    $blog_post = $plan_info->blog_post_limit;
                    $newsletter = $plan_info->newsletter_limit;
                } else {
                    $service_end_date = Carbon::parse($check_plan->service_end_date)->addDays($plan_info->days);
                    $course = $check_plan->course + $plan_info->course_limit;
                    $student = $check_plan->student + $plan_info->student_limit;
                    $instructor = $check_plan->instructor + $plan_info->instructor_limit;
                    $meeting = $check_plan->meeting + $plan_info->meeting_limit;
                    $upload_limit = $check_plan->upload_limit + $plan_info->upload_limit;
                    $quiz = $check_plan->quiz + $plan_info->quiz_question_limit;
                    $blog_post = $check_plan->blog_post + $plan_info->blog_post_limit;
                    $newsletter = $check_plan->newsletter + $plan_info->newsletter_limit;
                }


                $check_plan->course = $course;
                $check_plan->student = $student;
                $check_plan->instructor = $instructor;
                $check_plan->meeting = $meeting;
                $check_plan->upload_limit = $upload_limit;
                $check_plan->quiz = $quiz;
                $check_plan->blog_post = $blog_post;
                $check_plan->newsletter = $newsletter;
                $check_plan->purchase_date = $purchase_date;
                $check_plan->service_end_date = $service_end_date;
                $check_plan->unlimited = $unlimited;
                if (isModuleActive('LmsSaasMD')) {
                    $check_plan->course_access = $plan_info->course_access;
                    $check_plan->student_access = $plan_info->student_access;
                    $check_plan->instructor_access = $plan_info->instructor_access;
                    $check_plan->meeting_access = $plan_info->meeting_access;
                    $check_plan->quiz_access = $plan_info->quiz_access;
                    $check_plan->blog_access = $plan_info->blog_access;
                }
                $check_plan->update();

            } else {
                $service_end_date = $purchase_date->addDays($plan_info->days);
                if (isModuleActive('LmsSaas')) {
                    $saas_purchase_management = new SaasInstitutePlanManagement();
                } else {
                    $saas_purchase_management = new SaasInstitutePlanManagementMD();
                }
                $saas_purchase_management->lms_id = $user->lms_id;
                $saas_purchase_management->course = $plan_info->course_limit;
                $saas_purchase_management->student = $plan_info->student_limit;
                $saas_purchase_management->instructor = $plan_info->instructor_limit;
                $saas_purchase_management->meeting = $plan_info->meeting_limit;
                $saas_purchase_management->upload_limit = $plan_info->upload_limit;
                $saas_purchase_management->quiz = $plan_info->quiz_question_limit;
                $saas_purchase_management->blog_post = $plan_info->blog_post_limit;
                $saas_purchase_management->newsletter = 0;
                $saas_purchase_management->purchase_date = $purchase_date;
                $saas_purchase_management->service_end_date = $service_end_date;
                $saas_purchase_management->unlimited = $unlimited;
                if (isModuleActive('LmsSaasMD')) {
                    $saas_purchase_management->course_access = $plan_info->course_access;
                    $saas_purchase_management->student_access = $plan_info->student_access;
                    $saas_purchase_management->instructor_access = $plan_info->instructor_access;
                    $saas_purchase_management->meeting_access = $plan_info->meeting_access;
                    $saas_purchase_management->quiz_access = $plan_info->quiz_access;
                    $saas_purchase_management->blog_access = $plan_info->blog_access;
                }
                $saas_purchase_management->save();
            }

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
