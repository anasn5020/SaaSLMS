<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Subscription\Entities\CourseSubscription;
use Modules\Subscription\Entities\SubscriptionSetting;

class HomePageSubscriptionPlanSection extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
            $setting = SubscriptionSetting::getData();
            $plans = CourseSubscription::where('status', 1)->orderBy('order', 'desc')->limit(3)->get();
            return view(theme('components.home-page-subscription-plan-section'),compact('setting','plans'));
    }
}
