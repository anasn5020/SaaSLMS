<?php

namespace Modules\Setting\Repositories;


use App\Traits\UploadMedia;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Modules\Localization\Entities\Language;
use Modules\Setting\Model\Currency;
use Modules\Setting\Model\DateFormat;
use Modules\Setting\Model\GeneralSetting;
use Modules\Setting\Model\TimeZone;

class GeneralSettingRepository implements GeneralSettingRepositoryInterface
{
    use UploadMedia;

    public $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());

    }

    public function update(array $data)
    {
        foreach ($data as $key => $value) {

            if ($key == 'time_zone_id') {
                $time_zone = TimeZone::find($value);
                $time_zone = $time_zone->code ?? 'Asia/Dhaka';
                UpdateGeneralSetting('active_time_zone', $time_zone);
                putEnvConfigration('TIME_ZONE', $time_zone);
            } elseif ($key == 'site_title') {
                putEnvConfigration('APP_NAME', $value);
            } elseif (in_array($key, ['logo', 'logo2', 'logo3', 'favicon'])) {
                $this->imageUpload($key, $value);
            } elseif (in_array($key, ['datatable_default_font'])) {
                $this->mediaManageSelect($key, $value);
            } elseif ($key == 'language_id') {
                $language = Language::find($value);
                if ($language) {
                    UpdateGeneralSetting('language_id', $value);
                    UpdateGeneralSetting('language_code', $language->code);
                    UpdateGeneralSetting('language_name', $language->name);
                    UpdateGeneralSetting('language_rtl', $language->rtl);


                    $user = Auth::user();
                    $user->language_id = Settings('language_id');
                    $user->language_name = Settings('language_name');
                    $user->language_code = Settings('language_code');
                    $user->language_rtl = Settings('language_rtl');
                    $user->save();
                    App::setLocale($language->code);

                }
            } elseif ($key == 'currency_id') {
                $currency = Currency::find($value);
                if ($currency) {
                    UpdateGeneralSetting('currency_id', $value);
                    UpdateGeneralSetting('currency_symbol', $currency->symbol);
                    UpdateGeneralSetting('currency_code', $currency->code);
                }
            } elseif ($key == 'date_format_id') {
                $date_format = DateFormat::find($value);
                if ($date_format) {
                    UpdateGeneralSetting('date_format_id', $value);
                    UpdateGeneralSetting('active_date_format', $date_format->format);
                }
            }
            if (!in_array($key, ['logo', 'logo2', 'logo3', 'favicon','datatable_default_font'])) {
                UpdateGeneralSetting($key, $value);
            }

        }
        return true;
    }


    public function imageUpload($key, $value)
    {
        UpdateGeneralSetting($key, '');
        $setting = GeneralSetting::where('key', $key)->first();
        if ($setting) {
            $this->removeLink($setting->id, get_class($setting));
            $url = $this->generateLink($value, $setting->id, get_class($setting), 'value');
            UpdateGeneralSetting($key, $url);
        }

        if ($url == null) {
            return false;
        }
        try {
            if ($key == 'logo') {
                $site_log_sizes = [
                    ['640', '1136'],
                    ['750', '1334'],
                    ['828', '1792'],
                    ['1125', '2436'],
                    ['1242', '2208'],
                    ['1242', '2688'],
                    ['1536', '2048'],
                    ['1668', '2224'],
                    ['1668', '2388'],
                    ['2048', '2732'],
                ];
                foreach ($site_log_sizes as $size) {
                    $rowImage = $this->manager->create($size[0], $size[1], '#fff');
                    $rowImage->place($url, 'center');
                    $rowImage->save(public_path("images/icons/splash-{$size[0]}x{$size[1]}.png"));
                }


            } elseif ($key == 'favicon') {
                $fav_icon_sizes = [72, 96, 128, 144, 152, 192, 384, 512];
                foreach ($fav_icon_sizes as $size) {
                    $rowImage = $this->manager->create($size, $size, '#fff');
                    $rowImage->place($url, 'center');
                    $rowImage->save(public_path("images/icons/icon-{$size}x{$size}.png"));
                }
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
    public function mediaManageSelect($key, $value)
    {
        UpdateGeneralSetting($key, '');
        $setting = GeneralSetting::where('key', $key)->first();
        if ($setting) {
            $this->removeLink($setting->id, get_class($setting));
            $url = $this->generateLink($value, $setting->id, get_class($setting), 'value');
            UpdateGeneralSetting($key, $url);
        }
    }
}
