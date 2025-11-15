<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/class/4.jpg')}}"
     data-aoraeditor-title="Classes Section Dark" data-aoraeditor-categories="Home Page;Classes">

    <style>
        .classes .section-subtitle-action .theme-btn {
            background: var(--system_primery_color);
            background-size: 200% auto;

            color: #ffffff;
        }

        .classes .section-subtitle-action .theme-btn:hover {
            background-color: var(--system_secendory_color_10);
            border-color: var(--system_secendory_color_10);
        }

        .classes-slider {
            --stage-mb: 40px;
        }

        .classes-slider .classes-item {
            margin-top: 0 !important;
        }

        .classes-slider .owl-stage-outer {
            padding-bottom: var(--stage-mb);
            margin-bottom: calc(var(--stage-mb) * -1);
        }

        .classes-slider .owl-item img {
            width: 100% !important;
        }

        .classes-slider .owl-nav button {
            margin-top: calc(var(--stage-mb) * -2);
            box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.08) !important;
        }

        .classes-item {
            margin-top: 55px;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item {
                margin-top: 45px;
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item {
                margin-top: 35px;
            }
        }

        .classes-item:hover .classes-item-img img {
            transform: scale(1.02);
        }

        .classes-item-img {
            width: 100%;
            padding-bottom: 58%;
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            z-index: 1;
        }

        @media only screen and (max-width: 991px) {
            .classes-item-img {
                padding-bottom: 70%;
            }
        }

        /*
        .classes-item-img::before {
            content: "";
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            opacity: 0.9;
            background: linear-gradient(262.24deg, rgba(40, 31, 58, 0.846) 15.85%, rgba(40, 31, 58, 0.135) 68.54%, rgba(40, 31, 58, 0.063) 80.57%, rgba(40, 31, 58, 0.018) 104.19%);
        }
        */

        .classes-item-img img {
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            transform: scale(1);
            transition: all 0.4s ease-in-out;
            z-index: -2;
        }

        .classes-item-info {
            position: absolute;
            top: 25px;
            right: 20px;
            z-index: 2;
            width: -moz-max-content;
            width: max-content;
        }

        html[dir=rtl] .classes-item-info {
            right: auto !important;
            left: 20px;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item-info {
                top: 20px;
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item-info {
                top: 15px;
                right: 15px;
            }

            html[dir=rtl] .classes-item-info {
                left: 15px;
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item-info ul {
                gap: 6px;
            }
        }

        .classes-item-info ul li {
            --btn-padding-y: 4px;
            --btn-padding-x: 10px;
            font-size: 12px;
            line-height: 1.5;
            font-family: var(--fontFamily2);
            gap: 4px;
            width: -moz-max-content;
            width: max-content;
            border: none;
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .classes-item-info ul li {
                margin-bottom: 0 !important;
            }
        }

        @media only screen and (max-width: 479px) {
            .classes-item-info ul li {
                margin-bottom: 0 !important;
            }
        }

        .classes-item-info ul li.bg-secondary {
            background-color: var(--system_secendory_color_10) !important;
        }

        .classes-item-content {
            background-color: #343944;
            border: 4px solid #343944;
            width: calc(100% - 80px);
            padding: 25px 26px;
            border-radius: 18px;
            margin-top: -50px;
            position: relative;
            z-index: 1;
            box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.08);
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item-content {
                padding: 20px;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .classes-item-content {
                width: calc(100% - 20px);
                padding: 14px 17px;
                margin-top: -70px;
            }
        }

        @media only screen and (max-width: 767px) {
            .classes-item-content {
                width: calc(100% - 30px);
                padding: 14px 17px;
            }
        }

        @media only screen and (max-width: 479px) {
            .classes-item-content {
                margin-top: -80px;
            }
        }

        .classes-item-content .content {
            max-width: 75%;
            flex: 0 0 100%;
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .classes-item-content .content {
                max-width: 66.6666666667%;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item-content .content {
                max-width: 66.6666666667%;
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item-content .content {
                max-width: 100%;
            }
        }

        .classes-item-content .price {
            max-width: 25%;
            flex: 0 0 100%;
            position: relative;
            z-index: 1;
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .classes-item-content .price {
                max-width: 33.3333333333%;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item-content .price {
                max-width: 33.3333333333%;
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item-content .price {
                text-align: left !important;
                max-width: 100%;
                display: flex;
                align-items: center;
                margin-top: 8px;
            }

            html[dir=rtl] .classes-item-content .price {
                text-align: right !important;
            }

        }

        .classes-item-content .price::before {
            content: "";
            width: 1px;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background: radial-gradient(1700% 52.31% at 50% 50.77%, rgba(217, 217, 217, 0.6) 0%, rgba(217, 217, 217, 0.198) 51.04%, rgba(217, 217, 217, 0) 100%);
        }

        html[dir=rtl] .classes-item-content .price::before {
            left: auto;
            right: 0
        }


        @media only screen and (max-width: 991px) {
            .classes-item-content .price::before {
                display: none;
            }
        }

        .classes-item-content h4 {
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            margin-bottom: 0;
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .classes-item-content h4 {
                font-size: 18px;
            }
        }

        .classes-item-content h4:hover {
            color: var(--system_primery_color) !important;
        }

        .classes-item-content del {
            font-size: 12px;
            line-height: 2.3333333333;
            opacity: 0.7;
            color: #98A6B4;
        }

        .classes-item-content strong {
            font-size: 18px;
            line-height: 1.5;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item-content strong {
                font-size: 22px;
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item-content strong {
                font-size: 20px;
            }
        }

        .classes-item-content .theme-btn {
            font-size: 14px;
            line-height: 1.5;
            --btn-padding-y: 4px;
            --btn-padding-x: 10px;
        }

        html[dir=rtl] .classes-item-content .theme-btn {
            margin-left: 0;
            margin-right: auto;
        }

        @media only screen and (max-width: 991px) {
            .classes-item-content .theme-btn {
                margin-left: auto;
            }
        }

        .classes-item-date {
            font-size: 13px;
            line-height: 1.1666666667;
            margin-bottom: 10px;
            color: var(--system_paragraph_color);
        }

        .classes-item-user {
            color: #98A6B4;
        }

        .classes-item-user:hover {
            color: var(--system_primery_color);
        }

        .classes-item-user #img {
            --user-img: 30px;
            width: var(--user-img);
            height: var(--user-img);
            border-radius: 100%;
            overflow: hidden;
            border: 0px solid var(--system_secendory_color);
            position: relative;
        }

        .classes-item-user #img img {
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }

        @media only screen and (max-width: 991px) {
            .classes-item-user p {
                font-size: 14px;
            }
        }

    </style>

    <div class="classes position-relative section-margin-lg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-subtitle">
                        <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-24 gap-3">
                            <div>
                                <h3 class="mb-0 text-white">Upcoming Live Class</h3>
                            </div>
                            <div class="section-subtitle-action mt-0">
                                <a href="{{url('classes')}}" class="theme-btn bg-primary">All Live Class</a>
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
                         data-select="id,type,slug,title,thumbnail,price,discount_price,created_at,updated_at,category_id,class_id,user_id,total_enrolled"
                         data-order="id"
                         data-limit="6"
                         data-view="_single_classes"
                         data-model="Modules\CourseSetting\Entities\Course"
                         data-with="class,class.category,user"
                         data-where-type="3"
                         data-where-status="1"
                    >
                        <div class="dynamicData"
                             data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
