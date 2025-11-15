<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;
use Modules\FrontendManage\Entities\Slider;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;
use Modules\OrgSubscription\Entities\OrgSubscriptionCheckout;

class MyOrgSubscriptionPlanSection extends Component
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }


    public function render()
    {
        $query = OrgSubscriptionCheckout::where('user_id', Auth::user()->id)->with('plan', 'plan.assign');
        $search = $this->request->search;
        if (!empty($search)) {
            $query->whereHas('plan', function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%");
            });
        }
        $order = $this->request->order;
        $type2 = $this->request->type2;
        if ($order == 'title') {
            $query->orderBy(
                OrgCourseSubscription::select('title')
                    ->whereColumn('plan_id', 'org_course_subscriptions.id')
                    ->orderBy('title')
                    ->limit(1)
            );
        } elseif ($order == 'start_date') {
            $query->orderBy('start_date');
        } elseif ($order == 'end_date') {
            $query->orderBy('end_date');
        }

        if (!empty($type2)) {
            if ($type2 == 'class') {
                $query->whereHas('plan', function ($q) use ($search) {
                    $q->where('type', 1);
                });
            }
            if ($type2 == 'path') {
                $query->whereHas('plan', function ($q) use ($search) {
                    $q->where('type', 2);
                });
            }
            $type = $type2;
        } else {
            $type = 'all';
        }


        $plans = $query->get();
        $sliders = Slider::where('status', 1)->get();
        return view(theme('components.my-org-subscription-plan-section'), compact('plans', 'sliders', 'type'));
    }
}
