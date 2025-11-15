<?php

namespace Modules\FrontendManage\Entities;

use App\AboutPage;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Traits\HasTranslations;

class BecomeInstructor extends Model
{
    use Tenantable;

    protected $fillable = [];

    use HasTranslations;

    public $translatable = ['section', 'title', 'description', 'btn_name'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('BecomeInstructor_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('BecomeInstructor_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('BecomeInstructor_');
            }
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('BecomeInstructor_' . app()->getLocale() . SaasDomain(), function () {
            return BecomeInstructor::all();
        });
    }
}
