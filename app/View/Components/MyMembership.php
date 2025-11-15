<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Membership\Entities\MembershipPlanCheckout;
use Modules\Membership\Repositories\Interfaces\MembershipSettingsRepositoryInterface;

class MyMembership extends Component
{
    protected $membershipSettings;

    public function __construct(
        MembershipSettingsRepositoryInterface $membershipSettings
    )
    {
        $this->membershipSettings = $membershipSettings;
    }

    public function render()
    {
        $user = auth()->user();
        $data['settings'] = $this->membershipSettings->settings();
        $data['checkouts'] = MembershipPlanCheckout::with('plan', 'user')
            ->where('user_id', $user->id)->whereNotNull('plan_id')->get();
        return view(theme('components.my-membership'), $data);
    }
}
