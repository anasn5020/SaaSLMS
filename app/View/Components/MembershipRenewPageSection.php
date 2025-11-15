<?php

namespace App\View\Components;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\View\Component;
use Modules\Membership\Entities\MembershipPlan;
use Modules\Membership\Entities\MembershipPlanCheckout;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;

class MembershipRenewPageSection extends Component
{
    public $plan;
    public $checkoutId;
    public function __construct($planId, $checkoutId)
    {
        $this->plan = $planId;
        $this->checkoutId = $checkoutId;
    }
    public function render()
    {
        $plan_id = $this->plan;
        $checkout_id = $this->checkoutId;
        $user = auth()->user();
        $exit = MembershipPlanCheckout::where('id', $checkout_id)->where('user_id', $user->id)->first();
        if (!$exit) {
            Toastr::warning(trans('membership.Sorry!You have not Buy Ever!!'), trans('common.Warning'));
            return redirect()->route('membership.myMembership');
        }
        $data['membershipPlan'] = MembershipPlan::findOrFail($plan_id);
        $data['plan_id'] = session()->put('plan_id', $plan_id);
        $data['checkout_id'] = session()->put('checkout_id', $checkout_id);
        $data['methods'] = PaymentMethod::where('active_status', 1)->where('module_status', 1)->where('method', '!=', 'Bank Payment')->where('method', '!=', 'Offline Payment')->get(['method', 'logo']);
        return view(theme('components.membership-renew-page-section'), $data);
    }
}
