<?php

namespace Modules\SystemSetting\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;


class SocialLink extends Model
{

    use Tenantable;

    protected $fillable = [];


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('social_links_' . SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('social_links_' . SaasDomain());
        });
        self::deleted(function ($model) {
            Cache::forget('social_links_' . SaasDomain());
        });
    }
}
