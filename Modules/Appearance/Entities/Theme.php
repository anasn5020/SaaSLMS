<?php

namespace Modules\Appearance\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Setting\Model\GeneralSetting;
use Modules\Appearance\Entities\ThemeCustomize;

class Theme extends Model
{
    use Tenantable;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            GenerateGeneralSetting(SaasDomain());
            Cache::forget('frontend_active_theme_' . SaasDomain());
            Cache::forget('getAllTheme_' . SaasDomain());
            Cache::forget('color_theme_' . SaasDomain());

        });

        self::updated(function ($model) {
            GenerateGeneralSetting(SaasDomain());
            Cache::forget('frontend_active_theme_' . SaasDomain());
            Cache::forget('getAllTheme_' . SaasDomain());
            Cache::forget('color_theme_' . SaasDomain());


        });

        self::deleted(function ($model) {
            GenerateGeneralSetting(SaasDomain());
            Cache::forget('theme_customizes_' . SaasDomain());
            Cache::forget('getAllTheme_' . SaasDomain());
            Cache::forget('color_theme_' . SaasDomain());

        });
    }

    public static function getAllData()
    {
        return Cache::rememberForever('getAllTheme_' . SaasDomain(), function () {
            return Theme::get();
        });
    }

}
