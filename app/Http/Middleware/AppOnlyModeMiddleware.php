<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Frontend\WebsiteController;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class AppOnlyModeMiddleware
{
    public function handle($request, Closure $next)
    {

        if (Settings('mobile_app_only_mode') == 1) {
            $website = new WebsiteController();
            return new response($website->onlyAppMode());
        }
        return $next($request);
    }
}
