<?php

namespace Modules\Setting\Http\Controllers;

use App\Traits\SendMail;
use App\Traits\SendSMS;
use App\Traits\UploadMedia;
use App\Traits\UploadTheme;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Modules\Setting\Repositories\GeneralSettingRepositoryInterface;
use Modules\SystemSetting\Entities\EmailTemplate;


class GeneralSettingsController extends Controller
{
    use UploadMedia, SendSMS, SendMail, UploadTheme, ValidatesRequests;

    protected $generalsettingRepository;

    public function __construct(GeneralSettingRepositoryInterface $generalsettingRepository)
    {
        $this->generalsettingRepository = $generalsettingRepository;
    }

    public function update(Request $request)
    {

        if (appMode()) {
            return 2;
        }

        try {
            $this->generalsettingRepository->update($request->except("_token"));

            session()->forget('settings');
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function smtp_gateway_credentials_update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        UpdateGeneralSetting('mail_protocol', $request->mail_protocol);
        UpdateGeneralSetting('mail_signature', $request->mail_signature);
        UpdateGeneralSetting('mail_header', $request->mail_header);
        UpdateGeneralSetting('mail_footer', $request->mail_footer);

        session()->forget('settings');

        if ($request->mail_protocol == 'sendmail') {
            $request->merge(["MAIL_MAILER" => "smtp"]);
        } else {
            $request->merge(["MAIL_MAILER" => $request->mail_protocol]);
        }
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }
        // return back()->with('message-success', __('setting.SMTP Gateways Credentials has been updated Successfully'));
        Toastr::success(__('setting.SMTP Gateways Credentials has been updated Successfully'), trans('common.Success'));
        return redirect()->back();
    }

    public function test_mail_send(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        if (saasEnv('MAIL_USERNAME') != null) {
            $this->sendMailTest($request);
            // return back()->with('message-success', __('setting.Mail has been sent Successfully'));
            Toastr::success(__('setting.Mail has been sent Successfully'), trans('common.Success'));
            return redirect()->back();
        }
        // return back()->with('message-warning', __('setting.Please Configure SMTP settings first'));
        Toastr::warning(__('setting.Please Configure SMTP settings first'), 'Warning');
        return redirect()->back();
    }

    public function socialCreditional(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        if ($request->fbLogin == 1) {
            $request->validate([

                'facebook_client' => "required",
                'facebook_secret' => "required",
            ]);
        } elseif ($request->googleLogin == 1) {
            $request->validate([
                'google_client' => "required",
                'google_secret' => "required"
            ]);
        } else {
            $request->validate([
                'google_client' => "required",
                'google_secret' => "required",
                'facebook_client' => "required",
                'facebook_secret' => "required",
            ]);

        }

        try {

            if (Config::get('app.app_sync')) {
                Toastr::error('For demo version you can not change this !', 'Failed');
                return redirect()->back();
            } else {
                UpdateGeneralSetting('google_client', $request->google_client);
                UpdateGeneralSetting('google_secret', $request->google_secret);
                UpdateGeneralSetting('facebook_client', $request->facebook_client);
                UpdateGeneralSetting('facebook_secret', $request->facebook_secret);
                UpdateGeneralSetting('fbLogin', $request->fbLogin);
                UpdateGeneralSetting('googleLogin', $request->googleLogin);
                session()->forget('settings');

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            }

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function seoSetting(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request->validate([
            'meta_keywords' => 'required',
            'meta_description' => 'required',

        ]);
        try {
            if (Config::get('app.app_sync')) {
                Toastr::error('For demo version you can not change this !', 'Failed');
                return redirect()->back();
            } else {

                UpdateGeneralSetting('meta_keywords', $request->meta_keywords);
                UpdateGeneralSetting('meta_description', $request->meta_description);


                session()->forget('settings');

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            }

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function footerEmailConfig()
    {
        return view('setting::emails.email_template');
    }

    public function EmailTemp()
    {

        $query = EmailTemplate::query();
        if (!showEcommerce()) {
            $query->where('ecommerce', 0);
        }
        $templates = $query->get();
        return view('setting::emails.email_temp', compact('templates'));
    }

    public function aboutSystem()
    {
        return view('setting::aboutSystem');
    }


    public function EmailTempAjax($id, $type)
    {
        if (\request()->ajax()) {
            $template = EmailTemplate::findOrFail($id);
            return view('setting::emails.email_temp_ajax', compact('template', 'type'));
        }
        abort(404);
    }

    public function remove_icon(Request $request)
    {
        $name = $request->name;

        if (in_array($name, ['logo', 'logo2', 'logo3', 'favicon'])) {
            $this->generalsettingRepository->update([$name => '']);
            UpdateGeneralSetting($name, '');
        }
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

}
