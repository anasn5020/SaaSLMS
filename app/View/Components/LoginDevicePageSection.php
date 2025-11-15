<?php

namespace App\View\Components;

use App\UserLogin;
use Illuminate\View\Component;

class LoginDevicePageSection extends Component
{

    public function render()
    {
        $logins = UserLogin::where('user_id', auth()->id())->where('status', 1)->get();
        return view(theme('components.login-device-page-section'), compact('logins'));
    }
}
