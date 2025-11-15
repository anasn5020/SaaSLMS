<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/shop/2.jpg')}}"
     data-aoraeditor-title="Store Section V2" data-aoraeditor-categories="Home Page">

    <style>
        .shop {
            position: relative;
            z-index: 1;
            padding-bottom: 60px
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .shop {
                padding-bottom: 30px
            }
        }

        .shop-shape {
            --size: 180px;
            width: var(--size);
            height: var(--size);
            position: absolute;
            top: calc(var(--size) / 2 * -1);
            right: 30px;
            z-index: 2
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .shop-shape {
                --size: 110px
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .shop-shape {
                --size: 110px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .shop-shape {
                display: none
            }
        }

        @media only screen and (max-width: 991px) {
            .shop-shape {
                display: none
            }
        }

        .shop-slider .owl-stage-outer {
            padding: 26px 0px;
            margin: -26px 0px
        }

        .shop-slider .owl-item img {
            width: 100% !important
        }

        .shop-slider .shop-item {
            margin-top: 0 !important
        }

        .shop-item {
            border-radius: 30px;
            padding: 30px;
            margin-top: 30px;
            overflow: hidden;
            position: relative;
            bottom: 0;
            box-shadow: 20px 7px 23px rgba(0, 0, 0, 0);
            transition: all .4s ease-in-out
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .shop-item {
                padding: 20px
            }
        }

        @media only screen and (max-width: 991px) {
            .shop-item {
                padding: 24px
            }
        }

        @media only screen and (max-width: 767px) {
            .shop-item {
                margin-top: 24px
            }
        }

        .shop-item:hover {
            bottom: 3px;
            box-shadow: 20px 7px 23px rgba(44, 36, 36, 0.15)
        }

        .shop-item-rating {
            display: inline-block;
            width: max-content;
            font-size: 12px;
            line-height: 1.5;
            background-color: #fff;
            border-radius: 100px;
            padding: 4px 10px;
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
            box-shadow: 2px 4px 26px 10px rgba(0, 0, 0, 0.1)
        }

        .shop-item-img {
            width: 100%;
            padding-bottom: 80%;
            position: relative;
            overflow: hidden;
            border-radius: 26px;
            margin-bottom: 12px
        }

        .shop-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            z-index: 0
        }

        .shop-item-content span {
            font-size: 14px;
            line-height: 1.5;
            color: var(--system_primery_color_70);
            letter-spacing: 0.005em;
            display: block;
            margin-bottom: 10px
        }

        .shop-item-content h4 {
            font-size: 20px;
            line-height: 1.5;
            line-height: 1.2;
            font-weight: 500;
            margin-bottom: 20px;
            color: #636676;
            cursor: pointer
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .shop-item-content h4 {
                font-size: 18px
            }
        }

        @media only screen and (max-width: 991px) {
            .shop-item-content h4 {
                font-size: 18px
            }
        }

        @media only screen and (max-width: 991px) {
            .shop-item-content h4 {
                margin-bottom: 10px
            }
        }

        @media only screen and (max-width: 767px) {
            .shop-item-content h4 {
                font-size: 20px
            }
        }

        .shop-item-content h4:hover {
            color: var(--system_primery_color)
        }

        .shop-item-content strong {
            font-size: 32px;
            line-height: 1.25;
            color: var(--system_primery_color)
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .shop-item-content strong {
                font-size: 28px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .shop-item-content strong {
                font-size: 26px
            }
        }

        @media only screen and (max-width: 767px) {
            .shop-item-content strong {
                font-size: 24px
            }
        }

        .shop-item-content .theme-btn {
            font-size: 12px;
            font-weight: 500;
            line-height: 1.5;
            --btn-padding-y: 8px;
            --btn-padding-x: 10px
        }

        .shop-item-content .theme-btn i {
            margin-right: 6px
        }

    </style>
    <div class="shop">
        <div class="shop-shape"><img src="{{themeAsset('img/shape/shop.png')}}" alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-subtitle">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h3 class="mb-0 text-white">{{trans('store.Store')}}</h3>
                            </div>
                            <div class="section-subtitle-action mt-0">
                                <a href="{{validRouteUrl('store.products')}}"
                                   class="theme-btn bg-white ms-2">{{__('product.All Products')}}</a>
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
                     data-order="id"
                     data-limit="4"
                     data-where-type="5"
                     data-where-status="1"
                     data-view="_single_section_store"
                     data-model="Modules\CourseSetting\Entities\Course"
                     data-with="product">

                    <div class="dynamicData"
                         data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                </div>
            </div>
        </div>
    </div>

</div>
