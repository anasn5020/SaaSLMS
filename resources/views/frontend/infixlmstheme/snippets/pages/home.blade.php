
<div
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/7.jpg')}}"
    data-aoraeditor-title="Homepage Default" data-aoraeditor-categories="Home Page">
    <link rel="stylesheet" href="{{themeAsset('css/sections/homepage_v7.css')}}">
    @if(Settings('frontend_global_color_scheme')=="no" || !Settings('frontend_global_color_scheme'))
        <style>
            :root {
                --system_primary_gredient1: #660AFB;
                --system_primary_gredient2: #BF37FF;
                --system_primary_color: linear-gradient(77.16deg, var(--system_primary_gredient1) 13.44%, var(--system_primary_gredient2) 87.24%);
                --system_secendary_color: #1F2B40;
                --fontFamily1: "Plus Jakarta Sans", sans-serif;
                --fontFamily2: "Inter", sans-serif;
            }

        </style>
    @endif
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_banner_v7'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_featured_section_v7'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_category_section_v7'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_course_section_v7'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_client_section_v7'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_testimonial_section_v7'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_latest_course_section_v7'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_instructor_section_v7'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_faq_section_v7'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_cta_section_v7'))
        </div>
    </div>
</div>

<div
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/1.jpg')}}"
    data-aoraeditor-title="HomePage V1" data-aoraeditor-categories="Home Page">
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{themeAsset('css/sections/homepage_v1.css')}}">
    @if(Settings('frontend_global_color_scheme')=="no" || !Settings('frontend_global_color_scheme'))
        <style>
            :root {
                --system_primery_gredient1: #2477FF;
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
                --fontFamily1: 'Signika', sans-serif;
                --fontFamily2: "Inter", sans-serif
            }

        </style>
    @endif
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._banner-light'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._category-v4'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._counter_v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._course_section_v4'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._reward-section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._quiz_section_v4'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._testimonial_section_v4'))
        </div>
    </div>
    @if(isModuleActive('Subscription'))
        <div class="row">
            <div class="col-sm-12 ui-resizable" data-type="container-content">
                @include(theme('snippets.components._price_section_v2'))
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._about_v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._popular_instructors_v4'))
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._classes_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._apk_section_light'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._blog_section_v3'))
        </div>
    </div>
</div>

<div
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/2.jpg')}}"
    data-aoraeditor-title="HomePage V2" data-aoraeditor-categories="Home Page">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{themeAsset('css/sections/homepage_v2.css')}}">
    @if(Settings('frontend_global_color_scheme')=="no" || !Settings('frontend_global_color_scheme'))
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

        </style>
    @endif
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._banner-v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._about_v1'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._category-v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._course_section_v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._testimonial_section_v2'))
        </div>
    </div>

    @if(isModuleActive('Subscription'))
        <div class="row">
            <div class="col-sm-12 ui-resizable" data-type="container-content">
                @include(theme('snippets.components._price_section'))
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._quiz_section_v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_sponsor_success'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._popular_instructors_v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._become_instructor_section_v2'))
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._classes_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._apk_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._blog_section_v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._reward-with-footer-v2'))
        </div>
    </div>
</div>

<div
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/3.jpg')}}"
    data-aoraeditor-title="HomePage V3" data-aoraeditor-categories="Home Page">
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{themeAsset('css/sections/homepage_v3.css')}}">
    @if(Settings('frontend_global_color_scheme')=="no" || !Settings('frontend_global_color_scheme'))
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
                --fontFamily1: "Signika", sans-serif;
                --fontFamily2: "Inter", sans-serif;
            }

        </style>
    @endif
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._banner-slider-v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._category-v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._course_section_featured'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._course_section_v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._testimonial_section_v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._quiz_section_v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._reward-with-footer-v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._classes_section_v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._popular_instructors_v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._apk_section_v3'))
        </div>
    </div>
</div>


