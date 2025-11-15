<?php

namespace Modules\Appearance\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ThemeCustomize extends Model
{
    use Tenantable;
    protected $guarded = ['id'];
    protected $casts = [
        'primary_color'             => 'string',
        'secondary_color'           => 'string',
        'footer_background_color'   => 'string',
        'footer_headline_color'     => 'string',
        'footer_text_color'         => 'string',
        'footer_text_hover_color'   => 'string',
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_name', 'name')->withDefault();
    }


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('theme_customizes_' . SaasDomain());
            Cache::forget('color_theme_' . SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('theme_customizes_' . SaasDomain());
            Cache::forget('color_theme_' . SaasDomain());
        });
        self::deleted(function ($model) {
            Cache::forget('theme_customizes_' . SaasDomain());
            Cache::forget('color_theme_' . SaasDomain());
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('theme_customizes_' . SaasDomain(), function () {
            return ThemeCustomize::select('*')->first();
        });
    }
}
