<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RewardPointController extends Controller
{
    public function index()
    {
        return view(theme('pages.reward'));
    }
}
