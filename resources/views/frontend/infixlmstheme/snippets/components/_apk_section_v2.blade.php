<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/apk/2.jpg')}}"
     data-aoraeditor-title="APK Sections V2" data-aoraeditor-categories="Home Page">

    <style>
        .apk {
            background-color: #38485C;
            border-radius: 50px;
            z-index: 1;
            margin-top: calc(var(--section-sepreate) - 30px);
            box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.08);
            color: #fff
        }

        .apk-shape {
            top: 100%;
            right: 100%;
            --width: 175px;
            width: var(--width);
            height: var(--width);
            z-index: 1;
            margin-top: -80px;
            margin-right: -60px
        }

        html[dir=rtl] .apk-shape {
            right: auto;
            left: 100%;
            margin-right: 0;
            margin-left: -60px;
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .apk-shape {
                --width: 115px
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .apk-shape {
                --width: 125px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .apk-shape {
                display: none
            }
        }

        @media only screen and (max-width: 991px) {
            .apk-shape {
                display: none
            }
        }

        .apk-shape img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1
        }

        .apk-content {
            padding: 74px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .apk-content {
                padding: 60px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .apk-content {
                padding: 54px !important;
            }
        }

        @media only screen and (max-width: 767px) {
            .apk-content {
                padding: 40px 30px !important;
            }
        }

        @media only screen and (max-width: 479px) {
            .apk-content {
                padding: 30px 24px !important;
            }
        }

        .apk-content h3 {
            color: currentColor;
            font-size: 48px;
            line-height: 1.25
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .apk-content h3 {
                font-size: 42px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .apk-content h3 {
                font-size: 36px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .apk-content h3 {
                font-size: 32px
            }
        }

        @media only screen and (max-width: 767px) {
            .apk-content h3 {
                font-size: 28px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .apk-content h3 {
                margin-bottom: 16px !important
            }
        }

        @media only screen and (max-width: 767px) {
            .apk-content h3 {
                margin-bottom: 12px !important
            }
        }

        .apk-content h3 .text-primary {
            color: #FFDC83 !important
        }

        .apk-content h3 span {
            position: relative;
            z-index: 1
        }

        .apk-content h3 span::before {
            content: "";
            width: 100%;
            height: 100%;
            position: absolute;
            bottom: -10px;
            left: 20px;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg width='243' height='21' viewBox='0 0 243 21' fill='none' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M2 14.0007C238 30 241 2 241 2' stroke='%23FFDC83' stroke-width='4' stroke-linecap='round'/%3e%3c/svg%3e ");
            background-repeat: no-repeat;
            background-position: left bottom;
        }

        html[dir=rtl] .apk-content h3 span::before {
            left: auto;
            right: 0;
            bottom: 0;
        }

        .apk-content p {
            color: currentColor;
            margin-bottom: 36px
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .apk-content p {
                margin-bottom: 26px
            }
        }

        @media only screen and (max-width: 767px) {
            .apk-content p {
                margin-bottom: 20px
            }
        }

        .apk-content a {
            color: #CEE8FF;
            display: block;
            border-radius: 100px;
            overflow: hidden
        }

        .apk-content a:hover {
            color: var(--system_secendory_color)
        }

        .apk-content a:hover path {
            fill: #fff
        }

        @media only screen and (max-width: 767px) {
            .apk-content a svg {
                width: 130px;
                height: auto
            }
        }

        .apk-content a svg path {
            fill: var(--system_primery_color);
            transition: all .4s ease-in-out
        }

        .apk-content .gap-4 {
            gap: 12px !important
        }

        .apk-img {
            width: 520px;
            height: 480px;
            position: relative;
            z-index: 1;
            margin-top: -100px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .apk-img {
                width: 450px;
                height: 410px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .apk-img {
                width: 410px;
                height: 390px;
                margin-top: 50px
            }
        }

        @media only screen and (max-width: 767px) {
            .apk-img {
                width: 310px;
                height: 290px;
                margin-left: 0 !important;
                margin-top: 40px
            }

            html[dir=rtl] .apk-img {
                margin-right: 0 !important;
            }
        }

        html[dir=rtl] .apk-img img {
            transform: scaleX(-1);
        }

    </style>
    <div class="container">
        <div class="apk position-relative">
            <div class="apk-shape position-absolute">
                <img src="{{themeAsset('img/shape/reward-shape.png')}}" alt="">
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="apk-content pe-0">
                        <h3 class="pe-4 mb-4">For Better <span class="text-primary">Experience</span> Use Mobile App
                        </h3>
                        <p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do
                            amet sint. Velit officia consequat duis enim velit mollit xercitation.</p>
                        <div class="d-flex align-items-center gap-4">
                            <a href="#" target="_blank">
                                <img src="{{url('public/frontend/infixlmstheme/img/svg/google_play_btn.svg')}}"
                                     alt=""> </a>
                            <a href="#" target="_blank">
                                <img src="{{url('public/frontend/infixlmstheme/img/svg/apple_store_btn.svg')}}"
                                     alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="apk-img mx-auto">
                        <div class="overflow-hidden">
                            <img src="{{themeAsset('img/others/phone-img.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
