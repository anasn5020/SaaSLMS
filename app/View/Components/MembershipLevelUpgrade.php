<?php

namespace App\View\Components;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\View\Component;
use Modules\Membership\Entities\MembershipPlanCheckout;
use Modules\Membership\Entities\PlanLevel;

class MembershipLevelUpgrade extends Component
{
    public $planId;
    public function __construct($planId)
    {
       $this->planId = $planId;
    }

    public function render()
    {

        $planId = $this->planId;
        $user = auth()->user();
        $checkout = MembershipPlanCheckout::where('plan_id', $planId)->where('user_id', $user->id)->first();
        if(!$checkout) {
            Toastr::warning(trans('membership. Your are not purchase ever!!'), trans('common.Warning'));
            return redirect()->back();
        }
        $planLevels = PlanLevel::where('membership_plan_id', $planId)->where('status', 1)->get();
        $plan = $checkout->plan;
        return view(theme('components.membership-level-upgrade'), compact('planLevels', 'checkout', 'plan'));
    }
}
