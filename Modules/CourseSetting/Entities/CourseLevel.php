<?php

namespace Modules\CourseSetting\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

use App\Traits\Organization;

class CourseLevel extends Model
{
    use Tenantable, Organization;

    protected $guarded = ['id'];

    use HasTranslations;

    public $translatable = ['title'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('CourseLevel_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('CourseLevel_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('CourseLevel_');
            }
        });
    }

    public static function getAllActiveData()
    {
        return Cache::rememberForever('CourseLevel_' . app()->getLocale() . SaasDomain(), function () {
            return CourseLevel::select('id', 'title')->where('status', 1)->get();
        });
    }

    public function totalCourse()
    {
        return $this->hasMany(Course::class, 'level')->count();
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'level');
    }
}
