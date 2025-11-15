<?php

namespace App\View\Components;

use App\AboutPage;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Modules\FrontendManage\Entities\Sponsor;

class AboutPageBrand extends Component
{

    public function render()
    {
        $sponsors = Cache::rememberForever('SponsorList_'. app()->getLocale().SaasDomain(), function () {
            return Sponsor::where('status', 1)
                ->get();
        });
        $about = AboutPage::getData();
        return view(theme('components.about-page-brand'), compact('sponsors', 'about'));
    }
}
