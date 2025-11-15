@php use Illuminate\Support\Facades\Auth; @endphp
<div class="white-box  ">
    <form action="{{ route('AdminUpdateCourse') }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl-6">
                <label class="primary_input_label mt-1" for="">
                    {{ __('courses.Type') }} <strong
                        class="text-danger">*</strong></label>
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-25">
                        <label class="primary_checkbox d-flex mr-12"
                               for="type{{ @$course->id }}1">
                            <input type="radio" class="common-radio type1"
                                   id="type{{ @$course->id }}1" name="type"
                                   value="1"
                                {{ @$course->type == 1 ? 'checked' : '' }}>

                            <span class="checkmark me-2"></span>
                            {{ __('courses.Course') }}
                        </label>
                    </div>

                    <div class="col-md-4 col-sm-6 mb-25">
                        <label class="primary_checkbox d-flex mr-12"
                               for="type{{ @$course->id }}2">
                            <input type="radio" class="common-radio type2"
                                   id="type{{ @$course->id }}2" name="type"
                                   value="2"
                                {{ @$course->type == 2 ? 'checked' : '' }}>

                            <span
                                class="checkmark me-2"></span>{{ __('quiz.Quiz') }}
                        </label>
                    </div>
                </div>

            </div>


            <div
                class="col-xl-6 dripCheck"
                @if ($course->type != 1) style="display: none" @endif>
                <div class="primary_input mb-25">
                    <label class="primary_input_label mt-1" for="">
                        {{ __('common.Drip Content') }}</label>
                    <div class="row">
                        <div class="col-md-4 col-sm-6 mb-25">
                            <label class="primary_checkbox d-flex mr-12"
                                   for="drip{{ @$course->id }}0">
                                <input type="radio" class="common-radio drip0"
                                       id="drip{{ @$course->id }}0" name="drip"
                                       value="0"
                                    {{ @$course->drip == 0 ? 'checked' : '' }}>

                                <span class="checkmark me-2"></span>
                                {{ __('common.No') }}
                            </label>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-25">
                            <label class="primary_checkbox d-flex mr-12"
                                   for="drip{{ @$course->id }}1">
                                <input type="radio" class="   drip1"
                                       id="drip{{ @$course->id }}1" name="drip"
                                       value="1"
                                    {{ @$course->drip == 1 ? 'checked' : '' }}>
                                <span class="checkmark me-2"></span>
                                {{ __('common.Yes') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            @if (Auth::user()->role_id != 2)
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label"
                               for="assign_instructor">{{ __('courses.Assign Instructor') }}
                        </label>
                        <select class="primary_select category_id"
                                name="assign_instructor" id="assign_instructor"
                            {{ $errors->has('assign_instructor') ? 'autofocus' : '' }}>
                            <option
                                data-display="{{ __('common.Select') }} {{ __('courses.Instructor') }}"
                                value="">{{ __('common.Select') }}
                                {{ __('courses.Instructor') }} </option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}"
                                    {{ $instructor->id == $course->user_id ? 'selected' : '' }}>
                                    {{ @$instructor->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <label class="primary_input_label"
                           for="assistant_instructors">{{ __('courses.Assistant Instructor') }}
                    </label>
                    <select name="assistant_instructors[]"
                            id="assistant_instructors"
                            class="multypol_check_select active mb-15 e1"
                            multiple>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->id }}"
                                {{ !empty($course->assistantInstructorsIds) && in_array($instructor->id, $course->assistantInstructorsIds) ? 'selected' : '' }}>
                                {{ @$instructor->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>


        </div>
        <input type="hidden" name="id" class="course_id"
               value="{{ @$course->id }}">
        <div class="col-xl-12 p-0">
            <div class="row pt-0">
                @if (isModuleActive('FrontendMultiLang'))
                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                        role="tablist">
                        @foreach ($LanguageList as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                   href="#element_course{{ $language->code }}"
                                   role="tab"
                                   data-bs-toggle="tab">{{ $language->native }} </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="tab-content">
                @foreach ($LanguageList as $key => $language)
                    <div role="tabpanel"
                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                         id="element_course{{ $language->code }}">
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label mt-1"
                                           for="">{{ __('courses.Course Title') }}
                                    </label>
                                    <input class="primary_input_field"
                                           name="title[{{ $language->code }}]"
                                           value="{{ $course->getTranslation('title', $language->code) }}"
                                           placeholder="-" type="text">
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="primary_input mb-35">
                                    <label class="primary_input_label"
                                           for="about">{{__('courses.Course')}} {{__('courses.Requirements')}}  </label>
                                    <textarea
                                        class="lms_summernote"
                                        name="requirements[{{$language->code}}]"

                                        id="about" cols="30"
                                        rows="10">{!!@$course->getTranslation('requirements',$language->code)!!}</textarea>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="primary_input mb-35">
                                    <label class="primary_input_label mt-1"
                                           for="">{{__('courses.Course')}} {{__('courses.Description')}}  </label>
                                    <textarea
                                        class="lms_summernote"
                                        name="about[{{$language->code}}]"
                                        name="" id=""
                                        cols="30"
                                        rows="10">{!!@$course->getTranslation('about',$language->code)!!}</textarea>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="primary_input mb-35">
                                    <label class="primary_input_label"
                                           for="about">{{__('courses.Course')}} {{__('courses.Outcomes')}}  </label>
                                    <textarea
                                        class="lms_summernote"
                                        name="outcomes[{{$language->code}}]"

                                        id="about" cols="30"
                                        rows="10">{!!@$course->getTranslation('outcomes',$language->code)!!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">

                @php
                    if (courseSetting()->show_mode_of_delivery == 1 || isModuleActive('Org')) {
                        $col_size = 4;
                    } elseif (currentTheme()=='tvt'){
                        $col_size = 3;
                    }else {
                        $col_size = 6;
                    }
                @endphp

                @if(currentTheme()=='tvt')
                    <div class="col-xl-{{$col_size}}  mb_30">
                        <select class="primary_select school_subject_id"
                                name="school_subject_id"
                                id="school_subject_id" {{$errors->has('school_subject_id') ? 'autofocus' : ''}}>
                            <option
                                data-display="{{__('common.Select')}} {{__('courses.School Subject')}} *"
                                value="">{{__('common.Select')}} {{__('courses.School Subject')}} </option>
                            @if(isset($subjects))
                                @foreach($subjects as $subject)
                                    <option
                                        {{$course->school_subject_id==$subject->id?'selected':''}}
                                        value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                @endif

                <div class="col-xl-{{ $col_size }} courseBox mb-25">
                    <select class="primary_select edit_category_id"
                            data-course_id="{{ @$course->id }}" name="category"
                            id="course">
                        <option
                            data-display="{{__('common.Select')}} {{__('quiz.Category')}}"
                            value="">{{__('common.Select')}} {{__('quiz.Category')}} </option>
                        @php
                            request()->replace(['category'=>$course->category_id]);
                        @endphp
                        @foreach($categories as $category)
                            @if($category->parent_id==0)
                                @include('backend.categories._single_select_option',['category'=>$category,'level'=>1])
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-{{ $col_size }} courseBox mb-25"
                     id="edit_subCategoryDiv{{ @$course->id }}">
                    <select class="primary_select " name="sub_category"
                            id="edit_subcategory_id{{ @$course->id }}">
                        <option
                            data-display="{{ __('common.Select') }} {{ __('courses.Sub Category') }}"
                            value="">{{ __('common.Select') }}
                            {{ __('courses.Sub Category') }}
                        </option>
                        @if(!empty($course->subcategory_id) || $course->subcategory_id!=0)
                            <option value="{{ @$course->subcategory_id }}"
                                    selected>
                                {{ @$course->subCategory->name }}</option>
                            @if (isset($course->category->subcategories))
                                @foreach ($course->category->subcategories as $sub)
                                    @if ($course->subcategory_id != $sub->id)
                                        <option value="{{ @$sub->id }}">
                                            {{ @$sub->name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    </select>
                </div>
                @if (courseSetting()->show_mode_of_delivery == 1 || isModuleActive('Org'))
                    <div class="col-xl-{{ $col_size }}   mb-25">
                        <select class="primary_select mode_of_delivery"
                                name="mode_of_delivery">
                            <option
                                data-display="{{ __('common.Select') }} {{ __('courses.Mode of Delivery') }}*"
                                value="">{{ __('common.Select') }}
                                {{ __('courses.Mode of Delivery') }}
                                *
                            </option>
                            <option value="1"
                                {{ $course->mode_of_delivery == 1 ? 'selected' : '' }}>
                                {{ __('courses.Online') }}</option>

                            @if (!isModuleActive('Org'))
                                <option value="2"
                                    {{ $course->mode_of_delivery == 2 ? 'selected' : '' }}>
                                    {{ __('courses.Distance Learning') }}</option>
                                <option value="3"
                                    {{ $course->mode_of_delivery == 3 ? 'selected' : '' }}>
                                    {{ __('courses.Face-to-Face') }}</option>
                            @else
                                <option value="3"
                                    {{ $course->mode_of_delivery == 3 ? 'selected' : '' }}>
                                    {{ __('courses.Offline') }}</option>
                            @endif

                        </select>
                    </div>
                @endif

                <div class="col-xl-4  quizBox mb-25" style=" display: none">
                    <select class="primary_select" name="quiz" id="quiz_id">
                        <option
                            data-display="{{ __('common.Select') }} {{ __('quiz.Quiz') }}"
                            value="">{{ __('common.Select') }}
                            {{ __('quiz.Quiz') }} </option>
                        @foreach ($quizzes as $quiz)
                            <option value="{{ $quiz->id }}"
                                    @if ($quiz->id == $course->quiz_id) selected @endif>
                                {{ @$quiz->title }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-xl-4  responsiveResize2  makeResize ">
                    <select class="primary_select" name="level">
                        <option
                            data-display="{{ __('common.Select') }} {{ __('courses.Level') }}"
                            value="">{{ __('common.Select') }}
                            {{ __('courses.Level') }}</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}"
                                    @if (@$course->level == $level->id) selected @endif>
                                {{ $level->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-4 makeResize responsiveResize" id="">
                    <select class="primary_select" name="language"
                            id="">
                        <option
                            data-display="{{ __('common.Select') }} {{ __('courses.Language') }}"
                            value="">{{ __('common.Select') }}
                            {{ __('courses.Language') }}</option>
                        @foreach ($languages as $language)
                            <option value="{{ $language->id }}"
                                    @if ($language->id == $course->lang_id) selected @endif>
                                {{ $language->native }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-4 makeResize  responsiveResize mb-25">
                    <div class="primary_input ">
                        <input class="primary_input_field" name="duration"
                               placeholder="{{ __('common.Duration') }}   ({{ __('common.In Minute') }})"
                               min="0" step="any"
                               type="number" value="{{ @$course->duration }}">
                    </div>
                </div>
                @if(isModuleActive('Org'))
                    <div class="col-xl-4 makeResize responsiveResize" id="">
                        <div class="primary_input mb-25">

                            <input class="primary_input_field"
                                   name="org_leaderboard_point"
                                   placeholder="{{__('org.Leaderboard point')}}"
                                   id=""
                                   min="0" step="any" type="number"
                                   value="{{old('org_leaderboard_point',@$course->org_leaderboard_point)}}" {{$errors->has('org_leaderboard_point') ? 'autofocus' : ''}}>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-xl-6 courseBox mb-25">
                <div class="primary_input  ">

                    <div class="row  ">
                        <div class="col-md-12">
                            <label class="primary_input_label mt-1"
                                   for="">
                                {{ __('common.Complete course sequence') }}</label>
                        </div>
                        <div class="col-md-3 mb-25">
                            <label class="primary_checkbox d-flex mr-12"
                                   for="complete_order0">
                                <input type="radio"
                                       class="common-radio complete_order0"
                                       id="complete_order0"
                                       name="complete_order"
                                       value="0"
                                    {{ @$course->complete_order == 0 ? 'checked' : '' }}>
                                <span class="checkmark me-2"></span>
                                {{ __('common.No') }}
                            </label>
                        </div>
                        <div class="col-md-3 mb-25">

                            <label class="primary_checkbox d-flex mr-12"
                                   for="complete_order1">
                                <input type="radio"
                                       class="common-radio complete_order1"
                                       id="complete_order1"
                                       name="complete_order"
                                       value="1"
                                    {{ @$course->complete_order == 1 ? 'checked' : '' }}>


                                <span class="checkmark me-2"></span>
                                {{ __('common.Yes') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-none">
                <div class="col-lg-6">
                    <div class="checkbox_wrap d-flex align-items-center">
                        <label for="course_1" class="switch_toggle me-2">
                            <input type="checkbox" name="isFree" value="1"
                                   id="edit_course_1">
                            <i class="slider round"></i>
                        </label>
                        <label
                            class="mb-0">{{ __('courses.This course is a top course') }}</label>
                    </div>
                </div>
            </div>
            @if (showEcommerce())
                <div class="row mt-20">
                    <div class="col-lg-4">
                        <div
                            class="checkbox_wrap d-flex align-items-center mt-40">
                            <label for="edit_course_2{{ $course->id }}"
                                   class="switch_toggle  me-2">
                                <input type="checkbox" class="edit_course_2"
                                       id="edit_course_2{{ $course->id }}"
                                       name="is_free"
                                       @if ($course->price == 0) checked @endif
                                       value="1">
                                {{-- <input type="checkbox" class="edit_course_2" id="edit_course_2" name="is_free" @if ($course->price == 0) checked @endif value="1"> --}}
                                <i class="slider round"></i>
                            </label>
                            <label
                                class="mb-0">{{ __('courses.This course is a free course') }}</label>
                        </div>
                    </div>
                    <div class="col-xl-4" id="edit_price_div">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label mt-1"
                                   for="">{{ __('courses.Price') }}</label>
                            <input class="primary_input_field" name="price"
                                   min="0" step="any"
                                   placeholder="-" value="{{ @$course->price }}"
                                   type="number">
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="">{{ __('courses.Price Text') }}</label>
                            <input class="primary_input_field" name="price_text"   placeholder="-"
                                   id=" "
                                   type="text" value="{{$course->price_text}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-20 editDiscountDiv">
                    <div class="col-lg-6">
                        <div
                            class="checkbox_wrap d-flex align-items-center mt-40">
                            <label for="edit_course_3"
                                   class="switch_toggle  me-2">
                                <input type="checkbox" class="edit_course_3"
                                       name="is_discount"
                                       @if ($course->discount_price > 0) checked
                                       @endif
                                       id="edit_course_3" value="1">
                                <i class="slider round"></i>
                            </label>
                            <label
                                class="mb-0">{{ __('courses.This course has discounted price') }}</label>
                        </div>
                    </div>
                    @php
                        if ($course->discount_price > 0) {
                            $d_price = 'block';
                        } else {
                            $d_price = 'none';
                        }
                    @endphp
                    <div class="col-xl-6" id="edit_discount_price_div"
                         style="display: {{ $d_price }}">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label mt-1"
                                   for="">{{ __('courses.Discount') }}
                                {{ __('courses.Price') }}</label>
                            <input class="primary_input_field editDiscount"
                                   name="discount_price"
                                   min="0"  step="any"
                                   value="{{ @$course->discount_price }}"
                                   placeholder="-" type="number">
                        </div>
                    </div>
                </div>

                {{-- Price Plan --}}

                <div class="row mt-20">
                    <div class="col-lg-6 mb-25">
                        <div
                            class="checkbox_wrap d-flex align-items-center mt-40">
                            <label for="iap" class="switch_toggle me-2">
                                <input type="checkbox" id="iap" value="1"
                                       name="iap" {{!empty($course->iap_product_id)?'checked':""}}>
                                <i class="slider round"></i>
                            </label>
                            <label
                                class="mb-0">{{ __('courses.This course is a In App purchase course') }}</label>
                        </div>
                    </div>
                    <div
                        class="col-xl-6  {{!empty($course->iap_product_id)?'':"d-none"}}"
                        id="iap_div">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="">{{ __('courses.In App purchase product ID') }}</label>
                            <input class="primary_input_field"
                                   name="iap_product_id" placeholder="-"
                                   id=""
                                   type="text"
                                   value="{{old('iap_product_id',$course->iap_product_id)}}">
                        </div>
                    </div>
                </div>
            @endif
            @if(isModuleActive("SupportTicket"))
                <div class="row mt-20 mb-10">
                    <div class="col-lg-6">
                        <div
                            class="checkbox_wrap d-flex align-items-center mt-40">
                            <label for="support" class="switch_toggle me-1">
                                <input type="checkbox" name="support"
                                       {{ isset($course) && $course->support == 1 ? 'checked' : '' }}
                                       class="support" id="support" value="1">
                                <i class="slider round"></i>
                            </label>
                            <label
                                class="mb-0">{{ __('common.Support') }}</label>
                        </div>
                    </div>
                </div>
            @endif

            <div class="videoOption">
                <div class="row mt-20 mb-10 ">
                    <div class="col-lg-6">
                        <div
                            class="checkbox_wrap d-flex align-items-center mt-40">
                            <label for="show_overview_media"
                                   class="switch_toggle me-2">
                                <input type="checkbox" id="show_overview_media"
                                       value="1"
                                       {{$course->show_overview_media==1 ? "checked" : ""}} name="show_overview_media">
                                <i class="slider round"></i>
                            </label>
                            <label
                                class="mb-0">{{ __('courses.Show Overview Video') }}</label>
                        </div>
                    </div>
                </div>
                @push('js')
                    <script>
                        let show_overview_media = $('#show_overview_media');
                        let overview_host_section = $('#overview_host_section');
                        show_overview_media.change(function () {
                            if (show_overview_media.is(':checked')) {
                                overview_host_section.show();
                            } else {
                                overview_host_section.hide();
                            }
                        });
                    </script>

                @endpush
                <div class="row mt-20 " id="overview_host_section"
                     style="display: {{$course->type==2 || $course->show_overview_media==0 ?"none":""}}">

                    <div class="col-xl-6  mb-25">

                        <select class="primary_select category_id" data-key="12"
                                name="host" id="category_id12">
                            <option value=""
                                    data-display="{{__('common.Select')}} {{__('courses.Host')}}">{{__('common.Select')}} {{__('courses.Host')}}</option>


                            @php
                                $hostOptions = [
                                    'ImagePreview' => 'courses.Image Preview',
                                    'Youtube' => 'Youtube',
                                    'Vimeo' => 'courses.Vimeo',
                                    'VdoCipher' => 'VdoCipher',
                                    'Self' => 'courses.Self',
                                    'Custom' => 'courses.Custom URL'
                                ];

                                $selectedHost = @$course->host ?? '';
                            @endphp

                            @foreach($hostOptions as $value => $label)
                                <option value="{{ $value }}"
                                        {{ $selectedHost == $value ? 'selected' : '' }}
                                >
                                    {{ __($label) }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    @push('js')
                        <script>
                            $(document).on('change', '.category_id', function () {
                                var key = $(this).data('key');
                                let category_id = $('#category_id' + key).find(":selected").val();

                                if (category_id === 'Youtube' || category_id === 'URL' || category_id === 'm3u8' || category_id === 'Custom') {
                                    $("#iframeBox" + key).hide();
                                    $("#videoUrl" + key).show();
                                    $("#vimeoUrl" + key).hide();
                                    $("#VdoCipherUrl" + key).hide();
                                    $("#vimeoVideo" + key).val('');
                                    $("#youtubeVideo" + key).val('');
                                    $("#fileupload" + key).hide();
                                    $("#bunnyStreamUrl" + key).hide();
                                    $("#media_upload" + key).hide();

                                } else if ((category_id === 'Self') || (category_id === 'Zip') || (category_id === 'GoogleDrive') || (category_id === 'PowerPoint') || (category_id === 'Excel') || (category_id === 'Text') || (category_id === 'Word') || (category_id === 'PDF') || (category_id === 'Image') || (category_id === 'AmazonS3') || (category_id === 'SCORM') || (category_id === 'SCORM-AwsS3') || (category_id === 'XAPI') || (category_id === 'XAPI-AwsS3') || (category_id === 'H5P')) {

                                    $("#iframeBox" + key).hide();
                                    $("#fileupload" + key).show();
                                    $("#videoUrl" + key).hide();
                                    $("#vimeoUrl" + key).hide();
                                    $("#vimeoVideo" + key).val('');
                                    $("#youtubeVideo" + key).val('');
                                    $("#VdoCipherUrl" + key).hide();
                                    $("#bunnyStreamUrl" + key).hide();
                                    $("#media_upload" + key).hide();

                                } else if (category_id === 'Vimeo') {
                                    $("#iframeBox" + key).hide();
                                    $("#videoUrl" + key).hide();
                                    $("#vimeoUrl" + key).show();
                                    $("#vimeoVideo" + key).val('');
                                    $("#youtubeVideo" + key).val('');
                                    $("#fileupload" + key).hide();
                                    $("#VdoCipherUrl" + key).hide();
                                    $("#bunnyStreamUrl" + key).hide();
                                    $("#media_upload" + key).hide();

                                } else if (category_id === 'VdoCipher') {
                                    $("#iframeBox" + key).hide();
                                    $("#videoUrl" + key).hide();
                                    $("#vimeoUrl" + key).hide();
                                    $("#VdoCipherUrl" + key).show();
                                    $("#vimeoVideo" + key).val('');
                                    $("#youtubeVideo" + key).val('');
                                    $("#fileupload" + key).hide();
                                    $("#bunnyStreamUrl" + key).hide();
                                    $("#media_upload" + key).hide();

                                } else if (category_id === 'Iframe') {
                                    $("#iframeBox" + key).show();
                                    $("#videoUrl" + key).hide();
                                    $("#vimeoUrl" + key).hide();
                                    $("#vimeoVideo" + key).val('');
                                    $("#youtubeVideo" + key).val('');
                                    $("#fileupload" + key).hide();
                                    $("#VdoCipherUrl" + key).hide();
                                    $("#bunnyStreamUrl" + key).hide();
                                    $("#media_upload" + key).hide();
                                } else if (category_id === 'BunnyStorage') {
                                    $("#iframeBox" + key).hide();
                                    $("#videoUrl" + key).hide();
                                    $("#vimeoUrl" + key).hide();
                                    $("#bunnyStreamUrl" + key).show();
                                    $("#vimeoVideo" + key).val('');
                                    $("#youtubeVideo" + key).val('');
                                    $("#fileupload" + key).hide();
                                    $("#VdoCipherUrl" + key).hide();
                                    $("#media_upload" + key).hide();
                                } else if (category_id === 'Storage') {
                                    $("#iframeBox" + key).hide();
                                    $("#videoUrl" + key).hide();
                                    $("#vimeoUrl" + key).hide();
                                    $("#bunnyStreamUrl" + key).hide();
                                    $("#vimeoVideo" + key).val('');
                                    $("#youtubeVideo" + key).val('');
                                    $("#fileupload" + key).hide();
                                    $("#VdoCipherUrl" + key).hide();
                                    $("#media_upload" + key).show();
                                    // Amaz.uploader.initForInput();

                                } else {
                                    $("#iframeBox" + key).hide();
                                    $("#videoUrl" + key).hide();
                                    $("#vimeoUrl" + key).hide();
                                    $("#vimeoVideo" + key).val('');
                                    $("#youtubeVideo" + key).val('');
                                    $("#fileupload" + key).hide();
                                    $("#VdoCipherUrl" + key).hide();
                                    $("#bunnyStreamUrl" + key).hide();
                                    $("#media_upload" + key).hide();

                                }

                            });
                        </script>
                    @endpush
                    <div class="col-xl-6">


                        <div class="input-effect  " id="videoUrl12"
                             style="display:@if((isset($course) && ($course->host!="Youtube" && $course->host!="Custom")) || !isset($course)) none  @endif">

                            <input class="primary_input_field"
                                   name="trailer_link"
                                   id="youtubeVideo1"
                                   placeholder="{{__('courses.Video URL')}} *"
                                   value="@if(isset($course) && $course->host=="Youtube" || $course->host=='Custom'){{$course->trailer_link}}@endif"
                                   type="text">

                            <span class="focus-border"></span>
                            @if ($errors->has('video_url'))
                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $errors->first('video_url') }}</strong>
                                                                    </span>
                            @endif
                        </div>

                        <div class="input-effect " id="vimeoUrl12"
                             style="display: @if((isset($course) && ($course->host!="Vimeo")) || !isset($course)) none  @endif">
                            <div class="" id="">

                                @if(config('vimeo.connections.main.upload_type')=="Direct")
                                    <div class="primary_file_uploader">
                                        <input
                                            class="primary-input filePlaceholder"
                                            type="text"
                                            id=""
                                            {{$errors->has('image') ? 'autofocus' : ''}}
                                            placeholder="{{__('courses.Browse Video file')}}"
                                            readonly="">
                                        <button class="" type="button">
                                            <label
                                                class="primary-btn small fix-gr-bg"
                                                for="document_file_thumb_vimeo_add">{{__('common.Browse') }}</label>
                                            <input type="file"
                                                   class="d-none fileUpload"
                                                   name="vimeo"
                                                   id="document_file_thumb_vimeo_add">
                                        </button>
                                    </div>
                                @else
                                    <select
                                        class="select2  vimeoList vimeoListForCourse"
                                        name="vimeo"
                                        id="vimeoVideo1">
                                        <option
                                            data-display="{{__('common.Select')}} {{__('courses.Video')}}"
                                            value="">{{__('common.Select')}} {{__('courses.Video')}}
                                        </option>

                                        <option
                                            value="{{$course->trailer_link}}"
                                            selected></option>

                                    </select>
                                @endif
                                @if ($errors->has('vimeo'))
                                    <span
                                        class="invalid-feedback invalid-select"
                                        role="alert">
                                            <strong>{{ $errors->first('vimeo') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="input-effect" id="VdoCipherUrl12"
                             style="display: @if((isset($editLesson) && ($editLesson->host!="VdoCipher")) || !isset($editLesson)) none  @endif">
                            <div class="" id="">

                                <select
                                    class="select2  vdocipherList vdocipherListForCourse"
                                    name="vdocipher"
                                    id=" ">
                                    <option
                                        data-display="{{__('common.Select')}} {{__('courses.Video')}}"
                                        value="">{{__('common.Select')}} {{__('courses.Video')}}
                                    </option>
                                    <option value="{{$course->trailer_link}}"
                                            selected></option>
                                </select>
                                @if ($errors->has('vdocipher'))
                                    <span
                                        class="invalid-feedback invalid-select"
                                        role="alert">
                                                                        <strong>{{ $errors->first('vdocipher') }}</strong>
                                                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="input-effect " id="fileupload12"
                             style="display: @if((isset($course) && (($course->host=="Vimeo") ||  ($course->host=="Youtube")) ) || !isset($course)) none  @endif">


                            <x-upload-file
                                name="file"
                                type="video"
                                media_id="{{isset($course)?$course->trailer_link_media?->media_id:''}}"
                                :has_label="false"
                            />

                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-6 mt-20">
                    <label class="primary_input_label mt-1">{{__('courses.View Scope')}} </label>
                    <select class="primary_select " name="scope"
                            id="">
                        <option
                            value="1" {{@$course->scope=="1"?'selected':''}}>{{__('courses.Public')}}
                        </option>

                        <option
                            {{@$course->scope=="0"?'selected':''}} value="0">
                            {{__('courses.Private')}}
                        </option>

                    </select>
                </div>

                <div class="col-xl-4 mt-25">
                    <label
                        class="primary_input_label mt-1">{{_trans('courses.Access Limit')}} {{_trans('courses.In Days')}}
                        (<small>{{_trans('courses.0 means Unlimited')}}</small>
                        )</label>
                    <input class="primary_input_field " name="access_limit"
                           placeholder="{{_trans('courses.Access Limit')}}"
                           id="access_limit"
                           type="number"
                           value="{{old('access_limit',$course->access_limit)}}">
                </div>
            </div>
            @if(isModuleActive('UpcomingCourse'))
                <div class="row mt-20">
                    <div class="col-lg-3 mb-25">
                        <div
                            class="checkbox_wrap d-flex align-items-center mt-40">
                            <label for="is_upcoming_course"
                                   class="switch_toggle me-2">
                                <input
                                    {{ @$course->is_upcoming_course ?'checked':'' }} type="checkbox"
                                    id="is_upcoming_course" value="1"
                                    name="is_upcoming_course">
                                <i class="slider round"></i>
                            </label>
                            <label
                                class="mb-0">{{ __('courses.Is upcoming course?') }}</label>
                        </div>
                    </div>

                    <div class="col-xl-3 upcoming_course_div publish_date_div">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for="">{{__('courses.Publish Date')}}
                            </label>
                            <div class="primary_datepicker_input">
                                <div class="g-0  input-right-icon">
                                    <div class="col">
                                        <div class="">
                                            <input
                                                placeholder="{{__('courses.Publish Date')}}"
                                                class="primary_input_field primary-input date form-control"
                                                id="publish_date" type="text"
                                                name="publish_date"
                                                value="{{ @$course->publish_date?date('m/d/Y',strtotime(@$course->publish_date)):"" }}"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <button class="" type="button">
                                        <i class="ti-calendar"
                                           id="start-date-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 mb-25 upcoming_course_div">
                        <div
                            class="checkbox_wrap d-flex align-items-center mt-40">
                            <label for="is_allow_prebooking"
                                   class="switch_toggle me-2">
                                <input
                                    {{ @$course->is_allow_prebooking ?'checked':'' }} type="checkbox"
                                    id="is_allow_prebooking" value="1"
                                    name="is_allow_prebooking">
                                <i class="slider round"></i>
                            </label>
                            <label
                                class="mb-0">{{ __('courses.Is Allow Prebooking?') }}</label>
                        </div>
                    </div>

                    <div
                        class="col-lg-3 mb-25 upcoming_course_div booking_amount_div">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="booking_amount">{{ __('courses.Booking Amount') }}
                                *</label>
                            <input
                                class="primary_input_field booking_amount_field"
                                name="booking_amount"
                                placeholder="{{ __('courses.Booking Amount') }}"
                                id="booking_amount"
                                type="number"
                                value="{{@$course->booking_amount}}">
                        </div>
                    </div>

                </div>
            @endif

            <div class="row mt-20">
                <div class="col-xl-6">
                    <div class=" mb-35">
                        <x-upload-file
                            name="image"
                            type="image"
                            media_id="{{isset($course)?$course->image_media?->media_id:''}}"
                            label="{{ __('courses.Course Thumbnail') }}"
                            note="{{__('student.Recommended size')}} (1170x600)"
                        />
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label mt-1"
                               for="">{{__('courses.Meta keywords')}}</label>
                        <input class="primary_input_field" name="meta_keywords"
                               value="{{@$course->meta_keywords}}"
                               placeholder="-" type="text">
                    </div>
                </div>

            </div>

            @if(Settings('frontend_active_theme')=="edume")
                <div class="row">
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="">{{__('courses.Key Point') }}
                                (1)</label>
                            <input class="primary_input_field"
                                   name="what_learn1" placeholder="-"
                                   type="text"
                                   value="{{old('what_learn1',@$course->what_learn1)}}">
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="">{{__('courses.Key Point') }}
                                (2) </label>
                            <input class="primary_input_field"
                                   name="what_learn2" placeholder="-"
                                   type="text"
                                   value="{{old('what_learn2',@$course->what_learn2)}}">
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">

                <div class="col-xl-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label mt-1"
                               for="">{{__('courses.Meta description')}}</label>
                        <textarea id="my-textarea" class="primary_input_field"
                                  name="meta_description" style="height: 200px"
                                  rows="3">{!!@$course->meta_description!!}</textarea>
                    </div>

                </div>

            </div>

            <div class="row" id="">
                <div class="col-lg-2 mb-25">
                    <div class="checkbox_wrap d-flex align-items-center mt-20">
                        <label for="has_badge" class="switch_toggle me-2">
                            <input type="checkbox" id="has_badge" value="1" name="has_badge" {{@$course->has_badge==1?'checked':''}}>
                            <i class="slider round"></i>
                        </label>
                        <label
                            class="mb-0">{{ __('courses.Has Badge') }}</label>
                    </div>
                </div>
                <div class="col-xl-4 mb-25" id="has_badge_div" style="display: {{@$course->has_badge==1?'show':'none'}}">
                    <x-upload-file
                        name="course_badge"
                        type="image"
                        media_id="{{isset($course)?$course->course_badge_media?->media_id:''}}"
                        label="{{ __('courses.Badge') }}"
                    />
                </div>
            </div>

            <div class="col-lg-12 text-center pt_15">
                <div class="d-flex justify-content-center">
                    <button class="primary-btn semi_large2  fix-gr-bg"
                            id="save_button_parent" type="submit"><i
                            class="ti-check"></i> {{__('common.Update')}} {{__('courses.Course')}}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')

<script>
    $(document).ready(function () {
        $('#has_badge').change(function () {
            if (this.checked)
                $('#has_badge_div').fadeIn('slow');
            else
                $('#has_badge_div').fadeOut('slow');
        });
    });
</script>
@endpush
