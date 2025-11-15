<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/categories/1.jpg')}}"
     data-aoraeditor-title="Category V3" data-aoraeditor-categories="Home Page;Categories">

    <style>
        .category {
            background-color: #ECEFFD;
            padding-bottom: 350px
        }

        .category .section-title {
            margin-bottom: 90px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category .section-title {
                margin-bottom: 70px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .category .section-title {
                margin-bottom: 50px
            }
        }

        @media only screen and (max-width: 767px) {
            .category .section-title {
                margin-bottom: 30px
            }
        }

        .category .section-title h2 {
            margin-bottom: 15px
        }

        .category .section-title p {
            font-size: 18px;
            line-height: 1.55556
        }

        @media only screen and (max-width: 991px) {
            .category .section-title p {
                font-size: 16px
            }
        }

        .category-item {
            --icon: 136px;
            background-color: #fff;
            padding: 30px;
            padding-bottom: 36px;
            text-align: center;
            display: block;
            border-radius: 8px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category-item {
                --icon: 106px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .category-item {
                --icon: 100px
            }
        }

        @media only screen and (max-width: 767px) {
            .category-item {
                --icon: 80px
            }
        }

        .category-item:hover h6 {
            color: var(--system_primery_color)
        }

        .category-item-icon {
            width: var(--icon);
            height: var(--icon);
            border-radius: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: var(--system_primery_color);
            background-size: 200% auto;
            margin: 0 auto;
            margin-bottom: 20px
        }

        .category-item-icon img, .category-item-icon svg {
            height: 54px;
            object-fit: contain
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category-item-icon img, .category-item-icon svg {
                height: 44px
            }
        }

        @media only screen and (max-width: 991px) {
            .category-item-icon img, .category-item-icon svg {
                height: 30px
            }
        }

        .category-item-content h6 {
            color: var(--system_secendory_color);
            font-family: var(--fontFamily1);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            font-size: 20px;
            line-height: 1.5;
            transition: all .4s ease-in-out
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category-item-content h6 {
                font-size: 18px
            }
        }

        @media only screen and (max-width: 991px) {
            .category-item-content h6 {
                font-size: 18px
            }
        }

        .category-item-content p {
            color: #A4ABBD;
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical
        }

        .category-cta {
            border-radius: 10px;
            padding: 0px 42px;
            position: relative;
            padding-left: var(--padding);
            --img-width: 270px;
            --padding: 230px;
            --img-position: -30px
        }

        html[dir=rtl] .category-cta {
            padding-left: 42px;
            padding-right: var(--padding);
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .category-cta {
                --padding: 210px;
                --img-width: 260px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category-cta {
                --padding: 180px;
                --img-width: 190px;
                --img-position: -20px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .category-cta {
                padding: 24px !important
            }
        }

        @media only screen and (max-width: 767px) {
            .category-cta {
                padding: 20px 25px !important
            }
        }

        .category-cta.bg-primary {
            color: #fff;
            border-radius: 10px;
            padding-left: 1rem !important;
            padding-right: var(--padding)
        }

        html[dir=rtl] .category-cta.bg-primary {
            padding-right: 1rem !important;
            padding-left: var(--padding);
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category-cta.bg-primary {
                padding-left: 2rem !important
            }

            html[dir=rtl] .category-cta.bg-primary {
                padding-right: 2rem !important;
            }
        }

        @media only screen and (max-width: 767px) {
            .category-cta.bg-primary {
                padding-right: inherit;
                margin-top: 30px
            }

            html[dir=rtl] .category-cta.bg-primary {
                padding-left: inherit;
            }
        }

        .category-cta.bg-primary .category-cta-img {
            left: auto;
            right: var(--img-position)
        }

        html[dir=rtl] .category-cta.bg-primary .category-cta-img {
            left: var(--img-position);
            right: auto;
        }

        .category-cta.bg-primary h3, .category-cta.bg-primary p {
            color: currentColor
        }

        .category-cta.bg-primary a {
            background-color: #fff;
            color: var(--system_primery_color)
        }

        .category-cta.bg-primary a:hover {
            background-color: var(--system_secendory_color);
            color: #fff
        }

        .category-cta-img {
            max-width: var(--img-width);
            flex: 0 0 100%;
            height: 300px;
            position: absolute;
            bottom: 0;
            left: var(--img-position)
        }

        html[dir=rtl] .category-cta-img {
            left: auto;
            right: var(--img-position);
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .category-cta-img {
                height: auto
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category-cta-img {
                height: auto
            }
        }

        @media only screen and (max-width: 991px) {
            .category-cta-img {
                display: none
            }
        }

        .category-cta-img img {
            width: 100%;
            height: 100%;
            object-fit: contain
        }

        .category-cta-content {
            max-width: 100%;
            flex: 0 0 100%;
            padding: 40px 0px;
            padding-left: 30px
        }

        html[dir=rtl] .category-cta-content {
            padding-right: 30px;
            padding-left: 0;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category-cta-content {
                padding: 30px 0px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .category-cta-content {
                padding: 0;
                max-width: 100%
            }
        }

        @media only screen and (max-width: 767px) {
            .category-cta-content {
                padding: 20px 0px
            }
        }

        @media only screen and (max-width: 479px) {
            .category-cta-content {
                padding: 0;
                max-width: 100%
            }
        }

        .category-cta-content h3 {
            font-size: 32px;
            line-height: 1.25;
            padding-right: 12%;
            margin-bottom: 12px
        }

        html[dir=rtl] .category-cta-content h3 {
            padding-right: 0;
            padding-left: 12%;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category-cta-content h3 {
                font-size: 28px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .category-cta-content h3 {
                font-size: 26px
            }
        }

        @media only screen and (max-width: 767px) {
            .category-cta-content h3 {
                font-size: 24px
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .category-cta-content h3 {
                font-size: 28px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .category-cta-content h3 {
                padding-right: 0;
                font-size: 24px
            }

            html[dir=rtl] .category-cta-content h3 {
                padding-left: 0;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .category-cta-content h3 {
                padding: 0
            }
        }

        @media only screen and (max-width: 767px) {
            .category-cta-content h3 {
                padding-right: 0
            }

            html[dir=rtl] .category-cta-content h3 {
                padding-left: 0
            }
        }

        .category-cta-content p {
            margin-bottom: 18px
        }

        .category-cta-content .theme-btn {
            --btn-padding-y: 9px;
            --btn-padding-x: 18px
        }

    </style>
    <div class="category section-padding-sm position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 text-center">
                    <div class="section-title">
                        <h2>All Categories</h2>
                        <p>Amet minim non deserunt ullamco est sit aliqua dolor do amet sint velit officia consequs</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="col-12">
                        <div data-type="component-nonExisting"
                             data-preview=""
                             data-table=""
                             data-select="image,name,id,thumbnail,total_courses"
                             data-order="id"
                             data-limit="0"
                             data-where-status="1"
                             data-view="_single_category_v3"
                             data-model="Modules\CourseSetting\Entities\Category"
                             data-with=""
                             data-with-count="courses"
                        >
                            <div class="dynamicData"
                                 data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


