<?php

namespace App\View\Components;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\CourseCanceled;
use Modules\CourseSetting\Entities\CourseEnrolled;

class EnrollmentCancellationPageSection extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        $flag = Settings('allow_refund_days') == 0 ? false : true;
        $records = CourseCanceled::where('user_id', auth()->id())
            ->with('course')
            ->latest()
            ->paginate(10);

        $ignore = CourseCanceled::where('user_id', auth()->id())
            ->where('status', 0)
            ->whereNotNull('enroll_id')->pluck('enroll_id')->toArray();
        $courses = CourseEnrolled::where('user_id', auth()->id())
            ->where('purchase_price', ">", 0)
            ->whereNotIn('id', $ignore)
            ->when($flag, function ($query) {
                $today = Carbon::now();
                $date = $today->subDays((int)Settings('allow_refund_days'))->format('Y-m-d');
                return $query->where(DB::raw('DATE(created_at)'), '>=', $date);
            })
            ->with('course')
            ->get();


        return view(theme('components.enrollment-cancellation-page-section'), compact('records', 'courses'));
    }
}
