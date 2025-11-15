<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class AccountDeleteSection extends Component
{

    public function __construct()
    {
        //
    }


    public function render()
    {
        $account = Auth::user();
        return view(theme('components.account-delete-section'), compact('account'));
    }
}
