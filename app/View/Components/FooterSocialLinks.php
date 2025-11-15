<?php

namespace App\View\Components;

use App\Traits\Tenantable;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Modules\SystemSetting\Entities\SocialLink;

class FooterSocialLinks extends Component
{
    use Tenantable;
    public function render()
    {
        $social_links = Cache::rememberForever('social_links_'.SaasDomain(), function () {
            return SocialLink::select('link', 'icon', 'name')
                ->where('status', '=', 1)
                ->get();
        });
        return view(theme('components.footer-social-links'), compact('social_links'));
    }
}
