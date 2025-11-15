<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/quiz/3.jpg')}}"
     data-aoraeditor-title="Quiz Section V3" data-aoraeditor-categories="Home Page;Quizzes">

    <style>
        .quiz {
            padding-top: var(--section-sepreate-sm)
        }

        .quiz-item {
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
            .quiz-item {
                margin-top: 30px
            }
        }

        .quiz-item:hover {
            top: -5px
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
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            transform: scale(1);
            transition: all .4s ease-in-out
        }

        .quiz-item-content {
            padding: 20px 25px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .quiz-item-content {
                padding-left: 15px;
                padding-right: 15px
            }
        }

        .quiz-item-content .meta {
            position: relative;
            z-index: 1;
            margin-top: -37px;
            margin-bottom: 21px
        }

        .quiz-item-content .meta > * {
            padding: 10px 18px
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .quiz-item-content .meta > * {
                padding-left: 12px;
                padding-right: 12px
            }
        }

        .quiz-item-content .author {
            --width: 34px;
            margin-bottom: 12px
        }

        .quiz-item-content-rating {
            color: var(--system_secendory_color) !important
        }

        .quiz-item-title {
            margin-bottom: 40px;
            color: var(--system_secendory_color);
            font-weight: 700;
            font-size: 20px;
            line-height: 1.5;
            min-height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .quiz-item-title {
                font-size: 18px
            }
        }

        @media only screen and (max-width: 991px) {
            .quiz-item-title {
                font-size: 18px
            }
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .quiz-item-title {
                margin-bottom: 30px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .quiz-item-title {
                margin-bottom: 24px
            }
        }

        @media only screen and (max-width: 991px) {
            .quiz-item-title {
                margin-bottom: 20px
            }
        }

        .quiz-item-title:hover {
            color: var(--system_primery_color)
        }

        .quiz-item-price > span {
            display: flex;
            align-items: center
        }

        .quiz-item-price del {
            font-size: 20px;
            line-height: 1.5;
            font-weight: 500
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .quiz-item-price del {
                font-size: 18px
            }
        }

        @media only screen and (max-width: 991px) {
            .quiz-item-price del {
                font-size: 18px
            }
        }

        .quiz-item-price strong {
            font-size: 32px;
            line-height: 1.25;
            font-family: var(--fontFamily2);
            color: #596688
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .quiz-item-price strong {
                font-size: 28px
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .quiz-item-price strong {
                font-size: 26px
            }
        }

        @media only screen and (max-width: 767px) {
            .quiz-item-price strong {
                font-size: 24px
            }
        }

        .quiz-item-footer {
            padding: 15px 26px;
            color: #fff
        }

        @media only screen and (min-width: 1280px) and (max-width: 1439px) {
            .quiz-item-footer {
                padding: 10px 16px
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .quiz-item-footer {
                padding: 10px 16px
            }
        }

        .quiz-item-footer strong {
            font-size: 22px;
            line-height: 1.5
        }

        @media only screen and (max-width: 991px) {
            .quiz-item-footer strong {
                font-size: 20px
            }
        }

        .quiz-item-footer del {
            font-size: 16px
        }

        .quiz-item-footer > * {
            font-size: 24px;
            line-height: 1.5;
            color: #fff
        }

        @media only screen and (min-width: 992px) and (max-width: 1279px) {
            .quiz-item-footer > * {
                font-size: 22px
            }
        }

        @media only screen and (max-width: 991px) {
            .quiz-item-footer > * {
                font-size: 20px
            }
        }

    </style>
    <div class="quiz">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2>
                            Top Online Quiz
                        </h2>
                        <p>{{@$homeContent->quiz_sub_title}}</p>
                    </div>
                </div>
            </div>

            <div data-type="component-nonExisting"
                 data-preview=""
                 data-table=""
                 data-select=""
                 data-order="id"
                 data-limit="12"
                 data-where-type="2"
                 data-where-status="1"
                 data-view="_single_quiz_v3"
                 data-model="Modules\CourseSetting\Entities\Course"
                 data-with="quiz,quiz.category,user,reviews"
            >
                <div class="dynamicData"
                     data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
            </div>
        </div>
    </div>


</div>
