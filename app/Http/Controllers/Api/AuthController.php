<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\Personal\UserInfoResource;
use App\Models\DeleteAccountRequest;
use App\Models\Language;
use App\Notifications\VerifyEmail;
use App\Repositories\UserRepositoryInterface;
use App\Traits\LogoutFromOtherDevice;
use App\User;
use App\UserLogin;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Modules\Affiliate\Repositories\AffiliateRepository;
use Modules\MyClass\Entities\ClassAttendance;
use Modules\TwoFA\Entities\UserOtpCode;
use Stevebauman\Location\Facades\Location;
use function session;

/**
 * @group  User management
 *
 * APIs for managing user
 */
class AuthController extends Controller
{
    use VerifiesEmails {
        VerifiesEmails::verify as parentVerify;
    }
    use LogoutFromOtherDevice;

    /**
     * Create user
     *
     * @bodyParam  name string required The name of the User.
     * @bodyParam email string required The email address of the User.
     * @bodyParam phone string required The phone number of the User.
     * @bodyParam password string required Set password.
     * @bodyParam password_confirmation string required Set confirm password.
     * @return [string] message
     */

    /*{
    "name": "Ashif",
    "phone": "01722334455",
    "email": "ashif@gmail.com",
    "password": "123456",
    "password_confirmation": "123456"
}*/
    public function signup(Request $request)
    {

        if (!$request->phone) {
            $request->merge([
                'phone' => null
            ]);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255|unique:users,phone',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:8'
        ];

        $validator = Validator::make($request->all(), $rules, validationMessage($rules));

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone ?? null,
                'username' => $request->phone ?? $request->email,
                'password' => bcrypt($request->password),
                'institute_id' => $request->institute_id,
                'language_id' => Settings('language_id') ?? '19',
                'language_name' => Settings('language_name') ?? 'English',
                'language_code' => Settings('language_code') ?? 'en',
                'language_rtl' => Settings('language_rtl') ?? '0',
                'country' => Settings('country_id'),
//                    'email_verified_at' => now(),
                'referral' => generateUniqueId(),
            ]);

            if (Settings('email_verification') != 1 || config('app.demo_mode')) {
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
                $checkMail = '';
            } else {
                $checkMail = 'Please verify your email';
//                $user->sendEmailVerificationNotification();
                  $user->notify(new VerifyEmail());
            }
            if (isModuleActive('TwoFA')) {
                $user->two_step_verification = (int)Settings('default_two_fa');
            }
            applyDefaultRoleToUser($user);

            if (isModuleActive('Affiliate')) {
                $affiliateRepo = new AffiliateRepository();

                if ($request->referral_code) {
                    $affiliateRepo->affiliateUserByCode($request->referral_code);
                }else{
                    $affiliateRepo->affiliateUser($user->id);
                }

            }

            if ($user->role_id == 2) {
                $user->status =(int)Settings('instructor_registration_auto_approval');
                $user->save();
            }elseif($user->role_id == 3) {
                $user->status =(int)Settings('student_registration_auto_approval');
                $user->save();
            }

            $result = $user->save();
            if ($result) {
                $response = [
                    'success' => true,
                    'message' => 'Successfully created user! ' . $checkMail,
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Something went wrong',
                ];
            }


            return response()->json($response, 200);
        } catch (Exception $exception) {

            return $response = [
                'success' => false,
                //            'data'    => $result,
                'message' => $exception->getMessage(),
            ];
        }
    }

    /**
     * Login user and create token
     *
     * @bodyParam email string required The email address of the User.
     * @bodyParam password string required The password of the User.
     * @response {
     * "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiY2UwN2I1ZjY0YzdiZGRlMWYwMjJlZWVhOWJmYzViZDQwZDk0MDM4ZmNhNzhhN2VkN2RkODYyZWU0Y2JhODk4MTZkZmVjMzBkNGYwNTA5MDUiLCJpYXQiOjE2MDU1Mjk1NzEsIm5iZiI6MTYwNTUyOTU3MSwiZXhwIjoxNjM3MDY1NTcxLCJzdWIiOiI2Iiwic2NvcGVzIjpbXX0.kxYeLAD_LMkSOs1KigyMnarEI5F8LrhEL1ogNLBdSqmQryfEdkaW1xgDNr1RaDzxLck0_6eQoifJb9n5qP3DD8chqVRS3UXtvGHh6SqB0_YExHkp8o1GHGBG1PgxOFm85QRUJYw8rvxsMo8wcumez4WgsqPIDOJkC9epp7KhCQV0psmsp0-ZCbptZNUabrvtrwaz_dhmFVluLvNrbG5_0pAI6CCOK9cWwv9T6zE5dQDxS-0_CA_LfXfhE9mvg-7rnWVmMqpbPpmpYdbv1tN7w652GbWiTSaYp3Psi_-UuljJ5kmBP_ia5sMYLMJc8VVPQPoNX4sTvQ6HeibpFCsXu3dEs8JrbQl_WI_za9th-G9jOPcAA6kXFrLe6Su84YSMafCjl1-Cc0UczC_S-ziaIn3PMGM04qfBrLmMoM22njBpIZ5U6R34hXe4LEPD1KGkiP7RhO0wi1budJmXoHDQjXWgpaMKH9I053f1hz_REoM0huNvZ0ADrA7Xo_8gWcx5oUM-HvLK80MIm3-f1xrPQW4hwh3r__NrMaLJkpY7yM5de8x_0-6i5vGCiksTl7zbrfCGarS9fo4qmyEN2n6Fns5Pq89iK3uKeBQe2c6QHNIxtDoxladZF9s5UHdp2OjTC4hDahNJxUuwSvo8Cd_MS2TWJhqXeYLGkgh_GpPqCGA",
     * "token_type": "Bearer",
     * "expires_at": "2021-11-16 18:26:11"
     * }
     */

    /*{
         "email": "ashif@gmail.com",
         "password": "123456"
        }*/
    public function sendTFA(Request $request)
    {
        $user = $request->user();
        if ($user->role_id==3){
            $tfaStatus =(int)Settings('enable_student_two_fa');
        }else{
            $tfaStatus =(int)Settings('enable_two_fa');
        }
        if (isModuleActive('TwoFA') && $tfaStatus) {

            User::where('two_step_verification', 2)->whereNull('google2fa_secret')->update(['google2fa_secret' => app('pragmarx.google2fa')->generateSecretKey()]);

            if ($request->get('method') == 'email') {
                $user->two_step_verification = 1;
            } elseif ($request->get('method') == 'sms') {
                $user->two_step_verification = 3;
            } elseif ($request->get('method') == 'mobile') {
                $user->two_step_verification = 4;
            }

            if ($user && ($user->two_step_verification == 1 || $user->two_step_verification == 3 || $user->two_step_verification == 4)) {
                $userRepository = App::make(UserRepositoryInterface::class);
                $verification_code = $userRepository->storeVerificationCode($user->email);

                if ($verification_code) {
                    $data = [
                        'otp_code' => $verification_code->otp_code,
                        'email' => $verification_code->email,
                        'expired_time' => $verification_code->expired_time
                    ];
                    if ($user->two_step_verification == 1) {
                        send_email($user, 'Two_Factor_Authentication', $data);
                    } elseif ($user->two_step_verification == 3) {
                        send_sms_notification($user, 'Two_Factor_Authentication', $data);
                    } elseif ($user->two_step_verification == 4) {
                        send_mobile_notification($user, 'Two_Factor_Authentication', $data);
                    }
                }


            }

            $response = [
                'success' => true,
                'message' => '2FA send successfully'
            ];
        } else {
            if (Schema::hasColumn('users', 'google2fa_secret')) {
                User::select('google2fa_secret')->update(['google2fa_secret' => null]);
            }
            $response = [
                'success' => false,
                'message' => '2FA is not active by use'
            ];
        }
        return response()->json($response);

    }

    public function checkTFA(Request $request)
    {
        $user = $request->user();
        if ($request->otp_code) {
            $requested_user = UserOtpCode::where('email', $user->email)->latest()->first();
            $different = $requested_user->created_at->diffInMinutes(Carbon::now());

            if ($requested_user->otp_code != $request->otp_code) {
                $response = [
                    'success' => false,
                    'message' => 'Invalid OTP code'
                ];
                return response()->json($response, 422);
            } elseif ($different > $user->two_fa_expired_time) {
                $response = [
                    'success' => false,
                    'message' => 'Expired OTP code'
                ];
                return response()->json($response, 422);
            } else {
                UserOtpCode::where('email', $request->email)->delete();
                $user->token()->update([
                    'tfa' => true
                ]);
                $response = [
                    'success' => true,
                    'message' => 'OTP code verified successfully'
                ];
                return response()->json($response);

            }
        } else {
            $response = [
                'success' => false,
                'message' => 'OTP code is required'
            ];
            return response()->json($response);
        }
    }

    public function autoVerify(Request $request)
    {
        $user = $request->user();
        $user->token()->update([
            'tfa' => true
        ]);
        $response = [
            'success' => true,
            'message' => 'OTP code verified successfully'
        ];
        return response()->json($response);
    }

    public function socialLogin(Request $request)
    {
        $request->validate([
            'provider_id' => ['required'],
            'provider_name' => ['required'],
            'name' => ['nullable'],
            'email' => ['nullable'],
            'token' => 'required'
        ]);
        if ($request->provider_name == 'google') {
            $res = Http::get('https://oauth2.googleapis.com/tokeninfo?id_token=' . $request->token); //student
             if ($res->successful()) {
                return $this->getTokenBySocial($request);
            } else {
                return response()->json([
                    'message' => 'Invalid token.'
                ], 422);
            }
        } elseif ($request->provider_name == 'facebook') {
            $res = Http::get('https://graph.facebook.com/me?access_token=' . $request->token);
            if ($res->successful()) {
                return $this->getTokenBySocial($request);
            } else {
                return response()->json([
                    'message' => 'Invalid token.'
                ], 422);
            }
        } elseif ($request->provider_name == 'apple') {

            return $this->getTokenBySocial($request);
//            $verificationUrl = 'https://appleid.apple.com/auth/token';
//            $clientId = 'your_client_id';
//            $clientSecret = 'your_client_secret';
//            $token = $request->token;
//
//            $res = Http::asForm()->post($verificationUrl, [
//                'client_id' => $clientId,
//                'client_secret' => $clientSecret,
//                'code' => $token,
//                'grant_type' => 'authorization_code',
//            ]);
//
//            if ($res->successful()) {
//                return
//            } else {
//                return response()->json([
//                    'message' => 'Invalid token.'
//                ], 422);
//            }
        } else {
            return response()->json([
                'message' => 'Invalid provider name.'
            ], 422);
        }
    }

    private function getTokenBySocial($request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => '',
                'role_id' => 3,
                'language_id' => Settings('language_id') ?? '19',
                'language_name' => Settings('language_name') ?? 'English',
                'language_code' => Settings('language_code') ?? 'en',
                'language_rtl' => Settings('language_rtl') ?? '0',
                'country' => Settings('country_id'),
                'email_verified_at' => now(),
                'referral' => generateUniqueId(),
            ]);
            applyDefaultRoleToUser($user);
        } else {
            $user->name = $request->name;
            $user->email_verified_at = now();
            $user->save();
        }
        Auth::login($user);

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        if (isModuleActive('TwoFA')) {
            $token->tfa = true;
        }
        $result = $token->save();

        $data = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'is_verify' => $user->email_verified_at,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];

        if ($result) {

            $request->merge([
                'api_token' => $token->id,
            ]);


            $check = $this->attemptUserCheck($request);

            if (!$check['type']) {
                $response = [
                    'success' => false,
                    'message' => $check['message'],
                ];
                if (isset($check['multipleLogin'])) {
                    $response['multipleLogin'] = $check['multipleLogin'];
                }
            } else {
                $response = [
                    'success' => true,
                    'data' => $data,
                    'message' => 'Successfully login!',
                ];
            }

        } else {
            $response = [
                'success' => false,
                'message' => 'Something went wrong',
            ];
        }

        return response()->json($response, 200);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if ($request->phone) {
            $fieldType = 'phone';
            $credentials = [
                'phone' => $request->phone,
                'password' => $request->password
            ];
        } else {
            $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $credentials = [
                $fieldType => $request->email,
                'password' => $request->password
            ];
        }

