<?php

namespace Modules\FooterSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class FooterSetting extends Model
{
    protected $guarded = [];

    use HasTranslations;

    public $translatable = ['value'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('footerSetting_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('footerSetting_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('footerSetting_');
            }
        });
    }
}
