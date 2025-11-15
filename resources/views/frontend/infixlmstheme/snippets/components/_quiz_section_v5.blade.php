<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/quiz/5.jpg')}}"
     data-aoraeditor-title="Quiz Section Dark" data-aoraeditor-categories="Home Page;Quizzes">

    <style>
        .quiz .section-subtitle {
            background-color: rgba(255, 255, 255, 0.05);
            box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.07)
        }

        .quiz .section-subtitle-action .theme-btn {
            background: var(--system_primery_color) !important
        }

        .quiz .section-subtitle-action .theme-btn:hover {
            background-color: var(--system_secendory_color_10) !important;
            border-color: var(--system_secendory_color_10)
        }

        .quiz-slider .owl-stage {
            padding-top: var(--top-sp)
        }

        .quiz-slider .owl-stage-outer {
            padding-bottom: 60px
        }

        @media only screen and (max-width: 767px) {
            .quiz-slider .owl-stage-outer {
                padding-bottom: 30px
            }
        }

        .quiz-slider .owl-dots {
            position: relative;
            top: 100%;
            left: 50%;
            transform: translateX(-50%)
        }

        .quiz-item {
            background-color: rgba(255, 255, 255, 0.05);
            overflow: hidden;
            border-radius: 20px;
            margin-top: 24px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.05);
            position: relative;
            top: 0;
            transition: all .4s ease-in-out
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .quiz-item {
                margin-top: 35px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .quiz-item {
                margin-top: 35px
            }
        }

        @media only screen and (max-width: 991px) {
            .quiz-item {
                margin-top: 30px
            }
        }

        .quiz-item:hover {
            top: -5px
        }

        .quiz-item:hover .quiz-item-img img {
            transform: scale(1.05)
        }

        .quiz-item-badge {
            position: absolute;
            top: 13px;
            right: 14px;
            z-index: 1;
            border-radius: 38px;
            color: #fff;
            background-color: var(--system_secendory_color);
            font-weight: 700;
            font-size: 9px;
            line-height: 10px;
            padding: 8px 13px
        }

        html[dir=rtl] .quiz-item-badge {
            right: auto;
            left: 14px
        }

        @media only screen and (max-width: 767px) {
            .quiz-item-badge {
                top: 10px;
                right: 10px
            }

            html[dir=rtl] .quiz-item-badge {
                right: auto;
                left: 10px;
            }

        }

        .quiz-item-img {
            display: block;
            width: 100%;
            position: relative;
            overflow: hidden;
            padding-bottom: 55%;
            z-index: 1
        }

        .quiz-item-img img {
            width: 100% !important;
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

        .quiz-item-rating {
            background-color: #fff;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
            border-radius: 42px;
            position: relative;
            z-index: 1;
            margin-top: -23px;
            padding-right: 16px !important
        }

        html[dir=rtl] .quiz-item-rating {
            padding-right: 0;
            padding-left: 1rem !important;
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .quiz-item-rating {
                margin-bottom: 20px !important
            }
        }

        @media only screen and (max-width: 767px) {
            .quiz-item-rating {
                margin-bottom: 16px !important
            }
        }

        .quiz-item-rating i {
            font-size: 12px
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .quiz-item-rating i {
                font-size: 11px
            }
        }

        .quiz-item-rating .user {
            --rating-user: 30px;
            width: var(--rating-user);
            height: var(--rating-user);
            border-radius: 100%;
            overflow: hidden;
            flex: 0 0 auto
        }

        .quiz-item-rating .user img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .quiz-item-rating a {
            color: #EEF0F6;
            max-width: calc(100% / 12 * 7);
            flex: 0 0 100%
        }

        .quiz-item-rating a:hover {
            color: var(--system_secendory_color)
        }

        .quiz-item-rating span {
            color: currentColor;
            font-size: 12px;
            line-height: 1.75;
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical
        }

        .quiz-item-rating > div {
            max-width: calc(100% / 12 * 5);
            flex: 0 0 100%;
            text-align: right
        }

        html[dir=rtl] .quiz-item-rating > div {
            text-align: left;
        }

        .quiz-item-lession {
            background: var(--system_primery_color);
            background-size: 200% auto;
            grid-template-columns:repeat(3, minmax(0, 1fr));
            border-top: 1px solid #fff
        }

        .quiz-item-lession p {
            color: #fff !important;
            font-size: 14px;
            padding: 9px 0px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-weight: 400!important;
        }

        .quiz-item-lession p:nth-child(2) {
            background-color: rgba(0, 0, 0, 0.15)
        }

        .quiz-item-content {
            padding: 20px
        }

        @media (min-width: 1367px) {
            .quiz-item-content {
                padding: 30px
            }
        }

        .quiz-item-content h4 {
            font-size: 22px;
            line-height: 1.5;
            font-family: var(--fontFamily1);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            font-weight: 500;
            cursor: pointer;
            min-height: 60px;
            color: var(--system_secendory_color);

        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .quiz-item-content h4 {
                font-size: 18px
            }
        }

        @media only screen and (max-width: 991px) {
            .quiz-item-content h4 {
                font-size: 18px
            }
        }

        .quiz-item-content .theme-btn {
            --btn-padding-y: 8px;
            --btn-padding-x: 11px;
            font-size: 12px;
            line-height: 1.5
        }

        .quiz-item-content-meta {
            font-size: 13px;
            line-height: 3;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .quiz-item-content-meta {
                font-size: 12px
            }
        }

        @media only screen and (max-width: 767px) {
            .quiz-item-content-meta {
                font-size: 12px;
                line-height: 1.5;
                margin-bottom: 12px !important
            }
        }

        .quiz-item-title {
            min-height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: 20px;
            color: #EEF0F6
        }

        @media only screen and (max-width: 767px) {
            .quiz-item-title {
                margin-bottom: 16px
            }
        }

        .quiz-item-title:hover {
            color: var(--system_primery_color)
        }

        @media only screen and (max-width: 767px) {
            .quiz-item-info {
                margin-bottom: 12px !important
            }
        }

        .quiz-item-info > * {
            font-size: 12px;
            font-family: var(--fontFamily2);
            font-weight: 500;
            padding: 5px 10px;
            color: var(--system_primery_color);
            background-color: var(--system_primery_color_07);
            border-radius: 100px
        }

        .quiz-item-price > span {
            display: flex;
            align-items: center
        }

        .quiz-item-price del {
            font-size: 12px;
            font-weight: 500
        }

        .quiz-item-price strong {
            font-size: 24px;
            line-height: 1.5;
            font-family: var(--fontFamily2);
            color: #EEF0F6
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .quiz-item-price strong {
                font-size: 22px
            }
        }

        @media only screen and (max-width: 991px) {
            .quiz-item-price strong {
                font-size: 20px
            }
        }

    </style>
    <div class="quiz">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-subtitle">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h3 class="mb-0 text-white">Top Online Quiz</h3>
                            </div>
                            <div class="section-subtitle-action mt-0">
                                <a href="{{route('quizzes')}}" class="theme-btn bg-primary ms-2">All Quiz</a>
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
                     data-limit="12"
                     data-where-type="2"
                     data-where-status="1"
                     data-view="_single_quiz_v4"
                     data-model="Modules\CourseSetting\Entities\Course"
                     data-with="quiz,quiz.category,user"
                >
                    <div class="dynamicData"
                         data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                </div>
            </div>
        </div>
    </div>


</div>
