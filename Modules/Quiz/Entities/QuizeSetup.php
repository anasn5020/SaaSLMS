<?php

namespace Modules\Quiz\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;


class QuizeSetup extends Model
{
    use Tenantable;

    protected $fillable = [];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('QuizSetup_' . SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('QuizSetup_' . SaasDomain());
        });
        self::deleted(function ($model) {
            Cache::forget('QuizSetup_' . SaasDomain());
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('QuizSetup_' . SaasDomain(), function () {
            return QuizeSetup::first();
        });
    }
}
