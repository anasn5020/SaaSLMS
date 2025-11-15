<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaintenanceModeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the application is resetting
        if (Storage::has('.app_resetting')) {
            return $this->handleAppResetting($request);
        }

        // Check if maintenance mode is enabled for unauthenticated users
        if (!Auth::check() && Settings('maintenance_status') == 1) {
            return $this->handleMaintenanceMode($request);
        }

        // Continue to the next middleware
        return $next($request);
    }

    private function handleAppResetting(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*') || $request->ajax()) {
            return response()->json([
                'success' => false,
                'type' => 'reset',
                'message' => 'The application is currently resetting. Please try again later.',
            ], 503);
        }

        return new Response(view('reset'));
    }

    private function handleMaintenanceMode(Request $request)
    {
        $maintain = collect();
        $maintain->maintenance_title = HomeContents('maintenance_title');
        $maintain->maintenance_sub_title = HomeContents('maintenance_sub_title');
        $maintain->maintenance_banner = HomeContents('maintenance_banner');

        if ($request->expectsJson() || $request->is('api/*') || $request->ajax()) {
            return response()->json([
                'success' => false,
                'type' => 'maintenance',
                'message' => 'The application is currently in maintenance mode. Please try again later.',
            ], 503);
        }

        return new Response(view(theme('pages.maintenance'), compact('maintain')));
    }
}
