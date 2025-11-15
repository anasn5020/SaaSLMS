<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Payment\Entities\Checkout;

class BundleSubscriptionMyCoursePageSection extends Component
{

    public function __construct()
    {
        //
    }

    public function render()
    {
        $checkouts = Checkout::where('user_id', Auth::id())->whereNotNull('bundle_id')->with('courses', 'bundle')->latest()->paginate(5);

        return view(theme('components.bundle-subscription-my-course-page-section'), compact('checkouts'));
    }
}
