<?php

namespace App\View\Components;


use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\CourseSetting\Entities\CourseEnrolled;

class MyBundlePageSection extends Component
{

    public function render()
    {

        $bundle_ids = CourseEnrolled::select('bundle_course_id')->where('user_id', Auth::id())->where('bundle_course_id', '!=', 0)->distinct()->get()->pluck('bundle_course_id')->toArray();
        $BundleCourse = BundleCoursePlan::where('status', 1)->whereIn('id', $bundle_ids)->orderBy('order', 'asc')->with('reviews', 'course')->get();

        return view(theme('components.my-bundle-page-section'), compact('BundleCourse'));
    }
}
