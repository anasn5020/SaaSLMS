<?php

namespace App;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class AboutPage extends Model
{
    use Tenantable;
    use HasTranslations;

    public $translatable = [
        'who_we_are',
        'banner_title',
        'story_title',
        'story_description',
        'total_teacher',
        'teacher_title',
        'teacher_details',
        'total_student',
        'student_title',
        'student_details',
        'total_courses',
        'course_title',
        'course_details',
        'about_page_content_title',
        'about_page_content_details',
        'about_page_content_details2',
        'live_class_title',
        'live_class_details',
        'sponsor_title',
        'sponsor_sub_title',
        'registered_students',
        'quality_content',
        'questions_answers',
        'our_mission',
        'our_vision'
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('AboutPage_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('AboutPage_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('AboutPage_');
            }
        });
    }

    public static function getData()
    {
        return Cache::rememberForever('AboutPage_' . app()->getLocale() . SaasDomain(), function () {
            return AboutPage::first();
        });
    }

}
