<?php

use App\Jobs\PushNotificationJob;
use App\Notifications\GeneralNotification;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;
use Modules\CourseSetting\Entities\Course;
use Modules\FrontendManage\Entities\CourseSetting;
use Modules\NotificationSetup\Entities\RoleEmailTemplate;
use Modules\NotificationSetup\Entities\UserNotificationSetup;
use Modules\Quiz\Entities\OnlineExamQuestionAssign;
use Modules\Setting\Model\GeneralSetting;
use Modules\SystemSetting\Entities\EmailTemplate;
use Modules\SystemSetting\Entities\Message;
use Nwidart\Modules\Facades\Module;


if (!function_exists('socialIconList')) {
    function socialIconList()
    {
        $list = [
            'fa-facebook',
            'fa-twitter',
            'fa-linkedin',
            'fa-instagram',
            'fa-dribbble',
            'fa-google-plus',
            'fa-youtube',
            'fa-vimeo',
            'fa-reddit',
//            'fa-tiktok',
            'fa-snapchat',
            'fa-pinterest',
            'fa-whatsapp',
            'fa-telegram',
            'fa-tumblr',
            'fa-medium',
            'fa-slack',
            'fa-weibo',
            'fa-quora',
            'fa-flickr',
            'fa-behance',
            'fa-github',
            'fa-stack-overflow',
            'fa-soundcloud',
            'fa-spotify'
        ];
        $str = '';
        foreach ($list as $class) {
            $str .= '<option value="fab ' . $class . '"><i class="fa ' . $class . '"></i> ' . $class . ' </option>';
        }
        return $str;
    }
}


if (!function_exists('getProfileImage')) {
    function getProfileImage($path, $name = 'User')
    {
        if (File::exists($path)) {
            return (string)asset($path);
        } else {
            return (string)  'https://ui-avatars.com/api/?background=random&name=' . $name;
        }
    }
}

if (!function_exists('getCourseImage')) {
    function getCourseImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset(currentTheme() == 'wetech' ? 'public/frontend/wetech/img/default/course.png' : 'public/assets/course/no_image.png');
        }
    }
}

if (!function_exists('getQuizImage')) {
    function getQuizImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset(currentTheme() == 'wetech' ? 'public/frontend/wetech/img/default/course.png' : 'public/assets/course/no_image.png');
        }
    }
}
if (!function_exists('getVirtualClassImage')) {
    function getVirtualClassImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset(currentTheme() == 'wetech' ? 'public/frontend/wetech/img/default/virtual_class.png' : 'public/assets/course/no_image.png');
        }
    }
}

if (!function_exists('getForumImage')) {
    function getForumImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset(currentTheme() == 'wetech' ? 'public/frontend/wetech/img/default/forum.png' : 'public/assets/course/no_image.png');
        }

    }
}
if (!function_exists('getBlogImage')) {
    function getBlogImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset(currentTheme() == 'wetech' ? 'public/frontend/wetech/img/default/news.png' : 'public/assets/course/no_image.png');

        }
    }
}

if (!function_exists('getLogoImage')) {
    function getLogoImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset('public/uploads/settings/logo.png');
        }
    }
}

if (!function_exists('showImage')) {
    function showImage($path = null, $type = 'dummy')
    {
        if ($path && File::exists($path)) {
            return asset($path);
        } else {
            if ($type == 'cover_photo') {
                return asset('public/assets/profile/cover.jpg');
            }
            return asset('public/assets/profile/dummy.png');
        }
    }
}

if (!function_exists('showPreview')) {
    function showPreview($path = null, $type = 'image')
    {
        if ($path && File::exists($path) && $type == 'image') {
            return asset($path);
        } else {
            if ($type == 'image') {
                return asset('public/preview/image.png');
            } elseif ($type == 'video') {
                return asset('public/preview/video.png');
            } elseif ($type == 'pdf') {
                return asset('public/preview/pdf.png');
            } elseif ($type == 'zip') {
                return asset('public/preview/zip.png');
            } elseif ($type == 'doc') {
                return asset('public/preview/doc.png');
            } else {
                return asset('public/preview/invalid.png');
            }
        }
    }
}


if (!function_exists('getBlogImage')) {
    function getBlogImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset('public/demo/blog/no-image.jpg');
        }
    }
}
if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}

if (!function_exists('isInstructor')) {
    function isInstructor()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 2) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


