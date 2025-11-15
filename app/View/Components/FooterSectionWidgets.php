<?php

namespace App\View\Components;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Modules\FooterSetting\Entities\FooterSetting;
use Modules\FooterSetting\Entities\FooterWidget;

class FooterSectionWidgets extends Component
{


    public function render()
    {
        $sectionWidgetsData = Cache::rememberForever('sectionWidgets_' . app()->getLocale() . SaasDomain(), function () {
            return FooterWidget::where('status', 1)
                ->with('frontpage')
                ->get();
        });

        $sectionWidgets['one'] = $sectionWidgetsData->where('section', '1');
        $sectionWidgets['two'] = $sectionWidgetsData->where('section', '2');
        $sectionWidgets['three'] = $sectionWidgetsData->where('section', '3');
        if (Settings('frontend_active_theme') == 'tvt') {
            $sectionWidgets['four'] = $sectionWidgetsData->where('section', '4');
        }
        return view(theme('components.footer-section-widgets'), compact('sectionWidgets'));
    }
}
