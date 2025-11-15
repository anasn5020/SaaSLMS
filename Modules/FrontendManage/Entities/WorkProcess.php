<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

use App\Traits\HasTranslations;

class WorkProcess extends Model
{
    use Tenantable;

    protected $guarded = [];

    use HasTranslations;

    public $translatable = ['title', 'description'];


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('WorkProcess_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('WorkProcess_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('WorkProcess_');
            }
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('WorkProcess_' . app()->getLocale() . SaasDomain(), function () {
            return WorkProcess::select('title', 'description')->where('status', 1)->get();
        });
    }
}
