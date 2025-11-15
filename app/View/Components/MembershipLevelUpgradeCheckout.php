<?php

namespace App\View\Components;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\View\Component;
use Modules\Membership\Entities\MembershipPlanCheckout;
use Modules\Membership\Entities\PlanLevel;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;

class MembershipLevelUpgradeCheckout extends Component
{
    public $levelId, $checkoutId;
    public function __construct($levelId, $checkoutId)
    {
        $this->levelId = $levelId;
        $this->checkoutId = $checkoutId;
    }
    public function render()
    {
        $user = auth()->user();
        $level_id = $this->levelId;
        $checkout_id = $this->checkoutId;
        $checkout = MembershipPlanCheckout::where('id', $checkout_id)->where('user_id', $user->id)->first();
        if(!$checkout) {
            Toastr::warning(trans('membership. Your are not purchase ever!!'), trans('common.Warning'));
            return redirect()->back();
        }
        $data['planLevel'] = PlanLevel::where('membership_plan_id', $checkout->plan_id)->where('membership_level_id', $level_id)->where('status', 1)->first();
        $data['membershipPlan'] = $checkout->plan;
        $data['methods'] = PaymentMethod::where('active_status', 1)->where('module_status', 1)->where('method', '!=', 'Bank Payment')->where('method', '!=', 'Offline Payment')->get(['method', 'logo']);
        session()->put('planLevel_id', $level_id);
        session()->put('planLevel_checkout_id', $checkout_id);
        return view(theme('components.membership-level-upgrade-checkout'), $data);
    }
}
