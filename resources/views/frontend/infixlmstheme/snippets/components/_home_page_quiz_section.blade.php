<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_quiz_section.jpg')}}"
     data-aoraeditor-title="HomePage Quiz Section" data-aoraeditor-categories="Home Page">
    <style>
        .quiz_wizged .thumb .prev_prise {
            text-decoration: line-through;
            color: var(--system_secendory_color);
            font-size: 12px;
            font-weight: 600;
            padding-bottom: 5px;
        }

        .quiz_wizged .thumb .prise_tag {
            top: 20px;
            right: 20px;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            line-height: 1;
            border-radius: 50%;
            min-height: 70px;
            min-width: 70px !important;
        }

        html[dir="rtl"] .quiz_wizged .thumb .prise_tag {
            left: 20px;
            right: auto;
        }

    </style>
    <div class="quiz_area">
        <div class="container">
            <div class="white_box">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section__title text-center mb_80">
                            <h3>{{@$homeContent->quiz_title}}</h3>
                            <p>
                                {{@$homeContent->quiz_sub_title}}
                            </p>
                        </div>
                    </div>
                </div>


                <div data-type="component-nonExisting"
                     data-preview=""
                     data-table=""
                     data-select="id,type,slug,title,thumbnail,price,discount_price"
                     data-order="id"
                     data-limit="4"
                     data-where-type="2"
                     data-where-status="1"
                     data-view="_single_home_page_quiz"
                     data-model="Modules\CourseSetting\Entities\Course"
                     data-with="quiz,quiz.assign"
                >
                    <div class="dynamicData"
                         data-dynamic-href="{{routeIsExist('getDynamicData')?route('getDynamicData'):''}}"></div>
                </div>


                <div class="row">
                    <div class="col-12 text-center pt_70">
                        <a href="{{route('quizzes')}}"
                           class="theme_btn mb_30">{{__('frontend.View All Quiz')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
