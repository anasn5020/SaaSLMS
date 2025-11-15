<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MyCartWithOutLoginPageSection extends Component
{

    public function render()
    {
        return view(theme('components.my-cart-with-out-login-page-section'));
    }
}
