<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class PrivacyPolicy extends Model
{
    use Tenantable;

    protected $fillable = [];

    use HasTranslations;

    public $translatable = ['details', 'page_banner_title', 'page_banner_sub_title'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('PrivacyPolicy_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('PrivacyPolicy_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('PrivacyPolicy_');
            }
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('PrivacyPolicy_' . app()->getLocale() . SaasDomain(), function () {
            return PrivacyPolicy::first();
        });
    }
}
