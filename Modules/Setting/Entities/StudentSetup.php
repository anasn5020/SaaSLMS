<?php

namespace Modules\Setting\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class StudentSetup extends Model
{
    use Tenantable;
    protected $fillable = [];


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('student_setups_'.SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('student_setups_'.SaasDomain());
        });
        self::deleted(function ($model) {
            Cache::forget('student_setups_'.SaasDomain());
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('student_setups_'.SaasDomain(), function () {
            return StudentSetup::first();
        });
    }
}
