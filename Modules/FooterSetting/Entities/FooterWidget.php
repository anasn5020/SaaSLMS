<?php

namespace Modules\FooterSetting\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Modules\FrontendManage\Entities\FrontPage;
use App\Traits\HasTranslations;

class FooterWidget extends Model
{
    use Tenantable;

    protected $guarded = ['id'];

    use HasTranslations;

    public $translatable = ['name'];

    public function frontpage()
    {
        return $this->belongsTo(FrontPage::class, 'page_id')->withDefault();
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('sectionWidgets_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('sectionWidgets_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('sectionWidgets_');
            }
        });
    }
}