<div
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/4.jpg')}}"
    data-aoraeditor-title="HomePage V4" data-aoraeditor-categories="Home Page">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{themeAsset('css/sections/homepage_v4.css')}}">
    @if(Settings('frontend_global_color_scheme')=="no" || !Settings('frontend_global_color_scheme'))
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
        </style>
    @endif
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._banner-v4'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._counter_v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._category-v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._course_section_v4'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._testimonial_section_v4'))
        </div>
    </div>
    @if(isModuleActive('Subscription'))
        <div class="row">
            <div class="col-sm-12 ui-resizable" data-type="container-content">
                @include(theme('snippets.components._price_section_v2'))
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._quiz_section_v4'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._about_v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._popular_instructors_v4'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._become_instructor_section_v4'))
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._classes_section_v4'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._apk_section_v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._blog_section_v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._reward-with-footer-v1'))
        </div>
    </div>
</div>

<div
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/5.jpg')}}"
    data-aoraeditor-title="HomePage v5 (Dark)" data-aoraeditor-categories="Home Page">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{themeAsset('css/sections/homepage_v5.css')}}">
    @if(Settings('frontend_global_color_scheme')=="no" || !Settings('frontend_global_color_scheme'))
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
                --fontFamily1: 'Outfit', sans-serif;
                --fontFamily2: "Oswald", sans-serif;
            }

        </style>
    @endif
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._banner-dark'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._category-dark'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._counter_v4'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._course_section_dark'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._reward-section_dark'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._quiz_section_v5'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._testimonial_section_v5'))
        </div>
    </div>
    @if(isModuleActive('Subscription'))
        <div class="row">
            <div class="col-sm-12 ui-resizable" data-type="container-content">
                @include(theme('snippets.components._price_section_v3'))
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._about_v4'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._popular_instructors_v5'))
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._classes_section_v4'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._apk_section_dark'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._blog_section_v4'))
        </div>
    </div>
</div>

<div
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/6.jpg')}}"
    data-aoraeditor-title="HomePage v6 (Gradient)" data-aoraeditor-categories="Home Page">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="{{themeAsset('css/sections/homepage_v6.css')}}">
    <link rel="stylesheet" href="{{themeAsset('css/sections/gradient-style.css')}}">
    @if(Settings('frontend_global_color_scheme')=="no" || !Settings('frontend_global_color_scheme'))
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
                --system_primery_gredient2: #0C2FEF;
                --bg_color: #fff;
                --fontFamily1: "Oswald", sans-serif;
                --fontFamily2: "Plus Jakarta Sans", sans-serif;
            }

        </style>
    @endif
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._banner-slider-v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._category-v5'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._course_section_featured'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._course_section_v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._testimonial_section_v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._quiz_section_v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._reward-section_v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._classes_section_v2'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._popular_instructors_v3'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._apk_section_v3'))
        </div>
    </div>
</div>

<div
    class="full-page"
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/all_section.jpg')}}"
    data-aoraeditor-title="Homepage v7" data-aoraeditor-categories="Home Page">
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_banner'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_category_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_instructor_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_course_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_best_category_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_quiz_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">

            @include(theme('snippets.components._home_page_testimonial_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_sponsor'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_blog_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_become_instructor_section'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_how_to_buy'))
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ui-resizable" data-type="container-content">
            @include(theme('snippets.components._home_page_faq'))
        </div>
    </div>

</div>


@include(theme('snippets.components._home_page_banner'))
@include(theme('snippets.components._banner-slider-v2'))
@include(theme('snippets.components._banner-slider-v3'))
@include(theme('snippets.components._banner-v2'))
@include(theme('snippets.components._banner-v3'))
@include(theme('snippets.components._banner-v4'))
@include(theme('snippets.components._banner-dark'))


@include(theme('snippets.components._about_v1'))
@include(theme('snippets.components._about_v2'))
@include(theme('snippets.components._about_v3'))
@include(theme('snippets.components._about_v4'))

@include(theme('snippets.components._home_page_category_section'))
@include(theme('snippets.components._category-v2'))
@include(theme('snippets.components._category-v3'))
@include(theme('snippets.components._category-v4'))
@include(theme('snippets.components._category-v5'))
@include(theme('snippets.components._category-dark'))

@include(theme('snippets.components._home_page_instructor_section'))