//        $credentials = request(['email', 'password']);

        try {
            if (!Auth::attempt($credentials))
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);

            $user = $request->user();

            if (empty($user->email_verified_at)) {
                $response = [
                    'success' => false,
                    'message' => 'Email not verified. Please verify your email',
                ];
                return response()->json($response, 403);

            }

            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $result = $token->save();

            $data = [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'is_verify' => $user->email_verified_at,
                'is_login_into_web' => $user->is_login_into_web,
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ];

            if ($result) {

                $request->merge([
                    'api_token' => $token->id,
                ]);

                $check = $this->attemptUserCheck($request);

                if (!$check['type']) {
                    $response = [
                        'success' => false,
                        'message' => $check['message'],
                    ];
                    if (isset($check['multipleLogin'])) {
                        $response['multipleLogin'] = $check['multipleLogin'];
                    }
                } else {
                    checkGamification('each_login', 'activity');
                    $response = [
                        'success' => true,
                        'data' => $data,
                        'message' => 'Successfully login!',
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Something went wrong',
                ];
            }

            return response()->json($response, 200);
        } catch (Exception $exception) {
            $response = [
                'success' => false,
                'message' => $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Get the authenticated User
     *
     * @response
     *  {
     * "success": true,
     * "data": [
     * {
     * "id": 6,
     * "role_id": 3,
     * "name": "Ashif",
     * "photo": "public/infixlms/img/admin.png",
     * "image": "public/infixlms/img/admin.png",
     * "avatar": "public/infixlms/img/admin.png",
     * "mobile_verified_at": null,
     * "email_verified_at": null,
     * "notification_preference": "mail",
     * "is_active": 1,
     * "username": "ashif@gmail.com",
     * "email": "ashif@gmail.com",
     * "email_verify": "0",
     * "phone": "01722334455",
     * "address": null,
     * "city": "1374",
     * "country": "19",
     * "zip": null,
     * "dob": null,
     * "about": null,
     * "facebook": null,
     * "twitter": null,
     * "linkedin": null,
     * "instagram": null,
     * "subscribe": 0,
     * "provider": null,
     * "provider_id": null,
     * "status": 1,
     * "balance": 0,
     * "currency_id": 112,
     * "special_commission": 1,
     * "payout": "Paypal",
     * "payout_icon": "/uploads/payout/pay_1.png",
     * "payout_email": "demo@paypal.com",
     * "referral": null,
     * "added_by": 0,
     * "created_at": "2020-11-16T12:09:40.000000Z",
     * "updated_at": "2020-11-16T12:09:40.000000Z"
     * } ,
     * "message": "Getting user info"
     * }
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        try {

            if (isModuleActive('Org')) {
                $data = User::where('id', $request->user()->id)->with('position', 'branch')->first();
            } else {
                $data = User::where('id', $request->user()->id)->with('studentInstitute:id,name',)->first();
//                $data = $request->user();
            }
            if (empty($data->state)) {
                $data->state = 0;
            }
            $data->unreadNotifications = $data->unreadNotifications->count();
            $data->currency_symbol = $data->currency?->symbol;
            $data->currency_code = $data->currency?->code;
            if (isModuleActive('Subscription')) {
                $data->active_study_plans = userCurrentPlan();
            }
            $response = [
                'success' => true,
                'data' => new UserInfoResource($data),
                'message' => 'Getting user info',
            ];

            return response()->json($response);
        } catch (Exception $exception) {
            $response = [
                'success' => false,
                'message' => $exception->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function attemptUserCheck($request)
    {
        $result['type'] = true;
        $result['message'] = '';

        if (Auth::user()->status == 0) {
            Auth::logout();

            $result['type'] = false;
            $result['message'] = 'Your account has been disabled !';
            return $result;
        }

        if (Auth::user()->role_id == 3) {

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

            if (isModuleActive('MyClass')) {
                $today = Carbon::now()->format('Y-m-d');
                $exit = ClassAttendance::where('login_at', $today)
                    ->where('user_id', Auth::id())->first();
                if (!$exit) {
                    $model = new ClassAttendance;
                    $model->user_id = Auth::id();
                    $model->token = 'my-class';
                    $model->login_at = $today;
                    $model->save();
                }
            }

            $multipleLoginStatus = $this->multipleLogin($request);
            if (!$multipleLoginStatus) {
                $result['type'] = false;
                $result['multipleLogin'] = true;
                $result['message'] = trans('auth.multiple_device_login_error_msg');
                return $result;
            }
        }

        session(['role_id' => Auth::user()->role_id]);
        if (isModuleActive('Chat')) {
            userStatusChange(auth()->id(), 1);
        }


        return $result;
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            if ($user->role_id != 1) {
                $login = UserLogin::where('user_id', $user->id)->where('status', 1)->latest()->first();
                if ($login) {
                    $login->status = 0;
                    $login->logout_at = Carbon::now(Settings('active_time_zone'));
                    $login->save();
                }
            }
            $user->token()->revoke();
            $response = [
                'success' => true,
                'message' => 'Successfully logged out',
            ];
            return response()->json($response, 200);
        } catch (Exception $exception) {
            $response = [
                'success' => false,
                'message' => $exception->getMessage()
            ];
            return response()->json($response, 500);
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
            if (count($logins) >= $device_limit && $request->get('force') != 1) {
                Auth::logout();
                return false;
            } elseif ($request->get('force') == 1) {

                $this->logoutFromOtherDevice(Auth::user());

                DB::table('user_logins')
                    ->where('status', '=', 1)
                    ->where('user_id', '=', Auth::id())
                    ->latest()->delete();
                DB::table('user_logins')
                    ->where('status', '=', 1)
                    ->where('user_id', '=', Auth::id())->update([
                        'status' => 0,
                        'logout_at' => Carbon::now(Settings('active_time_zone'))
                    ]);
                DB::table('oauth_access_tokens')->where('user_id', Auth::id())
                    ->where('id', '!=', !empty($request->api_token) ? $request->api_token : null)->latest()->skip(1)->delete();
            }
        }
        UserLogin::create([
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'browser' => 'API',
            'os' => 'API',
            'token' => session()->getId(),
            'api_token' => !empty($request->api_token) ? $request->api_token : null,
            'login_at' => Carbon::now(Settings('active_time_zone')),
            'location' => Location::get($request->ip())
        ]);
        return true;
    }

    /**
     * Change Password
     *
     * @bodyParam old_password string required The current password of the User.
     * @bodyParam new_password string required The new password of the User.
     * @bodyParam confirm_password string required The confirm password of the User.
     * @response {
     * "success": true,
     * "message": "Password updated successfully."
     * }
     */
    public function changePassword(Request $request)
    {
        $input = $request->all();
        $userid = $data = $request->user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
                }
            } catch (Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg, "data" => array());
            }
        }
        if ($arr['status'] == 200) {
            $status = true;
        } else {
            $status = false;
        }
        $response = [
            'success' => $status,
            'message' => $arr['message'],
        ];
        return response()->json($response, $arr['status']);
    }

    public function accountDelete(Request $request)
    {
        $user = $request->user();
        $userid = $user->id;

        if (!empty($user->password) && !Hash::check($request->old_password, $user->password)) {
            $response = [
                'success' => false,
                'message' => "Check your old password.",
            ];
        } else {
            $user->update(['status' => 0]);

            DeleteAccountRequest::create(
                [
                    'user_id' => $userid
                ]
            );
            $this->logoutFromOtherDevice($user);
            $this->logoutFromCurrentDevice($user);
            $response = [
                'success' => true,
                'message' => "Account delete request send successfully.",
            ];
        }


        return response()->json($response);

    }

    public function setFcmToken(Request $request)
    {

        try {
            $user = User::find($request->id);
            $user->device_token = $request->token;
            $user->save();

            $response = [
                'success' => true,
                'message' => 'Successfully set fcm token',
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function getLang(Request $request)
    {

        if (auth('api')->check()) {
            $user = auth('api')->user();
            $code = empty($request->code) ? $user->language_code ?? 'en' : $request->code;
            $rtl = empty($request->rtl) ? $user->language_rtl ?? 0 : $request->rtl;
        } else {
            $code = Settings('language_code') ?? 'en';
            $rtl = Settings('language_rtl') ?? 0;
        }

        try {
            $path = resource_path("lang/$code" . "/api.php");
            $values = File::getRequire($path);
        } catch (Exception $exception) {
            $path = resource_path("lang/en/api.php");
            $values = File::getRequire($path);
        }

        $language = [];
        foreach ($values as $key => $value) {
            $language[$key] = $value;
        }
        $lang = json_decode(json_encode($language), true);

        $data['rtl'] = $rtl;
        $data['code'] = $code;
        $data['lang'] = $lang;


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Getting data',
        ];

        return response()->json($response, 200);
    }

    public function setLang(Request $request)
    {

        try {
            $language_code = $request->lang;
            $language = Language::where('status', 1)->where('code', $language_code)->first();
            $user = $request->user();
            if ($user) {
                $user->language_id = $language->id;
                $user->language_code = $language->code;
                $user->language_name = $language->name;
                $user->language_rtl = $language->rtl;
                $user->save();
            }

            $response = [
                'success' => true,
                'data' => (string)$language->code,
                'message' => 'Successfully set lang',
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function sendOtp(Request $request)
    {
        try {
            $otp = rand(100000, 999999);
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->otp = $otp;
                $user->save();

                send_email($user, 'ResetOTP', [
                    'otp' => $user->otp,
                    'email' => $user->email,
                    'name' => $user->name,
                ]);

                $response = [
                    'success' => true,
                    'message' => 'Operation Successful',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Operation Failed',
                ];
            }

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }


    public function resetWithOtp(Request $request)
    {
        try {
            $status = false;
            $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
            if ($user) {
                if (strlen($request->password) >= 8 && $request->password == $request->confirm_password) {
                    if ($user->otp == $request->otp) {
                        $user->password = Hash::make($request->password);
                        $user->otp = null;
                        $user->save();
                        $status = true;
                    }
                }
            }

            if ($status) {
                $response = [
                    'success' => true,
                    'message' => 'Operation Successful',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Operation Failed',
                ];
            }


            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function logOutDevice(Request $request)
    {
        if (!Hash::check($request->password, auth('api')->user()->password)) {
            $response = [
                'success' => false,
                'message' => trans('frontend.Your Password Doesnt Match'),
            ];
            return response()->json($response, 200);
        }
        if ($request->type == "logout") {
            $login = UserLogin::find($request->id);
            if (!empty($login->api_token)) {
                DB::table('oauth_access_tokens')->where('id', '=', $login->api_token)->delete();
            }
            Auth::guard('web')->logoutOtherDevices($request->password);
            $login->status = 0;
            $login->logout_at = Carbon::now();
            $login->save();

            $response = [
                'success' => true,
                'message' => trans('frontend.Logged Out SuccessFully'),
            ];
        } else {
            $response = [
                'success' => true,
                'message' => trans('Operation Successful'),
            ];
        }
        return response()->json($response, 200);
    }


    public function resendEmail(Request $request)
    {
        try {
            $status = false;

            $response = [
                'success' => false,
                'message' => 'Operation Failed',
            ];


            $user = User::where('email', $request->email)->first();
            if ($user) {
                if ($user->email_verified_at == null) {
                    $user->sendEmailVerificationNotification();
                    $response = [
                        'success' => true,
                        'message' => 'Operation Successful',
                    ];
                    $status = true;
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Already verified',
                    ];
                }
            }

            return response()->json($response,);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

}
