<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\UserLogin;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Noticeboard\Entities\Noticeboard;
use Modules\Payment\Entities\Withdraw;
use Modules\Setting\Entities\Badge;
use Modules\Setting\Http\Controllers\BadgeController;

class HomeController extends Controller
{

    public function __construct()
    {

        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        if (Auth::user()->role_id == 1) {
            return redirect()->route('dashboard');
        } else if (Auth::user()->role_id == 2) {
            return redirect()->route('dashboard');
        } else if (Auth::user()->role_id == 3) {
            return redirect()->route('studentDashboard');
        } else {
            return redirect('/');
        }
    }

    //dashboard
    public function dashboard()
    {
        try {
            $user = Auth::user();

            // Redirect for specific roles
            if ($user->role_id == 3) {
                return redirect()->route('studentDashboard');
            }

            if (isModuleActive('Affiliate') && $user->role->name == 'Affiliate') {
                return redirect()->route('affiliate.my_affiliate.index');
            }

            $currentYear = Carbon::now()->year;
            $currentMonth = Carbon::now()->month;
            $data = [];

            // Recent enrollments
            $recentEnrollQuery = CourseEnrolled::query()
                ->latest()
                ->take(4)
                ->select('reveune', 'course_id', 'user_id', 'purchase_price')
                ->with('course', 'course.user', 'user');

            if ($user->role_id == 1) {
                $recentEnroll = $recentEnrollQuery->get();

                $coursesEarnings = CourseEnrolled::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->get();

                $courses_enrolle = $coursesEarnings->groupBy(fn($enroll) => $enroll->created_at->format('d M'))
                    ->map(fn($group) => $group->sum('qty'));
            } else {
                $recentEnrollQuery->whereHas('course', fn($query) => $query->where('user_id', $user->id));
                $recentEnroll = $recentEnrollQuery->get();

                $coursesEarnings = CourseEnrolled::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->whereHas('course', fn($query) => $query->where('user_id', $user->id))
                    ->get();

                $courses_enrolle = $coursesEarnings->groupBy(fn($enroll) => $enroll->created_at->format('d M'))
                    ->map(fn($group) => $group->sum('qty'));
            }

            // Daily revenue
            $dailyRevenue = $coursesEarnings->groupBy(fn($earning) => $earning->created_at->format('d M'))
                ->map(fn($group) => $group->sum('reveune'));

            $courshEarningM_onth_name = $dailyRevenue->keys()->toArray();
            $courshEarningMonthly = $dailyRevenue->values()->toArray();

            // Payment statistics
            $withdrawsQuery = Withdraw::selectRaw('monthname(issueDate) as month, YEAR(issueDate) as year, status')
                ->whereYear('issueDate', $currentYear)
                ->whereMonth('issueDate', $currentMonth);

            if ($user->role_id != 1) {
                $withdrawsQuery->where('instructor_id', $user->id);
            }

            $withdraws = $withdrawsQuery->get();
            $payment_statistics = [
                'paid' => $withdraws->where('status', 1),
                'unpaid' => $withdraws->where('status', 0),
                'month' => Carbon::now()->translatedFormat('F'),
                'year' => translatedNumber(Carbon::now()->year),
            ];

            // Course Overview
            $courseQuery = Course::with('user', 'enrolls');

            if (isModuleActive('Organization') && $user->isOrganization()) {
                $courseQuery->whereHas('user', fn($q) => $q->where('organization_id', Auth::id())->orWhere('id', Auth::id()));
            }

            $allCourses = $courseQuery->get();
            $course_overview = [
                'active' => $allCourses->where('status', 1)->count(),
                'pending' => $allCourses->where('status', 0)->count(),
                'courses' => $allCourses->where('type', 1)->count(),
                'quizzes' => $allCourses->where('type', 2)->count(),
                'classes' => $allCourses->where('type', 3)->count(),
            ];

            // Daily Enrollment
            $enroll_day = $courses_enrolle->keys()->toArray();
            $enroll_count = $courses_enrolle->values()->toArray();

            // CPD Module
            $students = isModuleActive('CPD') ? User::select('id','name')->withCount('cpds')->where('role_id', 3)->get() : null;

            // Gamification badges
            $badges = [];

            if (Settings('gamification_status') && Settings('gamification_leaderboard_show_badges_status')) {
                $badgeController = new BadgeController();
                $types = array_keys($badgeController->badgesTypes());
                $myBadgesIds = Auth::user()->userLatestBadges->pluck('badge_id')->toArray();
                $notForStudent = [
                    'blogs',
                    'sales',
                    'rating',
                    'registration'
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
                    ->whereIn('type', $notForStudent)
                    ->get()
                    ->groupBy('type');
            }
            // Noticeboard
            if (isModuleActive('Noticeboard') && hasTable('noticeboards')) {
                $courseId = $user->studentCourses->pluck('course_id')->toArray();
                $query = Noticeboard::where('status', 1)->with('noticeType');

                if (isModuleActive('Organization') && !empty($user->organization_id)) {
                    $query->whereHas('user', fn($q) => $q->where('id', $user->organization_id));
                }

                $data['noticeboards'] = $query->whereHas('assign', fn($q) => $q->whereIn('course_id', $courseId)
                    ->orWhere('role_id', $user->role_id))->latest()->limit(5)->get();
            }

            return view('dashboard', $data, compact(
                'badges',
                'recentEnroll',
                'courshEarningM_onth_name',
                'courshEarningMonthly',
                'payment_statistics',
                'enroll_day',
                'enroll_count',
                'course_overview',
                'allCourses',
                'students'
            ));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function userLoginChartByDays(Request $request)
    {
        $userLoginChartByDays = [];
        $type = $request->type;
        $days = $request->days;

        if ($type == "days") {

            $from = Carbon::now()->subDays($days - 1);
            $to = Carbon::now();


        } else {
            $allDays = explode(' - ', $days);
            $from = Carbon::parse($allDays[0]);
            $to = Carbon::parse($allDays[1]);
        }


        $period = CarbonPeriod::create($from, $to);
        $dates = [];
        $data = [];

        foreach ($period as $key => $value) {
            $day = $value->format('Y-m-d');
            $dates[] = $day;
            $query5 = UserLogin::whereDate('login_at', $day);
            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query5->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }
            $data[] = translatedNumber($query5->count());
        }
        $userLoginChartByDays['date'] = $dates;
        $userLoginChartByDays['data'] = $data;

        return $userLoginChartByDays;
    }

    public function userLoginChartByTime(Request $request)
    {
        $userLoginChartByDays = [];
        $type = $request->type;
        $days = $request->days;

        if ($type == "days") {

            $from = Carbon::now()->subDays($days - 1);
            $to = Carbon::now();


        } else {
            $allDays = explode(' - ', $days);
            $from = Carbon::parse($allDays[0]);
            $to = Carbon::parse($allDays[1]);
        }


        $period = CarbonPeriod::create($from, $to);
        $hours = [];

        foreach ($period as $key => $value) {
            $day = $value->format('Y-m-d');


            $query6 = UserLogin::whereDate('login_at', $day);

            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query6->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }

            $loginData = $query6->get(['id', 'login_at'])->groupBy(function ($date) {
                return Carbon::parse($date->login_at)->format('H');
            });

            for ($i = 0; $i <= 23; $i++) {
                if (!isset($hours[$i])) {
                    $hours[$i] = 0;
                }
                if (!isset($loginData[$i])) {
                    $loginData[$i] = [];
                }
                $hours[$i] = count($loginData[$i]) + $hours[$i];
            }
        }
        return $hours;
    }

    public function getDashboardData()
    {
        try {
            $user = Auth::user();

            if ($user->role_id == 2) {
                $allCourseEnrolled = CourseEnrolled::with('user', 'course')
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })->get();

                $allCourses = Course::where('user_id', $user->id)->get();

                $thisMonthEnroll = CourseEnrolled::whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })->sum('purchase_price');


