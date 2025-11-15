<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\HasTranslations;
use App\Traits\Tenantable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class HeaderMenu extends Model
{
    use Tenantable;
    use HasTranslations;

    public $translatable = ['title'];

    protected $guarded = ['id'];


    public function childs()
    {
        return $this->hasMany(HeaderMenu::class, 'parent_id', 'id')->orderBy('position');
    }


    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('menus_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('menus_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('menus_');
            }
        });

        static::addGlobalScope(new \App\Scopes\LmsScope);
    }
}
