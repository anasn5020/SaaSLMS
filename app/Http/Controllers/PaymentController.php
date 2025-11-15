<?php

namespace App\Http\Controllers;

use App\BillingDetails;
use App\Events\OneToOneConnection;
use App\Traits\GoogleAnalytics4;
use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Bryceandy\Laravel_Pesapal\Facades\Pesapal;

use Carbon\Carbon;
use DrewM\MailChimp\MailChimp;
use Exception;
use GetResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redirect;
use Modules\Affiliate\Events\ReferralPayment;
use Modules\Appointment\Entities\Booking;
use Modules\AstraPay\Services\AstraPayService;
use Modules\AuthorizeNet\Repositories\AuthorizeNetRepository;
use Modules\Bkash\Services\BkashService;
use Modules\Braintree\Repositories\BraintreeRepository;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\BundleSubscription\Entities\BundleSetting;
use Modules\CCAvenue\Libraries\CCAvenue;
use Modules\Coinbase\Repositories\CoinbaseRepository;
use Modules\Coupons\Entities\UserWiseCoupon;
use Modules\Coupons\Entities\UserWiseCouponSetting;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Flutterwave\Repositories\FlutterwaveRepository;
use Modules\Gift\Entities\GiftCart;
use Modules\GoogleCalendar\Events\GoogleCalendarEventAddAttendee;
use Modules\GoogleMeet\Events\MeetingAddAttendeeEvent;
use Modules\Group\Events\GroupMemberCreate;
use Modules\Installment\Http\Controllers\InstallmentPurchaseController;
use Modules\Instamojo\Http\Controllers\InstamojoController;
use Modules\Invoice\Repositories\Interfaces\InvoiceRepositoryInterface;
use Modules\JazzCash\Repositories\JazzcashRepository;
use Modules\MercadoPago\Http\Controllers\MercadoPagoController;
use Modules\Midtrans\Http\Controllers\MidtransController;
use Modules\Mobilpay\Http\Controllers\MobilpayController;
use Modules\Mollie\Repositories\MollieRepository;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Organization\Entities\OrganizationFinance;
use Modules\Organization\Events\CourseSellCommissionEvent;
use Modules\Payeer\Http\Controllers\PayeerController;
use Modules\Payment\Entities\Cart;
use Modules\Payment\Entities\Checkout;
use Modules\Payment\Entities\InstructorPayout;
use Modules\Paytm\Http\Controllers\PaytmController;
use Modules\RazerMS\Http\Controllers\RazerMSController;
use Modules\Razorpay\Http\Controllers\RazorpayController;
use Modules\RegistrationBonus\Repositories\RegistrationbonusRepositroy;
use Modules\Sslcommerz\Http\Controllers\SslcommerzController;
use Modules\Store\Entities\OrderPackageDetail;
use Modules\Store\Entities\OrderProductDetail;
use Modules\Store\Entities\Product;
use Modules\Store\Entities\ShippingMethod;
use Modules\Survey\Entities\Survey;
use Modules\Survey\Http\Controllers\SurveyController;
use Modules\TapPayment\Http\Controllers\TapPaymentController;
use Modules\Tranzak\Services\TranzakService;
use Modules\Wallet\Http\Controllers\WalletController;
use Omnipay\Omnipay;
use Unicodeveloper\Paystack\Facades\Paystack;


class PaymentController extends Controller
{
    use GoogleAnalytics4, SendNotification;

    public $payPalGateway;

    public function __construct()
    {
        $this->middleware(['maintenanceMode', 'onlyAppMode']);

        $this->payPalGateway = Omnipay::create('PayPal_Rest');
        $this->payPalGateway->setClientId(getPaymentEnv('PAYPAL_CLIENT_ID'));
        $this->payPalGateway->setSecret(getPaymentEnv('PAYPAL_CLIENT_SECRET'));
        $this->payPalGateway->setTestMode(getPaymentEnv('IS_PAYPAL_LOCALHOST') == 'true'); //set it to 'false' when go live
    }

