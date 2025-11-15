<div data-type="component-text"
     data-preview="{{ !function_exists('themeAsset') ? '' : themeAsset('img/snippets/preview/banner/banner-v5.jpg') }}"
     data-aoraeditor-title="Banner Dark" data-aoraeditor-categories="Home Page;Banner">

    <style>
        .banner-area {
            position: relative;
            z-index: 1;
            padding-top: 200px;
            padding-bottom: 100px;
            background-image: var(--bg-image);
            background-repeat: no-repeat;
            background-size: auto;
            background-position: 90% 100%;
            background-color: transparent !important;
            display: flex;
            align-items: center
        }

        .banner-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            text-align: end;
        }

        .banner-img img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
            max-width: 100%;
        }

        .banner-area::before {
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1
        }

        html[dir=rtl] .banner-area::before {
            left: auto;
            right: 0;
        }

        @media only screen and (max-width: 991px) {
            .banner-area::before {
                content: ""
            }
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .banner-area {
                padding-top: 150px;
                background-position-x: 110%
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .banner-area {
                padding-top: 150px;
                background-size: 60%;
                background-position: right bottom;
                padding-bottom: 0
            }

            html[dir=rtl] .banner-area {
                background-position: left bottom;
            }

        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-area {
                padding-top: 80px;
                padding-bottom: 30px;
                background-size: 50%;
                background-position: right center
            }

            html[dir=rtl] .banner-area {
                background-position: left bottom;
            }

        }

        @media only screen and (max-width: 991px) {
            .banner-area {
                background-size: 100%;
                background-position: center
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-area {
                padding: 100px 0px
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-area {
                padding: 80px 0px
            }
        }

        @media only screen and (max-width: 479px) {
            .banner-area {
                padding: 60px 0px
            }
        }

        .banner-text h1 {
            font-size: 64px;
            line-height: 1.25;
            margin-bottom: 20px
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .banner-text h1 {
                font-size: 54px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-text h1 {
                font-size: 50px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-text h1 {
                font-size: 44px
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-text h1 {
                font-size: 38px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-text h1 {
                margin-bottom: 10px
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-text h1 {
                margin-bottom: 14px
            }
        }

        .banner-text p {
            font-size: 18px;
            line-height: 1.66667;
            margin-bottom: 40px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-text p {
                padding-right: 0 !important
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-text p {
                font-size: 16px;
                margin-bottom: 26px
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-text p {
                font-size: 16px;
                margin-bottom: 24px
            }
        }

        .banner-text .theme-btn {
            --btn-padding-y: 16px
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-text .theme-btn {
                --btn-padding-y: 12px
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-text .theme-btn {
                --btn-padding-y: 10px;
                --btn-padding-x: 24px
            }
        }

    </style>
    <form action="{{ route('search') }}">
        <div class="banner-area">
            <div class="banner-img">
                <img src="{{ asset('public/frontend/infixlmstheme/img/banner/banner-v5.svg')}}" class="d-none d-md-block" alt="">
                <img src="{{ asset('public/frontend/infixlmstheme/img/banner/banner-v5-m.svg')}}" class="d-md-none" alt="">
            </div>

            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="banner-text">
                            <h1 class="text-white">{{ @$homeContent->slider_title }}</h1>
                            <p class="pe-0 pe-xl-5 text-white">{{ @$homeContent->slider_text }}</p>
                            <a href="{{route('courses')}}" class="theme-btn text-capitalize">View All Courses</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
