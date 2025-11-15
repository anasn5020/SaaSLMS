<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/course/3.jpg')}}"
     data-aoraeditor-title="Course Section V3" data-aoraeditor-categories="Courses;Home Page">

    <style>
        .course {
            padding-top: var(--section-sepreate-sm)
        }

        .course-item {
            background-color: #fff;
            overflow: hidden;
            border-radius: 10px;
            margin-top: 40px;
            position: relative;
            top: 0;
            transition: all .4s ease-in-out;
            box-shadow: -2px 9px 26px rgba(0, 0, 0, 0.08)
        }

        @media only screen and (max-width: 991px) {
            .course-item {
                margin-top: 30px
            }
        }

        .course-item:hover {
            top: -5px
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

        .course-item-content {
            padding: 20px 25px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-content {
                padding-left: 15px;
                padding-right: 15px
            }
        }

        .course-item-content .meta {
            position: relative;
            z-index: 1;
            margin-top: -37px;
            margin-bottom: 21px
        }

        .course-item-content .meta > * {
            padding: 10px 18px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-content .meta > * {
                padding-left: 12px;
                padding-right: 12px
            }
        }

        .course-item-content .author {
            --width: 34px;
            margin-bottom: 12px;
            min-height: 39px;
        }

        .course-item-content-rating {
            color: var(--system_secendory_color) !important
        }

        .course-item-title {
            margin-bottom: 40px;
            color: var(--system_secendory_color);
            font-weight: 700;
            font-size: 22px;
            min-height: 60px;
            line-height: 1.5;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            font-family: var(--fontFamily1);
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-title {
                font-size: 20px
            }
        }

        @media only screen and (max-width: 991px) {
            .course-item-title {
                font-size: 18px
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .course-item-title {
                margin-bottom: 30px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-title {
                margin-bottom: 24px
            }
        }

        @media only screen and (max-width: 991px) {
            .course-item-title {
                margin-bottom: 20px
            }
        }

        .course-item-title:hover {
            color: var(--system_primery_color)
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
            color: #596688
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

        .course-item-footer {
            padding: 15px 26px;
            color: #fff
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .course-item-footer {
                padding: 10px 16px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-footer {
                padding: 10px 16px
            }
        }

        .course-item-footer strong {
            font-size: 22px;
            line-height: 1.5
        }

        @media only screen and (max-width: 991px) {
            .course-item-footer strong {
                font-size: 20px
            }
        }

        .course-item-footer del {
            font-size: 16px
        }

        .course-item-footer > * {
            font-size: 24px;
            line-height: 1.5;
            color: #fff
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .course-item-footer > * {
                font-size: 22px
            }
        }

        @media only screen and (max-width: 991px) {
            .course-item-footer > * {
                font-size: 20px
            }
        }

    </style>
    <div class="course bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2>{{@$homeContent->course_title}}</h2>
                        <p>{{@$homeContent->course_sub_title}}</p>
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
                 data-view="_single_course_v3"
                 data-model="Modules\CourseSetting\Entities\Course"
                 data-with="courseLevel,user,category,reviews"
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>
        </div>
    </div>

</div>
