<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\LmsSaas\Entities\SaasPlan;
use Modules\LmsSaasMD\Entities\SaasPlan as SaasPlanMD;
use Modules\Subscription\Entities\SubscriptionSetting;

class SaasPageSection extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (isModuleActive('LmsSaas')) {
            $plans = SaasPlan::on(env('DB_CONNECTION'))->where('status', 1)->orderBy('order')->get();
        } else {
            $plans = SaasPlanMD::on(env('DB_CONNECTION'))->where('status', 1)->orderBy('order')->get();
        }
        $setting = [];
        return view(theme('components.saas-page-section'), compact('plans', 'setting'));
    }
}
