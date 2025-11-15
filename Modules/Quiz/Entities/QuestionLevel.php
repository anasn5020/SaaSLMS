<?php

namespace Modules\Quiz\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Traits\HasTranslations;

class QuestionLevel extends Model
{
    use Tenantable;

    protected $guarded = [];

    use HasTranslations;

    public $translatable = ['title'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('QuestionLevel_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('QuestionLevel_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('QuestionLevel_');
            }
        });
    }

    public static function getAllActiveData()
    {
        return Cache::rememberForever('QuestionLevel_' . app()->getLocale() . SaasDomain(), function () {
            return QuestionLevel::select('id', 'title')->where('status', 1)->get();
        });
    }

    public function totalQuestions()
    {
        return $this->hasMany(QuestionBank::class, 'level')->count();
    }

    public function questions()
    {
        return $this->hasMany(QuestionBank::class, 'level');
    }
}
