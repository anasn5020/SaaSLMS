<?php

use App\Http\Controllers\Frontend\ThemeDynamicData;
use App\Notifications\GeneralNotification;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use IvoPetkov\HTML5DOMDocument;
use Modules\Affiliate\Entities\AffiliateConfiguration;
use Modules\Blog\Entities\UserBlog;
use Modules\FooterSetting\Entities\FooterSetting;
use Modules\Membership\Entities\MembershipUpgradeLevel;
use Modules\Org\Entities\OrgRecentActivity;
use Modules\RolePermission\Entities\Permission;
use Modules\Setting\Entities\Badge;
use Modules\Setting\Entities\UserBadge;
use Modules\Setting\Entities\UserGamificationPoint;
use Modules\Setting\Entities\UserLevelHistory;


if (!function_exists('paymentGateWayCredentialsEmptyCheck')) {
    function paymentGateWayCredentialsEmptyCheck($method)
    {
        if ($method == 'PayPal') {
            if (!empty(getPaymentEnv('PAYPAL_CLIENT_ID')) && !empty(getPaymentEnv('PAYPAL_CLIENT_SECRET')) && !empty(getPaymentEnv('IS_PAYPAL_LOCALHOST'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Instamojo') {
            if (!empty(getPaymentEnv('Instamojo_API_AUTH')) && !empty(getPaymentEnv('Instamojo_API_AUTH_TOKEN')) && !empty(getPaymentEnv('Instamojo_URL'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Midtrans') {
            if (!empty(getPaymentEnv('MIDTRANS_SERVER_KEY'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Payeer') {
            if (!empty(getPaymentEnv('PAYEER_MERCHANT')) && !empty(getPaymentEnv('PAYEER_KEY'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Pesapal') {
            if (!empty(getPaymentEnv('PESAPAL_KEY')) && !empty(getPaymentEnv('PESAPAL_SECRET'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Mobilpay') {
            if (!empty(getPaymentEnv('MOBILPAY_MERCHANT_ID')) && !empty(getPaymentEnv('MOBILPAY_TEST_MODE')) && !empty(getPaymentEnv('MOBILPAY_PUBLIC_KEY_PATH')) && !empty(getPaymentEnv('MOBILPAY_PRIVATE_KEY_PATH'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'PayPal') {
            if (!empty(getPaymentEnv('PAYPAL_CLIENT_ID')) && !empty(getPaymentEnv('PAYPAL_CLIENT_SECRET'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Stripe') {
            if (!empty(getPaymentEnv('STRIPE_SECRET')) && !empty(getPaymentEnv('STRIPE_KEY'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'PayStack') {
            if (!empty(getPaymentEnv('PAYSTACK_PUBLIC_KEY')) && !empty(getPaymentEnv('PAYSTACK_SECRET_KEY')) && !empty(getPaymentEnv('MERCHANT_EMAIL')) && !empty(getPaymentEnv('PAYSTACK_PAYMENT_URL'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'RazorPay') {
            if (!empty(getPaymentEnv('RAZOR_KEY')) && !empty(getPaymentEnv('RAZOR_SECRET'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'MercadoPago') {
            if (!empty(getPaymentEnv('MERCADO_PUBLIC_KEY')) && !empty(getPaymentEnv('MERCADO_ACCESS_TOKEN'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'PayTM') {
            if (!empty(getPaymentEnv('PAYTM_MERCHANT_ID')) && !empty(getPaymentEnv('PAYTM_MERCHANT_KEY')) && !empty(getPaymentEnv('PAYTM_MERCHANT_WEBSITE')) && !empty(getPaymentEnv('PAYTM_CHANNEL')) && !empty(getPaymentEnv('PAYTM_INDUSTRY_TYPE'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Bkash') {
            if (!empty(getPaymentEnv('BKASH_APP_KEY')) && !empty(getPaymentEnv('BKASH_APP_SECRET')) && !empty(getPaymentEnv('BKASH_USERNAME')) && !empty(getPaymentEnv('BKASH_PASSWORD')) && !empty(getPaymentEnv('IS_BKASH_LOCALHOST'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Easy Paisa') {
            if (!empty(getPaymentEnv('EASY_PAISA_STORE_ID')) && !empty(getPaymentEnv('EASY_PAISA_HASH_KYE'))) {
                $result = true;
            } else {
                $result = false;
            }

        } elseif ($method == 'Authorize.Net') {
            if (!empty(getPaymentEnv('AUTHORIZE_NET_API_KEY')) && !empty(getPaymentEnv('AUTHORIZE_NET_API_KEY')) && !empty(getPaymentEnv('AUTHORIZE_NET_TRANSACTION_KEY'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Braintree') {
            if (!empty(getPaymentEnv('BRAINTREE_MERCHANT_ID')) && !empty(getPaymentEnv('BRAINTREE_PUBLIC_KEY')) && !empty(getPaymentEnv('BRAINTREE_PRIVATE_KEY')) && !empty(getPaymentEnv('BRAINTREE_ENVIRONMENT'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Mollie') {
            if (!empty(getPaymentEnv('MOLLIE_SECRET_KEY'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Flutterwave') {
            if (!empty(getPaymentEnv('FLW_PUBLIC_KEY')) && !empty(getPaymentEnv('FLW_SECRET_KEY')) && !empty(getPaymentEnv('FLW_SECRET_HASH')) && !empty(getPaymentEnv('FLW_ENVIRONMENT'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Coinbase') {
            if (!empty(getPaymentEnv('COINBASE_API_KEY')) && !empty(getPaymentEnv('COINBASE_API_VERSION'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Jazz Cash') {
            if (!empty(getPaymentEnv('JAZZ_CASH_MERCHANT_ID')) && !empty(getPaymentEnv('JAZZ_CASH_PASSWORD')) && !empty(getPaymentEnv('JAZZ_CASH_INTEGRITY_SALT'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'CCAvenue') {
            if (!empty(getPaymentEnv('CCA_KEY')) && !empty(getPaymentEnv('CCA_ACCESS_CODE')) && !empty(getPaymentEnv('CCA_MERCHANT_ID'))) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = true;
        }
        return $result;
    }
}


if (!function_exists('affiliateConfig')) {
    function affiliateConfig($key)
    {
        try {
            if ($key) {
                if (Cache::has('affiliate_config_' . SaasDomain())) {
                    $affiliate_configs = Cache::get('affiliate_config_' . SaasDomain());
                    return $affiliate_configs[$key];

                } else {
                    Cache::forget('affiliate_config_' . SaasDomain());
                    $data = [];
                    foreach (AffiliateConfiguration::get() as $setting) {
                        $data[$setting->key] = $setting->value;
                    }
                    Cache::rememberForever('affiliate_config_' . SaasDomain(), function () use ($data) {
                        return $data;
                    });
                    $affiliate_configs = Cache::get('affiliate_config_' . SaasDomain());
                    return $affiliate_configs[$key];
                }
            } else {
                return false;
            }

        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('isAffiliateUser')) {
    function isAffiliateUser()
    {
        try {
            if (isModuleActive('Affiliate')) {
                if (auth()->check()) {
                    if (auth()->user()->affiliate_request == 1) {
                        return true;
                    }
                }
            }
            return false;

        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('hasAffiliateAccess')) {
    function hasAffiliateAccess()
    {
        try {
            if (isModuleActive('Affiliate')) {
                if (auth()->check()) {
                    if (auth()->user()->role->id == 1) {
                        return true;
                    }
                    if (auth()->user()->affiliate_request == 1 && auth()->user()->accept_affiliate_request == 1) {
                        return true;
                    }
                }
            }

            return false;

        } catch (Exception $exception) {
            return false;
        }
    }
}


if (!function_exists('showPrice')) {
    function showPrice($price, $text = false)
    {
        if (!showEcommerce()) {
            return '';
        }
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
                $result = 0;
            }
        }

        if (Settings('currency_seperator') == 2) {
            $explode = explode('.', $result);
            $results = implode(',', $explode);
            return $results;
        } else {
            return $result;
        }
    }
}

if (!function_exists('showEcommerce')) {
    function showEcommerce()
    {
        if (Settings('hide_ecommerce') != '1') {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('onlySubscription')) {
    function onlySubscription()
    {
        if (isModuleActive('Subscription') && Settings('only_subscription') == '1') {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('getAllChildCodeIds')) {
    function getAllChildCodeIds($child, $pathCode = [])
    {
        if (isset($child->childs)) {
            if (count($child->childs) != 0) {
                foreach ($child->childs as $child) {
                    $pathCode[] = $child->id;
                    $pathCode = getAllChildCodeIds($child, $pathCode);
                }
                return $pathCode;
            }
        }
        return $pathCode;
    }
}

if (!function_exists('orgGetStartEndDate')) {
    function orgGetStartEndDate($enroll, $course)
    {
        $days['start'] = '';
        $days['end'] = '';
        if ($enroll->org_subscription_plan_id != 0) {
            $plan = $enroll->orgSubscriptionPlan;
            if ($plan->type == 1) {
                if (!empty($plan->join_date)) {
                    $days['start'] = Carbon::createFromFormat('m/d/Y', $plan->join_date)->translatedFormat('d/m/Y') . ' ' . $plan->join_time;
                }
                if (!empty($plan->end_date)) {
                    $days['end'] = Carbon::createFromFormat('m/d/Y', $plan->end_date)->translatedFormat('d/m/Y') . ' ' . $plan->end_time;
                }
            } else {
                $start = $plan->subscription->start_date;
                $end = $plan->subscription->end_date;
                if (!empty($start)) {
                    $days['start'] = Carbon::parse($start . '')->translatedFormat('d/m/Y h:i A');
                }
                if (!empty($end)) {
                    $days['end'] = Carbon::parse($end)->translatedFormat('d/m/Y h:i A');
                }

            }
        } elseif (isset($enroll->shift) && $enroll->shift != 0) {
            $shift = $enroll->shiftDetails();
            if ($shift) {
                $days['start'] = Carbon::createFromFormat('m/d/Y', $shift->start_date)->translatedFormat('d/m/Y') . ' ' . $shift->start_time;
                $days['end'] = Carbon::createFromFormat('m/d/Y', $shift->end_date)->translatedFormat('d/m/Y') . ' ' . $shift->end_time;
            } else {
                $days['start'] = trans('common.Not Set');
                $days['end'] = trans('common.Not Set');
            }

        } else {
            $days['start'] = Carbon::parse($course->created_at)->translatedFormat('d/m/Y h:i A');
            $days['end'] = trans('org.Limitless');
        }

        return $days;
    }
}

if (!function_exists('addOrgRecentActivity')) {
    function addOrgRecentActivity($user_id, $course_id, $type)
    {
        if (isModuleActive('Org')) {
            $activity = new OrgRecentActivity();
            $activity->user_id = $user_id;
            $activity->course_id = $course_id;
            $activity->type = $type;
            $activity->save();
        }
    }
}


if (!function_exists('getPercentage')) {
    function getPercentage($value, $total, $decimal = 0)
    {
        try {
            if ($value > 0 && $total > 0) {
                $count1 = $value / $total;
                $count2 = $count1 * 100;
                return number_format($count2, $decimal);
            } else {
                return 0;
            }

        } catch (Exception $e) {
            return 0;
        }
    }
}

if (!function_exists('applyDefaultRoleToUser')) {
    function applyDefaultRoleToUser($user)
    {
        if (isModuleActive('UserType')) {
            $user->userRoles()->sync($user->role_id);
        }
    }
}

if (!function_exists('assetVersion')) {
    function assetVersion()
    {
        if (config('app.debug')) {
            $ver = rand(1, 9999);
        } else {
            $ver = Storage::has('.version') ? Storage::get('.version') : Settings('system_version');
        }
        return '?v=' . $ver;
    }
}
if (!function_exists('ob_fresh')) {
    function ob_fresh()
    {
        ob_end_clean();
        ob_start();
    }
}
if (!function_exists('clearAllLangCache')) {
    function clearAllLangCache($key)
    {
        try {
            $domain = SaasDomain();
        } catch (Exception $e) {
            $domain = 'main';
        }
        try {
            $languages = getLanguageList();
            foreach ($languages as $lang) {
                Cache::forget($key . $lang->code . $domain);
            }
        } catch (Exception $exception) {

        }

    }
}
if (!function_exists('footerSettings')) {
    function footerSettings($key)
    {
        $footerSetting = Cache::rememberForever('footerSetting_' . app()->getLocale() . SaasDomain(), function () {
            return FooterSetting::all();
        });
        $setting = $footerSetting->where('key', $key)->first();
        return $setting ? $setting->value : '';
    }
}

if (!function_exists('convertToSlug')) {
    function convertToSlug($str, $delimiter = '-')
    {
        $unwanted_array = ['ś' => 's', 'ą' => 'a', 'ć' => 'c', 'ç' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ź' => 'z', 'ż' => 'z',
            'Ś' => 's', 'Ą' => 'a', 'Ć' => 'c', 'Ç' => 'c', 'Ę' => 'e', 'Ł' => 'l', 'Ń' => 'n', 'Ó' => 'o', 'Ź' => 'z', 'Ż' => 'z'];
        $str = strtr($str, $unwanted_array);

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }
}

if (!function_exists('byte2mb')) {
    function formatBytes($bytes)
    {
        if ($bytes > 0) {
            $i = floor(log($bytes) / log(1024));
            $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            return sprintf('%.02F', round($bytes / pow(1024, $i), 1)) * 1 . ' ' . @$sizes[$i];
        } else {
            return 0;
        }
    }
}

if (!function_exists('selfHosted')) {
    function selfHosted($type)
    {
        $self = ['Self', 'SCORM', 'XAPI', 'PowerPoint', 'Excel', 'Text', 'Word', 'PDF', 'Image', 'Zip'];
        if (in_array($type, $self)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('getActiveJsDateFormat')) {
    function getActiveJsDateFormat(): string
    {
        switch (Settings('active_date_format')) {
            case 'Y-m-d':
                $jsFormat = 'yyyy-mm-dd';
                break;
            case 'Y-d-m':
                $jsFormat = 'yyyy-dd-mm';
                break;
            case 'd-m-Y':
                $jsFormat = 'dd-mm-yyyy';
                break;
            case 'm-d-Y':
                $jsFormat = 'mm-dd-yyyy';
                break;
            case 'Y/m/d':
                $jsFormat = 'yyyy/mm/dd';
                break;
            case 'Y/d/m':
                $jsFormat = 'yyyy/dd/mm';
                break;
            case 'd/m/Y':
                $jsFormat = 'dd/mm/yyyy';
                break;
            case 'm/d/Y':
                $jsFormat = 'mm/dd/yyyy';
                break;
            default:
                $jsFormat = 'mm/dd/yyyy';
        }

        return $jsFormat;
    }

}
if (!function_exists('getActivePhpDateFormat')) {
    function getActivePhpDateFormat(): string
    {
        $valid = [
            'Y-m-d',
            'Y-d-m',
            'd-m-Y',
            'm-d-Y',
            'Y/m/d',
            'Y/d/m',
            'd/m/Y',
            'm/d/Y'
        ];
        if (!in_array(Settings('active_date_format'), $valid)) {
            $format = 'm/d/Y';
        } else {
            $format = Settings('active_date_format');
        }
        return $format;
    }
}

if (!function_exists('getJsDateFormat')) {
    function getJsDateFormat($date = null): string
    {
        try {
            if (empty($date)) {
                return '';
            }
            $format = getActivePhpDateFormat();
            if ($format == 'm/d/Y') {
                return $date;
            }
            return Carbon::createFromFormat('m/d/Y', $date)->format($format);
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('getPhpDateFormat')) {
    function getPhpDateFormat($date): string
    {
        $format = getActivePhpDateFormat();
        try {
            return Carbon::createFromFormat($format, $date)->format('m/d/Y');
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('hasDynamicPage')) {
    function hasDynamicPage()
    {
        $themes = [
            'infixlmstheme',
            'kidslms'
        ];
        if (!in_array(currentTheme(), $themes)) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('MarkAsBlogRead')) {
    function MarkAsBlogRead($blog_id = 0)
    {
        if (Auth::check()) {
            UserBlog::updateOrInsert([
                'user_id' => Auth::id(),
                'blog_id' => $blog_id,
            ]);
        }

    }
}
if (!function_exists('upgradeLevelPayment')) {
    function upgradeLevelPayment(int $checkout_id, int $level_id, int $user_id = null)
    {
        $userId = $user_id ?? auth()->user()->id;
        $exit = MembershipUpgradeLevel::where('membership_checkout_id', $checkout_id)->where('level_id', $level_id)->where('user_id', $userId)->first();
        if ($exit) {
            return true;
        }
        return false;


    }
}
if (!function_exists('spn_active_link')) {
    function spn_active_link($route_or_path, $class = 'mm-active')
    {
        if (is_array($route_or_path)) {
            foreach ($route_or_path as $route) {
                if (request()->is($route)) {
                    return $class;
                }
            }
            return in_array(request()->route()->getName(), $route_or_path) ? $class : false;
        } else {
            if (request()->route()->getName() == $route_or_path) {
                return $class;
            }

            if (request()->is($route_or_path)) {
                return $class;
            }
        }

        return false;
    }
}

if (!function_exists('childrenRoute')) {
    function childrenRoute($menu, $routes = [])
    {
        if (@$menu->route) {
            $routes[] = $menu->route;
        }
        if (!empty($menu->childs) && $menu->childs->count()) {
            foreach ($menu->childs as $child) {
                $routes = childrenRoute($child, $routes);
            }
            return $routes;
        }
        return $routes;
    }
}

if (!function_exists('parentRoute')) {
    function parentRoute($menu, $routes = [])
    {
        $count = count($routes);
        if (@$menu->route) {
            $routes[$count]['route'] = $menu->route;
            $routes[$count]['name'] = $menu->name;
        }
        if ($menu->parent) {
            return parentRoute($menu->parent, $routes);
        }
        return $routes;
    }
}

if (!function_exists('dynamicContentAppend')) {
    function dynamicContentAppend($content = null)
    {
        try {
            $dom = new HTML5DOMDocument();
            $dom->loadHTML($content, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);
            $nodes = $dom->querySelectorAll('.dynamicData');

            if ($nodes) {
                foreach ($nodes as $node) {

                    $parent_data = $node->parentNode->getAttributes();
                    $request = [];
                    $param = [];
                    foreach ($parent_data as $key => $data) {
                        //                        $param[] = $key;
                        $param[$key] = $data;
                    }

                    $request['param'] = $param;
                    request()->merge($request);

                    $themeDynamic = new ThemeDynamicData();
                    $data = $themeDynamic->__invoke(request());
                    if (response($data)->status() == 200) {
                        $content = response($data)->content();
                        $newnode = $dom->createDocumentFragment();
                        $newnode->appendXML('<div>' . htmlspecialchars($content) . '</div>');
                        $node->appendChild($newnode);
                    } else {
                        return '';
                    }
                }
            }

            return $dom->saveHTML();
        } catch (Exception $exception) {
            if (app()->environment() == 'local') {
                dd($exception);
            }
            return '';
        }
    }
}

if (!function_exists('generateBreadcrumb')) {
    function generateBreadcrumb($currentRoute = null)
    {
        try {
            if (empty($currentRoute)) {
                $currentRoute = Route::currentRouteName();
            }
            $menus = Cache::rememberForever('MenuPermissionList_' . SaasDomain(), function () {
                return Permission::select('name', 'route', 'parent_route', 'position')->with('parent')->orderBy('position')->get();
            });
            $menu = $menus->where('route', $currentRoute)->first();

            if ($menu) {
                $links = parentRoute($menu);
                krsort($links);
                return view('backend.partials.breadcrumb', compact('links', 'menu'));
            }
        } catch (Exception $e) {
            return '';
        }

    }
}
if (!function_exists('dbDateFormat')) {
    function dbDateFormat($date)
    {
        $format = getActiveJsDateFormat();
        try {
            return \Illuminate\Support\Carbon::createFromFormat($format, $date)->format('Y-m-d');
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('checkGamification')) {
    function checkGamification($type, $badge_type, $user = null, $point = 0)
    {
        $enable = false;

        if (empty($user)) {
            if (auth()->check()) {
                $user = auth()->user();
            }else{
                return false;
            }
        }
        $user_id = $user->id;

        if ($user->role_id == 1) {
            return false;
        }

        if (Settings('gamification_status') && Settings('gamification_point_status') && !isModuleActive('Org')) {

            if ($type == 'each_login' && Settings('gamification_point_each_login_status')) {
                $point = Settings('gamification_point_each_login_point');
                $enable = true;
            } elseif ($type == 'each_unit_complete' && Settings('gamification_point_each_unit_complete_status')) {
                $point = Settings('gamification_point_each_unit_complete_point');
                $enable = true;
            } elseif ($type == 'each_course_complete' && Settings('gamification_point_each_course_complete_status')) {
                $point = Settings('gamification_point_each_course_complete_point');
                $enable = true;
            } elseif ($type == 'each_certificate' && Settings('gamification_point_each_certificate_status')) {
                $point = Settings('gamification_point_each_certificate_point');
                $enable = true;
            } elseif ($type == 'each_test_complete' && Settings('gamification_point_each_test_complete_status')) {
                $point = Settings('gamification_point_each_test_complete_point');
                $enable = true;
            } elseif ($type == 'each_assignment_complete' && Settings('gamification_point_each_assignment_complete_status')) {
                $point = Settings('gamification_point_each_assignment_complete_point');
                $enable = true;
            } elseif ($type == 'each_comment' && Settings('gamification_point_each_comment_status')) {
                $point = Settings('gamification_point_each_comment_point');
                $enable = true;
            } elseif ($type == 'each_perfectionism' && Settings('gamification_badges_perfectionism_status')) {
                $enable = true;
            } elseif ($type == 'each_survey' && Settings('gamification_badges_survey_status')) {
                $enable = true;
            }

        } elseif (isModuleActive('Org')) {
            if ($type == 'each_login' && Settings('gamification_point_each_login_status')) {
                $point = 1;
                $enable = true;
            } elseif ($type == 'each_course_complete' && Settings('gamification_point_each_course_complete_status')) {
                $enable = true;
            } elseif ($type == 'each_test_complete' && Settings('gamification_point_each_test_complete_status')) {
                $enable = true;
            } elseif ($type == 'each_perfectionism' && Settings('gamification_badges_perfectionism_status')) {
                $enable = true;
            } elseif ($type == 'each_survey' && Settings('gamification_badges_survey_status')) {
//                $point = 1;
                $enable = true;
            } elseif ($type == 'each_certificate' && Settings('gamification_point_each_certificate_status')) {
                $point = 1;
                $enable = true;
            }
        }

        if ($enable) {
            UserGamificationPoint::create([
                'user_id' => $user_id,
                'type' => $type,
                'badge_type' => $badge_type,
                'point' => (int)$point,
            ]);
            if ($point != 0) {
                $typeTrans = 'setting.' . $type;
                $notification_title = '+' . $point . ' ' . trans('setting.Points') . ' ' . trans('common.for') . ' ' . trans($typeTrans);

                Toastr::success($notification_title, trans('common.Success'));

                $user_new_point = $user->gamification_total_points + $point;

                $user->gamification_points = $user->gamification_points + $point;
                $user->gamification_total_points = $user_new_point;
                $user->save();

                $details = [
                    'title' => $notification_title,
                    'body' => $notification_title,
                    'actionText' => '',
                    'actionURL' => '#',
                ];
                Notification::send($user, new GeneralNotification($details));
            }


        }

        $totalGamificationPoint = (int)UserGamificationPoint::where('badge_type', $badge_type)->where('user_id', auth()->id())->sum('point');

        $badges = Badge::where('type', $badge_type)->where('point', '<=', $totalGamificationPoint)->where('status', 1)->orderBy('point', 'desc')->get();
        foreach ($badges as $badge) {
            if ($badge && Settings('gamification_badges_' . $badge_type . '_status')) {

                $userBadge = UserBadge::updateOrCreate([
                    'user_id' => $user_id,
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
                    Notification::send($user, new GeneralNotification($details));
                }
            }
        }


        checkUserLevel($user);


        return false;
    }
}

if (!function_exists('checkUserLevel')) {
    function checkUserLevel($user)
    {
        if ((bool)Settings('gamification_level_status')) {



            if ((bool)Settings('gamification_level_entry_point_status')) {
                $point = (int)Settings('gamification_level_entry_point');
                while ($user->gamification_points >= $point) {
                    $user->gamification_points -= $point;
                    $user->user_level += 1;
                    createUserLevelHistory($user->id, 'point', $user->gamification_total_points);
                }
                $user->save();
            }

            if ((bool)Settings('gamification_level_entry_complete_status')) {
                $point = (int)Settings('gamification_level_entry_complete_point');
                $total_courses = $user->studentCourses->count();

                 $new_level = (int)floor($total_courses / $point);

                 if ($new_level > $user->user_level_course_complete) {
                    $user->user_level_course_complete = $new_level;
                    $user->save();

                     createUserLevelHistory($user->id, 'course', $point);
                }
            }
            if ((bool)Settings('gamification_level_entry_badge_status')) {
                $point = (int)Settings('gamification_level_entry_badge_point');
                $total_badges = $user->userBadges->count();

                 if ($total_badges == 0) {
                    $level = 1;
                } else {
                     $level = (int)ceil($total_badges / $point);
                }

                 if ($user->user_level < $level) {
                    $user->user_level = $level;
                    $user->save();

                     createUserLevelHistory($user->id, 'badge', $point);
                }
            }


        }

    }
}

if (!function_exists('createUserLevelHistory')) {
    function createUserLevelHistory($id, $type, $point)
    {
        $check = UserLevelHistory::where('user_id', $id)->where('type', $type)->where('count', $point)->first();
        if (!$check) {
            UserLevelHistory::create([
                'user_id' => $id,
                'type' => $type, //point|course|badge
                'count' => $point,

            ]);
            Toastr::success(trans('common.A new level has been unlocked'), trans('common.Congratulations'));
        }


    }
}


