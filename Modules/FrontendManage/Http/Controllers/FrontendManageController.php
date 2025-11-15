<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\AboutPage;
use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use App\Traits\UploadMedia;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\FrontendManage\Entities\CourseSetting;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FrontendManage\Entities\HomeContent;
use Modules\FrontendManage\Entities\HomeSlider;
use Modules\FrontendManage\Entities\PrivacyPolicy;
use Modules\FrontendManage\Entities\TopbarSetting;
use Modules\SystemSetting\Entities\FrontendSetting;
use Modules\SystemSetting\Entities\SocialLink;
use Modules\SystemSetting\Entities\Testimonial;
use Throwable;

class FrontendManageController extends Controller
{
    use ImageStore, UploadMedia;

    public function index()
    {
        return 'Frontend Manage';
    }


    // HomeContent
    public function HomeContent()
    {
        try {
            if (function_exists('SaasDomain')) {
                $domain = SaasDomain();
            } else {
                $domain = 'main';
            }
            $home_content = app('getHomeContent');
            $pages = FrontPage::where('status', 1)->get();
            $blocks = Cache::rememberForever('homepage_block_positions' . $domain, function () {
                return DB::table('homepage_block_positions')->select(['id', 'block_name', 'order'])->orderBy('order', 'asc')->get();
            });

            return view('frontendmanage::home_content', compact('home_content', 'pages', 'blocks'));
        } catch (Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function HomeContentUpdate(Request $request)
    {
        $rules = [
            'slider_banner' => 'mimes:jpeg,jpg,bmp,png,svg,gif',
            'instructor_banner' => 'mimes:jpeg,jpg,bmp,png,svg,gif',
            'best_category_banner' => 'mimes:jpeg,jpg,bmp,png,svg,gif',
            'become_instructor_logo' => 'mimes:jpeg,jpg,bmp,png,svg,gif',
            'subscribe_logo' => 'mimes:jpeg,jpg,bmp,png,svg,gif',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        if (demoCheck()) {
            return redirect()->back();
        }
        try {

            if ($request->instructor_banner != null) {
                UpdateHomeContent('instructor_banner', $this->saveImage($request->instructor_banner));
            }
            if ($request->best_category_banner != null) {
                UpdateHomeContent('best_category_banner', $this->saveImage($request->best_category_banner));
            }

            if ($request->how_to_buy_logo1 != null) {
                UpdateHomeContent('how_to_buy_logo1', $this->saveImage($request->how_to_buy_logo1));
            }

            if ($request->how_to_buy_logo2 != null) {
                UpdateHomeContent('how_to_buy_logo2', $this->saveImage($request->how_to_buy_logo2));
            }

            if ($request->how_to_buy_logo3 != null) {
                UpdateHomeContent('how_to_buy_logo3', $this->saveImage($request->how_to_buy_logo3));
            }

            if ($request->how_to_buy_logo4 != null) {
                UpdateHomeContent('how_to_buy_logo4', $this->saveImage($request->how_to_buy_logo4));
            }
            if ($request->subscribe_logo != null) {
                UpdateHomeContent('subscribe_logo', $this->saveImage($request->subscribe_logo));
            }

            if ($request->become_instructor_logo != null) {
                UpdateHomeContent('become_instructor_logo', $this->saveImage($request->become_instructor_logo));
            }

            if ($request->slider_banner != null) {
                UpdateHomeContent('slider_banner', $this->saveImage($request->slider_banner));
            }


            if ($request->key_feature_logo1 != null) {
                UpdateHomeContent('key_feature_logo1', $this->saveImage($request->key_feature_logo1));
            }

            if ($request->key_feature_logo2 != null) {
                UpdateHomeContent('key_feature_logo2', $this->saveImage($request->key_feature_logo2));
            }

            if ($request->key_feature_logo3 != null) {
                UpdateHomeContent('key_feature_logo3', $this->saveImage($request->key_feature_logo3));
            }

            if ($request->banner_logo != null) {
                UpdateHomeContent('banner_logo', $this->saveImage($request->banner_logo));
            }
            if ($request->cta_img_upper != null) {
                UpdateHomeContent('cta_img_upper', $this->saveImage($request->cta_img_upper));
            }
            if ($request->cta_img_lower != null) {
                UpdateHomeContent('cta_img_lower', $this->saveImage($request->cta_img_lower));
            }

            $items = $request->except([
                'instructor_banner', 'best_category_banner',
                'how_to_buy_logo1', 'how_to_buy_logo2',
                'how_to_buy_logo3', 'how_to_buy_logo4',
                'subscribe_logo', 'key_feature_logo1',
                'key_feature_logo2', 'key_feature_logo3',
                'banner_logo', '_token', 'url', 'id',
                'become_instructor_logo', 'slider_banner',
                'cta_img_upper', 'cta_img_lower'
            ]);
            foreach ($items as $key => $item) {
                UpdateHomeContent($key, $item);
            }
            UpdateHomeContent('show_menu_search_box', $request->show_menu_search_box == 1 ? 1 : 0);
            UpdateHomeContent('show_subscription_plan', $request->show_subscription_plan == 1 ? 1 : 0);
            UpdateHomeContent('show_banner_search_box', $request->show_banner_search_box == 1 ? 1 : 0);
            UpdateHomeContent('show_key_feature', $request->show_key_feature == 1 ? 1 : 0);
            UpdateHomeContent('show_banner_section', $request->show_banner_section == 1 ? 1 : 0);
            UpdateHomeContent('show_category_section', $request->show_category_section == 1 ? 1 : 0);
            UpdateHomeContent('show_testimonial_section', $request->show_testimonial_section == 1 ? 1 : 0);
            UpdateHomeContent('show_live_class_section', $request->show_live_class_section == 1 ? 1 : 0);
            UpdateHomeContent('show_instructor_section', $request->show_instructor_section == 1 ? 1 : 0);
            UpdateHomeContent('show_course_section', $request->show_course_section == 1 ? 1 : 0);
            UpdateHomeContent('show_best_category_section', $request->show_best_category_section == 1 ? 1 : 0);
            UpdateHomeContent('show_quiz_section', $request->show_quiz_section == 1 ? 1 : 0);
            UpdateHomeContent('show_article_section', $request->show_article_section == 1 ? 1 : 0);
            UpdateHomeContent('show_subscribe_section', $request->show_subscribe_section == 1 ? 1 : 0);
            UpdateHomeContent('show_become_instructor_section', $request->show_become_instructor_section == 1 ? 1 : 0);
            UpdateHomeContent('show_sponsor_section', $request->show_sponsor_section == 1 ? 1 : 0);
            UpdateHomeContent('show_how_to_buy', $request->show_how_to_buy == 1 ? 1 : 0);
            UpdateHomeContent('show_home_page_faq', $request->show_home_page_faq == 1 ? 1 : 0);
            UpdateHomeContent('show_banner_subscription_box', $request->show_banner_subscription_box == 1 ? 1 : 0);
            UpdateHomeContent('show_why_choose', $request->show_why_choose == 1 ? 1 : 0);
            UpdateHomeContent('show_course_level', $request->show_course_level == 1 ? 1 : 0);
            UpdateHomeContent('show_popular_course', $request->show_popular_course == 1 ? 1 : 0);
            UpdateHomeContent('show_continue_watching', $request->show_continue_watching == 1 ? 1 : 0);
            UpdateHomeContent('show_contact_page_faq', $request->show_contact_page_faq == 1 ? 1 : 0);
            UpdateHomeContent('show_cta_section', $request->show_cta_section == 1 ? 1 : 0);

            GenerateHomeContent(SaasDomain());

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.homeContent');


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function showTopBarSettings()
    {
        try {
            $data = TopbarSetting::getData();
            return view('frontendmanage::topbarSetting', compact('data'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function showCourseSettings()
    {
        try {
            $data = CourseSetting::getData();
            return view('frontendmanage::courseSetting', compact('data'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function saveCourseSettings(Request $request)
    {
        // return $request;
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            if (isset($request->show_enrolled_or_level_section) && !isset($request->enrolled_or_level)) {
                Toastr::warning(trans('frontendmanage.Required Data Not Selected'), trans('common.Failed'));
                return redirect()->back();
            }
            $data = CourseSetting::getData();
            $data->show_rating = $request->show_rating;
            $data->show_cart = $request->show_cart;
            $data->show_enrolled_or_level_section = $request->show_enrolled_or_level_section;
            $data->enrolled_or_level = $request->enrolled_or_level;
            $data->show_cql_left_sidebar = $request->show_cql_left_sidebar;
            $data->size_of_grid = $request->size_of_grid;
            $data->show_mode_of_delivery = $request->show_mode_of_delivery;

            $data->show_review_option = $request->show_review_option;
            $data->show_rating_option = $request->show_rating_option;
            $data->show_search_in_category = $request->show_search_in_category;

            $data->show_instructor_rating = $request->show_instructor_rating;
            $data->show_instructor_review = $request->show_instructor_review;
            $data->show_instructor_enrolled = $request->show_instructor_enrolled;
            $data->show_instructor_courses = $request->show_instructor_courses;
            $data->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return view('frontendmanage::courseSetting', compact('data'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function saveTopBarSettings(Request $request)
    {
        // return $request;
        if (demoCheck()) {
            return redirect()->back();

        }
        try {
            $data = TopbarSetting::getData();

            $data->left_side_text_show = $request->left_side_text_show;
            $data->left_side_logo = $request->left_side_logo;
            $data->left_side_text = $request->left_side_text;
            $data->left_side_text_link = $request->left_side_text_link;

            $data->right_side_text_1_show = $request->right_side_text_1_show;
            $data->reight_side_logo_1 = $request->reight_side_logo_1;
            $data->right_side_text_1 = $request->right_side_text_1;
            $data->right_side_text_1_link = $request->right_side_text_1_link;

            $data->right_side_text_2_show = $request->right_side_text_2_show;
            $data->reight_side_logo_2 = $request->reight_side_logo_2;
            $data->right_side_text_2 = $request->right_side_text_2;
            $data->right_side_text_2_link = $request->right_side_text_2_link;

            $data->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return view('frontendmanage::topbarSetting', compact('data'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function ContactPageContent()
    {
        try {
            $page_content = app('getHomeContent');
            return view('frontendmanage::contact_page_content', compact('page_content'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function PageContent()
    {
        try {
            $page_content = HomeContent::with('value_media')->get();
            $data['breadcrumb_image'] = $page_content->where('key', 'breadcrumb_image')->first();
//            $data['course_page_banner'] = $page_content->where('key', 'course_page_banner')->first();
//            $data['class_page_banner'] = $page_content->where('key', 'class_page_banner')->first();
//            $data['quiz_page_banner'] = $page_content->where('key', 'quiz_page_banner')->first();
//            $data['instructor_page_banner'] = $page_content->where('key', 'instructor_page_banner')->first();
//            $data['become_instructor_page_banner'] = $page_content->where('key', 'become_instructor_page_banner')->first();
//            $data['about_page_banner'] = $page_content->where('key', 'about_page_banner')->first();
//            $data['subscription_page_banner'] = $page_content->where('key', 'subscription_page_banner')->first();
//            $data['forum_banner'] = $page_content->where('key', 'forum_banner')->first();
//            $data['blog_page_banner'] = $page_content->where('key', 'blog_page_banner')->first();
//            $data['saas_banner'] = $page_content->where('key', 'saas_banner')->first();
//            $data['offer_page_banner'] = $page_content->where('key', 'offer_page_banner')->first();
             return view('frontendmanage::page_content', $data, compact('page_content'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function PageContentUpdate(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            if ($request->breadcrumb_image != null) {
                $item = HomeContent::where('key', 'breadcrumb_image')->firstOrNew([
                    'key' => 'breadcrumb_image',
                ]);
                $item->value = null;
                $item->save();
                $this->removeLink($item->id, get_class($item));
                UpdateHomeContent('breadcrumb_image', $this->generateLink($request->breadcrumb_image, $item->id, get_class($item), 'value'));
            }
/*
            if ($request->blog_page_banner != null) {
                $item = HomeContent::where('key', 'blog_page_banner')->firstOrNew([
                    'key' => 'blog_page_banner',
                ]);
                $item->value = null;
                $item->save();
                $this->removeLink($item->id, get_class($item));
                UpdateHomeContent('blog_page_banner', $this->generateLink($request->blog_page_banner, $item->id, get_class($item), 'value'));

            }
            if ($request->about_page_banner != null) {
                $item = HomeContent::where('key', 'about_page_banner')->firstOrNew([
                    'key'=>'about_page_banner',
                ]);
                    $item->value = null;
                    $item->save();
                    $this->removeLink($item->id, get_class($item));
                    UpdateHomeContent('about_page_banner', $this->generateLink($request->about_page_banner, $item->id, get_class($item), 'value'));
            }
            if ($request->instructor_page_banner != null) {
                $item = HomeContent::where('key', 'instructor_page_banner')->firstOrNew([
                    'key'=>'instructor_page_banner',
                ]);
                $item->value = null;
                $item->save();
                $this->removeLink($item->id, get_class($item));
                UpdateHomeContent('instructor_page_banner', $this->generateLink($request->instructor_page_banner, $item->id, get_class($item), 'value'));
            }
            if ($request->become_instructor_page_banner != null) {
                $item = HomeContent::where('key', 'become_instructor_page_banner')->firstOrNew([
                    'key' => 'become_instructor_page_banner'
                ]);
                    $item->value = null;
                    $item->save();
                    $this->removeLink($item->id, get_class($item));
                    UpdateHomeContent('become_instructor_page_banner', $this->generateLink($request->become_instructor_page_banner, $item->id, get_class($item), 'value'));

            }
            if ($request->quiz_page_banner != null) {
                $item = HomeContent::where('key', 'quiz_page_banner')->firstOrNew([
                    'key' => 'quiz_page_banner'
                ]);
                    $item->value = null;
                    $item->save();
                    $this->removeLink($item->id, get_class($item));
                    UpdateHomeContent('quiz_page_banner', $this->generateLink($request->quiz_page_banner, $item->id, get_class($item), 'value'));

            }
            if ($request->class_page_banner != null) {
                $item = HomeContent::where('key', 'class_page_banner')->firstOrNew([
                    'key' => 'class_page_banner'
                ]);
                    $item->value = null;
                    $item->save();
                    $this->removeLink($item->id, get_class($item));
                    UpdateHomeContent('class_page_banner', $this->generateLink($request->class_page_banner, $item->id, get_class($item), 'value'));

            }
            if ($request->course_page_banner != null) {
                $item = HomeContent::where('key', 'course_page_banner')->firstOrNew([
                    'key' => 'course_page_banner'
                ]);
                    $item->value = null;
                    $item->save();
                    $this->removeLink($item->id, get_class($item));
                    UpdateHomeContent('course_page_banner', $this->generateLink($request->course_page_banner, $item->id, get_class($item), 'value'));

            }
            if ($request->saas_banner != null) {
                $item = HomeContent::where('key', 'saas_banner')->firstOrNew([
                    'key' => 'saas_banner'
                ]);
                    $item->value = null;
                    $item->save();
                    $this->removeLink($item->id, get_class($item));
                    UpdateHomeContent('saas_banner', $this->generateLink($request->saas_banner, $item->id, get_class($item), 'value'));

            }
            if ($request->offer_page_banner != null) {
                $item = HomeContent::where('key', 'offer_page_banner')->firstOrNew([
                    'key' => 'offer_page_banner'
                ]);
                    $item->value = null;
                    $item->save();
                    $this->removeLink($item->id, get_class($item));
                    UpdateHomeContent('offer_page_banner', $this->generateLink($request->offer_page_banner, $item->id, get_class($item), 'value'));

            }   if ($request->forum_banner != null) {
                $item = HomeContent::where('key', 'forum_banner')->firstOrNew([
                    'key' => 'forum_banner'
                ]);
                    $item->value = null;
                    $item->save();
                    $this->removeLink($item->id, get_class($item));
                    UpdateHomeContent('forum_banner', $this->generateLink($request->forum_banner, $item->id, get_class($item), 'value'));

            }

            if (isModuleActive('Subscription')) {
                UpdateHomeContent('subscription_page_title', $request->subscription_page_title);
                UpdateHomeContent('subscription_page_sub_title', $request->subscription_page_sub_title);
                if ($request->subscription_page_banner != null) {
                    $item = HomeContent::where('key', 'subscription_page_banner')->firstOrNew([
                        'key' => 'subscription_page_banner'
                    ]);
                        $item->value = null;
                        $item->save();
                        $this->removeLink($item->id, get_class($item));
                        UpdateHomeContent('subscription_page_banner', $this->generateLink($request->subscription_page_banner, $item->id, get_class($item), 'value'));

                }
            }


            $items = $request->except([
                'blog_page_banner', 'about_page_banner',
                'instructor_page_banner', 'become_instructor_page_banner',
                'quiz_page_banner', 'class_page_banner',
                'course_page_banner', 'subscription_page_banner', 'saas_banner'
            ]);
            $ignore = ['_token', 'url'];
            foreach ($items as $key => $item) {
                if (in_array($key, $ignore)) {
                    continue;
                }
                UpdateHomeContent($key, $item);
            }*/

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.pageContent');


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }


    public function ContactPageContentUpdate(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {


            $items = $request->except([
                'show_map', 'contact_page_body_image',
                'contact_page_banner', 'contact_page_phone',
                'contact_page_email', 'contact_page_address',
                'show_contact_page_faq'
            ]);
            $ignore = ['_token', 'url'];

            foreach ($items as $key => $item) {
                if (in_array($key, $ignore)) {
                    continue;
                }
                UpdateHomeContent($key, $item);
            }

            UpdateHomeContent('show_map', $request->show_map == 1 ? 1 : 0);
            UpdateHomeContent('show_contact_page_faq', $request->show_contact_page_faq == 1 ? 1 : 0);


            if ($request->contact_page_body_image != null) {
                UpdateHomeContent('contact_page_body_image', $this->saveImage($request->contact_page_body_image));
            }
            if ($request->contact_page_banner != null) {
                UpdateHomeContent('contact_page_banner', $this->saveImage($request->contact_page_banner));
            }
            if ($request->contact_page_phone != null) {
                UpdateHomeContent('contact_page_phone', $this->saveImage($request->contact_page_phone));
            }
            if ($request->contact_page_email != null) {
                UpdateHomeContent('contact_page_email', $this->saveImage($request->contact_page_email));
            }
            if ($request->contact_page_address != null) {
                UpdateHomeContent('contact_page_address', $this->saveImage($request->contact_page_address));
            }


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function PrivacyPolicy()
    {
        try {
            $privacy_policy = PrivacyPolicy::first();
            return view('frontendmanage::privacy_policy', compact('privacy_policy'));
        } catch (Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function PrivacyPolicyUpdate(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        // return $request;

        try {
            $privacy_policy = PrivacyPolicy::find($request->id);

            foreach ((array)$request->details as $key => $details) {
                $privacy_policy->setTranslation('details', $key, $details);
            }

            foreach ((array)$request->page_banner_title as $key => $title) {
                $privacy_policy->setTranslation('page_banner_title', $key, $title);
            }

            foreach ((array)$request->page_banner_sub_title as $key => $sub) {
                $privacy_policy->setTranslation('page_banner_sub_title', $key, $sub);
            }
            $privacy_policy->page_banner_status = !empty($request->page_banner_status) ? $request->page_banner_status : 0;


            if ($request->page_banner != null) {
                $privacy_policy->page_banner = $this->saveImage($request->page_banner);
            }

            $privacy_policy->save();
            if ($privacy_policy) {
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function testimonials()
    {
        try {
            $data['testimonials'] = Testimonial::latest()->get();
            return view('frontendmanage::testimonials', $data);
        } catch (Throwable $th) {

            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function testimonials_store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $code = auth()->user()->language_code;

        $rules = [
            'body.' . $code => 'required',
            'author.' . $code => 'required',
            'profession.' . $code => 'required',
            'image' => 'required',

        ];
        $this->validate($request, $rules, validationMessage($rules));
        try {
            $testimonial = new Testimonial();

            foreach ($request->body as $key => $body) {
                $testimonial->setTranslation('body', $key, $body);
            }
            foreach ($request->author as $key => $author) {
                $testimonial->setTranslation('author', $key, $author);
            }


            foreach ($request->profession as $key => $profession) {
                $testimonial->setTranslation('profession', $key, $profession);
            }
            $testimonial->star = $request->star;

            $testimonial->status = (int)$request->status;
            $testimonial->save();

            if ($request->image) {
                $testimonial->image = $this->generateLink($request->image, $testimonial->id, get_class($testimonial), 'image');
            }
            $testimonial->save();


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.testimonials');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function testimonials_update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'body' => 'required',
            'author' => 'required',
            'profession' => 'required',

        ];

        $this->validate($request, $rules, validationMessage($rules));


        try {
            $testimonial = Testimonial::find($request->id);
            foreach ($request->body as $key => $body) {
                $testimonial->setTranslation('body', $key, $body);
            }
            foreach ($request->author as $key => $author) {
                $testimonial->setTranslation('author', $key, $author);
            }
            foreach ($request->profession as $key => $profession) {
                $testimonial->setTranslation('profession', $key, $profession);
            }
            $testimonial->star = $request->star;


            $testimonial->image = null;

            $testimonial->status = (int)$request->status;
            $testimonial->save();

            $this->removeLink($testimonial->id, get_class($testimonial));
            if ($request->image) {
                $testimonial->image = $this->generateLink($request->image, $testimonial->id, get_class($testimonial), 'image');
            }
            $testimonial->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.testimonials');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function testimonials_edit($id)
    {
        try {
            $data['testimonials'] = Testimonial::latest()->get();
            $edit = Testimonial::find($id);
            return view('frontendmanage::testimonials', $data, compact('edit'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function testimonials_delete($id)
    {
        if (demoCheckById($id,[1,2,3,4,5])) {
            return redirect()->back();
        }
        try {
            $testimonial = Testimonial::find($id);
            $testimonial->delete();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.testimonials');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function sectionSetting()
    {
        try {
            $data['frontends'] = FrontendSetting::whereNotIn('id', [1, 2])->latest()->get();
            return view('frontendmanage::sectionSetting', compact('data'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function sectionSettingEdit($id)
    {
        try {
            $edit = FrontendSetting::find($id);
            $data['frontends'] = FrontendSetting::whereNotIn('id', [1, 2])->latest()->get();

            return view('frontendmanage::sectionSetting', compact('data', 'edit'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function sectionSetting_update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required',
            'description' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $frontend = FrontendSetting::find($request->id);
            $frontend->title = $request->title;
            $frontend->description = $request->description;
            $frontend->btn_name = $request->btn_name;
            $frontend->btn_link = $request->btn_link;
            $frontend->url = $request->url;
            if ($request->icon) {
                $frontend->icon = $request->icon;
            }
            $frontend->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.sectionSetting');

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function socialSetting()
    {
        try {
            $data['social_links'] = SocialLink::latest()->get();
            return view('frontendmanage::socialSetting', compact('data'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function socialSettingEdit($id)
    {
        try {
            $data['social_links'] = SocialLink::latest()->get();
            $edit = SocialLink::find($id);
            return view('frontendmanage::socialSetting', compact('data', 'edit'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function socialSettingDelete($id)
    {
        if (demoCheckById($id,[1,2,3,4,5])) {
            return redirect()->back();
        }
        try {

            $delete = SocialLink::find($id)->delete();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect('frontend/social-setting');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function AboutPage()
    {
        $about = AboutPage::getData();
        return view('frontendmanage::about', compact('about'));
    }

    public function saveAboutPage(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            'live_class_image' => 'required|mimes:jpeg,bmp,png,jpg,svg,gif',
            'counter_bg' => 'required|mimes:jpeg,bmp,png,jpg,svg,gif'
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $about = AboutPage::first();

            foreach ((array)$request->who_we_are as $key => $who_we_are) {
                $about->setTranslation('who_we_are', $key, $who_we_are);
            }
            foreach ((array)$request->banner_title as $key => $banner_title) {
                $about->setTranslation('banner_title', $key, $banner_title);
            }
            foreach ((array)$request->story_title as $key => $value) {
                $about->setTranslation('story_title', $key, $value);
            }
            foreach ((array)$request->story_description as $key => $value) {
                $about->setTranslation('story_description', $key, $value);
            }
            foreach ((array)$request->teacher_title as $key => $value) {
                $about->setTranslation('teacher_title', $key, $value);
            }

            foreach ((array)$request->teacher_details as $key => $value) {
                $about->setTranslation('teacher_details', $key, $value);
            }
            foreach ((array)$request->course_title as $key => $value) {
                $about->setTranslation('course_title', $key, $value);
            }

            foreach ((array)$request->course_details as $key => $value) {
                $about->setTranslation('course_details', $key, $value);
            }
            foreach ((array)$request->student_title as $key => $value) {
                $about->setTranslation('student_title', $key, $value);
            }
            foreach ((array)$request->student_details as $key => $value) {
                $about->setTranslation('student_details', $key, $value);
            }
            foreach ((array)$request->total_student as $key => $value) {
                $about->setTranslation('total_student', $key, $value);
            }
            foreach ((array)$request->total_teacher as $key => $value) {
                $about->setTranslation('total_teacher', $key, $value);
            }
            foreach ((array)$request->total_courses as $key => $value) {
                $about->setTranslation('total_courses', $key, $value);
            }


            foreach ((array)$request->about_page_content_title as $key => $value) {
                $about->setTranslation('about_page_content_title', $key, $value);
            }

            foreach ((array)$request->about_page_content_details as $key => $value) {
                $about->setTranslation('about_page_content_details', $key, $value);
            }
            foreach ((array)$request->about_page_content_details2 as $key => $value) {
                $about->setTranslation('about_page_content_details2', $key, $value);
            }

            foreach ((array)$request->live_class_title as $key => $value) {
                $about->setTranslation('live_class_title', $key, $value);
            }

            foreach ((array)$request->live_class_details as $key => $value) {
                $about->setTranslation('live_class_details', $key, $value);
            }
            foreach ((array)$request->sponsor_title as $key => $value) {
                $about->setTranslation('sponsor_title', $key, $value);
            }

            foreach ((array)$request->sponsor_sub_title as $key => $value) {
                $about->setTranslation('sponsor_sub_title', $key, $value);
            }

            foreach ((array)$request->registered_students as $key => $value) {
                $about->setTranslation('registered_students', $key, $value);
            }

            foreach ((array)$request->questions_answers as $key => $value) {
                $about->setTranslation('questions_answers', $key, $value);
            }

            foreach ((array)$request->quality_content as $key => $value) {
                $about->setTranslation('quality_content', $key, $value);
            }

            foreach ((array)$request->our_mission as $key => $value) {
                $about->setTranslation('our_mission', $key, $value);
            }

            foreach ((array)$request->our_vision as $key => $value) {
                $about->setTranslation('our_vision', $key, $value);
            }


            $about->show_testimonial = $request->show_testimonial;
            $about->show_brand = $request->show_brand;
            $about->show_become_instructor = $request->show_become_instructor;


            if ($request->image1 != null) {
                $about->image1 = $this->saveImage($request->image1);
            }

            if ($request->image2 != null) {

                $about->image2 = $this->saveImage($request->image2);
            }


            if ($request->image3 != null) {

                $about->image3 = $this->saveImage($request->image3);
            }

            if ($request->image4 != null) {

                $about->image4 = $this->saveImage($request->image4);
            }

            if ($request->live_class_image != null) {

                $url5 = $this->saveImage($request->live_class_image);

                $about->live_class_image = $url5;
            }

            if ($request->counter_bg != null) {

                $url5 = $this->saveImage($request->counter_bg);

                $about->counter_bg = $url5;
            }

            $about->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function socialSettingSave(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        // return $request;

        $rules = [
            'icon' => 'required',
            'name' => 'required',
            'btn_link' => 'required',
            'status' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));


        try {
            $social_link = new SocialLink();
            $social_link->icon = $request->icon;
            $social_link->name = $request->name;
            $social_link->link = $request->btn_link;
            $social_link->status = $request->status;
            $social_link->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function socialSettingUpdate(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = ['id' => 'required',
            'name' => 'required',
            'icon' => 'required',
            'btn_link' => 'required',
            'status' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));


        try {
            $social_link = SocialLink::find($request->id);
            $social_link->icon = $request->icon;
            $social_link->name = $request->name;
            $social_link->link = $request->btn_link;
            $social_link->status = $request->status;
            $social_link->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect('frontend/social-setting');

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function changeHomePageBlockOrder(Request $request)
    {
        if (function_exists('SaasDomain')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }
        $ids = $request->get('ids');

        foreach ($ids as $index => $id) {
            DB::table('homepage_block_positions')->where('id', $id)->limit(1)->update(['order' => $index]);
        }
        Cache::forget('homepage_block_positions' . SaasDomain());
        return Cache::rememberForever('homepage_block_positions' . $domain, function () {
            return DB::table('homepage_block_positions')->select(['id', 'block_name', 'order'])->orderBy('order', 'asc')->get();
        });
    }
}
