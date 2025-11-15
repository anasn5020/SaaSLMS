<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendManage\Entities\FrontPage;

class AddSixHomePageInFrontendPage extends Migration
{
    public function up()
    {
        for ($i = 1; $i <= 6; $i++) {
            $fun = 'home' . $i;
            FrontPage::updateOrCreate(
                ['slug' => 'home' . $i],
                [
                    'name' => 'home' . $i,
                    'title' => 'Homepage V' . $i,
                    'sub_title' => '',
                    'details' => $this->$fun(),
                    'is_static' => 0,
                    'status' => 1
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    public function home1()
    {
        $html = '
<div
    data-type="component-text"
    data-preview="' . themeAsset('img/snippets/preview/home/1.jpg') . '"
    data-aoraeditor-title="HomePage V1" data-aoraeditor-categories="Home Page">
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="' . themeAsset('css/sections/homepage_v1.css') . '">
    <style>
                  :root {
                --system_primery_color: #2477FF;
                --system_primery_color_05: #2477FF0D;
                --system_primery_color_07: #2477FF12;
                --system_primery_color_08: #2477FF14;
                --system_primery_color_10: #2477FF1A;
                --system_primery_color_20: #2477FF33;
                --system_primery_color_30: #2477FF4D;
                --system_primery_color_50: #2477FF80;
                --system_primery_color_70: #2477FFB3;
                --system_secendory_color: #1F2B40;
                --system_secendory_color_10: #1F2B401A;
                --system_paragraph_color: #656A7B;
                --fontFamily1: \'Signika\', sans-serif;
                --fontFamily2: "Inter", sans-serif

            }
    </style>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._banner-light'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._category-v4'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            ' . view(theme('snippets.components._counter_v2'))->render() . '
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            ' . view(theme('snippets.components._course_section_v4'))->render() . '
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            ' . view(theme('snippets.components._reward-section'))->render() . '
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            ' . view(theme('snippets.components._quiz_section_v4'))->render() . '
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            ' . view(theme('snippets.components._testimonial_section_v4'))->render() . '
        </div>
    </div>';

        if (isModuleActive('Subscription')) {
            $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            ' . view(theme('snippets.components._price_section_v2'))->render() . '
        </div>
    </div>';
        }

        $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            ' . view(theme('snippets.components._about_v2'))->render() . '
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            ' . view(theme('snippets.components._popular_instructors_v4'))->render() . '
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            ' . view(theme('snippets.components._classes_section'))->render() . '
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            ' . view(theme('snippets.components._apk_section_light'))->render() . '
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            ' . view(theme('snippets.components._blog_section_v3'))->render() . '
        </div>
    </div>
</div>';

        return $html;
    }

    public function home2()
    {
        $html = '
<div
    data-type="component-text"
    data-preview="' . (function_exists('themeAsset') ? themeAsset('img/snippets/preview/home/2.jpg') : '') . '"
    data-aoraeditor-title="HomePage V2" data-aoraeditor-categories="Home Page">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="' . themeAsset('css/sections/homepage_v2.css') . '">';

        if (Settings('frontend_global_color_scheme') == "no" || !Settings('frontend_global_color_scheme')) {
            $html .= '
    <style>
       :root {
                --system_primery_color: #0096B7;

                --system_primery_color_05: #0096B70D;
                --system_primery_color_07: #0096B712;
                --system_primery_color_08: #0096B714;
                --system_primery_color_10: #0096B71A;
                --system_primery_color_20: #0096B733;
                --system_primery_color_30: #0096B74D;
                --system_primery_color_50: #0096B780;
                --system_primery_color_70: #0096B7B3;
                --bg_color: #CEE8FF;
                --system_secendory_color: #1F2B40;
                --system_secendory_color_10: #1F2B401A;
                --system_paragraph_color: #656A7B;
                --fontFamily1: "Oswald", sans-serif;
                --fontFamily2: "Inter", sans-serif;

            }
    </style>';
        }

        $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._banner-v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._about_v1'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._category-v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._course_section_v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._testimonial_section_v2'))->render();
        $html .= '   </div>
    </div>';

        if (isModuleActive('Subscription')) {
            $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
            $html .= view(theme('snippets.components._price_section'))->render();
            $html .= '   </div>
    </div>';
        }

        $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._quiz_section_v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._home_sponsor_success'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._popular_instructors_v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._classes_section'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._apk_section'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._blog_section_v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._reward-with-footer-v2'))->render();
        $html .= '   </div>
    </div>
</div>';
        return $html;
    }

