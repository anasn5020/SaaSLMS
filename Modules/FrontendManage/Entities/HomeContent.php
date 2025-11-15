<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\UsedMedia;
use App\Traits\HasTranslations;

class HomeContent extends Model
{
    use Tenantable;

    protected $guarded = [];

    use HasTranslations;

    public $translatable = ['value'];

//    public static function boot()
//    {
//        if (function_exists('SaasDomain')) {
//            $domain = SaasDomain();
//        } else {
//            $domain = 'main';
//        }
//        parent::boot();
//        self::created(function ($model) use ($domain) {
//
//            GenerateHomeContent($domain);
//        });
//        self::updated(function ($model) use ($domain) {
//            GenerateHomeContent($domain);
//        });
//    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('home_contents_');
                clearAllLangCache('homeContents_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('home_contents_');
                clearAllLangCache('homeContents_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('home_contents_');
                clearAllLangCache('homeContents_');
            }
        });
    }

    public function value_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'value');
    }

}
