{{-- @php
    $user = Auth::user();
    if ($user->role_id == 1) {
        $groups = Modules\Quiz\Entities\QuestionGroup::where('active_status', 1)->latest()->get();
    } else {
        $groups = Modules\Quiz\Entities\QuestionGroup::where('active_status', 1)->where('user_id', $user->id)->latest()->get();
    }
@endphp --}}
@if(isset($bank))
    <form class="form-horizontal" method="POST" action="{{ route('question-bank-update', $bank->id) }}" enctype="multipart/form-data" id="question_bank">
        @csrf
        @method('PUT')
        @else
            @if (permissionCheck('question-bank.store'))
                <form class="form-horizontal" method="POST" action="{{ route('question-bank.course') }}" enctype="multipart/form-data" id="question_bank">
                    @csrf
                    @endif
                    @endif

<input type="hidden" id="url" value="{{url('/')}}">
<input type="hidden" name="course_id" value="{{@$course->id}}">
<input type="hidden" name="category" value="{{@$course->category_id}}">
<input type="hidden" name="question_type" value="M">
<input type="hidden" id="quiz_id_inside{{$chapter->id}}" name="quize_id" value="">
@if (isset($course->subcategory_id))
    <input type="hidden" name="sub_category" value="{{@$course->subcategory_id}}">
@endif
<div class="section-white-box questionBoxDiv">
    <div class="add-visitor">
        <input type="hidden" name="chapterId" value="{{@$chapter->id}}">
        <div class="row">
            <div class="col-lg-12">

                <div class="row mt-25">
                    <div class="col-lg-12">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{__('quiz.Group')}} *</label>
                            <select class="primary_select" name="group">
                                <option
                                    data-display="{{__('common.Select')}} {{__('quiz.Group')}} "
                                    value="">{{__('common.Select')}} {{__('quiz.Group')}} </option>

                                @foreach($questionGroups as $group)
                                    <option value="{{$group->id}}"
                                              >{{$group->title}}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-25">
                    <div class="col-lg-12">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{__('quiz.Question')}} *</label>
                            <textarea {{ $errors->has('question') ? ' autofocus' : '' }}
                                      class="  form-control name{{ $errors->has('question') ? ' is-invalid' : '' }}"
                                      rows="4"
                                      name="question">{{isset($bank)? strip_tags($bank->question):(old('question')!=''?(old('question')):'')}}</textarea>
                            <span class="focus-border textarea"></span>
                            @if ($errors->has('question'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('question') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-25">
                    <div class="col-lg-12">
                        <div class="input-effect">
                            <label class="primary_input_label mt-1"> {{__('quiz.Marks')}} *</label>
                            <input {{ $errors->has('marks') ? ' autofocus' : '' }}
                                   class="primary_input_field name{{ $errors->has('marks') ? ' is-invalid' : '' }}"
                                   type="number" name="marks"
                                   value="{{isset($bank)? $bank->marks:(old('marks')!=''?(old('marks')):'')}}">
                            <span class="focus-border"></span>
                            @if ($errors->has('marks'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('marks') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="multiple-choice">
                    <div class="row  mt-25">
                        <div class="col-lg-10">
                            <div class="input-effect">
                                <label class="primary_input_label mt-1"> {{__('quiz.Number Of Options')}}*</label>
                                <input {{ $errors->has('number_of_option') ? ' autofocus' : '' }}
                                       class="primary_input_field name{{ $errors->has('number_of_option') ? ' is-invalid' : '' }}"
                                       type="number" name="number_of_option" autocomplete="off"
                                       id="number_of_option{{$chapter->id}}"
                                       value="{{isset($bank)? $bank->number_of_option: ''}}">
                                <span class="focus-border"></span>
                                @if ($errors->has('number_of_option'))
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('number_of_option') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-2 mt-25">
                            <button type="button" data-chapter_id="{{$chapter->id}}" class="primary-btn small fix-gr-bg"
                                    id="create-option">{{__('quiz.Create')}} </button>
                        </div>
                    </div>
                </div>
                <div class="multiple-options" id="multiple-options{{$chapter->id}}">
                    @php
                        $i=0;
                        $multiple_options = [];

                        if(isset($bank)){
                            if($bank->type == "M"){
                                $multiple_options = $bank->questionMu;
                            }
                        }
                    @endphp
                    @foreach($multiple_options as $multiple_option)

                        @php $i++; @endphp
                        <div class='row  mt-25'>
                            <div class='col-lg-10'>
                                <div class='input-effect'>
                                    <label class="primary_input_label mt-1"> {{__('quiz.Option')}} {{$i}}</label>
                                    <input class='primary_input_field name' type='text'
                                           name='option[]' autocomplete='off' required
                                           value="{{$multiple_option->title}}">
                                    <span class='focus-border'></span>
                                </div>
                            </div>
                            <div class='col-lg-2 mt-40'>
                                <label class="primary_checkbox d-flex mr-12 "
                                       for="option_check_{{$i}}" {{__('quiz.Yes')}}>
                                    <input type="checkbox" @if ($multiple_option->status==1) checked
                                           @endif id="option_check_{{$i}}"
                                           name="option_check_{{$i}}" value="1">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- End New Create --}}


            </div>
        </div>

        <div class="row mt-40">
            <div class="col-lg-12 d-flex gap-10 justify-content-center text-center">
                <button data-chapter_id="{{$chapter->id}}" type="button"
                        class="primary-btn fix-gr-bg close_question_section"
                        data-bs-toggle="tooltip">
                    {{__('common.Close')}}
                </button>
                <button type="submit" class="primary-btn fix-gr-bg questionSubmitBtn"
                        data-bs-toggle="tooltip">
                    <i class="ti-check"></i>
                    {{__('common.Save')}}
                </button>
            </div>
        </div>
    </div>
</div>
                </form>
