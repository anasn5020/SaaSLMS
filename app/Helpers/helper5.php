<?php


use App\Jobs\SendNotification;
use App\Notifications\GeneralNotification;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\CourseSetting\Entities\CourseBadge;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Installment\Entities\InstallmentPurchaseRequest;
use Modules\NotificationSetup\Entities\RoleEmailTemplate;
use Modules\NotificationSetup\Entities\UserNotificationSetup;
use Modules\Org\Entities\OrgLeaderboardAssign;
use Modules\Org\Entities\OrgLeaderboardUserPoint;
use Modules\Payment\Entities\Cart;
use Modules\RegistrationBonus\Entities\RegistrationBonusSetting;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\Role;
use Modules\Setting\Entities\Badge;
use Modules\Setting\Entities\SmsGateway;
use Modules\Setting\Entities\UserBadge;
use Modules\Store\Entities\PickupLocation;
use Modules\Store\Entities\ProductSku;
use Modules\Store\Entities\ShippingConfiguration;
use Modules\SystemSetting\Entities\EmailTemplate;

if (!function_exists('availableRolesForBadges')) {
    function availableRolesForBadges($name)
    {
        try {
            $roles = Cache::rememberForever('AvailableRolesForBadgesRoles' . SaasDomain(), function () {
                return Role::where('id', '!=', 1)->get(['id', 'name']);
            });

            if ($name == 'activity' || $name == 'registration') {
                $roles = $roles->pluck('name')->toArray();
                $availableRoles = implode(', ', $roles);
            } elseif ($name == 'courses' || $name == 'rating' || $name == 'sales' || $name == 'blogs') {
                $roles = $roles->where('id', '!=', 3)->pluck('name')->toArray();
                $availableRoles = implode(', ', $roles);
            } elseif ($name == 'learning' || $name == 'test' || $name == 'assignment' || $name == 'performance' || $name == 'survey' || $name == 'comment' || $name == 'certification') {
                $roles = $roles->where('id', 3)->pluck('name')->toArray();
                $availableRoles = implode(', ', $roles);
            }
            return $availableRoles;

        } catch (Exception $exception) {
            return false;
        }
    }
}


if (!function_exists('checkGamificationReg')) {
    function checkGamificationReg()
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return false;
        }
        $reg_badges = Badge::select('id', 'title', 'image', 'point')->where('type', 'registration')->where(function ($query) {
            $totalDay = 0;
            if (Auth::check()) {
                $created = new Carbon(Auth::user()->created_at);
                $now = Carbon::now();
                $totalDay = $now->diffInDays($created) - 1;
            }
            $query->where('point', '<=', $totalDay);
        })->orderBy('point', 'asc')->get();


        foreach ($reg_badges as $badge) {
            if (Settings('gamification_status') && Settings('gamification_badges_status') && Settings('gamification_badges_registration_status')) {

                $userBadge = UserBadge::updateOrCreate([
                    'user_id' => Auth::id(),
                    'badge_id' => $badge->id,
                ]);
                if ($userBadge->wasRecentlyCreated) {
                    $badge_notification_title = trans('common.A new badge has been unlocked');
                    Toastr::success($badge_notification_title, trans('common.Congratulations'));
                    $details = [
                        'title' => $badge_notification_title,
                        'body' => $badge_notification_title,
                        'actionText' => '',
                        'actionURL' => '#',
                    ];
                    Notification::send(Auth::user(), new GeneralNotification($details));
                }
            }
        }


    }
}

if (!function_exists('pluralize')) {
    function pluralize($quantity, $singular, $plural = null)
    {
        if ($quantity == 1 || !strlen($singular)) return $singular;
        if ($plural !== null) return $plural;

        $last_letter = strtolower($singular[strlen($singular) - 1]);
        switch ($last_letter) {
            case 'y':
                return substr($singular, 0, -1) . 'ies';
            case 's':
                return $singular . 'es';
            default:
                return $singular . 's';
        }
    }
}
if (!function_exists('maxUploadFileSize')) {
    function maxUploadFileSize()
    {
        $max_upload = min((int)ini_get('post_max_size'), (int)ini_get('upload_max_filesize'));
        return $max_upload * 1024;
    }
}

