<?php

namespace Modules\Certificate\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CertificateSettingController extends Controller
{

    public function index()
    {
        return view('certificate::setting.index');
    }

    public function store(Request $request)
    {
        UpdateGeneralSetting('manually_assign_certificate', $request->get('manually_assign_certificate', 0));
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }
}
