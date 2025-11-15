<?php

namespace Modules\PopupContent\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Setting\Entities\UsedMedia;
use App\Traits\HasTranslations;

class PopupContent extends Model
{
    use Tenantable;

    protected $fillable = [];
    use HasTranslations;

    public $translatable = ['title', 'message', 'btn_txt'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('popup_contents_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('popup_contents_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('popup_contents_');
            }
        });
    }


    public static function getData()
    {
        if (function_exists('SaasDomain')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }
        return Cache::rememberForever('popup_contents_' . app()->getLocale() . $domain, function () {
            return PopupContent::first();
        });
    }

    public function image_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'image');
    }

}
