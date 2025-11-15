<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\Component;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Setting\Entities\Badge;
use Modules\Setting\Entities\StudentSetup;
use Modules\Setting\Http\Controllers\BadgeController;

class MyDashboardPageSection extends Component
{

    public function __construct()
    {
        //
    }

    public function render()
    {
        ;
        $data['user'] = $user = Auth::user();
        $enrolledByUser = CourseEnrolled::where('user_id', Auth::user()->id)->orderBy('last_view_at', 'desc');

        $total_spent = $enrolledByUser->sum('purchase_price');
        $total_purchase = $enrolledByUser->count() ?? 0;


        $Hour = date('G');

        if ($Hour >= 5 && $Hour <= 11) {
            $wish_string = trans("student.Good Morning");
        } else if ($Hour >= 12 && $Hour <= 18) {
            $wish_string = trans("student.Good Afternoon");
        } else if ($Hour >= 19 || $Hour <= 4) {
            $wish_string = trans("student.Good Evening");
        }
        $date = Carbon::now(Settings('active_time_zone'))->translatedFormat("jS F Y \, l");

        $mycourse = $enrolledByUser
            ->whereHas('course', function ($query) {
                $query->where('type', '=', 1);
            })
            ->with('course', 'course.lessons', 'course.activeReviews', 'course.completeLessons', 'course.completeLessons')->take(3)->get();

        $student_setup = StudentSetup::getData();
        $courses = Course::where('type', 1)->where('status', 1)->inRandomOrder()->limit(3)->with('lessons', 'enrollUsers', 'cartUsers', 'user', 'reviews', 'BookmarkUsers', 'courseLevel')
            ->whereDoesntHave('enrolls', function ($q) {
                $q->where('user_id', '=', Auth::id());
            })
            ->get();
        $quizzes = Course::where('type', 2)->where('status', 1)->inRandomOrder()->limit(3)->with('quiz', 'quiz.assign', 'enrollUsers', 'cartUsers', 'user', 'reviews', 'BookmarkUsers', 'courseLevel')
            ->whereDoesntHave('enrolls', function ($q) {
                $q->where('user_id', '=', Auth::id());
            })->get();

        $withForClass = ['activeReviews', 'enrollUsers', 'cartUsers', 'class', 'class.zoomMeetings', 'user', 'reviews', 'BookmarkUsers', 'courseLevel'];
        if (isModuleActive('BBB')) {
            $withForClass[] = 'class.bbbMeetings';
        }
        if (isModuleActive('Jisti')) {
            $withForClass[] = 'class.jitsiMeetings';
        }
        $classes = Course::where('type', 3)->where('status', 1)->inRandomOrder()->limit(3)->with($withForClass)
            ->whereDoesntHave('enrolls', function ($q) {
                $q->where('user_id', '=', Auth::id());
            })->get();

        $myCertificateNumber = CertificateRecord::where('student_id', Auth::id())->count();

        $badges = [];

        if (Settings('gamification_status') && Settings('gamification_leaderboard_show_badges_status')) {
            $badgeController = new BadgeController();
            $types = array_keys($badgeController->badgesTypes());
            $myBadgesIds = Auth::user()->userLatestBadges->pluck('badge_id')->toArray();
            $notForStudent = [
                'blogs',
                'sales',
                'rating'
            ];
            $reg_badges = Badge::select('id', 'point')->where('type', 'registration')->where(function ($query) {
                $totalDay = 0;
                if (Auth::check()) {
                    $created = new \Illuminate\Support\Carbon(Auth::user()->created_at);
                    $now = Carbon::now();
                    $totalDay = $now->diffInDays($created);
                }
                $query->where('point', '<=', $totalDay);
            })->orderBy('point', 'asc')->get()->pluck('id')->toArray();
            $myBadgesIds = array_merge($myBadgesIds, $reg_badges);
            $badges = Badge::select('title', 'image', 'type', 'point')
                ->where('status', 1)
                ->whereIn('type', $types)->where('status', 1)
                ->whereNotIn('id', $myBadgesIds)
                ->orderBy('point', 'asc')
                ->whereNotIn('type', $notForStudent)
                ->get()
                ->groupBy('type');
        }

        $data['noticeboards'] = [];
        $hasNoticeboard = hasTable('noticeboards');
        if ($hasNoticeboard) {
            $courseId = $user->studentCourses->pluck('course_id')->toArray();


            $query = \Modules\Noticeboard\Entities\Noticeboard::where('status', 1)->with('noticeType');

            if (isModuleActive('Organization') && !empty($user->organization_id)) {
                $query->whereHas('user', function ($q) use ($user) {
                    $q->where('id', $user->organization_id);
                });
            }
            $data['noticeboards'] = $query->whereHas('assign', function ($q) use ($courseId, $user) {
                $q->whereIn('course_id', $courseId);
                $q->orWhere('role_id', $user->role_id);
            })->latest()->limit(5)->get();
        }

        return view(theme('components.my-dashboard-page-section'), $data, compact('badges', 'myCertificateNumber', 'quizzes', 'courses', 'classes', 'data', 'mycourse', 'wish_string', 'date', 'total_purchase', 'student_setup', 'total_spent'));
    }
}
