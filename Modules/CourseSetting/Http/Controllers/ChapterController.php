<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\Traits\SendNotification;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\Course;

class ChapterController extends Controller
{
    use SendNotification;

    public function index()
    {
        $categories = Category::get();
        $chapters = Chapter::leftjoin('courses', 'courses.id', '=', 'chapters.course_id')->select('chapters.*', 'courses.title')->get();
        return view('coursesetting::chapter', compact('categories', 'chapters'));
    }

    public function chapterSearchByCourse(Request $request)
    {
        $request->validate([
            'course' => 'required',
        ]);

        try {
            $categories = Category::get();
            $chapters = Chapter::leftjoin('courses', 'courses.id', '=', 'chapters.course_id')
                ->where('course_id', $request->course)
                ->select('chapters.*', 'courses.title')->get();
            return view('coursesetting::chapter', compact('categories', 'chapters'));

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('coursesetting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request->validate([
            'course' => 'required',
            'chapter_name' => 'required',
        ]);
        try {
            $user = Auth::user();
            if ($user->role_id == 2) {
                $course = Course::where('id', $request->course)->where('user_id', Auth::id())->first();
            } else {
                $course = Course::where('id', $request->course)->first();
            }


            if (isset($course)) {

                $chpter_no = Chapter::where('course_id', $course->id)->count();
                $chapter = new Chapter();
                $chapter->name = $request->chapter_name;
                $chapter->course_id = $request->id;
                $chapter->chapter_no = $chpter_no + 1;
                $chapter->save();
                if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {
                    foreach ($course->enrollUsers as $user) {

                        $this->sendNotification('Course_Chapter_Added', $user, [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->getTranslation('title', $user->language_code ?? config('app.fallback_locale')),
                            'chapter' => $chapter->name,
                        ]);

                    }
                }

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return back();
            } else {

                Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
                return redirect()->back();
            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('coursesetting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function chapterEdit($id)
    {
        try {
            $categories = Category::get();
            $chapter = Chapter::leftjoin('courses', 'courses.id', '=', 'chapters.course_id')
                ->leftjoin('sub_categories', 'courses.subcategory_id', '=', 'sub_categories.id')
                ->where('chapters.id', $id)
                ->select('chapters.*', 'courses.title', 'courses.category_id', 'subcategory_id', 'sub_categories.name as subcategory_name')->first();

            $chapters = Chapter::leftjoin('courses', 'courses.id', '=', 'chapters.course_id')->select('chapters.*', 'courses.title')->get();
            return view('coursesetting::chapter', compact('categories', 'chapters', 'chapter'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function chapterUpdate(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request->validate([
            'course' => 'required',
            'chapter_name' => 'required',
        ]);

        try {

            $chapter = Chapter::where('id', $request->course)->first();
            $chapter->name = $request->chapter_name;
            $chapter->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
