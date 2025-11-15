<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Repositories\UserRepositoryInterface;
use App\Traits\GoogleAnalytics4;
use App\Traits\LogoutFromOtherDevice;
use App\User;
use App\UserLogin;
use Brian2694\Toastr\Facades\Toastr;
use Browser;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Modules\Coupons\Entities\UserWiseCoupon;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\FrontendManage\Entities\LoginPage;
use Modules\MyClass\Entities\ClassAttendance;
use Modules\Payment\Entities\Cart;
use Modules\RolePermission\Entities\Role;
use Modules\Store\Entities\ProductSku;
use Modules\Subscription\Entities\SubscriptionCart;
use Modules\TwoFA\Entities\UserOtpCode;
use Stevebauman\Location\Facades\Location;
use function Symfony\Component\Translation\t;

class LoginController extends Controller
{
    use LogoutFromOtherDevice;

    use GoogleAnalytics4;

    protected $providers = [
        'facebook', 'google',
    ];

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function __construct()

    {

        $this->middleware('guest')->except('logout');
        $this->redirectTo = url()->previous();

    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */


    public function redirectToProvider($driver)
    {
        if (!$this->isProviderAllowed($driver)) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }
    }

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('social.login')
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);
    }

    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        // check for email in returned user
        return empty($user->email)
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }



    protected function loginOrCreateAccount($providerUser, $driver)
    {
        // check for already has account
        $user = User::where('email', $providerUser->getEmail())->first();

        $newCreated = false;
        // if user already found
        if ($user) {
            if ($user->email_verified_at == null) {
                $user->email_verified_at = now();
                $user->save();
            }
            $user->update([
                'provider' => $driver,
                'provider_id' => $providerUser->id,
                'access_token' => $providerUser->token,
                'is_login_into_web' => 1,
                'last_activity_at' => now(),
            ]);
        } else {
            $newCreated = true;
            // create a new user
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'image' => $providerUser->getAvatar(),
                'provider' => $driver,
                'email_verified_at' => now(),
                'provider_id' => $providerUser->getId(),
                'access_token' => $providerUser->token,
                'password' => bcrypt(now()),
                'language_id' => Settings('language_id') ?? '19',
                'language_name' => Settings('language_name') ?? 'English',
                'language_code' => Settings('language_code') ?? 'en',
                'language_rtl' => Settings('language_rtl') ?? '0',
                'country' => Settings('country_id'),
                'username' => null,
                'is_login_into_web' => 1,
                'role_id'=> 3,
                'referral' => generateUniqueId(),
                'last_activity_at' => now(),
            ]);

            if (session::get('referral') != null) {
                $invited_by = User::where('referral', session::get('referral'))->first();
                $invites = !empty($invited_by->total_referrer_users) ? $invited_by->total_referrer_users : 0;
                $total_reffer = $invites + 1;
                $invited_by->total_referrer_users = $total_reffer;
                $invited_by->save();

                if (isModuleActive('RegistrationBonus')) {
                    $this->bonus->referralBonus($invited_by);
                } else {
                    $user_coupon = new UserWiseCoupon();
                    $user_coupon->invite_by = $invited_by->id;
                    $user_coupon->invite_accept_by = $user->id;
                    $user_coupon->invite_code = session::get('referral');
                    $user_coupon->save();
                }
            }
        }
        applyDefaultRoleToUser($user);

        // login the user
        Auth::login($user, true);

        if (!$newCreated && Auth::user()->role_id == 3 && !$this->multipleLogin(\request())) {
            if (Settings('allow_force_logout') == 1) {
                Toastr::error(trans('auth.multiple_device_login_error_msg'), trans('common.Failed'));
            } else {
                Toastr::error(trans('frontend.Your Account is already logged in, into').' ' . Settings('device_limit') . ' '.trans('frontend.devices'), trans('common.Error'));
            }
            return redirect()->route('login');
        }

        return $this->sendSuccessResponse();
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {

        $this->validateLogin($request);


        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }


        if (isModuleActive('TwoFA')) {
            $target_user = User::where('email', $request->email)->first();
            if ($target_user){
                $tfaStatus = ($target_user->role_id == 3)
                    ? (int)Settings('enable_student_two_fa')
                    : (int)Settings('enable_two_fa');

                if ($tfaStatus) {
                    $twoFaVerify= $this->handleTwoFactorAuthentication($request, $target_user);
                    if ($twoFaVerify){
                        return redirect()->route('two_step_verification');
                    }
                }
            }

        } else {
            if (Schema::hasColumn('users', 'google2fa_secret')) {
                User::select('google2fa_secret')->update(['google2fa_secret' => null]);
            }
        }
         if ($this->attemptLogin($request)) {




            if (Auth::user()->status == 0) {
                Auth::logout();

                Toastr::error(trans('frontend.Your account is inactive.') . ' ' . trans('frontend.Contact the administrator for assistance.'), trans('common.Failed'));
                return back();
            }

            if (isModuleActive('LmsSaas') && Auth::user()->institute->domain != SaasDomain()) {
                $user = Auth::user();
                Auth::logout();
                if ($user->lms_id != 1) {
                    $domain = $user->institute->domain . '.';
                } else {
                    $domain = '';
                }
                $token = md5(uniqid());
                Storage::put($token, $request->email . '|' . $request->password);
                $url = 'http://' . $domain . config('app.short_url') . '/login?token=' . $token;
                return redirect()->to($url);

            }

            if (Auth::user()->role_id != 1) {
                //device  limit
                $user = Auth::user();
                $time = (int)Settings('device_limit_time');
                $last_activity = $user->last_activity_at;
                if ($time != 0) {
                    if (!empty($last_activity)) {
                        $valid_activity = Carbon::parse($last_activity)->addMinutes($time);
                        $current_time = Carbon::now();
                        if ($current_time->lt($valid_activity)) {
                        } else {
                            $login = UserLogin::where('user_id', Auth::id())->where('status', 1)->latest()->first();
                            if ($login) {
                                $login->status = 0;
                                $login->logout_at = Carbon::now(Settings('active_time_zone'));
                                $login->save();
                            }
                        }
                    }
                }
                $user->last_activity_at = now();
                $user->save();

                $this->classAttendance($user); /* this for MyClass Module*/

                if (Auth::user()->role_id == 3 && !$this->multipleLogin($request)) {
                    if (Settings('allow_force_logout') == 1) {
                        Toastr::error(trans('auth.multiple_device_login_error_msg'), trans('common.Failed'));
                    } else {
                        Toastr::error(trans('frontend.Your Account is already logged in, into').' ' . Settings('device_limit') . ' '.trans('frontend.devices'), trans('common.Error'));
                    }
                    return back();
                }

                if (session()->get('cart') != null && count(session()->get('cart')) > 0) {

                    foreach (session()->get('cart') as $key => $session_cart) {
                        $checkHasCourse = Course::find($session_cart['course_id']);
                        if ($checkHasCourse) {
                            $enolledCousrs = CourseEnrolled::where('user_id', Auth::user()->id)->where('course_id', $session_cart['course_id'])->first();
                            if (!$enolledCousrs || ($session_cart['is_store'] ?? false)) {
                                $hasInCart = Cart::where('course_id', $session_cart['course_id'])->where('user_id', Auth::user()->id)->first();
                                if (!$hasInCart) {
                                    $exist = Cart::where('user_id', Auth::user()->id)->latest()->first();
                                    if ($exist) {
                                        $trackingId = $exist->tracking;
                                    } else {
                                        $trackingId = getTrx();

                                    }
                                    if ($checkHasCourse->discount_price != null) {
                                        $price = $checkHasCourse->discount_price;
                                    } else {
                                        $price = $checkHasCourse->price;
                                    }

                                    if (isset(session()->get('coupon')[$checkHasCourse->id])) {
                                        $price = session()->get('coupon')[$checkHasCourse->id]['price'];
                                    }

                                    $cart = new Cart();
                                    $cart->user_id = Auth::user()->id;
                                    $cart->instructor_id = $session_cart['instructor_id'];
                                    $cart->course_id = $session_cart['course_id'];
                                    $cart->tracking = $trackingId;
                                    $cart->price = $price;

                                    if (isModuleActive('Store') && ($session_cart['is_store'] ?? false)) {
                                        $cart->qty = $session_cart['qty'] ?? 1;
                                        $cart->is_store = $session_cart['is_store'] ?? false;
                                        $cart->attributes_values = $session_cart['attributes_values'] ?? '';
                                        $cart->product_sku_id = $session_cart['product_sku_id'] ?? 0;
                                        $cart->product_sku_label = $session_cart['product_sku_label'] ?? '';
                                        $sku =ProductSku::find($session_cart['product_sku_id']??0);
                                        $cart->price =$sku->price??0;

                                    }


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
            }
            $this->loginHistory($request);


            session(['role_id' => Auth::user()->role_id]);
            if (isModuleActive('Chat')) {
                userStatusChange(auth()->id(), 1);
            }

            Session::flash('from_login', true);
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param Request $request
     * @return void
     *
     * @throws ValidationException
     */
    protected function validateLogin(Request $request)
    {
        if (saasEnv('NOCAPTCHA_FOR_LOGIN') == 'true' && empty($request->two_step_verify_code)) {
            $rules = [
                $this->username() => 'required|string',
                'password' => 'required|string',
                'g-recaptcha-response' => 'required|captcha'
            ];
        } else {
            $rules = [
                $this->username() => 'required|string',
                'password' => 'required|string',
            ];
        }
        $this->validate($request, $rules, validationMessage($rules));

//        $request->validate($rules);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';

    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request),
            $this->maxAttempts()
        );
    }

    /**
     * Get the rate limiter instance.
     *
     * @return RateLimiter
     */
    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    /**
     * Get the throttle key for the given request.
     *
     * @param Request $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input($this->username())) . '|' . $request->ip();
    }

    /**
     * Get the maximum number of attempts to allow.
     *
     * @return int
     */
    public function maxAttempts()
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
    }

    /**
     * Fire an event when a lockout occurs.
     *
     * @param Request $request
     * @return void
     */
    protected function fireLockoutEvent(Request $request)
    {
        event(new Lockout($request));
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param Request $request
     * @return void
     *
     * @throws ValidationException
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            $this->username() => [Lang::get('auth.throttle', ['seconds' => $seconds])],
        ])->status(429);
    }

    private function handleTwoFactorAuthentication(Request $request, $user)
    {

        User::where('two_step_verification', 2)
            ->whereNull('google2fa_secret')
            ->update(['google2fa_secret' => app('pragmarx.google2fa')->generateSecretKey()]);


         if ($request->two_step_verify_code) {
            $otpRecord = UserOtpCode::where('email', $request->email)->latest()->first();
            if ($otpRecord) {
                $timeElapsed = $otpRecord->created_at->diffInMinutes(Carbon::now());

                if ($otpRecord->otp_code != $request->two_step_verify_code) {
                    Toastr::error(trans('auth.Your verification code does not matched'), trans('common.Failed'));
                    return true;
                 } elseif ($timeElapsed > $user->two_fa_expired_time) {
                    Toastr::error(trans('auth.Your verification time is expired. Please resend code for login'), trans('common.Failed'));
                   return true;
                 }
            }

            UserOtpCode::where('email', $request->email)->delete();
        } elseif (in_array($user->two_step_verification, [1, 3, 4])) {
            \session()->put('email', $request->email);
            \session()->put('password', $request->password);
            \session()->put('force', $request->force);

            $userRepository = App::make(UserRepositoryInterface::class);
            $verificationCode = $userRepository->storeVerificationCode($request->email);

            if ($verificationCode) {
                $data = [
                    'otp_code' => $verificationCode->otp_code,
                    'email' => $verificationCode->email,
                    'expired_time' => $verificationCode->expired_time>0?$verificationCode->expired_time:trans('common.Unlimited'),
                ];

                switch ($user->two_step_verification) {
                    case 1:
                        send_email($user, 'Two_Factor_Authentication', $data);
                        break;
                    case 3:
                        send_sms_notification($user, 'Two_Factor_Authentication', $data);
                        break;
                    case 4:
                        send_mobile_notification($user, 'Two_Factor_Authentication', $data);
                        break;
                }
            }
            return true;
        }
        return  false;
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        return [
            $fieldType => $request->email,
            'password' => $request->password
        ];
//        return $request->only($this->username(), 'password');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $login = UserLogin::where('user_id', Auth::id())->where('status', 1)->latest()->first();
            if ($login) {
                $login->status = 0;
                $login->logout_at = Carbon::now(Settings('active_time_zone'));
                $login->save();
            }
            if (isModuleActive('Chat')) {
                userStatusChange(auth()->id(), 0);
            }

            $this->postEvent([
                'name' => 'logout',
                'params' => [
                    'login_at' => now(),
                    'role' => Auth::user()->role->name
                ],
            ]);

            Auth::logout();
            session(['role_id' => '']);
            Session::flush();
        }

        return redirect('/');
    }

    private function classAttendance($user)
    {
        $today = Carbon::now()->format('Y-m-d');
        if (isModuleActive('MyClass') && $user->role_id == 3) {
            $exit = ClassAttendance::where('user_id', $user->id)->where('login_at', $today)->first();
            if (!$exit) {
                $attendance = new ClassAttendance;
                $attendance->user_id = $user->id;
                $attendance->login_at = $today;
                $attendance->status = 1;
                $attendance->save();
            }
        }
    }

    public function multipleLogin($request)
    {
        $device_limit = Settings('device_limit');
        $logins = DB::table('user_logins')
            ->where('status', '=', 1)
            ->where('user_id', '=', Auth::id())
            ->latest()
            ->get();
        if ($device_limit != 0) {
            if (count($logins) >= $device_limit && $request->get('force', 0) != 1) {
                Auth::logout();
                return false;
            } elseif ($request->get('force') == 1) {
                $this->logoutFromOtherDevice(Auth::user());
                DB::table('user_logins')
                    ->where('status', '=', 1)
                    ->where('user_id', '=', Auth::id())
                    ->latest()->delete();
            }
        }


        return true;
    }

    public function loginHistory($request)
    {
        $login = UserLogin::create([
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'browser' => !empty(Browser::browserName()) ? Browser::browserName() : $request->browser,
            'os' => !empty(Browser::platformName()) ? Browser::platformName() : $request->os,
            'token' => \session()->getId(),
            'api_token' => !empty($request->api_token) ? $request->api_token : null,
            'login_at' => Carbon::now(Settings('active_time_zone')),
            'location' => Location::get($request->ip())
        ]);

        $this->postEvent([
            'name' => 'login',
            'params' => [
                'login_at' => now(),
                'role' => Auth::user()->role->name
            ],
        ]);
        \session()->put('login_token', $login->token);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $goto = \session('redirectTo') ?? redirect()->intended($this->redirectPath())->getTargetUrl();

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        checkGamification('each_login', 'activity');
        checkGamificationReg();
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->to($goto);
    }

    public function redirectPath()
    {

        $carts = Cart::where(['user_id' => \auth()->id()])->count();
        $subscriptionCarts=0;
        if (isModuleActive('Subscription')){
            $subscriptionCarts = SubscriptionCart::where(['user_id' => \auth()->id()])->count();
        }

        if (Auth::user()->role_id == 3) {
            if ($carts > 0) {
                $path = route('CheckOut');
            } elseif ($subscriptionCarts > 0){
                $path =route('courseSubscriptionCheckout');
            }else {
                $path = route('studentDashboard');
            }


            if (Settings('customize_org_chart_branch_navigate') == 1 && Settings('org_student_special_branch') == Auth::user()->org_chart_code) {
                if (Settings('navigate_special_branch_after_login') == 'homepage') {
                    return url('/');
                }
            } else {
                if (Settings('navigate_user_after_login') == 'homepage') {
                    return url('/');
                }
            }

        } else {
            if ($carts > 0) {
                $path = route('CheckOut');
            } else {
                if (Settings('navigate_user_after_login') == 'homepage') {
                    return url('/');
                }else{
                    $path = route('dashboard');
                }
            }
        }
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }
        if (\session()->get('from_login')) {
            return $path;
        }
        return property_exists($this, 'redirectTo') ? $this->redirectTo : $path;
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param Request $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request)
    {
        $this->limiter()->clear($this->throttleKey($request));
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //update activity
        if (Auth::check()) {
            $user = Auth::user();
            $user->last_activity_at = now();
            $user->save();
        }
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param Request $request
     * @return void
     */
    protected function incrementLoginAttempts(Request $request)
    {
        $this->limiter()->hit(
            $this->throttleKey($request),
            $this->decayMinutes()
        );
    }

    /**
     * Get the number of minutes to throttle for.
     *
     * @return int
     */
    public function decayMinutes()
    {
        return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1;
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function sendSuccessResponse()
    {
        Auth::user()->update([
            'is_login_into_web' => 1,
        ]);
        if (Auth::user()->role_id != 1) {
            return redirect()->intended('student-dashboard');
        } else {
            return redirect()->intended('home');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    //user logout method
    public function showLoginForm()
    {
        if (Storage::has('.app_resetting')) {
            return new response(view('reset'));
        }
        $token = request('token');
        if ($token && Storage::exists($token)) {
            $content = Storage::get($token);
            $data = explode('|', $content);
            if ($data && count($data) == 2) {
                $email = $data[0];
                $password = $data[1];
                $user = User::where('email', $email)->where('lms_id', app('institute')->id)->first();

                if ($user && Hash::check($password, $user->password)) {
                    Auth::login($user);
                    Storage::delete($token);
                    return redirect()->route('home');
                }
            }
        }
        $page = LoginPage::getData();

        $data=[];
        if (config('app.demo_mode')){
            $data['roles']=Role::whereHas('users',function ($q){
                $q->where('status',1);
            })->where('type','System')->get(['id','name']);
         }
        return view(theme('auth.login'),$data, compact('page'));


    }

    public function autologin($key)
    {
        if (config('app.demo_mode')) {
            $user = User::where('role_id', $key)->first();
            $url = route('dashboard');
            if (!$user){
                Toastr::error('User not found','Error');
                return redirect()->back();
            }
            Auth::loginUsingId($user->id);
            return redirect()->to($url);
        } else {
            return redirect()->back();
        }
    }

    /**
     * The user has logged out of the application.
     *
     * @param Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }
}
