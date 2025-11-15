<?php

namespace Modules\ModuleManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Module extends Model
{


    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('ModuleList');
        });
        self::updated(function ($model) {
            Cache::forget('ModuleList');
        });
        self::deleted(function ($model) {
            Cache::forget('ModuleList');
        });
    }

    public function verify()
    {
        return $this->belongsTo(InfixModuleManager::class, 'name', 'name')->withDefault();
    }
}
