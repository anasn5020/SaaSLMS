<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Providers\RouteServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\StudentCustomField;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\FrontendManage\Entities\LoginPage;
use Modules\Payment\Entities\Cart;
use function session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('guest');
    }

    public function RegisterForm()
    {
        abort_if(!Settings('student_reg'), 404);
        abort_if(saasPlanCheck('student'), 404);
        $page = LoginPage::getData();
        $custom_field = StudentCustomField::getData();
        return view(theme('auth.register'), compact('page', 'custom_field'));
    }

    public function LmsRegisterForm()
    {

        abort_if(!isModuleActive('LmsSaas') && !isModuleActive('LmsSaasMD'), 404);
        abort_if(SaasDomain() != 'main', 404);
        $page = LoginPage::getData();
        $custom_field = StudentCustomField::getData();
        return view(theme('auth.lms_register'), compact('page', 'custom_field'));
    }

    public function showRegistrationForm()
    {
        $page = LoginPage::getData();
        return view(theme('auth.register'), compact('page'));
    }

    public function register(Request $request)
    {
        if (isModuleActive('LmsSaasMD')) {
            ini_set('max_execution_time', 10000);
        }

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        if (isModuleActive('LmsSaasMD') && !empty($user->institute) && $user->institute->status == 0) {
            $maintain = collect();
            $maintain->maintenance_title = trans('saas.View Title');
            $maintain->maintenance_sub_title = trans('saas.View Sub Title');
            $maintain->maintenance_banner = HomeContents('maintenance_banner');
            return new response(view(theme('pages.maintenance'), compact('maintain')));
        }
        if (isModuleActive('LmsSaasMD') && !empty($user->institute) && $user->institute->domain != SaasDomain()) {
            if ($user->lms_id != 1) {
                $token = md5(uniqid());
                Storage::put($token, $request->email . '|' . $request->password);
                $url = 'http://' . $user->institute->domain . '.' . config('app.short_url') . '/login?token=' . $token;
                return redirect()->to($url);
            }
        }
        if (isModuleActive('LmsSaas') && !empty($user->institute) && $user->institute->domain != SaasDomain()) {
            if ($user->lms_id != 1) {
                $token = md5(uniqid());
                Storage::put($token, $request->email . '|' . $request->password);
                $url = 'http://' . $user->institute->domain . '.' . config('app.short_url') . '/login?token=' . $token;
                return redirect()->to($url);
            }
        }


        event(new Registered($user));


        $this->guard()->login($user);


        if ($user->role_id == 3) {
            $loginController = new LoginController();
            $loginController->multipleLogin($request);


            checkGamification('each_login', 'activity');
            checkGamificationReg();
            if ($this->goToCheckout()) {
                return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect(route('CheckOut'));
            }
        }


        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (saasEnv('NOCAPTCHA_FOR_REG') == 'true' && !($data['type'] ?? '' == "Instructor")) {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'g-recaptcha-response' => 'required|captcha'
            ];
        } else {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];
        }

        if (isset($data['is_lms_signup'])) {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'institute_name' => ['required', 'string', 'max:255'],
                'domain' => ['required', 'string', 'max:20', 'unique:lms_institutes'],
            ];
        }
        if (currentTheme() == 'tvt') {
            $rules['level'] = ['required'];
        }

        if (isset($data['type']) && $data['type'] == "Instructor") {

        }else{
            $custom_field = StudentCustomField::getData();

            if ($custom_field->required_company == 1) {
                $rules['company'] = ['required', 'string', 'max:255'];
            }
            if ($custom_field->required_gender == 1) {
                $rules['gender'] = ['required', 'string', 'max:255'];
            }

            if ($custom_field->required_student_type == 1) {
                $rules['student_type'] = ['required', 'string', 'max:255'];
            }

            if ($custom_field->required_identification_number == 1) {
                $rules['identification_number'] = ['required', 'string', 'max:255'];
            }

            if ($custom_field->required_job_title == 1) {
                $rules['job_title'] = ['required', 'string', 'max:255'];
            }


            if ($custom_field->required_dob == 1) {
                $rules['dob'] = ['required', 'string', 'max:255'];
            }

            if ($custom_field->required_institute == 1) {
                $rules['institute_id'] = ['required', 'string', 'max:255'];
            }
        }




        return Validator::make($data, $rules,
            validationMessage($rules)
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        if (isset($data['type']) && $data['type'] == "Instructor") {
            $role = 2;
        } else {
            $role = 3;
        }
        if (isset($data['is_lms_signup'])) {
            $role = 1;
        }

        if (empty($data['phone'])) {
            $data['phone'] = null;
        }
        if (isModuleActive('Organization') && isset($data['account_type']) && $data['account_type']) {
            $role = $data['account_type'];
        }

        if (isModuleActive('TwoFA')) {
            session()->put('email', $data['email']);
            session()->put('password', $data['password']);
        }

        return $this->userRepository->create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'role_id' => $role,
            'dob' => $data['dob'] ?? null,
            'gender' => $data['gender'] ?? null,
            'institute_id' => $data['institute_id'] ?? null,
            'student_type' => $data['student_type'] ?? null,
            'job_title' => $data['job_title'] ?? null,
            'identification_number' => $data['identification_number'] ?? null,
            'company' => $data['company'] ?? null,
            'password' => Hash::make($data['password']),
            'language_id' => Settings('language_id') ?? '19',
            'language_name' => Settings('language_name') ?? 'English',
            'language_code' => Settings('language_code') ?? 'en',
            'language_rtl' => Settings('language_rtl') ?? '0',
            'country' => Settings('country_id'),
            'username' => null,
            'is_lms_signup' => $data['is_lms_signup'] ?? null,
            'institute_name' => $data['institute_name'] ?? null,
            'domain' => str_replace(' ', '', $data['domain'] ?? null),
            'referral' => generateUniqueId(),
            'level' => $data['level'] ?? '',
            'special_commission' => null,
            'referral_code'=>$data['referral_code']??''
        ]);
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

                            if (isset(session()->get('coupon')[$checkHasCourse->id])) {
                                $price = session()->get('coupon')[$checkHasCourse->id]['price'];
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
}
