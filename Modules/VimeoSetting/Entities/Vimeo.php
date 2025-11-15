<?php

namespace Modules\VimeoSetting\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


class Vimeo extends Model
{

    use Tenantable;

    protected $guarded = ['id'];


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('vimeoSetting_' . SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('vimeoSetting_' . SaasDomain());
        });
    }
}
