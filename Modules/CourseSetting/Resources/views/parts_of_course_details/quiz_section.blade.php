@php
    $user = Auth::user();
    if ($user->role_id == 2) {
        $groups = Modules\Quiz\Entities\QuestionGroup::where('active_status', 1)->where('user_id', $user->id)->latest()->get();
    } else {
        $groups = Modules\Quiz\Entities\QuestionGroup::where('active_status', 1)->latest()->get();
    }
@endphp
@if(isset($bank))
    <form class="form-horizontal" method="POST" action="{{ route('question-bank-update', $bank->id) }}" enctype="multipart/form-data" id="question_bank">
        @csrf
        @method('PUT')
        @else
            @if (permissionCheck('question-bank.store'))
                <form class="form-horizontal" method="POST" action="{{ route('save-course-quiz') }}" enctype="multipart/form-data" id="question_bank">
                    @csrf
                    @endif
                    @endif

<input type="hidden" id="url" value="{{url('/')}}">
<input type="hidden" name="course_id" value="{{@$course->id}}">
<input type="hidden" name="category" value="{{@$course->category_id}}">
<input type="hidden" name="question_type" value="M">
@if (isset($course->subcategory_id))
    <input type="hidden" name="sub_category" value="{{@$course->subcategory_id}}">
@endif
<div class="section-white-box">
    <div class="add-visitor">

        <div class="row">
            <div class="col-lg-12">

                <div class="quiz_div">
                    <input type="hidden" name="is_quiz" value="1">
                    <div class="row ">
                        <div class="col-lg-12 ">
                            <label class="primary_input_label mt-3"
                                   for=""> {{__('courses.Chapter')}}
                                <span class="required_mark">*</span></label>
                            <select class="primary_select " name="chapterId">
                                <option
                                    data-display="{{__('common.Select')}} {{__('courses.Chapter')}}"
                                    value="">{{__('common.Select')}} {{__('courses.Chapter')}} </option>
                                @foreach ($chapters as $chapter)
                                    <option
                                        value="{{@$chapter->id}}" {{isset($editLesson)? ($editLesson->chapter_id == $chapter->id? 'selected':''):''}} >{{@$chapter->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('chapterId'))
                                <span class="invalid-feedback invalid-select"
                                      role="alert">
                <strong>{{ $errors->first('chapterId') }}</strong>
            </span>
                            @endif
                        </div>
                    </div>

                    <div class="input-effect mt_35 ">
                        <div class="col-xl-6 ">
                            <div class="row">
                                <div class="col-md-6">

                                    <input type="radio" class="common-radio type1"
                                           id="type{{@$course->id}}5" name="type"
                                           value="1" checked>
                                    <label
                                        for="type{{@$course->id}}5">Existing</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" class="common-radio type2"
                                           id="type{{@$course->id}}6" name="type"
                                           value="2">
                                    <label
                                        for="type{{@$course->id}}6">New</label>
                                </div>
                            </div>

                        </div>
                        @if ($errors->has('quiz'))
                            <span class="invalid-feedback invalid-select" role="alert">
                <strong>{{ $errors->first('quiz') }}</strong>
            </span>
                        @endif
                    </div>

                    <div class="input-effect mt-2 pt-1" id="existing_quiz">
                        <label class="primary_input_label mt-1" for=""> {{__('quiz.Quiz')}} <span class="required_mark">*</span></label>
                        <select class="primary_select" name="quiz">
                            <option
                                data-display="{{__('common.Select')}} {{__('quiz.Quiz')}}"
                                value="">{{__('common.Select')}} {{__('quiz.Quiz')}} </option>
                            @foreach ($quizzes as $quiz)
                                <option
                                    value="{{@$quiz->id}}" {{isset($editLesson)? ($editLesson->quiz_id == $quiz->id? 'selected':''):''}} >{{@$quiz->title}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('quiz'))
                            <span class="invalid-feedback invalid-select" role="alert">
                            <strong>{{ $errors->first('quiz') }}</strong>
                         </span>
                        @endif
                    </div>

                    {{-- Start New Create --}}
                    <div class="new_quiz mt-20" style="display: none">


                        @php
                            $LanguageList = getLanguageList();
                        @endphp
                        <div class="row pt-0">
                            @if(isModuleActive('FrontendMultiLang'))
                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                    role="tablist">
                                    @foreach ($LanguageList as $key => $language)
                                        <li class="nav-item">
                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                               href="#element{{$language->code}}"
                                               role="tab"
                                               data-bs-toggle="tab">{{ $language->native }}  </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="tab-content">
                            @foreach ($LanguageList as $key => $language)
                                <div role="tabpanel"
                                     class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                     id="element{{$language->code}}">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-effect mt-3">
                                                <label class="primary_input_label mt-1"
                                                       for=""> {{__('quiz.Quiz Title')}}
                                                    <span class="required_mark">*</span></label>
                                                <input {{ $errors->has('title') ? ' autofocus' : '' }}
                                                       class="primary_input_field name{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                       type="text" name="title[{{$language->code}}]" autocomplete="off"
                                                       value="{{isset($online_exam)? $online_exam->getTranslation('title',$language->code): ''}}">
                                                <input type="hidden" name="id"
                                                       value="{{isset($online_exam)? $online_exam->id: ''}}">
                                                <span class="focus-border"></span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="input-effect">
                                                <label class="primary_input_label mt-1"
                                                       for="">{{__('quiz.Instruction')}}
                                                    <span class="required_mark">*</span></label>
                                                <textarea {{ $errors->has('instruction') ? ' autofocus' : '' }}
                                                          class="primary_input_field name{{ $errors->has('instruction') ? ' is-invalid' : '' }}"
                                                          cols="0" rows="4"
                                                          name="instruction[{{$language->code}}]">{{isset($online_exam)? $online_exam->getTranslation('instruction',$language->code): ''}}</textarea>
                                                <span class="focus-border textarea"></span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mt-25">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <label class="primary_input_label mt-1" for="">{{__('quiz.Minimum Percentage')}}
                                        <span class="required_mark">*</span> </label>
                                    <input {{ $errors->has('title') ? ' percentage' : '' }}
                                           class="primary_input_field name{{ $errors->has('percentage') ? ' is-invalid' : '' }}"
                                           type="number" name="percentage" autocomplete="off"
                                           value="{{isset($online_exam)? $online_exam->percentage: old('percentage')}}">
                                    <input type="hidden" name="id"
                                           value="{{isset($group)? $group->id: ''}}">
                                    <span class="focus-border"></span>
                                    @if ($errors->has('percentage'))
                                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('percentage') }}</strong>
                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- End New Create --}}
                    @push('js')
                        <script>
                            $(".quiz_div input[name='type']").click(function () {
                                let new_quiz = $('.new_quiz');
                                let existing_quiz = $('#existing_quiz');
                                if ($('input:radio[name=type]:checked').val() == 1) {
                                    existing_quiz.show();
                                    new_quiz.hide();
                                    // alert($('input:radio[name=type]:checked').val());
                                    //$('#select-table > .roomNumber').attr('enabled',false);
                                } else {
                                    existing_quiz.hide();
                                    new_quiz.show();
                                }
                            });
                        </script>
                    @endpush
                    <div class="input-effect mt-2 pt-1">
                        <div class=" " id="">
                            <label class="primary_input_label "
                                   for="">{{__('courses.Privacy')}}
                                <span class="required_mark">*</span></label>
                            <select class="primary_select" name="lock">
                                <option
                                    data-display="{{__('common.Select')}} {{__('courses.Privacy')}} "
                                    value="">{{__('common.Select')}} {{__('courses.Privacy')}} </option>

                                <option value="0"
                                        @if (@$editLesson->is_lock==0) selected @endif >{{__('courses.Unlock')}}</option>

                                <option value="1"
                                        @if (!isset($editLesson) || @$editLesson->is_lock==1) selected @endif >{{__('courses.Locked')}}</option>
                            </select>
                            @if ($errors->has('is_lock'))
                                <span class="invalid-feedback invalid-select"
                                      role="alert">
                    <strong>{{ $errors->first('is_lock') }}</strong>
                </span>
                            @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="row mt-40">
            <div class="col-lg-12 d-flex gap-10 justify-content-center text-center">
                <button type="submit" class="primary-btn fix-gr-bg"
                        data-bs-toggle="tooltip">
                    <i class="ti-check"></i>
                    {{__('common.Save')}}
                </button>
            </div>
        </div>
    </div>
</div>
                </form>
