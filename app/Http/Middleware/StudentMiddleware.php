<?php

namespace App\Http\Middleware;

use App\Events\LastActivityEvent;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

class StudentMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {
            if (!$request->user() ||
                ($request->user() instanceof MustVerifyEmail &&
                    !$request->user()->hasVerifiedEmail())) {
                return $request->expectsJson()
                    ? abort(403, 'Your email address is not verified.')
                    : Redirect::route('verification.notice');
            }
            return $next($request);
        } elseif (Auth::check() && (Auth::user()->role_id != 1 && Auth::user()->role_id != 3)) {
            $allowRoutes = [
                'CheckOut',
                'invoice',
                'enrollmentCancellationSubmit',
                'getCertificate',
                'getCertificate'
            ];
            $currentRoute = Route::currentRouteName();
            if (in_array($currentRoute, $allowRoutes)) {
                return $next($request);
            }
            return redirect()->to(route('dashboard'));
        } elseif (Auth::check() && Auth::user()->role_id == 1) {
            return redirect()->to(route('dashboard'));
        } else {
            return redirect()->to('/login');
        }
    }

}


