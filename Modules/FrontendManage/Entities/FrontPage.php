<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasTranslations;

class FrontPage extends Model
{
    use Tenantable;

    protected $guarded = ['id'];

    use HasTranslations;

    public $translatable = [
        'title',
        'sub_title',
        'details'
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('FrontPageList_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('FrontPageList_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('FrontPageList_');
            }
        });
    }
}
