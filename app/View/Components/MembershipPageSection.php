<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Membership\Entities\MembershipPlan;

class MembershipPageSection extends Component
{

    public function __construct()
    {
    }
    public function render()
    {
        $faqs = null;
        $plans = MembershipPlan::where('status', 1)->orderBy('position_order', 'asc')->get();
        $plan_features = null;
        $setting = null;
        return view(theme('components.membership-page-section'), compact('faqs', 'plans', 'plan_features', 'setting'));
    }
}
