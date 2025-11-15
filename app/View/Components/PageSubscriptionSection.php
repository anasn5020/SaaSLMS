<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Subscription\Entities\CourseSubscription;
use Modules\Subscription\Entities\PlanFeature;

class PageSubscriptionSection extends Component
{

    public function render()
    {
        $plan = CourseSubscription::where('status', 1)->orderBy('days', 'desc')->first();  
        $plan_features = PlanFeature::where('status', 1)->orderBy('order', 'asc')->get();
        return view(theme('components.page-subscription-section'), compact('plan', 'plan_features'));
    }
}