if (!function_exists('userLocal')) {
    function userLocal()
    {
        try {
            $user = auth()->user();
            if (isset($user->language_code)) {
                $user_lang = $user->language_code;
            } else {
                $user_lang = App::getLocale();
            }
            return $user_lang;
        } catch (Throwable $th) {
            return 'en';
        }
    }
}
if (!function_exists('_translation')) {
    function _translation($key)
    {
        $trans = trans($key);
        try {
            $exp = explode('.', $trans);
            if (count($exp) == 2) {
                $txt = Str::replace('_', ' ', ucfirst($exp[1]));
                $txt = ucfirst($txt);
            } else {
                $txt = $trans;
                $txt = Str::replace('_', ' ', ucfirst($txt));
                $txt = ucfirst($txt);
            }
            return $txt;
        } catch (Throwable $th) {
            return $key;
        }
    }
}


if (!function_exists('_trans')) {
    function _trans($value)
    {

        try {
            if (env('APP_ENV') == 'production') {
                return trans($value);
            } else {

                $local = userLocal() ? userLocal() : app()->getLocale();

                $langPath = resource_path('lang/' . $local . '/');

                if (!file_exists($langPath)) {
                    mkdir($langPath, 0777, true);
                }

                if (str_contains($value, '.')) {
                    $new_trns = explode('.', $value);
                    $file_name = $new_trns[0];
                    $trans_key = $new_trns[1];


                    $file_path = $langPath . '' . $file_name . '.php';
                    if (file_exists($file_path)) {
                        $file_content = include($file_path);

                        if (array_key_exists($trans_key, $file_content)) {
                            return _translation($value);
                        } else {
                            $file_content[$trans_key] = $trans_key;
                            $str = <<<EOT
                                                <?php
                                                    return [
                                                EOT;
                            foreach ($file_content as $key => $val) {
                                if (gettype($val) == 'string') {

                                    $line = <<<EOT
                                                                        "{$key}" => "{$val}",\n
                                                                    EOT;
                                }
                                if (gettype($val) == 'array') {
                                    $line = <<<EOT
                                                                                "{$key}" => [\n
                                                                            EOT;
                                    $str .= $line;
                                    foreach ($val as $lang_key => $lang_val) {

                                        $line = <<<EOT
                                                                                "{$lang_key}" => "{$lang_val}",\n
                                                                            EOT;

                                        $str .= $line;
                                    }

                                    $line = <<<EOT
                                                                            ],\n
                                                                        EOT;
                                }

                                $str .= $line;
                            }
                            $end = <<<EOT
                                                        ]
                                                ?>
                                                EOT;
                            $str .= $end;

                            file_put_contents($file_path, $str, $flags = 0, $context = null);
                        }

                    } else {

                        fopen($file_path, 'w');
                        $file_content = [];
                        $file_content[$trans_key] = $trans_key;
                        $str = <<<EOT
                                                <?php
                                                    return [
                                                EOT;
                        foreach ($file_content as $key => $val) {
                            if (gettype($val) == 'string') {

                                $line = <<<EOT
                                                                        "{$key}" => "{$val}",\n
                                                                    EOT;
                            }
                            if (gettype($val) == 'array') {
                                $line = <<<EOT
                                                                                "{$key}" => [\n
                                                                            EOT;
                                $str .= $line;
                                foreach ($val as $lang_key => $lang_val) {

                                    $line = <<<EOT
                                                                                "{$lang_key}" => "{$lang_val}",\n
                                                                            EOT;

                                    $str .= $line;
                                }

                                $line = <<<EOT
                                                                            ],\n
                                                                        EOT;
                            }

                            $str .= $line;
                        }
                        $end = <<<EOT
                                                        ]
                                                ?>
                                                EOT;
                        $str .= $end;

                        file_put_contents($file_path, $str, $flags = 0, $context = null);


                    }

                    return _translation($value);
                } else {

                    $trans_key = $value;
                    $file_path = resource_path('lang/' . $local . '/' . $local . '.php');

                    fopen($file_path, 'w');
                    $file_content = [];
                    $file_content[$trans_key] = $trans_key;
                    $str = <<<EOT
                                                <?php
                                                    return [
                                                EOT;
                    foreach ($file_content as $key => $val) {
                        if (gettype($val) == 'string') {

                            $line = <<<EOT
                                                                        "{$key}" => "{$val}",\n
                                                                    EOT;
                        }
                        if (gettype($val) == 'array') {
                            $line = <<<EOT
                                                                                "{$key}" => [\n
                                                                            EOT;
                            $str .= $line;
                            foreach ($val as $lang_key => $lang_val) {

                                $line = <<<EOT
                                                                                "{$lang_key}" => "{$lang_val}",\n
                                                                            EOT;

                                $str .= $line;
                            }

                            $line = <<<EOT
                                                                            ],\n
                                                                        EOT;
                        }

                        $str .= $line;
                    }
                    $end = <<<EOT
                                                        ]
                                                ?>
                                                EOT;
                    $str .= $end;

                    file_put_contents($file_path, $str, $flags = 0, $context = null);
                    return _translation($value);

                }
                return _translation($value);
            }

        } catch (Exception $exception) {
            return $value;
        }
    }
}

