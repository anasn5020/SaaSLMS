<?php

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\CourseSetting\Entities\Category;
use Modules\Organization\Entities\OrganizationSetting;
use Modules\Payment\Entities\Cart;
use Modules\Setting\Model\Currency;
use Modules\StudentSetting\Entities\BookmarkCourse;
use Modules\SystemSetting\Entities\EmailSetting;
use Modules\SystemSetting\Entities\EmailTemplate;


if (!function_exists('ad')) {
    function ad(mixed ...$vars)
    {
        if (config('app.debug')) {
            foreach ($vars as $key => $value) {
                 Log::info(is_int($key) ? "Variable {$key}" : $key, [
                    'dump' => print_r($value, true),
                ]);
            }

             dd(...$vars);
        }
    }
}


if (!function_exists('send_smtp_mail')) {
    function send_smtp_mail($config, $receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
    {
        $mail_val = [
            'send_to_name' => $receiver_name,
            'send_to' => $receiver_email,
            'email_from' => $config->from_email,
            'email_from_name' => $config->from_name,
            'subject' => $subject,
        ];

        try {
            Mail::send('partials.email', ['body' => $message], function ($send) use ($mail_val) {
                $send->from($mail_val['email_from'], $mail_val['email_from_name']);
                $send->replyto($mail_val['email_from'], $mail_val['email_from_name']);
                $send->to($mail_val['send_to'])->subject($mail_val['subject']);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

}

if (!function_exists('sendMailBySendGrid')) {
    function sendMailBySendGrid($config, $receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($config->from_email, $config->from_name);
        $email->setSubject($subject);
        $email->addTo($receiver_email, $receiver_email);
        $email->addContent(
            "text/html", (string)view('partials.email', ['body' => $message])
        );
        $sendgrid = new SendGrid($config->api_key);
        try {
            $response = $sendgrid->send($email);
            if ($response->statusCode() == 202) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}


if (!function_exists('shortcode_replacer')) {

    function shortcode_replacer($shortcode, $replace_with, $template_string)
    {
        if ($shortcode == "{{currency}}") {
            return str_replace($shortcode, '', $template_string);
        }

        if ($shortcode == "{{amount}}" || $shortcode == "{{price}}" || $shortcode == "{{rev}}") {
            return str_replace($shortcode, getPriceFormat($replace_with), $template_string);
        }
        return str_replace($shortcode, $replace_with, $template_string);
    }
}

if (!function_exists('send_email')) {

    function send_email($user, $type, $shortcodes = [])
    {
        try {
            $query = EmailTemplate::query();
            if (!showEcommerce()) {
                $query->where('ecommerce', 0);
            }
            $email_template = $query->where('act', $type)->first();
            if ($email_template && $email_template->status == 1) {

                if ($email_template->act == 'POSTED_NOTIFICATION') {
                    $email_template->email_body = $shortcodes['message'] ?? $email_template->email_body;
                    $email_template->subj = $shortcodes['title'] ?? $email_template->subj;
                }


                $message = $email_template->email_body;
                foreach ($shortcodes as $code => $value) {
                    $message = shortcode_replacer('{{' . $code . '}}', $value, $message);
                }
                $message = shortcode_replacer('{{footer}}', Settings('email_template'), $message);

                $config = EmailSetting::where('active_status', 1)->first();

                if ($type == "CONTACT_MESSAGE") {
                    $to_email = Settings('email');
                } else {
                    $to_email = $user->email;
                }
                if (empty($user->email)) {
                    return false;
                }
                if ($config->id == 1) {
                    send_php_mail($to_email, $user->name, $config->from_email, $email_template->subj, $message);
                } else if ($config->id == 2) {
                    send_smtp_mail($config, $to_email, $user->name, $config->from_email, Settings('site_title'), $email_template->subj, $message);
                } else if ($config->id == 3) {
                    sendMailBySendGrid($config, $to_email, $user->name, $config->from_email, Settings('site_title'), $email_template->subj, $message);
                }
                return true;
            }
            return false;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }


    }
}


if (!function_exists('getTrx')) {
    function getTrx($length = 12)
    {
        $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('routeIsExist')) {
    function routeIsExist($route)
    {
        if (Route::has($route)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('validRouteUrl')) {
    function validRouteUrl($route)
    {
        $url = null;
        try {
            $route = explode('?', $route);
            if (routeIsExist($route[0])) {
                if (isset($route[1])) {
                    $url = \route($route[0], $route[1]);
                } else {
                    $url = \route($route[0]);
                }
            }
        } catch (Exception $e) {
        }
        return $url;
    }
}


if (!function_exists('routeIs')) {
    function routeIs($route)
    {
        if (Route::currentRouteName() == $route) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('appMode')) {
    function appMode()
    {
        return (Config::get('app.app_sync'));
    }
}

if (!function_exists('demoCheck')) {
    function demoCheck($message = '')
    {
        if (appMode()) {
            if (empty($message)) {
                $message = trans('common.For the demo version, you cannot change this');
            }
            Toastr::error($message, trans('common.Failed'));
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('demoCheckById')) {
    function demoCheckById($currentId, $demoIds,$message = '')
    {
        if (Config::get('app.demo_mode') && in_array($currentId, $demoIds) ) {
            if (empty($message)) {
                $message = trans('common.For the demo version, you cannot change this');
            }
            Toastr::error($message, trans('common.Failed'));
            return true;
        } else {
            return false;
        }
    }
}



if (!function_exists('userName')) {
    function userName($id)
    {
        if (User::find($id) != null) {
            return User::find($id)->name;
        }
        return null;
    }
}
if (!function_exists('fileUpload')) {
    function fileUpload($file, $destination)
    {
        $contains = Str::contains($destination, SaasDomain() . '/');
        if (!$contains) {
            $destination = explode('public/uploads/', $destination);
            $destination = $destination[0] . 'public/uploads/' . SaasDomain() . '/' . $destination[array_key_last($destination)];
        }


        $fileName = "";

        if (!$file) {
            return $fileName;
        }

        $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();


        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0777, true, true);
        }

        $file->move($destination, $fileName);
        return $destination . $fileName;

    }
}

if (!function_exists('fileUpdate')) {
    function fileUpdate($databaseFile, $file, $destination)
    {
        $contains = Str::contains($destination, SaasDomain() . '/');
        if (!$contains) {
            $destination = explode('public/uploads/', $destination);
            $destination = $destination[0] . 'public/uploads/' . SaasDomain() . '/' . $destination[array_key_last($destination)];
        }

        $fileName = "";

        if ($file) {
            $fileName = fileUpload($file, $destination);

            if ($databaseFile && file_exists($databaseFile)) {

                unlink($databaseFile);

            }
        } elseif (!$file and $databaseFile) {
            $fileName = $databaseFile;
        }

        return $fileName;

    }
}
if (!function_exists('showPicName')) {
    function showPicName($data)
    {
        if (empty($data)) {
            return '';
        }
        $name = explode('/', $data);
        return $name[array_key_last($name)];
    }
}
if (!function_exists('vimeoVideoEmbed')) {
    function vimeoVideoEmbed($video_uri, $title, $height, $width)
    {
        // return '<iframe class="video_iframe" src="https://player.vimeo.com/video/'.showPicName($video_uri).'?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id='.env("VIMEO_APP_ID").'" width="'.$width.'" height="'.$height.'" frameborder="0" allow="autoplay; fullscreen" allowfullscreen title="LMS Basic"></iframe>';
        return '<iframe class="video_iframe" src="https://player.vimeo.com/video/' . showPicName($video_uri) . '?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=' . saasEnv("VIMEO_APP_ID") . '"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen title="LMS Basic"></iframe>';
    }
}


if (!function_exists('getSetting')) {
    function getSetting()
    {
        try {
            return app('getSetting');

        } catch (Exception $exception) {
            return false;
        }
    }
}
if (!function_exists('getVideoId')) {
    function getVideoId($v_id)
    {
        $video_id = explode("=", $v_id);
        return $video_id[array_key_last($video_id)];
    }
}
if (!function_exists('youtubeVideo')) {
    function youtubeVideo($video_url)
    {
        if (Str::contains($video_url, 'youtu.be')) {

            $url = explode("/", $video_url);
            return 'https://www.youtube.com/watch?v=' . ($url[3] ?? '');
        }

        if (Str::contains($video_url, '&')) {
            return substr($video_url, 0, strpos($video_url, "&"));
        } else {
            return $video_url;
        }


    }
}


if (!function_exists('isBookmarked')) {
    function isBookmarked($user_id, $course_id)
    {
        $bookmarked = BookmarkCourse::where('user_id', $user_id)->where('course_id', $course_id)->first();
        if ($bookmarked) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('cartItem')) {
    function cartItem()
    {
        if (Auth::check()) {

            return Cache::rememberForever('login_user_cart_sum' . Auth::id() . SaasDomain(), function () {
                return Cart::where('user_id', Auth::id())
                    ->when(isModuleActive('Appointment'), function ($query) {
                        $query->whereNotNull('course_id');
                    })
                    ->count();
            });


        } else if (session()->get('cart')) {
            if (isModuleActive('Store')) {
                $qty = 0;
                $is_store = [];
                foreach (session()->get('cart') as $key => $cart) {
                    $quantity = $cart['qty'] ?? 1;
                    $qty = $qty + @$quantity;
                    $is_store = $cart['is_store'] ?? false;
                }
                if ($is_store == 'store') {
                    return $qty;
                } else {
                    return count(session()->get('cart'));
                }
            } else {
                return count(session()->get('cart'));
            }
        } else {
            return 0;
        }
    }
}


if (!function_exists('totalWhiteList')) {
    function totalWhiteList()
    {
        if (Auth::check()) {
            $bookmarks = BookmarkCourse::where('user_id', Auth::id())->count();
            return $bookmarks;
        } else {
            return 0;
        }
    }
}


function send_php_mail($receiver_email, $receiver_name, $sender_email, $subject, $message)
{
    $headers = "From: <$sender_email> \r\n";
    $headers .= "Reply-To: " . Settings('site_title') . " <$sender_email> \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    return mail($receiver_email, $subject, $message, $headers);

}


if (!function_exists('checkCurrency')) {
    function checkCurrency($currency_code)
    {
        $currency = Currency::where('code', $currency_code)->first();
        if ($currency != null) {
            return true;
        }
        return null;
    }
}


if (!function_exists('showStatus')) {
    function showStatus($status)
    {
        if ($status == 1) {
            return 'Active';
        }
        return 'Inactive';
    }
}


if (!function_exists('permissionCheck')) {
    function permissionCheck($route_name)
    {
        if (auth()->check()) {
            if (auth()->user()->role_id == 1) {
                return TRUE;
            } else {

                if (isModuleActive('OrgInstructorPolicy')) {
                    if (auth()->user()->role_id == 2) {
                        $roles = app('policy_permission_list');
                        $role = $roles->where('id', auth()->user()->policy_id)->first();
                        /*
                                                    $allowRoutes = [
                                                        'dashboard',
                                                        'quiz',
                            //                            'quiz.test-list',
                            //                            'quiz.add-test',
                            //                            'quiz.edit-test',
                            //                            'quiz.delete-test',
                                                        'quiz.mark-test',
                                                        'quiz.supervisor',
                                                        'quiz.supervisor.extraTime',
                                                        'quiz.supervisor.warning',
                                                        'quiz.supervisor.continueDoTest',
                                                        'quiz.supervisor.comment',
                                                        'set-quiz.mark-register',
                                                        'quizReTest'
                                                    ];
                                                    if (in_array($route_name, $allowRoutes)) {
                                                        return true;
                                                    }*/

                    } else {
                        $roles = app('permission_list');
                        $role = $roles->where('id', auth()->user()->role_id)->first();

                    }
                    if ($role != null && $role->permissions->contains('route', $route_name)) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                } else {
                    $roles = app('permission_list');
                    $role = $roles->where('id', auth()->user()->role_id)->first();
                    if ($role != null && $role->permissions->contains('route', $route_name)) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                }

            }
        }
        return FALSE;
    }
}

//formats price to home default price with convertion
if (!function_exists('single_price')) {
    function single_price($price)
    {
        return getPriceFormat($price);
    }
}


//Messages
if (!function_exists('getConversations')) {
    function getConversations($messages)
    {
        $output = '';
        if ($messages) {
            foreach ($messages as $key => $message) {
                if ($message->sender_id == Auth::id()) {
                    $output .= '
                                <div class="single_message_chat">
                                    <div class="message_pre_left">
                                        <div class="message_preview_thumb">
                                            <img src="' . getProfileImage(@$message->sender->image, @$message->sender->name) . '" alt="">
                                        </div>
                                        <div class="messges_info">
                                            <h4>' . @$message->sender->name . '</h4>
                                            <p>' . @$message->created_at . '</p>
                                        </div>
                                    </div>
                                    <div class="message_content_view red_border">
                                        <p>' . @$message->message . '</p>
                                    </div>
                                </div>';
                } else {
                    $output .= '
                            <div class="single_message_chat sender_message">
                                <div class="message_pre_left">
                                    <div class="messges_info">
                                    <h4>' . @$message->sender->name . '</h4>
                                    <p>' . @$message->created_at . '</p>
                                    </div>
                                    <div class="message_preview_thumb">
                                    <img src="' . getProfileImage(@$message->sender->image, $message->sender->name) . '" alt="">
                                    </div>
                                </div>
                                <div class="message_content_view">
                                    <p>' . @$message->message . '</p>
                                </div>
                            </div>';
                }
            }
            return $output;
        } else {
            $message = trans("communication.Let's say Hi");
            $output = '<p class="NoMessageFound">' . $message . '!</p>';
        }
        return $output;

    }
}


// checking module enable/disable
if (!function_exists('checkModuleEnable')) {
    function checkModuleEnable($module = null, $name = null)
    {
        if ($name) {
            return true;
        } else {
            return false;
        }

    }
}


if (!function_exists('getHeaderCategories')) {
    function getHeaderCategories()
    {
        return Category::with('subcategories')->where('status', 1)->orderBy('position_order', 'ASC')->get();
    }
}


if (!function_exists('returnList')) {
    function returnList()
    {

        //version 5
        $list = [
            "fab fa-500px",
            "fab fa-accessible-icon",
            "fab fa-accusoft",
            "fas fa-address-book",
            "far fa-address-book",
            "fas fa-address-card",
            "far fa-address-card",
            "fas fa-adjust",
            "fab fa-adn",
            "fab fa-adversal",
            "fab fa-affiliatetheme",
            "fab fa-algolia",
            "fas fa-align-center",
            "fas fa-align-justify",
            "fas fa-align-left",
            "fas fa-align-right",
            "fab fa-amazon",
            "fas fa-ambulance",
            "fas fa-american-sign-language-interpreting",
            "fab fa-amilia",
            "fas fa-anchor",
            "fab fa-android",
            "fab fa-angellist",
            "fas fa-angle-double-down",
            "fas fa-angle-double-left",
            "fas fa-angle-double-right",
            "fas fa-angle-double-up",
            "fas fa-angle-down",
            "fas fa-angle-left",
            "fas fa-angle-right",
            "fas fa-angle-up",
            "fab fa-angrycreative",
            "fab fa-angular",
            "fab fa-app-store",
            "fab fa-app-store-ios",
            "fab fa-apper",
            "fab fa-apple",
            "fab fa-apple-pay",
            "fas fa-archive",
            "fas fa-arrow-alt-circle-down",
            "far fa-arrow-alt-circle-down",
            "fas fa-arrow-alt-circle-left",
            "far fa-arrow-alt-circle-left",
            "fas fa-arrow-alt-circle-right",
            "far fa-arrow-alt-circle-right",
            "fas fa-arrow-alt-circle-up",
            "far fa-arrow-alt-circle-up",
            "fas fa-arrow-circle-down",
            "fas fa-arrow-circle-left",
            "fas fa-arrow-circle-right",
            "fas fa-arrow-circle-up",
            "fas fa-arrow-down",
            "fas fa-arrow-left",
            "fas fa-arrow-right",
            "fas fa-arrow-up",
            "fas fa-arrows-alt",
            "fas fa-arrows-alt-h",
            "fas fa-arrows-alt-v",
            "fas fa-assistive-listening-systems",
            "fas fa-asterisk",
            "fab fa-asymmetrik",
            "fas fa-at",
            "fab fa-audible",
            "fas fa-audio-description",
            "fab fa-autoprefixer",
            "fab fa-avianex",
            "fab fa-aviato",
            "fab fa-aws",
            "fas fa-backward",
            "fas fa-balance-scale",
            "fas fa-ban",
            "fab fa-bandcamp",
            "fas fa-barcode",
            "fas fa-bars",
            "fas fa-bath",
            "fas fa-battery-empty",
            "fas fa-battery-full",
            "fas fa-battery-half",
            "fas fa-battery-quarter",
            "fas fa-battery-three-quarters",
            "fas fa-bed",
            "fas fa-beer",
            "fab fa-behance",
            "fab fa-behance-square",
            "fas fa-bell",
            "far fa-bell",
            "fas fa-bell-slash",
            "far fa-bell-slash",
            "fas fa-bicycle",
            "fab fa-bimobject",
            "fas fa-binoculars",
            "fas fa-birthday-cake",
            "fab fa-bitbucket",
            "fab fa-bitcoin",
            "fab fa-bity",
            "fab fa-black-tie",
            "fab fa-blackberry",
            "fas fa-blind",
            "fab fa-blogger",
            "fab fa-blogger-b",
            "fab fa-bluetooth",
            "fab fa-bluetooth-b",
            "fas fa-bold",
            "fas fa-bolt",
            "fas fa-bomb",
            "fas fa-book",
            "fas fa-bookmark",
            "far fa-bookmark",
            "fas fa-braille",
            "fas fa-briefcase",
            "fab fa-btc",
            "fas fa-bug",
            "fas fa-building",
            "far fa-building",
            "fas fa-bullhorn",
            "fas fa-bullseye",
            "fab fa-buromobelexperte",
            "fas fa-bus",
            "fab fa-buysellads",
            "fas fa-calculator",
            "fas fa-calendar",
            "far fa-calendar",
            "fas fa-calendar-alt",
            "far fa-calendar-alt",
            "fas fa-calendar-check",
            "far fa-calendar-check",
            "fas fa-calendar-minus",
            "far fa-calendar-minus",
            "fas fa-calendar-plus",
            "far fa-calendar-plus",
            "fas fa-calendar-times",
            "far fa-calendar-times",
            "fas fa-camera",
            "fas fa-camera-retro",
            "fas fa-car",
            "fas fa-caret-down",
            "fas fa-caret-left",
            "fas fa-caret-right",
            "fas fa-caret-square-down",
            "far fa-caret-square-down",
            "fas fa-caret-square-left",
            "far fa-caret-square-left",
            "fas fa-caret-square-right",
            "far fa-caret-square-right",
            "fas fa-caret-square-up",
            "far fa-caret-square-up",
            "fas fa-caret-up",
            "fas fa-cart-arrow-down",
            "fas fa-cart-plus",
            "fab fa-cc-amex",
            "fab fa-cc-apple-pay",
            "fab fa-cc-diners-club",
            "fab fa-cc-discover",
            "fab fa-cc-jcb",
            "fab fa-cc-mastercard",
            "fab fa-cc-paypal",
            "fab fa-cc-stripe",
            "fab fa-cc-visa",
            "fab fa-centercode",
            "fas fa-certificate",
            "fas fa-chart-area",
            "fas fa-chart-bar",
            "far fa-chart-bar",
            "fas fa-chart-line",
            "fas fa-chart-pie",
            "fas fa-check",
            "fas fa-check-circle",
            "far fa-check-circle",
            "fas fa-check-square",
            "far fa-check-square",
            "fas fa-chevron-circle-down",
            "fas fa-chevron-circle-left",
            "fas fa-chevron-circle-right",
            "fas fa-chevron-circle-up",
            "fas fa-chevron-down",
            "fas fa-chevron-left",
            "fas fa-chevron-right",
            "fas fa-chevron-up",
            "fas fa-child",
            "fab fa-chrome",
            "fas fa-circle",
            "far fa-circle",
            "fas fa-circle-notch",
            "fas fa-clipboard",
            "far fa-clipboard",
            "fas fa-clock",
            "far fa-clock",
            "fas fa-clone",
            "far fa-clone",
            "fas fa-closed-captioning",
            "far fa-closed-captioning",
            "fas fa-cloud",
            "fas fa-cloud-download-alt",
            "fas fa-cloud-upload-alt",
            "fab fa-cloudscale",
            "fab fa-cloudsmith",
            "fab fa-cloudversify",
            "fas fa-code",
            "fas fa-code-branch",
            "fab fa-codepen",
            "fab fa-codiepie",
            "fas fa-coffee",
            "fas fa-cog",
            "fas fa-cogs",
            "fas fa-columns",
            "fas fa-comment",
            "far fa-comment",
            "fas fa-comment-alt",
            "far fa-comment-alt",
            "fas fa-comments",
            "far fa-comments",
            "fas fa-compass",
            "far fa-compass",
            "fas fa-compress",
            "fab fa-connectdevelop",
            "fab fa-contao",
            "fas fa-copy",
            "far fa-copy",
            "fas fa-copyright",
            "far fa-copyright",
            "fab fa-cpanel",
            "fab fa-creative-commons",
            "fas fa-credit-card",
            "far fa-credit-card",
            "fas fa-crop",
            "fas fa-crosshairs",
            "fab fa-css3",
            "fab fa-css3-alt",
            "fas fa-cube",
            "fas fa-cubes",
            "fas fa-cut",
            "fab fa-cuttlefish",
            "fab fa-d-and-d",
            "fab fa-dashcube",
            "fas fa-database",
            "fas fa-deaf",
            "fab fa-delicious",
            "fab fa-deploydog",
            "fab fa-deskpro",
            "fas fa-desktop",
            "fab fa-deviantart",
            "fab fa-digg",
            "fab fa-digital-ocean",
            "fab fa-discord",
            "fab fa-discourse",
            "fab fa-dochub",
            "fab fa-docker",
            "fas fa-dollar-sign",
            "fas fa-dot-circle",
            "far fa-dot-circle",
            "fas fa-download",
            "fab fa-draft2digital",
            "fab fa-dribbble",
            "fab fa-dribbble-square",
            "fab fa-dropbox",
            "fab fa-drupal",
            "fab fa-dyalog",
            "fab fa-earlybirds",
            "fab fa-edge",
            "fas fa-edit",
            "far fa-edit",
            "fas fa-eject",
            "fas fa-ellipsis-h",
            "fas fa-ellipsis-v",
            "fab fa-ember",
            "fab fa-empire",
            "fas fa-envelope",
            "far fa-envelope",
            "fas fa-envelope-open",
            "far fa-envelope-open",
            "fas fa-envelope-square",
            "fab fa-envira",
            "fas fa-eraser",
            "fab fa-erlang",
            "fab fa-etsy",
            "fas fa-euro-sign",
            "fas fa-exchange-alt",
            "fas fa-exclamation",
            "fas fa-exclamation-circle",
            "fas fa-exclamation-triangle",
            "fas fa-expand",
            "fas fa-expand-arrows-alt",
            "fab fa-expeditedssl",
            "fas fa-external-link-alt",
            "fas fa-external-link-square-alt",
            "fas fa-eye",
            "fas fa-eye-dropper",
            "fas fa-eye-slash",
            "far fa-eye-slash",
            "fab fa-facebook",
            "fab fa-facebook-f",
            "fab fa-facebook-messenger",
            "fab fa-facebook-square",
            "fas fa-fast-backward",
            "fas fa-fast-forward",
            "fas fa-fax",
            "fas fa-female",
            "fas fa-fighter-jet",
            "fas fa-file",
            "far fa-file",
            "fas fa-file-alt",
            "far fa-file-alt",
            "fas fa-file-archive",
            "far fa-file-archive",
            "fas fa-file-audio",
            "far fa-file-audio",
            "fas fa-file-code",
            "far fa-file-code",
            "fas fa-file-excel",
            "far fa-file-excel",
            "fas fa-file-image",
            "far fa-file-image",
            "fas fa-file-pdf",
            "far fa-file-pdf",
            "fas fa-file-powerpoint",
            "far fa-file-powerpoint",
            "fas fa-file-video",
            "far fa-file-video",
            "fas fa-file-word",
            "far fa-file-word",
            "fas fa-film",
            "fas fa-filter",
            "fas fa-fire",
            "fas fa-fire-extinguisher",
            "fab fa-firefox",
            "fab fa-first-order",
            "fab fa-firstdraft",
            "fas fa-flag",
            "far fa-flag",
            "fas fa-flag-checkered",
            "fas fa-flask",
            "fab fa-flickr",
            "fab fa-fly",
            "fas fa-folder",
            "far fa-folder",
            "fas fa-folder-open",
            "far fa-folder-open",
            "fas fa-font",
            "fab fa-font-awesome",
            "fab fa-font-awesome-alt",
            "fab fa-font-awesome-flag",
            "fab fa-fonticons",
            "fab fa-fonticons-fi",
            "fab fa-fort-awesome",
            "fab fa-fort-awesome-alt",
            "fab fa-forumbee",
            "fas fa-forward",
            "fab fa-foursquare",
            "fab fa-free-code-camp",
            "fab fa-freebsd",
            "fas fa-frown",
            "far fa-frown",
            "fas fa-futbol",
            "far fa-futbol",
            "fas fa-gamepad",
            "fas fa-gavel",
            "fas fa-gem",
            "far fa-gem",
            "fas fa-genderless",
            "fab fa-get-pocket",
            "fab fa-gg",
            "fab fa-gg-circle",
            "fas fa-gift",
            "fab fa-git",
            "fab fa-git-square",
            "fab fa-github",
            "fab fa-github-alt",
            "fab fa-github-square",
            "fab fa-gitkraken",
            "fab fa-gitlab",
            "fab fa-gitter",
            "fas fa-glass-martini",
            "fab fa-glide",
            "fab fa-glide-g",
            "fas fa-globe",
            "fab fa-gofore",
            "fab fa-goodreads",
            "fab fa-goodreads-g",
            "fab fa-google",
            "fab fa-google-drive",
            "fab fa-google-play",
            "fab fa-google-plus",
            "fab fa-google-plus-g",
            "fab fa-google-plus-square",
            "fab fa-google-wallet",
            "fas fa-graduation-cap",
            "fab fa-gratipay",
            "fab fa-grav",
            "fab fa-gripfire",
            "fab fa-grunt",
            "fab fa-gulp",
            "fas fa-h-square",
            "fab fa-hacker-news",
            "fab fa-hacker-news-square",
            "fas fa-hand-lizard",
            "far fa-hand-lizard",
            "fas fa-hand-paper",
            "far fa-hand-paper",
            "fas fa-hand-peace",
            "far fa-hand-peace",
            "fas fa-hand-point-down",
            "far fa-hand-point-down",
            "fas fa-hand-point-left",
            "far fa-hand-point-left",
            "fas fa-hand-point-right",
            "far fa-hand-point-right",
            "fas fa-hand-point-up",
            "far fa-hand-point-up",
            "fas fa-hand-pointer",
            "far fa-hand-pointer",
            "fas fa-hand-rock",
            "far fa-hand-rock",
            "fas fa-hand-scissors",
            "far fa-hand-scissors",
            "fas fa-hand-spock",
            "far fa-hand-spock",
            "fas fa-handshake",
            "far fa-handshake",
            "fas fa-hashtag",
            "fas fa-hdd",
            "far fa-hdd",
            "fas fa-heading",
            "fas fa-headphones",
            "fas fa-heart",
            "far fa-heart",
            "fas fa-heartbeat",
            "fab fa-hire-a-helper",
            "fas fa-history",
            "fas fa-home",
            "fab fa-hooli",
            "fas fa-hospital",
            "far fa-hospital",
            "fab fa-hotjar",
            "fas fa-hourglass",
            "far fa-hourglass",
            "fas fa-hourglass-end",
            "fas fa-hourglass-half",
            "fas fa-hourglass-start",
            "fab fa-houzz",
            "fab fa-html5",
            "fab fa-hubspot",
            "fas fa-i-cursor",
            "fas fa-id-badge",
            "far fa-id-badge",
            "fas fa-id-card",
            "far fa-id-card",
            "fas fa-image",
            "far fa-image",
            "fas fa-images",
            "far fa-images",
            "fab fa-imdb",
            "fas fa-inbox",
            "fas fa-indent",
            "fas fa-industry",
            "fas fa-info",
            "fas fa-info-circle",
            "fab fa-instagram",
            "fab fa-internet-explorer",
            "fab fa-ioxhost",
            "fas fa-italic",
            "fab fa-itunes",
            "fab fa-itunes-note",
            "fab fa-jenkins",
            "fab fa-joget",
            "fab fa-joomla",
            "fab fa-js",
            "fab fa-js-square",
            "fab fa-jsfiddle",
            "fas fa-key",
            "fas fa-keyboard",
            "far fa-keyboard",
            "fab fa-keycdn",
            "fab fa-kickstarter",
            "fab fa-kickstarter-k",
            "fas fa-language",
            "fas fa-laptop",
            "fab fa-laravel",
            "fab fa-lastfm",
            "fab fa-lastfm-square",
            "fas fa-leaf",
            "fab fa-leanpub",
            "fas fa-lemon",
            "far fa-lemon",
            "fab fa-less",
            "fas fa-level-down-alt",
            "fas fa-level-up-alt",
            "fas fa-life-ring",
            "far fa-life-ring",
            "fas fa-lightbulb",
            "far fa-lightbulb",
            "fab fa-line",
            "fas fa-link",
            "fab fa-linkedin",
            "fab fa-linkedin-in",
            "fab fa-linode",
            "fab fa-linux",
            "fas fa-lira-sign",
            "fas fa-list",
            "fas fa-list-alt",
            "far fa-list-alt",
            "fas fa-list-ol",
            "fas fa-list-ul",
            "fas fa-location-arrow",
            "fas fa-lock",
            "fas fa-lock-open",
            "fas fa-long-arrow-alt-down",
            "fas fa-long-arrow-alt-left",
            "fas fa-long-arrow-alt-right",
            "fas fa-long-arrow-alt-up",
            "fas fa-low-vision",
            "fab fa-lyft",
            "fab fa-magento",
            "fas fa-magic",
            "fas fa-magnet",
            "fas fa-male",
            "fas fa-map",
            "far fa-map",
            "fas fa-map-marker",
            "fas fa-map-marker-alt",
            "fas fa-map-pin",
            "fas fa-map-signs",
            "fas fa-mars",
            "fas fa-mars-double",
            "fas fa-mars-stroke",
            "fas fa-mars-stroke-h",
            "fas fa-mars-stroke-v",
            "fab fa-maxcdn",
            "fab fa-medapps",
            "fab fa-medium",
            "fab fa-medium-m",
            "fas fa-medkit",
            "fab fa-medrt",
            "fab fa-meetup",
            "fas fa-meh",
            "far fa-meh",
            "fas fa-mercury",
            "fas fa-microchip",
            "fas fa-microphone",
            "fas fa-microphone-slash",
            "fab fa-microsoft",
            "fas fa-minus",
            "fas fa-minus-circle",
            "fas fa-minus-square",
            "far fa-minus-square",
            "fab fa-mix",
            "fab fa-mixcloud",
            "fab fa-mizuni",
            "fas fa-mobile",
            "fas fa-mobile-alt",
            "fab fa-modx",
            "fab fa-monero",
            "fas fa-money-bill-alt",
            "far fa-money-bill-alt",
            "fas fa-moon",
            "far fa-moon",
            "fas fa-motorcycle",
            "fas fa-mouse-pointer",
            "fas fa-music",
            "fab fa-napster",
            "fas fa-neuter",
            "fas fa-newspaper",
            "far fa-newspaper",
            "fab fa-nintendo-switch",
            "fab fa-node",
            "fab fa-node-js",
            "fab fa-npm",
            "fab fa-ns8",
            "fab fa-nutritionix",
            "fas fa-object-group",
            "far fa-object-group",
            "fas fa-object-ungroup",
            "far fa-object-ungroup",
            "fab fa-odnoklassniki",
            "fab fa-odnoklassniki-square",
            "fab fa-opencart",
            "fab fa-openid",
            "fab fa-opera",
            "fab fa-optin-monster",
            "fab fa-osi",
            "fas fa-outdent",
            "fab fa-page4",
            "fab fa-pagelines",
            "fas fa-paint-brush",
            "fab fa-palfed",
            "fas fa-paper-plane",
            "far fa-paper-plane",
            "fas fa-paperclip",
            "fas fa-paragraph",
            "fas fa-paste",
            "fab fa-patreon",
            "fas fa-pause",
            "fas fa-pause-circle",
            "far fa-pause-circle",
            "fas fa-paw",
            "fab fa-paypal",
            "fas fa-pen-square",
            "fas fa-pencil-alt",
            "fas fa-percent",
            "fab fa-periscope",
            "fab fa-phabricator",
            "fab fa-phoenix-framework",
            "fas fa-phone",
            "fas fa-phone-square",
            "fas fa-phone-volume",
            "fab fa-pied-piper",
            "fab fa-pied-piper-alt",
            "fab fa-pied-piper-pp",
            "fab fa-pinterest",
            "fab fa-pinterest-p",
            "fab fa-pinterest-square",
            "fas fa-plane",
            "fas fa-play",
            "fas fa-play-circle",
            "far fa-play-circle",
            "fab fa-playstation",
            "fas fa-plug",
            "fas fa-plus",
            "fas fa-plus-circle",
            "fas fa-plus-square",
            "far fa-plus-square",
            "fas fa-podcast",
            "fas fa-pound-sign",
            "fas fa-power-off",
            "fas fa-print",
            "fab fa-product-hunt",
            "fab fa-pushed",
            "fas fa-puzzle-piece",
            "fab fa-python",
            "fab fa-qq",
            "fas fa-qrcode",
            "fas fa-question",
            "fas fa-question-circle",
            "far fa-question-circle",
            "fab fa-quora",
            "fas fa-quote-left",
            "fas fa-quote-right",
            "fas fa-random",
            "fab fa-ravelry",
            "fab fa-react",
            "fab fa-rebel",
            "fas fa-recycle",
            "fab fa-red-river",
            "fab fa-reddit",
            "fab fa-reddit-alien",
            "fab fa-reddit-square",
            "fas fa-redo",
            "fas fa-redo-alt",
            "fas fa-registered",
            "far fa-registered",
            "fab fa-rendact",
            "fab fa-renren",
            "fas fa-reply",
            "fas fa-reply-all",
            "fab fa-replyd",
            "fab fa-resolving",
            "fas fa-retweet",
            "fas fa-road",
            "fas fa-rocket",
            "fab fa-rocketchat",
            "fab fa-rockrms",
            "fas fa-rss",
            "fas fa-rss-square",
            "fas fa-ruble-sign",
            "fas fa-rupee-sign",
            "fab fa-safari",
            "fab fa-sass",
            "fas fa-save",
            "far fa-save",
            "fab fa-schlix",
            "fab fa-scribd",
            "fas fa-search",
            "fas fa-search-minus",
            "fas fa-search-plus",
            "fab fa-searchengin",
            "fab fa-sellcast",
            "fab fa-sellsy",
            "fas fa-server",
            "fab fa-servicestack",
            "fas fa-share",
            "fas fa-share-alt",
            "fas fa-share-alt-square",
            "fas fa-share-square",
            "far fa-share-square",
            "fas fa-shekel-sign",
            "fas fa-shield-alt",
            "fas fa-ship",
            "fab fa-shirtsinbulk",
            "fas fa-shopping-bag",
            "fas fa-shopping-basket",
            "fas fa-shopping-cart",
            "fas fa-shower",
            "fas fa-sign-in-alt",
            "fas fa-sign-language",
            "fas fa-sign-out-alt",
            "fas fa-signal",
            "fab fa-simplybuilt",
            "fab fa-sistrix",
            "fas fa-sitemap",
            "fab fa-skyatlas",
            "fab fa-skype",
            "fab fa-slack",
            "fab fa-slack-hash",
            "fas fa-sliders-h",
            "fab fa-slideshare",
            "fas fa-smile",
            "far fa-smile",
            "fab fa-snapchat",
            "fab fa-snapchat-ghost",
            "fab fa-snapchat-square",
            "fas fa-snowflake",
            "far fa-snowflake",
            "fas fa-sort",
            "fas fa-sort-alpha-down",
            "fas fa-sort-alpha-up",
            "fas fa-sort-amount-down",
            "fas fa-sort-amount-up",
            "fas fa-sort-down",
            "fas fa-sort-numeric-down",
            "fas fa-sort-numeric-up",
            "fas fa-sort-up",
            "fab fa-soundcloud",
            "fas fa-space-shuttle",
            "fab fa-speakap",
            "fas fa-spinner",
            "fab fa-spotify",
            "fas fa-square",
            "far fa-square",
            "fab fa-stack-exchange",
            "fab fa-stack-overflow",
            "fas fa-star",
            "far fa-star",
            "fas fa-star-half",
            "far fa-star-half",
            "fab fa-staylinked",
            "fab fa-steam",
            "fab fa-steam-square",
            "fab fa-steam-symbol",
            "fas fa-step-backward",
            "fas fa-step-forward",
            "fas fa-stethoscope",
            "fab fa-sticker-mule",
            "fas fa-sticky-note",
            "far fa-sticky-note",
            "fas fa-stop",
            "fas fa-stop-circle",
            "far fa-stop-circle",
            "fab fa-strava",
            "fas fa-street-view",
            "fas fa-strikethrough",
            "fab fa-stripe",
            "fab fa-stripe-s",
            "fab fa-studiovinari",
            "fab fa-stumbleupon",
            "fab fa-stumbleupon-circle",
            "fas fa-subscript",
            "fas fa-subway",
            "fas fa-suitcase",
            "fas fa-sun",
            "far fa-sun",
            "fab fa-superpowers",
            "fas fa-superscript",
            "fab fa-supple",
            "fas fa-sync",
            "fas fa-sync-alt",
            "fas fa-table",
            "fas fa-tablet",
            "fas fa-tablet-alt",
            "fas fa-tachometer-alt",
            "fas fa-tag",
            "fas fa-tags",
            "fas fa-tasks",
            "fas fa-taxi",
            "fab fa-telegram",
            "fab fa-telegram-plane",
            "fab fa-tencent-weibo",
            "fas fa-terminal",
            "fas fa-text-height",
            "fas fa-text-width",
            "fas fa-th",
            "fas fa-th-large",
            "fas fa-th-list",
            "fab fa-themeisle",
            "fas fa-thermometer-empty",
            "fas fa-thermometer-full",
            "fas fa-thermometer-half",
            "fas fa-thermometer-quarter",
            "fas fa-thermometer-three-quarters",
            "fas fa-thumbs-down",
            "far fa-thumbs-down",
            "fas fa-thumbs-up",
            "far fa-thumbs-up",
            "fas fa-thumbtack",
            "fas fa-ticket-alt",
            "fas fa-times",
            "fas fa-times-circle",
            "far fa-times-circle",
            "fas fa-tint",
            "fas fa-toggle-off",
            "fas fa-toggle-on",
            "fas fa-trademark",
            "fas fa-train",
            "fas fa-transgender",
            "fas fa-transgender-alt",
            "fas fa-trash",
            "fas fa-trash-alt",
            "far fa-trash-alt",
            "fas fa-tree",
            "fab fa-trello",
            "fab fa-tripadvisor",
            "fas fa-trophy",
            "fas fa-truck",
            "fas fa-tty",
            "fab fa-tumblr",
            "fab fa-tumblr-square",
            "fas fa-tv",
            "fab fa-twitch",
            "fab fa-twitter",
            "fab fa-twitter-square",
            "fab fa-typo3",
            "fab fa-uber",
            "fab fa-uikit",
            "fas fa-umbrella",
            "fas fa-underline",
            "fas fa-undo",
            "fas fa-undo-alt",
            "fab fa-uniregistry",
            "fas fa-universal-access",
            "fas fa-university",
            "fas fa-unlink",
            "fas fa-unlock",
            "fas fa-unlock-alt",
            "fab fa-untappd",
            "fas fa-upload",
            "fab fa-usb",
            "fas fa-user",
            "far fa-user",
            "fas fa-user-circle",
            "far fa-user-circle",
            "fas fa-user-md",
            "fas fa-user-plus",
            "fas fa-user-secret",
            "fas fa-user-times",
            "fas fa-users",
            "fab fa-ussunnah",
            "fas fa-utensil-spoon",
            "fas fa-utensils",
            "fab fa-vaadin",
            "fas fa-venus",
            "fas fa-venus-double",
            "fas fa-venus-mars",
            "fab fa-viacoin",
            "fab fa-viadeo",
            "fab fa-viadeo-square",
            "fab fa-viber",
            "fas fa-video",
            "fab fa-vimeo",
            "fab fa-vimeo-square",
            "fab fa-vimeo-v",
            "fab fa-vine",
            "fab fa-vk",
            "fab fa-vnv",
            "fas fa-volume-down",
            "fas fa-volume-off",
            "fas fa-volume-up",
            "fab fa-vuejs",
            "fab fa-weibo",
            "fab fa-weixin",
            "fab fa-whatsapp",
            "fab fa-whatsapp-square",
            "fas fa-wheelchair",
            "fab fa-whmcs",
            "fas fa-wifi",
            "fab fa-wikipedia-w",
            "fas fa-window-close",
            "far fa-window-close",
            "fas fa-window-maximize",
            "far fa-window-maximize",
            "fas fa-window-minimize",
            "fas fa-window-restore",
            "far fa-window-restore",
            "fab fa-windows",
            "fas fa-won-sign",
            "fab fa-wordpress",
            "fab fa-wordpress-simple",
            "fab fa-wpbeginner",
            "fab fa-wpexplorer",
            "fab fa-wpforms",
            "fas fa-wrench",
            "fab fa-xbox",
            "fab fa-xing",
            "fab fa-xing-square",
            "fab fa-y-combinator",
            "fab fa-yahoo",
            "fab fa-yandex",
            "fab fa-yandex-international",
            "fab fa-yelp",
            "fas fa-yen-sign",
            "fab fa-yoast",
            "fab fa-youtube"
        ];
        $str = '';
        foreach ($list as $class) {
            $name = explode("-", $class);
            $name1 = explode($name[0] . '-', $class);
            $str .= '<option value="' . $class . '"><i class="' . $class . '"></i> ' . $name1[1] . ' </option>';
        }

        return $str;
    }
}
