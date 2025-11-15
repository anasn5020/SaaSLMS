<?php

namespace Modules\Zoom\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;


class ZoomSetting extends Model
{

    use Tenantable;

    protected $guarded = ['id'];
    protected $table = 'zoom_settings';

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('ZoomSetting_' . SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('ZoomSetting_' . SaasDomain());
        });
        self::deleted(function ($model) {
            Cache::forget('ZoomSetting_' . SaasDomain());
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('ZoomSetting_' . SaasDomain(), function () {
            return ZoomSetting::first();
        });
    }
}
