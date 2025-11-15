@extends('backend.master')
@section('mainContent')
    <style>
        @media only screen and (min-width: 992px) {
            .drawflow-node.ans {
                margin-right: 0 !important;
            }
        }

        .drawflow .drawflow-node {
            width: calc(100% / 12 * 5) !important;
        }

        .drawflow .drawflow-node .primary_input_field {
            width: 180px;
            align-self: start;
        }

        .drawflow .drawflow-node .input {
            z-index: 999 !important;
        }

        .thumb_img_div {
            height: 50px !important;
        }

        .thumb_img_div img {
            height: 50px !important;
        }

        .drawflow {
            min-width: 1500px;
        }

        .drawflow_content_node .primary_input.single-uploader {
            display: flex;
        }

        .ansNode .drawflow_content_node .primary_input.single-uploader {
            display: flex;
            flex-direction: row-reverse;
        }

        .drawflow_content_node .product_image_all_div {
            margin-top: 0;
            height: 46px;
            width: fit-content;
        }

        .drawflow_content_node .product_image_all_div img {
            height: 46px !important;
            width: 80px !important;
            object-fit: cover;
        }

        .drawflow_content_node .thumb_img_div {
            height: 46px !important;
            min-width: 90px !important;
            border: 0 !important;
        }

        .drawflow_content_node .primary_file_uploader {
            flex-grow: 1;
        }

        html[dir='rtl'] #drawflow {
            direction: ltr;
        }

        html[dir='rtl'] .drawflow .connection {
            right: auto;
            left: 0;
        }

        .drawflow-node .product_image_all_div {
            margin-left: 16px;
        }

        html[dir="rtl"] .drawflow-node .product_image_all_div {
            margin-right: 16px;
            margin-left: 0;
        }

    </style>
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($bank))
                @if (permissionCheck('question-bank.store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-end col-md-12 mb-20">

                        </div>
                    </div>
                @endif
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">


                            @if(isset($bank))

                                <form method="POST" action="{{ route('question-bank-update', $bank->id) }}"
                                      class="form-horizontal" enctype="multipart/form-data" id="question_bank">
                                    @method('PUT')
                                    @csrf
                                    @else
                                        @if (permissionCheck('question-bank.store'))
                                            <form method="POST" action="{{ route('question-bank.store') }}"
                                                  class="form-horizontal" enctype="multipart/form-data"
                                                  id="question_bank">
                                                @csrf
                                                @endif
                                                @endif
                                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

                                                <input type="hidden" name="connection" id="connection"
                                                       value="{{old('connection',isset($bank) && $bank->type=='X'?$bank->connection:null)}}">
                                                {{--                            <input type="hidden" name="data" id="data">--}}

                                                <div class="white-box ">
                                                    <div class="add-visitor">
                                                        <div class="row row-gap-3">
                                                            <div class="col-lg-4">
                                                                @php
                                                                    if(isset($bank)){
                                                                         request()->replace(['group'=>$bank->q_group_id]);
                                                                    }
                                                                @endphp
                                                                <label class="primary_input_label"
                                                                       for="groupInput">{{__('quiz.Group')}} <span
                                                                        class="required_mark">*</span></label>
                                                                <select {{ $errors->has('group') ? ' autofocus' : '' }}
                                                                        class="primary_select{{ $errors->has('group') ? ' is-invalid' : '' }}"
                                                                        name="group" id="groupInput">
                                                                    <option
                                                                        data-display="{{__('common.Select')}} {{__('quiz.Group')}} "
                                                                        value="">{{__('common.Select')}} {{__('quiz.Group')}}
                                                                    </option>
                                                                    @if(isModuleActive('AdvanceQuiz'))
                                                                        @foreach($groups->where('parent_id',0) as $group)
                                                                            @include('advancequiz::group._single_select_option_id',['group'=>$group,'level'=>1])
                                                                        @endforeach
                                                                    @else
                                                                        @foreach($groups as $group)
                                                                            @if(isset($bank))
                                                                                <option
                                                                                    value="{{$group->id}}" {{$group->id == $bank->q_group_id? 'selected': ''}}>{{$group->title}}</option>
                                                                            @else
                                                                                <option
                                                                                    value="{{$group->id}}" {{old('group')!=''? (old('group') == $group->id? 'selected':''):''}} >{{$group->title}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif

                                                                </select>

                                                            </div>
                                                            @if(isModuleActive('AdvanceQuiz'))
                                                                <div class="col-lg-4">
                                                                    <label class="primary_input_label"
                                                                           for="level">{{__('quiz.Question Level')}} </label>
                                                                    <select
                                                                        {{ $errors->has('level') ? ' autofocus' : '' }}
                                                                        class="primary_select {{ $errors->has('level') ? ' is-invalid' : '' }}"
                                                                        id="level" name="level">

                                                                        @foreach($levels as $level)
                                                                            @if(isset($bank))
                                                                                <option
                                                                                    value="{{$level->id}}" {{$bank->level == $level->id? 'selected': ''}}>{{$level->title}}</option>
                                                                            @else
                                                                                <option
                                                                                    value="{{$level->id}}" {{old('level')!=''? (old('level') == $level->id? 'selected':''):''}}>{{$level->title}}</option>
                                                                            @endif

                                                                        @endforeach
                                                                    </select>

                                                                </div>
                                                                <div class="col-lg-4 mt-30-md" id="preConditionQus">
                                                                    <label class="primary_input_label"
                                                                           for="subcategory_id">{{__('quiz.Pre-Condition Question')}}</label>
                                                                    <select
                                                                        {{ $errors->has('pre_condition') ? ' autofocus' : '' }}
                                                                        class="primary_select{{ $errors->has('pre_condition') ? ' is-invalid' : '' }} select_section"
                                                                        id="pre_condition" name="pre_condition">

                                                                        <option value="0"
                                                                                @if(isset($bank) && $bank->pre_condition==0)
                                                                                    selected
                                                                            @endif
                                                                        >{{__('common.No')}}</option>

                                                                        <option value="1"
                                                                                @if(isset($bank) && $bank->pre_condition==1)
                                                                                    selected
                                                                            @endif
                                                                        >{{__('common.Yes')}}</option>
                                                                    </select>

                                                                </div>
                                                            @endif
                                                            <div class="col-lg-4">
                                                                <label id="QuestionTypeLevel"
                                                                       class="primary_input_label {{isModuleActive('AdvanceQuiz')?'mt-25':''}}"
                                                                       for="question-type">{{__('quiz.Question Type')}}
                                                                    <span
                                                                        class="required_mark">*</span></label>
                                                                <select
                                                                    {{ $errors->has('question_type') ? ' autofocus' : '' }}
                                                                    class="primary_select{{ $errors->has('question_type') ? ' is-invalid' : '' }}"
                                                                    name="question_type" id="question-type">
                                                                    <option data-display="{{__('quiz.Question Type')}} "
                                                                            value="">{{__('quiz.Question Type')}}
                                                                    </option>

                                                                    <option
                                                                        value="M" {{ old('question_type',isset($bank)? $bank->type:'') == 'M'? 'selected': '' }}> {{__('quiz.Multiple Choice')}}</option>

                                                                    <option
                                                                        value="O" {{ old('question_type',isset($bank)? $bank->type:'') == 'O'? 'selected': '' }} > {{__('quiz.Sorting')}} </option>

                                                                    <option
                                                                        value="X" {{ old('question_type',isset($bank)? $bank->type:'') == 'X'? 'selected': '' }} > {{__('quiz.Matching')}} </option>

                                                                    <option
                                                                        value="C" {{ old('question_type',isset($bank)? $bank->type:'') == 'C'? 'selected': '' }} > {{__('quiz.Cloze question')}} </option>

                                                                    <option
                                                                        value="P" {{ old('question_type',isset($bank)? $bank->type:'') == 'P'? 'selected': '' }} > {{__('quiz.Puzzle')}} </option>

                                                                    <option
                                                                        value="S" {{ old('question_type',isset($bank)? $bank->type:'') == 'S'? 'selected': '' }}> {{__('quiz.Short Answer')}} </option>
                                                                    <option
                                                                        value="L" {{ old('question_type',isset($bank)? $bank->type:'') == 'L'? 'selected': '' }}> {{__('quiz.Long Answer')}} </option>
                                                                </select>

                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div
                                                                    class="input-effect {{isModuleActive('AdvanceQuiz')?'mt-25':''}}">
                                                                    <label
                                                                        class="primary_input_label"> {{__('quiz.Marks')}}
                                                                        <span
                                                                            class="required_mark">*</span>
                                                                    </label>
                                                                    <input
                                                                        {{ $errors->has('marks') ? ' autofocus' : '' }}
                                                                        class="primary_input_field name{{ $errors->has('marks') ? ' is-invalid' : '' }}"
                                                                        type="number" name="marks"
                                                                        value="{{isset($bank)? $bank->marks:(old('marks')!=''?(old('marks')):'')}}">
                                                                    <span class="focus-border"></span>

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2" id="shuffleBox">
                                                                <div
                                                                    class="input-effect @if(isModuleActive('AdvanceQuiz'))  mt-25 @endif">
                                                                    <label
                                                                        class="primary_input_label mt-1"> {{__('quiz.Shuffle Answer')}}
                                                                        <span
                                                                            class="required_mark">*</span>
                                                                    </label>
                                                                    <select
                                                                        {{ $errors->has('shuffle') ? ' autofocus' : '' }}
                                                                        class="primary_select{{ $errors->has('shuffle') ? ' is-invalid' : '' }}"
                                                                        name="shuffle" id="shuffle">
                                                                        <option
                                                                            value="1" {{isset($bank)? $bank->shuffle ==1? 'selected': '' : 'selected'}}> {{__('common.Yes')}}</option>
                                                                        <option
                                                                            value="0" {{isset($bank)? $bank->shuffle ==0? 'selected': '' : ''}}> {{__('common.No')}}</option>

                                                                    </select>

                                                                </div>
                                                            </div>


                                                            <div class="col-xl-4">
                                                                <div class=" mt-25">
                                                                    <x-upload-file
                                                                        name="image"
                                                                        type="image"
                                                                        media_id="{{isset($bank)?$bank->image_media?->media_id:''}}"
                                                                        label="{{ __('common.Image') }}"
                                                                    />
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="row mt-25">
                                                            <div class="col-lg-12">
                                                                <div class="input-effect">
                                                                    <label
                                                                        class="primary_input_label mt-1"> {{__('quiz.Question')}}
                                                                        <span
                                                                            class="required_mark">*</span></label>
                                                                    <textarea
                                                                        class="textArea lms_summernote {{ @$errors->has('details') ? ' is-invalid' : '' }}"
                                                                        cols="30" rows="10"
                                                                        name="question">{{isset($bank)? $bank->question:(old('question')!=''?(old('question')):'')}}</textarea>

                                                                    <span class="focus-border textarea"></span>

                                                                </div>
                                                            </div>
                                                        </div>


                                                        @php
                                                            if((isset($bank) && $bank->type == "M") || old('question_type') == "M"){
                                                                 $multiple_choice = "";
                                                                 $multiple_options = "";
                                                             }

                                                              if((isset($bank) && $bank->type == "X") || old('question_type') == "X"){
                                                                 $matching_choice = "";
                                                                 $matching_options = "";
                                                             }

                                                              if((isset($bank) && $bank->type == "O") || old('question_type') == "O"){
                                                                     $sorting_choice = "";
                                                                     $sorting_options = "";
                                                                 }

                                                              if((isset($bank) && $bank->type == "P") || old('question_type') == "P"){
                                                                 $puzzle_choice = "";
                                                                 $puzzle_options = "";
                                                             }
                                                        @endphp
                                                        <div class="multiple-choice">
                                                            <div class="row  mt-25 align-items-end">
                                                                <div class="col-lg-8">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="primary_input_label mt-1"> {{__('quiz.Number Of Options')}}
                                                                            <span
                                                                                class="required_mark">*</span></label>
                                                                        <input
                                                                            {{ $errors->has('number_of_option') ? ' autofocus' : '' }}
                                                                            class="primary_input_field name{{ $errors->has('number_of_option') ? ' is-invalid' : '' }}"
                                                                            type="number" name="number_of_option"
                                                                            autocomplete="off"
                                                                            id="number_of_option"
                                                                            value="{{isset($bank)? $bank->number_of_option: ''}}">
                                                                        <span class="focus-border"></span>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 mt-40 mb-2">
                                                                    <button type="button"
                                                                            class="primary-btn small fix-gr-bg"
                                                                            id="create-option">{{__('quiz.Create')}} </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="matching-choice ">
                                                            <div class="row  mt-25">
                                                                <div class="col-lg-3">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="primary_input_label mt-1"> {{__('quiz.Number Of Options')}}
                                                                            <span
                                                                                class="required_mark">*</span></label>
                                                                        <input
                                                                            {{ $errors->has('number_of_option') ? ' autofocus' : '' }}
                                                                            class="primary_input_field name{{ $errors->has('number_of_option') ? ' is-invalid' : '' }}"
                                                                            type="number" name="number_of_qus"
                                                                            autocomplete="off"
                                                                            id="number_of_qus"
                                                                            data-title="{{__('quiz.Option')}}"
                                                                            value="{{isset($bank)? $bank->number_of_qus: ''}}">
                                                                        <span class="focus-border"></span>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 mt-40">
                                                                    <button type="button"
                                                                            class="primary-btn small fix-gr-bg"
                                                                            id="create-qus-option">{{__('quiz.Create')}} </button>
                                                                </div>

                                                                <div class="col-lg-3">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="primary_input_label mt-1"> {{__('quiz.Number Of Answer')}}
                                                                            <span
                                                                                class="required_mark">*</span></label>
                                                                        <input
                                                                            {{ $errors->has('number_of_ans') ? ' autofocus' : '' }}
                                                                            class="primary_input_field name{{ $errors->has('number_of_ans') ? ' is-invalid' : '' }}"
                                                                            type="number" name="number_of_ans"
                                                                            autocomplete="off"
                                                                            id="number_of_ans"
                                                                            data-title="{{__('quiz.Answer')}}"
                                                                            value="{{old('number_of_ans',isset($bank)? $bank->number_of_ans: '')}}">
                                                                        <span class="focus-border"></span>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 mt-40">
                                                                    <button type="button"
                                                                            class="primary-btn small fix-gr-bg"
                                                                            id="create-ans-option">{{__('quiz.Create')}} </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="sorting-choice">
                                                            <div class="row  mt-25 align-items-end">
                                                                <div class="col-lg-8">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="primary_input_label mt-1"> {{__('quiz.Number Of Options')}}
                                                                            <span
                                                                                class="required_mark">*</span></label>
                                                                        <input
                                                                            {{ $errors->has('number_of_sorting_option') ? ' autofocus' : '' }}
                                                                            class="primary_input_field name{{ $errors->has('number_of_sorting_option') ? ' is-invalid' : '' }}"
                                                                            type="number"
                                                                            name="number_of_sorting_option"
                                                                            autocomplete="off"
                                                                            id="number_of_sorting_option"
                                                                            value="{{isset($bank)? $bank->number_of_option: ''}}">
                                                                        <span class="focus-border"></span>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 mt-40 mb-2">
                                                                    <button type="button"
                                                                            class="primary-btn small fix-gr-bg"
                                                                            id="create-sorting-option">{{__('quiz.Create')}} </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="cloze-choice">
                                                            <div class="row  mt-25 align-items-end">
                                                                <div class="col-lg-8">
                                                                    <div class="input-effect">
                                                                        <div class="instruction-box pt-3 pb-3">
                                                                            <strong>{{__('quiz.Instruction')}}:</strong>
                                                                            {{__('quiz.Please enter your question in the following format')}}
                                                                            :
                                                                            use <code>[1]</code>, <code>[2]</code>, etc.
                                                                            to indicate the
                                                                            blanks.
                                                                            <br>Example: "The capital of France is
                                                                            <code>[1]</code>."
                                                                        </div>

                                                                        <label
                                                                            class="primary_input_label mt-1"> {{__('quiz.Number Of Blanks')}}
                                                                            <span
                                                                                class="required_mark">*</span>
                                                                        </label>

                                                                        <input
                                                                            {{ $errors->has('number_of_cloze_option') ? ' autofocus' : '' }}
                                                                            class="primary_input_field name{{ $errors->has('number_of_cloze_option') ? ' is-invalid' : '' }}"
                                                                            type="number" name="number_of_cloze_option"
                                                                            autocomplete="off"
                                                                            id="number_of_cloze_option"
                                                                            value="{{isset($bank)? $bank->number_of_option: ''}}">
                                                                        <span class="focus-border"></span>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 mt-40 mb-2">
                                                                    <button type="button"
                                                                            class="primary-btn small fix-gr-bg"
                                                                            id="create-cloze-option">{{__('quiz.Create')}} </button>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="puzzle-choice ">
                                                            <div class="row  mt-25">
                                                                <div class="col-lg-3">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="primary_input_label mt-1"> {{__('quiz.Number Of Options')}}
                                                                            <span
                                                                                class="required_mark">*</span></label>
                                                                        <input
                                                                            {{ $errors->has('puzzle_number_of_qus') ? ' autofocus' : '' }}
                                                                            class="primary_input_field name{{ $errors->has('puzzle_number_of_qus') ? ' is-invalid' : '' }}"
                                                                            type="number" name="puzzle_number_of_qus"
                                                                            autocomplete="off"
                                                                            id="puzzle_number_of_qus"
                                                                            data-title="{{__('quiz.Option')}}"
                                                                            value="{{isset($bank)? $bank->number_of_qus: ''}}">
                                                                        <span class="focus-border"></span>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 mt-40">
                                                                    <button type="button"
                                                                            class="primary-btn small fix-gr-bg"
                                                                            id="create-puzzle-qus-option">{{__('quiz.Create')}} </button>
                                                                </div>

                                                                <div class="col-lg-3">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="primary_input_label mt-1"> {{__('quiz.Number Of Answer')}}
                                                                            <span
                                                                                class="required_mark">*</span></label>
                                                                        <input
                                                                            {{ $errors->has('puzzle_number_of_ans') ? ' autofocus' : '' }}
                                                                            class="primary_input_field name{{ $errors->has('puzzle_number_of_ans') ? ' is-invalid' : '' }}"
                                                                            type="number" name="puzzle_number_of_ans"
                                                                            autocomplete="off"
                                                                            id="puzzle_number_of_ans"
                                                                            data-title="{{__('quiz.Answer')}}"
                                                                            value="{{old('puzzle_number_of_ans',isset($bank)? $bank->number_of_ans: '')}}">
                                                                        <span class="focus-border"></span>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 mt-40">
                                                                    <button type="button"
                                                                            class="primary-btn small fix-gr-bg"
                                                                            id="create-puzzle-ans-option">{{__('quiz.Create')}} </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{--question option start--}}
                                                        <div class="multiple-options questionBoxDiv"
                                                             id="{{isset($multiple_options)? "": 'multiple-options'}}">
                                                            @php
                                                                $i=0;
                                                                $multiple_options = [];

                                                                if(isset($bank)){
                                                                    if($bank->type == "M"){
                                                                        $multiple_options = $bank->questionMuInSerial;
                                                                    }
                                                                }
                                                            @endphp
                                                            @foreach($multiple_options as $multiple_option)

                                                                @php $i++; @endphp
                                                                <div class='row  mt-25'>
                                                                    <div class='col-lg-10'>
                                                                        <div class='input-effect'>
                                                                            <input class='primary_input_field name'
                                                                                   type='text'
                                                                                   name='option[]' autocomplete='off'
                                                                                   required
                                                                                   value="{{$multiple_option->title}}">
                                                                            <span class='focus-border'></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class='col-lg-2 mt-40'>
                                                                        <label class="primary_checkbox d-flex mr-12 "
                                                                               for="option_check_{{$i}}">
                                                                            <input type="checkbox"
                                                                                   @if ($multiple_option->status==1) checked
                                                                                   @endif id="option_check_{{$i}}"
                                                                                   name="option_check_{{$i}}" value="1">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <div class="sorting-options questionBoxDiv"
                                                             id="{{isset($multiple_options)? "": 'multiple-options'}}">
                                                            @php
                                                                $i=0;
                                                                $sorting_options = [];

                                                                if(isset($bank)){
                                                                    if($bank->type == "O"){
                                                                        $sorting_options = $bank->questionSortingOptionsSerial;
                                                                    }
                                                                }
                                                            @endphp
                                                            @foreach($sorting_options as $key=>$sorting_option)

                                                                <div class='row  mt-25' id='option-{{$key}}'>
                                                                    <div class='col-lg-10'>
                                                                        <div class='input-effect'>
                                                                            <input class='primary_input_field name'
                                                                                   type='text'
                                                                                   name='sorting_option[]'
                                                                                   autocomplete='off' required
                                                                                   value="{{$sorting_option->title}}">
                                                                            <span class='focus-border'></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class='col-lg-2 mt-15 '>
                                                                        <span class='drag-handle' style='cursor: move;'>&#9776;</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <div class="matching-options "
                                                             id="{{isset($matching_choice)? "": 'matching-options'}}">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div id="drawflow" ondrop="drop(event)"
                                                                         ondragover="allowDrop(event)"
                                                                         style="width: 100%;overflow: auto">


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="cloze-options QA_section   table-responsive">
                                                            <table class=" QA_table table table-borderless mt-3">
                                                                <thead>
                                                                <tr>
                                                                    <th class="p-2">{{trans('quiz.Number')}}</th>
                                                                    <th class="p-2 w-75">{{trans('quiz.Options')}}</th>
                                                                    <th class="p-2">{{trans('common.Action')}}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @php
                                                                    $i = 0;
                                                                    $cloze_options = [];

                                                                    if (isset($bank) && $bank->type == "C") {
                                                                        $cloze_options = $bank->questionMuInSerial;
                                                                    }
                                                                @endphp
                                                                @if(isset($cloze_options) && count($cloze_options) > 0)
                                                                    @foreach($cloze_options->groupBy('group') as $key => $cloze_group)
                                                                        <tr class='option-row'>
                                                                            <td class='p-2'>{{ $loop->iteration }}</td>
                                                                            <td class='p-2'>
                                                                                <div class='options-container'
                                                                                     data-row-number='{{ $loop->iteration }}'>
                                                                                    @foreach($cloze_group as $option)
                                                                                        <div
                                                                                            class='input-effect mb-2 d-flex align-items-center'>
                                                                                            {{-- Pre-fill option value --}}
                                                                                            <input
                                                                                                class='primary_input_field name'
                                                                                                placeholder='Option {{ $loop->iteration }}'
                                                                                                type='text'
                                                                                                name='cloze_option[{{ $loop->parent->iteration }}][]'
                                                                                                value="{{ $option->title }}"
                                                                                                autocomplete='off'
                                                                                                required>

                                                                                            {{-- Checkbox for correct answer --}}
                                                                                            <label
                                                                                                class='primary_checkbox d-flex ms-3'>
                                                                                                <input
                                                                                                    name='cloze_answer[{{ $loop->parent->iteration }}]'
                                                                                                    value='{{ $loop->iteration }}'
                                                                                                    type='radio' {{ $option->status ? 'checked' : '' }}>
                                                                                                <span
                                                                                                    class='checkmark'></span>
                                                                                            </label>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </td>
                                                                            <td class='p-2'>
                                                                                <div class='d-flex'>
                                                                                    <button type='button'
                                                                                            class='primary-btn small fix-gr-bg add-option-btn'>
                                                                                        <i class='ti ti-plus m-0 p-0'></i>
                                                                                    </button>
                                                                                    <button type='button'
                                                                                            class='primary-btn small fix-gr-bg remove-option-btn ms-2'>
                                                                                        <i class='ti ti-trash m-0 p-0'></i>
                                                                                    </button>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>


                                                            </table>

                                                        </div>


                                                        <div class="puzzle-options">


                                                            @php
                                                                $i=0;
                                                                $puzzle_options = [];

                                                                $puzzleQus =[];
                                                                $puzzleAns =[];
                                                                if(isset($bank) && $bank->type == "P"){
                                                                    $puzzle_options = $bank->questionSortingOptionsSerial;
                                                                    $puzzleQus = $puzzle_options->where('type',1);
                                                                    $puzzleAns = $puzzle_options->where('type',0);
                                                                }
                                                            @endphp

                                                            <div class="row">
                                                                <div class="col-6 mt-3" id="puzzleQus">
                                                                    @php
                                                                        $puzzleQusIndex=0;
                                                                    @endphp
                                                                    @foreach($puzzleQus as  $qus)
                                                                        <div class='row optionType mb-3' data-type='qus'
                                                                             data-index='{{ $puzzleQusIndex }}'>
                                                                            <div class='col-lg-12 optionTitle'>
                                                                                <div class='input-group'>
                                                                                    <input
                                                                                        class='form-control option_title'
                                                                                        type='text'
                                                                                        value="{{$qus->title}}"
                                                                                        name='puzzle_qus[{{ $puzzleQusIndex }}]'
                                                                                        placeholder='Enter Question {{ $puzzleQusIndex + 1 }}'
                                                                                        required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php
                                                                            $puzzleQusIndex++;
                                                                        @endphp
                                                                    @endforeach
                                                                </div>
                                                                <div class="col-6 mt-3" id="puzzleAns">
                                                                    @php
                                                                        $puzzleAnsIndex=0;
                                                                    @endphp
                                                                    @foreach($puzzleAns as  $ans)
                                                                        <div class='row optionType mb-3' data-type='ans'
                                                                             data-index='{{ $puzzleAnsIndex }}'>
                                                                            <div class='col-lg-12 optionTitle'>
                                                                                <div class='input-group'>
                                                                                    <input
                                                                                        class='form-control ans_title'
                                                                                        type='text'
                                                                                        value="{{$ans->title}}"
                                                                                        name='puzzle_ans[{{ $puzzleAnsIndex }}]'
                                                                                        placeholder='Enter Answer {{ $puzzleAnsIndex + 1 }}'>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php
                                                                            $puzzleAnsIndex++;
                                                                        @endphp
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-12" id="puzzleCombine">
                                                                    @if(isset($bank))
                                                                        <div class="col-12">
                                                                            <h4>{{ __('quiz.Correct option') }}</h4>
                                                                        </div>
                                                                        @php
                                                                            $puzzleQusIndex=0;
                                                                        @endphp
                                                                        @foreach($puzzleQus as $i => $qus)
                                                                            <div class="row mb-5">
                                                                                <div class="col-lg-6">
                                                                                    <label>{{__('quiz.Question')}} {{ $puzzleQusIndex=$puzzleQusIndex + 1 }}
                                                                                        :</label>
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-6 d-flex flex-column gap-3">
                                                                                    @php
                                                                                        $puzzleAnsIndex=0;
                                                                                    @endphp
                                                                                    @foreach($puzzleAns as $j => $ans)
                                                                                        @php
                                                                                            $checkboxId = "questionReview_{$i}_{$j}";
                                                                                            $hasItem= $bank->matchingOptions->where('option_id',$qus->id)->where('answer_id',$ans->id)->first();
                                                                                        @endphp
                                                                                        <label
                                                                                            class="primary_checkbox d-flex text-nowrap mr-12">
                                                                                            <input
                                                                                                name="question_review[{{ $i }}][{{$puzzleAnsIndex}}]"
                                                                                                value="{{ $puzzleAnsIndex }}"
                                                                                                id="{{ $checkboxId }}"
                                                                                                {{$hasItem? 'checked': ''}}
                                                                                                type="checkbox">
                                                                                            <span
                                                                                                class="checkmark"></span>
                                                                                            <span
                                                                                                class="ms-2">{{ trans('quiz.Answer').' ' . ($puzzleAnsIndex =$puzzleAnsIndex+1) }}</span>
                                                                                        </label>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- question options end--}}


                                                        <div class="">
                                                            <div class="row  mt-25">
                                                                <div class="col-lg-12">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="primary_input_label mt-1"> {{__('quiz.Explanation')}} </label>
                                                                        <textarea
                                                                            class="textArea lms_summernote {{ @$errors->has('details') ? ' is-invalid' : '' }}"
                                                                            cols="10" rows="10"
                                                                            name="explanation">{{isset($bank)? $bank->explanation:(old('explanation')!=''?(old('explanation')):'')}}</textarea>

                                                                        <span class="focus-border textarea"></span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-3">
                                                            <div class="col-lg-12 text-center">
                                                                <button class="primary-btn fix-gr-bg questionSubmitBtn"
                                                                        data-bs-toggle="tooltip"
                                                                        type="submit">
                                                                    <i class="ti-check"></i>
                                                                    {{ isset($bank) ? __('common.Update') : __('common.Save') }} {{ __('quiz.Question') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{--
        <div class="modal fade admin-query" id="deleteBank">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('common.Delete')}} </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                class="ti-close "></i></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{route('question-bank-delete')}}" method="post">
                            @csrf

                            <div class="text-center">

                                <h4>{{__('common.Are you sure to delete ?')}} </h4>
                            </div>
                            <input type="hidden" name="id" value="" id="classQusId">
                            <div class="mt-40 d-flex justify-content-between">
                                <button type="button" class="primary-btn tr-bg"
                                        data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                <button class="primary-btn fix-gr-bg"
                                        type="submit">{{__('common.Delete')}}</button>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade admin-query" id="removeImageModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('common.Confirm')}} </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                class="ti-close "></i></button>
                    </div>

                    <div class="modal-body">
                        <form action="#" method="post">
                            @csrf

                            <div class="text-center">

                                <h4>{{__('common.Are you sure to remove')}}? </h4>
                            </div>
                            <input type="hidden" value="" id="quizId">
                            <input type="hidden" value="" id="targetContent">
                            <div class="mt-40 d-flex justify-content-between">
                                <button type="button" class="primary-btn tr-bg"
                                        data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                <button class="primary-btn fix-gr-bg removeImageConfirm"
                                        type="button">{{__('common.Remove')}}</button>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        --}}
