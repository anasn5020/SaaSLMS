<div data-type="component-text"
     data-preview="{{ !function_exists('themeAsset') ? '' : themeAsset('img/snippets/preview/price/3.jpg') }}"
     data-aoraeditor-title="Price Dark" data-aoraeditor-categories="Price;Home Page">

    <style>
        .bg-orange-deep {
            background-color: #FBBC04 !important
        }

        .price {
            --card-sp: 55px;
            position: relative;
            z-index: 0
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .price {
                --card-sp: 45px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price {
                --card-sp: 25px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .price {
                --card-sp: 24px
            }
        }

        @media only screen and (max-width: 767px) {
            .price {
                --card-sp: 0
            }
        }

        .price-shape {
            --shape-width: 166px;
            width: var(--shape-width);
            height: var(--shape-width);
            position: absolute;
            top: 200px;
            right: 10px;
            z-index: -1
        }

        html[dir=rtl] .price-shape {
            right: auto;
            left: 10px;
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .price-shape {
                --shape-width: 126px;
                top: 180px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-shape {
                --shape-width: 106px;
                top: 70px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .price-shape {
                --shape-width: 86px;
                top: 70px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-shape {
                --shape-width: 76px;
                top: 60px;
                right: 0px
            }

            html[dir=rtl] .price-shape {
                right: auto;
                left: 0
            }

        }

        .price .section-title h2 {
            margin-bottom: 30px
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .price .section-title h2 {
                margin-bottom: 24px
            }
        }

        @media only screen and (max-width: 767px) {
            .price .section-title h2 {
                margin-bottom: 20px
            }
        }

        .price-package {
            background-color: #fff;
            border-radius: 100px;
            display: inline-flex;
            margin-top: 40px;
            margin-bottom: var(--card-sp);
            box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.08)
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
            min-width: 136px;
            justify-content: center;
            background-color: transparent;
            color: #98A6B4
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
            color: #fff
        }

        .price-item {
            border-radius: 44px;
            width: 100%;
            position: relative;
            z-index: 1;
            overflow: hidden;
            text-align: center;
            padding: 56px 64px;
            background-color: rgba(255, 255, 255, 0.05);
            box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.08)
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .price-item {
                padding-left: 40px;
                padding-right: 40px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item {
                padding: 36px 24px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .price-item {
                padding: 24px 16px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-item {
                border-radius: 24px;
                padding: 30px;
                width: 80%;
                margin: auto;
                margin-top: 30px !important
            }
        }

        @media only screen and (max-width: 479px) {
            .price-item {
                width: 100%
            }
        }

        .price-item-meta {
            display: inline-block;
            font-family: var(--fontFamily2);
            font-weight: 500;
            color: #fff;
            padding: 10px 15px;
            min-width: 200px;
            text-align: center;
            border-radius: 0px 0px 30px 30px;
            background-color: #EEF0F6;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            font-size: 24px;
            line-height: 1.5
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item-meta {
                font-size: 22px
            }
        }

        @media only screen and (max-width: 991px) {
            .price-item-meta {
                font-size: 20px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item-meta {
                padding: 6px 10px
            }
        }

        @media only screen and (max-width: 991px) {
            .price-item-meta {
                padding: 4px 10px;
                min-width: 160px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-item-meta {
                min-width: 140px
            }
        }

        .price-item h4 {
            font-size: 96px;
            line-height: 1.22917;
            color: #EEF0F6;
            font-weight: 600;
            margin-bottom: 0
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item h4 {
                font-size: 66px;
                margin-top: 20px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .price-item h4 {
                font-size: 46px;
                margin-top: 30px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-item h4 {
                font-size: 46px;
                margin-top: 20px !important
            }
        }

        .price-item h4 span {
            font-size: 32px;
            line-height: 1.5
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item h4 span {
                font-size: 28px
            }
        }

        .price-item h4 small {
            font-size: 16px;
            line-height: 1.625
        }

        .price-item img {
            width: 130px;
            filter: brightness(0) invert(1)
        }

        .price-item ul {
            margin: 30px 0px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item ul {
                margin: 25px 0px
            }
        }

        @media only screen and (max-width: 991px) {
            .price-item ul {
                margin: 20px 0px
            }
        }

        .price-item ul li {
            font-size: 18px;
            line-height: 2.77778
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item ul li {
                font-size: 16px;
                line-height: 2.3
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .price-item ul li {
                font-size: 15px;
                line-height: 1.5;
                margin-bottom: 12px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-item ul li {
                font-size: 16px;
                line-height: 2.3
            }
        }

        .price-item ul li:last-child {
            margin-bottom: 0 !important
        }

        .price-item a {
            display: block;
            background-color: #fff;
            padding: 16px 10px;
            font-size: 24px;
            line-height: 1.5;
            font-weight: 500;
            font-family: var(--fontFamily2)
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item a {
                font-size: 22px
            }
        }

        @media only screen and (max-width: 991px) {
            .price-item a {
                font-size: 20px
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .price-item a {
                font-size: 20px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .price-item a {
                font-size: 20px;
                padding: 12px 10px
            }
        }

        @media only screen and (max-width: 991px) {
            .price-item a {
                font-size: 18px;
                padding: 12px
            }
        }

        @media only screen and (max-width: 767px) {
            .price-item a {
                margin-top: 25px
            }
        }
    </style>
    <div class="price position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 text-center">
                    {{-- need to daynamic --}}
                    <div class="section-title">
                        <h2>Subscription plan</h2>
                        <p>You can save money, if you choose our any yearly plan, You can save if you choose our any
                            yearly plan</p>

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
                     data-view="_single_price_section_v2"
                     data-model="Modules\Subscription\Entities\CourseSubscription"
                     data-with="features">
                    <div class="dynamicData"
                         data-dynamic-href="{{ routeIsExist('getDynamicData') ? route('getDynamicData') : '' }}"></div>
                </div>
            </div>
        </div>
    </div>

</div>