@include(theme('snippets.components._home_page_course_section'))

@include(theme('snippets.components._home_page_best_category_section'))
@include(theme('snippets.components._home_page_quiz_section'))
@include(theme('snippets.components._home_page_testimonial_section'))
@include(theme('snippets.components._home_sponsor'))

@include(theme('snippets.components._home_page_blog_section'))
@include(theme('snippets.components._blog_section_v2'))
@include(theme('snippets.components._blog_section_v3'))
@include(theme('snippets.components._blog_section_v4'))

@include(theme('snippets.components._home_page_become_instructor_section'))
@include(theme('snippets.components._home_page_how_to_buy'))
@include(theme('snippets.components._home_page_faq'))

@include(theme('snippets.components._testimonial_section_v2'))
@include(theme('snippets.components._testimonial_section_v3'))
@include(theme('snippets.components._testimonial_section_v4'))
@include(theme('snippets.components._testimonial_section_v5'))


@include(theme('snippets.components._course_section_v2'))
@include(theme('snippets.components._course_section_v3'))
@include(theme('snippets.components._course_section_v4'))
@include(theme('snippets.components._course_section_dark'))

@include(theme('snippets.components._course_section_featured'))


@include(theme('snippets.components._quiz_section_v2'))
@include(theme('snippets.components._quiz_section_v3'))
@include(theme('snippets.components._quiz_section_v4'))
@include(theme('snippets.components._quiz_section_v5'))
@if(isModuleActive('Subscription'))
    @include(theme('snippets.components._price_section'))
    @include(theme('snippets.components._price_section_v2'))
    @include(theme('snippets.components._price_section_v3'))
@endif
@include(theme('snippets.components._home_sponsor_success'))


@include(theme('snippets.components._popular_instructors_v2'))
@include(theme('snippets.components._popular_instructors_v3'))
@include(theme('snippets.components._popular_instructors_v4'))
@include(theme('snippets.components._popular_instructors_v5'))

@if(isModuleActive('Store'))
    @include(theme('snippets.components._shop_section'))
    @include(theme('snippets.components._shop_section_v2'))
    @include(theme('snippets.components._shop_section_v3'))
@endif
@include(theme('snippets.components._classes_section'))
@include(theme('snippets.components._apk_section'))
@include(theme('snippets.components._apk_section_v2'))
@include(theme('snippets.components._apk_section_v3'))
@include(theme('snippets.components._apk_section_dark'))
@include(theme('snippets.components._reward-with-footer-v1'))
@include(theme('snippets.components._reward-with-footer-v2'))
@include(theme('snippets.components._reward-section'))
@include(theme('snippets.components._reward-section_v2'))
@include(theme('snippets.components._reward-section_dark'))

@include(theme('snippets.components._counter_v2'))
@include(theme('snippets.components._counter_v3'))
@include(theme('snippets.components._counter_v4'))

@include(theme('snippets.components._classes_section_v2'))
@include(theme('snippets.components._classes_section_v3'))
@include(theme('snippets.components._classes_section_v4'))


@include(theme('snippets.components._home_page_slider'))

@include(theme('snippets.components._home_page_course_section'))
@include(theme('snippets.components._home_page_quiz_section'))

@include(theme('snippets.components._home_page_blog_section'))
@include(theme('snippets.components._home_page_how_to_buy'))
@include(theme('snippets.components._home_page_feature'))
@include(theme('snippets.components._home_page_category_list'))

{{--homepage v7 partials--}}
@include(theme('snippets.components._home_page_banner_v7'))
@include(theme('snippets.components._home_page_featured_section_v7'))
@include(theme('snippets.components._home_page_category_section_v7'))
@include(theme('snippets.components._home_page_course_section_v7'))
@include(theme('snippets.components._home_page_client_section_v7'))
@include(theme('snippets.components._home_page_testimonial_section_v7'))
@include(theme('snippets.components._home_page_latest_course_section_v7'))
@include(theme('snippets.components._home_page_instructor_section_v7'))
@include(theme('snippets.components._home_page_faq_section_v7'))
@include(theme('snippets.components._home_page_cta_section_v7'))
