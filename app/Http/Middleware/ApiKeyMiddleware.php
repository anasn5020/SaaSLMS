<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        if (!empty(Settings('api_key'))) {
            $header = $request->header('ApiKey');
            if ($header != Settings('api_key')) {
                abort(response()->json([
                    'success' => false,
                    'message' => 'Unauthorized! Api key is not valid',
                ], 403));
            }
        }
        return $next($request);
    }
}
