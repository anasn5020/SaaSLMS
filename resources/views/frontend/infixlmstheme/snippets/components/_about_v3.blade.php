<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/about/3.jpg')}}"
     data-aoraeditor-title="About Section V3"
     data-aoraeditor-categories="Home Page">

    <style>
        .about {
            position: relative;
            z-index: 0
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

        .about-video {
            width: 100%;
            padding-bottom: 74%;
            overflow: hidden;
            border-radius: 36px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-video {
                width: 90%
            }
        }

        @media only screen and (max-width: 991px) {
            .about-video {
                padding-bottom: 50%
            }
        }

        .about-video img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1
        }

        .about-video-play {
            --play-width: 100px;
            width: var(--play-width);
            height: var(--play-width);
            justify-content: center;
            background-color: #fff;
            color: var(--system_primery_color);
            border-radius: 100%;
            box-shadow: 20px 7px 23px rgba(44, 36, 36, 0.15);
            display: flex;
            align-items: center;
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
            margin-left: 0
        }

        .about-content {
            position: relative
        }

        @media only screen and (max-width: 991px) {
            .about-content {
                margin-top: 24px;
                padding-bottom: 20px
            }
        }

        .about-content h3 {
            font-size: 32px;
            line-height: 1.25;
            font-weight: 600;
            margin-bottom: 24px
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
                margin-bottom: 18px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .about-content h3 {
                font-size: 28px
            }
        }

        @media only screen and (max-width: 991px) {
            .about-content h3 {
                margin-bottom: 16px
            }
        }

        .about-content p {
            color: var(--system_paragraph_color);
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

        .about-content ul {
            width: 56%
        }

        .about-content ul li {
            color: var(--system_paragraph_color);
            --width: 24px
        }

        .about-content ul li:not(:last-child) {
            margin-bottom: 20px
        }

        .about-content ul li .icon {
            width: var(--width);
            height: var(--width);
            flex: 0 0 auto;
            position: relative;
            top: 3px
        }

        .about-content ul li .icon img, .about-content ul li .icon > * {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1
        }

        .about-content ul li .content {
            width: calc(100% - var(--width));
            flex: 0 0 auto;
            padding-left: 18px
        }

        html[dir=rtl] .about-content ul li .content {
            padding-left: 0;
            padding-right: 18px;
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

        .sponsor-title h4 {
            color: #777E93 !important
        }

    </style>
    <div class="about section-margin-lg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="section-title">
                        <h2>About Us</h2>
                        <p>Here is short details about our institute, Also you can see how we work</p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                {{-- need to dynamic --}}
                <div class="col-lg-6">
                    <div class="about-video position-relative">
                        <img src="{{themeAsset('img/others/about-v3.png')}}" alt="">
                        <a href="#" class="about-video-play">
                            <i class="fa fa-play">&nbsp;</i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content">
                        <h3>Corporate Learning Institute</h3>
                        <p>Since the year of 2008 and now at in 2019 “Spondon It” most popular in UI & UX, Web App
                            Development, Digital Marketing and Graphic Design related service provider company both
                            Local (Bangladesh) and global too!</p>
                        <p>At a time we are also doing our best for our clients by giving our service. This gives us
                            boost in popularity in this Digital Tech World.</p>
                        <ul class="mb-4 mb-lg-5">
                            <li class="d-flex flex-wrap">
                                <span class="icon text-primary">
                                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13 25C19.6274 25 25 19.6274 25 13C25 6.37258 19.6274 1 13 1C6.37258 1 1 6.37258 1 13C1 19.6274 6.37258 25 13 25Z"
                                            fill="#CEE8FF" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                        <path
                                            d="M8.20312 14.2002L11.694 17.8002C13.3367 13.0814 14.7048 11.0108 17.8031 8.2002"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span class="content">Explore the wide-range of online course in the world</span>
                            </li>
                            <li class="d-flex flex-wrap">
                                <span class="icon text-primary">
                                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13 25C19.6274 25 25 19.6274 25 13C25 6.37258 19.6274 1 13 1C6.37258 1 1 6.37258 1 13C1 19.6274 6.37258 25 13 25Z"
                                            fill="#CEE8FF" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                        <path
                                            d="M8.20312 14.2002L11.694 17.8002C13.3367 13.0814 14.7048 11.0108 17.8031 8.2002"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span class="content">Popular online course in the world</span>
                            </li>
                        </ul>
                        <a href="{{url('about-us')}}" class="theme-btn">Know More</a>
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
