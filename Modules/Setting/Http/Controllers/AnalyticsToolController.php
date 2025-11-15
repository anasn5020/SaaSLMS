<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AnalyticsToolController extends Controller
{
    public function index()
    {
        return view('setting::analytics.index');
    }

    public function update(Request $request)
    {
        if ($request->type == 'facebook') {
            if ($request->facebook_pixel_status == '1' && empty($request->facebook_pixel)) {
                Toastr::error(__('setting.facebook_pixel_id_required'), __('common.Error'));
                return redirect()->back();

            }
            UpdateGeneralSetting('facebook_pixel_status', $request->get('facebook_pixel_status', 0));
            UpdateGeneralSetting('facebook_pixel', $request->get('facebook_pixel', ''));
        }elseif ($request->type == 'gtm') {
            if ($request->gtm_status == '1' && empty($request->gtm_id)) {
                Toastr::error(__('setting.gtm_id_required'), __('common.Error'));
                return redirect()->back();

            }
            UpdateGeneralSetting('gtm_status', $request->get('gtm_status', 0));
            UpdateGeneralSetting('gtm_id', $request->get('gtm_id', ''));
        } elseif ($request->type = 'google') {

            if ($request->google_analytics_status == '1' && empty($request->MEASUREMENT_ID)) {
                Toastr::error(__('setting.tracking_id_required'), __('common.Error'));
                return redirect()->back();
            }

            UpdateGeneralSetting('google_analytics_status', $request->get('google_analytics_status', 0));
            SaasEnvSetting(SaasDomain(), 'MEASUREMENT_ID', $request->get('MEASUREMENT_ID', ''));
            SaasEnvSetting(SaasDomain(), 'MEASUREMENT_PROTOCOL_API_SECRET', $request->get('MEASUREMENT_PROTOCOL_API_SECRET', ''));
        }
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }


}
