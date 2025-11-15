<?php

namespace App\Http\Resources\api\v2\GeneralSettings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
use Modules\Appearance\Entities\ThemeCustomize;
use Modules\Setting\Model\BusinessSetting;
use Modules\SystemSetting\Entities\Modules;

class DefaultSettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $theme = ThemeCustomize::where('is_default', 1)
            ->select('primary_color', 'secondary_color', 'footer_background_color', 'footer_headline_color', 'footer_text_color', 'footer_text_hover_color')
            ->first();
        $emailVerificaiton = BusinessSetting::where('type', 'email_verification')->first();

        $modules = Modules::get()->pluck('name');

        $moduleData = [];
        foreach($modules as $module){
            // $moduleData[$module] = isModuleActive($module);
            $moduleData[] = [
                'name' => (string)$module,
                'status' => (bool)isModuleActive($module),
            ];
        }

        return [
            'site_title'            => (string)$this['site_title'],
            'student_reg'           => (bool)$this['student_reg'],
            'instructor_reg'        => (bool)$this['instructor_reg'],
            'currency_code'         => (string)$this['currency_code'],
            'currency_symbol'       => (string)$this['currency_symbol'],
            'email_verification'    => (bool)$emailVerificaiton->status,
            'theme_color'           => $theme,
            'modules'               => $moduleData,
            'is_demo'               => Config::get('app.demo_mode'),
        ];
    }
}
