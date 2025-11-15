<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/instractor/4.jpg')}}"
     data-aoraeditor-title="Instructor Section Dark" data-aoraeditor-categories="Instructor Page;Home Page;Instructors">

    <style>
        .instrucotr {
            background-color: transparent !important
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .instrucotr {
                overflow: hidden
            }
        }

        .instrucotr .section-title img, .instrucotr .section-title svg {
            margin-bottom: 36px
        }

        .instrucotr .section-title h2 {
            color: #F0F3F8
        }

        .instrucotr .section-title p {
            color: #98A6B4
        }

        .instrucotr-shape {
            --width: 128px;
            position: absolute;
            top: calc(var(--width) / 2 * -1);
            left: 32px;
            width: var(--width);
            height: var(--width)
        }

        html[dir=rtl] .instrucotr-shape {
            left: auto !important;
            right: 32px;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .instrucotr-shape {
                --width: 100px;
                left: 10px;
                top: 0
            }
        }

        html[dir=rtl] .instrucotr-shape {
            right: 10px
        }

        @media only screen and (max-width: 767px) {
            .instrucotr-shape {
                display: none
            }
        }

        .instrucotr-slider {
            --sp: 10px;
            --pb: 50px
        }

        .instrucotr-slider .owl-stage-outer {
            padding-top: var(--sp);
            padding-bottom: var(--pb);
            margin-bottom: calc(var(--pb) * -1)
        }

        .instrucotr-slider .owl-nav button {
            margin-top: var(--sp);
            box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.08) !important
        }

        .instrucotr-item {
            padding-left: 13px
        }
        .instrucotr-item:hover img {
            transform: scale(1.1);
            display: block;
        }

        html[dir=rtl] .instrucotr-item {
            padding-left: 0;
            padding-right: 13px;
        }

        .instrucotr-item-head {
            position: relative;
            z-index: 1
        }

        .instrucotr-item-head::before {
            content: "";
            width: 150px;
            height: calc(100% - 130px);
            position: absolute;
            top: -10px;
            left: -13px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 48px
        }

        html[dir=rtl] .instrucotr-item-head::before {
            left: auto;
            right: -13px;
        }

        .instrucotr-item-head svg {
            position: absolute;
            left: 86px;
            top: -10px;
            color: #EEF0F6;
            z-index: 1
        }

        html[dir=rtl] .instrucotr-item-head svg {
            left: auto !important;
            right: 86px;
        }

        html[dir=rtl] .instrucotr-item-head svg {
            right: 66px;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .instrucotr-item-head svg {
                left: 66px
            }
        }

        .instrucotr-item-img {
            width: 100%;
            padding-bottom: 130%;
            overflow: hidden;
            position: relative;
            display: block;
            z-index: 1;
            border-radius: 44px;
            box-shadow: 0px 11px 16px rgba(0, 0, 0, 0.15);
            background-color: #ECEFFD
        }

        @media only screen and (max-width: 767px) {
            .instrucotr-item-img {
                padding-bottom: 100%
            }
        }

        .instrucotr-item-img img {
            width: 100% !important;
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .instrucotr-item-img img {
                height: 130%
            }
        }

        @media only screen and (max-width: 767px) {
            .instrucotr-item-img img {
                height: auto
            }
        }

        .instrucotr-item-content {
            box-shadow: 0 4px 40px rgba(0, 0, 0, 0.08);
            padding: 40px 15px;
            padding-top: 25px;
            border-radius: 20px;
            width: calc(100% - 60px);
            margin-top: -80px;
            position: relative;
            z-index: 2;
            background: var(--system_primery_color)
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .instrucotr-item-content {
                padding: 30px 0;
                padding-top: 20px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .instrucotr-item-content {
                padding: 24px 0;
                width: calc(100% - 20px)
            }
        }

        @media only screen and (max-width: 991px) {
            .instrucotr-item-content {
                padding: 20px 0;
                padding-top: 20px
            }
        }

        .instrucotr-item-content h4 {
            font-weight: 500;
            color: #fff
        }

        @media only screen and (max-width: 991px) {
            .instrucotr-item-content h4 {
                margin-bottom: 5px
            }
        }

        .instrucotr-item-content h4:hover {
            color: #1E1C19 !important
        }

        .instrucotr-item-content p {
            line-height: 1.3125;
            letter-spacing: 0.05em;
            margin-bottom: 20px;
            color: #fff
        }

        .instrucotr-item-content ul li {
            margin: 0 !important
        }

        .instrucotr-item-actions {
            width: max-content;
            margin: auto
        }

        .instrucotr-item-actions .social-list a:hover {
            background-color: var(--system_secendory_color_10)
        }

        .become-instructor {
            --section-margin: 90px;
            margin-top: calc(var(--section-sepreate-md) + var(--section-margin));
            background: var(--system_primery_color);
            background-size: 200% auto;
            border-radius: 104px 83px 45px 57px;
            z-index: 1
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .become-instructor {
                --section-margin: 60px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .become-instructor {
                --section-margin: 70px;
                border-radius: 60px 60px 30px 30px
            }
        }

        @media only screen and (max-width: 767px) {
            .become-instructor {
                --section-margin: 70px;
                border-radius: 50px 50px 20px 20px
            }
        }

        .become-instructor-shape {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: -50px
        }

        html[dir=rtl] .become-instructor-shape {
            right: auto !important;
            left: -50px;
        }

        html[dir=rtl] .become-instructor-shape {
            left: -30px;
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .become-instructor-shape {
                right: -30px
            }

            html[dir=rtl] .become-instructor-shape {
                left: -30px;
            }

        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .become-instructor-shape {
                right: -30px
            }

            html[dir=rtl] .become-instructor-shape {
                left: -30px;
            }

        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .become-instructor-shape {
                right: -30px
            }

            html[dir=rtl] .become-instructor-shape {
                left: -30px;
            }

        }

        @media only screen and (max-width: 767px) {
            .become-instructor-shape {
                display: none
            }
        }

        .become-instructor-shape svg {
            color: #fff !important
        }

        .become-instructor-img {
            --shape-1: 180px;
            --shape-2: 225px;
            --img-positon: 60px;
            width: 290px;
            height: 314px;
            position: relative;
            margin-top: -68px;
            margin-right: var(--img-positon)
        }

        html[dir=rtl] .become-instructor-img {
            margin-right: 0 !important;
            margin-left: var(--img-positon);
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .become-instructor-img {
                --shape-1: 150px;
                --shape-2: 185px;
                --img-positon: 40px;
                width: 260px;
                height: 284px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .become-instructor-img {
                margin-right: auto;
                --shape-1: 130px;
                --shape-2: 175px;
                --img-positon: 46px;
                width: 240px;
                height: 264px
            }
        }

        @media only screen and (max-width: 767px) {
            .become-instructor-img {
                --shape-1: 140px;
                --shape-2: 175px;
                width: 220px;
                height: 234px;
                margin-right: auto
            }

            html[dir=rtl] .become-instructor-img {
                margin-right: auto;
            }

        }

        .become-instructor-img::before {
            content: "";
            width: var(--shape-1);
            height: var(--shape-1);
            border-radius: 100%;
            background-color: var(--system_primery_color_20);
            position: absolute;
            bottom: 0;
            left: -20px
        }

        html[dir=rtl] .become-instructor-img::before {
            left: auto;
            right: -20px;
        }

        .become-instructor-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            z-index: 0
        }

        .become-instructor-img .shape {
            width: var(--shape-2);
            height: var(--shape-2);
            border-radius: 100%;
            position: absolute;
            bottom: 34px;
            right: calc(var(--img-positon) * -1);
            background-color: #16CE8C;
            margin-right: 64px
        }

        html[dir=rtl] .become-instructor-img .shape {
            right: auto;
            left: calc(var(--img-positon) * -1);
            margin-right: 0;
            margin-left: 64px;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .become-instructor-img .shape {
                bottom: 44px
            }
        }

        .become-instructor-img .shape::before {
            content: "";
            width: 100%;
            height: 100%;
            position: absolute;
            top: -10px;
            left: 34px;
            border: 2px solid rgba(238, 240, 246, 0.7);
            z-index: 0;
            border-radius: 100%
        }

        html[dir=rtl] .become-instructor-img .shape::before {
            left: auto;
            right: 34px;
        }

        .become-instructor-content {
            padding: 0px 8.3333%
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .become-instructor-content {
                padding: 0;
                padding-right: 20%
            }

            html[dir=rtl] .become-instructor-content {
                padding-right: 0;
                padding-left: 20%;
            }

        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .become-instructor-content {
                padding-left: 0;
                padding-right: 15%
            }

            html[dir=rtl] .become-instructor-content {
                padding-right: 0;
                padding-left: 15%;
            }

        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .become-instructor-content {
                padding-top: 30px;
                padding-bottom: 30px;
                text-align: center
            }
        }

        @media only screen and (max-width: 767px) {
            .become-instructor-content {
                padding-top: 20px;
                padding-bottom: 30px;
                text-align: center
            }
        }

        .become-instructor-content h3 {
            font-size: 40px;
            line-height: 1.5;
            line-height: 1.2;
            color: #EEF0F6
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .become-instructor-content h3 {
                font-size: 36px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .become-instructor-content h3 {
                font-size: 32px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .become-instructor-content h3 {
                font-size: 28px
            }
        }

        @media only screen and (max-width: 767px) {
            .become-instructor-content h3 {
                font-size: 26px
            }
        }

        @media only screen and (max-width: 767px) {
            .become-instructor-content h3 {
                margin-bottom: 5px
            }
        }

        .become-instructor-content p {
            font-size: 18px;
            line-height: 1.33333;
            color: #EEF0F6
        }

        @media only screen and (max-width: 991px) {
            .become-instructor-content p {
                font-size: 16px;
                line-height: 1.683
            }
        }

        @media only screen and (max-width: 767px) {
            .become-instructor-content p {
                margin-bottom: 15px !important
            }
        }

        .become-instructor-content .theme-btn {
            min-width: 174px;
            --btn-padding-y: 12px;
            color: var(--system_primery_color);
            background-color: #fff
        }

        .become-instructor-content .theme-btn:hover {
            color: #fff
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .become-instructor-content .theme-btn {
                --btn-padding-y: 10px;
                min-width: 134px
            }
        }

        @media only screen and (max-width: 767px) {
            .become-instructor-content .theme-btn {
                --btn-padding-y: 10px;
                min-width: max-content
            }
        }

    </style>
    <div class="instrucotr position-relative bg-white">
        <div class="instrucotr-shape"><img src="{{themeAsset('img/shape/team-shape.png')}}" alt=""></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="section-title">
                        <h2>{{__('frontend.Expert Teachers')}}</h2>
                        <p>{{__('frontend.Here is short details about our institute, Also you can see how we work')}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div data-type="component-nonExisting"
                     data-preview=""
                     data-table="users"
                     data-select="image,name,id,headline,total_rating,facebook,twitter,linkedin,instagram,youtube"
                     data-order="total_rating"
                     data-dir="desc"
                     data-limit="10"
                     data-view="_single_instructor_v4"
                     data-model=""
                     data-with=""
                     data-with-count=""
                     data-where-role_id="2"
                     data-where-status="1"
                >
                    <div class="dynamicData"
                         data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                </div>
            </div>
        </div>
    </div>
</div>
