<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/about/2.jpg')}}"
     data-aoraeditor-title="About Section V2"
     data-aoraeditor-categories="Home Page">

    <style>
        .about {
            position: relative;
            z-index: 0;
            margin-top: var(--section-sepreate-lg)
        }

        .about .section-title {
            margin-bottom: 90px
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .about .section-title {
                margin-bottom: 70px
            }
        }

        @media only screen and (max-width: 767px) {
            .about .section-title {
                margin-bottom: 50px
            }
        }

        .about-inner {
            background-color: #fff;
            box-shadow: 5px 21px 60px 3px rgba(0, 0, 0, 0.15);
            border-radius: 36px;
            border-bottom-left-radius: 237px;
            padding-top: 60px;
            padding-bottom: 72px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-inner {
                padding-top: 50px;
                padding-bottom: 62px;
                border-bottom-left-radius: 136px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .about-inner {
                border-radius: 30px;
                padding: 30px
            }
        }

        @media only screen and (max-width: 767px) {
            .about-inner {
                border-radius: 30px;
                padding: 20px
            }
        }

        .about-video {
            width: 100%;
            padding-bottom: 64%;
            overflow: hidden;
            border-radius: 36px;
            margin-left: -50px
        }

        html[dir=rtl] .about-video {
            margin-left: 0;
            margin-right: -50px;
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .about-video {
                margin-left: -30px
            }

            html[dir=rtl] .about-video {
                margin-left: 0;
                margin-right: -30px;
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .about-video {
                margin-left: -20px
            }

            html[dir=rtl] .about-video {
                margin-left: 0;
                margin-right: -20px;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-video {
                width: 90%;
                margin-left: 20px
            }

            html[dir=rtl] .about-video {
                margin-left: 0;
                margin-right: 20px;
            }
        }

        @media only screen and (max-width: 991px) {
            .about-video {
                margin-left: 0
            }

            html[dir=rtl] .about-video {
                margin-right: 0;
            }
        }

        .about-video img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            z-index: 1
        }

        .about-video-play {
            --play-width: 100px;
            width: var(--play-width);
            height: var(--play-width);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            color: var(--system_primery_color);
            border-radius: 100%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            font-size: 24px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-video-play {
                --play-width: 80px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .about-video-play {
                --play-width: 80px
            }
        }

        @media only screen and (max-width: 767px) {
            .about-video-play {
                --play-width: 60px
            }
        }

        .about-video-play:hover {
            background: var(--system_primery_color);
            background-size: 200% auto;
            color: #fff
        }

        .about-video-play i {
            margin-left: 12px
        }

        html[dir=rtl] .about-video-play i {
            margin-left: 0;
        }

        .about-content {
            padding-right: 76px;
            position: relative
        }

        html[dir=rtl] .about-content {
            padding-right: 0;
            padding-left: 76px;
        }

        @media only screen and (max-width: 991px) {
            .about-content {
                margin-top: 24px;
                padding-right: 0;
                padding-bottom: 20px
            }

            html[dir=rtl] .about-content {
                padding-left: 0;
            }
        }

        .about-content h3 {
            font-size: 32px;
            line-height: 1.25;
            font-weight: 600;
            margin-bottom: 20px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-content h3 {
                font-size: 28px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .about-content h3 {
                font-size: 26px
            }
        }

        @media only screen and (max-width: 767px) {
            .about-content h3 {
                font-size: 24px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-content h3 {
                margin-bottom: 14px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .about-content h3 {
                font-size: 28px
            }
        }

        @media only screen and (max-width: 991px) {
            .about-content h3 {
                margin-bottom: 10px
            }
        }

        .about-content p {
            line-height: 1.5;
            margin-bottom: 26px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-content p {
                margin-bottom: 16px
            }
        }

        @media only screen and (max-width: 991px) {
            .about-content p {
                margin-bottom: 14px
            }
        }

        @media only screen and (max-width: 479px) {
            .about-content p {
                font-size: 14px;
                line-height: 1.683
            }
        }

        .about-content a {
            --btn-padding-y: 9px;
            min-width: 120px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-content a {
                margin-top: 10px
            }
        }

        @media only screen and (max-width: 991px) {
            .about-content a {
                margin-top: 10px
            }
        }
    </style>
    <div class="about">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="section-title">
                        <h2>About Us</h2>
                        <p>Here is short details about our institute, Also you can see how we work</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="about-inner position-relative">
                        <div class="about-inner-overlay-img position-absolute"><img
                                src="{{themeAsset('img/others/about-child.png')}}" alt=""></div>
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-5">
                                <div class="about-video position-relative">
                                    <img src="{{themeAsset('img/others/video-preview.jpg')}}" alt="alt img">
                                    <a href="#" class="about-video-play">
                                        <i class="fa fa-play">&nbsp;</i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="about-content ps-lg-4">
                                    <h3 class="text-secondary">Kids Institute</h3>
                                    <p>Since the year of 2008 and now at in 2019 “Spondon It” most popular in UI & UX,
                                        Web App Development, Digital Marketing and Graphic Design related service
                                        provider company both Local (Bangladesh) and global too!</p>
                                    <p>At a time we are also doing our best for our clients by giving our service. This
                                        gives us boost in popularity in this Digital Tech World.</p>
                                    <a href="{{url('about-us')}}" class="theme-btn">Know More</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div data-type="component-nonExisting"
                         data-preview=""
                         data-table=""
                         data-select="image"
                         data-order="id"
                         data-limit="0"
                         data-where-status="1"
                         data-view="_single_sponsor_v3"
                         data-model="Modules\FrontendManage\Entities\Sponsor"
                         data-with=""
                    >
                        <div class="dynamicData"
                             data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

