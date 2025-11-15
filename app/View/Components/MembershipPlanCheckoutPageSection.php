<?php

namespace App\View\Components;

use App\Repositories\CommonRepositoryInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Membership\Entities\MembershipCart;
use Modules\Membership\Entities\MembershipPlanCheckout;

class MembershipPlanCheckoutPageSection extends Component
{
    protected $plan;
    protected $price;
    protected $request;
    public function __construct(
        CommonRepositoryInterface $commonRepository,
        $request, $plan, $price
    ) {
        $this->s_plan = $plan;
        $this->price = $price;
        $this->request = $request;
        $this->commonRepository = $commonRepository;
    }


    public function render()
    {
        $type = $this->request->type;
        $data['s_plan']  = $this->plan;
        $user = Auth::user() ? Auth::user() : session()->get('membershipUser');

        if (!$user) {
            Toastr::error(trans('common.Operation failed'), trans('common.Error'));
            return redirect()->back();
        }

        $data['cart'] = MembershipCart::where('user_id', $user->id)->first();
        if ($data['cart']) {
            $tracking = $data['cart']->tracking;
        } else {
            $tracking = '';
        }

        if ($user->role_id == 3) {
            $total = MembershipCart::where('user_id', $user->id)->sum('price');
        }

        $checkout = MembershipPlanCheckout::where('tracking', $tracking)->where('user_id', $user->id)->latest()->first();
        if (!$checkout) {
            $checkout = new MembershipPlanCheckout();
        }


        $checkout->discount = 0.00;

        $checkout->tracking = $tracking;
        $checkout->user_id = $user->id;
        $checkout->price = $total;
        if (hasTax()) {
            $checkout->purchase_price = applyTax($total);
            $checkout->tax = taxAmount($total);
        } else {
            $checkout->purchase_price = $total;
        }
        $checkout->status = 0;
        $checkout->coupon_id = null;
        $checkout->save();

        $data += $this->commonRepository->billingInfo($type);

        return view(theme('components.membership-plan-checkout-page-section'), $data);
    }
}