                $today = CourseEnrolled::whereDate('created_at', Carbon::today())
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })->sum('purchase_price');


                $rev = $allCourseEnrolled->sum('reveune');
            } else {
                $query = CourseEnrolled::query();
                if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                    $query->whereHas('course.user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('id', Auth::id());
                    });
                }
                $allCourseEnrolled = $query->get();
                $query2 = Course::query();
                if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                    $query2->whereHas('user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('id', Auth::id());
                    });
                }
                $allCourses = $query2->get();

                $query3 = CourseEnrolled::whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'));

                if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                    $query3->whereHas('course.user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('id', Auth::id());
                    });
                }

                $thisMonthEnroll = $query3->sum('purchase_price');

                $query4 = CourseEnrolled::whereDate('created_at', Carbon::today());
                if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                    $query4->whereHas('course.user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('id', Auth::id());
                    });
                }
                $today = $query4->sum('purchase_price');

//
                $rev = (isModuleActive('Organization') && Auth::user()->isOrganization()) ? $allCourseEnrolled->sum('reveune') : $allCourseEnrolled->sum('purchase_price') - $allCourseEnrolled->sum('reveune');
            }

            $info['allCourse'] = translatedNumber($allCourses->count());
            $info['totalEnroll'] = translatedNumber($allCourseEnrolled->count());
            $info['thisMonthEnroll'] = getPriceFormat($thisMonthEnroll,false);
            $info['today'] = getPriceFormat($today,false);

            $user_query = User::whereIn('role_id', [2, 3]);

            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $user_query->where('organization_id', Auth::id());
            }
            $users = $user_query->get();

            $info['student'] = translatedNumber($users->where('role_id', 3)->count());
            $info['instructor'] = translatedNumber($users->where('role_id', 2)->count());
            $info['totalSell'] = getPriceFormat($allCourseEnrolled->sum('purchase_price'),false);
            $info['adminRev'] = getPriceFormat($rev,false);
            return Response::json($info);
        } catch (Exception $e) {
            return Response::json(['error' => $e->getMessage()]);
        }
    }


    public function validateGenerate()
    {
        return view('validate_generate');
    }


    public function validateGenerateSubmit()
    {
        $field = request()->field;
        $rules = request()->rules;
        $arr = [];


        $single_rule = explode('|', $rules);


        foreach ($single_rule as $rule) {
            $string = explode(':', $rule);
            $rule_name = $rule_message_key = $string[0];

            if (in_array($rule_name, ['max', 'min'])) {
                $rule_message_key = $rule_message_key . '.string';
            }

            $message = __('validation.' . $rule_message_key);

            $field_string = str_replace('_', ' ', $field);

            $message = str_replace(
                [':attribute', ':ATTRIBUTE', ':Attribute'],
                [$field_string, Str::upper($field_string), Str::ucfirst($field_string)],
                $message
            );
            if (in_array($rule_name, ['max', 'min'])) {
                $message = str_replace(
                    [':' . $rule_name],
                    [$string[1]],
                    $message
                );
            }

            if ($rule_name == 'required_if') {
                $ex = explode(',', $string[1]);
                $message = str_replace(
                    [':other'],
                    [str_replace('_', ' ', $ex[0])],
                    $message
                );
                if (isset($ex[2])) {
                    $message = str_replace(
                        [':value', "'"],
                        [str_replace('_', ' ', $ex[2]), ''],
                        $message
                    );
                } else {
                    $message = str_replace(
                        [':value', "'"],
                        [str_replace('_', ' ', $ex[1]), ''],
                        $message
                    );
                }
            }

            if ($rule_name == 'mimes') {

                $message = str_replace(
                    [':values'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'same') {

                $message = str_replace(
                    [':other'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'required_with') {

                $message = str_replace(
                    [':values'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }

            if ($rule_name == 'after_or_equal') {

                $message = str_replace(
                    [':date'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'after') {

                $message = str_replace(
                    [':date'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }


            $arr [$field . '.' . $rule_name] = $message;
        }

        $defaultFile = public_path('/../resources/lang/default/validation.php');
        $languages = include "{$defaultFile}";
        $languages = array_merge($languages, $arr);
        file_put_contents($defaultFile, '');
        file_put_contents($defaultFile, '<?php return ' . var_export($languages, true) . ';');

        return view('validate_generate', compact('field', 'rules', 'arr'));
    }
}
