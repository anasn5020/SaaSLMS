<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class IpBlock extends Model
{
    protected $fillable = [];


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('ipBlockList_'.SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('ipBlockList_'.SaasDomain());
        });
        self::deleted(function($model){
            Cache::forget('ipBlockList_'.SaasDomain());
        });

    }



}
