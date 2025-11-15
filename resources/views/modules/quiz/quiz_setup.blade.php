@extends('backend.master')
@section('mainContent')
    <style>
        #losingTotalQusCount {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            line-clamp: 1;
            -webkit-box-orient: vertical;
        }
    </style>

    {!! generateBreadcrumb() !!}
    @php
        $advance=isModuleActive('AdvanceQuiz');
   $size =$advance?12:4;
   $top =$advance?0:40;
    @endphp
    <section class="admin-visitor-area up_st_admin_visitor">

        <form method="POST" action="{{ route('quizSetup.store') }}" class="form-horizontal"
              enctype="multipart/form-data">
            @csrf
            <div class="white-box">

                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="general_quiz col-lg-{{!$advance?12:6}}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-title">
                                        <h3 class="mb-20">
                                            {{__('quiz.General Quiz Setup')}}
                                        </h3>
                                    </div>

                                    <div>
                                        <div class="add-visitor">
                                            <div class="row">
                                                <div class="col-lg-{{$size}}  mt-{{$top}} ">
                                                    <ul class="permission_list">
                                                        <li>
                                                            <label class="primary_checkbox d-flex mr-12 ">
                                                                <input name="set_per_question_time"
                                                                       @if (@$quiz_setup->set_per_question_time==1) checked
                                                                       @endif value="1" onChange="setQuestionTime()"
                                                                       id="set_question_time" type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p for="#set_question_time">{{trans('quiz.Per Question time count')}}</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-{{$size}} ">
                                                    @if ($quiz_setup->set_per_question_time==1)
                                                        <div class="form-group" id="per_question_time">
                                                            <label class="text-nowrap"
                                                                   for="set_time_per_question">{{trans('quiz.Per Question Time Count (Minute)')}}</label>
                                                            <input type="text" class="primary_input_field name"
                                                                   name="set_time_per_question"
                                                                   value="{{@$quiz_setup->time_per_question}}"
                                                                   id="set_time_per_question"
                                                                   aria-describedby="helpId" placeholder="">
                                                        </div>
                                                        <div class="form-group" id="total_question_time"
                                                             style="display: none">
                                                            <label
                                                                for="set_time_total_question">{{trans('quiz.Total Quiz time count (Minute)')}}</label>
                                                            <input type="text" class="primary_input_field name"
                                                                   name="set_time_total_question"
                                                                   value="{{@$quiz_setup->time_total_question}}"
                                                                   id="set_time_total_question"
                                                                   aria-describedby="helpId" placeholder="">
                                                        </div>
                                                    @else
                                                        <div class="form-group" id="per_question_time"
                                                             style="display: none">
                                                            <label
                                                                for="set_time_per_question">{{trans('quiz.Per Question Time Count (Minute)')}}</label>
                                                            <input type="text" class="primary_input_field name"
                                                                   name="set_time_per_question"
                                                                   value="{{@$quiz_setup->time_per_question}}"
                                                                   id="set_time_per_question"
                                                                   aria-describedby="helpId" placeholder="">
                                                        </div>
                                                        <div class="form-group" id="total_question_time">
                                                            <label
                                                                for="set_time_total_question">{{trans('quiz.Total Quiz time count (Minute)')}}</label>
                                                            <input type="text" class="primary_input_field name"
                                                                   name="set_time_total_question"
                                                                   value="{{@$quiz_setup->time_total_question}}"
                                                                   id="set_time_total_question"
                                                                   aria-describedby="helpId" placeholder="">
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="row">

                                                <div class="col-lg-{{$size}}  mt-{{$top}} ">
                                                    <ul class="permission_list">
                                                        <li>
                                                            <label class="primary_checkbox d-flex mr-12 ">
                                                                <input name="question_review"
                                                                       @if (@$quiz_setup->question_review==1) checked
                                                                       @endif value="1" id="questionReview"
                                                                       onChange="changeQuestionReview()"
                                                                       type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p for="#set_question_time">{{trans('quiz.Question Review')}} </p>
                                                        </li>
                                                        <small id="helpId"
                                                               class="form-text text-muted">{{trans('quiz.Note')}}
                                                            : {{trans('quiz.If you enable this option, show result: after each submit will disabled')}}</small>
                                                    </ul>
                                                </div>
                                                @php
                                                    if($quiz_setup->question_review!=1){
                                                            $show_result_each='';
                                                    }else{
                                                        $show_result_each='style=display:none';
                                                    }
                                                @endphp
                                                <div class="col-lg-{{$size}}  mt-{{$top}} "
                                                     {{@$show_result_each}} id="showResultDiv">
                                                    <ul class="permission_list">
                                                        <li>
                                                            <label class="primary_checkbox d-flex mr-12 ">
                                                                <input name="show_result_each_submit"
                                                                       @if (@$quiz_setup->show_result_each_submit==1) checked
                                                                       @endif value="1" type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p for="#set_question_time">{{trans('quiz.Show Results After Each Submit')}} </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-{{$size}}  mt-{{$top}} ">
                                                    <ul class="permission_list">
                                                        <li>
                                                            <label class="primary_checkbox d-flex mr-12 ">
                                                                <input name="random_question"
                                                                       @if (@$quiz_setup->random_question==1) checked
                                                                       @endif value="1" type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p for="#set_question_time">{{trans('quiz.Random Question')}} </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-{{$size}}  mt-{{$top}} ">
                                                    <ul class="permission_list">
                                                        <li>
                                                            <label class="primary_checkbox d-flex mr-12 ">
                                                                <input name="multiple_attend"
                                                                       @if (@$quiz_setup->multiple_attend==1) checked
                                                                       @endif value="1" type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p for="#set_question_time">{{trans('quiz.Multiple Attend')}} </p>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-lg-{{$size}}  mt-{{$top}} ">
                                                    <ul class="permission_list">
                                                        <li>
                                                            <label class="primary_checkbox d-flex mr-12 ">
                                                                <input name="show_ans_with_explanation"
                                                                       @if (@$quiz_setup->show_ans_with_explanation==1) checked
                                                                       @endif value="1" type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p for="#show_ans_with_explanation">{{trans('quiz.Same Page Show Question & Explanation')}} </p>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-lg-{{$size}}  mt-{{$top}} ">
                                                    <ul class="permission_list">
                                                        <li>
                                                            <label class="primary_checkbox d-flex mr-12 ">
                                                                <input name="show_ans_sheet"
                                                                       @if (@$quiz_setup->show_ans_sheet==1) checked
                                                                       @endif value="1" type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p for="#show_ans_sheet">{{trans('quiz.See Answer Sheet')}} </p>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-lg-{{$size}}  mt-{{$top}} ">
                                                    <ul class="permission_list">
                                                        <li>
                                                            <label class="primary_checkbox d-flex mr-12 ">
                                                                <input name="show_score_result"
                                                                       @if (@$quiz_setup->show_score_result==1) checked
                                                                       @endif value="1" type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p for="#show_score_result">{{trans('quiz.See Score Result')}} </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @if(currentTheme()=='infixlmstheme')
                                                    <div class="col-lg-{{$size}}  mt-{{$top}} ">
                                                        <ul class="permission_list">
                                                            <li>
                                                                <label class="primary_checkbox d-flex mr-12 ">
                                                                    <input name="show_correct_ans_in_ans_sheet"
                                                                           @if (@$quiz_setup->show_correct_ans_in_ans_sheet==1) checked
                                                                           @endif value="1" type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <p for="#show_correct_ans_in_ans_sheet">{{trans('quiz.Show Correct Ans In Answer Sheet')}} </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-{{$size}}  mt-{{$top}} ">
                                                        <ul class="permission_list">
                                                            <li>
                                                                <label class="primary_checkbox d-flex mr-12 ">
                                                                    <input name="show_only_wrong_ans_in_ans_sheet"
                                                                           @if (@$quiz_setup->show_only_wrong_ans_in_ans_sheet==1) checked
                                                                           @endif value="1" type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <p for="#show_only_wrong_ans_in_ans_sheet">{{trans('quiz.Show Only Wrong Ans In Answer Sheet')}} </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-{{$size}}  mt-{{$top}} ">
                                                        <ul class="permission_list">
                                                            <li>
                                                                <label class="primary_checkbox d-flex mr-12 ">
                                                                    <input name="show_total_correct_answer"
                                                                           @if (@$quiz_setup->show_total_correct_answer==1) checked
                                                                           @endif value="1" type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <p for="#show_total_correct_answer">{{_trans('quiz.Show Total Correct Answer')}} </p>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                @endif
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-{{$advance?12:3}} mt-{{$top}} ">
                                                            <ul class="permission_list">
                                                                <li>
                                                                    <label
                                                                        class="primary_checkbox d-flex mr-12 text-nowrap ">
                                                                        <input
                                                                            name="losing_focus_acceptance_number_check"
                                                                            class="losing_focus_acceptance_number_check"
                                                                            @if (@$quiz_setup->losing_focus_acceptance_number>0) checked
                                                                            @endif
                                                                            value="1"
                                                                            type="checkbox"
                                                                        >

                                                                        <span class="checkmark"></span>

                                                                        <span
                                                                            class="ps-3"> {{trans('quiz.Losing focus acceptance')}}</span>
                                                                    </label>

                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-8 losing_total_count_div">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <label class="primary_input_label"
                                                                           for="groupInput">{{__('quiz.Losing type')}}
                                                                        *</label>
                                                                    <select
                                                                        class="primary_select "
                                                                        onChange="setLosingQuestionTime()"
                                                                        name="losing_type" id="losingType">
                                                                        <option
                                                                            value="0"
                                                                            @if (@$quiz_setup->losing_type!=1) selected
                                                                            @endif>{{__('quiz.Per Question Time')}}
                                                                        </option>
                                                                        <option
                                                                            @if (@$quiz_setup->losing_type==1) selected
                                                                            @endif
                                                                            value="1">{{__('quiz.Total Question Time')}}
                                                                        </option>

                                                                    </select>

                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <label
                                                                        for="#">

                                                        <span class="" id="losingPerQusCount"
                                                              style="display: {{$quiz_setup->losing_type!=1?'block':'none'}}">
                                                               {{trans('quiz.Per Question time count')}}
                                                        </span>
                                                                        <span id="losingTotalQusCount"
                                                                        >
                                                               {{trans('quiz.Total Quiz time count')}}
                                                        </span>

                                                                    </label>
                                                                    <input class="primary_input_field name"
                                                                           name="losing_focus_acceptance_number"
                                                                           value="{{$quiz_setup->losing_focus_acceptance_number??0}}"
                                                                           type="number">
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                </div>
                            </div>

                            @if($advance)

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="main-title">
                                            <h3 class="mb-20">
                                                {{__('quiz.Advance Quiz Setup')}}
                                            </h3>
                                        </div>


                                        <div>
                                            <div class="add-visitor">
                                                <div class="row">
                                                    <div class="col-lg-12 mt-{{$top}} ">
                                                        <ul class="permission_list">
                                                            <li>
                                                                <label class="primary_checkbox d-flex mr-12 ">
                                                                    <input name="difficulty_level_status"
                                                                           @if (@$quiz_setup->difficulty_level_status==1) checked
                                                                           @endif value="1"
                                                                           id="difficulty_level_status"
                                                                           type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <label
                                                                    for="#difficulty_level_status">{{trans('quiz.Enable Question Difficulty Level')}}</label>
                                                            </li>

                                                            <li>
                                                                <label class="primary_checkbox d-flex mr-12 ">
                                                                    <input name="auto_generate_quiz_code_status"
                                                                           @if (@$quiz_setup->auto_generate_quiz_code_status==1) checked
                                                                           @endif value="1"
                                                                           id="auto_generate_quiz_code_status"
                                                                           type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <label
                                                                    for="#auto_generate_quiz_code_status">{{trans('quiz.Auto Generate Quiz CODE')}}</label>
                                                            </li>

                                                            <li>
                                                                <label class="primary_checkbox d-flex mr-12 ">
                                                                    <input
                                                                        name="auto_generate_quiz_offline_testing_status"
                                                                        @if (@$quiz_setup->auto_generate_quiz_offline_testing_status==1) checked
                                                                        @endif value="1"
                                                                        id="auto_generate_quiz_offline_testing_status"
                                                                        type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <label
                                                                    for="#auto_generate_quiz_offline_testing_status">{{trans('quiz.Auto Generate Quiz for Offline testing')}}</label>
                                                            </li>

                                                            <li>
                                                                <label class="primary_checkbox d-flex mr-12 ">
                                                                    <input name="advance_test_mode_status"
                                                                           @if (@$quiz_setup->advance_test_mode_status==1) checked
                                                                           @endif value="1"
                                                                           id="advance_test_mode_status"
                                                                           type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <label
                                                                    for="#advance_test_mode_status">{{trans('quiz.Enable advance Test mode')}}</label>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            @endif


                        </div>

                        <div class="row mt-20">
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="primary-btn fix-gr-bg"
                                        data-bs-toggle="tooltip">
                                    <i class="ti-check"></i>
                                    {{__('quiz.Save Setup')}}
                                </button>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </form>

    </section>
    <div id="edit_form">

    </div>
    <div id="view_details">

    </div>

    {{-- @include('coupons::create') --}}
    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/manage_quiz.js').assetVersion()}}"></script>
    @if($advance)
        <script>
            $(".advance_quiz").find('.white-box').height($(".general_quiz").find('.white-box').height());
        </script>
    @endif
@endpush
