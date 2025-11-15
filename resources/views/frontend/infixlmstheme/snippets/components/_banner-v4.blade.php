<div data-type="component-text"
     data-preview="{{ !function_exists('themeAsset') ? '' : themeAsset('img/snippets/preview/banner/banner-v4.jpg') }}"
     data-aoraeditor-title="Banner V4" data-aoraeditor-categories="Home Page;Banner">

    <style>
        .banner-area {
            position: relative;
            z-index: 1;
            background-image: var(--bg-image);
            background-repeat: no-repeat;
            background-size: 100%;
            background-position: top right;
            padding-top: 190px;
            padding-bottom: 290px
        }

        .banner-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /*html[dir=rtl] .banner-img {*/
        /*    transform: scaleX(-1)*/
        /*}*/

        .banner-img img {
            width: 100% !important;
            height: auto !important;
            object-fit: cover;
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .banner-area {
                padding-bottom: 250px;
                background-size: 120%
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .banner-area {
                background-size: 124%;
                padding-top: 140px;
                padding-bottom: 230px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-area {
                padding-top: 130px;
                padding-bottom: 190px;
                background-position: center right
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-area {
                padding: 80px 0px;
                background-image: none
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-area {
                padding: 60px 0px;
                background-image: none
            }
        }

        @media only screen and (max-width: 479px) {
            .banner-area {
                padding: 50px 0px
            }
        }

        .banner-text h1 {
            font-size: 64px;
            line-height: 1.25;
            margin-bottom: 30px;
            color: #425073
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
                margin-bottom: 20px
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-text h1 {
                margin-bottom: 24px
            }
        }

        .banner-text p {
            font-size: 18px;
            line-height: 1.66667;
            margin-bottom: 60px;
            color: #777E93
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .banner-text p {
                margin-bottom: 40px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-text p {
                padding-right: 0 !important;
                margin-bottom: 40px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-text p {
                font-size: 16px;
                margin-bottom: 36px
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

        .banner-text .theme-btn:not(:last-child) {
            margin-right: 24px
        }

        html[dir=rtl] .banner-text .theme-btn:not(:last-child) {
            margin-right: 0 !important;
            margin-left: 24px;
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .banner-text .theme-btn:not(:last-child) {
                margin-right: 18px
            }

            html[dir=rtl] .banner-text .theme-btn:not(:last-child) {
                margin-left: 18px;
            }
        }

        @media only screen and (max-width: 767px) {
            .banner-text .theme-btn:not(:last-child) {
                margin-right: 12px
            }

            html[dir=rtl] .banner-text .theme-btn:not(:last-child) {
                margin-left: 12px;
            }
        }

        @media only screen and (max-width: 479px) {
            .banner-text .theme-btn:not(:last-child) {
                margin-right: 0;
                margin-bottom: 12px
            }

            html[dir=rtl] .banner-text .theme-btn:not(:last-child) {
                margin-left: 0;
            }
        }

    </style>
    <form action="{{ route('search') }}">
        <div class="banner-area">
            <div class="banner-img d-none d-md-block">
                <img src="{{ asset('public/frontend/infixlmstheme/img/banner/banner-v4.png') }}" alt="">
            </div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="banner-text">
                            <h1>{{ @$homeContent->slider_title }}</h1>
                            <p class="pe-0 pe-xl-5">{{ @$homeContent->slider_text }}</p>
                            <a href="{{route('courses')}}" class="theme-btn text-capitalize">View All Courses</a>
                            <a href="{{route('quizzes')}}" class="theme-btn text-capitalize bg-white">View All
                                Quizzes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
