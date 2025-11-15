<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/reward/5.jpg')}}"
     data-aoraeditor-title="Reward V2" data-aoraeditor-categories="Home Page">

    <style>
        .reward {
            margin-top: calc(var(--section-sepreate-lg) + 20px);
            position: relative;
            z-index: 1;
        }

        .reward::before {
            content: "";
            width: 100%;
            height: 50%;
            position: absolute;
            bottom: -90px;
            left: 0;
            z-index: -1;
            background-color: #ECEFFD;
        }

        .reward-img {
            position: absolute;
            right: 0;
            bottom: 125px;
            z-index: -1;
            width: 583px;
            height: 450px;
            transform: scaleX(-1);
        }

        html[dir=rtl] .reward-img {
            right: auto;
            left: 0;
            transform: scaleX(1)
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .reward-img {
                width: 500px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .reward-img {
                width: 430px;
                height: 350px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .reward-img {
                width: 350px;
                height: 400px;
                bottom: 0
            }
        }

        @media only screen and (max-width: 767px) {
            .reward-img {
                display: none
            }
        }

        .reward-wrap {
            padding-left: 80px
        }

        html[dir=rtl] .reward-wrap {
            padding-right: 80px
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .reward-wrap {
                padding-left: 50px
            }

            html[dir=rtl] .reward-wrap {
                padding-right: 50px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .reward-wrap {
                padding-left: 50px
            }

            html[dir=rtl] .reward-wrap {
                padding-right: 50px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .reward-wrap {
                padding: 0 60px
            }
        }

        @media only screen and (max-width: 767px) {
            .reward-wrap {
                padding: 0 40px
            }
        }

        .reward-content {
            border-radius: 20px;
            padding: 95px 0 80px 0;
            position: relative;
            z-index: 1
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .reward-content {
                padding: 40px 0 50px 0
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .reward-content {
                padding: 55px 0 40px 0
            }
        }

        @media only screen and (max-width: 767px) {
            .reward-content {
                border-radius: 27px;
                padding: 40px 0
            }
        }

        .reward-content::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: -1;
            border-radius: 20px
        }

        .reward-content::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.4) url({{asset('public/frontend/infixlmstheme/img/shape/reward-bg.jpg')}}) no-repeat center;
            background-size: cover;
            z-index: -2;
            border-radius: 20px;
            filter: blur(6px);
        }

        .reward-content h3 {
            font-size: 48px;
            line-height: 1.25;
            color: #fff;
            margin-bottom: 20px
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .reward-content h3 {
                font-size: 42px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .reward-content h3 {
                font-size: 36px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .reward-content h3 {
                font-size: 32px
            }
        }

        @media only screen and (max-width: 767px) {
            .reward-content h3 {
                font-size: 28px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .reward-content h3 {
                margin-bottom: 10px
            }
        }

        @media only screen and (max-width: 767px) {
            .reward-content h3 {
                margin-bottom: 10px
            }
        }

        .reward-content p {
            font-size: 18px;
            line-height: 1.77778;
            color: #fff!important;
            margin-bottom: 34px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .reward-content p {
                margin-bottom: 24px
            }
        }

        @media only screen and (max-width: 767px) {
            .reward-content p {
                margin-bottom: 20px
            }
        }

        @media only screen and (max-width: 767px) {
            .reward-content p {
                font-size: 16px
            }
        }

        .reward-content .theme-btn {
            --btn-padding-y: 16px;
            color: #596688
        }

    </style>

    <div class="reward">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="reward-content">
                        <div class="row">
                            <div class="reward-img p-0">
                                <img src="{{themeAsset('img/others/reward-cup.png')}}" alt="">
                            </div>
                            <div class="col-lg-7">
                                <div class="reward-wrap">
                                    <h3>Win Reward Points</h3>
                                    <p>Buy course, complete course, incarese activity & many more way to win club
                                        points. You will
                                        be able to use your club points to get free prizes and courses. Start using the
                                        system now
                                        and collect points!</p>
                                    <a href="{{url('courses')}}" class="theme-btn rounded-pill bg-white">View All
                                        Courses</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
