<?php

namespace Modules\Setting\Model;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Localization\Entities\Language;
use Modules\Setting\Entities\UsedMedia;

class GeneralSetting extends Model
{

    use Tenantable;

    protected $hidden = ['id', 'created_at', 'updated_at'];


    protected $guarded = [];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id')->withDefault();
    }

    public function timezone()
    {
        return $this->belongsTo(TimeZone::class, 'time_zone_id')->withDefault();
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class)->withDefault();
    }

    public function date_format()
    {
        return $this->belongsTo(DateFormat::class, 'date_format_id')->withDefault();
    }


    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            if (function_exists('SaasDomain')) {
                GenerateGeneralSetting(SaasDomain());
                Cache::forget('frontend_active_theme_' . SaasDomain());
                Cache::forget('PermissionList_' . SaasDomain());
                Cache::forget('SidebarPermissionList_1' . SaasDomain());
                Cache::forget('SidebarPermissionList_2' . SaasDomain());
                Cache::forget('SidebarPermissionList_3' . SaasDomain());
                Cache::forget('SidebarPermissionList_4' . SaasDomain());
                Cache::forget('SidebarPermissionList_5' . SaasDomain());
                Cache::forget('MenuPermissionList_' . SaasDomain());
                Cache::forget('MenuPermissionList_' . SaasDomain());
                Cache::forget('RoleList_' . SaasDomain());
                Cache::forget('oldPermissionSync' . SaasDomain());
            }

        });
        self::updated(function ($model) {
            if (function_exists('SaasDomain')) {
                GenerateGeneralSetting(SaasDomain());
                Cache::forget('frontend_active_theme_' . SaasDomain());
                Cache::forget('PermissionList_' . SaasDomain());
                Cache::forget('SidebarPermissionList_1' . SaasDomain());
                Cache::forget('SidebarPermissionList_2' . SaasDomain());
                Cache::forget('SidebarPermissionList_3' . SaasDomain());
                Cache::forget('SidebarPermissionList_4' . SaasDomain());
                Cache::forget('SidebarPermissionList_5' . SaasDomain());
                Cache::forget('MenuPermissionList_' . SaasDomain());
                Cache::forget('MenuPermissionList_' . SaasDomain());
                Cache::forget('RoleList_' . SaasDomain());
                Cache::forget('oldPermissionSync' . SaasDomain());

            }
        });
    }

    public function value_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'value');
    }


}
