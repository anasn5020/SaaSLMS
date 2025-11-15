<?php

namespace App\View\Components;

use App\Repositories\CommonRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Membership\Entities\MembershipPlanCheckout;

class MembershipPaymentPageSection extends Component
{
    public $cart, $bill, $plan, $commonRepository;

    public function __construct(
        CommonRepositoryInterface $commonRepository,$cart, $bill, $plan)
    {

        $this->cart = $cart;
        $this->bill = $bill;
        $this->plan = $plan;
        $this->commonRepository= $commonRepository;
    }

    public function render()
    {
        $user = Auth::user();
        $this->cart->billing_detail_id = $this->bill->id;
        $this->cart->save();
        $data['checkout'] = MembershipPlanCheckout::where('tracking', $this->cart->tracking)->where('user_id', $user->id)->latest()->first();
       $data +=$this->commonRepository->billingInfo();
        return view(theme('components.membership-payment-page-section'), $data);
    }
}
