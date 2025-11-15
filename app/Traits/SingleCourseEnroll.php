<?php

namespace App\Traits;

use App\User;
use Modules\CourseSetting\Entities\Course;
use Modules\Payment\Entities\InstructorPayout;
use Modules\CourseSetting\Entities\CourseEnrolled;

trait SingleCourseEnroll
{

    public function singleCourseEnroll(int $student_id, int $course_id)
    {
        $wasCorseEnrolls = CourseEnrolled::where('user_id', $student_id)->pluck('course_id')->unique()->toArray();

        if (!in_array($course_id, $wasCorseEnrolls)) {
            $course = Course::findOrFail($course_id);
            $instructor = User::findOrFail($course->user_id);

            $enrolled = $course->total_enrolled;
            $course->total_enrolled = ($enrolled + 1);
            $enrolled = new CourseEnrolled;
            $enrolled->user_id = $student_id;
            $enrolled->course_id = $course_id;
            $enrolled->purchase_price = $course->discount_price != null ? $course->discount_price : $course->price;
            $enrolled->save();

            $itemPrice = $enrolled->purchase_price;

            if (!is_null($course->special_commission) && $course->special_commission != 0) {
                $commission = $course->special_commission;
                $reveune = ($itemPrice * $commission) / 100;
                $enrolled->reveune = $reveune;
            } elseif (!is_null($instructor->special_commission) && $instructor->special_commission != 0) {
                $commission = $instructor->special_commission;
                $reveune = ($itemPrice * $commission) / 100;
                $enrolled->reveune = $reveune;
            } else {
                $commission = 100 - Settings('commission');
                $reveune = ($itemPrice * $commission) / 100;
                $enrolled->reveune = $reveune;
            }

            $payout = new InstructorPayout;
            $payout->instructor_id = $course->user_id;
            $payout->reveune = $reveune;
            $payout->status = 0;
            $payout->save();

            $enrolled->save();

            $course->reveune = (($course->reveune) + ($enrolled->reveune));

            $course->save();
        }

    }

    public function reducedAmount(string $type, int $course_id, int $id)
    {
        $amount = 0;
        if ($type == 'myClass' && isModuleActive('MyClass')) {
            $payout = InstructorPayout::where('class_course_id', $id)->where('type', 'myClass')->first();
            if ($payout) {
                $amount = $payout->reveune;
            }
        }
    }
}
