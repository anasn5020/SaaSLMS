<?php

namespace Modules\FrontendManage\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HeaderFooterStyleController extends Controller
{

    public function index()
    {
        return view('frontendmanage::header_footer_style.index');
    }

    public function store(Request $request)
    {
        UpdateGeneralSetting('header_style', $request->header);
        UpdateGeneralSetting('footer_style', $request->footer);
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();

    }
}