if (!function_exists('isoToReglar')) {
    function isoToReglar($time)
    {
        try {
            $time = preg_replace('/[a-zA-Z]/', '', $time);
            $seconds = floatval($time);
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            $seconds = $seconds % 60;
            $milliseconds = round(($seconds - floor($seconds)) * 1000);

            $duration_string = '';
            if ($hours > 0) {
                $duration_string .= $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ';
            }
            if ($minutes > 0) {
                $duration_string .= $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ';
            }
            if ($seconds > 0) {
                $duration_string .= $seconds . ' second' . ($seconds > 1 ? 's' : '') . ' ';
            }
            if ($milliseconds > 0) {
                $duration_string .= $milliseconds . ' millisecond' . ($milliseconds > 1 ? 's' : '') . ' ';
            }
            return $duration_string;
        } catch (Throwable $th) {
            return $time;
        }
    }
}

if (!function_exists('showTime')) {
    function showTime($value = null)
    {
        try {
            return date('h:i a', strtotime($value));
        } catch (Exception $exception) {
            return $value;
        }
    }
}
if (!function_exists('formatDateRangeData')) {
    function formatDateRangeData($value, $format = 'array')
    {
        $data = explode("-", preg_replace('/\s+/', ' ', $value));
        if ($format == 'start_date') {
            return Carbon::parse($data[0])->format('Y-m-d');
        } elseif ($format == 'end_date') {
            return Carbon::parse($data[1])->format('Y-m-d');
        } else {
            return [Carbon::parse($data[0])->format('Y-m-d'), Carbon::parse($data[1])->format('Y-m-d')];
        }
    }
}
if (!function_exists('registrationBonusSetting')) {
    function registrationBonusSetting()
    {
        if (isModuleActive('RegistrationBonus')) {
            $bonus = RegistrationBonusSetting::first();
            if ($bonus) {
                $bonus_data = new stdClass();
                $bonus_data->is_active = !empty($bonus->is_active) ? $bonus->is_active : 0;
                $bonus_data->instant_bonus = !empty($bonus->instant_bonus) ? $bonus->instant_bonus : 0;
                $bonus_data->bonus_on_referrer = !empty($bonus->bonus_on_referrer) ? $bonus->bonus_on_referrer : 0;
                $bonus_data->bonus_on_purchase = !empty($bonus->bonus_on_purchase) ? $bonus->bonus_on_purchase : 0;
                $bonus_data->referrer_users = !empty($bonus->referrer_users) ? $bonus->referrer_users : 0;
                $bonus_data->referrer_amount = !empty($bonus->referrer_amount) ? $bonus->referrer_amount : 0;
                $bonus_data->bonus_amount = !empty($bonus->bonus_amount) ? $bonus->bonus_amount : 0;
                return $bonus_data;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}

if (!function_exists('orgLeaderboardPointCheck')) {
    function orgLeaderboardPointCheck($type, $point = 0, $id = 0, $interaction_type = '')
    {
        if (isModuleActive('Org')) {
            $course_id = 0;
            $quiz_id = 0;
            $test_id = 0;
            $survey_id = 0;
            if ($type == 'Course') {
                $course_id = (int)$id;
            } elseif ($type == 'Quiz') {
                $quiz_id = (int)$id;
            } elseif ($type == 'Test') {
                $test_id = (int)$id;
            } elseif ($type == 'Survey') {
                $survey_id = (int)$id;
            } elseif ($interaction_type == 'question' || $interaction_type == 'answer') {
                $course_id = (int)$id;
            } elseif ($interaction_type == 'thread' || $interaction_type == 'answer_thread') {
                $course_id = (int)$id;
            }
            $leaderboards = [];

            if ($course_id > 0) {
                $leaderboards = OrgLeaderboardAssign::where('assign_id', $course_id)->where('assign_type', 'course')->get();
            } elseif ($quiz_id > 0) {
                $leaderboards = OrgLeaderboardAssign::where('assign_id', $quiz_id)->where('assign_type', 'quiz')->get();
            } elseif ($test_id > 0) {
                $leaderboards = OrgLeaderboardAssign::where('assign_id', $test_id)->where('assign_type', 'test')->get();
            } elseif ($survey_id > 0) {
                $leaderboards = OrgLeaderboardAssign::where('assign_id', $survey_id)->where('assign_type', 'survey')->get();
            }
            foreach ($leaderboards as $leaderboard) {
                OrgLeaderboardUserPoint::create([
                    'user_id' => Auth::id(),
                    'type' => $type,
                    'point' => (int)$point,
                    'course_id' => (int)$course_id,
                    'quiz_id' => (int)$quiz_id,
                    'test_id' => (int)$test_id,
                    'survey_id' => (int)$survey_id,
                    'leaderboard_id' => (int)$leaderboard->org_leaderboard_id,
                    'interaction_type' => $interaction_type,
                ]);
            }

        }

    }
}
if (!function_exists('richTextWordLength')) {
    function richTextWordLength($string)
    {
        return str_word_count(strip_tags($string));

    }
}
if (!function_exists('checkEmptyValue')) {
    function checkEmptyValue($string)
    {
        return !empty(trim($string)) ? $string : trans('common.N/A');
    }
}
if (!function_exists('currencyConvert')) {
    function currencyConvert($price)
    {
        try {
            if (auth()->check()) {
                $currency_id = auth()->user()->currency_id;
            } elseif (session('currency_id')) {
                $currency_id = session('currency_id');
            } else {
                $currency_id = Settings('currency_id');
            }
            $default_currency = getCurrencyList()->where('id', Settings('currency_id'))->first();
            $convert_currency = getCurrencyList()->where('id', $currency_id)->first();
            if (Settings('currency_conversion') == 'Manual') {
                return $convert_currency->conversion_rate * $price;
            } else {
                return convertCurrency($default_currency->code ?? 'USD', $convert_currency->code ?? 'USD', $price);
            }
        } catch (Exception $exception) {
            return $price;
        }
    }
}
if (!function_exists('installmentProductPrice')) {
    function installmentProductPrice($topic_id, $plan_id, $price = 0)
    {
        try {
            $installment_request = InstallmentPurchaseRequest::where('topic_id', $topic_id)
                ->where('plan_id', $plan_id)
                ->where('user_id', auth()->user()->id)
                ->with('installmentPayments')
                ->latest()
                ->first();


            $payable_installment = $installment_request->installmentPayments->where('status', 'unpaid')->first();

            return $payable_installment->amount;
        } catch (Throwable $th) {
            return (int)$price;
        }
    }
}


if (!function_exists('dateDifference')) {
    function dateDifference($start_date, $end_date)
    {
        try {
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $diff = $start_date->diffInDays($end_date);
            return $diff;
        } catch (Throwable $th) {
            return 0;
        }
    }
}


if (!function_exists('hasCourseValidAccess')) {
    function hasCourseValidAccess($course)
    {
        if (Auth::check() && Auth::user()->role_id == 3 && $course->access_limit > 0) {
            $checkEnroll = CourseEnrolled::where('user_id', Auth::id())->where('course_id', $course->id)->first();

            $date = Carbon::parse($checkEnroll->created_at);
            $now = Carbon::now();
            $diff = $date->diffInDays($now);
            if ($diff >= $course->access_limit) {
                Toastr::error(trans('frontend.Your access validity is expired'), trans('common.Failed'));
                return false;
            }

        }
        return true;
    }
}
if (!function_exists('orgPermission')) {
    function orgPermission($org_id = null)
    {
        try {
            if (isModuleActive('Organization') && auth()->check() && auth()->user()->isOrganization()) {
                if ($org_id && auth()->user()->id == $org_id) {
                    return true;
                }
                return false;
            }
            return true;
        } catch (Throwable $th) {
            return true;
        }
    }
}
if (!function_exists('randomString')) {
    function randomString($length, $type = 'token')
    {
        if ($type === 'password') {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        } elseif ($type === 'username') {
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        } else {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }
        return substr(str_shuffle($chars), 0, $length);
    }
}

if (!function_exists('certificateAccessForm')) {
    function certificateAccessStudent($key)
    {
        if ($key == config('certificatepro.skey')) {
            return true;
        }
        return false;
    }
}

if (!function_exists('clearCacheByWildcard')) {
    function clearCacheByWildcard($pattern)
    {
        $cacheStore = Cache::store();
        $cacheDriver = $cacheStore->getStore();

        if (method_exists($cacheDriver, 'getConnection')) {
            $keys = $cacheDriver->getConnection()->keys($cacheStore->getPrefix() . $pattern);
            if (!empty($keys)) {
                $cacheStore->forget($keys);
            }
        } else {
            foreach ($cacheStore->getNamespace() as $key) {
                if (fnmatch($pattern, $key)) {
                    $cacheStore->forget($key);
                }
            }
        }
    }
}

if (!function_exists('UserSmsNotificationSetup')) {
    function UserSmsNotificationSetup($act, $user)
    {
        if (!$user->phone) {
            return false;
        }

        $role_email_template = RoleEmailTemplate::where('role_id', $user->role_id)->where('template_act', $act)->where('status', 1)->first();

        if ($role_email_template) {
            $user_notification_setup = UserNotificationSetup::where('user_id', $user->id)->first();

            if ($user_notification_setup) {
                $sms_ids = explode(',', $user_notification_setup->sms_ids);

                if (in_array($act, $sms_ids)) {
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
if (!function_exists('send_sms_notification')) {

    function send_sms_notification($user, $template, $shortcodes = [])
    {
        $response = false;
        try {
            $receiver_number = $user->phone;
            if (empty($receiver_number)) {
                return false;
            }
            $email_template = EmailTemplate::where('act', $template)->where('status', 1)->first();
            if ($email_template && $email_template->status == 1) {
                if ($email_template->act == 'POSTED_NOTIFICATION') {
                    $email_template->subj = $shortcodes['title'] ?? $email_template->subj;
                    $email_template->sms_message = $shortcodes['message'] ?? $email_template->sms_message;
                }

                if ($email_template->sms_message == null) {
                    $message = $email_template->subj;

                    if ($email_template->act == 'Two_Factor_Authentication') {
                        $message = "Your otp code is {{otp_code}}. It will expired within {{expired_time}} Minutes";
                    }
                } else {
                    $message = $email_template->sms_message;
                }
                foreach ($shortcodes as $code => $value) {
                    $message = shortcode_replacer('{{' . $code . '}}', $value, $message);
                }


                $active_gateway = SmsGateway::where('status', 1)->first();
                if (!$active_gateway) {
                    return $response;
                }
                if (empty($active_gateway->gateway_url)) {
                    return $response;
                }
                if ($active_gateway->add_plus) {
                    $receiver_number = '+' . $receiver_number;
                }
                $request_data = [
                    $active_gateway->send_to_parameter_name => $receiver_number,
                    $active_gateway->message_to_parameter_name => $message,
                ];

                foreach ($active_gateway->params as $param) {
                    $request_data[$param->key] = $param->value;
                }

                $params = [];
                $user_name = array_key_exists('username', $request_data);
                $password = array_key_exists('password', $request_data);

                if ($user_name && $password && $active_gateway->set_auth == "header") {
                    $params['auth'] = [
                        $request_data['username'],
                        $request_data['password'],
                    ];
                    unset($request_data['username']);
                    unset($request_data['password']);
                }

                $params['form_params'] = $request_data;
                $client = new Client();
                $method = strtolower($active_gateway->request_method);

                if ($method == 'get') {
                    $response = $client->$method($active_gateway->gateway_url . '?' . http_build_query($request_data));
                } else {
                    $response = $client->$method($active_gateway->gateway_url, $params);
                }
                return $response;
            }
        } catch (Exception $e) {
            Log::error('sms send issue:' . $e->getMessage() . ' Line:' . $e->getLine());
        }
        return $response;
    }
}
if (!function_exists('convertMinutesToHourAndMinute')) {
    function convertMinutesToHourAndMinute($minutes)
    {
        return intdiv($minutes, 60) . ':' . (str_pad($minutes % 60, 2, 0, STR_PAD_LEFT));
    }
}

if (!function_exists('permissionUpdateOrCreate')) {
    function permissionUpdateOrCreate($routes = [])
    {
        foreach ((array)$routes as $key => $route) {
            try {
                $parentSection = Permission::where('route', $route['parent_route'] ?? '')->first();
                if (!empty($parentSection)) {
                    $section_id = $parentSection->section_id;
                } elseif (isset($route['section_id'])) {
                    $section_id = $route['section_id'];
                } else {
                    $section_id = 1;
                }
                Permission::where('route', $route['route'])->delete();
                Permission::create([
                    'name' => $route['name'],
                    'route' => $route['route'],
                    'parent_route' => $route['parent_route'] ?? null,
                    'type' => $route['type'] ?? 1,

                    'old_name' => $route['old_name'] ?? $route['name'],
                    'old_parent_route' => $route['old_parent_route'] ?? $route['parent_route'],
                    'old_type' => $route['old_type'] ?? $route['type'],


                    'backend' => $route['backend'] ?? 1,
                    'ecommerce' => $route['ecommerce'] ?? 0,
                    'icon' => $route['icon'] ?? 'fas fa-th',
                    'module' => $route['module'] ?? null,
                    'not_module' => $route['not_module'] ?? null,
                    'theme' => $route['theme'] ?? null,
                    'not_theme' => $route['not_theme'] ?? null,
                    'section_id' => $section_id,
                    'power' => $route['power'] ?? 0,
                    'status' => $route['status'] ?? 1,
                ]);
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}


if (!function_exists('dateDifference')) {
    function dateDifference($start_date, $end_date)
    {
        try {
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $diff = $start_date->diffInDays($end_date);
            return $diff;
        } catch (Throwable $th) {
            return 0;
        }
    }
}


//Store Helpers
if (!function_exists('getParentSellerId')) {
    function getParentSellerId()
    {
        $seller_id = 0;
        if (auth()->check()) {
            $seller_id = auth()->user()->id;
        }
        return $seller_id;
    }
}

if (!function_exists('pickupLocationData')) {
    function pickupLocationData($key)
    {

        try {
            $user_id = getParentSellerId();
            if ($key) {
                $row = PickupLocation::where('is_set', 1)->where('created_by', $user_id)->first();
                if (!$row) {
                    $row = PickupLocation::where('created_by', $user_id)->first();
                }
                $data = [
                    'id' => $row->id,
                    'pickup_location' => $row->pickup_location,
                    'name' => $row->name,
                    'email' => $row->email,
                    'phone' => $row->phone,
                    'address' => $row->address,
                    'address_2' => $row->address_2,
                    'city' => $row->city->name,
                    'state' => $row->state->name,
                    'country' => $row->country->name,
                    'pin_code' => $row->pin_code,
                ];
                return $data[$key];
            } else {
                return false;
            }

        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('storeProductPrice')) {
    function storeProductPrice($discount_type, $discount, $org_price)
    {
        if (@$discount_type == 1) {
            $price = $org_price - $discount;
        } elseif (@$discount_type == 2) {
            $price = $org_price - ($org_price * $discount) / 100;
        } else {
            $price = $org_price;
        }
        return getPriceFormat($price);
    }
}

if (!function_exists('pickupPoint')) {
    function pickupPoint()
    {
        $location = PickupLocation::where('is_default', 1)->first();
        if ($location) {
            return $location->id;
        } else {
            $location = PickupLocation::first();
            if ($location) {
                return $location->id;
            } else {
                return null;
            }
        }
    }
}

if (!function_exists('sellerWiseShippingConfig')) {
    function sellerWiseShippingConfig($sellerId)
    {
        try {
            if ($sellerId) {
                $row = ShippingConfiguration::first();
                if ($row) {
                    return collect($row);
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } catch (Exception $exception) {
            return null;
        }
    }
}


if (!function_exists('generateDeliveryDate')) {
    function generateDeliveryDate($shipping)
    {
        $shipment_time = $shipping->shipment_time;
        $shipment_time = explode(" ", $shipment_time);
        $dayOrOur = $shipment_time[1] ?? '';
        $shipment_time = explode("-", $shipment_time[0] ?? "");
        $start_ = $shipment_time[0] ?? '';
        $end_ = $shipment_time[1] ?? "";
        $date = date('d-m-Y');
        $start_date = date('d M', strtotime($date . '+ ' . $start_ . ' ' . $dayOrOur));
        $end_date = date('d M', strtotime($date . '+ ' . $end_ . ' ' . $dayOrOur));
        if ($dayOrOur == 'days' || $dayOrOur == 'Days' || $dayOrOur == 'Day') {
            $delivery_date = 'Est arrival date: ' . $start_date . ' ' . '-' . ' ' . $end_date;
        } else {
            $delivery_date = 'Est arrival time: ' . $shipping->shipment_time;
        }
        return $delivery_date;
    }
}


if (!function_exists('hasTable')) {
    function hasTable($table)
    {
        return Cache::rememberForever('hasTable' . $table, function () use ($table) {
            return Schema::hasTable($table);
        });
    }
}
if (!function_exists('hasTableColumn')) {
    function hasTableColumn($table, $column)
    {
        return Cache::rememberForever('hasTable' . $table, function () use ($table, $column) {
            return Schema::hasColumn($table, $column);
        });
    }
}
if (!function_exists('getMaxUploadFileSize')) {
    function getMaxUploadFileSize()
    {
        if (is_numeric($postMaxSize = ini_get('upload_max_filesize'))) {
            return (int)$postMaxSize;
        }

        $metric = strtoupper(substr($postMaxSize, -1));
        $postMaxSize = (int)$postMaxSize;

        return match ($metric) {
            'K' => $postMaxSize * 1024,
            'M' => $postMaxSize * 1048576,
            'G' => $postMaxSize * 1073741824,
            default => $postMaxSize,
        };
    }
}
if (!function_exists('extractId')) {
    function extractId($input)
    {
        preg_match('/\[id=(\d+)\]/', $input, $matches);

        return $matches[1] ?? null;
    }
}
if (!function_exists('combinations')) {
    function combinations($arrays)
    {
        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;
    }
}
if (!function_exists('getProductPrice')) {
    function getProductPrice($product, $sku_id = null)
    {
        $price = $product->price;
        $discount = $product->discount;
        $discount_type = $product->discount_type;

        if ($product->has_variant && $sku_id) {
            $sku = ProductSku::find($sku_id);
            $price = $sku->price ?? 0;
        }

        if (@$discount_type == 1) {
            $price = $price - $discount;
        } elseif (@$discount_type == 2) {
            $price = $price - ($price * $discount) / 100;
        }
        if ($price < 0) {
            $price = 0;
        }
        return $price;
    }
}

if (!function_exists('getCouponPrice')) {
    function getCouponPrice($course_id)
    {
        if (isset(session()->get('coupon')[$course_id])) {
            return session()->get('coupon')[$course_id]['price'] ?? 0;
        } elseif (Auth::check()) {
            $cart = Cart::where('user_id', auth()->id())->where('course_id', $course_id)->whereNotNull('coupon_id')->first();
            return $cart->price ?? 0;
        } else {
            return 0;
        }

    }
}

if (!function_exists('hasCouponApply')) {
    function hasCouponApply($course_id)
    {
        if (isset(session()->get('coupon')[$course_id])) {
            return true;
        } elseif (Auth::check()) {
            $cart = Cart::where('user_id', auth()->id())->where('course_id', $course_id)->whereNotNull('coupon_id')->first();
            return $cart ? true : false;
        } else {
            return false;
        }
    }
}

if (!function_exists('getLimitedText')) {
    function getLimitedText($string, $limit)
    {
        $decodedString = html_entity_decode($string);
        $cleanedString = strip_tags($decodedString);
        $trimmedString = preg_replace('/\s+/', ' ', trim($cleanedString));
        return Str::limit($trimmedString, $limit);
    }
}
if (!function_exists('getBlogBonus')) {
    function getBlogBonus($blog)
    {
        if ($blog->status == 1
            && $blog->get_bonus != 1
            && $blog->user->role_id != 1
            && Settings('blog_credit_conversion_status') == 1
            && Settings('blog_credit_conversion_point') > 0
            && $blog->words_count > 0) {
            $point = Settings('blog_credit_conversion_point');
            $perWordPoint = 1 / $point;
            $words_count = $blog->words_count;

            $bonus = $perWordPoint * $words_count;

            $user = $blog->user;
            $user->balance = $user->balance + $bonus;
            $user->save();

            $blog->get_bonus = true;
            $blog->save();


            SendNotification::dispatch('Wallet_Credited', $user, [
                'name' => $user->name,
                'amount' => $bonus,
                'date_time' => Carbon::now()->format(Settings('active_date_format') . ' H:i:s A'),
            ], []);

        }
        return false;
    }
}

if (!function_exists('getQuestionType')) {
    function getQuestionType($type)
    {
        if ($type == "M") {
            return trans('quiz.Multiple Choice');
        } elseif ($type == "S") {
            return trans('quiz.Short Answer');
        } elseif ($type == "O") {
            return trans('quiz.Sorting');
        } elseif ($type == "L") {
            return trans('quiz.Long Answer');
        } elseif ($type == "X") {
            return trans('quiz.Matching');
        } elseif ($type == "C") {
            return trans('quiz.Cloze question');
        } elseif ($type == "P") {
            return trans('quiz.Puzzle');
        } else {
            return trans('common.N/A');
        }
    }
}

if (!function_exists('getClozeOptions')) {
    function getClozeOptions($qus, $submitted_options=null)
    {

        $questionMuInSerial = $qus->questionMuInSerial;
        $groups = $questionMuInSerial->groupBy('group');

        $selectOptions = [];
        $i = 1;
        foreach ($groups as $key => $group) {
            $selectOptions[$i] = $group->pluck('title', 'id')->toArray();
            $i++;
       }
        $string = $qus->question;

        if (!$submitted_options){
            return preg_replace_callback('/\[(\d+)\]/', function ($matches) use ($selectOptions) {
                $index = (int)$matches[1];

                // If no options are defined for this index, return the placeholder as is
                if (!isset($selectOptions[$index])) {
                    return $matches[0];
                }

                $options = "<option value=''>".trans('common.Select One')."</option>";
                foreach ($selectOptions[$index] as $value => $label) {
                    $options .= "<option value='{$value}'>{$label}</option>";
                }

                return "<span class='select-wrapper d-inline-block'><select class='quiz-select' name='select_{$index}'>{$options}</select></span>";

            }, $string);
        }else{

            $submittedAns = [];
            $group_ids = [];

            // Get group IDs and submitted answers
            foreach ($groups as $key => $group) {
                $group_ids[] = $group->pluck('id')->toArray();
            }

$submittedIndex=1;
            foreach ($submitted_options as $key => $value) {
                if (isset($value['submit']) && $value['submit']) {
                    $submittedAns[$submittedIndex] = $value;
                    $submittedIndex++;
                }
            }

            return preg_replace_callback('/\[(\d+)\]/', function ($matches) use ($selectOptions, $submittedAns) {
                $index = (int)$matches[1];

                // If no options are defined for this index, return the placeholder as is
                if (!isset($selectOptions[$index])) {
                    return $matches[0];
                }
                 // Check if an answer was submitted for this index
                if (isset($submittedAns[$index])) {
                    $submittedValue = $submittedAns[$index]['id'];  // The submitted answer's ID
                    $submittedLabel = $selectOptions[$index][$submittedValue] ?? trans('common.Invalid Option');
                    $isCorrect = $submittedAns[$index]['right'];  // Whether the submitted answer is correct

                    // Add correct or wrong class based on the correctness of the answer
                    $class = $isCorrect ? 'text-success' : 'text-danger';

                    // Return the submitted answer in a span tag
                    return "<span class='{$class}'>{$submittedLabel}</span>";
                }


            }, $string);
        }

    }
}



if (!function_exists('earnCourseBadge')) {
    function earnCourseBadge($course_id,$user_id,$status=false)
    {
        if (!$status){
            return false;
        }
        CourseBadge::updateOrCreate([
            'course_id'=>$course_id,
            'user_id'=>$user_id,
        ]);
        return true;
    }
}
