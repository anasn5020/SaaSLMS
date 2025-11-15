<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/class/2.jpg')}}"
     data-aoraeditor-title="Classes Section V2" data-aoraeditor-categories="Home Page;Classes">

    <style>
        .classes-slider {
            --stage-mb: 40px
        }

        .classes-slider .classes-item {
            margin-top: 0 !important
        }

        .classes-slider .owl-stage-outer {
            padding-bottom: var(--stage-mb);
            margin-bottom: calc(var(--stage-mb) * -1)
        }

        .classes-slider .owl-item img {
            width: 100% !important
        }

        .classes-slider .owl-nav button {
            margin-top: calc(var(--stage-mb) * -2);
            box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.08) !important
        }

        .classes-item {
            margin-top: 55px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item {
                margin-top: 45px
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item {
                margin-top: 35px
            }
        }

        .classes-item:hover .classes-item-img img {
            transform: scale(1.02)
        }

        .classes-item-img {
            width: 100%;
            padding-bottom: 58%;
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            z-index: 1
        }

        @media only screen and (max-width: 991px) {
            .classes-item-img {
                padding-bottom: 70%
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
            opacity: .90;
            background: linear-gradient(262.24deg, rgba(40, 31, 58, 0.846) 15.85%, rgba(40, 31, 58, 0.135) 68.54%, rgba(40, 31, 58, 0.063) 80.57%, rgba(40, 31, 58, 0.018) 104.19%)
        }*/

        .classes-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            transform: scale(1);
            transition: all .4s ease-in-out;
            z-index: -2
        }

        .classes-item-info {
            position: absolute;
            top: 25px;
            right: 20px;
            z-index: 2;
            width: max-content
        }

        html[dir=rtl] .classes-item-info {
            right: auto;
            left: 20px;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item-info {
                top: 20px
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item-info {
                top: 15px;
                right: 15px
            }

            html[dir=rtl] .classes-item-info {
                left: 15px;
                right: auto;
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item-info ul {
                gap: 6px
            }
        }

        .classes-item-info ul li {
            --btn-padding-y: 4px;
            --btn-padding-x: 10px;
            font-size: 12px;
            line-height: 1.5;
            font-family: var(--fontFamily2);
            gap: 4px;
            width: max-content;
            border: none;
            border-radius: 100px;
            pointer-events: none
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .classes-item-info ul li {
                margin-bottom: 0 !important
            }
        }

        @media only screen and (max-width: 479px) {
            .classes-item-info ul li {
                margin-bottom: 0 !important
            }
        }

        .classes-item-content {
            background-color: #fff;
            border: 4px solid #fff;
            width: calc(100% - 80px);
            padding: 25px 26px;
            border-radius: 18px;
            margin-top: -50px;
            position: relative;
            z-index: 1;
            box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.08)
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item-content {
                padding: 20px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .classes-item-content {
                width: calc(100% - 20px);
                padding: 14px 17px;
                margin-top: -70px
            }
        }

        @media only screen and (max-width: 767px) {
            .classes-item-content {
                width: calc(100% - 30px);
                padding: 14px 17px
            }
        }

        @media only screen and (max-width: 479px) {
            .classes-item-content {
                margin-top: -80px
            }
        }

        .classes-item-content .content {
            max-width: calc(100% / 12 * 9);
            flex: 0 0 100%
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .classes-item-content .content {
                max-width: calc(100% / 12 * 8)
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item-content .content {
                max-width: calc(100% / 12 * 8)
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item-content .content {
                max-width: 100%
            }
        }

        .classes-item-content .price {
            max-width: calc(100% / 12 * 3);
            flex: 0 0 100%;
            position: relative;
            z-index: 1
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .classes-item-content .price {
                max-width: calc(100% / 12 * 4)
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item-content .price {
                max-width: calc(100% / 12 * 4)
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item-content .price {
                text-align: left !important;
                max-width: 100%;
                display: flex;
                align-items: center;
                margin-top: 8px
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
            background: radial-gradient(1700% 52.31% at 50% 50.77%, rgba(217, 217, 217, 0.6) 0%, rgba(217, 217, 217, 0.198) 51.04%, rgba(217, 217, 217, 0) 100%)
        }

        html[dir=rtl] .classes-item-content .price::before {
            left: auto;
            right: 0;
        }

        @media only screen and (max-width: 991px) {
            .classes-item-content .price::before {
                display: none
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
                font-size: 18px
            }
        }

        .classes-item-content h4:hover {
            color: var(--system_primery_color) !important
        }

        .classes-item-content del {
            font-size: 12px;
            line-height: 2.33333;
            opacity: .70;
            color: #98A6B4
        }

        .classes-item-content strong {
            font-size: 18px;
            line-height: 1.5
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .classes-item-content strong {
                font-size: 22px
            }
        }

        @media only screen and (max-width: 991px) {
            .classes-item-content strong {
                font-size: 20px
            }
        }

        .classes-item-content .theme-btn {
            font-size: 14px;
            line-height: 1.5;
            --btn-padding-y: 4px;
            --btn-padding-x: 10px
        }

        @media only screen and (max-width: 991px) {
            .classes-item-content .theme-btn {
                margin-left: auto
            }

            html[dir=rtl] .classes-item-content .theme-btn {
                margin-left: 0;
                margin-right: auto;
            }
        }

        .classes-item-date {
            font-size: 13px;
            line-height: 1.16667;
            margin-bottom: 10px;
            color: var(--system_paragraph_color);
        }

        .classes-item-user {
            color: #98A6B4
        }

        .classes-item-user:hover {
            color: var(--system_primery_color)
        }

        .classes-item-user #img {
            --user-img: 30px;
            width: var(--user-img);
            height: var(--user-img);
            border-radius: 100%;
            overflow: hidden;
            border: 0 solid var(--system_secendory_color);
            position: relative
        }

        .classes-item-user #img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1
        }

        @media only screen and (max-width: 991px) {
            .classes-item-user p {
                font-size: 14px
            }
        }

    </style>
    <div class="classes position-relative section-margin-lg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h2>Upcoming Live Class</h2>
                        <p>Choose from over 100,000 online video courses with new additions published every month</p>
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
                         data-where-status="1"
                         data-where-type="3"
                    >
                        <div class="dynamicData"
                             data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
