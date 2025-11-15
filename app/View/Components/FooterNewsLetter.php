<?php

namespace App\View\Components;

use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;

class FooterNewsLetter extends Component
{


    public function render()
    {
        $newsletterSetting = Cache::rememberForever('newsletterSetting_' . SaasDomain(), function () {
            return DB::table('newsletter_settings')
                ->select('home_status', 'home_service', 'home_list_id', 'student_status', 'student_service', 'student_list_id', 'instructor_status',
                    'instructor_status', 'instructor_service', 'instructor_list_id')
                ->first();
        });
        $data = [];
        if (currentTheme() == 'teachery') {
            $data['course_enroll_count'] = CourseEnrolled::count();
            $data['course_count'] = Course::count();
            $data['instructor_count'] = User::where('role_id', 2)->count();
        }
        return view(theme('components.footer-news-letter'), $data, compact('newsletterSetting'));
    }
}
