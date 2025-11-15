<?php

namespace Modules\Setting\Http\Controllers;

use App\Country;
use App\Http\Controllers\Controller;
use App\Traits\UploadMedia;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\FrontendManage\Entities\HomeContent;
use Modules\Org\Entities\OrgBranch;
use Modules\Setting\Entities\InstructorSetup;
use Modules\Setting\Entities\StudentSetup;
use Modules\Setting\Model\BusinessSetting;
use Modules\Setting\Model\Currency;
use Modules\Setting\Model\DateFormat;
use Modules\Setting\Model\GeneralSetting;
use Modules\Setting\Model\TimeZone;
use Modules\Setting\Repositories\GeneralSettingRepositoryInterface;
use Modules\SystemSetting\Entities\EmailSetting;
use Nwidart\Modules\Facades\Module;

class SettingController extends Controller
{
    use UploadMedia;

    protected $generalSettingRepository;

    public function __construct(GeneralSettingRepositoryInterface $generalSettingRepository)
    {
        $this->generalSettingRepository = $generalSettingRepository;
    }

    public function activation()
    {
        $business_settings = BusinessSetting::all();
        return view('setting::activation', compact('business_settings'));
    }


    public function general_settings()
    {
        $date_formats = DateFormat::select('normal_view', 'id')->get();
        $languages = getLanguageList();
        $countries = Country::select('id', 'name')->where('active_status', 1)->get();
        $timeZones = TimeZone::select('id', 'time_zone')->get();
        $data = [];
        if (isModuleActive('Org')) {
            $data['branches'] = OrgBranch::orderBy('order', 'asc')->get();
        }
        $logo = GeneralSetting::where('key', 'logo')->first();
        $logo2 = GeneralSetting::where('key', 'logo2')->first();
        $logo3 = GeneralSetting::where('key', 'logo3')->first();
        $favicon = GeneralSetting::where('key', 'favicon')->first();
        $pdfFont = GeneralSetting::where('key', 'datatable_default_font')->first();
        return view('setting::general_settings', $data, compact('timeZones', 'countries', 'languages', 'date_formats', 'logo', 'logo2', 'logo3', 'favicon','pdfFont'));
    }

    public function email_setup()
    {
        $emailSettings = EmailSetting::get();
        $send_mail_setting = $emailSettings->where('email_engine_type', 'php')->first();
        $smtp_mail_setting = $emailSettings->where('email_engine_type', 'smtp')->first();
        $send_grid_mail_setting = $emailSettings->where('email_engine_type', 'sendgrid')->first();

        return view('setting::email_setup2', compact('emailSettings', 'send_mail_setting', 'smtp_mail_setting', 'send_grid_mail_setting'));
    }

    public function seo_setting()
    {
        return view('setting::seo_setting');
    }


    public function index()
    {
        return redirect()->route('home');
    }


    public function update_activation_status(Request $request)
    {
        if (demoCheck()) {
            return 2;
        }

        $business_setting = BusinessSetting::findOrFail($request->id);
        if ($business_setting != null) {
            $business_setting->status = $request->status??0;
            $business_setting->save();
            UpdateGeneralSetting($business_setting->type, $business_setting->status);
            return 1;
        }
        return 0;
    }

    public function maintenance()
    {
        $keys = [
            'maintenance_title',
            'maintenance_sub_title',
            'maintenance_banner',
            'maintenance_status',
        ];
        $setting = HomeContent::whereIn('key', $keys)->get();

        $maintenance_title = $setting->where('key', 'maintenance_title')->first()?->value;
        $maintenance_sub_title = $setting->where('key', 'maintenance_sub_title')->first()?->value;
        $maintenance_banner = $setting->where('key', 'maintenance_banner')->first();
        $maintenance_status = $setting->where('key', 'maintenance_status')->first()?->value;
        return view('setting::maintenance', compact('maintenance_title', 'maintenance_sub_title', 'maintenance_banner', 'maintenance_status'));
    }

