<?php

namespace Modules\SystemSetting\Entities;

use App\User;
use App\Traits\Tenantable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;


class  FrontendSetting extends Model
{
    use Tenantable;

    protected $fillable = ['section', 'title', 'description', 'heading', 'default_title', 'default_description', 'btn_name', 'default_btn', 'url', 'icon'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('SectionList');
        });
        self::updated(function ($model) {
            Cache::forget('SectionList');
        });
    }
}
