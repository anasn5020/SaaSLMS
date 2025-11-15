<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/course/3.jpg')}}"
     data-aoraeditor-title="Course Section V4" data-aoraeditor-categories="Courses;Home Page">

    <style>
        .course-item {
            background-color: #fff;
            overflow: hidden;
            border-radius: 20px;
            margin-top: 24px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.05);
            position: relative;
            top: 0;
            transition: all .4s ease-in-out
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .course-item {
                margin-top: 35px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item {
                margin-top: 35px
            }
        }

        @media only screen and (max-width: 991px) {
            .course-item {
                margin-top: 30px
            }
        }

        .course-item:hover {
            top: -5px
        }

        .course-item:hover .course-item-img img {
            transform: scale(1.05)
        }

        .course-item-img {
            display: block;
            width: 100%;
            position: relative;
            overflow: hidden;
            padding-bottom: 55%;
            z-index: 1
        }

        .course-item-img img {
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

        .course-item-rating {
            background-color: #fff;
            position: relative;
            z-index: 1;
            --rating-user: 40px;
            margin-bottom: 1rem
        }

        .course-item-rating i {
            font-size: 12px
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .course-item-rating i {
                font-size: 11px
            }
        }

        .course-item-rating .user {
            width: var(--rating-user);
            height: var(--rating-user);
            border-radius: 100%;
            overflow: hidden;
            flex: 0 0 auto;
            border: 1px solid #98A6B4
        }

        .course-item-rating .user img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .course-item-rating .content {
            width: calc(100% - var(--rating-user));
            flex: 0 0 auto;
            padding-left: 8px
        }

        html[dir=rtl] .course-item-rating .content {
            padding-left: 0;
            padding-right: 8px;
        }

        .course-item-rating a {
            color: var(--system_primery_color)
        }

        .course-item-rating a:hover {
            color: var(--system_secendory_color)
        }

        .course-item-rating span {
            color: currentColor;
            font-size: 20px;
            line-height: 1.5;
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            margin-bottom: 4px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-rating span {
                font-size: 18px
            }
        }

        @media only screen and (max-width: 991px) {
            .course-item-rating span {
                font-size: 18px
            }
        }

        .course-item-content {
            padding: 20px
        }

        @media (min-width: 1367px) {
            .course-item-content {
                padding: 30px
            }
        }

        @media only screen and (max-width: 479px) {
            .course-item-content {
                padding-top: 10px
            }
        }

        .course-item-content .theme-btn {
            --btn-padding-y: 11px;
            --btn-padding-x: 26px;
            font-size: 14px;
            line-height: 1.5
        }

        .course-item-content-meta {
            font-size: 10px;
            line-height: 3;
            color: var(--system_paragraph_color);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .course-item-content-meta {
                font-size: 12px
            }
        }

        @media only screen and (max-width: 767px) {
            .course-item-content-meta {
                font-size: 12px;
                line-height: 1.5;
                margin-bottom: 12px !important
            }
        }

        .course-item-content-meta span {
            color: #636676
        }

        .course-item-title {
            margin-bottom: 30px;
            color: var(--system_secendory_color);
            font-weight: 500;
            font-size: 22px;
            line-height: 1.25;
            min-height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            font-family: var(--fontFamily1);
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-title {
                font-size: 21px
            }
        }

        @media only screen and (max-width: 991px) {
            .course-item-title {
                font-size: 20px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-title {
                margin-bottom: 24px
            }
        }

        @media only screen and (max-width: 767px) {
            .course-item-title {
                margin-bottom: 16px
            }
        }

        .course-item-title:hover {
            color: var(--system_primery_color)
        }

        .course-item-info {
            border-radius: 16px;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
            padding: 10px 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: calc(49px / 2 * -1);
            position: relative;
            z-index: 1
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-info {
                border-radius: 8px
            }
        }

        @media only screen and (max-width: 767px) {
            .course-item-info {
                margin-bottom: 12px !important;
                justify-content: space-between
            }
        }

        .course-item-info-wrap {
            padding: 0px 20px
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .course-item-info-wrap {
                padding: 0 14px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-info-wrap {
                padding: 0 14px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .course-item-info-wrap {
                padding: 0 10px;
                justify-content: space-between
            }
        }

        @media only screen and (max-width: 767px) {
            .course-item-info-wrap {
                padding: 0 8px;
                justify-content: space-between
            }
        }

        .course-item-info > * {
            font-size: 12px;
            font-family: var(--fontFamily2);
            font-weight: 500;
            padding: 4px 10px;
            color: var(--system_primery_color);
            background-color: #fff;
            border-radius: 100px;
            min-width: 100px;
            text-align: center
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .course-item-info > * {
                min-width: max-content
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-info > * {
                min-width: max-content;
                font-size: 10px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .course-item-info > * {
                min-width: max-content
            }
        }

        @media only screen and (max-width: 479px) {
            .course-item-info > * {
                min-width: max-content
            }
        }

        .course-item-info > *:not(:last-child) {
            margin-right: 12px
        }

        html[dir=rtl] .course-item-info > *:not(:last-child) {
            margin-right: 0;
            margin-left: 12px;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-info > *:not(:last-child) {
                margin-right: 6px
            }

            html[dir=rtl] .course-item-info > *:not(:last-child) {
                margin-right: 0;
                margin-left: 6px;
            }
        }

        .course-item-price > span {
            display: flex;
            align-items: center
        }

        .course-item-price del {
            font-size: 20px;
            line-height: 1.5;
            font-weight: 500
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-price del {
                font-size: 18px
            }
        }

        @media only screen and (max-width: 991px) {
            .course-item-price del {
                font-size: 18px
            }
        }

        .course-item-price strong {
            font-size: 24px;
            line-height: 1.25;
            font-family: var(--fontFamily2);
            color: var(--system_secendory_color);
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-price strong {
                font-size: 22px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .course-item-price strong {
                font-size: 20px
            }
        }

        @media only screen and (max-width: 767px) {
            .course-item-price strong {
                font-size: 18px
            }
        }

    </style>
    <div class="course bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-subtitle">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h3 class="mb-0 text-white">{{@$homeContent->course_title}}</h3>
                            </div>
                            <div class="section-subtitle-action">
                                <a href="{{route('courses')}}" class="theme-btn bg-white ms-2">All Course</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table=""
                 data-select="id,type,slug,title,thumbnail,price,discount_price,mode_of_delivery,duration,total_enrolled,total_rating,user_id,category_id,level,total_rating"
                 data-order="id"
                 data-limit="6"
                 data-where-status="1"
                 data-where-type="1"
                 data-view="_single_course_v4"
                 data-model="Modules\CourseSetting\Entities\Course"
                 data-with="courseLevel,user,category"
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>
        </div>
    </div>

</div>