    public function maintenanceAction(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $banner = HomeContent::where('key', 'maintenance_banner')->first();
            if ($banner) {
                $url = null;
                $this->removeLink($banner->id, get_class($banner));
                $banner->value = null;
                $banner->save();
                if ($request->maintenance_banner) {
                    $url = $this->generateLink($request->maintenance_banner, $banner->id, get_class($banner), 'value');
                }
                $banner->value = $url;
                $banner->save();
                UpdateHomeContent('maintenance_banner', $url);
            }

            UpdateHomeContent('maintenance_title', $request->maintenance_title);
            UpdateHomeContent('maintenance_sub_title', $request->maintenance_sub_title);
            UpdateHomeContent('maintenance_status', $request->maintenance_status);
            UpdateGeneralSetting('maintenance_status', $request->maintenance_status);


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function captcha()
    {
        return view('setting::captcha');
    }

    public function captchaStore(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $site_key = $request->get('site_key');
        $secret_key = $request->get('secret_key');
        $login_status = $request->get('login_status');
        $reg_status = $request->get('reg_status');
        $contact_status = $request->get('contact_status');
        $is_invisible = $request->get('is_invisible');

        SaasEnvSetting(SaasDomain(), 'NOCAPTCHA_SITEKEY', $site_key);
        SaasEnvSetting(SaasDomain(), 'NOCAPTCHA_SECRET', $secret_key);

        if ($is_invisible == 1) {
            $is_invisible = 'true';
        } else {
            $is_invisible = 'false';
        }
        SaasEnvSetting(SaasDomain(), 'NOCAPTCHA_IS_INVISIBLE', $is_invisible);


        if ($login_status == 1) {
            $login_status = 'true';
        } else {
            $login_status = 'false';
        }
        SaasEnvSetting(SaasDomain(), 'NOCAPTCHA_FOR_LOGIN', $login_status);

        if ($reg_status == 1) {
            $reg_status = 'true';
        } else {
            $reg_status = 'false';
        }
        SaasEnvSetting(SaasDomain(), 'NOCAPTCHA_FOR_REG', $reg_status);

        if ($contact_status == 1) {
            $contact_status = 'true';
        } else {
            $contact_status = 'false';
        }
        SaasEnvSetting(SaasDomain(), 'NOCAPTCHA_FOR_CONTACT', $contact_status);

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function student_setup()
    {
        try {
            $data = StudentSetup::getData();
            return view('setting::studentSetup', compact('data'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function student_setup_update(Request $request)
    {
        try {
            $data = StudentSetup::getData();
            $data->show_running_course_thumb = $request->show_running_course_thumb;
            $data->show_recommended_section = $request->show_recommended_section;
            $data->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return view('setting::studentSetup', compact('data'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function instructor_setup()
    {
        try {
            $data = InstructorSetup::getData();
            return view('setting::instructorSetup', compact('data'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function instructor_setup_update(Request $request)
    {
        try {
            $data = InstructorSetup::first();
            $data->show_instructor_page_banner = $request->show_instructor_page_banner;
            $data->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return view('setting::instructorSetup', compact('data'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }


    public function socialLogin()
    {
        return view('setting::socialLogin');
    }

    public function socialLoginStore(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $allow_google_login = $request->get('allow_google_login');
        $google_client_id = $request->get('google_client_id');
        $google_secret_key = $request->get('google_secret_key');

        $allow_facebook_login = $request->get('allow_facebook_login');
        $facebook_client_id = $request->get('facebook_client_id');
        $facebook_secret_key = $request->get('facebook_secret_key');

        SaasEnvSetting(SaasDomain(), 'GOOGLE_CLIENT_ID', $google_client_id);
        SaasEnvSetting(SaasDomain(), 'GOOGLE_CLIENT_SECRET', $google_secret_key);


        SaasEnvSetting(SaasDomain(), 'FACEBOOK_CLIENT_ID', $facebook_client_id);
        SaasEnvSetting(SaasDomain(), 'FACEBOOK_CLIENT_SECRET', $facebook_secret_key);


        if ($allow_google_login == 1) {
            $login_status = 'true';
        } else {
            $login_status = 'false';
        }
        SaasEnvSetting(SaasDomain(), 'ALLOW_GOOGLE_LOGIN', $login_status);

        if ($allow_facebook_login == 1) {
            $allow_facebook_login = 'true';
        } else {
            $allow_facebook_login = 'false';
        }
        SaasEnvSetting(SaasDomain(), 'ALLOW_FACEBOOK_LOGIN', $allow_facebook_login);


        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }


    public function migration()
    {
        $migrations = [];
        $migrationsFolderPath[] = database_path('/migrations');
        $allModules = Module::all();
        foreach ($allModules as $name => $module) {
            if (isModuleActive($module)) {
                $migrationsFolderPath[] = $module->getPath() . '/Database/Migrations';
            }
        }
        foreach ($migrationsFolderPath as $path) {
            $files = app('migrator')->getMigrationFiles($path);
            foreach ($files as $key => $file) {
                $migrations[$key] = $file;
            }
        }
        $pendingMigrations = [];
        foreach ($migrations as $migration => $fullpath) {
            if (!DB::table('migrations')->where('migration', $migration)->exists())
                $pendingMigrations[$migration] = $fullpath;
        }
        return view('setting::migration', compact('pendingMigrations'));
    }

    public function migrationSubmit(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        if (auth()->user()->role_id != 1) {
            abort(403);
        }

        if ($request->password == "") {
            Toastr::error(__('common.enter_your_password'));
        } elseif (Hash::check($request->password, auth()->user()->password)) {
            Artisan::call('migrate',[
                '--no-interaction' => true,
            ]);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        } else {
            Toastr::error(__('common.Password did not match with your account password'));
        }
        return redirect()->back();
    }

    public function update_settings(Request $request)
    {
        $currency = Currency::where('id', $request->get('currency_id', 0))->first();
        if ($currency) {
            $currency_symbol = $currency->symbol;
            $currency_code = $currency->code;
        } else {
            $currency_symbol = Settings('currency_symbol');
            $currency_code = Settings('currency_code');
        }

        $data = [
            'currency_id' => $request->get('currency_id', 0),
            'currency_show' => $request->get('currency_show', 0),
            'currency_seperator' => $request->get('currency_seperator', 0),
            'currency_decimal' => $request->get('currency_decimal', 0),
            'hide_multicurrency' => $request->get('hide_multicurrency', 0),
            'currency_conversion' => $request->get('currency_conversion', 0),
            'currency_symbol' => $currency_symbol,
            'currency_code' => $currency_code,
            'currency_api_cache_time' => $request->get('currency_api_cache_time', 1440),

        ];
        $this->generalSettingRepository->update($data);
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

}
