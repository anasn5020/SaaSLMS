<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Coupons\Entities\UserWiseCoupon;

class ReferalPageSection extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $referrals = UserWiseCoupon::where('invite_by', Auth::user()->id)
            ->where('course_id', '!=', null)
            ->leftjoin('users', 'users.id', '=', 'user_wise_coupons.invite_accept_by')
            ->get();
        return view(theme('components.referal-page-section'), compact('referrals'));
    }
}
