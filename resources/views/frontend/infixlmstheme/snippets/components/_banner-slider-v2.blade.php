<div data-type="component-text"
     data-preview="{{ !function_exists('themeAsset') ? '' : themeAsset('img/snippets/preview/banner/banner-slider-v2.jpg') }}"
     data-aoraeditor-title="Banner Slider V2" data-aoraeditor-categories="Home Page;Banner">

    <style>
        .banner-area {
            position: relative;
            z-index: 1;
            padding-top: 100px;
            padding-bottom: 180px;
        }

        .banner-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .banner-img img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-area {
                padding-top: 80px;
                padding-bottom: 130px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-area {
                padding-top: 80px;
                padding-bottom: 100px;
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-area {
                padding-top: 50px;
                padding-bottom: 70px;
            }
        }

        .banner-area::before {
            content: "";
            height: 100%;
            width: 50%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            background: linear-gradient(90.11deg, rgba(60, 167, 224, 0.902) 0.1%, rgba(61, 106, 228, 0.769) 39.32%, rgba(60, 109, 219, 0) 99.9%);
            mix-blend-mode: hard-light;
            opacity: 0.5;
        }

        html[dir=rtl] .banner-area::before {
            left: auto;
            right: 0;
        }

        @media only screen and (max-width: 767px) {
            .banner-area::before {
                display: none;
            }
        }

        .banner-area::after {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            background: rgba(0, 0, 0, 0.4);
        }

        @media only screen and (max-width: 991px) {
            .banner-area::after {
                content: "";
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-area::after {
                background: rgba(0, 0, 0, 0.7);
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-area .row {
                justify-content: center;
            }
        }

        @media only screen and (max-width: 991px) {
            .banner-area .row {
                justify-content: center;
            }
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .banner-text {
                padding-left: 100px;
            }

            html[dir=rtl] .banner-text {
                padding-left: 0;
                padding-right: 100px;
            }
        }

        .banner-text h1 {
            font-size: 64px;
            line-height: 1.25;
            margin-bottom: 30px;
            color: #425073;
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .banner-text h1 {
                font-size: 54px;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-text h1 {
                font-size: 50px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-text h1 {
                font-size: 44px;
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-text h1 {
                font-size: 38px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-text h1 {
                margin-bottom: 20px;
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-text h1 {
                margin-bottom: 24px;
            }
        }

        .banner-text p {
            font-size: 18px;
            line-height: 1.6666666667;
            margin-bottom: 60px;
            color: #777E93;
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .banner-text p {
                margin-bottom: 40px;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-text p {
                padding-right: 0 !important;
                margin-bottom: 40px;
            }

            html[dir=rtl] .banner-text p {
                padding-left: 0 !important;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-text p {
                font-size: 16px;
                margin-bottom: 36px;
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-text p {
                font-size: 16px;
                margin-bottom: 24px;
            }
        }

        .banner-text .theme-btn {
            --btn-padding-y: 20px;
            min-width: 200px;
            border-radius: 6px
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-text .theme-btn {
                --btn-padding-y: 16px;
                min-width: 180px;
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-text .theme-btn {
                --btn-padding-y: 12px;
                --btn-padding-x: 24px;
                min-width: 140px;
            }
        }

        @media only screen and (max-width: 479px) {
            .banner-text .theme-btn {
                min-width: 100%;
            }
        }

        .banner-text .theme-btn.bg-transparent {
            color: #FFFFFF !important;
            border-color: #FFFFFF !important;
        }

        .banner-text .theme-btn.bg-transparent:hover {
            border-color: var(--system_secendory_color) !important;
        }

        .banner-text .single_slider {
            margin-right: 24px;
        }

        html[dir=rtl] .banner-text .single_slider {
            margin-right: 0 !important;
            margin-left: 24px;
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-text .single_slider {
                margin-right: 18px;
            }

            html[dir=rtl] .banner-text .single_slider {
                margin-left: 18px;
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-text .single_slider {
                margin-right: 12px;
            }

            html[dir=rtl] .banner-text .single_slider {
                margin-left: 12px;
            }
        }

        @media only screen and (max-width: 479px) {
            .banner-text .single_slider {
                margin-right: 10px;
                margin-bottom: 12px;
            }

            html[dir=rtl] .banner-text .single_slider {
                margin-left: 10px;
            }
        }

        .banner-slider .owl-nav {
            --btn-width: 40px;
            --btn-position: 50px;
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-slider .owl-nav {
                --btn-position: 20px;
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-slider .owl-nav {
                --btn-position: 12px;
                display: none;
            }
        }

        .banner-slider .owl-dots {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: none;
        }

        @media only screen and (max-width: 767px) {
            .banner-slider .owl-dots {
                display: block;
            }
        }

        .banner-img {
            min-height: 658px;
        }

        @media (min-width: 1280px) and (max-width: 1439px) {
            .banner-img {
                min-height: 613px;
            }
        }

        @media (min-width: 992px) and (max-width: 1279px) {
            .banner-img {
                min-height: 533px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .banner-img {
                min-height: 460px;
            }
        }

        @media (max-width: 767px) {
            .banner-img {
                min-height: 300px;
            }
        }

        .banner-slider .owl-stage {
            display: flex;
        }

        .banner-slider .owl-prev {
            top: 50%;
            transform: translateY(-50%);
            left: 20px;
        }

        html[dir="rtl"] .banner-slider .owl-prev {
            top: 50%;
            transform: translateY(-50%);
            right: 20px;
            left: auto;
            transform: scaleX(-1);
        }

        .banner-slider .owl-next {
            top: 50%;
            transform: translateY(-50%);
            right: 20px;
            left: auto;
        }

        html[dir="rtl"] .banner-slider .owl-next {
            top: 50%;
            transform: translateY(-50%);
            left: 20px;
            right: auto;
            transform: scaleX(-1);
        }

        .banner-slider .owl-dots {
            display: flex;
            margin-bottom: 50px;
        }

        .banner-slider .owl-item, .banner-slider .banner-area {
            min-height: 100% !important;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table=""
                 data-select=""
                 data-order="id"
                 data-limit=""
                 data-where-status="1"
                 data-view="_single_banner_slider"
                 data-model="Modules\FrontendManage\Entities\Slider"
                 data-with=""
                 data-with-count=""
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>
        </div>
    </div>
</div>