    public function home3()
    {
        $html = '
<div
    data-type="component-text"
    data-preview="' . (function_exists('themeAsset') ? themeAsset('img/snippets/preview/home/3.jpg') : '') . '"
    data-aoraeditor-title="HomePage V3" data-aoraeditor-categories="Home Page">
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="' . themeAsset('css/sections/homepage_v3.css') . '">';

        if (Settings('frontend_global_color_scheme') == "no" || !Settings('frontend_global_color_scheme')) {
            $html .= '
    <style>
            :root {
                --system_primery_color: #4B64EC;
                --system_primery_color_05: #4B64EC0D;
                --system_primery_color_07: #4B64EC12;
                --system_primery_color_08: #4B64EC14;
                --system_primery_color_10: #4B64EC1A;
                --system_primery_color_20: #4B64EC33;
                --system_primery_color_30: #4B64EC4D;
                --system_primery_color_50: #4B64EC80;
                --system_primery_color_70: #4B64ECB3;
                --system_secendory_color: #1F2B40;
                --system_secendory_color_10: #1F2B401A;
                --system_paragraph_color: #656A7B;
                --bg_color: #ffffff;
                --fontFamily1: "Outfit", sans-serif;
                --fontFamily2: "Oswald", sans-serif;

            }
    </style>';
        }

        $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._banner-slider-v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._category-v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._course_section_featured'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._course_section_v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._testimonial_section_v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._quiz_section_v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._reward-with-footer-v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._classes_section_v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._popular_instructors_v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._apk_section_v3'))->render();
        $html .= '   </div>
    </div>
</div>';

        return $html;
    }

    public function home4()
    {
        $html = '
<div
    data-type="component-text"
    data-preview="' . (function_exists('themeAsset') ? themeAsset('img/snippets/preview/home/4.jpg') : '') . '"
    data-aoraeditor-title="HomePage V4" data-aoraeditor-categories="Home Page">
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="' . themeAsset('css/sections/homepage_v4.css') . '">';

        if (Settings('frontend_global_color_scheme') == "no" || !Settings('frontend_global_color_scheme')) {
            $html .= '
    <style>
        :root {
                --system_primery_color: #38485C;
                --system_primery_color_05: #38485C0D;
                --system_primery_color_07: #38485C12;
                --system_primery_color_08: #38485C14;
                --system_primery_color_10: #38485C1A;
                --system_primery_color_20: #38485C33;
                --system_primery_color_30: #38485C4D;
                --system_primery_color_50: #38485C80;
                --system_primery_color_70: #38485CB3;
                --system_secendory_color: #1F2B40;
                --system_secendory_color_10: #1F2B401A;
                --system_paragraph_color: #656A7B;

                --bg_color: #CEE8FF;
                --fontFamily1: "Inter", sans-serif;
                --fontFamily2: "Inter", sans-serif;
            }
    </style>';
        }

        $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._banner-v4'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._counter_v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._category-v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._course_section_v4'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._testimonial_section_v4'))->render();
        $html .= '   </div>
    </div>';

        if (isModuleActive('Subscription')) {
            $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
            $html .= view(theme('snippets.components._price_section_v2'))->render();
            $html .= '   </div>
    </div>';
        }

        $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._quiz_section_v4'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._about_v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._popular_instructors_v4'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._classes_section_v4'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._apk_section_v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._blog_section_v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._reward-with-footer-v1'))->render();
        $html .= '   </div>
    </div>
