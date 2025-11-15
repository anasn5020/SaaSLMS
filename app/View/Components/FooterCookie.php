<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Modules\Setting\Entities\CookieSetting;

class FooterCookie extends Component
{

    public function render()
    {
        $cookie = Cache::rememberForever('cookie_'.SaasDomain(), function () {
            return CookieSetting::getData();
        });
        return view(theme('components.footer-cookie'), compact('cookie'));
    }
}
