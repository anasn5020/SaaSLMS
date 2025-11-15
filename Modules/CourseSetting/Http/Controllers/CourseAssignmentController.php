<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\Traits\SendNotification;
use App\Traits\UploadMedia;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Assignment\Entities\InfixAssignment;
use Modules\Certificate\Entities\Certificate;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseExercise;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\CourseSetting\Entities\Lesson;
use Modules\Localization\Entities\Language;
use Modules\Quiz\Entities\OnlineQuiz;

class CourseAssignmentController extends Controller
{
    use UploadMedia, SendNotification;

    public function AssignmentStore(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $validate_rules = [
            'title' => 'required|max:255',
            'marks' => 'required|min:0',
            'min_parcentage' => 'required|min:0',
            'description' => 'required',
        ];
        $request->validate($validate_rules, validationMessage($validate_rules));

        try {
            $assignment = new InfixAssignment();
            $assignment->title = $request->title;
            $assignment->course_id = $request->course_id;
            $assignment->marks = (int)$request->marks;
            $assignment->min_parcentage = (int)$request->min_parcentage;
            $assignment->description = $request->description;
            $assignment->assignment_from = 2;
            $assignment->created_by = Auth::user()->id;
            $assignment->last_date_submission = date('Y-m-d', strtotime($request->last_date_submission));
            $assignment->save();
            if ($request->attachment) {
                $assignment->attachment = $this->generateLink($request->attachment, $assignment->id, get_class($assignment), 'attachment');
            }
            $assignment->save();

            $course = Course::where('id', $request->course_id)->first();
            $chapter = Chapter::find($request->chapter_id);
            if (isset($course) && isset($chapter)) {

                $lesson = new Lesson();
                $lesson->course_id = (int)$request->course_id;
                $lesson->chapter_id = (int)$request->chapter_id;
                $lesson->assignment_id = (int)$assignment->id;
                $lesson->name = $assignment->title;
                $lesson->is_quiz = 0;
                $lesson->is_assignment = 1;
                $lesson->is_lock = (int)$request->is_lock;
                $lesson->save();

                if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {
                    foreach ($course->enrollUsers as $user) {
                        $this->sendNotification('Course_Assignment_Added', $user, [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->getTranslation('title', $user->language_code ?? config('app.fallback_locale')),
                            'chapter' => $chapter->name,
                            'assignment' => $assignment->title,
                        ]);

                    }
                }
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            }

            Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }

    }

    public function AssignmentUpdate(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $validate_rules = [
            'title' => 'required|max:255',
            'marks' => 'required|min:0',
            'min_parcentage' => 'required|min:0',
            'description' => 'required',
        ];
        $request->validate($validate_rules, validationMessage($validate_rules));

        try {
            $assignment = InfixAssignment::find($request->id);
            $assignment->title = $request->title;
            $assignment->course_id = $request->course_id;
            $assignment->marks = (int)$request->marks;
            $assignment->min_parcentage = (int)$request->min_parcentage;
            $assignment->description = $request->description;
            $assignment->last_date_submission = date('Y-m-d', strtotime($request->last_date_submission));
            $assignment->attachment = null;
            $assignment->save();

            $lesson =Lesson::find($request->lesson_id);
            if ($lesson){
                $lesson->is_lock = (int)$request->is_lock;
                $lesson->save();
            }


            if ($request->attachment) {
                $assignment->attachment = $this->generateLink($request->attachment, $assignment->id, get_class($assignment), 'attachment');
            }
            $assignment->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('courseDetails', $request->course_id);
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }

    }


    public function CourseAssignmentShow($id, $chapter_id, $lesson_id)
    {
        try {
            $data = [];
            $data['edit_assignment_id'] = $lesson_id;
            $data['chapter_id'] = $chapter_id;

            // return $data;
            $user = Auth::user();
            $course = Course::findOrFail($id);

            if ($course->type == 1) {

                if ($user->role_id == 2) {
                    $quizzes = OnlineQuiz::where('category_id', $course->category_id)->where('created_by', $user->id)->latest()->get();
                } else {
                    $quizzes = OnlineQuiz::where('category_id', $course->category_id)->latest()->get();
                }

            } else {
                if ($user->role_id == 2) {
                    $quizzes = OnlineQuiz::where('created_by', $user->id)->where('active_status', 1)->get();
                } else {
                    $quizzes = OnlineQuiz::where('active_status', 1)->get();

                }
            }

            $courseSettingController = new CourseSettingController;
            $vdocipher_list = [];
            $chapters = Chapter::where('course_id', $id)->orderBy('position', 'asc')->with('lessons')->get();

            $categories = Category::get();
            $instructors = User::where('role_id', 2)->get();
            $languages = Language::select('id', 'native', 'code')
                ->where('status', '=', 1)
                ->get();
            $course_exercises = CourseExercise::where('course_id', $id)->get();

            $video_list = [];

            $levels = CourseLevel::where('status', 1)->get();
            if (Auth::user()->role_id == 2) {
                $certificates = Certificate::where('created_by', Auth::user()->id)->latest()->get();
            } else {
                $certificates = Certificate::latest()->get();
            }
            $lesson = Lesson::where('id', $lesson_id)->first();
            $edit = InfixAssignment::where('id', $lesson->assignment_id)->first();

            return view('coursesetting::course_details', compact('data', 'edit', 'levels', 'vdocipher_list', 'video_list', 'course', 'chapters', 'categories', 'instructors', 'languages', 'course_exercises', 'quizzes', 'certificates', 'lesson'));

        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }


}
