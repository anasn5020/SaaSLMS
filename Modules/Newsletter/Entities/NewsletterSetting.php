<?php

namespace Modules\Newsletter\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class NewsletterSetting extends Model
{
    use Tenantable;
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('newsletterSetting_'.SaasDomain());
            Cache::forget('newsletterSettingData_'.SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('newsletterSetting_'.SaasDomain());
            Cache::forget('newsletterSettingData_'.SaasDomain());

        });

        self::deleted(function ($model) {
            Cache::forget('newsletterSetting_'.SaasDomain());
            Cache::forget('newsletterSettingData_'.SaasDomain());

        });
    }


    public static function getData()
    {
        return Cache::rememberForever('newsletterSetting_'.SaasDomain(), function () {
            return NewsletterSetting::first();
        });
    }
}
