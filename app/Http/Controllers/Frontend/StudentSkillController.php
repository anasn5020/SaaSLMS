<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Log;
use Modules\Quiz\Entities\QuizTest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\CourseSetting\Entities\Course;
use Modules\SkillAndPathway\Entities\Pathway;
use Modules\VirtualClass\Entities\ClassComplete;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\SkillAndPathway\Entities\StudentSkill;
use Modules\SkillAndPathway\Entities\StudentCompletePathway;

class StudentSkillController extends Controller
{
    public function mySkill()
    {
        return view(theme('pages.mySkills'));
    }

    public static function studentCreateSkill($skill_for, $course_id, $user, $enroll_info = null)
    {
        try {
            if ($enroll_info == null) {
                $enroll_info = CourseEnrolled::where('user_id', $user->id)->where('course_id', $course_id)->first();
            }
            if ($skill_for == 1) {
                $course = Course::find($course_id);
                foreach ($course->badges as $key => $skill) {
                    $check = StudentSkill::where('student_id', $user->id)->where('course_id', $course_id)->where('skill_id', $skill->skill_id)->first();
                    if (!$check) {
                        $student_skill = new StudentSkill();
                        $student_skill->student_id = $user->id;
                        $student_skill->course_id = $course_id;
                        $student_skill->skill_id = $skill->skill_id;
                        $student_skill->save();
                    }

                }
            } else {
                $pathway = Pathway::find($enroll_info->pathway_id);
                $totalCourse = $pathway->pathwayCourse->count();


                foreach ($pathway->pathwayCourse as $key => $pathway_course) {
                    //  dump($pathway_course->course);
                    try {
                        if ($pathway_course->course->type == 1) {
                            $percentage = $pathway_course->course->userEnrollPercentage($enroll_info->id, Auth::user()->id, $pathway_course->course->id);
                            if ($percentage >= 100) {
                                $check_exist = StudentCompletePathway::where('student_id', $user->id)->where('pathway_id', $enroll_info->pathway_id)->where('course_id', $pathway_course->course_id)->first();
                                if (!$check_exist) {
                                    $student_pathway = new StudentCompletePathway();
                                    $student_pathway->student_id = $user->id;
                                    $student_pathway->pathway_id = $pathway->id;
                                    $student_pathway->course_id = $pathway_course->course_id;
                                    $student_pathway->save();
                                }
                            }
                        }

                    } catch (\Exception $ee) {
                    }
                    if ($pathway_course->course->type == 2) {

                        $check_status = QuizTest::where('course_id', $pathway_course->course->id)->where('user_id', Auth::user()->id)->where('pass', 1)->first();

                        if ($check_status) {
                            $check_exist = StudentCompletePathway::where('student_id', $user->id)->where('pathway_id', $enroll_info->pathway_id)->where('course_id', $pathway_course->course_id)->first();
                            if (!$check_exist) {
                                $student_pathway = new StudentCompletePathway();
                                $student_pathway->student_id = $user->id;
                                $student_pathway->pathway_id = $pathway->id;
                                $student_pathway->course_id = $pathway_course->course_id;
                                $student_pathway->save();
                            }
                        }
                    }
                    if ($pathway_course->course->type == 3) {
                        $virtual_class = $pathway_course->course->class;

                        $total_class = $virtual_class->total_class;

                        $completed_class = ClassComplete::where('course_id', $pathway_course->course->id)->where('user_id', Auth::user()->id)->where('status', 1)->count();

                        if ($total_class == $completed_class) {
                            $check_exist = StudentCompletePathway::where('student_id', $user->id)->where('pathway_id', $enroll_info->pathway_id)->where('course_id', $pathway_course->course_id)->first();
                            if (!$check_exist) {
                                $student_pathway = new StudentCompletePathway();
                                $student_pathway->student_id = $user->id;
                                $student_pathway->pathway_id = $pathway->id;
                                $student_pathway->course_id = $pathway_course->course_id;
                                $student_pathway->save();
                            }
                        }
                    }

                }
                $completed_course = $pathway->pathwayCourseComplete->where('student_id', $user->id)->count();
                if ($completed_course == $totalCourse) {
                    foreach ($pathway->badges as $key => $skill) {
                        $student_skill = new StudentSkill();
                        $student_skill->student_id = $user->id;
                        $student_skill->course_id = $course_id;
                        $student_skill->skill_id = $skill->skill_id;
                        $student_skill->save();
                    }
                }
            }


            return "true";
        } catch (\Throwable $th) {
            return "false";
        }
    }

}
