<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ContactPageMap extends Component
{

    public function render()
    {
        return view(theme('components.contact-page-map'));
    }
}
