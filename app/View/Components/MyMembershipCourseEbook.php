<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Membership\Entities\MembershipPlan;
use Modules\Membership\Repositories\Interfaces\PlanRepositoryInterface;

class MyMembershipCourseEbook extends Component
{
    public $planId;
    protected $membershipPlanRepository;
    public function __construct(
        PlanRepositoryInterface $membershipPlanRepository,
        $planId)
    {

        $this->planId = $planId;
        $this->membershipPlanRepository = $membershipPlanRepository;
    }
    public function render()
    {
        $planId = $this->planId;
        $plan = MembershipPlan::with('courses', 'ebooks')->withCount('students', 'courses', 'ebooks')->where('id', $planId)->first();
        $data['courses'] = $plan->courses;
        $data['ebooks'] = $plan->ebooks;
        $data['membership'] = $plan->title .'['. $plan->level->title .']';
        return view(theme('components.my-membership-course-ebook'), $data);
    }
}
