<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/reward/1.jpg')}}"
     data-aoraeditor-title="Reward With Footer V1" data-aoraeditor-categories="Home Page">

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
            background-color: var(--footer_background_color);
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .reward {
                margin-bottom: -190px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .reward {
                margin-bottom: -280px
            }
        }

        .reward + * + .footer, .reward + .footer {
            padding-top: calc(260px + 120px)
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .reward + * + .footer, .reward + .footer {
                padding-top: calc(260px + 70px)
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .reward + * + .footer, .reward + .footer {
                padding-top: calc(260px + 30px)
            }
        }

        @media only screen and (max-width: 767px) {
            .reward + * + .footer, .reward + .footer {
                padding-top: calc(260px + 10px)
            }
        }

        .reward-img {
            width: 100%;
            position: relative;
            padding-left: 50px;
            padding-bottom: 78%
        }

        html[dir=rtl] .reward-img {
            padding-left: 0;
            padding-right: 50px;
        }

        @media only screen and (max-width: 991px) {
            .reward-img {
                padding-bottom: 30%
            }
        }

        .reward-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .reward-img {
                margin: auto;
                margin-bottom: 30px
            }
        }

        @media only screen and (max-width: 767px) {
            .reward-img {
                left: 0;
                width: 80%;
                margin: auto;
                margin-bottom: 30px
            }
        }

        .reward-wrap {
            padding: 0 70px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .reward-wrap {
                padding-left: 50px
            }

            html[dir=rtl] .reward-wrap {
                padding-left: 70px;
                padding-right: 50px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .reward-wrap {
                padding: 0 50px
            }
        }

        @media only screen and (max-width: 767px) {
            .reward-wrap {
                padding: 0 30px
            }
        }

        .reward-content {
            background-color: #fff;
            border-radius: 47px;
            padding: 40px 0 50px 0;
            position: relative;
            z-index: 1
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .reward-content {
                padding: 30px 0 40px 0
            }
        }

        @media only screen and (max-width: 767px) {
            .reward-content {
                border-radius: 27px
            }
        }

        .reward-content h3 {
            font-size: 48px;
            line-height: 1.25;
            color: var(--system_primery_color);
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
            color: #A4ABBD;
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
            --btn-padding-y: 16px
        }

        .reward-position {
            --shape-height: 200px;
            position: absolute;
            top: calc(var(--shape-height) / 2 * -1);
            right: -20px;
            height: var(--shape-height)
        }

        html[dir=rtl] .reward-position {
            right: auto;
            left: -20px;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .reward-position {
                --shape-height: 150px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .reward-position {
                --shape-height: 130px
            }
        }

        @media only screen and (max-width: 767px) {
            .reward-position {
                --shape-height: 80px;
                right: 0
            }

            html[dir=rtl] .reward-position {
                left: auto;
            }
        }

        .reward-position img {
            width: 100%;
            height: 100%;
            object-fit: contain
        }

    </style>

    <div class="reward">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="reward-content">
                        <div class="reward-position">
                            <img src="{{themeAsset('img/shape/reward-position.png')}}" alt="">
                        </div>
                        <div class="row align-items-center">
                            <div class="col-lg-5">
                                <div class="reward-img">
                                    <img src="{{themeAsset('img/others/reward-img.png')}}" alt="">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="reward-wrap">
                                    <h3>Win Reward Points</h3>
                                    <p>Buy course, complete course, incarese activity & many more way to win club
                                        points. You will be able to use your club points to get free prizes and courses.
                                        Start using the system now and collect points!</p>
                                    <a href="{{url('courses')}}" class="theme-btn">View All Courses</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
