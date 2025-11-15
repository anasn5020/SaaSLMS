<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/testimonials/2.jpg')}}"
     data-aoraeditor-title="Testimonial Section V2" data-aoraeditor-categories="Testimonials;Home Page">

    <style>
        .testimonial {
            padding: 90px 180px;
            position: relative;
            z-index: 1
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .testimonial {
                padding: 50px 80px
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .testimonial {
                padding: 50px 50px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .testimonial {
                padding: 40px 30px
            }
        }

        @media only screen and (max-width: 991px) {
            .testimonial {
                padding: 40px 0
            }
        }

        .testimonial-slider {
            padding: 0 20px
        }

        @media (min-width: 1581px) {
            .testimonial-slider {
                padding: 0 40px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .testimonial-slider {
                padding: 0
            }
        }

        @media only screen and (max-width: 991px) {
            .testimonial-slider {
                padding: 0
            }
        }

        .testimonial-slider .owl-stage-outer {
            overflow: hidden !important;
        }

        .testimonial-slider .owl-dots {
            margin-top: 60px;
            background-color: #fff;
            border-radius: 100px;
            padding: 0 5px;
            display: flex;
            align-items: center
        }

        @media only screen and (max-width: 991px) {
            .testimonial-slider .owl-dots {
                margin-top: 40px
            }
        }

        .testimonial-slider .owl-dot {
            background: var(--system_primery_color) !important
        }

        .testimonial-img {
            position: absolute;
            bottom: 0px;
            left: 0px;
            z-index: 1;
            width: max-content
        }

        html[dir=rtl] .testimonial-img {
            left: auto;
            right: 0;
            transform: scaleX(-1)
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .testimonial-img {
                bottom: 0
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .testimonial-img {
                width: 420px;
                height: 770px;
                bottom: 0
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .testimonial-img {
                width: 380px;
                height: auto;
                bottom: 0px
            }
        }

        @media only screen and (max-width: 991px) {
            .testimonial-img {
                display: none
            }
        }

        .testimonial-img img {
            max-width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: bottom;
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .testimonial-img img {
                object-fit: cover
            }
        }

        .testimonial-top {
            margin-bottom: 26px
        }

        .testimonial-top .quote {
            width: 120px;
            height: 120px
        }

        .testimonial-top .quote::before {
            content: "“";
            color: transparent;
            font-size: 300px;
            line-height: .93333;
            font-family: var(--fontFamily2);
            width: 100%;
            height: 100%;
            -webkit-text-stroke: 1px #fff;
            opacity: 1;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%)
        }

        .testimonial-top .rating i {
            font-size: 24px;
            line-height: 1.5;
            color: #fff
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .testimonial-top .rating i {
                font-size: 22px
            }
        }

        @media only screen and (max-width: 991px) {
            .testimonial-top .rating i {
                font-size: 20px
            }
        }

        .testimonial-top .rating i:not(:last-child) {
            margin-right: 10px
        }

        html[dir=rtl] .testimonial-top .rating i:not(:last-child) {
            margin-left: 10px;
            margin-right: 0;
        }

        .testimonial-content {
            margin-bottom: 30px
        }

        .testimonial-content p {
            font-size: 32px;
            line-height: 1.25;
            line-height: 1.8125;
            color: #fff!important;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            min-height: 86px;
            color: var(--system_paragraph_color);
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .testimonial-content p {
                font-size: 20px;
                line-height: 1.6;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .testimonial-content p {
                font-size: 18px;
                line-height: 1.5;
            }
        }

        @media only screen and (max-width: 767px) {
            .testimonial-content p {
                font-size: 24px
            }
        }

        .testimonial-user {
            --user-img: 40px;
            display: inline-flex;
            align-items: center;
            flex-wrap: wrap;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 10px;
            min-width: 190px
        }

        .testimonial-user-img {
            width: var(--user-img);
            height: var(--user-img);
            flex: 0 0 auto;
            border-radius: 100%;
            border: 2px solid #fff;
            overflow: hidden
        }

        .testimonial-user-img img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover
        }

        .testimonial-user-content {
            width: calc(100% - var(--user-img));
            flex: 0 0 auto;
            padding: 0 10px;
            text-align: left
        }

        html[dir=rtl] .testimonial-user-content {
            text-align: right;
        }

        .testimonial-user-content p {
            color: #fff;
            font-family: var(--fontFamily2);
            line-height: 1;
            margin-bottom: 6px
        }

        .testimonial-user-content p strong {
            font-weight: 500;
            color: #fff;
        }

        .testimonial-user-content span {
            color: #fff;
            font-size: 12px;
            line-height: 1;
            letter-spacing: 0.05em;
            display: block
        }
    </style>
    <div class="testimonial bg-primary section-margin">
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-xl-3 col-lg-4">
                    <div class="testimonial-img">
                        <img src="{{themeAsset('img/shape/testimonial-img.png')}}" alt="">
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <div data-type="component-nonExisting"
                         data-preview=""
                         data-table=""
                         data-select="image,author,star,body,profession"
                         data-order="id"
                         data-limit="0"
                         data-view="_single_testimonial_v2"
                         data-model="Modules\SystemSetting\Entities\Testimonial"
                         data-where-status="1"
                         data-with="">
                        <div class="dynamicData"
                             data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
