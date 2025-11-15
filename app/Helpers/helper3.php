<?php


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\CourseReveiw;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FrontendManage\Entities\HomeContent;
use Modules\HumanResource\Entities\Attendance;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;
use Modules\OrgSubscription\Entities\OrgSubscriptionCheckout;
use Modules\Setting\Entities\ErrorLog;
use Modules\Setting\Entities\IpBlock;
use Modules\Setting\Model\GeneralSetting;
use Modules\Subscription\Entities\SubscriptionCheckout;
use PhpOffice\PhpSpreadsheet\Shared\Date;

if (!function_exists('isRtl')) {
    function isRtl()
    {
        if (Auth::check()) {
            $rtl = Auth::user()->language_rtl;
        } elseif (Session::get('locale')) {
            $rtl = Session::get('language_rtl');
        } else {
            $rtl = Settings('language_rtl');
        }

        if ($rtl == 1) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('getDomainName')) {
    function getDomainName($url)
    {
        $url_domain = preg_replace("(^https?://)", "", $url);
        $url_domain = preg_replace("(^http?://)", "", $url_domain);
        $url_domain = str_replace("/", "", $url_domain);
        return $url_domain;

    }
}

if (!function_exists('getMenuLink')) {
    function getMenuLink($menu)
    {
        $url = url('/');
        if ($menu) {
            if (!empty($menu->link)) {
                if (substr($menu->link, 0, 1) == '/') {
                    if ($menu->link == "/") {
                        return url($menu->link) . '/';

                    }
                    return url($menu->link);
                }
                return $menu->link;
            }
            $type = $menu->type;
            $element_id = $menu->element_id;
            if ($type == "Dynamic Page") {

                $page = FrontPage::find($element_id);
                if ($page) {
                    $url = url($page->slug);
                    //                    $url = \route('frontPage', [$page->slug]);
                }
            } elseif ($type == "Static Page") {
                $page = FrontPage::find($element_id);
                if ($page) {
                    $url = url($page->slug);

                }
            } elseif ($type == "Category") {
                $url = route('courses') . "?category=" . $element_id;

            } elseif ($type == "Sub Category") {
                $url = route('courses') . "?category=" . $element_id;

            } elseif ($type == "Course") {
                $course = Course::find($element_id);
                if ($course) {
                    $url = route('courseDetailsView', [$course->id, $course->slug]);

                }
            } elseif ($type == "Quiz") {
                $course = Course::find($element_id);
                if ($course) {
                    $url = route('classDetails', [$course->id, $course->slug]);

                }
            } elseif ($type == "Class") {
                $course = Course::find($element_id);
                if ($course) {
                    $url = route('courseDetailsView', [$course->id, $course->slug]);

                }
            } elseif ($type == "Custom Link") {
                $url = '';
            }
        }


        return $url;

    }
}

if (!function_exists('isSubscribe')) {
    function isSubscribe()
    {
        if (isModuleActive('Subscription') && Auth::check()) {
            $user = Auth::user();
            $date_of_subscription = $user->subscription_validity_date;
            if (empty($date_of_subscription)) {
                return false;
            }

            $expires_at = new DateTime($date_of_subscription);
            $today = new DateTime('now');


            if ($expires_at < $today)
                return false;

            else {
                return true;
            }
        } else {
            return false;
        }

        return false;

    }
}


if (!function_exists('userCurrentPlan')) {
    function userCurrentPlan()
    {
        if (isModuleActive('Subscription')) {
            if (Auth::check()) {
                $user = Auth::user();
                $date_of_subscription = $user->subscription_validity_date;
                if (empty($date_of_subscription)) {
                    return null;
                }

                $check = SubscriptionCheckout::select('plan_id')->where('end_date', '>=', date('Y-m-d'))->get();
                if (count($check) != 0) {
                    $plan = [];
                    foreach ($check as $p) {
                        $plan[] = $p->plan_id;
                    }
                    return $plan;
                }


            }
        } else {
            return null;
        }

        return null;

    }
}


if (!function_exists('reviewCanDelete')) {
    function reviewCanDelete($review_user_id, $instructor_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($review_user_id == $user->id || $user->role_id == 1 || $instructor_id == $user->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}
if (!function_exists('commentCanDelete')) {
    function commentCanDelete($comment_user_id, $instructor_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($comment_user_id == $user->id || $user->role_id == 1 || $instructor_id == $user->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}
if (!function_exists('blogCommentCanDelete')) {
    function blogCommentCanDelete()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role_id == 1) {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('ReplyCanDelete')) {
    function ReplyCanDelete($reply_user_id, $instructor_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($reply_user_id == $user->id || $user->role_id == 1 || $instructor_id == $user->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


if (!function_exists('hasTax')) {
    function hasTax()
    {
        if (isModuleActive('Tax')) {
            if (Settings('tax_status') == 1) {
                return true;
            } else {
                return false;
            }

        }
        return false;
    }
}

if (!function_exists('countryWishTaxRate')) {
    function countryWishTaxRate()
    {
        $vat = 0;
        if (Auth::check()) {
            $country_id = Auth::user()->country;

            $countryWishTaxList = Cache::rememberForever('countryWishTaxList_' . SaasDomain(), function () {
                return DB::table('country_wish_taxes')
                    ->select('country_id', 'tax')
                    ->where('status', 1)
                    ->get();
            });

            $setting = $countryWishTaxList->where('country_id', $country_id)->first();
            if ($setting) {
                $vat = $setting->tax;
            }
        }
        return $vat;
    }
}
if (!function_exists('applyTax')) {
    function applyTax($price)
    {
        $type = Settings('tax_type');
        if ($type == 1) {
            $vat = Settings('tax_percentage');
        } else {
            $vat = countryWishTaxRate();
        }
        $vatToPay = ($price / 100) * $vat;
        $totalPrice = $price + $vatToPay;

        return $totalPrice;

    }
}
if (!function_exists('taxAmount')) {
    function taxAmount($price)
    {
        if (isModuleActive('Tax')) {
            $type = Settings('tax_type');
            if ($type == 1) {
                $vat = Settings('tax_percentage');
            } else {
                $vat = countryWishTaxRate();
            }
            return ($price / 100) * $vat;
        } else {
            return 0;
        }


    }
}

if (!function_exists('getPriceAsNumber')) {
    function getPriceAsNumber($price)
    {
        return str_replace(',', '', $price);

    }
}


if (!function_exists('currentTheme')) {
    function currentTheme()
    {
        if (app()->bound('getSetting')) {
            return Settings('frontend_active_theme');
        } else {
            return 'infixlmstheme';
        }


    }
}

if (!function_exists('shortDetails')) {
    function shortDetails($string, $length)
    {
        $string = strip_tags($string);
        if (strlen($string) > $length) {

            // truncate string
            $stringCut = substr($string, 0, $length);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '...';
        }
        return $string;
    }
}

if (!function_exists('totalReviews')) {
    function totalReviews($course_id)
    {
        return CourseReveiw::where('course_id', $course_id)->count();
    }
}

if (!function_exists('validationMessage')) {
    function validationMessage($validation_rules)
    {
        $message = [];
        foreach ($validation_rules as $attribute => $rules) {

            if (is_array($rules)) {
                $single_rule = $rules;
            } else {
                $single_rule = explode('|', $rules);
            }

            foreach ($single_rule as $rule) {
                $string = explode(':', $rule);
                $key = $attribute;
                if (strpos($attribute, '.')) {
                    $attr = explode('.', $attribute);
                    $key = $attr[0] ?? '';
                }
                $message [$attribute . '.' . $string[0]] = __('validation.' . $key . '.' . $string[0]);
            }
        }

        return $message;
    }
}

if (!function_exists('escapHtmlChar')) {
    function escapHtmlChar($str)
    {
        $find = ['"', "'"];
        $replace = ['&quot;', '&apos;'];
        return str_replace($find, $replace, htmlspecialchars($str));


    }
}
if (!function_exists('doubleQuotes2singleQuotes')) {
    function doubleQuotes2singleQuotes($str)
    {
        $find = ['"'];
        $replace = ["'"];
        return str_replace($find, $replace, htmlspecialchars($str));


    }
}


if (!function_exists('showDate')) {
    function showDate($date)
    {
        if (!$date) {
            return trans('common.N/A');
        }
        try {
            return translatedNumber(Carbon::parse($date)->locale(app()->getLocale())->translatedFormat(Settings('active_date_format')));
        } catch (Exception $e) {
            return trans('common.N/A');
        }
    }
}

if (!function_exists('checkParent')) {
    function checkParent($category, $string = null)
    {
        if (!empty($category->parent->id)) {
            return checkParent($category->parent, $string . '-');
        }
        if ($string) {
            $string = $string . '>';
        }
        return $string;

    }
}


if (!function_exists('GettingError')) {
    function GettingError($message, $url = '', $ip = '', $agent = '', $return = false)
    {
        if (!Storage::exists('.app_installed') || !Storage::get('.app_installed')) {
            Log::error($message);
            return false;
        }
        if (\config('app.debug')) {
            dd($message);
        }
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = 0;
        }
        ErrorLog::create([
            'subject' => $message,
            'type' => 1,
            'url' => $url,
            'ip' => $ip,
            'agent' => $agent,
            'user_id' => $user_id,
        ]);
        if ($return) {
            return false;
        } else {
            abort('500', trans('frontend.Something went wrong, Please check error log'));
        }

    }
}

if (!function_exists('isViewable')) {
    function isViewable($course)
    {
        $isViewable = true;
        if ($course->status == 0) {
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->role_id != 1 && $course->user_id != $user->id) {
                    $isViewable = false;
                }
            } else {
                $isViewable = false;
            }
        }
        return $isViewable;


    }
}

if (!function_exists('MinuteFormat')) {
    function MinuteFormat($minutes)
    {
        $minutes = doubleval($minutes);
        if ($minutes <= 0) {
            return trans('common.N/A');
        }
        $hours = floor($minutes / 60);
        $min = $minutes - ($hours * 60);
        $result = '';

        if (currentTheme() == 'wetech') {
            if ($hours == 1) {
                $result .= $hours . 'h';
            } elseif ($hours > 1) {
                $result .= $hours . 'h';
            }

            if ($min == 1) {
                $result .= $min . trans('frontend.Min');
            } elseif ($min > 1) {
                $result .= $min . trans('frontend.Min');
            }

        } else {
            if ($hours == 1) {
                $result .= $hours . ' ' . trans('frontend.Hour') . ' ';
            } elseif ($hours > 1) {
                $result .= $hours . ' ' . trans('frontend.Hours') . ' ';
            }

            if ($min == 1) {
                $result .= $min . ' ' . trans('frontend.Min');
            } elseif ($min > 1) {
                $result .= $min . ' ' . trans('frontend.Min');
            }
        }


        return translatedNumber($result);
    }
}

if (!function_exists('UpdateGeneralSetting')) {
    function UpdateGeneralSetting($key, $value)
    {
        try {
            $setting = GeneralSetting::where('key', $key)->first();
            if ($setting) {
                $setting->value = $value;
            } else {
                $setting = new GeneralSetting();
                $setting->key = $key;
                $setting->value = $value;
                $setting->updated_at = now();
                $setting->created_at = now();
            }
            $setting->save();
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('GenerateGeneralSetting')) {
    function GenerateGeneralSetting($domain)
    {
        if (Schema::hasColumn('general_settings', 'key')) {
            $path = Storage::path('settings.json');
            $settings = GeneralSetting::get(['key', 'value'])->pluck('value', 'key')->toArray();
            if (!Storage::has('settings.json')) {
                $strJsonFileContents = null;
            } else {
                $strJsonFileContents = file_get_contents($path);

            }
            $file_data = json_decode($strJsonFileContents, true);
            $setting_array[$domain] = $settings;
            if (!empty($file_data)) {
                $merged_array = array_merge($file_data, $setting_array);
            } else {
                $merged_array = $setting_array;
            }
            $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
            file_put_contents($path, $merged_array);

        }
    }
}

if (!function_exists('GenerateHomeContent')) {
    function GenerateHomeContent($domain)
    {

        if (Schema::hasColumn('home_contents', 'key')) {
            $path = Storage::path('homeContent.json');
            $settings = HomeContent::get(['key', 'value'])->pluck('value', 'key')->toArray();
            if (!Storage::has('homeContent.json')) {
                $strJsonFileContents = null;
            } else {
                $strJsonFileContents = file_get_contents($path);
            }
            $file_data = json_decode($strJsonFileContents, true);
            $setting_array[$domain] = $settings;
            if (!empty($file_data)) {
                $merged_array = array_merge($file_data, $setting_array);
            } else {
                $merged_array = $setting_array;
            }
            $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
            file_put_contents($path, $merged_array);
        }
    }
}


if (!function_exists('UpdateHomeContent')) {
    function UpdateHomeContent($key, $value)
    {

        $setting = HomeContent::where('key', $key)->first();
        if (!$setting) {
            $setting = new HomeContent();
            $setting->key = $key;
        }
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $setting->setTranslation('value', $k, $v);
            }
        } else {
            $setting->setTranslation('value', 'en', $value);
        }
        $setting->save();
    }
}

if (!function_exists('getIpBlockList')) {
    function getIpBlockList()
    {
        if (isModuleActive('LmsSaas')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }

        Cache::rememberForever('ipBlockList_' . $domain, function () {
            $data = [];
            $rowData = IpBlock::select('ip_address')->get();
            foreach ($rowData as $single) {
                $data[] = $single['ip_address'];
            }
            return $data;
        });
    }
}


if (!function_exists('HomeContents')) {
    function HomeContents($value = null)
    {
        $setting = app('getHomeContent')->where('key', $value)->first();
        return $setting ? $setting->value : '';
    }
}

if (!function_exists('getHomeContents')) {
    function getRawHomeContents($all, $value, $lang)
    {
        $result = '';
        try {
            $row = $all->where('key', $value)->first();
            $result = $row ? $row->getTranslation('value', $lang) : '';
        } catch (Exception $e) {

        }
        return $result;

    }
}

if (!function_exists('generateBlockPosition')) {
    function generateBlockPosition()
    {
        $homepage_block_positions = DB::table('homepage_block_positions')->orderBy('order', 'asc')->get();
        UpdateHomeContent('homepage_block_positions', json_encode($homepage_block_positions));
    }
}
if (!function_exists('isBundleValid')) {
    function isBundleExpire($course_id)
    {
        $enroll = null;
        if (Auth::check()) {
            $enroll = CourseEnrolled::where('user_id', Auth::user()->id)->where('course_id', $course_id)->first();
        }
        if ($enroll) {
            $validity = $enroll->bundle_course_validity;
            if (!empty($validity)) {
                if (!Carbon::parse($validity)->isFuture()) {
                    return true;
                }
            }

        }

        return false;
    }
}

if (!function_exists('isSubscriptionExpire')) {
    function isSubscriptionExpire()
    {
        if (Auth::user()->role_id == 3) {
            if (isModuleActive('Subscription') && Auth::check()) {
                $user = Auth::user();
                $validity = $user->subscription_validity_date;

                if (!empty($validity)) {
                    if (!Carbon::parse($validity)->isFuture()) {
                        return false;
                    }
                }
            }
        }
        return true;
    }
}


if (!function_exists('orgSubscriptionCourseValidity')) {
    function orgSubscriptionCourseValidity($courseId)
    {
        if (Auth::user()->role_id == 3) {
            if (isModuleActive('OrgSubscription') && Auth::check()) {
                $enroll = CourseEnrolled::with('orgSubscriptionPlan')->where('course_id', $courseId)->where('user_id', Auth::id())->first();

                if ($enroll && $enroll->subscription == 1) {
                    $time = $enroll->subscription_validity_time;
                    if (!empty($time)) {
                        $validity = $enroll->subscription_validity_date;
                    } else {
                        $validity = $enroll->subscription_validity_date . ' ' . $time;
                    }
                    //ALLOW ACCESS AFTER PLAN EXPIRED
                    if ($enroll->orgSubscriptionPlan->allow_access) {
                        return true;
                    }

                    if (!empty($validity)) {
                        if (!Carbon::parse($validity)->isFuture()) {
                            return false;
                        }
                    }

                }


            }
        }

        return true;
    }
}


if (!function_exists('orgSubscriptionCourseSequence')) {
    function orgSubscriptionCourseSequence($courseId)
    {
        if (isModuleActive('OrgSubscription') && Auth::check()) {

            $org_subscription_checkouts = OrgSubscriptionCheckout::where('user_id', Auth::id())->get();
            $access_courses = [];
            $plan_id = '';
            foreach ($org_subscription_checkouts as $cko) {
                if ($cko->plan->type == 1) {
                    if ($cko->plan->sequence == 1 && date('Y-m-d', strtotime($cko->plan->end_date)) > date('Y-m-d')) {
                        foreach ($cko->plan->assign as $course) {
                            if ($course->course_id == $courseId) {
                                $plan_id = $course->plan_id;
                            }
                        }
                    }

                } else {
                    $end_date = Carbon::parse($cko->start_date)->addDays($cko->days);
                    if ($cko->plan->sequence == 1 && $end_date->format('Y-m-d') > date('Y-m-d')) {
                        foreach ($cko->plan->assign as $course) {
                            //                            $access_courses[] = $course->course_id;
                            if ($course->course_id == $courseId) {
                                $plan_id = $course->plan_id;
                            }

                        }
                    }

                }
            }
            if ($plan_id) {
                $plan = OrgCourseSubscription::with('assign', 'assign.course')->find($plan_id);
                if ($plan) {
                    foreach ($plan->assign as $course) {
                        $access_courses[] = $course->course_id;
                        if ($course->course->type == 1 && $course->course->loginUserTotalPercentage != 100) {
                            break;
                        }
                    }
                }

            } else {
                return true;
            }

            if (in_array($courseId, $access_courses)) {
                return true;
            }
        }
        return false;
    }
}


if (!function_exists('updateEnrolledCourseLastView')) {
    function updateEnrolledCourseLastView($course_id)
    {
        if (Auth::check()) {
            $enroll = CourseEnrolled::where('course_id', $course_id)->where('course_id', $course_id)->where('user_id', Auth::id())->first();
            if ($enroll) {
                $enroll->last_view_at = now();
                $enroll->save();
            }
        }
    }
}


if (!function_exists('attendanceCheck')) {
    function attendanceCheck($user_id, $type, $date)
    {
        $attendance = Attendance::where('user_id', $user_id)->whereDate('date', Carbon::parse($date)->format('Y-m-d'))->first();
        if ($attendance != null) {
            if ($attendance->attendance == $type) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
}
if (!function_exists('attendanceInfo')) {
    function attendanceInfo($user_id, $date)
    {
        $attendance = Attendance::where('user_id', $user_id)->whereDate('date', Carbon::parse($date)->format('Y-m-d'))->first();

        return $attendance;
    }
}


if (!function_exists('attendanceNote')) {
    function attendanceNote($user_id)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', Carbon::today()->toDateString())->first();
        if ($todayAttendance != null) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('attendanceNoteDateWise')) {
    function attendanceNoteDateWise($user_id, $date)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', date('Y-m-d', strtotime($date)))->first();
        if ($todayAttendance != null) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('LateNote')) {
    function LateNote($user_id, $date)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', date('Y-m-d', strtotime($date)))->first();
        if ($todayAttendance) {
            return $todayAttendance->late_note;
        } else {
            return '';
        }
    }
}


if (!function_exists('Note')) {
    function Note($user_id)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', Carbon::today()->toDateString())->first();
        if ($todayAttendance != null && $todayAttendance->note != null) {
            return $todayAttendance->note;
        } else {
            return false;
        }
    }
}
if (!function_exists('NoteDateWise')) {
    function NoteDateWise($user_id, $date)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', date('Y-m-d', strtotime($date)))->first();
        if ($todayAttendance != null && $todayAttendance->note != null) {
            return $todayAttendance->note;
        } else {
            return false;
        }
    }
}

if (!function_exists('transformExcelDate')) {
    function transformExcelDate($value, $format = 'd/m/Y')
    {
        try {
            if (is_string($value)) {
                $date = Carbon::createFromFormat($format, $value);
                return $date->translatedFormat($format);
            } else {
                $date = Carbon::instance(Date::excelToDateTimeObject($value));
                return $date->translatedFormat($format);
            }

        } catch (ErrorException $e) {
            $date = Carbon::createFromFormat($format, $value);
            return $date->translatedFormat($format);
        }
    }
}


if (!function_exists('assignStaffToUser')) {
    function assignStaffToUser($user)
    {
        $check = DB::table('staffs')->where('user_id', $user->id)->first();
        if ($check) {
            DB::table('staffs')->insert([
                'user_id' => $user->id
            ]);
        }
    }
}


if (!function_exists('generateUniqueId')) {
    function generateUniqueId($random_id_length = 10)
    {
        $rnd_id = Hash::make((uniqid(rand(), 1)));
        $rnd_id = strip_tags(stripslashes($rnd_id));
        $rnd_id = str_replace(".", "", $rnd_id);
        $rnd_id = strrev(str_replace("/", "", $rnd_id));
        return substr($rnd_id, 0, $random_id_length);
    }
}

if (!function_exists('updateModuleParentRoute')) {
    function updateModuleParentRoute()
    {
        Cache::rememberForever('updateModuleParentRoute', function () {
            if (Schema::hasColumn('permissions', 'parent_route')) {
                $permissions = DB::table('permissions')->whereNotNull('parent_id')->get(['parent_id', 'route']);
                foreach ($permissions as $permission) {
                    $parent_route = null;
                    if (!empty($permission->parent_id)) {
                        $parent = DB::table('permissions')->where('id', $permission->parent_id)->first();
                        if ($parent) {
                            $parent_route = $parent->route;
                        }
                    }
                    DB::table('permissions')
                        ->where('route', $permission->route)->update([
                            'parent_route' => $parent_route,
                            'module_id' => null,
                            'parent_id' => null,
                        ]);
                }
                Cache::forget('PermissionList_' . SaasDomain());
                Cache::forget('RoleList_' . SaasDomain());
                Cache::forget('PolicyPermissionList_' . SaasDomain());
                Cache::forget('PolicyRoleList_' . SaasDomain());

            }
            return true;
        });


    }
}
