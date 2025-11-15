<?php

namespace Modules\VirtualClass\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;


class ClassSetting extends Model
{

    use Tenantable;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('ClassSetting_' . SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('ClassSetting_' . SaasDomain());
        });
        self::deleted(function ($model) {
            Cache::forget('ClassSetting_' . SaasDomain());
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('ClassSetting_' . SaasDomain(), function () {
            return ClassSetting::first();
        });
    }
}
