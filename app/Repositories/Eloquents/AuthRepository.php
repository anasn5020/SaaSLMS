<?php

namespace App\Repositories\Eloquents;

use App\User;
use App\UserLogin;
use Carbon\Carbon;
use Illuminate\Http\Response;
use App\Jobs\SendGeneralEmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\DeleteAccountRequest;
use Illuminate\Support\Facades\Http;
use Modules\MyClass\Entities\ClassAttendance;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\api\v2\User\UserDetailsResource;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Http\Resources\api\v2\Auth\AuthUserDetailResource;

class AuthRepository implements AuthRepositoryInterface
{
    use VerifiesEmails {
        VerifiesEmails::verify as parentVerify;
    }

    // public function __construct()
    // {
    //     config(['auth.defaults.guard' => 'api']);
    // }

    public function signup(object $request): array
    {
        if (isset($request->type) && $request->type == "instructor") {
            $role = 2;
        } else {
            $role = 3;
        }
        if (isset($request->is_lms_signup)) {
            $role = 1;
        }
        if (isModuleActive('Organization') && isset($request->account_type) && $request->account_type) {
            $role = $request->account_type;
        }

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'phone'             => $request->phone == '' ? null : $request->phone,
            'username'          => $request->email,
            'role_id'           => $role,
            'password'          => bcrypt($request->password),
            'language_id'       => Settings('language_id') ?? '19',
            'language_name'     => Settings('language_name') ?? 'English',
            'language_code'     => Settings('language_code') ?? 'en',
            'language_rtl'      => Settings('language_rtl') ?? '0',
            'country'           => Settings('country_id'),
            'referral'          => generateUniqueId(),
        ]);
        applyDefaultRoleToUser($user);

        if (Settings('email_verification') == 1) {
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->save();
            SendGeneralEmail::dispatch($user, 'EmailVerificationOTP', [
                'otp'   => $user->otp,
                'email' => $user->email,
                'name'  => $user->name,
            ]);
        }

        if ($user->role_id == 2) {
            $user->status =(int)Settings('instructor_registration_auto_approval');
            $user->save();
        }elseif($user->role_id == 3) {
            $user->status =(int)Settings('student_registration_auto_approval');
            $user->save();
        }
        $data = [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'otp' => $user->otp,
        ];

        return ['data' => $data, 'role' => $user->role_id];
    }

    public function verifyEmail(object $request): array
    {
        $user = User::where('email', $request->email)->first();
        if (!isset($user)) {
            throw ValidationException::withMessages(['user' => trans('api.User not found'),]);
        }
        if ($user->otp != $request->otp) {
            throw ValidationException::withMessages(['otp' => trans('api.Invalid OTP')]);
        }
        if (Settings('email_verification') == 1 && $request->type == 'signup' && !$user->email_verified_at) {
            $user->email_verified_at = $user->otp == $request->otp ? date('Y-m-d H:m:s') : null;
            $user->email_verify = $user->otp == $request->otp;
            $user->otp = null;
            $user->save();

            $response = [
                'success'   => true,
                'message'   => trans('api.OTP verification is successful'),
            ];
        } elseif ($request->type != 'signup' && $user->email_verified_at && $user->otp) {
            $user->otp = $user->otp == $request->otp ? $user->otp : $user->otp;
            $user->save();

            $response = [
                'success'   => true,
                'message'   => trans('api.OTP verification is successful'),
            ];
        } else {
            $response = [
                'succcess' => false,
                'message' => trans('api.Invalid OTP'),
            ];
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return ['response' => $response, 'status' => $status ?? 200];
    }

    public function login(object $request): array
    {
        $user = $request->user();

        if (Settings('email_verification') == 1 && $user->email_verified_at || $user->role_id == 1) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();

            $data = [
                'access_token'  => (string)$tokenResult->accessToken,
                'token_type'    => 'Bearer',
                'is_verify'     => (bool)$user->email_verified_at,
                'expires_at'    => (string)Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user' => new AuthUserDetailResource($user),
            ];
            $request->merge([
                'api_token' => $token->id,
            ]);
            $this->attemptUserCheck($request);
        } elseif (Settings('email_verification') != 1) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();

            $data = [
                'access_token'  => (string)$tokenResult->accessToken,
                'token_type'    => 'Bearer',
                'is_verify'     => (bool)$user->email_verified_at,
                'expires_at'    => (string)Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user' => new AuthUserDetailResource($user),
            ];
            $request->merge([
                'api_token' => $token->id,
            ]);
            $this->attemptUserCheck($request);
        } else {
            $data = [];
        }

        return $data;
    }
    public function socialLogin(object $request): array
    {
        if ($request->provider_name == 'google') {
            // $res = Http::get('https://oauth2.googleapis.com/tokeninfo?id_token=' . $request->token);
            $res = Http::get('https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=' . $request->token);
            if ($res->successful()) {
                // return response()->json(['google_token' => $this->getTokenBySocial($request)]);
                return $this->getTokenBySocial($request);
            } else {
                //     return response()->json([
                //         'message' => trans('api.Invalid token')
                //     ], 422);
                throw ValidationException::withMessages(['token' => trans('api.Invalid token')]);
            }
        } elseif ($request->provider_name == 'facebook') {
            $res = Http::get('https://graph.facebook.com/me?access_token=' . $request->token);
            if ($res->successful()) {
                // return response()->json(['facebook_token' => $this->getTokenBySocial($request)]);
                return $this->getTokenBySocial($request);
            } else {
                // return response()->json([
                //     'message' => trans('api.Invalid token')
                // ], 422);

                throw ValidationException::withMessages(['token' => trans('api.Invalid token')]);
            }
        } elseif ($request->provider_name == 'apple') {
            //             return response()->json(['apple_token' => $this->getTokenBySocial($request)]);
            return $this->getTokenBySocial($request);
        } else {
            // return response()->json([
            //     'message' => trans('api.Invalid provider name')
            // ], 422);

            ValidationException::withMessages(['provider_name' => trans('api.Invalid provider name')]);
        }
    }

    public function logout(object $request): bool
    {
        $request->user()->token()->revoke();
        return true;
    }

    public function user(object $request): object
    {
        $data = $request->user();
        if (empty($data->state)) {
            $data->state = 0;
        }
        $data->unreadNotifications = $data->unreadNotifications->count();
        $data->currency_symbol = $data->currency?->symbol;
        $data->currency_code = $data->currency?->code;
        if (isModuleActive('Subscription')) {
            $data->active_study_plans = userCurrentPlan();
        }
        $data->save();
        if (!$data) {
            $response = [
                'success'   => false,
                'message'   => trans('api.User not found'),
            ];
        } else {
            $response = [
                'success'   => true,
                'data'      => $data,
                'message'   => trans('api.Getting user info'),
            ];
        }

        return response()->json($response);
    }

    public function changePassword(object $request): array
    {
        $userid = $request->user()->id;
        if (!password_verify($request->old_password, auth()->user()->password)) {
            $arr = [
                "status"    => 400,
                "message"   => trans('api.Check your old password'),
            ];
        } else if (password_verify($request->new_password, auth()->user()->password)) {
            $arr = [
                "status"    => 400,
                "message"   => trans('api.Please enter a password which is not similar then current password'),
            ];
        } else {
            User::where('id', $userid)->update(['password' => bcrypt($request->new_password)]);
            $arr = [
                "status"    => 200,
                "message"   => trans('api.Password updated successfully'),
            ];
        }

        if ($arr['status'] == 200) {
            $status = true;
        } else {
            $status = false;
        }
        $data = [
            'success' => $status,
            'message' => $arr['message'],
        ];
        return  ['status_code' => $arr['status'], 'data' => $data];
    }

    /* public function accountDelete(object $request): object
    {
        $rules = ['old_password' => 'required'];
        $request->validate($rules, validationMessage($rules));
        $userid = $request->user()->id;
        if (!password_verify($request->old_password, auth()->user()->password)) {
            $arr = array("status" => 400, "message" => trans('api.Check your old password'), "data" => array());
        } else {
            User::where('id', $userid)->delete();
            $arr = array("status" => 200, "message" => trans('api.Account Delete successfully'), "data" => array());
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
    } */

    public function setFcmToken(object $request): object
    {
        $request->validate([
            'id' => 'required',
            'token' => 'required'
        ]);

        $user = User::find($request->id);
        $user->device_token = $request->token;
        $user->save();

        if (!$user->device_token) {
            $response = [
                'success'   => false,
                'message'   => trans('api.Cannot set fcm token')
            ];
        } else {
            $response = [
                'success' => true,
                'message' => trans('api.Successfully set fcm token'),
            ];
        }

        return response()->json($response);
    }

    /* public function getLang(object $request): object
    {
        if (auth('api')->check()) {
            $user   = auth('api')->user();
            $code   = empty($request->code) ? $user->language_code ?? 'en' : $request->code;
            $rtl    = empty($request->rtl) ? $user->language_rtl ?? 0 : $request->rtl;
        } else {
            $code   = Settings('language_code') ?? 'en';
            $rtl    = Settings('language_rtl') ?? 0;
        }

        try {
            $path   = resource_path("lang/$code" . "/api.php");
            $values = File::getRequire($path);
        } catch (\Exception $e) {
            $path   = resource_path("lang/en/api.php");
            $values = File::getRequire($path);
        }

        $language = [];
        foreach ($values as $key => $value) {
            $language[$key] = $value;
        }
        $lang = json_decode(json_encode($language), true);

        $data['rtl']    = $rtl;
        $data['code']   = $code;
        $data['lang']   = $lang;
        $response       = [
            'success'   => true,
            'data'      => $data,
            'message'   => trans('api.Getting data'),
        ];

        return response()->json($response, 200);
    } */

    /* public function setLang(object $request): object
    {
        try {
            $language_code  = $request->lang;
            $language       = Language::where('status', 1)->where('code', $language_code)->first();
            $user           = $request->user();
            if ($user) {
                $user->language_id      = $language->id;
                $user->language_code    = $language->code;
                $user->language_name    = $language->name;
                $user->language_rtl     = $language->rtl;
                $user->save();
            }

            $response = [
                'success'   => true,
                'data'      => $language->code,
                'message'   => trans('api.Successfully set lang'),
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    } */

    public function sendOtp(object $request): string
    {
        $user = User::where('email', $request->email)->first();

        if (!isset($user)) {
            throw ValidationException::withMessages(['user' => trans('api.User not found'),]);
        }

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->save();
        SendGeneralEmail::dispatch($user, 'ResetOTP', [
            'otp'   => $user->otp,
            'email' => $user->email,
            'name'  => $user->name,
        ]);
        return $user->otp;
    }

    public function resetPasswordWithOtp(object $request): bool
    {
        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
        if (strlen($request->new_password) >= 8 && $request->new_password == $request->confirm_password) {
            $user->password = bcrypt($request->new_password);
            $user->otp = null;
            $user->save();
            return true;
        } else {
            return false;
        }
    }

    public function logOutDevice(object $request): bool
    {
        $login = UserLogin::find($request->id);
        if (!empty($login->api_token)) {
            DB::table('oauth_access_tokens')->where('id', $login->api_token)->delete();
        }
        auth()->guard('web')->logoutOtherDevices($request->password);
        $login->status = 0;
        $login->logout_at = Carbon::now();
        $login->save();
        return true;
    }
    public function userDetail(): object
    {
        $user = User::where('id', auth()->user()->id)
            ->where('is_active', 1)
            ->first();
        return new UserDetailsResource($user);
    }
    public function deleteSelfAccount(object $request): array
    {
        if (auth()->user()->role_id != 1) {
            $user = User::find(auth()->id());
            if (password_verify($request->password, $user->password)) {
                $user->update(['status' => false]);
                DeleteAccountRequest::create(['user_id' => auth()->id()]);
                $this->logout($request);
            }
            $response = [
                'success'   => true,
                'message'   => trans('api.Account delete submit')
            ];
        }
        return $response;
    }
    private function attemptUserCheck($request)
    {
        $result['type']     = true;
        $result['message']  = '';

        if (auth()->user()->status == 0) {
            auth()->logout();

            $result['type']     = false;
            $result['message']  = trans('api.Your account has been disabled');
            return $result;
        }

        if (auth()->user()->role_id == 3) {
            //device  limit
            $user = auth()->user();
            $time = (int)Settings('device_limit_time');
            $last_activity = $user->last_activity_at;
            if ($time != 0) {
                if (!empty($last_activity)) {
                    $valid_activity = Carbon::parse($last_activity)->addMinutes($time);
                    $current_time = Carbon::now();
                    if ($current_time->lt($valid_activity)) {
                    } else {
                        $login = UserLogin::where('user_id', auth()->id())->where('status', 1)->latest()->first();
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
                    ->where('user_id', auth()->id())->first();
                if (!$exit) {
                    $model = new ClassAttendance;
                    $model->user_id = auth()->id();
                    $model->token = 'my-class';
                    $model->login_at = $today;
                    $model->save();
                }
            }
            $loginController = new LoginController();
            if (!$loginController->multipleLogin($request)) {
                $result['type'] = false;
                $result['message'] = 'Your Account is already logged in, into ' . Settings('device_limit') . ' devices';
                return $result;
            }
        }

        session(['role_id' => auth()->user()->role_id]);
        if (isModuleActive('Chat')) {
            userStatusChange(auth()->id(), 1);
        }

        return $result;
    }
    private function getTokenBySocial($request): array
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user = User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => '',
                'role_id'           => $request->instructor ? 2 : 3,
                'language_id'       => Settings('language_id') ?? '19',
                'language_name'     => Settings('language_name') ?? 'English',
                'language_code'     => Settings('language_code') ?? 'en',
                'language_rtl'      => Settings('language_rtl') ?? '0',
                'country'           => Settings('country_id'),
                'email_verified_at' => now(),
                'referral'          => generateUniqueId(),
            ]);
            applyDefaultRoleToUser($user);
        } else {
            $user->name = $request->name;
            $user->save();
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $result = $token->save();


        if ($result) {
            $request->merge([
                'api_token' => $token->id,
            ]);
            return [
                'access_token'  => $tokenResult->accessToken,
                'token_type'    => 'Bearer',
                'is_verify'     => (bool)$user->email_verified_at,
                'expires_at'    => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user' => new AuthUserDetailResource($user),
            ];
        }

        // if (!$result) {
        //     $response = [
        //         'success'   => false,
        //         'data'      => null,
        //         'message'   => trans('api.Something went wrong'),
        //     ];
        // } else {
        //     $request->merge([
        //         'api_token' => $token->id,
        //     ]);

        //     $response = [
        //         'success'   => true,
        //         'data'      => $data,
        //         'message'   => trans('api.Successfully login'),
        //     ];
        // }

        // return response()->json($response);
    }

    public function demoLoginData(): array
    {
        if (Config::get('app.demo_mode')) {
            $data['admin_email'] = User::whereHas('role', function ($role) {
                $role->where('name', 'Super admin');
            })->first()->email;
            $data['instructor_email'] = User::whereHas('role', function ($role) {
                $role->where('name', 'Instructor');
            })->first()->email;
            return $data;
        } else {
            return [];
        }
    }

    public function demoLogin(object $request, ?string $role): array
    {
        if (Config::get('app.demo_mode') && in_array($role, ['admin', 'instructor'])) {
            $user = User::when($role == 'admin', function ($q) {
                $q->whereHas('role', function ($r) {
                    $r->where('name', 'Super admin');
                });
            })
                ->when($role == 'instructor', function ($q) {
                    $q->whereHas('role', function ($r) {
                        $r->where('name', 'Instructor');
                    });
                })
                ->first();

            if ($request->get('email') != $user->email) {
                throw ValidationException::withMessages(['email' => trans('validation.email.exists')]);
            }

            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            $data = [
                'access_token'  => (string)$tokenResult->accessToken,
                'token_type'    => 'Bearer',
                'is_verify'     => (bool)$user->email_verified_at,
                'expires_at'    => (string)Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user' => new AuthUserDetailResource($user),
            ];
        } else {
            $data = [];
        }
        return $data;
    }
}
