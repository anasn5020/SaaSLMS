<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Payment\Entities\Cart;

class MyCartWithLoginPageSection extends Component
{

    public function render()
    {
        $carts = Cart::where('user_id', Auth::id())->with('course', 'course.user')->get();
        return view(theme('components.my-cart-with-login-page-section'), compact('carts'));
    }
}
