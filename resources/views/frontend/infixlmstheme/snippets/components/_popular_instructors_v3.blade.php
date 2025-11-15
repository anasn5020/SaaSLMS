<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/instractor/3.jpg')}}"
     data-aoraeditor-title="Instructor Section V3" data-aoraeditor-categories="Instructor Page;Home Page;Instructors">


    <style>
        .instrucotr {
            padding: var(--section-sepreate-lg) 0
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .instrucotr {
                --section-sepreate-lg: 110px;
                overflow: hidden
            }
        }

        .instrucotr .section-title img, .instrucotr .section-title svg {
            margin-bottom: 36px
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

        .instrucotr-slider .owl-nav > * {
            margin-top: var(--sp);
            background-color: var(--system_primery_color_20) !important
        }

        .instrucotr-slider .owl-nav > *:hover {
            background: var(--system_primery_color) !important
        }

        .instrucotr-item {
            position: relative;
            z-index: 1;
            border-radius: 16px;
            overflow: hidden
        }
        .instrucotr-item:hover img {
            transform: scale(1.1);
            display: block;
        }

        .instrucotr-item:hover .instrucotr-item-content {
            transform: translateY(0px)
        }

        .instrucotr-item-img {
            width: 100%;
            padding-bottom: 130%;
            overflow: hidden;
            position: relative;
            display: block;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, #000 100%);
            box-shadow: 0px 11px 16px rgba(0, 0, 0, 0.15)
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
            position: absolute;
            left: 0;
            width: 100%;
            bottom: 0;
            z-index: 1;
            margin-bottom: 30px;
            transform: translateY(80px);
            transition: all .4s ease-in-out
        }

        @media only screen and (max-width: 767px) {
            .instrucotr-item-content {
                transform: translateY(70px)
            }
        }

        .instrucotr-item-content h4 {
            font-weight: 500;
            color: #fff;
            font-size: 32px;
            line-height: 1.25;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .instrucotr-item-content h4 {
                font-size: 28px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .instrucotr-item-content h4 {
                font-size: 26px
            }
        }

        @media only screen and (max-width: 767px) {
            .instrucotr-item-content h4 {
                font-size: 24px
            }
        }

        @media only screen and (max-width: 991px) {
            .instrucotr-item-content h4 {
                margin-bottom: 5px
            }
        }

        .instrucotr-item-content h4:hover {
            opacity: .8;
        }

        .instrucotr-item-content p {
            line-height: 1.3125;
            letter-spacing: 0.05em;
            margin-bottom: 20px;
            color: #A4ABBD!important;
        }

        .instrucotr-item-content ul li {
            margin: 0 !important
        }

        .instrucotr-item-actions {
            width: max-content;
            margin: auto
        }

        .become-instructor {
            --section-margin: 90px;
            margin-top: calc(var(--section-sepreate-md) + var(--section-margin));
            border-radius: 20px;
            z-index: 1;
            background: var(--system_primery_color)
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .become-instructor {
                --section-margin: 60px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .become-instructor {
                --section-margin: 70px
            }
        }

        @media only screen and (max-width: 767px) {
            .become-instructor {
                --section-margin: 70px
            }
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
            margin-right: 0;
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
        }

        .become-instructor-img::before {
            content: "";
            width: var(--shape-1);
            height: var(--shape-1);
            border-radius: 100%;
            background-color: #fff;
            opacity: .40;
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
            background-color: #CEE8FF;
            margin-right: 64px
        }

        .become-instructor-img .shape {
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
            border: 2px solid rgba(89, 102, 136, 0.7);
            z-index: 0;
            border-radius: 100%
        }

        html[dir=rtl] .become-instructor-img .shape::before {
            left: auto;
            right: -34px;
        }

        .become-instructor-content {
            padding: 0px 8.3333%
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .become-instructor-content {
                padding: 0
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .become-instructor-content {
                padding-left: 0
            }

            html[dir=rtl] .become-instructor-content {
                padding-left: 8.3333%;
                padding-right: 0;
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
            color: #fff
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
            color: #fff
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
            color: #777E93
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
                     data-view="_single_instructor_v3"
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
