<div>
    <div class="quiz__details">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-xl-11">
                    <div class="row">
                        <div class="col-12">


                            <div class="quiz_score_wrapper mb_30">
                                <!-- quiz_test_header  -->
                                <div class="quiz_test_header d-flex align-items-center justify-content-between">
                                    <!-- <h3>{{__('student.Your Exam Score')}}</h3> -->
                                    <h3>
                                        {{$course->quiz->title}}
                                    </h3>
{{--                                    <div class="quiz_header_right">--}}
{{--                                            <span class="question_time">--}}
 {{--                                                <span class="me-2">Remaining:</span><span--}}
{{--                                                    id="timer">0:00:00</span></span>--}}
{{--                                    </div>--}}
                                </div>
                                <!-- quiz_test_body  -->
                                <div class="quiz_test_body">
                                    @if ($quiz->publish==1)
                                        @if($result['pass'])
                                            <h3 class="success">{{__('student.Congratulations!')}}</h3>
                                        @else
                                            <h3 class="failed"><span>{{__('frontend.You have failed')}}.</span> {{__('frontend.Wishing you luck the next time')}}
                                            </h3>
                                        @endif
                                    @else
                                        <h3 class="success">{{__('quiz.Please wait till completion marking process')}}</h3>
                                    @endif


                                    <p class="subtitle">{{__('frontend.You have completed')}} {{$course->quiz->title}}</p>

                                    @if ($quiz->publish==1)
                                        <div class="">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="score_view_wrapper">
                                                        <div class="single_score_view">
                                                            {{--<p>{{__('student.Exam Score')}}:</p>--}}
                                                            <ul class="quiz_exam_score_details">
                                                                <li class="correct">
                                                                    <label class="primary_checkbox2 d-flex">
                                                                        <input checked="" type="checkbox" disabled>
                                                                        <div class="icon">
                                                                            <svg width="15" height="15"
                                                                                 viewBox="0 0 15 15" fill="none"
                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M1.61719 9.18847L5.78764 13.4892C7.75009 7.85194 9.38446 5.37824 13.0859 2.02051"
                                                                                    stroke="currentColor"
                                                                                    stroke-width="3"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"/>
                                                                            </svg>
                                                                        </div>

                                                                        <span
                                                                            class="label_name">{{$result['totalCorrect']}} {{__('student.Correct Answer')}}</span>
                                                                    </label>
                                                                </li>
                                                                <li class="wrong">
                                                                    <label class="primary_checkbox2 error_ans d-flex">
                                                                        <input checked="" name="qus" type="checkbox"
                                                                               disabled>
                                                                        <div class="icon">
                                                                            <svg width="12" height="12"
                                                                                 viewBox="0 0 12 12" fill="none"
                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M1.75781 10.2427L10.2431 1.75739"
                                                                                    stroke="currentColor"
                                                                                    stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"/>
                                                                                <path
                                                                                    d="M10.2431 10.2426L1.75781 1.75732"
                                                                                    stroke="currentColor"
                                                                                    stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"/>
                                                                            </svg>

                                                                        </div>
                                                                        <span
                                                                            class="label_name">{{$result['totalWrong']}} {{__('student.Wrong Answer')}}</span>
                                                                    </label>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="single_score_view d-flex">
                                                            <div>
                                                                {{--<div class="col md-2">
                                                                    <p>{{__('frontend.Start')}}</p>
                                                                    <span> {{$result['start_at']}} </span>
                                                                </div>

                                                                <div class="col md-2">
                                                                    <p>{{__('frontend.Finish')}}</p>
                                                                    <span> {{$result['end_at']}}      </span>
                                                                </div>

                                                                <div class="col md-2">
                                                                    <p>{{__('frontend.Duration')}}
                                                                        ({{__('frontend.Minute')}})</p>
                                                                    <h4 class="f_w_700 "> {{$result['duration']}} </h4>
                                                                </div>--}}

                                                                <div>
                                                                    <p>{{__('student.Exam Score')}}
                                                                        : {{$result['score']}} Out
                                                                        of {{$result['totalScore']}}</p>
                                                                </div>

                                                                {{--<div class="col md-2">
                                                                    <p>{{__('frontend.Percentage')}}</p>
                                                                    <h4 class="f_w_700 "> {{$result['mark']}}% </h4>
                                                                </div>--}}

                                                                <div>
                                                                    <p>
                                                                         {{__('frontend.Result')}}:
                                                                        <span>
                                                                            @if($result['pass'])
                                                                                {{__("frontend.Pass")}}
                                                                            @else
                                                                                {{__("frontend.Failed")}}
                                                                            @endif
                                                                        </span>
                                                                    </p>

                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sumit_skip_btns d-flex align-items-center flex-wrap">
                                            <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}"
                                               class="quiz_primary_btn   mr_20">{{__('student.Done')}}</a>
                                             @if(count($preResult)!=0)
                                                <button type="button"
                                                        class="quiz_secondary_btn  showHistory  mr_20">{{__('frontend.View History')}}</button>
                                            @endif

                                            <a href="{{$quiz->quiz->show_ans_sheet==1?route('quizResultPreview',$quiz->id):'#'}}"
                                               title="{{$quiz->quiz->show_ans_sheet!=1?__('quiz.Answer Sheet is currently locked by Teacher'):''}}"
                                               class=" quiz_secondary_btn submit_q_btn">{{__('student.See Answer Sheet')}}</a>

                                        </div>
                                    @endif

                                    @if(count($preResult)!=0)
                                        <div id="historyDiv" class="pt-5 " style="display:none;">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>{{__('frontend.Date')}}</th>
                                                    <th>{{__('frontend.Mark')}}</th>
                                                    <th>{{__('frontend.Percentage')}}</th>
                                                    <th>{{__('frontend.Rating')}}</th>
                                                    @if($quiz->quiz->show_result_each_submit==1)
                                                        <th>{{__('frontend.Details')}}</th>
                                                    @endif
                                                </tr>
                                                @foreach($preResult as $pre)
                                                    <tr>
                                                        <td>{{$pre['date']}}</td>
                                                        <td>{{$pre['score']}}/{{$pre['totalScore']}}</td>
                                                        <td>{{$pre['mark']}}%</td>
                                                        <td class="{{$pre['text_color']}}">{{$pre['status']}}</td>
                                                        @if($quiz->quiz->show_result_each_submit==1)
                                                            <td>
                                                                <a href="{{route('quizResultPreview',$pre['quiz_test_id'])}}"
                                                                   class=" font_1 font_16 f_w_600 theme_text3 submit_q_btn">{{__('student.See Answer Sheet')}}</a>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


