<?php

namespace App\Repositories;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\CourseSetting\Entities\CourseEnrolled;

class MyEnrollmentRepository
{

    public function myTopics(array $request_data = [])
    {
        $with = ['course', 'course.quiz', 'course.class'];
        $data = CourseEnrolled::query()
            ->with($with)
            ->where('user_id', Auth::id())
            ->where('status', '=', 1);

        if (isset($request_data['f_date']) && $request_data['f_date']) {
            $data->whereBetween(DB::raw('DATE(created_at)'), formatDateRangeData($request_data['f_date']));
        }

        if (isset($request_data['f_type']) && $request_data['f_type']) {
            $data->whereHas('course', function ($q) use ($request_data) {
                $q->where('type', $request_data['f_type']);
            });
        }
        if (isset($request_data['f_category']) && $request_data['f_category']) {
            $data->whereHas('course', function ($q) use ($request_data) {
                $q->where('category_id', $request_data['f_category']);
            });
        }

        $data->select('course_enrolleds.*');

        return $data;
    }


}
