<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Subscription\Entities\CourseSubscription;
use Modules\Subscription\Entities\PlanFeature;

class HomePageCallToAction extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        $plan = CourseSubscription::orderBy('order', 'asc')->first();
        $features = PlanFeature::orderBy('order', 'asc')->get();
        return view(theme('components.home-page-call-to-action'),compact('plan','features'));
    }
}