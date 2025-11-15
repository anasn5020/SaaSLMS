@php
    use Modules\Survey\Entities\SurveyAssign;if (!empty($course->survey->questionAssigns)){
        $totalQus =$course->survey->questionAssigns->count();
    }else{
        $totalQus =0;
    }
     $assign_info= SurveyAssign::where('survey_id',$course->survey->id)
     ->where('user_id',auth()->id())
      ->first();
@endphp
<style>
    .quiz_questions_wrapper .quiz_test_body .quiz_select li {
        margin-bottom: 0;
    }
</style>
@if($assign_info && $assign_info->survey->title!="")
    <div class="modal fade " id="assignSubmit"
         tabindex="-1"
         role="dialog" aria-labelledby="assignModalLabel"
         aria-hidden="true">
        <div class="modal-dialog   modal-dialog-centered " role="document" style="max-width: 70%;">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="assignModalLabel">
                        {!! $course->survey->title !!}
                    </h5>
                    {!! $course->survey->description !!}
                </div>

                <form action="{{route('survey.student_survey_participate_store',$course->survey->id)}}"
                      method="post">
                    <input type="hidden" name="survey_id" value="{{$course->survey->id}}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="quiz_questions_wrapper mb_30">

                                    <!-- quiz_test_body  -->
                                    <div class="quiz_test_body">
                                        <div class="tabControl">
                                            @if($totalQus>0)
                                                <!-- nav-pills  -->
                                                <ul class="nav nav-pills nav-fill d-none" id="pills-tab" role="tablist">
                                                    @foreach ($course->survey->questionAssigns as $key => $question)
                                                        <li class="nav-item">
                                                            <a class="nav-link {{$key==0?'active':''}}"
                                                               id="pills-home-tab"
                                                               data-bs-toggle="pill"
                                                               href="#pills-{{$key}}" role="tab">Tab1</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <!-- tab-content  -->
                                                <div class="tab-content" id="pills-tabContent">
                                                    @foreach ($course->survey->questionAssigns as $key => $assign)
                                                        @php
                                                            $question =$assign->questionBank;

                                                                            //   $submitted_answer=$submitted_answers->where('question_id',$question->id)->first();
                                                        @endphp
                                                        <div class="tab-pane fade {{$key==0?'show active':''}}"
                                                             id="pills-{{$key}}" role="tabpanel"
                                                             aria-labelledby="pills-home-tab">
                                                            <!-- content  -->
                                                            <div class="question_list_header">
                                                                <div class="question_list_top">
                                                                    @php
                                                                        $currentSerial =1+$key;
                                                                    @endphp
                                                                    <p>{{__('common.Question')}} {{$currentSerial}} {{__('common.out of')}} {{$totalQus}}</p>
                                                                    <div class="arrow_controller">
                                                                    <span class="surveyBtnPrevious"> <i
                                                                            class="ti-angle-left"></i> </span>
                                                                        <span class="surveyBtnNext"> <i
                                                                                class="ti-angle-right"></i> </span>
                                                                    </div>
                                                                </div>
                                                                <div class="question_list_counters">
                                                                    @for($i=0;$i<$totalQus;$i++)
                                                                        @php
                                                                            $serial =1+$i;
                                                                        @endphp
                                                                        <span
                                                                            class="{{$key==$i?'skip_qus':''}}">{{$serial}}</span>

                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div class="multypol_qustion mb_30">
                                                                <h4 class="font_18 f_w_700 mb-0">
                                                                {!! $question->question !!}
                                                                </h4>
                                                                <input type="hidden" name="question[]"
                                                                       value="{{$question->id}}">
                                                            </div>

                                                            <div class="quiz_select">
                                                                @if ($question->type=='checkbox')
                                                                    @foreach ($question->questionMu as $attribute)
                                                                        <div class="mb-2">
                                                                            <label
                                                                                class="primary_bulet_checkbox d-flex">
                                                                                <input class="quizAns"
                                                                                        name="survey_answer[{{$question->id}}][]"
                                                                                       type="checkbox"
                                                                                       value="{{$attribute->id}}">

                                                                                <span class="checkmark mr_10"></span>
                                                                                <span
                                                                                    class="label_name">{{$attribute->title}} </span>
                                                                            </label>
                                                                        </div>
                                                                    @endforeach

                                                                @elseif ($question->type=='radio')
                                                                    @foreach ($question->questionMu as $attribute)
                                                                        <div class="mb-2">
                                                                            <label
                                                                                class="primary_bulet_checkbox d-flex">
                                                                                <input class="quizAns"
                                                                                       {{isset($submitted_answer) ? $submitted_answer->answer == $attribute->id? 'checked':'':''}}
                                                                                       name="survey_answer[{{$question->id}}]"
                                                                                       type="radio"
                                                                                       value="{{$attribute->id}}">

                                                                                <span class="checkmark mr_10"></span>
                                                                                <span
                                                                                    class="label_name">{{$attribute->title}} </span>
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                @elseif ($question->type=='linear_scale')
                                                                    @php
                                                                        $option =$question->number_of_option;
                                                                    @endphp

                                                                    <ul>

                                                                        @for ($i=1; $i<=$option;$i++)
                                                                            <li class="d-inline-block text-center me-1">
                                                                                <label>
                                                                                    <strong>{{$i}}</strong>
                                                                                </label>
                                                                                <label class="primary_bulet_checkbox d-flex">
                                                                                    <input type="radio" value="{{$i}}"
                                                                                           name="survey_answer[{{$question->id}}]"
                                                                                        {{isset($submitted_answer) ? $submitted_answer->answer ==$i? 'checked':'':''}}
                                                                                    >
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                            </li>
                                                                        @endfor

                                                                    </ul>
                                                                @elseif ($question->type=='dropdown')
                                                                    <div class="single_input d-inline-block w-50">
                                                                        <select class="nice_Select mb-3 wide w-100"
                                                                                name="survey_answer[{{$question->id}}]" {{$errors->first('language') ? 'autofocus' : ''}}>
                                                                            <option data-display="Select Answer"
                                                                                    value="#">{{__('common.Select')}} {{__('common.Answer')}}

                                                                            </option>
                                                                            @foreach ($question->questionMu as $attribute)
                                                                                <option
                                                                                    {{isset($submitted_answer) ? $submitted_answer->answer == $attribute->id? 'selected':'':''}} value="{{$attribute->id}}">{{$attribute->title}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                @else
                                                                    <div class="input-effect mb-20">
                                                        <textarea class="textArea lms_summernote " cols="30" rows="10"
                                                                  name="survey_answer[{{$question->id}}]">

                                                 </textarea>
                                                                        <span class="focus-border textarea"></span>

                                                                    </div>
                                                                @endif
{{--                                                                @if ($question->type!='textarea')--}}
{{--                                                                    @if ($question->type=='Checkbox')--}}
{{--                                                                        @foreach ($question->set->activeAttributes as $attribute)--}}
{{--                                                                            <div class="me-2">--}}
{{--                                                                                <label--}}
{{--                                                                                    class="primary_bulet_checkbox d-flex">--}}
{{--                                                                                    <input class="quizAns"--}}
{{--                                                                                           {{isset($submitted_answer) ? $submitted_answer->answer == $attribute->id? 'checked':'':''}}--}}
{{--                                                                                           name="survey_answer[{{$question->id}}]"--}}
{{--                                                                                           type="checkbox"--}}
{{--                                                                                           value="{{$attribute->id}}">--}}

{{--                                                                                    <span--}}
{{--                                                                                        class="checkmark mr_10"></span>--}}
{{--                                                                                    <span--}}
{{--                                                                                        class="label_name">{{$attribute->name}} </span>--}}
{{--                                                                                </label>--}}
{{--                                                                            </div>--}}
{{--                                                                        @endforeach--}}
{{--                                                                    @endif--}}
{{--                                                                    @if ($question->type=='radio')--}}
{{--                                                                        @foreach ($question->set->activeAttributes as $attribute)--}}
{{--                                                                            <div class="me-2">--}}
{{--                                                                                <label--}}
{{--                                                                                    class="primary_bulet_checkbox d-flex">--}}
{{--                                                                                    <input class="quizAns"--}}
{{--                                                                                           {{isset($submitted_answer) ? $submitted_answer->answer == $attribute->id? 'checked':'':''}}--}}
{{--                                                                                           name="survey_answer[{{$question->id}}]"--}}
{{--                                                                                           type="radio"--}}
{{--                                                                                           value="{{$attribute->id}}">--}}

{{--                                                                                    <span--}}
{{--                                                                                        class="checkmark mr_10"></span>--}}
{{--                                                                                    <span--}}
{{--                                                                                        class="label_name">{{$attribute->name}} </span>--}}
{{--                                                                                </label>--}}
{{--                                                                            </div>--}}
{{--                                                                        @endforeach--}}
{{--                                                                    @endif--}}
{{--                                                                    @if ($question->type=='dropdown')--}}
{{--                                                                        <div class="single_input ">--}}
{{--                                                            <span class="primary_label2">{{__('common.Answer')}}  <span--}}
{{--                                                                    class=""></span> </span>--}}
{{--                                                                            <select class="select2 mb-3 wide w-100"--}}
{{--                                                                                    name="survey_answer[{{$question->id}}]" {{$errors->first('language') ? 'autofocus' : ''}}>--}}
{{--                                                                                <option data-display="Select Answer"--}}
{{--                                                                                        value="#">{{__('common.Select')}} {{__('common.Answer')}}</option>--}}
{{--                                                                                @foreach ($question->set->activeAttributes as $attribute)--}}
{{--                                                                                    <option--}}
{{--                                                                                        {{isset($submitted_answer) ? $submitted_answer->answer == $attribute->id? 'selected':'':''}} value="{{$attribute->id}}">{{$attribute->name}}</option>--}}
{{--                                                                                @endforeach--}}
{{--                                                                            </select>--}}
{{--                                                                        </div>--}}
{{--                                                                    @endif--}}
{{--                                                                @else--}}
{{--                                                                    <div class="input-effect mb-20">--}}
{{--                                                                        <label--}}
{{--                                                                            class="primary_input_label"> {{__('common.Answer')}}--}}
{{--                                                                            <strong--}}
{{--                                                                                class="text-danger"></strong></label>--}}
{{--                                                                        <textarea class="textArea lms_summernote "--}}
{{--                                                                                  ols="30"--}}
{{--                                                                                  rows="10"--}}
{{--                                                                                  name="survey_answer[{{$question->id}}]">--}}

{{--                                                    {{$submitted_answers->where('question_id',$question->id)->first() ? $submitted_answers->where('question_id',$question->id)->first()->answer:''}}--}}
{{--                                                </textarea>--}}
{{--                                                                        <span class="focus-border textarea"></span>--}}

{{--                                                                    </div>--}}
{{--                                                                @endif--}}
                                                            </div>


                                                            @if($totalQus!=$currentSerial)
                                                                <div class="sumit_skip_btns d-flex align-items-center">
                                                                    <a href="#"
                                                                       class="theme_btn small_btn  mr_20 surveyBtnNext">{{__('common.Continue')}}</a>
                                                                    <a href="#"
                                                                       class=" font_1 font_16 f_w_600 theme_text3 submit_q_btn surveyBtnNext">
                                                                        {{__('common.Skip')}} {{__('common.Question')}}</a>
                                                                </div>
                                                            @else

                                                                <div class="sumit_skip_btns d-flex align-items-center">
                                                                    <button type="submit"
                                                                            class="theme_btn small_btn  mr_20 ">{{__('common.Submit')}}</button>
                                                                </div>
                                                            @endif
                                                        </div>

                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="d-flex justify-content-center align-content-center">{{__('survey.No Questions Found')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $(document).on('click', '.surveyBtnNext', function (e) {
                e.preventDefault();
                var $active = $('.nav-pills .active');
                var $next = $active.closest('li').next('li').find('a');
                if ($next.length) {
                    $next.tab('show');
                }
            });

            $(document).on('click', '.surveyBtnPrevious', function (e) {
                e.preventDefault();
                var $active = $('.nav-pills .active');
                var $prev = $active.closest('li').prev('li').find('a');
                if ($prev.length) {
                    $prev.tab('show');
                }
            });
        });

    </script>
@endif
