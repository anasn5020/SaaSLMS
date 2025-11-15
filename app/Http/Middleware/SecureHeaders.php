<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $response->headers->set('X-Frame-Options', 'DENY');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
//            $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()'); // Uncomment if you want to disable geolocation, microphone, and camera access (InAppLiveClass neeed enable microphone and camera)
            $response->headers->set('X-XSS-Protection', '1; mode=block');

            $allowedOriginsFile = base_path('.allowedOrigins');
            if (file_exists($allowedOriginsFile)) {
                $csp = file_get_contents($allowedOriginsFile);
                $csp = preg_replace("/(\/[^>]*>)([^<]*)(<)/","\\1\\3",$csp);
                $csp = preg_replace("/[\r\n]*/","",$csp);

                $response->headers->set('Content-Security-Policy', $csp);
            }
        }

        return $response;
    }
}
