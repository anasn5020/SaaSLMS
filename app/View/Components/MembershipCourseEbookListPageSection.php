<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Membership\Entities\MembershipPlan;

class MembershipCourseEbookListPageSection extends Component
{
    public $id;

    public function __construct($id)
    {
        $this->plan_id = $id;
    }

    public function render()
    {
        $id = $this->plan_id;
        $plan = MembershipPlan::with('courses', 'ebooks')->withCount('students', 'courses', 'ebooks')->where('id', $id)->first();

        return view(theme('components.membership-course-ebook-list-page-section'), compact('plan'));
    }
}
