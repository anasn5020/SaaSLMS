<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class DemoPreventMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Config::get('app.demo_mode')) {
            $msg=  trans('common.For the demo version, you cannot change this');
            if ($request->wantsJson()) {
                return response()->json(['message' => $msg], 422);
            } else {
                Toastr::error($msg, trans('common.Failed'));
            }
            return redirect()->back();
        }

        return $next($request);
    }
}