if (!function_exists('isStudent')) {
    function isStudent()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 3) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('isFree')) {
    function isFree($course_id)
    {
        $course = Course::find($course_id);
        if ($course) {
            if ($course->price == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


if (!function_exists('totalUnreadMessages')) {
    function totalUnreadMessages()
    {
        return Message::where('seen', '=', 0)->where('reciever_id', '=', Auth::id())->count();
    }
}


if (!function_exists('getLanguageList')) {
    function getLanguageList()
    {
        if (isModuleActive('LmsSaas')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }
        return Cache::rememberForever('LanguageList_' . $domain, function () {
            return DB::table('languages')
                ->where('status', 1)
                ->select('id', 'code', 'name', 'native','flag')
                ->where('lms_id', SaasInstitute()->id)
                ->get();
        });
    }
}

if (!function_exists('getCurrencyList')) {
    function getCurrencyList()
    {
        if (isModuleActive('LmsSaas')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }
        return Cache::rememberForever('currencyList_' . $domain, function () {
            return DB::table('currencies')
                ->where('status', 1)
                ->select('id', 'code', 'name', 'symbol', 'conversion_rate')
                ->where('lms_id', SaasInstitute()->id)
                ->get();
        });
    }
}


if (!function_exists('putEnvConfigration')) {
    function putEnvConfigration($envKey, $envValue)
    {
        $envValue = str_replace('\\', '\\' . '\\', $envValue);
        $value = '"' . $envValue . '"';
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $str .= "\n";
        $keyPosition = strpos($str, "{$envKey}=");


        if (is_bool($keyPosition)) {

            $str .= $envKey . '="' . $envValue . '"';

        } else {
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
            $str = str_replace($oldLine, "{$envKey}={$value}", $str);

            $str = substr($str, 0, -1);
        }

        if (!file_put_contents($envFile, $str)) {
            return false;
        } else {
            return true;
        }

    }
}


if (!function_exists('courseDetailsUrl')) {
    function courseDetailsUrl($id, $type, $slug)
    {
        if ($type == 1) {
            $details = 'courses-details';
        } elseif ($type == 2) {
            $details = 'quiz-details';
        } elseif ($type == 3) {
            $details = 'class-details';
        } elseif ($type == 5) {
            $details = 'product-details';
        } else {
            $details = 'courses-details';
        }
        return url($details . '/' . $slug);
    }
}
if (!function_exists('UserEmailNotificationSetup')) {
    function UserEmailNotificationSetup($act, $user)
    {

        $role_email_template = RoleEmailTemplate::where('role_id', $user->role_id)->where('template_act', $act)->where('status', 1)->first();
        if ($role_email_template) {
            $user_notification_setup = UserNotificationSetup::where('user_id', $user->id)->first();
            if ($user_notification_setup) {
                $email_ids = explode(',', $user_notification_setup->email_ids);

                if (in_array($act, $email_ids)) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return true;
            }
        }
    }
}
if (!function_exists('UserBrowserNotificationSetup')) {
    function UserBrowserNotificationSetup($act, $user)
    {

        $role_email_template = RoleEmailTemplate::where('role_id', $user->role_id)->where('template_act', $act)->where('status', 1)->first();

        if ($role_email_template) {
            $user_notification_setup = UserNotificationSetup::where('user_id', $user->id)->first();

            if ($user_notification_setup) {
                $browser_ids = explode(',', $user_notification_setup->browser_ids);

                if (in_array($act, $browser_ids)) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return true;
            }
        }
    }
}

if (!function_exists('UserMobileNotificationSetup')) {
    function UserMobileNotificationSetup($act, $user)
    {

        $role_email_template = RoleEmailTemplate::where('role_id', $user->role_id)->where('template_act', $act)->where('status', 1)->first();

        if ($role_email_template) {
            $user_notification_setup = UserNotificationSetup::where('user_id', $user->id)->first();

            if ($user_notification_setup) {
                $mobile_ids = explode(',', $user_notification_setup->mobile_ids);

                if (in_array($act, $mobile_ids)) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return true;
            }
        }
    }
}
if (!function_exists('send_browser_notification')) {

    function send_browser_notification($user, $type, $shortcodes = [], $actionText = '', $actionURL = '', $notificationType = null, $id = null)
    {
        $status = EmailTemplate::where('act', $type)->first()->status;
        if ($status == 1) {
            $email_template = EmailTemplate::where('act', $type)->where('status', 1)->first();

            if ($email_template->act == 'POSTED_NOTIFICATION') {
                $email_template->email_body = $shortcodes['message'] ?? $email_template->email_body;
                $email_template->subj = $shortcodes['title'] ?? $email_template->subj;
                $email_template->browser_message = $shortcodes['message'] ?? $email_template->email_body;
            }


            if ($email_template->browser_message == null) {
                $message = $email_template->subj;
            } else {
                $message = $email_template->browser_message;
            }


            foreach ($shortcodes as $code => $value) {
                $message = shortcode_replacer('{{' . $code . '}}', $value, $message);
            }
            // $message = shortcode_replacer('{{footer}}', $general->email_template, $message);


            $details = [
                'title' => $email_template->subj,
                'body' => $message,
                'actionText' => $actionText,
                'actionURL' => $actionURL,
                'notification_type' => $notificationType,
                'id' => $id
            ];
            Notification::send($user, new GeneralNotification($details));
        }

    }
}

if (!function_exists('send_mobile_notification')) {

    function send_mobile_notification($user, $type, $shortcodes = [], $title = "", $id = 0, $notify_type = '')
    {
        $status = EmailTemplate::where('act', $type)->first()->status;
        if ($status == 1) {
            $email_template = EmailTemplate::where('act', $type)->where('status', 1)->first();

            if ($email_template->act == 'POSTED_NOTIFICATION') {
                $email_template->email_body = $shortcodes['message'] ?? $email_template->email_body;
                $email_template->subj = $shortcodes['title'] ?? $email_template->subj;
                $email_template->browser_message = $shortcodes['message'] ?? $email_template->email_body;
            }


            if ($email_template->browser_message == null) {
                $message = $email_template->subj;
            } else {
                $message = $email_template->browser_message;
            }


            foreach ($shortcodes as $code => $value) {
                $message = shortcode_replacer('{{' . $code . '}}', $value, $message);
            }

            if (empty($title)) {
                $title = $email_template->subj;
            }

            PushNotificationJob::dispatch($title, $message, $user->device_token, $id, $notify_type);
        }

    }
}


if (!function_exists('htmlPart')) {
    function htmlPart($subject, $body)
    {
        $html = '
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <style>

         .social_links {
            background: #F4F4F8;
            padding: 15px;
            margin: 30px 0 30px 0;
        }

        .social_links a {
            display: inline-block;
            font-size: 15px;
            color: #252B33;
            padding: 5px;
        }


    </style>

    <div class="">
    <div style="color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;"><h1 style="margin: 20px 0px 10px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;">
    ' . $subject . '

    </h1></div><div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
    <p style="color: rgb(85, 85, 85);"><br></p>
    <p style="color: rgb(85, 85, 85);">' . $body . '</p></div>
    </div>

    <div class="email_invite_wrapper" style="text-align: center">


        <div class="social_links">
            <a href="https://twitter.com/codetheme"> <i class="fab fa-facebook-f"></i> </a>
            <a href="https://codecanyon.net/user/codethemes/portfolio"><i class="fas fa-code"></i> </a>
            <a href="https://twitter.com/codetheme" target="_blank"> <i class="fab fa-twitter"></i> </a>
            <a href="https://dribbble.com/codethemes"> <i class="fab fa-dribbble"></i></a>
        </div>
    </div>

    ';
        return $html;
    }
}
if (!function_exists('translatedNumber')) {
    function translatedNumber($number = null)
    {
        $number = (string)$number;
        $translatedNumber = '';
        for ($i = 0; $i < strlen($number); $i++) {
            $digit = $number[$i];
            if (is_numeric($digit)) {
                $translatedNumber .= trans('number.' . $digit);
            } else {
                $translatedNumber .= $digit;
            }
        }
        return $translatedNumber;
    }
}

if (!function_exists('getPriceFormat')) {
    function getPriceFormat($price, $text = true)
    {
        if (!showEcommerce()) {
            return '';
        }
        $price =(float)$price;
        $type = Settings('currency_show');
        if (!empty($price) || $price != 0) {

            if (Settings('hide_multicurrency') == 1) {
                $price = number_format((float)str_replace(',', '', currencyConvert($price)), Settings('currency_decimal'));

                if (auth()->check()) {
                    $currency_id = auth()->user()->currency_id;
                } elseif (session('currency_id')) {
                    $currency_id = session('currency_id');
                } else {
                    $currency_id = Settings('currency_id');
                }
                $convert_currency = getCurrencyList()->where('id', $currency_id)->first();
                $symbol = $convert_currency->symbol ?? '$';
            } else {
                $symbol = Settings('currency_symbol');
                $price = number_format((float)str_replace(',', '', $price), 2);
            }

            $price = translatedNumber($price);


            if ($type == 1) {
                $result = $symbol . $price;

            } elseif ($type == 2) {
                $result = $symbol . ' ' . $price;

            } elseif ($type == 3) {
                $result = $price . $symbol;

            } elseif ($type == 4) {
                $result = $price . ' ' . $symbol;

            } else {
                $result = $price;
            }
        } else {
            if ($text) {
                $result = trans('common.Free');
            } else {
                $result = trans('number.0');
            }
        }

        if (Settings('currency_seperator') == 2) {
            $explode = explode('.', $result);
            return implode(',', $explode);
        } else {
            return $result;
        }

    }
}


if (!function_exists('totalQuizQus')) {
    function totalQuizQus($quiz_id)
    {
        $total = OnlineExamQuestionAssign::where('online_exam_id', $quiz_id)->count();
        return $total;
    }
}

if (!function_exists('totalQuizMarks')) {
    function totalQuizMarks($quiz_id)
    {
        $totalMark = 0;
        $total = OnlineExamQuestionAssign::where('online_exam_id', $quiz_id)->with('questionBank')->get();

        foreach ($total as $question) {
            $totalMark = $totalMark + $question->questionBank->marks;
        }
        return $totalMark;
    }
}

if (!function_exists('theme')) {
    function theme($fileName)
    {
        if (!empty(Settings('frontend_active_theme'))) {
            $theme = Settings('frontend_active_theme');
        } else {
            $theme = 'infixlmstheme';
        }
        $path = 'frontend.' . $theme . '.' . $fileName;
        if (View::exists($path)) {
            return $path;
        } else {
            return 'frontend.infixlmstheme' . '.' . $fileName;
        }

    }
}


if (!function_exists('themeAsset')) {
    function themeAsset($fileName)
    {
        try {
            if (!empty(Settings('frontend_active_theme'))) {
                $theme = Settings('frontend_active_theme');
            } else {
                $theme = 'infixlmstheme';
            }
            $path = 'public/frontend/' . $theme . '/' . $fileName;
            return asset($path);
        } catch (Exception $e) {
            return '';
        }

    }
}

if (!function_exists('backendComponent')) {
    function backendComponent($fileName)
    {
        return 'backend.components.' . $fileName;

    }
}

//Start Compact Helper

if (!function_exists('topbarSetting')) {
    function topbarSetting()
    {
        return app()->topbarSetting;
    }
}
if (!function_exists('courseSetting')) {
    function courseSetting()
    {
        return CourseSetting::getData();
    }
}
if (!function_exists('itemsGridSize')) {
    function itemsGridSize()
    {
        if (Settings('frontend_active_theme') == 'edume') {
            $view_grid = 5;
            return $view_grid * 2;
        }
        if (courseSetting()->size_of_grid == 3) {
            $view_grid = 4;
        } else {
            $view_grid = 3;
        }

        return $view_grid * 3;
    }
}
//End Compact Helper

if (!function_exists('Settings')) {
    function Settings($value = null)
    {
        try {
            if (isModuleActive('LmsSaas')) {
                $domain = SaasDomain();
            } else {
                $domain = 'main';
            }
            if ($value == "frontend_active_theme") {
                return Cache::rememberForever('frontend_active_theme_' . $domain, function () {
                    $setting = GeneralSetting::where('key', 'frontend_active_theme')->first();
                    return $setting->value;
                });
            } elseif ($value == "active_time_zone") {
                if (!isValidTimeZone(app('getSetting')[$value])) {
                    return 'Asia/Dhaka';
                }
            } elseif ($value == "start_site") {
                if (!isset(app('getSetting')[$value])) {
                    if (isModuleActive('Org')) {
                        return 'loginpage';
                    } else {
                        return 'homepage';
                    }
                }
            }
            return app('getSetting')[$value];
        } catch (Exception $exception) {
            return false;
        }
    }
}
if (!function_exists('isValidTimeZone')) {
    function isValidTimeZone($timezone = null)
    {
        try {
            Carbon::now($timezone);
        } catch (Exception $exception) {
            return false;
        }
        return true;
    }
}

if (!function_exists('isModuleActive')) {
    function isModuleActive($module)
    {

        try {
            $haveModule = app('ModuleList')->where('name', $module)->first();
            if (empty($haveModule)) {
                return false;
            }
            $modulestatus = $haveModule->status;


            $is_module_available = 'Modules/' . $module . '/Providers/' . $module . 'ServiceProvider.php';

            if (file_exists($is_module_available)) {


                $moduleCheck = Module::find($module)->isEnabled();


                if (!$moduleCheck) {

                    return false;
                }


                if ($modulestatus == 1) {
                    $is_verify = app('ModuleManagerList')->where('name', $module)->first();

                    if (!empty($is_verify->purchase_code)) {
                        return true;
                    }
                }
            }


            //            }
            return false;
        } catch (Throwable $th) {


            return false;
        }

    }
}


if (!function_exists('getPercentageRating')) {
    function getPercentageRating($review_data, $value)
    {
        if ($review_data['total'] > 0) {
            $data['total'] = $review_data['total'] ?? 0;
            switch ($value) {
                case 1 :
                    $per = $review_data['1'];
                    break;
                case 2 :
                    $per = $review_data['2'];
                    break;
                case 3 :
                    $per = $review_data['3'];
                    break;
                case 4 :
                    $per = $review_data['4'];
                    break;
                case 5 :
                    $per = $review_data['5'];
                    break;
                default:
                    $per = 0;
                    break;
            }

            if ($per > 0) {
                $data['per'] = ($per / $data['total']) * 100;
            } else {
                $data['per'] = 0;
            }
        } else {
            $data['per'] = 0;
        }
        $data['per'] = number_format($data['per'], 2);
        return $data['per'] ?? 0;
    }
}

if (!function_exists('userRating')) {
    function userRating($user_id)
    {
        $totalRatings['rating'] = 0;
        $ReviewList = DB::table('courses')
            ->join('course_reveiws', 'course_reveiws.course_id', 'courses.id')
            ->select('courses.id', 'course_reveiws.id as review_id', 'course_reveiws.star as review_star')
            ->where('courses.user_id', $user_id)
            ->get();
        $totalRatings['total'] = count($ReviewList);

        foreach ($ReviewList as $Review) {
            $totalRatings['rating'] += $Review->review_star;
        }

        if ($totalRatings['total'] != 0) {
            $avg = ($totalRatings['rating'] / $totalRatings['total']);
        } else {
            $avg = 0;
        }

        if ($avg != 0) {
            if ($avg - floor($avg) > 0) {
                $rate = number_format($avg, 1);
            } else {
                $rate = number_format($avg, 0);
            }
            $totalRatings['rating'] = $rate;
        }
        return $totalRatings;
    }
}


if (!function_exists('getPriceWithConversion')) {
    function getPriceWithConversion($price)
    {
        $price = str_replace(',', '', $price);
        $price = $price * 1;
        return $price;
    }
}

if (!function_exists('convertCurrency')) {
    function convertCurrency($from_currency, $to_currency, $amount)
    {
        $from = urlencode($from_currency);
        $to = urlencode($to_currency);

        $client = new Client();
        $cacheTime = (Settings('currency_api_cache_time') ? Settings('currency_api_cache_time') : 1440) * 60;

        try {
            if (Settings('currency_conversion') == 'Fixer') {

                $rate = Cache::remember('CurrencyRateFixer' . $from . $to . SaasDomain(), $cacheTime, function () use ($from, $to, $amount, $client) {
                    $apikey = Settings('fixer_key') ?? '';
                    $url = "http://data.fixer.io/api/latest?access_key=" . $apikey;
                    $response = $client->request('GET', $url);
                    $responseBody = $response->getBody()->getContents();
                    $info = json_decode($responseBody);

                    $cur = (array)@$info->rates;
                    $from_value = null;
                    $to_value = null;
                    foreach ($cur as $key => $value) {
                        if ($key == $from) {
                            $from_value = $value;
                        }
                        if ($key == $to) {
                            $to_value = $value;
                        }
                    }
                    if ($to_value > 0) {
                        $rate = ($to_value / $from_value);
                    } else {
                        $rate = 1;
                    }
                    return $rate;
                });

                return $amount * $rate;

            } elseif (Settings('currency_conversion') == 'Exchangerate') {
                $access_key = Settings('exchangerate_access_key');
                if ($from == $to) {
                    return $amount;
                }
                $url = 'http://api.exchangerate.host/live?source=' . $from . '&currencies=' . $to . '&access_key=' . $access_key;
                $rate = Cache::remember('CurrencyRateExchangerate' . $from . $to . SaasDomain(), $cacheTime, function () use ($from, $to, $amount, $client, $access_key, $url) {
                    $response = $client->request('GET', $url);
                    $responseBody = $response->getBody()->getContents();
                    $info = json_decode($responseBody);
                    if (!$info->success) {
                        Log::error($info->error->info);
                    }
                    $result = $info->quotes;
                    $key = strtoupper($from . $to);
                    return $result->$key;
                });
                if ($rate > 0) {
                    $total = $amount * $rate;
                } else {
                    $total = $amount;
                }
                return $total;

            }
        } catch (Exception $e) {
        }
        return $amount;

    }
}
