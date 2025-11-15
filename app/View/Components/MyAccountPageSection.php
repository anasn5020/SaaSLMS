<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class MyAccountPageSection extends Component
{

    public function render()
    {
        $account = Auth::user();
        return view(theme('components.my-account-page-section'), compact('account'));
    }
}
