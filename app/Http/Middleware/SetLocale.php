<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $lang = $user->language_code ?? 'en';
        } else {
            if (session()->get('locale')) {
                $lang = session()->get('locale') ?? 'en';
            } else {
                $lang = Settings('language_code') ?: 'en';
            }
        }

        $lang = is_string($lang) ? $lang : 'en';

        App::setLocale($lang);
        return $next($request);
    }
}
