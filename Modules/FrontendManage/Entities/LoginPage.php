<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Setting\Entities\UsedMedia;
use App\Traits\HasTranslations;

class LoginPage extends Model
{
    use Tenantable;
    use HasTranslations;

    public $translatable = ['title', 'slogans1', 'slogans2', 'slogans3', 'reg_title', 'reg_slogans1', 'reg_slogans2', 'reg_slogans3', 'forget_title', 'forget_slogans1', 'forget_slogans2', 'forget_slogans3'];
    protected $fillable = [];

    public static function boot()
    {

        parent::boot();

        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('login_page_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('login_page_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('login_page_');
            }
        });

    }

    public static function getData()
    {
        return Cache::rememberForever('login_page_' . app()->getLocale() . SaasDomain(), function () {
            return LoginPage::firstOrCreate();
        });
    }

    public function banner_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'banner');
    }

    public function reg_banner_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'reg_banner');
    }

    public function forget_banner_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'forget_banner');
    }

}
