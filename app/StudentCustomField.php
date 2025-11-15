<?php

namespace App;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class StudentCustomField extends Model
{
    use Tenantable;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('student_custom_field_'.SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('student_custom_field_'.SaasDomain());
        });
        self::deleted(function ($model) {
            Cache::forget('student_custom_field_'.SaasDomain());
        });
    }
    public static function getData()
    {
        return Cache::rememberForever('student_custom_field_'.SaasDomain(), function () {
            return StudentCustomField::first();
        });
    }
}