@endsection
@push('scripts')

    <script>

        $("body").on('change', '.fileUpload1', function () {
            let placeholder = $(this).closest(".primary_file_uploader").find(".filePlaceholder");
            let fileInput = event.srcElement;
            placeholder.val(fileInput.files[0].name);
            console.log(fileInput.files[0].name);
            $('.removeImage1').removeClass('d-none');
        });


        $(document).on("click", ".questionSubmitBtn", function (e) {

            e.preventDefault();
            let type = $('#question-type').val();
            if (type == 'M') {
                let div = $('.questionBoxDiv');
                let count = div.find('[type=checkbox]:checked').length;
                let errorOptionCount = 0;

                if (count < 1) {
                    toastr.error('{{__('common.At least one correct answer is required')}} ', '{{__('common.Error')}}');
                    return false;
                }

                $('input[name="option[]"]').each(function (index) {
                    if ($(this).val().trim() == "") {
                        errorOptionCount++;
                    }
                });

                if (errorOptionCount != 0) {
                    toastr.error('{{__("quiz.Option title is required")}}', '{{__("common.Error")}}');
                    return false;
                }

            } else if (type == 'X') {
                let connection = $('#connection').val().length;
                if (connection == 0) {
                    toastr.error('{{__('common.At least one correct answer is required')}} ', '{{__('common.Error')}}');
                    return false;
                }
                let errorCount = 0;
                $('.option_title').each(function (index) {
                    if ($(this).val().trim() == "") {
                        errorCount++;
                        toastr.error('{{__('quiz.Option title is required')}} ', '{{__('common.Error')}}');
                    }
                });
                $('.ans_title').each(function (index) {
                    if ($(this).val().trim() == "") {
                        errorCount++;
                        toastr.error('{{__('quiz.Answer title is required')}} ', '{{__('common.Error')}}');
                    }
                });
                if (errorCount != 0) {
                    return false;
                }
                $('#data').val(JSON.stringify(editor.export()));
            }else if(type =='P'){
                let errorCount = 0;
                $('.option_title').each(function (index) {
                    if ($(this).val().trim() == "") {
                        errorCount++;
                        toastr.error('{{__('quiz.Option title is required')}} ', '{{__('common.Error')}}');
                    }
                });
                $('.ans_title').each(function (index) {
                    if ($(this).val().trim() == "") {
                        errorCount++;
                        toastr.error('{{__('quiz.Answer title is required')}} ', '{{__('common.Error')}}');
                    }
                });

                if (errorCount != 0) {
                    return false;
                }
            }
            $(this).closest('form').submit();
        });

        $('#question-type').change(function (e) {

            let type = $('#question-type').val();
            if (type == 'M') {
                $('.multiple-choice').show();
                $('.multiple-options').show();

                $('.sorting-choice').hide();
                $('.sorting-options').hide();
                $('.cloze-choice').hide();
                $('.cloze-options').hide();
                $('.matching-choice').hide();
                $('.matching-options').hide();
                $('.puzzle-choice').hide();
                $('.puzzle-options').hide();
                $('#shuffleBox').show();
                $('#preConditionQus').show();
                @if(isModuleActive('AdvanceQuiz'))
                $('#QuestionTypeLevel').addClass('mt-25');
                @endif
            } else if (type == 'O') {
                $('.multiple-choice').hide();
                $('.multiple-options').hide();

                $('.sorting-choice').show();
                $('.sorting-options').show();
                $('.cloze-choice').hide();
                $('.cloze-options').hide();
                $('.matching-choice').hide();
                $('.matching-options').hide();
                $('.puzzle-choice').hide();
                $('.puzzle-options').hide();
                $('#shuffleBox').hide();
                $('#preConditionQus').hide();
                @if(isModuleActive('AdvanceQuiz'))
                $('#QuestionTypeLevel').addClass('mt-25');
                @endif
            } else if (type == 'C') {
                $('.multiple-choice').hide();
                $('.multiple-options').hide();
                $('.sorting-choice').hide();
                $('.sorting-options').hide();
                $('.cloze-choice').show();
                $('.cloze-options').show();
                $('.matching-choice').hide();
                $('.matching-options').hide();
                $('.puzzle-choice').hide();
                $('.puzzle-options').hide();
                $('#shuffleBox').hide();
                $('#preConditionQus').hide();
                @if(isModuleActive('AdvanceQuiz'))
                $('#QuestionTypeLevel').addClass('mt-25');
                @endif
            } else if (type == 'P') {
                $('.multiple-choice').hide();
                $('.multiple-options').hide();
                $('.sorting-choice').hide();
                $('.sorting-options').hide();
                $('.cloze-choice').hide();
                $('.cloze-options').hide();
                $('.matching-choice').hide();
                $('.matching-options').hide();
                $('.puzzle-choice').show();
                $('.puzzle-options').show();
                $('#shuffleBox').hide();
                $('#preConditionQus').hide();
                @if(isModuleActive('AdvanceQuiz'))
                $('#QuestionTypeLevel').addClass('mt-25');
                @endif
            } else if (type == 'X') {
                $('.matching-choice').show();
                $('.matching-options').show();
                $('.sorting-choice').hide();
                $('.sorting-options').hide();
                $('.cloze-choice').hide();
                $('.cloze-options').hide();
                $('.multiple-choice').hide();
                $('.multiple-options').hide();
                $('.puzzle-choice').hide();
                $('.puzzle-options').hide();
                $('#shuffleBox').hide();
                $('#preConditionQus').show();
                @if(isModuleActive('AdvanceQuiz'))
                $('#QuestionTypeLevel').addClass('mt-25');
                @endif
            } else {
                $('.sorting-choice').hide();
                $('.sorting-options').hide();
                $('.multiple-choice').hide();
                $('.multiple-options').hide();
                $('.matching-choice').hide();
                $('.matching-options').hide();
                $('.puzzle-choice').hide();
                $('.puzzle-options').hide();
                $('.cloze-choice').hide();
                $('.cloze-options').hide();
                $('#shuffleBox').hide();
                $('#preConditionQus').hide();
                @if(isModuleActive('AdvanceQuiz'))
                $('#QuestionTypeLevel').removeClass('mt-25');
                @endif

            }

            if (type == "S") {
                $('#marks_required').hide();
            } else {
                $('#marks_required').show();
            }

        });
        $('#question-type').trigger('change')


        $(document).on("click", ".removeImage1", function (e) {
            e.preventDefault();
            let target = $(this).data('target')
            let id = $(this).data('id')
            console.log(id);
            $('#targetContent').val(target);
            $('#quizId').val(id);
            $('#removeImageModal').modal('show');
        });

        $(document).on("click", ".removeImageConfirm", function (e) {
            e.preventDefault();
            let target_name = $('#targetContent').val();
            let id = $('#quizId').val();
            let target = $(target_name);
            target.find('.filePlaceholder').val('');
            target.find('.fileUpload1').val('');
            $('#removeImageModal').modal('hide');
            $('.removeImage1').addClass('d-none');
            if (id != "") {


                var formData = {
                    id: id,
                };
                $.ajax({
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    url: "{{url('quiz/remove-image-ajax')}}",
                    success: function (data) {

                    },
                    error: function (data) {
                        console.log("Error:", data);
                    },
                });
            }
        });


        $(document).on("click", "#create-sorting-option", function (event) {
            $('#question_bank div.sorting-options').html('');

            var number_of_option = $('#number_of_sorting_option').val();
            for (var i = 0; i < number_of_option; i++) {
                var appendRow = '';
                appendRow += "<div class='row  mt-25' id='option-" + i + "'' data-id='" + i + "'>";
                appendRow += "<div class='col-lg-10 optionTitle'>";
                appendRow += "<div class='input-effect'>"
                appendRow += "<input class='primary_input_field name' type='text' name='sorting_option[]' autocomplete='off' required>";
                appendRow += "</div>";
                appendRow += "</div>";
                appendRow += "<div class='col-lg-2 mt-15 '>";

                appendRow += "            <span class='drag-handle' style='cursor: move;'>&#9776;</span>";

                appendRow += "</div>";
                appendRow += "</div>";

                $(".sorting-options").append(appendRow);
                console.log('here')

                getSortingOrders();

            }
        });


        function getSortingOrders() {
            $('.sorting-options').sortable({
                handle: ".drag-handle",
            });
        }

        getSortingOrders();
        // Cloze option
        $(document).on("click", "#create-cloze-option", function (event) {
            // Clear the options container before adding new rows
            $('.cloze-options').empty();

            // Get the number of rows from input
            var number_of_option = $('#number_of_cloze_option').val();

            // Initialize the table structure outside the loop
            var appendTable = '<table class="QA_table table table-borderless mt-3">';
            appendTable += '<thead>';
            appendTable += '<tr>';
            appendTable += '<th class="p-2">{{trans("quiz.Number")}}</th>';
            appendTable += '<th class="p-2 w-75">{{trans("quiz.Options")}}</th>';
            appendTable += '<th class="p-2">{{trans("common.Action")}}</th>';
            appendTable += '</tr>';
            appendTable += '</thead>';
            appendTable += '<tbody>'; // Start tbody

            // Generate rows based on the number_of_option input
            for (var i = 0; i < number_of_option; i++) {
                appendTable += generateOptionRow(i + 1);  // Generate each row
            }

            appendTable += '</tbody>'; // End tbody
            appendTable += '</table>';  // End table

            // Append the whole table at once
            $('.cloze-options').append(appendTable);

            console.log('Cloze options with multiple choices created');
        });

        // Function to generate a row with multiple options (default 4 options per row)
        function generateOptionRow(rowNumber) {
            var defaultOptions = 4;  // Default number of options per row
            var rowHTML = "<tr class='option-row'>";
            rowHTML += "<td class='p-2'>" + rowNumber + "</td>";
            rowHTML += "<td class='p-2'>";

            // Create a div that contains multiple options (default 4 options)
            rowHTML += "<div class='options-container' data-row-number='" + rowNumber + "'>";

            for (var i = 0; i < defaultOptions; i++) {
                rowHTML += generateOptionInput(rowNumber, i + 1);
            }

            rowHTML += "</div>";  // End options-container div
            rowHTML += "</td>";

            rowHTML += "<td class='p-2'>";
            rowHTML += "<div class='d-flex'><button type='button' class='primary-btn small fix-gr-bg add-option-btn'><i class='ti ti-plus m-0 p-0'></i></button>";
            rowHTML += "<button type='button' class='primary-btn small fix-gr-bg remove-option-btn ms-2'><i class='ti ti-trash  m-0 p-0'></i></button></div>";
            rowHTML += "</td>";
            rowHTML += "</tr>";

            return rowHTML;
        }

        // Function to generate an individual option input
        function generateOptionInput(rowNumber, optionNumber) {
            return "<div class='input-effect mb-2 d-flex align-items-center'>" +
                "<input class='primary_input_field name' placeholder='Option " + optionNumber + "' type='text' name='cloze_option[" + rowNumber + "][]' autocomplete='off' required>" +
                "<label class='primary_checkbox d-flex ms-3'>" +
                "<input name='cloze_answer[" + rowNumber + "]' value='" + optionNumber + "' type='radio'>" +
                "<span class='checkmark'></span>" +
                "</label>" +
                "</div>";
        }


        // Add new option input within a specific row
        $(document).on("click", ".add-option-btn", function () {
            // Get the parent row and number of current options in the row
            var optionsContainer = $(this).closest('tr').find('.options-container');
            var rowNumber = optionsContainer.data('row-number');
            var optionCount = optionsContainer.children().length;

            // Append a new option input to the current row
            optionsContainer.append(generateOptionInput(rowNumber, optionCount + 1));
        });

        // Remove the last option input within a specific row
        $(document).on("click", ".remove-option-btn", function () {
            var optionsContainer = $(this).closest('tr').find('.options-container');
            var optionCount = optionsContainer.children().length;

            // Ensure there's at least 1 option left in the row
            if (optionCount > 1) {
                optionsContainer.children().last().remove();
            } else {
                toastr.error("{{__('quiz.At least one option is required')}}")
            }
        });


        // Generate puzzle question input fields
        $(document).on("click", "#create-puzzle-qus-option", function (event) {
            let qusItem = $('#puzzle_number_of_qus').val();
            let qusRow = '';

            // Translation strings for question
            let enterQuestion = "{{ trans('quiz.Enter Question') }}";

            for (let i = 0; i < qusItem; i++) {
                qusRow += "<div class='row optionType mb-3' data-type='qus' data-index='" + i + "'>";
                qusRow += "<div class='col-lg-12 optionTitle'>";
                qusRow += "<div class='input-group'>";
                qusRow += "<input class='form-control option_title' type='text' name='puzzle_qus[" + i + "]' placeholder='" + enterQuestion + " " + (i + 1) + "' required>";
                qusRow += "</div>";
                qusRow += "</div>";
                qusRow += "</div>";
            }

            $('#puzzleQus').html(qusRow);
            combineQusAndAns();
        });

        // Generate puzzle answer input fields
        $(document).on("click", "#create-puzzle-ans-option", function (event) {
            let ansItem = $('#puzzle_number_of_ans').val();
            let ansRow = '';

            // Translation strings for answer
            let enterAnswer = "{{ trans('quiz.Enter Answer') }}";

            for (let i = 0; i < ansItem; i++) {
                ansRow += "<div class='row optionType mb-3' data-type='ans' data-index='" + i + "'>";
                ansRow += "<div class='col-lg-12 optionTitle'>";
                ansRow += "<div class='input-group'>";
                ansRow += "<input class='form-control ans_title' type='text' name='puzzle_ans[" + i + "]' placeholder='" + enterAnswer + " " + (i + 1) + "'>";
                ansRow += "</div>";
                ansRow += "</div>";
                ansRow += "</div>";
            }

            $('#puzzleAns').html(ansRow);
            combineQusAndAns();
        });


        function combineQusAndAns() {
            let qusElements = $('#puzzleQus .optionType');
            let ansElements = $('#puzzleAns .optionType');
            let combineRow = `
                <div class="col-12">
                    <h4>{{__('quiz.Correct option')}}</h4>
                </div>
            `;

            if (qusElements.length > 0 && ansElements.length > 0) {
                for (let i = 0; i < qusElements.length; i++) {
                    let qus = "{{trans('quiz.Question')}} " + (i + 1) + " :";

                    combineRow += "<div class='row mb-5'>";
                    combineRow += "<div class='col-lg-6 '>";
                    combineRow += "<label> " + qus + "</label>";
                    combineRow += "</div>";
                    combineRow += "<div class='col-lg-6 d-flex flex-column gap-3'>";

                    // Create checkboxes for all available answers
                    for (let j = 0; j < ansElements.length; j++) {
                        let ans = "{{__('quiz.Answer')}} " + (j + 1);

                        // Create unique IDs for each checkbox
                        let checkboxId = `questionReview_${i}_${j}`;

                        combineRow += "<label class='primary_checkbox d-flex text-nowrap mr-12'>";
                        combineRow += `<input name='question_review[${i}][${j}]' value='${j}' id='${checkboxId}' type='checkbox'>`;
                        combineRow += `<span class='checkmark'></span>`;
                        combineRow += `<span class='ms-2'>${ans}</span>`;
                        combineRow += "</label>";
                    }

                    combineRow += "</div>";
                    combineRow += "</div>";
                }
                $('#puzzleCombine').html(combineRow);
            }
        }


        $(document).on("change", ".option_title", function () {
            const index = $(this).closest('.optionType').data('index');
            const newValue = $(this).val();
            console.log(`Question ${index + 1} changed to: "${newValue}"`);
            // Add any additional logic you want to perform on change
        });

        // Handle change events for answer text inputs
        $(document).on("change", ".ans_title", function () {
            const index = $(this).closest('.optionType').data('index');
            const newValue = $(this).val();
            console.log(`Answer ${index + 1} changed to: "${newValue}"`);
            // Add any additional logic you want to perform on change
        });
    </script>
    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>


    @includeIf("quiz::partials._quiz_bank_script")
@endpush
