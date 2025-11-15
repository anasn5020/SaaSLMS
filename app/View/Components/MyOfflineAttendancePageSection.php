<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\OrgSubscription\Entities\OrgAttendance;

class MyOfflineAttendancePageSection extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        $query = OrgAttendance::query();
        $query->with('course', 'user');
        $query->where('user_id', Auth::id());
        $attendances = $query->get();
        return view(theme('components.my-offline-attendance-page-section'), compact('attendances'));
    }
}
