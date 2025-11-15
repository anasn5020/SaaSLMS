<div data-type="component-nonExisting"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/home_sponsor_v2.jpg')}}"
     data-aoraeditor-title="Sponsor And Success"
     data-aoraeditor-categories="Home Page;Dynamic component"
>
    <style>
        .about {
            position: relative;
            z-index: 0;
            background-color: #CEE8FF
        }

        .about-inner {
            background: rgba(0, 0, 0, 0.86) url('{{asset('public/frontend/infixlmstheme/img/shape/about-bg-shape.png')}}') no-repeat center;
            padding: 80px 0px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-inner {
                padding: 60px 20px
            }
        }

        @media only screen and (max-width: 767px) {
            .about-inner {
                padding: 40px 15px
            }
        }

        .about-inner h3 {
            font-size: 48px;
            line-height: 1.25;
            color: #fff;
            margin-bottom: 15px
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .about-inner h3 {
                font-size: 42px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-inner h3 {
                font-size: 36px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .about-inner h3 {
                font-size: 32px
            }
        }

        @media only screen and (max-width: 767px) {
            .about-inner h3 {
                font-size: 28px
            }
        }

        .about-inner p {
            font-size: 18px;
            line-height: 1.55556;
            color: #fff;
            margin-bottom: 35px
        }

        @media only screen and (max-width: 991px) {
            .about-inner p {
                font-size: 16px
            }
        }

        .about-video {
            max-width: 500px;
            padding-bottom: 45%;
            overflow: hidden;
            border-radius: 36px;
            margin-left: auto;
            margin-right: auto
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-video {
                width: 90%
            }
        }

        .about-video img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            z-index: 1
        }

        .about-video-play {
            --play-width: 90px;
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
            font-size: 24px;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .about-video-play {
                --play-width: 70px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .about-video-play {
                --play-width: 70px
            }
        }

        @media only screen and (max-width: 767px) {
            .about-video-play {
                --play-width: 50px
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

    </style>
    <div class="about">
        <div class="container-fluid g-0">
            <div class="row g-0 align-items-center">
                <div class="col-sm-12 col-lg-6 text-center">
                    <div class="about-inner">
                        <h3>Success Story </h3>
                        <p>Here is short details about our institute, Also you can see how we work</p>
                        <div class="about-video position-relative">
                            <img src="{{themeAsset('img/others/about-v3.png')}}" alt="">
                            <a href="#" class="about-video-play">
                                <i class="fa fa-play">&nbsp;</i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div
                        data-preview=""
                        data-table=""
                        data-select="image,title"
                        data-order="id"
                        data-limit="0"
                        data-where-status="1"
                        data-view="_single_sponsor_v2"
                        data-model="Modules\FrontendManage\Entities\Sponsor"
                        data-with="">
                        <div class="dynamicData"
                             data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
