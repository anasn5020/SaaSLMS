<?php

namespace App\Http\Controllers\Api\V2;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Validation\ValidationException;
use App\Repositories\Interfaces\AuthRepositoryInterface;

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

    protected $authRepository;

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

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function signup(Request $request): object
    {
        $rules = [
            'name'                  => 'required|string',
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'nullable|string|unique:users,phone',
            'password'              => 'required|confirmed|string|min:8',
            'password_confirmation' => 'required|same:password|string',
            'type'                  => 'nullable|string'
        ];

        $request->validate($rules, validationMessage($rules));
        $data = $this->authRepository->signup($request);
        $response = [
            'success'   => true,
            'data'      => $data['data'],
            'message'   => $data['role'] == 2 ? trans('api.Successfully created instructor') : trans('api.Successfully created user')
        ];

        return response()->json($response);
    }


    public function verifyEmail(Request $request): object
    {
        $rules = [
            'email' => 'required|exists:users,email',
            'type' => 'required|string',
            'otp' => 'required'
        ];

        $request->validate($rules, validationMessage($rules));
        $data = $this->authRepository->verifyEmail($request);
        return response()->json($data['response'], $data['status']);
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
    public function login(Request $request): object
    {
        $rules = [
            'email'         => 'required|string|exists:users,email',
            'password'      => 'required|string',
            'remember_me'   => 'nullable|boolean'
        ];

        $request->validate($rules, validationMessage($rules));

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $fieldType => $request->email,
            'password' => $request->password
        ];

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => trans('api.Credential not mathch'),
            ], 401);
        }

        $user = $request->user();

        if (auth()->attempt($credentials) && Settings('email_verification') == 1 && $user->email_verified_at == false) {
            return response()->json([
                'success' => false,
                'message' => trans('api.Please verify your email address'),
            ], 401);
        }

        $data = $this->authRepository->login($request);

        if (empty($data)) {
            $status = Response::HTTP_UNAUTHORIZED;
            $response = [
                'success'   => false,
                'message'   => trans('api.Email is not verified')
            ];
        } else {
            checkGamification('each_login', 'activity');
            $response = [
                'success'   => true,
                'data'      => $data,
                'message'   => trans('api.Successfully login')
            ];
        }

        return response()->json($response, $status ?? 200);
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
    public function user(Request $request): object
    {
        return $this->authRepository->user($request);
    }

    public function socialLogin(Request $request): object
    {
        $rules = [
            'provider_id'   => 'required',
            'provider_name' => 'required',
            'name'          => 'nullable',
            'email'         => 'nullable',
            'token'         => 'required',
            'instructor'    => 'nullable|boolean',
        ];
        $request->validate($rules, validationMessage($rules));

        if (!empty($this->authRepository->socialLogin($request))) {
            $response = [
                'success' => true,
                'data' => $this->authRepository->socialLogin($request),
                'message' => trans('api.Successfully login')
            ];
        } else {
            $response = [
                'success'   => false,
                'data'      => null,
                'message'   => trans('api.Something went wrong'),
            ];
            $status = 503;
        }


        // return $this->authRepository->socialLogin($request);

        return response()->json($response, $status ?? 200);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request): object
    {
        $this->authRepository->logout($request);

        $response = [
            'success' => true,
            'message' => trans('api.Successfully logged out'),
        ];
        return response()->json($response);
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
    public function changePassword(Request $request): object
    {
        $rules = [
            'old_password'      => 'required',
            'new_password'      => 'required|min:8',
            'confirm_password'  => 'required|same:new_password'
        ];
        $request->validate($rules, validationMessage($rules));
        $data = $this->authRepository->changePassword($request);
        return response()->json($data['data'], $data['status_code']);
    }

    // public function accountDelete(Request $request): object
    // {
    //     return $this->authRepository->accountDelete($request);
    // }

    public function setFcmToken(Request $request): object
    {
        return $this->authRepository->setFcmToken($request);
    }

    /* public function getLang(Request $request): object
    {
        return $this->authRepository->getLang($request);
    }

    public function setLang(Request $request): object
    {
        return $this->authRepository->setLang($request);
    } */

    public function sendOtp(Request $request): object
    {
        return response()->json([
            'success' => true,
            'otp' => $this->authRepository->sendOtp($request),
            'message' => trans('api.OTP send successful'),
        ]);
    }


    public function resetWithOtp(Request $request): object
    {
        $rules = [
            'new_password' => 'required|min:8',
            'confirm_password' => 'required_with:new_password|same:new_password',
        ];
        $request->validate($rules, validationMessage($rules));
        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
        if (!$user) {
            $response = [
                'success' => false,
                'message' => trans('api.Invalid OTP or Email')
            ];
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        } else {
            $this->authRepository->resetPasswordWithOtp($request);
            $response = [
                'success' => true,
                'message' => trans('api.Password changed successful'),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    public function logOutDevice(Request $request): object
    {
        if (!password_verify($request->password, auth('api')->user()->password)) {
            $response = [
                'success' => false,
                'message' => trans('frontend.Your Password Doesnt Match'),
            ];
            return response()->json($response, 200);
        }
        if ($request->type == "logout") {
            $this->authRepository->logOutDevice($request);

            $response = [
                'success' => true,
                'message' => trans('frontend.Logged Out SuccessFully'),
            ];
        } else {
            $response = [
                'success' => true,
                'message' => trans('api.Operation successful'),
            ];
        }
        return response()->json($response, 200);
    }

    public function userDetail(): object
    {
        $response = [
            'success'   => true,
            'data'      => $this->authRepository->userDetail(),
            'message'   => trans('api.Operation successful')
        ];
        return response($response);
    }

    public function deleteSelfAccount(Request $request): object
    {
        $rules = ['password' => 'required|current_password:api'];
        $request->validate($rules, validationMessage($rules));
        $response = $this->authRepository->deleteSelfAccount($request);
        return response()->json($response);
    }

    public function demoLoginData()
    {
            return response()->json([
                'success' => true,
                'data' => $this->authRepository->demoLoginData(),
                'message' => trans('api.Getting demo credentials successfully'),
            ]);
     
    }

    public function demoLogin(Request $request, ?string $role): object
    {
        $rules = [
            'email'         => 'required|string|email',
            'password'      => 'required|string',
        ];
        $request->validate($rules, validationMessage($rules));

        if ($request->get('password') != '12345678') {
            throw ValidationException::withMessages(['password' => trans('validation.password.current_password')]);
        }

         
        return response()->json([
            'success' => true,
            'data' => $this->authRepository->demoLogin($request, $role),
            'message' => trans('api.Successfully login'),
        ]);
       
    }
}
