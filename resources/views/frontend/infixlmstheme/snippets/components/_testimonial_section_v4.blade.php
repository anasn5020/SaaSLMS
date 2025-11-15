<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/testimonials/4.jpg')}}"
     data-aoraeditor-title="Testimonial Section V4" data-aoraeditor-categories="Testimonials;Home Page">

    <style>
        @media only screen and (min-width: 1581px) {
            .testimonial-slider {
                padding: 0px 75px
            }
        }

        .testimonial-slider .owl-stage {
            display: flex
        }

        .testimonial-slider .owl-stage-outer {
            padding-bottom: 60px;
            margin-bottom: -60px;
            padding-top: 30px;
            margin-top: -30px
        }

        .testimonial-slider .owl-item {
            width: 100%;
            display: flex
        }

        .testimonial-slider .owl-dots {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%)
        }

        @media only screen and (max-width: 767px) {
            .testimonial-slider .owl-dots {
                top: auto;
                bottom: 0
            }
        }

        .testimonial-single {
            border-radius: 80px;
            border-bottom-right-radius: 21px;
            padding: 0px 36px;
            padding-bottom: 40px;
            background-color: #fff;
            color: #98A6B4;
            position: relative;
            z-index: 1;
            top: 0;
            width: 100%;
            box-shadow: 0px 14px 50px rgba(0, 0, 0, 0.08);
            transition: all .4s ease-in-out
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .testimonial-single {
                padding: 0px 20px;
                padding-bottom: 30px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .testimonial-single {
                padding: 0px 26px;
                padding-bottom: 30px
            }
        }

        @media only screen and (max-width: 991px) {
            .testimonial-single {
                padding: 0px 26px;
                padding-bottom: 30px
            }
        }

        .testimonial-single::after {
            content: "“";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            color: transparent;
            font-size: 400px;
            line-height: 1.4;
            font-family: var(--fontFamily2);
            z-index: -1;
            width: 100%;
            height: 100%;
            text-align: right;
            padding-right: 20px;
            -webkit-text-stroke: 1px rgba(152, 166, 180, 0.4);
            opacity: 0.2
        }

        html[dir=rtl] .testimonial-single::after {
            text-align: left;
            padding-right: 0;
            padding-left: 20px;
        }

        @media only screen and (min-width: 1440px) and (max-width: 1580px) {
            .testimonial-single::after {
                font-size: 290px;
                line-height: 1.5
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .testimonial-single::after {
                font-size: 250px;
                line-height: 1.5
            }
        }

        @media only screen and (max-width: 991px) {
            .testimonial-single::after {
                font-size: 200px;
                line-height: 1.7
            }
        }

        @media only screen and (max-width: 767px) {
            .testimonial-single::after {
                line-height: 1.6
            }
        }

        .testimonial-single:hover {
            top: -6px
        }

        .testimonial-single p, .testimonial-single span {
            color: currentColor
        }

        .testimonial-top {
            border: 5px solid #636676;
            background-color: #636676;
            border-radius: 24px;
            border-top-right-radius: 10px;
            padding: 6px 24px;
            margin-top: -31px;
            margin-bottom: 40px
        }

        html[dir=rtl] .testimonial-top {
            border-top-right-radius: 24px;
            border-top-left-radius: 10px;
        }

        @media only screen and (max-width: 991px) {
            .testimonial-top {
                padding: 4px 16px
            }
        }

        .testimonial-top span {
            color: #fff
        }

        @media only screen and (max-width: 991px) {
            .testimonial-top span {
                font-size: 14px
            }
        }

        .testimonial-top .rating {
            line-height: 1 !important
        }

        .testimonial-content {
            margin-top: var(--top-sp);
            overflow: auto
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .testimonial-content {
                margin-top: 26px;
                margin-bottom: 20px !important
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .testimonial-content {
                margin-top: 26px;
                margin-bottom: 20px !important
            }
        }

        @media only screen and (max-width: 767px) {
            .testimonial-content {
                margin-top: 20px;
                margin-bottom: 16px !important
            }
        }

        .testimonial-content p {
            line-height: 1.75;
            overflow: hidden;
            display: -webkit-box;
            line-clamp: 4;
            min-height: 112px;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            color: var(--system_paragraph_color);

        }

        @media only screen and (max-width: 767px) {
            .testimonial-content p {
                font-size: 14px
            }
        }

        .testimonial-user-img {
            --user-img: 40px;
            width: var(--user-img);
            height: var(--user-img);
            border-radius: 100%;
            border: 2px solid #F7EFFF;
            overflow: hidden
        }

        .testimonial-user-img img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover
        }

        .testimonial-user span {
            color: #636676;
            font-size: 12px;
            line-height: 1;
            letter-spacing: 0.05em
        }

        .testimonial-user p {
            color: #636676;
            font-family: var(--fontFamily1);
            line-height: 1
        }

        .testimonial-user p strong {
            font-weight: 600
        }

    </style>
    <div class="testimonial position-relative section-margin-lg pt-4 pt-lg-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div data-type="component-nonExisting"
                         data-preview=""
                         data-table=""
                         data-select="image,author,star,body,profession"
                         data-order="id"
                         data-limit="0"
                         data-view="_single_testimonial_v3"
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
