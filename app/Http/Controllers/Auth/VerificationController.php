<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Providers\RouteServiceProvider;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Payment\Entities\Cart;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails {
        VerifiesEmails::verify as parentVerify;
    }

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    public function resend_mail()
    {
        $user = Auth::user();

        if (Settings('email_verification') != 1 || config('app.demo_mode')) {
            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->save();
        } else {
            $user->sendEmailVerificationNotification();
        }
        return back();
    }

    public function verify(Request $request)
    {
        if ($request->user() && $request->user() != $request->route('id')) {
            Auth::logout();
        }
        if (!$request->user()) {
            $userId = $request->route('id');
            Auth::loginUsingId($userId, true);
        }

        if (!UserDomainCheck()) {
            Auth::logout();
            Toastr::error(trans('frontend.Please Login to your domain'), trans('common.Failed'));
            return back();
        }

        return $this->parentVerify($request);
    }

    public function show(Request $request)
    {
        if (Storage::exists(md5(Auth::user()->email))) {
            $email = Storage::get(md5(Auth::user()->email));
            $user = User::where('email', trim($email))->first();
            $user->sendEmailVerificationNotification();
            Storage::delete(md5(Auth::user()->email));
        }

        if (Session::has('reg_email')) {
            Session::forget('reg_email');
        }
        if ($request->user()->hasVerifiedEmail()) {
            if (SaasDomain() == 'main' && Auth::user()->lms_id != 1) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                Auth::logout();
                return redirect()->route('login');
            }

            return redirect('/');
        }

        return view(theme('auth.verify'));
    }

    public function redirectPath()
    {
        $url = url('/');
        if (Auth::user()->role_id == 3) {
            if ($this->goToCheckout()) {
                return $this->redirectTo = route('CheckOut');
            }
        }
        return $url;
    }

    public function goToCheckout(): bool
    {
        if (session()->get('cart') != null && count(session()->get('cart')) > 0) {

            foreach (session()->get('cart') as $key => $session_cart) {
                $checkHasCourse = Course::find($session_cart['course_id']);
                if ($checkHasCourse) {
                    $enolledCousrs = CourseEnrolled::where('user_id', Auth::user()->id)->where('course_id', $session_cart['course_id'])->first();
                    if (!$enolledCousrs) {
                        $hasInCart = Cart::where('course_id', $session_cart['course_id'])->where('user_id', Auth::user()->id)->first();
                        if (!$hasInCart) {
                            if ($checkHasCourse->discount_price != null) {
                                $price = $checkHasCourse->discount_price;
                            } else {
                                $price = $checkHasCourse->price;
                            }
                            if (hasCouponApply($session_cart['course_id'])){
                                $price = $price - getCouponPrice($session_cart['course_id']);
                            }
                            $cart = new Cart();
                            $cart->user_id = Auth::user()->id;
                            $cart->instructor_id = $session_cart['instructor_id'];
                            $cart->course_id = $session_cart['course_id'];
                            $cart->tracking = getTrx();
                            $cart->price = $price;
                            $cart->save();

                            if ($cart->price == 0) {
                                $paymentController = new PaymentController();
                                $paymentController->directEnroll($cart->course_id, $cart->tracking);
                            }
                        }

                    }

                }

            }
        }
        $carts = Cart::where('user_id', \auth()->id())->count();
        if ($carts > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The user has been verified.
     *
     * @param Request $request
     * @return mixed
     */
    protected function verified(Request $request)
    {
        //after verified
        if (Auth::check()) {
            Auth::user()->update([
                'is_login_into_web' => 1,
            ]);
            send_email(Auth::user(), 'New_Student_Reg', [
                'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                'name' => Auth::user()->name
            ]);
        }

    }

}
