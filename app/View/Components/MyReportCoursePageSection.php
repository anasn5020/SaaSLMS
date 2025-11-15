<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\OrgSubscription\Http\Controllers\OrgSubscriptionReportController;

class MyReportCoursePageSection extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        $query = CourseEnrolled::where('user_id', Auth::id())->latest();
        if (Settings('frontend_active_theme') == 'wetech') {
            $courses = $query->get();
        } else {
            $courses = $query->paginate(5);
        }
        return view(theme('components.my-report-course-page-section'), compact('courses'));
    }
}
