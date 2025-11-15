<?php

namespace App\View\Components;

use App\Traits\Tenantable;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
use Modules\FrontendManage\Entities\Sponsor;

class HomePageBrandSection extends Component
{
    use Tenantable;
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        $sponsors = Cache::rememberForever('SponsorList_'. app()->getLocale().SaasDomain(), function () {
            return Sponsor::where('status', 1)
                ->get();
        });
        return view(theme('components.home-page-brand-section'), compact('sponsors'));
    }
}
