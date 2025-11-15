<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/shop/1.jpg')}}"
     data-aoraeditor-title="Store Section V1" data-aoraeditor-categories="Home Page">

    <style>
        .shop {
            position: relative;
            z-index: 1
        }

        .shop-shape {
            display: none
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
            border-radius: 5px;
            padding: 30px;
            margin-top: 30px;
            overflow: hidden;
            position: relative;
            bottom: 0;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.08);
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
            bottom: 3px
        }

        .shop-item-rating {
            display: inline-block;
            width: max-content;
            font-size: 12px;
            line-height: 1.5;
            background-color: var(--system_secendory_color);
            border-radius: 4px;
            padding: 4px 10px;
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1
        }

        .shop-item-rating .text-primary {
            color: #fff !important
        }

        .shop-item-img {
            width: 100%;
            padding-bottom: 82%;
            position: relative;
            overflow: hidden;
            border-radius: 5px;
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
            color: #777E93;
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

        .shop-item-content del {
            color: rgba(164, 171, 189, 0.4)
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
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-subtitle v2">
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
