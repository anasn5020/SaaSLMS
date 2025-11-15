<?php

namespace Modules\FrontendManage\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MenuSettingController extends Controller
{
    public function index()
    {
        try {
            return view('frontendmanage::menusetting.index');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function store(Request $request)
    {
        UpdateGeneralSetting('menu_bg', $request->menu_bg);
        UpdateGeneralSetting('menu_text', $request->menu_text);
        UpdateGeneralSetting('menu_hover_text', $request->menu_hover_text);
        UpdateGeneralSetting('menu_title_text', $request->menu_title_text);

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }
}
