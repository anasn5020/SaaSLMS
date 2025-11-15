<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Modules\Org\Http\Controllers\OrgColorController;

class FrontendDynamicStyleColor extends Component
{

    public function render()
    {
        if (currentTheme() == 'wetech' && Settings('wetech_color')) {
            try {
                $colors = OrgColorController::colorList();
                $color = $colors[Settings('wetech_color')] ?? [];
                $color = $color['style'];
            } catch (\Exception $exception) {
                $color = [
                    "system_primary_color" => "#00C895",
                    "system_primary_color_10" => "#00C8951A",
                    "system_primary_color_20" => "#00C89533",
                    "system_primary_color_30" => "#00C8954D",
                    "system_primary_color_50" => "#00C89580",
                    "system_primary_color_60" => "#00C89599",
                    "system_primary_color_80" => "#00C895CC",
                    "system_primary_color_90" => "#00C895E6",
                    "system_secendory_color" => "#202E3B",
                    "footer_background_color" => "#1E2147",
                    "footer_headline_color" => "#ffffff",
                    "footer_text_color" => "#5B5C6E",
                    "footer_text_hover_color" => "#00C895",
                    "system_primary_gradient" => "linear-gradient(135deg, #00C895 0%, #009670 100%)",
                    "system_dark_20" => "#12131533",
                    "system_white_10" => "#ffffff10",
                    "system_primary_dark" => "#02B789",
                    "system_primary_white" => "#fafafa"
                ];
            }
        } else {
            if (function_exists('SaasInstitute') && SaasInstitute() != null) {
                $institute_id = SaasInstitute()->id;
            } else {
                $institute_id = 1;
            }
            if (function_exists('SaasDomain')) {
                $domain = SaasDomain();
            } else {
                $domain = 'main';
            }
            $color = Cache::rememberForever('color_theme_' . $domain, function () use ($institute_id) {
                return DB::table('themes')
                    ->select(
                        'theme_customizes.primary_color',
                        'theme_customizes.gradient_color',
                        'theme_customizes.secondary_color',
                        'theme_customizes.footer_background_color',
                        'theme_customizes.footer_headline_color',
                        'theme_customizes.footer_text_color',
                        'theme_customizes.footer_text_hover_color',
                        'theme_customizes.bg_color',
                        'theme_customizes.is_gradient',
                    )
                    ->join('theme_customizes', 'themes.name', '=', 'theme_customizes.theme_name')
                    ->where('theme_customizes.lms_id', '=', $institute_id)
                    ->where('themes.is_active', '=', 1)
                    ->where('theme_customizes.is_default', '=', 1)
                    ->first();
            });
        }

        return view(theme('components.frontend-dynamic-style-color'), compact('color'));
    }
}
