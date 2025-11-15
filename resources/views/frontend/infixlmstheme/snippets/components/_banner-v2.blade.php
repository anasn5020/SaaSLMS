<div data-type="component-text"
     data-preview="{{ !function_exists('themeAsset') ? '' : themeAsset('img/snippets/preview/banner/banner-v2.jpg') }}"
     data-aoraeditor-title="Banner V2" data-aoraeditor-categories="Home Page;Banner">

    <style>
        .banner-area {
            /* background-image: var(--bg-image);
            background-size: cover;
            background-position: left center;
            background-repeat: no-repeat; */
            position: relative;
            z-index: 1;
        }

        .banner-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;

        }

        /*html[dir=rtl] .banner-img {*/
        /*    transform: scaleX(-1)*/
        /*}*/

        .banner-img img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
        }

        @media (min-width: 1581px) {
            .banner-area .container-fluid {
                padding-right: 190px
            }

            html[dir=rtl] .banner-area .container-fluid {
                padding-right: 15px;
                padding-left: 190px
            }
        }

        @media (min-width: 1440px) {
            .banner-area .container-fluid {
                padding-right: 50px
            }

            html[dir=rtl] .banner-area .container-fluid {
                padding-left: 50px;
                padding-right: 15px;
            }
        }

        @media (min-width: 1280px) {
            .banner-area .container-fluid {
                padding-right: 30px
            }

            html[dir=rtl] .banner-area .container-fluid {
                padding-right: 15px;
                padding-left: 30px;
            }
        }

        .banner-wrap {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 90px 50px;
            padding-bottom: var(--section-sepreate-sm)
        }

        @media (min-width: 1581px) {
            .banner-wrap {
                width: 93%
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .banner-wrap {
                padding: 70px 40px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-wrap {
                padding: 60px 40px
            }
        }

        @media only screen and (max-width: 991px) {
            .banner-wrap {
                padding: 40px 30px
            }
        }

        .banner-text h1 {
            font-size: 64px;
            line-height: 1.25;
            color: #fff;
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

        @media (min-width: 1581px) {
            .banner-text h1 {
                font-size: 72px
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
            font-size: 20px;
            line-height: 1.5;
            color: #CEE8FF;
            margin-bottom: 40px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-text p {
                font-size: 18px
            }
        }

        @media only screen and (max-width: 991px) {
            .banner-text p {
                font-size: 18px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .banner-text p {
                padding-right: 0 !important;
                margin-bottom: 30px
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
            --btn-padding-y: 16px;
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

        @media only screen and (max-width: 479px) {
            .banner-text .theme-btn {
                display: block
            }
        }

        .banner-text .theme-btn:not(:last-child) {
            margin-right: 20px
        }

        html[dir=rtl] .banner-text .theme-btn:not(:last-child) {
            margin-right: 0;
            margin-left: 20px;
        }

        @media only screen and (max-width: 767px) {
            .banner-text .theme-btn:not(:last-child) {
                margin-right: 10px
            }

            html[dir=rtl] .banner-text .theme-btn:not(:last-child) {
                margin-right: 0;
                margin-left: 10px;
            }
        }

        @media only screen and (max-width: 479px) {
            .banner-text .theme-btn:not(:last-child) {
                margin-right: 0;
                margin-bottom: 12px
            }

            html[dir=rtl] .banner-text .theme-btn:not(:last-child) {
                margin-right: 0;
                margin-left: 12px;
            }
        }

    </style>

    <form action="{{ route('search') }}">
        <div class="banner-area">
            <div class="banner-img">
                <img src="{{ asset('public/frontend/infixlmstheme/img/banner/banner-v1.jpg') }}" alt="">
            </div>
            <div class="container-fluid">
                <div class="row align-items-center justify-content-end">
                    <div class="col-xl-6 col-lg-7 col-md-8">
                        <div class="banner-wrap">
                            <div class="banner-text">
                                <h1>{{ @$homeContent->slider_title }}</h1>
                                <p>{{ @$homeContent->slider_text }}</p>
                                <a href="{{route('courses')}}" class="theme-btn text-capitalize">View All Courses</a>
                                <a href="{{route('quizzes')}}" class="theme-btn text-capitalize bg-white">View All Quizzes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
