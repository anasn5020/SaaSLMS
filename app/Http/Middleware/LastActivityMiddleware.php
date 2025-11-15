<?php

namespace App\Http\Middleware;

use App\Events\LastActivityEvent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LastActivityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $time = (int)Settings('device_limit_time');

        if (Auth::check() && Auth::user()->role_id == 3 && $time != 0) {
            event(new LastActivityEvent());
        }
        return $next($request);
    }
}
