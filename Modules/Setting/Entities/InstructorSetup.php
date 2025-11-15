<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InstructorSetup extends Model
{
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('InstructorSetup_'.SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('InstructorSetup_'.SaasDomain());
        });
        self::deleted(function ($model) {
            Cache::forget('InstructorSetup_'.SaasDomain());
        });
        static::addGlobalScope(new \App\Scopes\LmsScope);

    }
    public static function getData()
    {
        return Cache::rememberForever('InstructorSetup_'.SaasDomain(), function () {
            return InstructorSetup::first();
        });
    }
}
