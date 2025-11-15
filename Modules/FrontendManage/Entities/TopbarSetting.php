<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class TopbarSetting extends Model
{
    use Tenantable;
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('TopbarSetting_'.SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('TopbarSetting_'.SaasDomain());
        });
        self::deleted(function ($model) {
            Cache::forget('TopbarSetting_'.SaasDomain());
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('TopbarSetting_'.SaasDomain(), function () {
            return TopbarSetting::first();
        });
    }
}
