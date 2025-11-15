<?php

namespace App\Http\Middleware;

use App\UserLogin;
use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class CheckUserActiveStatus
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Session::has('impersonated')) {
            if (Auth::user()->status == 0) {
                Auth::logout();
                Toastr::error(trans('frontend.Your account is inactive.') . ' ' . trans('frontend.Contact the administrator for assistance.'), trans('common.Failed'));
                 return redirect('/');
            }

            $time = (int)Settings('device_limit_time');
            if (Auth::check() && Auth::user()->role_id == 3 && $time != 0) {
                $total = UserLogin::where([
                    'user_id' => Auth::id()])->count();
                if ($total > 1) {
                    $login = UserLogin::where([
                        'user_id' => Auth::id(),
                        'token' => session('login_token'),
                        'status' => 1
                    ])->count();
                    if (!$login) {
                        Auth::logout();
                        Toastr::error(trans('frontend.Logout from other device'), trans('common.Failed'));
                        return redirect('/');
                    }
                }
            }

            if (isModuleActive('TwoFA')) {
                $currentRoute = Route::currentRouteName();
                $allowRoutes = [
                    '2fa',
                    'logout'
                ];
                $user = Auth::user();

                if ($user->role_id==3){
                    $tfaStatus =(int)Settings('enable_student_two_fa');
                }else{
                    $tfaStatus =(int)Settings('enable_two_fa');
                }
                if ($tfaStatus && !in_array($currentRoute, $allowRoutes) && $user->two_step_verification == 2) {

                    $authenticator = app(Authenticator::class)->boot($request);
                    if (!$authenticator->isAuthenticated()) {
                        return $authenticator->makeRequestOneTimePasswordResponse();
                    }
                }
            }
        }

        return $next($request);
    }
}
