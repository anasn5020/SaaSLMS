<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MyMembershipDashboardPageSection extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view(theme('components.my-membership-dashboard-page-section'));
    }
}
