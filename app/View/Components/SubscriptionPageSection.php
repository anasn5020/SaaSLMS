<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Category;
use Modules\Subscription\Entities\CourseSubscription;
use Modules\Subscription\Entities\Faq;
use Modules\Subscription\Entities\PlanFeature;
use Modules\Subscription\Entities\SubscriptionSetting;

class SubscriptionPageSection extends Component
{

    public function render()
    {
        $faqs = Faq::where('status', 1)->orderBy('order')->get();
        $plans = CourseSubscription::where('status', 1)
            ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
            ->when(request('plan'), fn($q) => $q->where('id', request('plan')))
            ->orderBy('order')->get();
        $plan_features = PlanFeature::where('status', 1)->orderBy('order')->get();
        $categories = Category::where('status', 1)->orderBy('position_order')->get();
        $setting = SubscriptionSetting::getData();
        return view(theme('components.subscription-page-section'), compact('faqs', 'plans', 'plan_features', 'setting', 'categories'));
    }
}
