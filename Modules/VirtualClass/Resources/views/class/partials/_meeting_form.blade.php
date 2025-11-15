@php use Illuminate\Support\Facades\Auth; @endphp
@php use Carbon\Carbon; @endphp
@php use Modules\GoogleMeet\Entities\GoogleAccount; @endphp
@php use Modules\GoogleCalendar\Entities\GoogleCalendarAccount; @endphp

<div class="col-lg-12">

    @if (isset($class))

        <form method="POST" action="{{ route('virtual-class.update', $class->id) }}" class="form-horizontal"
              enctype="multipart/form-data" id="question_bank">
            @method('PUT')
            @csrf
            @else
                @if (permissionCheck('virtual-class.create'))

                    <form method="POST" action="{{ route('virtual-class.store') }}" class="form-horizontal"
                          enctype="multipart/form-data" id="question_bank">
                        @csrf

                        @endif
                        @endif
                        <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
                        <div class="white-box  student-details header-menu">
                            <div class="main-title">
                                <h3 class="mb-0">
                                    @if(isset($class))
                                        {{__('common.Edit')}}
                                    @else
                                        {{__('common.Add')}}
                                    @endif
                                    {{__('virtual-class.Class')}}
                                </h3>
                            </div>
                            <div class="add-visitor">
                                @php
                                    $LanguageList = getLanguageList();
                                @endphp
                                <div class="row pt-0">
                                    @if (isModuleActive('FrontendMultiLang'))
                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                            role="tablist">
                                            @foreach ($LanguageList as $key => $language)
                                                <li class="nav-item">
                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                       href="#element{{ $language->code }}" role="tab"
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
                                             id="element{{ $language->code }}">
                                            <div class="row mt-20">
                                                <div class="col-lg-12">
                                                    <div class="primary_input  mb-25">
                                                        <label
                                                            class="primary_input_label"> {{ __('virtual-class.Title') }}
                                                            <span
                                                                class="required_mark">*</span></label>
                                                        <input type="text"
                                                               placeholder="{{ __('virtual-class.Title') }}"
                                                               class="primary_input_field name{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                               name="title[{{ $language->code }}]"
                                                               {{ $errors->has('title') ? ' autofocus' : '' }}
                                                               value="{{ isset($class) ? $class->getTranslation('title', $language->code) : old('title.'.$language->code) }}">
                                                        <span class="focus-border textarea"></span>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-20">
                                                <div class="col-lg-12">
                                                    <div class="primary_input">
                                                        <label class="primary_input_label"
                                                               for="">{{ __('jitsi.Description') }}
                                                        </label>
                                                        <textarea class="lms_summernote  form-control" cols="0"
                                                                  rows="4"
                                                                  placeholder="{{ __('jitsi.Description') }}"
                                                                  name="description[{{ $language->code }}]"
                                                                  id="address">{{ isset($class) ? $class->course->getTranslation('about', $language->code) : '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row mt-20">
                                    @if (Auth::user()->role_id == 1)

                                        <div class="col-xl-4 col-md-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="assign_instructor">{{ __('courses.Assign Instructor') }}
                                                </label>
                                                <select class="primary_select category_id" name="assign_instructor"
                                                        id="assign_instructor"
                                                    {{ $errors->has('assign_instructor') ? 'autofocus' : '' }}>
                                                    <option
                                                        data-display="{{ __('common.Select') }} {{ __('courses.Instructor') }}"
                                                        value="">{{ __('common.Select') }}
                                                        {{ __('courses.Instructor') }} </option>
                                                    @foreach ($instructors as $instructor)
                                                        <option value="{{ $instructor->id }}"
                                                            {{ isset($class) ? ($instructor->id == $class->course->user_id ? 'selected' : '') : '' }}>
                                                            {{ @$instructor->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    @endif

                                    <div class="col-xl-4 col-md-6">
                                        <div class="primary_input  mb-25">
                                            <label class="primary_input_label"
                                                   for="assistant_instructors">{{ __('courses.Assistant Instructor') }}
                                            </label>
                                            <select name="assistant_instructors[]" id="assistant_instructors"
                                                    class="multypol_check_select active mb-15 e1" multiple>
                                                @foreach ($instructors as $instructor)
                                                    <option value="{{ $instructor->id }}"
                                                        {{ isset($class) && !empty($class->course->assistantInstructorsIds) && in_array($instructor->id, $class->course->assistantInstructorsIds) ? 'selected' : '' }}>
                                                        {{ @$instructor->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="primary_input  mb-25">

                                            <div class="input-effect">
                                                <label class="primary_input_label"> {{ __('virtual-class.Duration') }}
                                                    {{ __('virtual-class.Per Class') }}
                                                    ({{ __('virtual-class.in Minute') }}) <span
                                                        class="required_mark">*</span></label>
                                                <input {{ $errors->has('duration') ? ' autofocus' : '' }}
                                                       class="primary_input_field name{{ $errors->has('duration') ? ' is-invalid' : '' }}"
                                                       type="number" name="duration" placeholder="e.g.30min"
                                                       step="any"
                                                       value="{{ isset($class) ? $class->duration : (old('duration') != '' ? old('duration') : '') }}">
                                                <span class="focus-border"></span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="primary_input  mb-25">
                                            <label class="primary_input_label"
                                                   for="">{{ __('quiz.Category') }} <span class="required_mark">*</span></label>
                                            <select {{ $errors->has('category') ? ' autofocus' : '' }}
                                                    class="primary_select {{ $errors->has('category') ? ' is-invalid' : '' }}"
                                                    id="category_id" name="category">
                                                <option
                                                    data-display=" {{ __('common.Select') }} {{ __('quiz.Category') }} *"
                                                    value="">
                                                    {{ __('common.Select') }} {{ __('quiz.Category') }}
                                                </option>


                                                @php
                                                    if(isset($class)){
                                                          request()->replace(['category'=>$class->category_id]);
                                                    }

                                                @endphp
                                                @foreach($categories as $category)
                                                    @if($category->parent_id==0)
                                                        @include('backend.categories._single_select_option',['category'=>$category,'level'=>1])
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6" id="subCategoryDiv">
                                        <div class="primary_input  mb-25">
                                            <label class="primary_input_label"
                                                   for="">{{ __('quiz.Sub Category') }}</label>
                                            <select {{ $errors->has('sub_category') ? ' autofocus' : '' }}
                                                    class="primary_select{{ $errors->has('sub_category') ? ' is-invalid' : '' }} select_section"
                                                    id="subcategory_id" name="sub_category">
                                                <option
                                                    data-display=" {{ __('common.Select') }} {{ __('quiz.Sub Category') }}"
                                                    value="">{{ __('common.Select') }}
                                                    {{ __('quiz.Sub Category') }}
                                                </option>

                                                @if (isset($class))
                                                    <option value="{{ @$class->sub_category_id }}" selected>
                                                        {{ @$class->subCategory->name }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-md-6">
                                        <x-upload-file
                                            name="image"
                                            type="image"
                                            media_id="{{isset($class)?$class->course->image_media?->media_id:''}}"
                                            label="{{ __('common.Image') }}"
                                        />
                                    </div>
                                </div>
                                @if (showEcommerce())
                                    <div class="row ">
                                        <div class="align-items-center col-md-6 col-xl-4 d-flex justify-content-start">
                                            <div class="checkbox_wrap d-flex align-items-center">
                                                <label for="edit_course" class="switch_toggle">
                                                    <input type="checkbox" name="free"
                                                           {{ isset($class) && $class->fees == 0 ? 'checked' : '' }}
                                                           class="free_class" id="edit_course" value="1">
                                                    <i class="slider round"></i>
                                                </label>
                                                <label
                                                    class="ps-2">{{ __('virtual-class.This class is free') }}</label>
                                            </div>
                                        </div>


                                        <div class="col-xl-4 col-md-6 fees "
                                             @if (isset($class) && $class->fees == 0) style="display:none;" @endif>
                                            <div class="input-effect">
                                                <label class="primary_input_label mt-1"> {{ __('virtual-class.Fees') }}
                                                    <span
                                                        class="required_mark">*</span></label>
                                                <input
                                                    class="primary_input_field name{{ $errors->has('fees') ? ' is-invalid' : '' }}"
                                                    type="number" name="fees"
                                                    step="any"
                                                    value="{{ isset($class) ? $class->fees : (old('fees') != '' ? old('fees') : 0) }}">
                                                <span class="focus-border"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('courses.Price Text') }}</label>
                                                <input class="primary_input_field" name="price_text" placeholder="-"
                                                       id=" "
                                                       type="text" value="{{isset($class) ? $class->course->price_text:''}}">
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <div class="row mt-25 ">
                                    <div class="col-xl-4 col-md-6">
                                        <div class="primary_input  mb-25">
                                            <label class="primary_input_label">
                                                {{ __('courses.View Scope') }} </label>
                                            <select class="primary_select " name="scope" id="">
                                                <option value="1" {{ @$class->course->scope == '1' ? 'selected' : '' }}>
                                                    {{ __('courses.Public') }}
                                                </option>

                                                <option {{ @$class->course->scope == '0' ? 'selected' : '' }} value="0">
                                                    {{ __('courses.Private') }}
                                                </option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-md-6">
                                        <div class="primary_input  mb-25">
                                            <label class="primary_input_label">
                                                {{ __('courses.Level') }}
                                            </label>
                                            <select class="primary_select" name="level">

                                                @foreach($levels as $level)
                                                    <option
                                                        value="{{$level->id}}" {{old('level',@$class->course->level)==$level->id?"selected":""}} >{{$level->title}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    @if(isModuleActive('Org'))
                                        <div class="col-xl-4 col-md-6">
                                            <div class="primary_input  mb-25">
                                                <label
                                                    class="primary_input_label"> {{__('courses.Required Type')}} </label>
                                                <select class="primary_select " name="required_type"
                                                        id="">
                                                    <option
                                                        value="1" {{@$class->course->required_type=="1"?'selected':''}} {{!isset($class)?'selected':''}} >{{__('courses.Compulsory')}}
                                                    </option>

                                                    <option
                                                        {{@$class->course->required_type=="0"?'selected':''}} value="0">
                                                        {{__('courses.Open')}}
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-xl-4 col-md-6">
                                        <div class="primary_input  mb-25">
                                            <label class="primary_input_label"
                                                   for="">{{ __('virtual-class.Language') }} <span
                                                    class="required_mark">*</span></label>
                                            <select class="primary_select" name="lang_id" id="">
                                                <option
                                                    data-display="{{ __('common.Select') }} {{ __('common.Language') }}"
                                                    value="">{{ __('common.Select') }}
                                                    {{ __('common.Language') }}</option>
                                                @foreach ($languages as $language)
                                                    <option value="{{ $language->id }}"
                                                            @if (!isset($class)) @if ($language->id == 19) selected @endif
                                                        @endif
                                                        {{ isset($class) && $class->lang_id == $language->id ? 'selected' : '' }}
                                                    >{{ $language->native }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">

                                        <div class="primary_input mt-25 mb-25">
                                            <label class="primary_input_label"
                                                   for="">{{ __('virtual-class.Date') }}</label>
                                            <div class="primary_datepicker_input">
                                                <div class="g-0  input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="{{__('common.Date')}}" readonly
                                                                   class="primary_input_field primary-input date form-control  {{ @$errors->has('date') ? ' is-invalid' : '' }}"
                                                                   id="start_date" type="text"
                                                                   name="start_date"
                                                                   value="{{isset($class) ? getJsDateFormat(Carbon::createFromFormat('Y-m-d',$class->start_date)->format('m/d/Y')) : getJsDateFormat(date('m/d/Y'))}}"
                                                                   autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="primary_input  mt-25 mb-25">
                                            <label class="primary_input_label">
                                                {{__('common.Start')}} {{__('virtual-class.Time')}} <span
                                                    class="required_mark">*</span></label>
                                            <div class="primary_input">
                                                <input required
                                                       class="primary-input primary_input_field  time form-control{{ @$errors->has('time') ? ' is-invalid' : '' }}"
                                                       type="text" name="time"
                                                       value="{{ isset($class) ? old('time',$class->time): old('time')}}">

                                            </div>


                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-20">


                                    @php
                                        $is_recurring=isset($class) ? $class->is_recurring : old('is_recurring',0);
                                        $recurring_type=isset($class) ? $class->recurring_type : old('recurring_type',1);
                                        $recurring_repeat_count=isset($class) ? $class->recurring_repeat_count : old('recurring_repeat_count',1);
                                        $recurring_days=isset($class) ? $class->recurring_days : json_encode(old('recurring_days',[]));
                                        $recurring_days =(array)json_decode($recurring_days);
                                    @endphp

                                    <div class="col-xl-4 col-md-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label
                                                    class="primary_input_label mt-1">@lang('virtual-class.Recurring')</label>
                                            </div>
                                            <div class="col-lg-12  d-flex mt-2">
                                                <div class="col-md-4">
                                                    <label for="type_1"
                                                           class="primary_checkbox d-flex mr-12 is_recurring">
                                                        <input type="radio" class="common-checkbox" id="type_1"
                                                               name="is_recurring"
                                                               value="1"
                                                            {{$is_recurring==1 ? 'checked' : ''}}
                                                        >
                                                        <span class="checkmark me-2"></span>{{ __('common.Yes') }}
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="type_2"
                                                           class="primary_checkbox d-flex mr-12 is_recurring">
                                                        <input type="radio" class="common-checkbox" id="type_2"
                                                               name="is_recurring"
                                                               value="0"
                                                            {{$is_recurring==1 ? '' : 'checked'}}
                                                        >
                                                        <span class="checkmark me-2"></span>{{ __('common.No') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="col-xl-8 col-md-6 mt-20 recurrence_section  {{$is_recurring==1 ? '' : 'd-none'}}">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="primary_input_label"
                                                       for="">{{__('virtual-class.Repeat')}} {{__('common.Every')}}
                                                    <span
                                                        class="required_mark">*</span></label>

                                                <input
                                                    class="primary_input_field"
                                                    type="number" name="recurring_repeat_count"
                                                    step="any"
                                                    min="1"
                                                    value="{{$recurring_repeat_count}}">
                                                <span class="focus-border"></span>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="primary_input_label" for="">{{__('virtual-class.Type')}}
                                                    <span
                                                        class="required_mark">*</span></label>
                                                <select
                                                    class="primary_select form-control {{ @$errors->has('recurring_type') ? ' is-invalid' : '' }}"
                                                    id="recurring_type" name="recurring_type">
                                                    <option
                                                        value="1" {{ $recurring_type == 1 ? 'selected' : '' }}>
                                                        @lang('virtual-class.Daily')</option>
                                                    <option
                                                        value="2" {{ $recurring_type == 2 ? 'selected' : '' }}>
                                                        @lang('virtual-class.Weekly')</option>
                                                    <option
                                                        value="3" {{ $recurring_type == 3 ? 'selected' : '' }}>
                                                        @lang('virtual-class.Monthly') </option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="row   day_hide  {{$recurring_type=='2'?'':'d-none'}}" id="day_hide">
                                        <div class="col-lg-4 ">
                                            <label class="primary_input_label" for="">@lang('virtual-class.Occurs on')

                                                <span
                                                    class="text-danger"> *</span></label>
                                            @foreach ($days as $key=>$day)

                                                <label for="day{{$key}}" class="primary_checkbox d-flex mr-12 mb-2 ">
                                                    <input type="checkbox" class="common-checkbox" id="day{{$key}}"
                                                           name="recurring_days[]"
                                                           {{in_array($key,$recurring_days) ? 'checked' : ''}}
                                                           value="{{ $key }}">
                                                    <span
                                                        class="checkmark me-2"></span>{{trans('virtual-class.'.$day) }}
                                                </label>

                                            @endforeach
                                            @if ($errors->has('recurring_days'))
                                                <span class="text-danger" style="display:block">
                                    {{ $errors->first('recurring_days') }}
                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row   recurrence_section {{$is_recurring==1 ? '' : 'd-none'}}">
                                        <div class="col-lg-4">
                                            <div class="primary_input  mb-25">
                                                <label class="primary_input_label"
                                                       for="">@lang('virtual-class.End Recurrence') <span
                                                        class="text-danger"> *</span></label>
                                                <div class="primary_datepicker_input">
                                                    <div class="g-0  input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="End Date"
                                                                       class="primary_input_field primary-input date form-control  {{ @$errors->has('end_date') ? ' is-invalid' : '' }}"
                                                                       id="end_date" type="text"
                                                                       name="end_date"
                                                                       value="{{isset($class)?  getJsDateFormat(Carbon::createFromFormat('Y-m-d',$class->end_date)->format('m/d/Y')) : getJsDateFormat(date('m/d/Y'))}}"
                                                                       autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                            </div>
                                        </div>

                                    </div>
                                    {{--                                    recurring end--}}

                                    <div class="row @if(isset($class)) d-none @endif">
                                        <div class="col-md-12">
                                            <div class="row">


                                                <div class="col-md-12 mt-25 ">
                                                    <label class="primary_input_label"
                                                           for=""> {{__('virtual-class.Host')}} </label>
                                                </div>

                                                <div class="col-md-2 mb-25">
                                                    <label for="type1" class="primary_checkbox d-flex mr-12 ">
                                                        <input type="radio" class="common-checkbox" id="type1"
                                                               name="host"
                                                               value="Zoom"
                                                               @if(isset($class)) @if($class->host=="Zoom") checked
                                                               @endif @else
                                                                   checked @endif>
                                                        <span class="checkmark me-2"></span>{{__('virtual-class.Zoom')}}
                                                    </label>
                                                </div>

                                                @if(isModuleActive("BBB"))
                                                    <div class="col-md-2 mb-25">
                                                        <label for="type2" class="primary_checkbox d-flex mr-12 ">
                                                            <input type="radio" class="common-checkbox" id="type2"
                                                                   name="host"
                                                                   value="BBB"
                                                                   @if(isset($class)) @if($class->host=="BBB") checked @endif @endif
                                                            >
                                                            <span
                                                                class="checkmark me-2"></span> {{__('virtual-class.BBB')}}
                                                        </label>
                                                    </div>
                                                @endif

                                                @if(isModuleActive("Jitsi"))
                                                    <div class="col-md-2 mb-25">
                                                        <label for="type3" class="primary_checkbox d-flex mr-12 ">
                                                            <input type="radio" class="common-checkbox" id="type3"
                                                                   name="host"
                                                                   value="Jitsi"
                                                                   @if(isset($class)) @if($class->host=="Jitsi") checked @endif @endif
                                                            >
                                                            <span class="checkmark me-2"></span> {{__('jitsi.Jitsi')}}
                                                        </label>
                                                    </div>
                                                @endif

                                                <div class="col-md-2 mb-25">
                                                    <label for="Custom" class="primary_checkbox d-flex mr-12 ">
                                                        <input type="radio" class="common-checkbox" id="Custom"
                                                               name="host"
                                                               value="Custom"
                                                               @if(isset($class) && $class->host=="Custom") checked
                                                            @endif>
                                                        <span
                                                            class="checkmark me-2"></span>{{__('virtual-class.Custom')}}
                                                    </label>
                                                </div>

                                                @if(isModuleActive("GoogleMeet") && saasEnv('ALLOW_GOOGLE_MEET_CALENDAR')=='true' && GoogleAccount::where('is_active',1)->get()->count() > 0)
                                                    <div class="col-md-2 mb-25">
                                                        <label for="GoogleMeet"
                                                               class="primary_checkbox d-flex mr-12 text-nowrap">
                                                            <input type="radio" class="common-checkbox" id="GoogleMeet"
                                                                   name="host"
                                                                   value="GoogleMeet"
                                                                   @if(isset($class)) @if($class->host=="GoogleMeet") checked @endif @endif
                                                            >
                                                            <span
                                                                class="checkmark me-2"></span> {{__('virtual-class.Google Meet')}}
                                                        </label>
                                                    </div>
                                                @endif

                                                @if(isModuleActive("InAppLiveClass"))
                                                    <div class="col-md-2 mb-25">
                                                        <label for="type4"
                                                               class="primary_checkbox d-flex mr-12 text-nowrap">
                                                            <input type="radio" class="common-checkbox" id="type4"
                                                                   name="host"
                                                                   value="InAppLiveClass"
                                                                   @if(isset($class)) @if($class->host=="InAppLiveClass") checked @endif @endif
                                                            >
                                                            <span
                                                                class="checkmark me-2"></span> {{__('common.In-App Live Class')}}
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>


                                    <div class=" mt-25 single_class zoomSetting @if(isset($class)) d-none @endif"
                                         style="display: {{ isset($class) ? $class->host=="Zoom"? "block":"none": 'block'}}">

                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="primary_input  mb-25">
                                                    <label class="primary_input_label"
                                                           for="password">{{ __('zoom.Password') }} <span
                                                            class="required_mark">*</span></label>
                                                    <div class="primary_datepicker_input">
                                                        <div class="g-0  input-right-icon">
                                                            <div class="col">
                                                                <div class="">
                                                                    <input placeholder="Password"
                                                                           class="primary_input_field primary-input   form-control"
                                                                           id="password" type="text"
                                                                           name="password"
                                                                           value="123456"
                                                                           autocomplete="new-password">
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class=" mt-25 single_class bbbSetting @if (isset($class)) d-none @endif"
                                         style="display: {{ isset($class) ? ($class->host == 'BBB' ? 'block' : 'none') : 'none' }}">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="primary_input  mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('bbb.Moderator Password') }}
                                                        <span class="text-danger">*</span>

                                                    </label>
                                                    <input
                                                        class="primary_input_field form-control{{ $errors->has('moderator_password') ? ' is-invalid' : '' }}"
                                                        type="text" name="moderator_password" autocomplete="off"
                                                        placeholder="{{ __('bbb.Moderator Password') }}"
                                                        value="{{ isset($editdata) ? old('topic', $editdata->moderator_password) : old('moderator_password', '`1234567890') }}">

                                                    <span class="focus-border"></span>

                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="primary_input  mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('bbb.Attendee Password') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input
                                                        class="primary_input_field form-control{{ $errors->has('attendee_password') ? ' is-invalid' : '' }}"
                                                        type="text" name="attendee_password" autocomplete="off"
                                                        placeholder="{{ __('bbb.Attendee Password') }}"
                                                        value="{{ isset($editdata) ? old('topic', $editdata->attendee_password) : old('attendee_password', '12345678') }}">

                                                    <span class="focus-border"></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=" mt-25 single_class jitsiSetting @if (isset($class)) d-none @endif"
                                         style="display: {{ isset($class) ? ($class->host == 'Jitsi' ? 'block' : 'none') : 'none' }}">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="primary_input  mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('jitsi.Meeting ID/Room') }}
                                                    </label>
                                                    <input
                                                        class="primary_input_field form-control{{ $errors->has('jitsi_meeting_id') ? ' is-invalid' : '' }}"
                                                        type="text" name="jitsi_meeting_id" autocomplete="off"
                                                        placeholder="{{ __('jitsi.Meeting ID/Room') }}"
                                                        value="{{ date('ymdhmi') }}">

                                                    <span class="focus-border"></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="   single_class InAppLiveClassSetting @if (isset($class)) d-none @endif"
                                        style="display: {{ isset($class) ? ($class->host == 'InAppLiveClass' ? 'block' : 'none') : 'none' }}">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="primary_input  mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('chat.chat') }}
                                                    </label>

                                                    <div class="primary_datepicker_input">
                                                        <div class="g-0  input-right-icon">
                                                            <div class="row">
                                                                <div class="col-md-3 mb-25 ps-0">
                                                                    <div class="mr-30">
                                                                        <label class="primary_checkbox d-flex mr-12 "
                                                                               for="in_app_chat1">
                                                                            <input type="radio" name="in_app_chat"
                                                                                   id="in_app_chat1"
                                                                                   value="1"
                                                                                   checked
                                                                                   class="common-radio ">
                                                                            <span
                                                                                class="checkmark me-2"></span> {{__('common.Yes')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mb-25">
                                                                    <div class="mr-30">
                                                                        <label class="primary_checkbox d-flex mr-12 "
                                                                               for="in_app_chat0">
                                                                            <input type="radio" name="in_app_chat"
                                                                                   id="in_app_chat0"
                                                                                   value="0"

                                                                                   class="common-radio ">
                                                                            <span
                                                                                class="checkmark me-2"></span> {{__('common.No')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    @if (Settings('frontend_active_theme') == 'edume')
                                        <div class="row mt-20">
                                            <div class="col-xl-4">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('courses.Key Point') }} (1)</label>
                                                    <input class="primary_input_field" name="what_learn1"
                                                           placeholder="-"
                                                           type="text"
                                                           value="{{ isset($class) ? old('what_learn1', $class->course->what_learn1 ?? '') : old('what_learn1') }}">
                                                </div>
                                            </div>

                                            <div class="col-xl-4">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('courses.Key Point') }} (2) </label>
                                                    <input class="primary_input_field" name="what_learn2"
                                                           placeholder="-"
                                                           type="text"
                                                           value="{{ isset($class) ? old('what_learn2', $class->course->what_learn2 ?? '') : old('what_learn2') }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    @if(isModuleActive("GoogleCalendar") && saasEnv('ALLOW_GOOGLE_CALENDAR')=='true' && GoogleCalendarAccount::where('is_active',1)->get()->count() > 0)

                                        @php
                                            $falseCheck = true;
                                            if(isset($class) && $class->googleEvents->count() > 0){
                                                $falseCheck = false;
                                            }

                                        @endphp
                                        <div class="row mt-25 allow_google_calendar_div">
                                            <div class="col-md-12 mt-25 ">
                                                <label class="primary_input_label"
                                                       for=""> {{__('setting.Allow Google Calendar')}} </label>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <label for="allow_google_calendar1"
                                                       class="primary_checkbox d-flex mr-12 ">
                                                    <input {{!$falseCheck?'checked':''}} type="radio"
                                                           class="common-checkbox" id="allow_google_calendar1"
                                                           name="allow_google_calendar"
                                                           value="1">
                                                    <span class="checkmark me-2"></span>{{__('common.Yes')}}</label>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <label for="allow_google_calendar2"
                                                       class="primary_checkbox d-flex mr-12 ">
                                                    <input {{$falseCheck?'checked':''}} type="radio"
                                                           class="common-checkbox" id="allow_google_calendar2"
                                                           name="allow_google_calendar"
                                                           value="0">
                                                    <span class="checkmark me-2"></span>{{__('common.No')}}</label>
                                            </div>

                                        </div>
                                    @endif
                                    <div class="row mt-20">

                                        <div class="col-lg-4">
                                            <div class="primary_input  mb-25">
                                                <label class="primary_input_label"
                                                       for="certificate">{{ __('certificate.Certificate') }}</label>
                                                <div class="primary_input">
                                                    <select class="primary_select " name="certificate" id="certificate">
                                                        <option
                                                            data-display="{{ __('common.Select') }} {{ __('certificate.Certificate') }}"
                                                            value="">{{ __('common.Select') }}
                                                            {{ __('certificate.Certificate') }} </option>
                                                        @foreach ($certificates as $certificate)
                                                            <option value="{{ $certificate->id }}"
                                                            @if(isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro')
                                                                {{ isset($class) ? ($certificate->id == $class->course->pro_certificate_id ? 'selected' : '') : '' }}
                                                                @else
                                                                {{ isset($class) ? ($certificate->id == $class->course->certificate_id ? 'selected' : '') : '' }}
                                                                @endif

                                                            >
                                                                {{ @$certificate->title }} </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="primary_input  mb-25">
                                                <label class="primary_input_label"> {{ __('virtual-class.Capacity') }}
                                                    <small>[{{__('common.Note: 0 or empty means unlimited')}}
                                                        ]</small></label>
                                                <input
                                                    class="primary_input_field  {{ $errors->has('capacity') ? ' is-invalid' : '' }}"
                                                    type="number" name="capacity" min="0"
                                                    value="{{ isset($class) ? $class->capacity : old('capacity',0) }}">
                                                <span class="focus-border"></span>
                                            </div>
                                        </div>

                                        @if(isModuleActive("SupportTicket"))
                                            <div class="col-lg-4 mt-40">
                                                <div class="checkbox_wrap d-flex align-items-center">
                                                    <label for="support" class="switch_toggle me-1">
                                                        <input type="checkbox" name="support"
                                                               {{ isset($class) && $class->course->support == 1 ? 'checked' : '' }}
                                                               class="support" id="support" value="1">
                                                        <i class="slider round"></i>
                                                    </label>
                                                    <label class="mb-0 ms-2">{{ __('common.Support') }}</label>
                                                </div>
                                            </div>
                                        @endif


                                        {{--                    <div class="col-lg-4">--}}
                                        {{--                        <div class="checkbox_wrap d-flex align-items-center">--}}
                                        {{--                            <label for="show_record" class="switch_toggle me-1">--}}
                                        {{--                                <input type="checkbox" name="show_record"--}}

                                        {{--                                       class="show_record" id="show_record" value="1">--}}
                                        {{--                                <i class="slider round"></i>--}}
                                        {{--                            </label>--}}
                                        {{--                            <label class="mb-0 ms-2">{{ __('virtual-class.Show Record') }}</label>--}}
                                        {{--                        </div>--}}
                                        {{--                    </div>--}}


                                    </div>
                                    <div class="row mt-20">

                                        <div class="col-xl-4 col-md-6">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label
                                                        class="primary_input_label mt-1">{{ __('virtual-class.Show Record') }}</label>
                                                </div>
                                                <div class="col-lg-12  d-flex mt-2">
                                                    <div class="col-md-4">
                                                        <label for="show_record_1"
                                                               class="primary_checkbox d-flex mr-12 is_recurring">
                                                            <input type="radio" class="common-checkbox"
                                                                   id="show_record_1"
                                                                   name="show_record"
                                                                   value="1"
                                                                {{ isset($class) && $class->show_record == 1 ? 'checked' : '' }}
                                                            >
                                                            <span class="checkmark me-2"></span>{{ __('common.Yes') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="show_record_2"
                                                               class="primary_checkbox d-flex mr-12 is_recurring">
                                                            <input type="radio" class="common-checkbox"
                                                                   id="show_record_2"
                                                                   name="show_record"
                                                                   value="0"
                                                                {{ isset($class) && $class->show_record != 1 ? 'checked' : '' }}
                                                                {{!isset($class)? 'checked' : ''}}
                                                            >
                                                            <span class="checkmark me-2"></span>{{ __('common.No') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-md-6">
                                            <div class="primary_input  mb-25">
                                                <label
                                                    class="primary_input_label">{{ __('virtual-class.Validity Days After Record') }}
                                                    <small>
                                                        [{{__('common.Note: 0 or empty means unlimited')}}]
                                                    </small>
                                                </label>
                                                <input
                                                    class="primary_input_field  {{ $errors->has('record_validity') ? ' is-invalid' : '' }}"
                                                    type="number" name="record_validity" min="0"
                                                    value="{{ isset($class) ? $class->record_validity : old('record_validity',0) }}">
                                                <span class="focus-border"></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row row-gap-24">
                                        <div
                                            class="col-lg-12 text-center d-flex justify-content-center align-items-center">
                                            <button type="submit" class="primary-btn fix-gr-bg"
                                                    data-bs-toggle="tooltip">
                                                <i class="ti-check"></i>
                                                @if (isset($class))
                                                    {{ __('common.Update') }}
                                                @else
                                                    {{ __('common.Save') }}
                                                @endif
                                                {{ __('virtual-class.Class') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
</div>

