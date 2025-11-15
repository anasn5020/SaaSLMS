<?php

namespace App\Http\Controllers;

class StoreGoogleAnalyticsClientIdController extends Controller
{
    public function __invoke(): void
    {
        session(['google-analytics-4-measurement-protocol.client_id' => request('client_id')]);
    }
}