    public function makePlaceOrder(Request $request)
    {
        if (isModuleActive('Appointment')) {
            $type = $request->get('type');
            if ($type == 'appointment') {
                Cart::where(function ($query) {
                    $query->where('type', '!=', 'appointment')
                        ->orWhereNull('type');
                })
                    ->where('user_id', Auth::id())
                    ->delete();
            } else {
                Cart::where('type', 'appointment')
                    ->where('user_id', Auth::id())
                    ->delete();
            }
            Cache::forget('login_user_cart_sum'. Auth::id() . SaasDomain());
        }
        $carts = Cart::where('user_id', Auth::id())->count();
        if ($carts == 0) {
            return redirect('/');
        }
        $rules = [
            'old_billing' => 'required_if:billing_address,previous',
            'first_name' => 'required_if:billing_address,new',
            'country' => 'required_if:billing_address,new',
            'phone' => 'required_if:billing_address,new',
            'email' => 'required_if:billing_address,new',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        if ($request->billing_address == 'new') {
            $bill = BillingDetails::where('tracking_id', $request->tracking_id)->first();

            if (empty($bill)) {
                $bill = new BillingDetails();
            }

            $bill->user_id = Auth::id();
            $bill->tracking_id = $request->tracking_id;
            $bill->first_name = $request->first_name;
            $bill->last_name = $request->last_name ?? ' ';
            $bill->company_name = $request->company_name;
            $bill->country = $request->country;
            $bill->address1 = $request->address1 ?? 'N/A';
            $bill->address2 = $request->address2;
            $bill->city = $request->city;
            $bill->state = (int)$request->state;
            $bill->zip_code = $request->zip_code;
            $bill->phone = $request->phone;
            $bill->email = $request->email;
            $bill->details = $request->details;
            $bill->payment_method = null;
            $bill->save();
        } else {

            $bill = BillingDetails::where('id', $request->old_billing)->first();
            if ($request->previous_address_edit == 1) {
                $bill->user_id = Auth::id();
                $bill->tracking_id = $request->tracking_id;
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
                $bill->tracking_id = $request->tracking_id;
                $bill->save();
            }

        }

        $tracking = $request->tracking_id;
        $checkout_info = Checkout::where('tracking', $tracking)->where('user_id', Auth::id())->latest()->first();

        $carts = Cart::with('course')->where('tracking', $tracking)->get();
        if ($checkout_info) {
            $checkout_info->billing_detail_id = $bill->id;
            $checkout_info->save();

            if (isModuleActive('Tax')) {
                $tax = $checkout_info->tax / ($carts->sum('qty')>0?$carts->sum('qty'):1);
            } else {
                $tax = 0;
            }

            $shipping_cost = 0;
            if (isModuleActive('Store')) {
                $shipping_method = ShippingMethod::find($checkout_info->shipping_id);
                if ($checkout_info->shipping_cost > 0) {
                    $shp_chrg = Cart::whereHas('course', function ($q) {
                        $q->where('product_type', 2);
                    })->where('tracking', $checkout_info->tracking)->sum('qty');
                    $shipping_cost = $shipping_method->cost / $shp_chrg;

                }
            }

            foreach ($carts as $cart) {
                if (isModuleActive('Store') && $cart->is_store > 0) {
                    $pack = OrderPackageDetail::where(['course_id' => $cart->course_id, 'order_id' => $checkout_info->id])->count();
                    if ($pack < 1) {
                        $package = OrderPackageDetail::create([
                            'order_id' => $checkout_info->id,
                            'seller_id' => @$cart->course->product->user_id,
                            'package_code' => date('ymdhsi') . rand(11, 99),
                            'number_of_product' => $cart->qty>0?$cart->qty:1,
                            'shipping_cost' => $cart->course->product_type == 2 ? round($shipping_cost * ($cart->qty>0?$cart->qty:1), 2) : 0,
                            'shipping_date' => isset($shipping_method) ? generateDeliveryDate($shipping_method) : null,
                            'carrier_id' => isset($shipping_method) ? $shipping_method->carrier_id : null,
                            'pickup_point_id' => pickupPoint(),
                            'tax_amount' => round($tax * $cart->qty, 2),
                            'delivery_status' => 1,
                            'course_id' => $cart->course_id,
                            'is_store' => $cart->is_store,
                            'shipping_method' => $checkout_info->shipping_id,
                        ]);

                        OrderProductDetail::create([
                            'package_id' => $package->id,
                            'qty' => $cart->qty>0?$cart->qty:1,
                            'price' => $cart->price,
                            'total_price' => $checkout_info->purchase_price,
                            'tax_amount' => taxAmount($tax),
                            'course_id' => $cart->course_id,
                            'is_store' => $cart->is_store,
                        ]);
                    }

                }
            }


            if ($checkout_info->purchase_price == 0) {
                $checkout_info->payment_method = 'None';
                $bill->payment_method = 'None';
                $checkout_info->save();
                foreach ($carts as $cart) {
                    if (isModuleActive('Store') && $cart->is_store > 0) {
                        $package = OrderPackageDetail::create([
                            'order_id' => $checkout_info->id,
                            'seller_id' => @$cart->course->product->user_id,
                            'package_code' => date('ymdhsi') . rand(11, 99),
                            'number_of_product' => $cart->sum('qty')>0?$cart->sum('qty'):1,
                            'pickup_point_id' => pickupPoint(),
                            'tax_amount' => $checkout_info->tax,
                            'delivery_status' => 1,
                        ]);
                    }


                    if (isModuleActive('Gift') && $cart->is_gift == 1) {
                        $gift_cart = new GiftCart();
                        $gift_cart->course_id = $cart->course_id;
                        $gift_cart->user_id = $cart->user_id;
                        $gift_cart->price = $cart->price;
                        $gift_cart->instructor_id = $cart->instructor_id;
                        $gift_cart->tracking = $cart->tracking;
                        $gift_cart->gift_id = $cart->gift_id;
                        $gift_cart->save();

                        $cart->delete();
                    } elseif (isModuleActive('Installment') && $cart->is_installment == 1) {
                        $cart->delete();
                    } else {
                        $this->directEnroll($cart->course_id, $checkout_info->tracking);
                    }

                    $cart->delete();
                }

                Toastr::success(trans('frontend.Checkout Successfully Done'), trans('common.Success'));
                if (Settings('frontend_active_theme') == 'tvt') {
                    return redirect('/');
                }
                return $this->redirectToDashboard($checkout_info->id);
            } else {
                $this->postEvent([
                    'name' => 'add_billing_details',
                    'params' => [
                        "items" => [
                            [
                                'tracking_id' => $request->tracking_id,
                                'first_name' => $request->first_name,
                                'last_name' => $request->last_name,
                                'price' => $checkout_info->purchase_price,
                            ]
                        ],
                    ],
                ]);
                return redirect()->route('orderPayment');

            }
        } else {
            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

            return \redirect()->back();
        }
        //payment method start skip for now

    }

    public function directEnroll($id, $tracking = '')
    {
        try {
            $success = trans('lang.Enrolled') . ' ' . trans('lang.Successfully');
            $user = Auth::user();

            $checkout = Checkout::where('tracking', $tracking)->first();
            if (!$checkout) {
                $checkout = new Checkout();
                $checkout->discount = 0;
                $checkout->coupon_id = null;
                $checkout->purchase_price = 0;
                $checkout->tracking = $tracking;
                $checkout->user_id = Auth::id();
                $checkout->price = 0;
                $checkout->status = 0;
                $checkout->save();
            }

            $this->payWithGateway([], 'None', $user);
            return response()->json([
                'success' => $success,
            ]);
        } catch (Exception$e) {
            return response()->json(['error' => trans("lang.Operation Failed")]);
        }

    }

    public function payWithGateWay($response, $gateWayName, $user = null, $invoice = null)
    {
        try {

            if (Auth::check()) {
                if (!$user) {
                    $user = Auth::user();
                }
            }

            if ($user) {
                $certificate = session()->get('certificate_order') ?? null;
                $checkout_info = Checkout::where('user_id', $user->id)->latest()->first();
                if ($invoice) {
                    $checkout_info = Checkout::where('user_id', $invoice->user_id)
                        ->where('tracking', $invoice->tracking)
                        ->where('invoice_id', $invoice->id)->first();
                }
                if ($certificate) {
                    $checkout_info = Checkout::where('user_id', $certificate->user_id)
                        ->where('tracking', $certificate->tracking)
                        ->where('type', 'certificate')
                        ->where('order_certificate_id', $certificate->id)->first();
                }
                if (isset($checkout_info)) {

                    $discount = $checkout_info->discount;

                    $carts = Cart::where('user_id', $user->id)->latest()->get();

                    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
                    if (isset($backtrace[1])) {
                        $caller = $backtrace[1];
                        $callerMethod = $caller['function'];
                        if ($callerMethod == 'directEnroll' && empty($checkout_info->coupon_id)) {
                            $carts = $carts->where('price', 0);
                        }
                    }
                    if ($invoice) {
                        $carts = $invoice->courses;
                    } elseif ($certificate) {
                        $carts = $certificate;
                    }
                    $courseType = collect();
                    $renew = 0;
                    $bundleId = 0;

                    $is_installment_checkout = 0;

                    if (isModuleActive('Installment') != $certificate) {
                        $is_installment_checkout = $carts->where('is_installment', 1)->count() > 0 ? 1 : 0;
                    }

                    if (!$certificate) {
                        foreach ($carts as $cartKey => $cart) {

                            if (isModuleActive('Cashback')) {
                                $course = Course::find($cart->course_id);
                                if ($course) {
                                    $cashback_source = '';
                                    switch ($course->type) {
                                        case '1':
                                            $cashback_source = 'course';
                                            break;
                                        case '2':
                                            $cashback_source = 'quiz';
                                            break;
                                        case '3':
                                            $cashback_source = 'live_class';
                                            break;
                                        default:

                                            break;
                                    }
                                    generateCashback($cart->user_id, $cart->price, $cashback_source, $course);
                                }

                            }
                            if (isModuleActive('Gift') && $cart->is_gift == 1) {
                                $checkout_data = [
                                    'payment_checkout_info' => $checkout_info,
                                    'payment_user' => $user,
                                    'payment_discount' => $discount,
                                    'payment_cart' => $cart,
                                    'payment_carts' => $carts,
                                    'payment_courseType' => $courseType,
                                    'payment_gateWayName' => $gateWayName,
                                ];
                                $cart->cart_gift->update([
                                    'gift_status' => 2,
                                    'checkout_data' => $checkout_data,
                                ]);
                                continue;

                            }

                            if (isModuleActive('Installment') && !$certificate && $cart->is_installment == 1) {
                                $checkout_data = [
                                    'payment_checkout_info' => $checkout_info,
                                    'payment_user' => $user,
                                    'payment_discount' => $discount,
                                    'payment_cart' => $cart,
                                    'payment_carts' => $carts,
                                    'payment_courseType' => $courseType,
                                    'payment_gateWayName' => $gateWayName,
                                ];
                                $installment_request = new InstallmentPurchaseController();
                                if ($cart->installment_type == 'upfront') {
                                    $installment_request->installmentProcessReset($cart->tracking, $checkout_data);
                                } else {
                                    $installment_request->installmentPaymentProcess($cart->purchase_id);
                                }

                                continue;
                            }


                            if ($checkout_info->type == 'appointment') {
                                $instructor = User::find($cart->instructor_id);
                                $this->forAppointment($checkout_info, $instructor, $discount, $cart, $carts, $gateWayName);
                            } elseif ($certificate) {

                            } else {
                                $this->defaultPayment($checkout_info, $user, $discount, $cart, $carts, $courseType, $gateWayName);
                            }

                            if (isModuleActive('Affiliate') && isModuleActive('BundleSubscription') && $cart->bundle_course_id && $user->isReferralUser) {
                                Event::dispatch(new ReferralPayment($user->id, $cart->bundle_course_id, $cart->price, 'bundle'));
                            }
                        }
                    }


                    // out of foreach
                    $checkout_info->payment_method = $gateWayName;
                    $checkout_info->status = $is_installment_checkout > 0 ? 0 : 1;
                    $checkout_info->response = json_encode($response);
                    if ($certificate || $invoice) {
                        if ($checkout_info) {
                            // for invoice
                            if (isModuleActive('Invoice') && $invoice) {
                                $invoice->update([
                                    'payment_method' => $gateWayName,
                                    'status' => 'paid',
                                    'checkout_id' => $checkout_info->id,
                                ]);
                            }
                            // end invoice
                            if (isModuleActive('Invoice') && $certificate) {
                                $certificate->update([
                                    'status' => 'ordered',
                                    'checkout_id' => $checkout_info->id,
                                    'payment_status' => 1,
                                ]);

                                $admin = User::where('role_id', 1)->first();
                                $shortCodes = [
                                    'student_name' => $certificate->user->name,
                                    'course' => $certificate->course->getTranslation('title', $admin->language_code ?? config('app.fallback_locale')),
                                ];
                                $this->sendNotification('certificate_order', $admin, $shortCodes);

                            }
                        }
                    } else {
                        // bundlesSubscription
                        if (isModuleActive('BundleSubscription')) {
                            $checkout_info->bundle_id = $bundleId;
                            $checkout_info->renew = $renew;

                            if (isset($courseType->bundle) && $courseType->bundle == 1 && isset($courseType->single) && $courseType->single == 1) {
                                $checkout_info->course_type = 'multi';
                            } elseif (isset($courseType->single) && $courseType->single == 1) {
                                $checkout_info->course_type = 'single';
                            } else {
                                $checkout_info->course_type = 'bundle';
                            }
                        }
                        $checkout_info->save();
                        // end bundle Subscription
                    }

                    if ($checkout_info->user->status == 1 && !$invoice && !$certificate) {
                        foreach ($carts as $old) {
                            $old->delete();
                        }
                    }

                    if (isModuleActive('RegistrationBonus')) {

                        $bonus = new RegistrationbonusRepositroy();
                        $invited_user_id = UserWiseCoupon::where('invite_accept_by', Auth::id())->first();
                        if ($invited_user_id) {
                            $invited_user = User::find($invited_user_id->invite_by);
                            if ($invited_user) {
                                $invited_user->total_referrer_amount = $checkout_info->purchase_price;
                                $invited_user->save();
                                $bonus->bonusOnPurchase($invited_user);
                            }
                        }
                    }

                    if ($gateWayName != 'None') {
                        Toastr::success(trans('frontend.Checkout Successfully Done'), trans('common.Success'));
                    }
                    if ($gateWayName != 'COD' && isModuleActive('Store')) {
                        $checkout_info->is_paid = 1;
                        $checkout_info->save();


                        if (!$checkout_info->shipping_id) {
                            $checkout_info->is_confirmed = 1;
                            $checkout_info->is_completed = 1;
                            $checkout_info->is_received = 1;
                            $checkout_info->save();
                        }
                    }

                    return true;
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return false;
                }

            } else {
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return false;
            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);

        }
    }

    private function forAppointment($checkout_info, $instructor, $discount, $cart, $carts, $gateWayName)
    {
        if (isModuleActive('Appointment') && $cart->schedule_id) {
            if ($discount != 0 || !empty($discount)) {
                $itemPrice = $instructor->hour_rate - ($discount / count($carts));
                $discount_amount = $instructor->hour_rate - $itemPrice;
            } else {
                $itemPrice = $instructor->hour_rate;
                $discount_amount = 0.00;
            }
            $exit = Booking::where('schedule_id', $cart->schedule_id)
                ->where('user_id', auth()->user()->id)->first();

            // for appointment  module
            if (!$exit) {
                $scheduleBooking = new Booking;
                $scheduleBooking->schedule_id = $cart->schedule_id;
                $scheduleBooking->tracking = $cart->tracking;
                $scheduleBooking->user_id = auth()->user()->id;
                $scheduleBooking->instructor_id = $cart->instructor_id;
                $scheduleBooking->purchase_price = $itemPrice ?? 0;
                $scheduleBooking->coupon = null;
                $scheduleBooking->discount_amount = $discount_amount;
                $scheduleBooking->timezone = $cart->timezone;
                $scheduleBooking->status = 0;
                $scheduleBooking->save();

                if (!is_null($instructor->appointment_special_commission) && $instructor->appointment_special_commission != 0) {
                    $commission = $instructor->appointment_special_commission;
                    $revenue = ($itemPrice * $commission) / 100;
                } else {
                    $commission = 100 - Settings('appointment_commission');
                    $revenue = ($itemPrice * $commission) / 100;
                }

                $payout = new InstructorPayout();
                $payout->instructor_id = $cart->instructor_id;
                $payout->reveune = $revenue;
                $payout->status = 0;
                $payout->save();
                $this->emailNotification($checkout_info, $cart, $gateWayName);
            }

        }
    }

    public function emailNotification($checkout_info, $cart, $gateWayName)
    {
        $start_time = date('h:i A', strtotime($cart->schedule->slotInfo->start_time));
        $end_time = date('h:i A', strtotime($cart->schedule->slotInfo->end_time));
        $hour_rate = $cart->schedule->userInfo->hour_rate;
        $timeSlot = $cart->schedule->schedule_date . '(' . $start_time . '-' . $end_time . ')';
        $topic = $cart->schedule->category->name . '(' . $cart->schedule->subCategory->name . ')';
        $admin = User::where('role_id', 1)->first();


        $shortCodes = [
            'time' => \Illuminate\Support\Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
            'timeSlot' => $timeSlot,
            'topic' => $topic,
            'currency' => $cart->instructor->currency->symbol ?? '$',
            'price' => $hour_rate ?? 0,
            'student_name' => $cart->student->name,
            'instructor' => $cart->schedule->userInfo->name,
            'gateway' => $gateWayName,
        ];

        $this->sendNotification('Appointment_Enroll_Instructor', $cart->instructor, $shortCodes);
        $this->sendNotification('Appointment_Enroll_Admin', $cart->instructor, $shortCodes);
        $this->sendNotification('Appointment_Enroll_Payment', $cart->student, $shortCodes);


    }

    public function defaultPayment($checkout_info, $user, $discount, $cart, $carts, $courseType, $gateWayName = null, $installment_purchase_id = null)
    {

        //payment confirm
        if ($checkout_info->purchase_price > 0) {
            $notificationTemplate = 'Payment_Done';
            $notificationTemplateData = [
                'name' => $user->name,
                'amount' => $checkout_info->purchase_price,
                'txn_id' => $checkout_info->tracking,
                'payment_date' => showDate(Carbon::now()),
            ];

            $this->sendNotification($notificationTemplate, $user, $notificationTemplateData);

        }

        if ($cart->course_id != 0) {
            $courseType->single = 1;

            $course = Course::find($cart->course_id);
            $enrolled = $course->total_enrolled;
            $course->total_enrolled = ($enrolled + 1);

            //==========================Start Referral========================
            $purchase_history = CourseEnrolled::where('user_id', $user->id)->first();
            $referral_check = UserWiseCoupon::where('invite_accept_by', $user->id)->where('category_id', null)->where('course_id', null)->first();
            $referral_settings = UserWiseCouponSetting::where('status', 1)->where('role_id', $user->role_id)->first();

            if ($referral_settings && $purchase_history == null && $referral_check != null) {
                $referral_check->category_id = $course->category_id;
                $referral_check->subcategory_id = $course->subcategory_id;
                $referral_check->course_id = $course->id;
                $referral_check->save();
                $percentage_cal = ($referral_settings->amount / 100) * $checkout_info->price;

                if ($referral_settings->type == 1) {
                    if ($checkout_info->price > $referral_settings->max_limit) {
                        $bonus_amount = $referral_settings->max_limit;
                    } else {
                        $bonus_amount = $referral_settings->amount;
                    }
                } else {
                    if ($percentage_cal > $referral_settings->max_limit) {
                        $bonus_amount = $referral_settings->max_limit;
                    } else {
                        $bonus_amount = $percentage_cal;
                    }
                }

                $referral_check->bonus_amount = $bonus_amount;
                $referral_check->save();

                $invite_by = User::find($referral_check->invite_by);
                $invite_by->balance += $bonus_amount;
                $invite_by->save();

                $invite_accept_by = User::find($referral_check->invite_accept_by);
                $invite_accept_by->balance += $bonus_amount;
                $invite_accept_by->save();
            }
            //==========================End Referral========================
            if ($discount != 0 || !empty($discount)) {
                $itemPrice = $cart->price - ($discount / count($carts));
                $discount_amount = $cart->price - $itemPrice;
            } else {
                $itemPrice = $cart->price;
                $discount_amount = 0.00;
            }

            $enroll = CourseEnrolled::where('user_id', $user->id)->where('course_id', $course->id)->first();
            if (!$enroll) {
                $enroll = new CourseEnrolled();
            }
            if (isModuleActive('Store') && $cart->is_store == 1) {
                $enroll = new CourseEnrolled();
            }

            $instractor = (isModuleActive('Organization') && $course->isOrganizationCourse()) ? $course->courseOrganization() : User::find($cart->instructor_id);
            $enroll->user_id = $user->id;
            $enroll->tracking = $checkout_info->tracking;
            $enroll->course_id = $course->id;
            $enroll->purchase_price = $itemPrice;
            $enroll->coupon = null;
            $enroll->discount_amount = $discount_amount;
            if (isModuleActive('Store') && $cart->is_store == 1) {
                $enroll->qty = $cart->qty>0?$cart->qty:1;
                $enroll->is_store = $cart->is_store;

                $enroll->attributes_values = $cart->attributes_values;
                $enroll->product_sku_id = $cart->product_sku_id;
                $enroll->product_sku_label = $cart->product_sku_label;
            }

            if (isModuleActive('Installment') && $cart->is_installment == 1) {
                $enroll->status = 0;
                $enroll->save();
                return;
            } else {
                $enroll->status = 1;
            }

            if (isModuleActive('EarlyBird')) {
                updateEarlybirdRecord($course->id, $user->id);
            }

            if (isModuleActive('UserGroup') && $instractor->userGroup && $instractor->userGroup->group->status && $instractor->userGroup->group->commission) {
                $commission = $instractor->userGroup->group->commission;
                $reveune = ($itemPrice * $commission) / 100;
                $enroll->reveune = $reveune;
            } elseif (!is_null($course->special_commission) && $course->special_commission != 0) {

                $commission = $course->special_commission;
                $reveune = ($itemPrice * $commission) / 100;
                $enroll->reveune = $reveune;
            } elseif (!is_null($instractor->special_commission) && $instractor->special_commission != 0) {
                $commission = $instractor->special_commission;
                $reveune = ($itemPrice * $commission) / 100;
                $enroll->reveune = $reveune;
            } else {
                $commission = 100 - Settings('commission');
                $reveune = ($itemPrice * $commission) / 100;
                $enroll->reveune = $reveune;
            }

            if (isModuleActive('Organization') && $course->isOrganizationCourse()) {
                $organization_commission_data = [
                    'user_id' => $course->courseOrganization()->id,
                    'amount' => $reveune,
                    'status' => true,
                    'type' => OrganizationFinance::$credit,
                    'description' => OrganizationFinance::$course_sale_description,
                    'course_id' => $course->id,
                    'data_type' => OrganizationFinance::$type_income,
                    'payment_type' => OrganizationFinance::$payment_pending,

                ];
                event(new CourseSellCommissionEvent($organization_commission_data));

                $admin_commission_data = [
                    'user_id' => 0,
                    'amount' => $itemPrice - $reveune,
                    'status' => true,
                    'type' => OrganizationFinance::$credit,
                    'description' => OrganizationFinance::$course_sale_description,
                    'course_id' => $course->id,
                    'data_type' => OrganizationFinance::$type_income,
                    'payment_type' => OrganizationFinance::$payment_completed,
                ];
                event(new CourseSellCommissionEvent($admin_commission_data));

            } else {
                $payout = new InstructorPayout();
                $payout->instructor_id = $course->user_id;
                $payout->reveune = $reveune;
                $payout->status = 0;
                $payout->save();
            }


            $enroll->save();
            if (isModuleActive('Group')) {
                if ($course->isGroupCourse) {
                    Event::dispatch(new GroupMemberCreate($course->id, $user->id));
                }
            }

            $course->reveune = (($course->reveune) + ($enroll->reveune));

            $course->save();
            checkGamification('each_enroll', 'sales', $instractor);

            if (isModuleActive('Chat')) {
                event(new OneToOneConnection($instractor, $user, $course));
            }
            if (isModuleActive('Survey')) {
                $hasSurvey = Survey::where('course_id', $course->id)->get();
                foreach ($hasSurvey as $survey) {
                    $surveyController = new SurveyController();
                    $surveyController->assignSurvey($survey, $user);
                }
            }

            if (isModuleActive('Affiliate')) {
                if ($user->isReferralUser) {
                    Event::dispatch(new ReferralPayment($user->id, $course->id, $cart->price));
                }
            }
            if (isModuleActive('Invoice')) {
                if ($checkout_info->invoice_id) {
                    $interface = App::make(InvoiceRepositoryInterface::class);
                    $interface->sendInvoice($checkout_info->user->id, null, $checkout_info);
                }
            }

            $this->sendNotification('Course_Enroll_Payment', $checkout_info->user, [
                'time' => \Illuminate\Support\Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
                'course' => $course->getTranslation('title', $checkout_info->user->language_code ?? config('app.fallback_locale')),
                'currency' => $checkout_info->user->currency->symbol ?? '$',
                'price' => ($checkout_info->user->currency->conversion_rate * $itemPrice),
                'instructor' => $course->user->name,
                'gateway' => $gateWayName,
            ]);


            $this->sendNotification('Enroll_notify_Instructor', $instractor, [
                'time' => Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
                'course' => $course->getTranslation('title', $instractor->language_code ?? config('app.fallback_locale')),
                'currency' => $instractor->currency->symbol ?? '$',
                'price' => ($instractor->currency->conversion_rate * $itemPrice),
                'rev' => @$reveune,
            ]);


            if (isModuleActive('GoogleCalendar') && $course->type == 3 && $course->class->host != 'GoogleMeet') {
                Event::dispatch(new GoogleCalendarEventAddAttendee($course->class_id, $user->email));
            }

            if (isModuleActive('GoogleMeet') && $course->type == 3 && $course->class->host == 'GoogleMeet') {
                Event::dispatch(new MeetingAddAttendeeEvent($course->class_id, $user->email));
            }

            //start email subscription
            if ($instractor->subscription_api_status == 1) {
                try {
                    if ($instractor->subscription_method == "Mailchimp") {
                        $list = $course->subscription_list;
                        $MailChimp = new MailChimp($instractor->subscription_api_key);
                        $MailChimp->post("lists/$list/members", [
                            'email_address' => $user->email,
                            'status' => 'subscribed',
                        ]);

                    } elseif ($instractor->subscription_method == "GetResponse") {

                        $list = $course->subscription_list;
                        $getResponse = new GetResponse($instractor->subscription_api_key);
                        $getResponse->addContact(array(
                            'email' => $user->email,
                            'campaign' => array('campaignId' => $list),

                        ));
                    } elseif ($instractor->subscription_method == "Acelle") {

                        $list = $course->subscription_list;
                        $email = $user->email;
                        $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                        $acelleController = new AcelleController();
                        $response = $acelleController->curlPostRequest($make_action_url);
                    }
                } catch (Exception$exception) {
                    GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);

                }
            }

        } else {
            $bundleCheck = BundleCoursePlan::find($cart->bundle_course_id);

            $totalCount = count($bundleCheck->course);
            $price = $bundleCheck->price;
            if ($price != 0) {
                $price = $price / $totalCount;
            }

            $courseType->bundle = 1;
            if ($cart->renew != 1) {
                foreach ($bundleCheck->course as $course) {

                    $enrolled = $course->course->total_enrolled;
                    $course->course->total_enrolled = ($enrolled + 1);

                    $enroll = CourseEnrolled::where('user_id', $user->id)->where('course_id', $course->course->id)->first();
                    if (!$enroll) {
                        $enroll = new CourseEnrolled();
                    }
                    $instractor = User::find($cart->instructor_id);
                    $enroll->user_id = $user->id;
                    $enroll->tracking = $checkout_info->tracking;
                    $enroll->course_id = $course->course->id;
                    $enroll->purchase_price = $price;
                    $enroll->coupon = null;
                    $enroll->discount_amount = 0;
                    $enroll->status = 1;
                    $enroll->bundle_course_id = $cart->bundle_course_id;
                    $enroll->bundle_course_validity = $cart->bundle_course_validity;
                    $enroll->save();

                    $course->course->save();

                }
            } else {
                $enrollBundleCourse = CourseEnrolled::where('bundle_course_id', $cart->bundle_course_id)->where('user_id', Auth::id())->get();
                foreach ($enrollBundleCourse as $enroll) {

                    $instractor = User::find($cart->user_id);
                    $enroll->bundle_course_id = $cart->bundle_course_id;
                    $enroll->bundle_course_validity = $cart->bundle_course_validity;
                    //$enroll->reveune = $enroll->reveune + $reveune / count($enrollBundleCourse);
                    $enroll->save();
                }
                $bundleId = $cart->bundle_course_id;
                $renew = 1;
                $checkout_info->renew = $renew;
                $checkout_info->bundle_id = $bundleId;
                $checkout_info->save();
            }
            $bundleCommission = BundleSetting::getData();
            if ($bundleCommission) {
                $commission = $bundleCommission->commission_rate;
                $reveune = ($bundleCheck->price * $commission) / 100;
                $bundleCheck->reveune += $reveune;
                $bundleCheck->student += 1;
                $bundleCheck->save();
            }
            $payout = new InstructorPayout();
            $payout->instructor_id = $bundleCheck->user_id;
            $payout->reveune = $reveune;
            $payout->status = 0;
            $payout->save();

            $this->sendNotification('Course_Enroll_Payment', $checkout_info->user, [
                'time' => \Illuminate\Support\Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
                'course' => $bundleCheck->title,
                'currency' => $checkout_info->user->currency->symbol ?? '$',
                'price' => ($checkout_info->user->currency->conversion_rate * $bundleCheck->price),
                'instructor' => $bundleCheck->user->name,
                'gateway' => $gateWayName,
            ]);

            $this->sendNotification('Enroll_notify_Instructor', $instractor, [
                'time' => Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
                'course' => $bundleCheck->title,
                'currency' => $instractor->currency->symbol ?? '$',
                'price' => ($instractor->currency->conversion_rate * $bundleCheck->price),
                'rev' => @$reveune,
            ]);


            if (isModuleActive('Invoice') && !empty($checkout_info->invoice_id)) {
                $interface = App::make(InvoiceRepositoryInterface::class);
                $interface->sendInvoice($checkout_info->user->id, null, $checkout_info);
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
                } catch (Exception$exception) {
                    GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);

                }
            }
        }


    }

    public function redirectToDashboard($id = null)
    {
        if (!$id) {
            if (\auth()->user()->role_id == 3) {
                return redirect(route('studentDashboard'));
            } else {
                return redirect(route('dashboard'));
            }
        }
        $encodedValue = Crypt::encryptString(json_encode([
            'type' => 'checkout',
            'id' => $id,
        ]));
        return redirect()->route('paymentSuccess', $encodedValue);


    }

    public function paymentSubmit(Request $request)
    {
        $type = session()->get('order_type');
        if (isModuleActive('Store')) {
            $checkout_info = Checkout::with('allPackage.course.product')->where('id', $request->id)->where('tracking', $request->tracking_id)->with('user')->first();

            foreach ($checkout_info->allPackage as $package) {
                $course = Course::find($package->course_id);
                $course->stock_quantity = $course->stock_quantity - $package->number_of_product;
                $course->save();
                $course = Product::find($course->product_id);
                $course->stock_quantity = $course->stock_quantity - $package->number_of_product;
                $course->save();
            }
        } else {
            $checkout_info = Checkout::where('id', $request->id)->where('tracking', $request->tracking_id)->with('user')->first();
        }

        if (Settings('hide_multicurrency') == 1) {
            $amount = (float)number_format(convertCurrency(auth()->user()->currency->code ?? Settings('currency_code'), Settings('currency_code'), $checkout_info->purchase_price), 2);
        } else {
            $amount = $checkout_info->purchase_price;
        }

        if (isset($request->deposit_amount)) {
            if (Settings('hide_multicurrency') == 1) {
                $deposit_amount = (float)number_format(convertCurrency(auth()->user()->currency->code ?? Settings('currency_code'), Settings('currency_code'), $request->deposit_amount), 2);
            } else {
                $deposit_amount = $request->deposit_amount;
            }

            $request->merge(
                [
                    'deposit_amount' => $deposit_amount
                ]
            );

        }
        $system_currency = Settings('currency_code');

        if (!empty($checkout_info)) {

            if ($request->payment_method == "Sslcommerz") {
                $ssl = new SslcommerzController();
                $ssl->payment($checkout_info, $request);

            } elseif ($request->payment_method == "PayPal") {

                try {
                    $response = $this->payPalGateway->purchase(array(
                        'amount' => $amount,
                        'currency' => $system_currency,
                        'returnUrl' => route('paypalSuccess'),
                        'cancelUrl' => route('paypalFailed'),

                    ))->send();

                    if ($response->isRedirect()) {
                        $response->redirect(); // this will automatically forward the customer
                    } else {
                        Toastr::error($response->getMessage(), trans('common.Failed'));
                        return \redirect()->back();
                    }
                } catch (Exception$e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

                }
            } elseif ($request->payment_method == "Payeer") {

                try {
                    $payeer = new PayeerController();
                    $request->merge(['type' => 'Payment']);
                    $request->merge(['amount' => $amount]);
                    $response = $payeer->makePayment($request);

                    if ($response) {
                        return \redirect()->to($response);
                    } else {
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                        return \redirect()->back();
                    }
                } catch (Exception$e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

                }

            } elseif ($request->payment_method == "Midtrans") {

                try {
                    $midtrans = new MidtransController();
                    $request->merge(['type' => 'Payment']);
                    $request->merge(['amount' => $amount]);
                    $response = $midtrans->makePayment($request);

                    if ($response) {
                        return $response;
                    } else {
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                        return \redirect()->back();
                    }
                } catch (Exception$e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

                }

            } elseif ($request->payment_method == "MercadoPago") {
                $mercadoPagoController = new MercadoPagoController();
                $response = $mercadoPagoController->payment($request->all());
                return response()->json(['target_url' => $response]);
            } elseif ($request->payment_method == "Instamojo") {

                $instamojo = new InstamojoController();
                $response = $instamojo->paymentProcess($amount);
                if ($response) {
                    return \redirect()->to($response);
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return \redirect()->back();
                }

            } elseif ($request->payment_method == "Mobilpay") {

                $mobilpay = new MobilpayController();
                $mobilpay->paymentProcess($amount);

            } elseif ($request->payment_method == 'Jazz Cash') {
                try {
                    $jazz = new JazzcashRepository();
                    $payment_info = [
                        "billref" => $checkout_info->tracking,
                        "description" => "Purchase Payment",
                        "email" => Auth::user()->email,
                        "mobile" => Auth::user()->phone,
                    ];
                    session()->put('from', 'purchase');
                    $result = $jazz->getArray($payment_info, $request->deposit_amount);
                    $post_url = $jazz->getPostUrl();

                    return view('jazzcash::payment', compact('post_url'));
                } catch (Exception $e) {
                    Toastr::error($e->getMessage(), trans('common.Error'));
                    return back();
                }
            } elseif ($request->payment_method == 'Coinbase') {
                $coinbase = new CoinbaseRepository();
                $payment_info = [
                    "name" => "Purchase payment",
                    "description" => "Payment for Course or Class Purchase",
                    "currency" => "USD",
                    "charge_type" => "purchase"

                ];
                $result = $coinbase->makePayment($payment_info, $amount);


                session()->get('pay_from', 'purchase');
                session()->get('charge_id', $result['data']['id']);


                if (isset($result['data']) && isset($result['data']['hosted_url'])) {
                    return redirect()->to($result['data']['hosted_url']);
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return back();
                }
            } elseif ($request->payment_method == "Stripe") {

                $request->validate([
                    'stripeToken' => 'required',
                ]);
                $token = $request->stripeToken ?? '';
                $gatewayStripe = Omnipay::create('Stripe');
                $gatewayStripe->setApiKey(getPaymentEnv('STRIPE_SECRET'));

                //$formData = array('number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2030', 'cvv' => '123');
                $response = $gatewayStripe->purchase(array(
                    'amount' => $amount,
                    'currency' => Settings('currency_code'),
                    'token' => $token,
                ))->send();

                if ($response->isRedirect()) {
                    // redirect to offsite payment gateway
                    $response->redirect();
                } elseif ($response->isSuccessful()) {
                    // payment was successful: update database

                    $payWithStripe = $this->payWithGateWay($response->getData(), "Stripe", $user = null, session()->get('invoice'));
                    if ($payWithStripe) {

                        Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                        if (Settings('frontend_active_theme') == 'tvt') {
                            return redirect('/');
                        }
                        return $this->redirectToDashboard($checkout_info->id);
                    } else {
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                        return \redirect()->back();
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
                    return \redirect()->back();
                }

                $payment = new RazorpayController();
                $response = $payment->payment($request->razorpay_payment_id);

                if ($response['type'] == "error") {
                    Toastr::error($response['message'], trans('common.Error'));
                    return \redirect()->back();
                }

                $payWithRazorPay = $this->payWithGateWay($response['response'], "RazorPay", $user = null, session()->get('invoice'));

                if ($payWithRazorPay) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (Settings('frontend_active_theme') == 'tvt') {
                        return redirect('/');
                    }
                    return $this->redirectToDashboard($checkout_info->id);
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return \redirect()->back();
                }

            } //payment getway
            elseif ($request->payment_method == "PayTM") {

                $userData = [
                    'user' => $checkout_info['tracking'],
                    'mobile' => $checkout_info->billing->phone,
                    'email' => $checkout_info->billing->email,
                    'amount' => $amount,
                    'order' => $checkout_info->billing->phone . "_" . rand(1, 1000),
                ];

                $payment = new PaytmController();
                return $payment->payment($userData);

            } //payment getway

            elseif ($request->payment_method == "PayStack") {

                try {
                    return Paystack::getAuthorizationUrl()->redirectNow();

                } catch (Exception $e) {
                    Toastr::error(trans('frontend.Currency not supported by merchant'), trans('common.Failed'));
                    return redirect()->route('orderPayment');
                }

            } elseif ($request->payment_method == "Pesapal") {

                try {
                    $paymentData = [
                        'amount' => $amount,
                        'currency' => Settings('currency_code'),
                        'description' => 'Payment',
                        'type' => 'MERCHANT',
                        'reference' => 'Payment|' . md5(time()) . '|' . $amount,
                        'first_name' => Auth::user()->first_name,
                        'last_name' => Auth::user()->last_name,
                        'email' => Auth::user()->email,
                    ];

                    $iframe_src = Pesapal::getIframeSource($paymentData);

                    return view('laravel_pesapal::iframe', compact('iframe_src'));
                } catch (Exception$e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
                }

            } elseif ($request->payment_method == "RazerMS") {

                try {
                    $payment = new RazerMSController();
                    $url = $payment->generatePaymentUrl($amount, 'payment');
                    return redirect($url);
                } catch (Exception $e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

                }
            } elseif ($request->payment_method == "TapPayment") {

                try {
                    (new TapPaymentController())->charge([
                        'amount' => $amount,
                        'type' => 'purchase',
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
            } elseif ($request->payment_method == "AstraPay") {

                try {
                    $service = new AstraPayService();
                    $service->paymentRequest([
                        'amount' => $amount,
                        'currency' => Settings('currency_code'),
                        'description' => 'Payment',
                    ]);

                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));

                    return redirect()->back();
                } catch (Exception $e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

                }
            } elseif ($request->payment_method == "Wallet") {

                $payment = new WalletController();
                $response = $payment->payment($request);

                if ($response['type'] == "error") {
                    Toastr::error($response['message'], trans('common.Error'));
                    return \redirect()->back();
                }
                $payWithWallet = $this->payWithGateWay($response['response'], "Wallet", $user = null, session()->get('invoice'));

                if ($payWithWallet) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (Settings('frontend_active_theme') == 'tvt') {
                        return redirect('/');
                    }

                    return $this->redirectToDashboard($checkout_info->id);
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return \redirect()->back();
                }

            } elseif ($request->payment_method == 'Authorize.Net') {
                $authorizeNet = new  AuthorizeNetRepository();
                $response = $authorizeNet->payNow($request, $request->deposit_amount);
                if ($response != null) {
                    if ($response->getMessages()->getResultCode() == "Ok") {
                        $tresponse = $response->getTransactionResponse();
                        if ($tresponse != null && $tresponse->getMessages() != null) {
                            $payWithAuthore = $this->payWithGateWay($response, "Authore.Net", $user = null, session()->get('invoice'));
                            if ($payWithAuthore) {
                                Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                                if (Settings('frontend_active_theme') == 'tvt') {
                                    return redirect('/');
                                }
                                return $this->redirectToDashboard($checkout_info->id);
                            } else {
                                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                                return \redirect()->back();
                            }
                        } else {
                            $msg = 'here were some issue with the payment. Please try again later.';
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
            } elseif ($request->payment_method == 'Braintree') {
                $braintree = new  BraintreeRepository();
                $result = $braintree->payNow($request, $request->deposit_amount);
                if ($result->success) {

                    $payWithBrainTree = $this->payWithGateWay($result, "Braintree", $user = null, session()->get('invoice'));

                    if ($payWithBrainTree) {
                        Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                        return $this->redirectToDashboard($checkout_info->id);
                    } else {
                        Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                        return Redirect::back();
                    }
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return Redirect::back();
                }
            } elseif ($request->payment_method == 'Mollie') {
                $mollie = new MollieRepository();

                $pay_info = [
                    'success_url' => route('mollieSuccess'),
                    "order_id" => $checkout_info->traking,
                    "amount" => $amount,
                    "details" => "Purchase Payment",
                ];
                $result = $mollie->preparePayment($pay_info);
                session()->put('mollie_id', $result->id);
                session()->put('checkout_id', $request->id);
                session()->put('tracking', $request->tracking_id);
                return redirect($result->getCheckoutUrl(), 303);
            } elseif ($request->payment_method == 'Flutterwave') {
                $flutterwave = new FlutterwaveRepository();
                $pay_info = [
                    "name" => Auth::user()->name,
                    "phone" => Auth::user()->phone,
                    "email" => Auth::user()->email,
                    "title" => "Course Purchase payment",
                    "description" => "Payment of course purchase",
                    "webhook" => route('flutterwavePurchaseWebhook')
                ];
                $payment = $flutterwave->payNow($pay_info, $amount);
                if ($payment->status == 'success') {
                    return redirect()->to($payment->data->link);
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return back();
                }
            } elseif ($request->payment_method == 'CCAvenue') {
                $ccavenue = new CCAvenue();
                return $response = $ccavenue->prepare('payment', $amount);
            } elseif ($request->payment_method == 'Tranzak') {

                $paymentData = [
                    'amount' => $amount,
                    'currencyCode' => Settings('currency_code'),
                    'description' => 'Payment',
                    'mchTransactionRef' => 'Payment|' . $amount,
                ];
                $service = new TranzakService();
                $payment_url = $service->paymentRequest($paymentData);
                if ($payment_url) {
                    \redirect($payment_url)->send();
                } else {
                    return back();
                }
            } elseif ($request->payment_method == 'Bkash') {

                $paymentData = [
                    'amount' => $amount,
                    'currencyCode' => Settings('currency_code'),
                    'description' => 'Payment',
                ];
                $service = new BkashService();
                $payment_url = $service->paymentRequest($paymentData);
                if ($payment_url) {
                    \redirect($payment_url)->send();
                } else {
                    return back();
                }
            } elseif ($request->payment_method == "COD") {

                $response['type'] = 'success';
                $response['response'] = [];

                $payWithCOD = $this->payWithGateWay($response['response'], "COD", $user = null, session()->get('invoice'));

                if ($payWithCOD) {
                    $checkout_info->is_paid = 0;
                    $checkout_info->save();
                    Toastr::success(trans('frontend.Order created successfully'), trans('common.Success'));
                    if (Settings('frontend_active_theme') == 'tvt') {
                        return redirect('/');
                    }
                    return $this->redirectToDashboard($checkout_info->id);

                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    return \redirect()->back();
                }

            }


        } else {
            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
            return Redirect::back();
        }

    }

    public function payment()
    {
        try {
            $carts = Cart::where('user_id', Auth::id())->count();
            if ($carts == 0) {
                return redirect('/');
            }
            return view(theme('pages.payment'));
        } catch (Exception$e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function directProductEnroll($cart, $tracking = '')
    {
        try {
            $success = trans('lang.Enrolled') . ' ' . trans('lang.Successfully');
            $user = Auth::user();

            $checkout = Checkout::where('tracking', $tracking)->first();
            if (!$checkout) {
                $checkout = new Checkout();
                $checkout->discount = 0;
                $checkout->coupon_id = null;
                $checkout->purchase_price = 0;
                $checkout->tracking = $tracking;
                $checkout->user_id = Auth::id();
                $checkout->price = 0;
                $checkout->status = 0;
                $checkout->is_confirmed = 1;
                $checkout->is_completed = 1;
                $checkout->is_paid = 1;
                $checkout->is_store = $cart->is_store;
                $checkout->order_number = rand(11, 99) . date('ymdhis');
                $checkout->save();
            }

            if (isModuleActive('Store') && $cart->is_store > 0) {
                $package = OrderPackageDetail::create([
                    'order_id' => $checkout->id,
                    'seller_id' => @$cart->course->product->user_id,
                    'package_code' => date('ymdhsi') . rand(11, 99),
                    'number_of_product' => $cart->qty>0?$cart->qty:1,
                    'shipping_cost' => 0,
                    'pickup_point_id' => pickupPoint(),
                    'delivery_status' => 1,
                    'course_id' => $cart->course_id,
                    'is_store' => $cart->is_store,
                ]);
                OrderProductDetail::create([
                    'package_id' => $package->id,
                    'qty' =>$cart->qty>0?$cart->qty:1,
                    'price' => $cart->price,
                    'total_price' => $checkout->purchase_price,
                    'course_id' => $cart->course_id,
                    'is_store' => $cart->is_store,
                ]);
            }

            $this->payWithGateway([], 'None', $user);
            return response()->json([
                'success' => $success,
            ]);
        } catch (Exception$e) {
            return response()->json(['error' => trans("lang.Operation Failed")]);
        }

    }

    public function paypalSuccess(Request $request)
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
                $payWithPapal = $this->payWithGateWay($arr_body, "PayPal", $user = null, session()->get('invoice'));
                if ($payWithPapal) {
                    Toastr::success(trans('frontend.Payment done successfully'), trans('common.Success'));
                    if (Settings('frontend_active_theme') == 'tvt') {
                        return redirect('/');
                    }
                    return $this->redirectToDashboard();
                } else {
                    Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                    if (Settings('frontend_active_theme') == 'tvt') {
                        return redirect('/');
                    }
                    return $this->redirectToDashboard();
                }

            } else {
                $msg = str_replace("'", " ", $response->getMessage());
                Toastr::error($msg, trans('common.Error'));
                return redirect()->back();
            }
        } else {
            Toastr::error(trans('frontend.Transaction is declined'));
            return redirect()->back();
        }

    }

    public function paypalFailed()
    {
        Toastr::error(trans('frontend.User is canceled the payment'), trans('common.Error'));
        if (Settings('frontend_active_theme') == 'tvt') {
            return redirect('/');
        }
        return $this->redirectToDashboard();
    }

    public function giftEnrollment($checkout_info, $user, $discount, $cart, $carts, $courseType, $gateWayName = null)
    {
        if ($cart->course_id != 0) {
            $courseType->single = 1;

            $course = Course::find($cart->course_id);
            $enrolled = $course->total_enrolled;
            $course->total_enrolled = ($enrolled + 1);

            //==========================Start Referral========================
            $purchase_history = CourseEnrolled::where('user_id', $user->id)->first();
            $referral_check = UserWiseCoupon::where('invite_accept_by', $user->id)->where('category_id', null)->where('course_id', null)->first();
            $referral_settings = UserWiseCouponSetting::where('role_id', $user->role_id)->first();

            if ($purchase_history == null && $referral_check != null) {
                $referral_check->category_id = $course->category_id;
                $referral_check->subcategory_id = $course->subcategory_id;
                $referral_check->course_id = $course->id;
                $referral_check->save();
                $percentage_cal = ($referral_settings->amount / 100) * $checkout_info->price;

                if ($referral_settings->type == 1) {
                    if ($checkout_info->price > $referral_settings->max_limit) {
                        $bonus_amount = $referral_settings->max_limit;
                    } else {
                        $bonus_amount = $referral_settings->amount;
                    }
                } else {
                    if ($percentage_cal > $referral_settings->max_limit) {
                        $bonus_amount = $referral_settings->max_limit;
                    } else {
                        $bonus_amount = $percentage_cal;
                    }
                }

                $referral_check->bonus_amount = $bonus_amount;
                $referral_check->save();

                $invite_by = User::find($referral_check->invite_by);
                $invite_by->balance += $bonus_amount;
                $invite_by->save();

                $invite_accept_by = User::find($referral_check->invite_accept_by);
                $invite_accept_by->balance += $bonus_amount;
                $invite_accept_by->save();
            }
            //==========================End Referral========================
            if ($discount != 0 || !empty($discount)) {
                $itemPrice = $cart->price - ($discount / count($carts));
                $discount_amount = $cart->price - $itemPrice;
            } else {
                $itemPrice = $cart->price;
                $discount_amount = 0.00;
            }

            $enroll = CourseEnrolled::where('user_id', $user->id)->where('course_id', $course->id)->first();
            if (!$enroll) {
                $enroll = new CourseEnrolled();
            }
            $instractor = User::find($cart->instructor_id);
            $enroll->user_id = $user->id;
            $enroll->tracking = $checkout_info->tracking;
            $enroll->course_id = $course->id;
            $enroll->purchase_price = $itemPrice;
            $enroll->coupon = null;
            $enroll->discount_amount = $discount_amount;
            $enroll->status = 1;

            if (!is_null($course->special_commission) && $course->special_commission != 0) {
                $commission = $course->special_commission;
                $reveune = ($itemPrice * $commission) / 100;
                $enroll->reveune = $reveune;
            } elseif (!is_null($instractor->special_commission) && $instractor->special_commission != 0) {
                $commission = $instractor->special_commission;
                $reveune = ($itemPrice * $commission) / 100;
                $enroll->reveune = $reveune;
            } else {
                $commission = 100 - Settings('commission');
                $reveune = ($itemPrice * $commission) / 100;
                $enroll->reveune = $reveune;
            }

            $payout = new InstructorPayout();
            $payout->instructor_id = $course->user_id;
            $payout->reveune = $reveune;
            $payout->status = 0;
            $payout->save();
            $enroll->save();
            if (isModuleActive('Group')) {
                if ($course->isGroupCourse) {
                    Event::dispatch(new GroupMemberCreate($course->id, $user->id));
                }
            }

            $course->reveune = (($course->reveune) + ($enroll->reveune));

            $course->save();
            checkGamification('each_enroll', 'sales', $instractor);

            if (isModuleActive('Chat')) {
                event(new OneToOneConnection($instractor, $user, $course));
            }
            if (isModuleActive('Survey')) {
                $hasSurvey = Survey::where('course_id', $course->id)->get();
                foreach ($hasSurvey as $survey) {
                    $surveyController = new SurveyController();
                    $surveyController->assignSurvey($survey->id, $user->id);
                }
            }

            if (isModuleActive('Affiliate')) {
                if ($user->isReferralUser) {
                    Event::dispatch(new ReferralPayment($user->id, $course->id, $cart->price));
                }
            }
            if (isModuleActive('Invoice')) {
                if ($checkout_info->invoice_id) {
                    $interface = App::make(InvoiceRepositoryInterface::class);
                    $interface->sendInvoice($checkout_info->user->id, null, $checkout_info);
                }
            }


            $this->sendNotification('Course_Enroll_Payment', $checkout_info->user, [
                'time' => \Illuminate\Support\Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
                'course' => $course->getTranslation('title', $checkout_info->user->language_code ?? config('app.fallback_locale')),
                'currency' => $checkout_info->user->currency->symbol ?? '$',
                'price' => ($checkout_info->user->currency->conversion_rate * $itemPrice),
                'instructor' => $course->user->name,
                'gateway' => $gateWayName,
            ]);

            $this->sendNotification('Enroll_notify_Instructor', $instractor, [
                'time' => Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
                'course' => $course->getTranslation('title', $instractor->language_code ?? config('app.fallback_locale')),
                'currency' => $instractor->currency->symbol ?? '$',
                'price' => ($instractor->currency->conversion_rate * $itemPrice),
                'rev' => @$reveune,
            ]);

            if (isModuleActive('GoogleCalendar') && $course->type == 3 && $course->class->host != 'GoogleMeet') {
                Event::dispatch(new GoogleCalendarEventAddAttendee($course->class_id, $user->email));
            }

            if (isModuleActive('GoogleMeet') && $course->type == 3 && $course->class->host == 'GoogleMeet') {
                Event::dispatch(new MeetingAddAttendeeEvent($course->class_id, $user->email));
            }

            //start email subscription
            if ($instractor->subscription_api_status == 1) {
                try {
                    if ($instractor->subscription_method == "Mailchimp") {
                        $list = $course->subscription_list;
                        $MailChimp = new MailChimp($instractor->subscription_api_key);
                        $MailChimp->post("lists/$list/members", [
                            'email_address' => $user->email,
                            'status' => 'subscribed',
                        ]);

                    } elseif ($instractor->subscription_method == "GetResponse") {

                        $list = $course->subscription_list;
                        $getResponse = new GetResponse($instractor->subscription_api_key);
                        $getResponse->addContact(array(
                            'email' => $user->email,
                            'campaign' => array('campaignId' => $list),

                        ));
                    } elseif ($instractor->subscription_method == "Acelle") {

                        $list = $course->subscription_list;
                        $email = $user->email;
                        $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                        $acelleController = new AcelleController();
                        $response = $acelleController->curlPostRequest($make_action_url);
                    }
                } catch (Exception$exception) {
                    GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);

                }
            }

        } else {
            $bundleCheck = BundleCoursePlan::find($cart->bundle_course_id);

            $totalCount = count($bundleCheck->course);
            $price = $bundleCheck->price;
            if ($price != 0) {
                $price = $price / $totalCount;
            }

            $courseType->bundle = 1;
            if ($cart->renew != 1) {
                foreach ($bundleCheck->course as $course) {

                    $enrolled = $course->course->total_enrolled;
                    $course->course->total_enrolled = ($enrolled + 1);

                    $enroll = CourseEnrolled::where('user_id', $user->id)->where('course_id', $course->course->id)->first();
                    if (!$enroll) {
                        $enroll = new CourseEnrolled();
                    }
                    $instractor = User::find($cart->instructor_id);
                    $enroll->user_id = $user->id;
                    $enroll->tracking = $checkout_info->tracking;
                    $enroll->course_id = $course->course->id;
                    $enroll->purchase_price = $price;
                    $enroll->coupon = null;
                    $enroll->discount_amount = 0;
                    $enroll->status = 1;
                    $enroll->bundle_course_id = $cart->bundle_course_id;
                    $enroll->bundle_course_validity = $cart->bundle_course_validity;

                    $enroll->save();

                    $course->course->save();

                }
            } else {
                $enrollBundleCourse = CourseEnrolled::where('bundle_course_id', $cart->bundle_course_id)->where('user_id', Auth::id())->get();
                foreach ($enrollBundleCourse as $enroll) {

                    $instractor = User::find($cart->user_id);
                    $enroll->bundle_course_id = $cart->bundle_course_id;
                    $enroll->bundle_course_validity = $cart->bundle_course_validity;
                    //$enroll->reveune = $enroll->reveune + $reveune / count($enrollBundleCourse);
                    $enroll->save();
                }
                $bundleId = $cart->bundle_course_id;
                $renew = 1;
                $checkout_info->renew = $renew;
                $checkout_info->bundle_id = $bundleId;
                $checkout_info->save();
            }
            $bundleCommission = BundleSetting::getData();
            if ($bundleCommission) {
                $commission = $bundleCommission->commission_rate;
                $reveune = ($bundleCheck->price * $commission) / 100;
                $bundleCheck->reveune += $reveune;
                $bundleCheck->student += 1;
                $bundleCheck->save();
            }
            $payout = new InstructorPayout();
            $payout->instructor_id = $bundleCheck->user_id;
            $payout->reveune = $reveune;
            $payout->status = 0;
            $payout->save();


            $this->postEvent([
                'name' => 'purchased_item',
                'params' => [
                    "items" => [
                        [
                            'course' => $bundleCheck->title,
                            'currency' => $checkout_info->user->currency->symbol ?? '$',
                            'price' => ($checkout_info->user->currency->conversion_rate * $bundleCheck->price),
                            'instructor' => $bundleCheck->user->name,
                            'gateway' => $gateWayName,
                        ]
                    ],
                ],
            ]);

            if (isModuleActive('Invoice')) {
                $interface = App::make(InvoiceRepositoryInterface::class);
                $interface->sendInvoice($checkout_info->user->id, null, $checkout_info);
            }
            $this->sendNotification('Course_Enroll_Payment', $checkout_info->user, [
                'time' => \Illuminate\Support\Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
                'course' => $bundleCheck->title,
                'currency' => $checkout_info->user->currency->symbol ?? '$',
                'price' => ($checkout_info->user->currency->conversion_rate * $bundleCheck->price),
                'instructor' => $bundleCheck->user->name,
                'gateway' => $gateWayName,
            ]);


            $this->sendNotification('Enroll_notify_Instructor', $instractor, [
                'time' => Carbon::now()->translatedFormat('d-M-Y ,s:i A'),
                'course' => $bundleCheck->title,
                'currency' => $instractor->currency->symbol ?? '$',
                'price' => ($instractor->currency->conversion_rate * $bundleCheck->price),
                'rev' => @$reveune,
            ]);

            if (isModuleActive('Chat')) {
                event(new OneToOneConnection($instractor, $user, $course));
            }

            if (isModuleActive('Survey')) {
                $hasSurvey = Survey::where('course_id', $course->id)->get();
                foreach ($hasSurvey as $survey) {
                    $surveyController = new SurveyController();
                    $surveyController->assignSurvey($survey->id, $user->id);
                }
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
                } catch (Exception$exception) {
                    GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);

                }
            }
        }
    }

}
