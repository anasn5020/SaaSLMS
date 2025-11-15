<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\UploadMedia;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Modules\Setting\Model\GeneralSetting;

class PreloaderSettingController extends Controller
{
    use UploadMedia;

    public function index()
    {
        $image = GeneralSetting::where('key', 'preloader_image')->first();
        return view('setting::preloader.index', compact('image'));
    }


    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }


        UpdateGeneralSetting('preloader_status', $request->preloader_status);
        UpdateGeneralSetting('preloader_style', $request->preloader_style);
        UpdateGeneralSetting('preloader_type', $request->preloader_type);


        UpdateGeneralSetting('preloader_image', null);
        $setting = GeneralSetting::where('key', 'preloader_image')->first();

        $this->removeLink($setting->id, get_class($setting));
        if ($request->preloader_image) {
            $url = $this->generateLink($request->preloader_image, $setting->id, get_class($setting), 'value');
            UpdateGeneralSetting('preloader_image', $url);
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

}
