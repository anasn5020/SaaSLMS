<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/blog/2.jpg')}}"
     data-aoraeditor-title="Blog Section V2" data-aoraeditor-categories="Home Page;Blog">

    <style>
        .section-subtitle.v2 {
            padding-bottom: 30px;
            background: transparent !important;
            border-bottom: 1px solid var(--system_primery_color);
            border-radius: 0 !important
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .section-subtitle.v2 {
                margin-bottom: 50px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .section-subtitle.v2 {
                margin-bottom: 40px
            }
        }

        @media only screen and (max-width: 767px) {
            .section-subtitle.v2 {
                margin-bottom: 34px
            }
        }

        .section-subtitle.v2 .select2 {
            display: none !important
        }

        .section-subtitle.v2 > div {
            padding: 0 !important
        }

        .section-subtitle.v2 h3 {
            color: var(--system_primery_color) !important
        }

        .section-subtitle.v2 .theme-btn.bg-white {
            background: var(--system_primery_color) !important;
            color: #fff !important
        }

        .section-subtitle.v2 .theme-btn.bg-white:hover {
            background-color: var(--system_secendory_color) !important
        }

        .blog .section-title h2 {
            margin-bottom: 30px
        }

        @media only screen and (max-width: 767px) {
            .blog .section-title h2 {
                margin-bottom: 20px
            }
        }

        @media only screen and (max-width: 479px) {
            .blog .section-title h2 {
                margin-bottom: 10px
            }
        }

        @media only screen and (max-width: 767px) {
            .blog-slider {
                padding: 0px 10px
            }
        }

        .blog-slider .blog-single {
            margin-top: 0px;
            min-height: 423px
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .blog-slider .blog-single {
                min-height: 388px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .blog-slider .blog-single {
                min-height: 407px
            }
        }

        @media only screen and (max-width: 767px) {
            .blog-slider .blog-single {
                min-height: auto
            }
        }

        .blog-slider .owl-item img {
            width: 100% !important
        }

        .blog-single {
            border-radius: 4px;
            overflow: hidden;
            margin-top: 45px;
            position: relative;
            z-index: 1;
            box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.08)
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .blog-single {
                margin-top: 35px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .blog-single {
                margin-top: 35px
            }
        }

        @media only screen and (max-width: 991px) {
            .blog-single {
                margin-top: 30px
            }
        }

        .blog-single:hover .blog-single-img img {
            transform: scale(1.03)
        }

        .blog-single .course-item-rating > a {
            max-width: calc(100% / 12 * 6)
        }

        .blog-single .course-item-rating > div {
            text-align: right;
            max-width: calc(100% / 12 * 6)
        }

        html[dir=rtl] .blog-single .course-item-rating > div {
            text-align: left;
        }

        .blog-single-meta {
            position: absolute;
            top: 14px;
            right: 14px;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            font-size: 10px;
            line-height: 1.4;
            padding: 6px 12px;
            border-radius: 100px;
            z-index: 2
        }

        html[dir=rtl] .blog-single-meta {
            right: auto;
            left: 14px;
        }

        .blog-single-meta.bg-white {
            box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.15);
            color: #596688
        }

        .blog-single-img {
            width: 100%;
            position: relative;
            overflow: hidden;
            padding-bottom: 55%;
            z-index: 1;
            display: block
        }

        .blog-single-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            transform: scale(1);
            transition: all .4s ease-in-out
        }

        .blog-single-content {
            padding: 30px
        }


        .blog-single-content h4 {
            /* color: #596688; */
            font-size: 22px;
            line-height: 1.5;
            line-height: 1.41667;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: 12px;
            min-height: 68px;
            font-family: var(--fontFamily1);
            color: var(--system_secendory_color);
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .blog-single-content h4 {
                font-size: 21px
            }
        }

        @media only screen and (max-width: 991px) {
            .blog-single-content h4 {
                font-size: 20px
            }
        }

        .blog-single-content h4:hover {
            color: var(--system_primery_color)
        }

        .blog-single-content p {
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 24px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            min-height: 63px;
            font-family: var(--fontFamily2);
            color: var(--system_paragraph_color);

        }

        .blog-single-content .theme-btn {
            font-size: 14px;
            line-height: 1.14286;
            --btn-padding-y: 10px;
            --btn-padding-x: 14px
        }

        .blog-single-rating {
            padding: 0 18px;
            --user-img: 30px;
            position: relative;
            z-index: 1;
            margin-top: -20px
        }

        .blog-single-rating > div {
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
            border-radius: 2px
        }

        .blog-single-rating > div > a {
            width: calc(100% / 12 * 7);
            flex: 0 0 auto
        }

        .blog-single-rating .date {
            font-size: 14px;
            flex: 0 0 auto;
            width: calc(100% / 12 * 5);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical
        }

        .blog-single-rating .user {
            width: var(--user-img);
            height: var(--user-img);
            flex: 0 0 auto;
            overflow: hidden;
            position: relative;
            z-index: 1;
            border-radius: 3px
        }

        .blog-single-rating .user img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1
        }

        .blog-single-rating .user-content {
            color: #596688;
            font-size: 16px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical
        }

        .blog .owl-stage-outer {
            padding-bottom: 40px;
            margin-bottom: -40px;
        }
    </style>
    <div class="blog section-margin-lg position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="section-subtitle v2">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h3 class="mb-0 text-white"> {{@$homeContent->article_title}}</h3>
                            </div>
                            <div class="section-subtitle-action">
                                <a href="{{url('blog')}}" class="theme-btn bg-white ms-2">All Post</a>
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
                         data-select="slug,thumbnail,authored_date,title,description,user_id,category_id"
                         data-order="id"
                         data-limit="8"
                         data-where-status="1"
                         data-view="_single_blog_v2"
                         data-model="Modules\Blog\Entities\Blog"
                         data-with="user,category"
                    >
                        <div class="dynamicData"
                             data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
