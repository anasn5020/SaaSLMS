<?php

namespace Modules\Localization\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


class Language extends Model
{
    use Tenantable;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('LanguageList_' . SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('LanguageList_' . SaasDomain());
        });
        self::deleted(function ($model) {
            Cache::forget('LanguageList_' . SaasDomain());
        });
    }
}
