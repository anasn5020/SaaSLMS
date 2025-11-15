<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Subscription\Entities\CourseSubscription;
use Modules\Subscription\Entities\SubscriptionCourseList;
use Modules\Subscription\Entities\SubscriptionSetting;

class SubscriptionCourseListPageSection extends Component
{
    public $id;

    public function __construct($id)
    {
        $this->plan_id = $id;
    }


    public function render()
    {
        $plan = CourseSubscription::findOrFail($this->plan_id);
        $lists = SubscriptionCourseList::where('plan_id', $plan->id)->with('course','course.enrollUsers','course.cartUsers','course.lessons')->paginate(12);
        $setting = SubscriptionSetting::getData();
        return view(theme('components.subscription-course-list-page-section'), compact('plan', 'lists', 'setting'));
    }
}