</div>';
        return $html;
    }

    public function home5()
    {
        $html = '
<div
    data-type="component-text"
    data-preview="' . (function_exists('themeAsset') ? themeAsset('img/snippets/preview/home/6.jpg') : '') . '"
    data-aoraeditor-title="HHomePage v5 (Dark)" data-aoraeditor-categories="Home Page">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="' . themeAsset('css/sections/homepage_v5.css') . '">';

        if (Settings('frontend_global_color_scheme') == "no" || !Settings('frontend_global_color_scheme')) {
            $html .= '
    <style>
          :root {
                --system_primery_color: #2477FF;
                --system_primery_color_05: #2477FF0D;
                --system_primery_color_07: #2477FF12;
                --system_primery_color_08: #2477FF14;
                --system_primery_color_10: #2477FF1A;
                --system_primery_color_20: #2477FF33;
                --system_primery_color_30: #2477FF4D;
                --system_primery_color_50: #2477FF80;
                --system_primery_color_70: #2477FFB3;
                --system_secendory_color: #F0F3F8;
                --bg_color: #292F3A;
                --system_secendory_color_10: #F0F3F81A;
                --fontFamily1: \'Outfit\', sans-serif;
                --fontFamily2: "Oswald", sans-serif;
            }
    </style>';
        }

        $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._banner-dark'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._category-dark'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._counter_v4'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._course_section_dark'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._reward-section_dark'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._quiz_section_v5'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._testimonial_section_v5'))->render();
        $html .= '   </div>
    </div>';

        if (isModuleActive('Subscription')) {
            $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
            $html .= view(theme('snippets.components._price_section_v3'))->render();
            $html .= '   </div>
    </div>';
        }

        $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._about_v4'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._popular_instructors_v5'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._classes_section_v4'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._apk_section_dark'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._blog_section_v4'))->render();
        $html .= '   </div>
         </div>
         </div>';
        return $html;
    }

    public function home6()
    {
        $html = '
<div
    data-type="component-text"
    data-preview="' . (function_exists('themeAsset') ? themeAsset('img/snippets/preview/home/7.jpg') : '') . '"
    data-aoraeditor-title="HomePage Gradient" data-aoraeditor-categories="Home Page">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="' . themeAsset('css/sections/homepage_v6.css') . '">
    <link rel="stylesheet" href="' . themeAsset('css/sections/gradient-style.css') . '">';

        if (Settings('frontend_global_color_scheme') == "no" || !Settings('frontend_global_color_scheme')) {
            $html .= '
    <style>
         :root {
                --system_primery_color: #4B64EC;
                --system_primery_color_0: #4B64EC00;
                --system_primery_color_05: #4B64EC0D;
                --system_primery_color_07: #4B64EC12;
                --system_primery_color_08: #4B64EC14;
                --system_primery_color_10: #4B64EC1A;
                --system_primery_color_20: #4B64EC33;
                --system_primery_color_30: #4B64EC4D;
                --system_primery_color_50: #4B64EC80;
                --system_primery_color_70: #4B64ECB3;
                --system_secendory_color: #1F2B40;
                --system_secendory_color_10: #1F2B401A;
                --system_paragraph_color: #656A7B;
                --sytem_gradient_2: #0C2FEF;
                --bg_color: #fff;
                --fontFamily1: "Oswald", sans-serif;
                --fontFamily2: "Plus Jakarta Sans", sans-serif;

            }
    </style>';
        }

        $html .= '
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._banner-slider-v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._category-v5'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._course_section_featured'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._course_section_v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._testimonial_section_v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._quiz_section_v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._reward-section_v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._classes_section_v2'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._popular_instructors_v3'))->render();
        $html .= '   </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">';
        $html .= view(theme('snippets.components._apk_section_v3'))->render();
        $html .= '   </div>
    </div>
</div>';
        return $html;
    }
}
