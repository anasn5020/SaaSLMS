<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApi2Fa
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && ($user->two_step_verification == 1 || $user->two_step_verification == 3 || $user->two_step_verification == 4)) {
            if (!$user->token()->tfa) {
                abort(response()->json([
                    'success' => false,
                    'tfa' => false,
                    'message' => '2Fa is not verified by user',
                ], 403));
            }
        }
        return $next($request);
    }
}
