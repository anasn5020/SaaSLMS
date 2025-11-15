<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function fallback($notFound)
    {
        return response()->json(['message' => 'The ' . $notFound . ' route is not found'], 404);
    }
}
