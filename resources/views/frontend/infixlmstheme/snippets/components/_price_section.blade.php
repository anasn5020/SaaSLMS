<div data-type="component-text"
     data-preview="{{ !function_exists('themeAsset') ? '' : themeAsset('img/snippets/preview/price/1.jpg') }}"
     data-aoraeditor-title="Price V1" data-aoraeditor-categories="Price;Home Page">

    <style>
        .price:not(.classes-item-content .price) {
            position: relative;
            z-index: 0;
            margin-top: var(--section-sepreate-lg)
        }

        .price .row:not(:first-child) {
            margin-bottom: -24px
        }

        .price-package {
            background-color: #fff;
            border-radius: 3px;
            display: inline-flex
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .price-package {
                margin-top: 30px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-package {
                margin-top: 26px
            }
        }

        .price-package a {
            min-width: 127px !important;
            background-color: transparent;
            justify-content: center;
            color: #98A6B4 !important;
            --btn-padding-y: 14px !important;
            border-radius: 3px !important
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .price-package a {
                min-width: 116px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-package a {
                --btn-padding-y: 10px
            }
        }

        .price-package a.active {
            background: var(--system_primery_color);
            background-size: 200% auto;
            color: #fff !important
        }

        .price .row .col-sm-6,
        .price .row .col {
            padding-right: calc(var(--bs-gutter-x) * .5);
            padding-left: calc(var(--bs-gutter-x) * .5)
        }

        @media (min-width: 992px) {
            .price .row .col-sm-6:first-child > *,
            .price .row .col:first-child > * {
                border-top-left-radius: 16px;
                border-bottom-left-radius: 16px
            }

            html[dir=rtl] .price .row .col-sm-6:first-child > *,
            html[dir=rtl] .price .row .col:first-child > * {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                border-top-right-radius: 1rem;
                border-bottom-right-radius: 1rem;
            }
        }

        @media (min-width: 992px) {
            .price .row .col-sm-6:last-child > *,
            .price .row .col:last-child > * {
                border-top-right-radius: 16px;
                border-bottom-right-radius: 16px;
                border: none
            }

            html[dir=rtl] .price .row .col-sm-6:last-child > *,
            html[dir=rtl] .price .row .col:last-child > * {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
                border-top-left-radius: 1rem;
                border-bottom-left-radius: 1rem;
            }
        }

        .price-item {
            width: 100%;
            position: relative;
            z-index: 1;
            overflow: hidden;
            background-color: #fff;
            border-right: 1px solid rgba(164, 171, 189, 0.3);
        }

        html[dir=rtl] .price-item {
            border-right: none;
            border-left: 1px solid rgba(164, 171, 189, 0.3);
        }

        @media only screen and (max-width: 991px) {
            .price-item {
                border-radius: 16px;
                margin-bottom: 24px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-item {
                text-align: center
            }
        }

        .price-item.populer {
            border-radius: 16px
        }

        .price-item-meta {
            display: flex;
            align-items: center;
            min-height: 90px;
            font-family: var(--fontFamily2);
            color: #fff;
            padding: 15px 35px;
            background-color: var(--system_secendory_color);
            font-size: 32px;
            line-height: 1.25;
            font-weight: 600
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item-meta {
                font-size: 28px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .price-item-meta {
                font-size: 26px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-item-meta {
                font-size: 24px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item-meta {
                padding-left: 25px;
                padding-right: 25px;
                min-height: 70px
            }
        }

        @media only screen and (max-width: 991px) {
            .price-item-meta {
                padding-left: 20px;
                padding-right: 20px;
                min-height: 70px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-item-meta {
                min-height: 60px;
                justify-content: center
            }
        }

        .price-item-content {
            padding: 45px 35px;
            padding-top: 0 !important
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .price-item-content {
                padding: 35px 25px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item-content {
                padding: 30px 25px
            }
        }

        @media only screen and (max-width: 991px) {
            .price-item-content {
                padding: 25px 30px
            }
        }

        .price-item-content h4 {
            font-size: 38px;
            line-height: 1.25;
            color: #596688;
            font-weight: 600;
            margin-bottom: 0;
            margin-top: 28px
        }

        /* @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .price-item-content h4 {
                font-size: 54px
            }
        } */

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item-content h4 {
                font-size: 30px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .price-item-content h4 {
                font-size: 26px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-item-content h4 {
                font-size: 24px
            }
        }

        @media (max-width: 1279px) {
            .price-item-content h4 {
                margin-top: 20px
            }
        }

        .price-item-content h4 span {
            font-size: 16px;
            line-height: 1.5
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item-content h4 span {
                font-size: 28px
            }
        }

        .price-item-content h4 small {
            font-size: 16px;
            line-height: 1.625
        }

        .price-item-content ul {
            margin-top: 20px
        }

        .price-item-content ul li {
            font-size: 14px;
            line-height: 2.14286
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item-content ul li {
                line-height: 1.71429
            }
        }

        .price-item-content ul li:not(:last-child) {
            margin-bottom: 18px
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .price-item-content ul li:not(:last-child) {
                margin-bottom: 12px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item-content ul li:not(:last-child) {
                margin-bottom: 10px
            }
        }

        @media only screen and (max-width: 991px) {
            .price-item-content ul li:not(:last-child) {
                margin-bottom: 12px
            }
        }

        .price-item-content h5 {
            overflow: hidden;
            margin-bottom: 0;
            margin-top: 10px;
        }

        .price-item-content h5 a {
            color: #fff;
            border-radius: 4px;
            font-size: 14px;
            padding: 7px;
            overflow: hidden;
            display: inline-block;
            margin: 0;
            text-align: center;
            min-width: 136px;
        }

        .price-item-content a,
        .price-item-content button {
            padding: 8px 22px;
            min-width: 150px;
            background-color: var(--system_secendory_color);
            font-size: 20px;
            line-height: 1.5;
            font-weight: 500;
            font-family: var(--fontFamily2);
            margin-top: 110px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item-content a {
                font-size: 18px
            }
        }

        @media only screen and (max-width: 991px) {
            .price-item-content a {
                font-size: 18px
            }
        }

        .price-item-content a:hover {
            background: var(--system_primery_color) !important;
            border-color: var(--system_primery_color) !important;
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .price-item-content a {
                margin-top: 70px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item-content a {
                margin-top: 60px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .price-item-content a {
                margin-top: 50px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-item-content a {
                margin-top: 35px
            }
        }
    </style>
    <div class="price position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="section-subtitle v2">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h3 class="mb-0 text-white">Subscription Plan</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div data-type="component-nonExisting"
                     data-preview=""
                     data-table=""
                     data-select=""
                     data-order="order"
                     data-limit="0"
                     data-where-status="1"
                     data-view="_single_price_section"
                     data-model="Modules\Subscription\Entities\CourseSubscription"
                     data-with="features">
                    <div class="dynamicData"
                         data-dynamic-href="{{ routeIsExist('getDynamicData') ? route('getDynamicData') : '' }}"></div>
                </div>
            </div>
        </div>
    </div>

</div>
