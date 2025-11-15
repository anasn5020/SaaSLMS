<?php

namespace App\View\Components;


use Illuminate\View\Component;
use Modules\SystemSetting\Entities\SocialLink;

class ContactPageSection extends Component
{

    public function render()
    {
        $data = [];
        if ((Settings('frontend_active_theme') == "teachery")) {
            $data['social'] = SocialLink::where('status', 1)->get();
        }
        return view(theme('components.contact-page-section'), $data);
    }
}
