<?php

namespace Modules\Localization\Http\Controllers;


use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Localization\Entities\Language;

class LocalizationController extends Controller
{
    public function index()
    {
        $languages = Language::get();
        return view('generalsetting::languageSetting.language',compact('languages'));
    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request->validate([
            'name' => 'required | unique:languages,name',
            'code' => 'required | max:15',
            'native' => 'required | max:50',
        ]);


        try {
            $s = new Language();
            $s->name = $request->name;
            $s->code = $request->code;
            $s->native = $request->native;
            $s->rtl = 0;
            $s->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect('language-list');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function show($id)
    {

        try {
            $editData = Language::findOrfail($id);
            $languages = Language::get();
            return view('generalsetting::languageSetting.language',compact('languages','editData'));

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request->validate([
            'name' => 'required|unique:languages,name,'. $request->id,
            'code' => 'required | max:15',
            'native' => 'required | max:50',
        ]);


        try {
            $s = Language::findOrfail($request->id);
            $s->name = $request->name;
            $s->code = $request->code;
            $s->native = $request->native;
            $s->update();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }






}
