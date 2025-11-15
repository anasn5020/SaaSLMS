@extends('backend.master')
@section('table')
    {{__('testimonials')}}
@endsection
@section('mainContent')
    @include("backend.partials.alertMessage")
    @php
        $LanguageList = getLanguageList();
    @endphp
    <style>
        .couter_boxs::before {
            background-image: url('{{asset('public/frontned/edume/img/about/counter_bg.png')}}');
        }
    </style>
    {!! generateBreadcrumb() !!}

    <section class="mb-20 student-details">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-lg-12">
                    <div class="row ">

                        <div class="col-lg-10">
                            <h3 class=" ">{{__('frontendmanage.About Content')}}</h3>


                        </div>
                        <div class="  col-lg-2 text-end col-md-12 mb-20"><a target="_blank"
                                                                            href="{{route('about')}}"
                                                                            class="primary-btn small fix-gr-bg"> <span
                                    class="ti-eye pe-2"></span> {{__('student.Preview')}} </a></div>
                    </div>


                    <form class="form-horizontal"
                          action="  @if (permissionCheck('frontend.AboutPage')) {{route('frontend.saveAboutPage')}}@endif"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        <div class="white-box  student-details header-menu">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                    <input type="hidden" name="id" value="{{@$about->id}}">

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
                                                <div class="row mb-30">
                                                    @if(currentTheme()=='tvt')
                                                        <div class="col-xl-12">
                                                            <div class="row">
                                                                <div class="col-xl-4">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{__('frontend.Registered Students')}} </label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('frontend.Registered Students')}} "
                                                                               type="text"
                                                                               name="registered_students[{{$language->code}}]"
                                                                               {{ $errors->has('registered_students') ? ' autofocus' : '' }}
                                                                               value="{{isset($about)? $about->getTranslation('registered_students',$language->code) : ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-4">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{__('frontend.Questions Answered')}} </label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('frontend.Questions Answered')}} "
                                                                               type="text"
                                                                               name="questions_answers[{{$language->code}}]"
                                                                               {{ $errors->has('questions_answers') ? ' autofocus' : '' }}
                                                                               value="{{isset($about)? $about->getTranslation('questions_answers',$language->code) : ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-4">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{__('frontend.Quality Content')}} </label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('frontend.Quality Content')}} "
                                                                               type="text"
                                                                               name="quality_content[{{$language->code}}]"
                                                                               {{ $errors->has('quality_content') ? ' autofocus' : '' }}
                                                                               value="{{isset($about)? $about->getTranslation('quality_content',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <hr>
                                                            <br>
                                                        </div>

                                                        <div class="col-xl-12">
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{__('frontend.Our Mission')}}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('frontend.Our Mission')}}"
                                                                               type="text"
                                                                               name="our_mission[{{$language->code}}]"
                                                                               {{ $errors->has('registered_students') ? ' autofocus' : '' }}
                                                                               value="{{isset($about)? $about->getTranslation('our_mission',$language->code) : ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{__('frontend.Our Vision')}}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('frontend.Our Vision')}} "
                                                                               type="text"
                                                                               name="our_vision[{{$language->code}}]"
                                                                               {{ $errors->has('our_vision') ? ' autofocus' : '' }}
                                                                               value="{{isset($about)? $about->getTranslation('our_vision',$language->code) : ''}}">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <hr>
                                                            <br>
                                                        </div>
                                                    @endif


                                                    @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'teachery')
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('frontendmanage.Who We Are')}} </label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('frontendmanage.Who We Are')}}"
                                                                       type="text"
                                                                       name="who_we_are[{{$language->code}}]"
                                                                       {{ $errors->has('who_we_are') ? ' autofocus' : '' }}
                                                                       value="{{isset($about)? $about->getTranslation('who_we_are',$language->code) : ''}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('frontendmanage.Banner Title')}} </label>
                                                                <input class="primary_input_field"
                                                                       {{ $errors->has('banner_title') ? ' autofocus' : '' }}
                                                                       placeholder="{{__('frontendmanage.Banner Title')}}"
                                                                       type="text"
                                                                       name="banner_title[{{$language->code}}]"
                                                                       value="{{isset($about)? $about->getTranslation('banner_title',$language->code) : ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <hr>
                                                            <br>
                                                        </div>
                                                    @endif

                                                    @if(currentTheme()!='tvt')
                                                        <div class="col-xl-12">
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{__('frontendmanage.Story Title')}} </label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('frontendmanage.Story Title')}}"
                                                                               type="text"
                                                                               name="story_title[{{$language->code}}]"
                                                                               {{ $errors->has('story_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($about)? $about->getTranslation('story_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.Story Description') }}
                                                                        </label>

                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('frontendmanage.Story Description')}}"
                                                                               type="text"
                                                                               name="story_description[{{$language->code}}]"
                                                                               {{ $errors->has('story_description') ? ' autofocus' : '' }}
                                                                               value="{{isset($about)? $about->getTranslation('story_description',$language->code) : ''}}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12">
                                                            <hr>
                                                            <br>
                                                        </div>
                                                    @endif

                                                    @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'teachery')
                                                        <div class="col-xl-2">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('frontendmanage.Total Teachers')}} </label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('frontendmanage.Total Teacher')}}"
                                                                       type="text"
                                                                       name="total_teacher[{{$language->code}}]"
                                                                       {{ $errors->has('total_teacher') ? ' autofocus' : '' }}
                                                                       value="{{isset($about)? $about->getTranslation('total_teacher',$language->code) : ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('frontendmanage.Teacher Title')}} </label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('frontendmanage.Teacher Title')}}"
                                                                       type="text"
                                                                       name="teacher_title[{{$language->code}}]"
                                                                       {{ $errors->has('teacher_title') ? ' autofocus' : '' }}
                                                                       value="{{isset($about)? $about->getTranslation('teacher_title',$language->code) : ''}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('frontendmanage.Teacher Details') }}
                                                                </label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('frontendmanage.Teacher Details')}}"
                                                                       type="text"
                                                                       name="teacher_details[{{$language->code}}]"
                                                                       {{ $errors->has('teacher_details') ? ' autofocus' : '' }}
                                                                       value="{{isset($about)? $about->getTranslation('teacher_details',$language->code) : ''}}">

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <hr>
                                                            <br>
                                                        </div>
                                                    @endif

                                                    @if(currentTheme() == 'infixlmstheme'  || currentTheme() == 'teachery')
                                                        <div class="col-xl-2">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('frontendmanage.Total Students')}} </label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('frontendmanage.Total Student')}}"
                                                                       type="text"
                                                                       name="total_student[{{$language->code}}]"
                                                                       {{ $errors->has('total_student') ? ' autofocus' : '' }}
                                                                       value="{{isset($about)? $about->getTranslation('total_student',$language->code) : ''}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('frontendmanage.Student Title')}} </label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('frontendmanage.Student Title')}}"
                                                                       type="text"
                                                                       name="student_title[{{$language->code}}]"
                                                                       {{ $errors->has('student_title') ? ' autofocus' : '' }}
                                                                       value="{{isset($about)? $about->getTranslation('student_title',$language->code) : ''}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('frontendmanage.Student Details') }}
                                                                </label>

                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('frontendmanage.Student Details')}}"
                                                                       type="text"
                                                                       name="student_details[{{$language->code}}]"
                                                                       {{ $errors->has('student_details') ? ' autofocus' : '' }}
                                                                       value="{{isset($about)? $about->getTranslation('student_details',$language->code) : ''}}">

                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12">
                                                            <hr>
                                                            <br>
                                                        </div>
                                                    @endif

                                                    @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'teachery')

                                                        <div class="col-xl-2">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('frontendmanage.Total Courses')}} </label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('frontendmanage.Total Courses')}}"
                                                                       type="text"
                                                                       name="total_courses[{{$language->code}}]"
                                                                       {{ $errors->has('total_courses') ? ' autofocus' : '' }}
                                                                       value="{{isset($about)? $about->getTranslation('total_courses',$language->code) : ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('frontendmanage.Course Title')}} </label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('frontendmanage.Course Title')}}"
                                                                       type="text"
                                                                       name="course_title[{{$language->code}}]"
                                                                       {{ $errors->has('course_title') ? ' autofocus' : '' }}
                                                                       value="{{isset($about)? $about->getTranslation('course_title',$language->code) : ''}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('frontendmanage.Course Details') }}
                                                                </label>

                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('frontendmanage.Course Title')}}"
                                                                       type="text"
                                                                       name="course_details[{{$language->code}}]"
                                                                       {{ $errors->has('course_details') ? ' autofocus' : '' }}
                                                                       value="{{isset($about)? $about->getTranslation('course_details',$language->code) : ''}}">

                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12">
                                                            <hr>
                                                            <br>
                                                        </div>
                                                    @endif

                                                    @if(currentTheme() != 'teachery')
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="primary_input_label"
                                                                               for="    "> {{__('frontendmanage.About Page Content Title')}}</label>

                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('frontendmanage.About Page Content Title')}}"
                                                                               type="text"
                                                                               name="about_page_content_title[{{$language->code}}]"
                                                                               {{ $errors->has('about_page_content_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($about)? $about->getTranslation('about_page_content_title',$language->code) : ''}}">
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="primary_input_label"
                                                                               for="    "> {{__('frontendmanage.About Page Content Details')}}</label>

                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('frontendmanage.About Page Content Details')}}"
                                                                               type="text"
                                                                               name="about_page_content_details[{{$language->code}}]"
                                                                               {{ $errors->has('about_page_content_details') ? ' autofocus' : '' }}
                                                                               value="{{isset($about)? $about->getTranslation('about_page_content_details',$language->code) : ''}}">
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(currentTheme()=='tvt')
                                                            <div class="col-xl-12">
                                                                <div class="primary_input mb-25">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label class="primary_input_label"
                                                                                   for="    "> {{__('frontendmanage.About Page Content Details')}}
                                                                                2</label>

                                                                            <input class="primary_input_field"
                                                                                   placeholder="{{__('frontendmanage.About Page Content Details')}} 2"
                                                                                   type="text"
                                                                                   name="about_page_content_details2[{{$language->code}}]"
                                                                                   {{ $errors->has('about_page_content_details2') ? ' autofocus' : '' }}
                                                                                   value="{{isset($about)? $about->getTranslation('about_page_content_details2',$language->code) : ''}}">
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif

                                                    @if(currentTheme()!='tvt' && currentTheme()!='teachery')
                                                        <div class="col-xl-12">
                                                            <hr>
                                                            <br>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="primary_input_label"
                                                                               for="    "> {{__('frontendmanage.Live Class Title')}}</label>

                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('frontendmanage.Live Class Title')}}"
                                                                               type="text"
                                                                               name="live_class_title[{{$language->code}}]"
                                                                               {{ $errors->has('live_class_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($about)? $about->getTranslation('live_class_title',$language->code) : ''}}">
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="primary_input_label"
                                                                               for="    "> {{__('frontendmanage.Live Class Details')}}</label>

                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('frontendmanage.Live Class Details')}}"
                                                                               type="text"
                                                                               name="live_class_details[{{$language->code}}]"
                                                                               {{ $errors->has('live_class_details') ? ' autofocus' : '' }}
                                                                               value="{{isset($about)? $about->getTranslation('live_class_details',$language->code) : ''}}">
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif


                                                    <div class="col-xl-12">
                                                        <hr>
                                                        <br>
                                                    </div>


                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Sponsor Title') }}</label>
                                                            <input class="primary_input_field"
                                                                   placeholder="{{ __('frontendmanage.Sponsor Title') }}"
                                                                   type="text" name="sponsor_title[{{$language->code}}]"
                                                                   {{ $errors->has('sponsor_title') ? ' autofocus' : '' }}
                                                                   value="{{isset($about)? $about->getTranslation('sponsor_title',$language->code) : ''}}">
                                                        </div>
                                                    </div>


                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Sponsor Sub Title') }}</label>
                                                            <input class="primary_input_field"
                                                                   placeholder="{{ __('frontendmanage.Sponsor Sub Title') }}"
                                                                   type="text"
                                                                   name="sponsor_sub_title[{{$language->code}}]"
                                                                   {{ $errors->has('sponsor_sub_title') ? ' autofocus' : '' }}
                                                                   value="{{isset($about)? $about->getTranslation('sponsor_sub_title',$language->code) : ''}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <hr>
                                                        <br>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if(currentTheme() != 'tvt' && currentTheme() != 'teachery')
                                        <div class="row ">
                                            <div class="col-xl-2">
                                                <div class="primary_input mb-25">

                                                    <img class="w-100 imagePreview5"
                                                         src="{{asset(isset($about)? $about->live_class_image : '')}}"
                                                         alt="">

                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('frontendmanage.Live Class Image') }}
                                                        <small>({{__('common.Recommended Size')}} 560x555)</small>
                                                    </label>
                                                    <div class="primary_file_uploader">
                                                        <input
                                                            class="primary-input  filePlaceholder {{ @$errors->has('live_class_image') ? ' is-invalid' : '' }}"
                                                            type="text" id=""
                                                            placeholder="{{__('setting.Browse file')}}"
                                                            readonly="" {{ $errors->has('live_class_image') ? ' autofocus' : '' }}>
                                                        <button class="" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                   for="live_class_image">{{ __('common.Browse') }}</label>
                                                            <input type="file" class="d-none imgInput5"
                                                                   name="live_class_image" id="live_class_image">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row ">

                                        @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'teachery' || currentTheme() == 'tvt')
                                            <div class="col-xl-6">
                                                <div class="row">

                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">

                                                            <img class="w-100 imagePreview1"
                                                                 src="{{asset(isset($about)? $about->image1 : '')}}"
                                                                 alt="">

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-8">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Image 1') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    330x330)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('image1') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="{{__('setting.Browse file')}}"
                                                                    readonly="" {{ $errors->has('image1') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label class="primary-btn small fix-gr-bg"
                                                                           for="file1">{{ __('common.Browse') }}</label>
                                                                    <input type="file" class="d-none imgInput1"
                                                                           name="image1" id="file1">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if(currentTheme() != 'tvt')
                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">

                                                                <img class="w-100 imagePreview2"
                                                                     src="{{asset(isset($about)? $about->image2 : '')}}"
                                                                     alt="">

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-8">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('frontendmanage.Image 2') }}
                                                                    <small>({{__('common.Recommended Size')}}
                                                                        360x540)</small>
                                                                </label>
                                                                <div class="primary_file_uploader">
                                                                    <input
                                                                        class="primary-input  filePlaceholder {{ @$errors->has('image2') ? ' is-invalid' : '' }}"
                                                                        type="text" id=""
                                                                        placeholder="{{__('setting.Browse file')}}"
                                                                        readonly="" {{ $errors->has('image2') ? ' autofocus' : '' }}>
                                                                    <button class="" type="button">
                                                                        <label class="primary-btn small fix-gr-bg"
                                                                               for="file2">{{ __('common.Browse') }}</label>
                                                                        <input type="file" class="d-none imgInput2"
                                                                               name="image2" id="file2">
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">

                                                                <img class="w-100 imagePreview3"
                                                                     src="{{asset(isset($about)? $about->image3 : '')}}"
                                                                     alt="">

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-8">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('frontendmanage.Image 3') }}
                                                                    <small>({{__('common.Recommended Size')}}
                                                                        280x330)</small>
                                                                </label>
                                                                <div class="primary_file_uploader">
                                                                    <input
                                                                        class="primary-input  filePlaceholder {{ @$errors->has('image3') ? ' is-invalid' : '' }}"
                                                                        type="text" id=""
                                                                        placeholder="{{__('setting.Browse file')}}"
                                                                        readonly="" {{ $errors->has('image3') ? ' autofocus' : '' }}>
                                                                    <button class="" type="button">
                                                                        <label class="primary-btn small fix-gr-bg"
                                                                               for="file3">{{ __('common.Browse') }}</label>
                                                                        <input type="file" class="d-none imgInput3"
                                                                               name="image3" id="file3">
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'teachery')
                                            <div class="col-xl-2">
                                                <div class="primary_input mb-25">

                                                    <img class="w-100 imagePreview4"
                                                         src="{{asset(isset($about)? $about->image4 : '')}}"
                                                         alt="">

                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('frontendmanage.Image 4') }}
                                                        <small>({{__('common.Recommended Size')}} 946x775)</small>
                                                    </label>
                                                    <div class="primary_file_uploader">
                                                        <input
                                                            class="primary-input  filePlaceholder {{ @$errors->has('image4') ? ' is-invalid' : '' }}"
                                                            type="text" id=""
                                                            placeholder="{{__('setting.Browse file')}}"
                                                            readonly="" {{ $errors->has('image4') ? ' autofocus' : '' }}>
                                                        <button class="" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                   for="file4">{{ __('common.Browse') }}</label>
                                                            <input type="file" class="d-none imgInput4"
                                                                   name="image4" id="file4">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <hr>
                                                <br>
                                            </div>
                                        @endif
                                        @if(currentTheme() != 'tvt')
                                            <div class="col-xl-2">
                                                <div class="primary_input mb-25">

                                                    <img class="w-100 imagePreview6"
                                                         src="{{asset(isset($about)? $about->counter_bg : '')}}"
                                                         alt="">

                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('frontendmanage.Counter Background Image') }}
                                                        <small>({{__('common.Recommended Size')}} 850x230)</small>
                                                    </label>
                                                    <div class="primary_file_uploader">
                                                        <input
                                                            class="primary-input  filePlaceholder {{ @$errors->has('counter_bg') ? ' is-invalid' : '' }}"
                                                            type="text" id=""
                                                            placeholder="{{__('setting.Browse file')}}"
                                                            readonly="" {{ $errors->has('counter_bg') ? ' autofocus' : '' }}>
                                                        <button class="" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                   for="counter_bg">{{ __('common.Browse') }}</label>
                                                            <input type="file" class="d-none imgInput6"
                                                                   name="counter_bg" id="counter_bg">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <hr>
                                                <br>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="primary_input mb-25">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="primary_input_label"
                                                                   for="    "> {{__('frontendmanage.Show Testimonial')}}</label>
                                                        </div>

                                                        <div class="col-md-6 mb-25">
                                                            <label class="primary_checkbox d-flex mr-12"
                                                                   for="testimonial0">
                                                                <input type="radio"
                                                                       class="common-radio drip0"
                                                                       id="testimonial0"
                                                                       name="show_testimonial"
                                                                       value="0" {{@$about->show_testimonial==0?"checked":""}}>
                                                                <span class="checkmark me-2"></span> {{__('common.No')}}
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6 mb-25">
                                                            <label class="primary_checkbox d-flex mr-12"
                                                                   for="testimonial1">
                                                                <input type="radio"
                                                                       class="common-radio drip1"
                                                                       id="testimonial1"
                                                                       name="show_testimonial"
                                                                       value="1" {{@$about->show_testimonial==1?"checked":""}}>
                                                                <span
                                                                    class="checkmark me-2"></span> {{__('common.Yes')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="primary_input mb-25">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="primary_input_label"
                                                                   for=""> {{__('frontendmanage.Show Brand')}}</label>
                                                        </div>

                                                        <div class="col-md-6 mb-25">
                                                            <label class="primary_checkbox d-flex mr-12"
                                                                   for="show_brand0">
                                                                <input type="radio"
                                                                       class="common-radio drip0"
                                                                       id="show_brand0"
                                                                       name="show_brand"
                                                                       value="0" {{@$about->show_brand==0?"checked":""}}>
                                                                <span class="checkmark me-2"></span> {{__('common.No')}}
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6 mb-25">
                                                            <label class="primary_checkbox d-flex mr-12"
                                                                   for="show_brand1">
                                                                <input type="radio"
                                                                       class="common-radio drip1"
                                                                       id="show_brand1"
                                                                       name="show_brand"
                                                                       value="1" {{@$about->show_brand==1?"checked":""}}>
                                                                <span
                                                                    class="checkmark me-2"></span> {{__('common.Yes')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'teachery')
                                            <div class="col-xl-4">
                                                <div class="primary_input mb-25">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="primary_input_label"
                                                                   for="    "> {{__('frontendmanage.Show Become Instructor')}}</label>
                                                        </div>

                                                        <div class="col-md-6 mb-25">
                                                            <label class="primary_checkbox d-flex mr-12"
                                                                   for="show_become_instructor0">
                                                                <input type="radio"
                                                                       class="common-radio drip0"
                                                                       id="show_become_instructor0"
                                                                       name="show_become_instructor"
                                                                       value="0" {{@$about->show_testimonial==0?"checked":""}}>
                                                                <span
                                                                    class="checkmark me-2"></span> {{__('common.No')}}
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6 mb-25">
                                                            <label class="primary_checkbox d-flex mr-12"
                                                                   for="show_become_instructor1">
                                                                <input type="radio"
                                                                       class="common-radio drip1"
                                                                       id="show_become_instructor1"
                                                                       name="show_become_instructor"
                                                                       value="1" {{@$about->show_testimonial==1?"checked":""}}>
                                                                <span
                                                                    class="checkmark me-2"></span> {{__('common.Yes')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>

                                </div>
                            </div>

                            @php
                                $tooltip = "";
                                if(permissionCheck('null')){
                                    $tooltip = "";
                                }else{
                                    $tooltip = "You have no permission to Update";
                                }
                            @endphp
                            <div class="row mt-40">
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="primary-btn fix-gr-bg" data-bs-toggle="tooltip"
                                            title="{{$tooltip}}">
                                        <i class="ti-check"></i>
                                        {{__('common.Update')}}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview1").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput1").change(function () {
            readURL1(this);
        });

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview2").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput2").change(function () {
            readURL2(this);
        });


        function readURL3(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview3").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput3").change(function () {
            readURL3(this);
        });


        function readURL4(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview4").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput4").change(function () {
            readURL4(this);
        });

        function readURL5(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview5").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput5").change(function () {
            readURL5(this);
        });

        function readURL6(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview6").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput6").change(function () {
            readURL6(this);
        });

    </script>
@endpush
