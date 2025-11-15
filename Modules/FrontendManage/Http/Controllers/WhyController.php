<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Modules\CourseSetting\Entities\Course;
use Modules\FrontendManage\Entities\Slider;
use Modules\FrontendManage\Entities\WhyChoose;

class WhyController extends Controller
{
    use ImageStore;

    public function index()
    {
        try {
            $whys = WhyChoose::all();
            return view('frontendmanage::why', compact('whys'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function store(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'image' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $why = new WhyChoose();
            $why->title = $request->title;
            $why->sub_title = $request->sub_title;


            if ($request->has('image')) {
                $why->image = $this->saveImage($request->image);
            }
            $why->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function edit($id)
    {
        try {
            $whys = WhyChoose::all();
            $why = WhyChoose::findOrFail($id);

            return view('frontendmanage::why', compact('whys', 'why'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'image' => 'nullable',
            'title' => 'required',
            'sub_title' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $why = WhyChoose::find($request->id);
            $why->title = $request->title;
            $why->sub_title = $request->sub_title;
            if ($request->has('image')) {
                $why->image = $this->saveImage($request->image);
            }
            $why->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            WhyChoose::destroy($id);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.why.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

}
