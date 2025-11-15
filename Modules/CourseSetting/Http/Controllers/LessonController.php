<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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


class LessonController extends Controller
{
    use SendNotification;

    public function index($id)
    {
        try {
            $categories = Category::get();
            $chapter = Chapter::leftjoin('courses', 'courses.id', '=', 'chapters.course_id')
                ->leftjoin('sub_categories', 'courses.subcategory_id', '=', 'sub_categories.id')
                ->where('chapters.id', $id)
                ->select('chapters.*', 'courses.title', 'courses.category_id', 'subcategory_id', 'sub_categories.name as subcategory_name')->first();

            $lessons = Lesson::where('chapter_id', $id)->get();
            return view('coursesetting::lesson', compact('categories', 'lessons', 'chapter'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function addLesson(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'chapter_id' => 'required',
            'duration' => 'required',
            'course_id' => 'required',
            'video_url' => 'required',
        ]);

        try {


            $user = Auth::user();
            if ($user->role_id == 2) {
                $course = Course::where('id', $request->course_id)->where('user_id', Auth::id())->first();
            } else {
                $course = Course::where('id', $request->course_id)->first();
            }

            $chapter = Chapter::find($request->chapter_id);

            if (isset($course) && isset($chapter)) {
                $success = trans('lang.Lesson') . ' ' . trans('lang.Added') . ' ' . trans('lang.Successfully');

                $lesson = new Lesson();
                $lesson->course_id = $request->course_id;
                $lesson->chapter_id = $request->chapter_id;
                $lesson->name = $request->name;
                $lesson->description = $request->description;
                $lesson->video_url = $request->video_url;
                $lesson->host = $request->host;
                $lesson->duration = $request->duration;
                $lesson->is_lock = $request->is_lock;
                $lesson->save();

                if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {
                    foreach ($course->enrollUsers as $user) {

                        $this->sendNotification('Course_Lesson_Added', $user, [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->getTranslation('title', $user->language_code ?? config('app.fallback_locale')),
                            'chapter' => $chapter->name,
                            'lesson' => $lesson->name,
                        ]);

                    }
                }


                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            }

            Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
            return redirect()->back();

        } catch (Exception $e) {

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function editLesson($id)
    {

        try {

            $courseSetting = new CourseSettingController();
            $video_list = $courseSetting->getVimeoList();

            $editLesson = Lesson::find($id);
            $course = Course::find($editLesson->course_id);
            $chapters = Chapter::where('course_id', $editLesson->course_id)->with('lessons')->get();
            $categories = Category::get();
            $instructors = User::where('role_id', 2)->get();
            $languages = Language::get();
            $quizzes = OnlineQuiz::where('category_id', $course->category_id)->get();
            $course_exercises = CourseExercise::where('course_id', $editLesson->course_id)->get();
            $levels = CourseLevel::where('status', 1)->get();
            if (Auth::user()->role_id == 1) {
                $certificates = Certificate::latest()->get();
            } else {
                $certificates = Certificate::where('created_by', Auth::user()->id)->latest()->get();
            }
            // return $course_exercises;

            return view('coursesetting::course_details', compact('levels', 'certificates', 'course', 'chapters', 'categories', 'instructors', 'languages', 'course_exercises', 'editLesson', 'quizzes', 'video_list'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function updateLesson(Request $request)
    {
        try {
            // $success = trans('lang.Lesson').' '.trans('lang.Updated').' '.trans('lang.Successfully');

            $lesson = Lesson::find($request->id);

            $user = Auth::user();
            if ($user->role_id == 2) {
                $course = Course::where('id', $lesson->course_id)->where('user_id', Auth::id())->first();
            } else {
                $course = Course::where('id', $lesson->course_id)->first();
            }

            if (isset($course)) {
                $lesson->course_id = $request->course_id;
                $lesson->chapter_id = $request->chapter_id;
                $lesson->name = $request->name;
                $lesson->description = $request->description;
                $lesson->video_url = $request->video_url;
                if ($request->get('host') == "Vimeo") {
                    $lesson->video_url = $request->vimeo;
                }
                $lesson->duration = $request->duration;
                $lesson->is_lock = $request->is_lock;
                $lesson->save();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->route('lessonPage', [$request->chapter_id]);
            } else {
                Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
            }
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function deleteLesson(Request $request)
    {
        try {
            $lesson = Lesson::find($request->id);

            $user = Auth::user();


            $user = Auth::user();
            if ($user->role_id == 2) {
                $course = Course::where('id', $lesson->course_id)->where('user_id', Auth::id())->first();
            } else {
                $course = Course::where('id', $lesson->course_id)->first();
            }


            if (isset($course)) {
                if ($lesson->is_assignment == 1) {
                    $assignment = InfixAssignment::find($lesson->assignment_id);
                    $assignment->delete();
                }
                $this->lessonFileDelete($lesson);

                if (isModuleActive('BunnyStorage')) {
                    if ($lesson->bunnyLesson) {
                        $lesson->bunnyLesson->delete();
                    }
                }


                $lesson->delete();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {

                Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function lessonFileDelete($lesson)
    {
        try {
            $host = $lesson->host;
            if ($host == "SCORM") {
                $index = $lesson->video_url;
                if (!empty($index)) {
                    $new_path = str_replace("/public/uploads/scorm/", "", $index);
                    $folder = explode('/', $new_path)[0] ?? '';
                    $delete_dir = public_path() . "/uploads/scorm/" . $folder;

                    if (File::isDirectory($delete_dir)) {
                        File::deleteDirectory($delete_dir);
                    }
                }
            } elseif ($host == "Self" || $host == "Image" || $host == "PDF" || $host == "Word" || $host == "Excel" || $host == "PowerPoint" || $host == "Text" || $host == "Zip") {

                $file = File::exists($lesson->video_url);

                if ($file) {
                    File::delete($lesson->video_url);

                }
            }
        } catch (\Exception $e) {

        }
        return true;
    }
}
