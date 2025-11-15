<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Impersonate
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('impersonated')) {
            Auth::onceUsingId(session()->get('impersonated'));
        }

        return $next($request);
    }
}
