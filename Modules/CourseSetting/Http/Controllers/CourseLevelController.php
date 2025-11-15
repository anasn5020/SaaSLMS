<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseLevel;


class CourseLevelController extends Controller
{

    public function index()
    {
        $levels = CourseLevel::all();
        return view('coursesetting::level', compact('levels'));
    }


    public function store(Request $request)
    {

        $code = auth()->user()->language_code;

        $rules = [
            'title.' . $code => 'required|max:255',
        ];

        $this->validate($request, $rules, validationMessage($rules));


        $level = new CourseLevel();
        $level->id = CourseLevel::max('id') + 1;
        foreach ($request->title as $key => $title) {
            $level->setTranslation('title', $key, $title);
        }
        $level->save();

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function edit($id, Request $request)
    {
        $edit = CourseLevel::findOrFail($id);
        $levels = CourseLevel::all();
        return view('coursesetting::level', compact('levels', 'edit'));
    }

    public function update(Request $request, $id)
    {


        $code = auth()->user()->language_code;

        $rules = [
            'title.' . $code => 'required|max:255',
        ];
        $this->validate($request, $rules, validationMessage($rules));
        $edit = CourseLevel::findOrFail($id);
        foreach ($request->title as $key => $title) {
            $edit->setTranslation('title', $key, $title);
        }
        $edit->save();

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('course-level.index');


    }

    public function delete($id)
    {


        if (demoCheckById($id,[1,2,3,4])) {
            return redirect()->back();
        }

        $hasCourse = Course::where('level', $id)->count();
        if ($hasCourse != 0) {
            Toastr::error(trans('courses.Level is not Empty'), trans('common.Failed'));
            return redirect()->back();
        }
        $level = CourseLevel::findOrFail($id);
        $level->delete();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('course-level.index');
    }
}
