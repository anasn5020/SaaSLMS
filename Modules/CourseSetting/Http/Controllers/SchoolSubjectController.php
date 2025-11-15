<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Modules\CourseSetting\Entities\SchoolSubject;

class SchoolSubjectController extends Controller
{
    public function index()
    {
        try {
            $subjects = SchoolSubject::orderBy('order', 'asc')->get();
            $max_id = SchoolSubject::max('order') + 1;
            return view('coursesetting::school-subject', compact('subjects', 'max_id'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            'name' => 'required|max:255',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        $store = new SchoolSubject();
        $store->name = $request->name;
        $store->order = $request->order;
        $store->status = $request->status;
        $store->save();

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();

    }


    public function edit($id)
    {

        try {
            $edit = SchoolSubject::findOrFail($id);
            $subjects = SchoolSubject::orderBy('order', 'asc')->get();
            $max_id = SchoolSubject::max('order') + 1;
            return view('coursesetting::school-subject', compact('edit', 'subjects', 'max_id'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'name' => 'required|max:255',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        $edit = SchoolSubject::findOrFail($id);

        $edit->name = $request->name;
        $edit->order = $request->order;
        $edit->status = $request->status;
        $edit->save();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('schoolSubject');

    }

    public function destroy($id)
    {
        $subject = SchoolSubject::findOrFail($id);
        $subject->delete();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('schoolSubject');
    }
}
