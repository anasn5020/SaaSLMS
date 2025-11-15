@extends('backend.master')
@section('table')
    {{__('testimonials')}}
@endsection
@section('mainContent')
    @php
        $LanguageList = getLanguageList();
    @endphp
    {!! generateBreadcrumb() !!}


    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-lg-12">


                    <form class="form-horizontal" action="{{route('frontend.pageContent_Update')}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="white-box student-details header-menu">
                             <div class="row">
                                <div class="col-md-6 ">
                                    <div class=" ">
                                        <x-upload-file
                                            name="breadcrumb_image"
                                            type="image"
                                            media_id="{{isset($breadcrumb_image)?$breadcrumb_image->value_media?->media_id:''}}"
                                            label="{{ __('frontendmanage.Breadcrumb Image') }}"
                                            note="{{__('student.Recommended size')}} (1920x210)"
                                        />
                                    </div>

                                 {{--    <div class="row">
                                        <div class="col-md-12">

                                            <div
                                                class="row pt-0  ">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element1{{$language->code}}"
                                                                   role="tab"
                                                                   data-bs-toggle="tab">{{ $language->native }}  </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div
                                                class="tab-content   ">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element1{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Course Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Course Page Title') }}"
                                                                           type="text"
                                                                           name="course_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('course_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'course_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6  ">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Course Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Course Page Sub Title') }}"
                                                                           type="text"
                                                                           name="course_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('course_page_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'course_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="row">
                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')

                                                    <div class="col-xl-6">
                                                        <div class=" mb-25">
                                                            <x-upload-file
                                                                name="course_page_banner"
                                                                type="image"
                                                                media_id="{{isset($course_page_banner)?$course_page_banner->value_media?->media_id:''}}"
                                                                label="{{ __('frontendmanage.Course Page Banner') }}"
                                                                note="{{__('student.Recommended size')}} (1920x500)"
                                                            />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div
                                                class="row pt-0  {{(currentTheme() == 'infixlmstheme') ? 'd-none' : ''}}">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element2{{$language->code}}"
                                                                   role="tab"
                                                                   data-bs-toggle="tab">{{ $language->native }}  </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div
                                                class="tab-content  {{(currentTheme() == 'infixlmstheme') ? 'd-none' : ''}}">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element2{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Class Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Class Page Title') }}"
                                                                           type="text"
                                                                           name="class_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('class_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'class_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Class Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Class Page Sub Title') }}"
                                                                           type="text"
                                                                           name="class_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('class_page_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'class_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">

                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')

                                                    <div class="col-xl-6">
                                                        <div class=" mb-25">
                                                            <x-upload-file
                                                                name="class_page_banner"
                                                                type="image"
                                                                media_id="{{isset($class_page_banner)?$class_page_banner?->value_media?->media_id:''}}"
                                                                label="{{ __('frontendmanage.Class Page Banner') }}"
                                                                note="{{__('student.Recommended size')}} (1920x500)"
                                                            />
                                                        </div>

                                                    </div>
                                                @endif
                                            </div>

                                            <div
                                                class="row pt-0  {{(currentTheme() == 'infixlmstheme') ? 'd-none' : ''}}">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element3{{$language->code}}"
                                                                   role="tab"
                                                                   data-bs-toggle="tab">{{ $language->native }}  </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div
                                                class="tab-content  {{(currentTheme() == 'infixlmstheme') ? 'd-none' : ''}}">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element3{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Quiz Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Quiz Page Title') }}"
                                                                           type="text"
                                                                           name="quiz_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('class_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'quiz_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Quiz Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Quiz Page Sub Title') }}"
                                                                           type="text"
                                                                           name="quiz_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('quiz_page_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'quiz_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">

                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')

                                                    <div class="col-xl-6">

                                                        <div class=" mb-25">
                                                            <x-upload-file
                                                                name="quiz_page_banner"
                                                                type="image"
                                                                media_id="{{isset($quiz_page_banner)?$quiz_page_banner->value_media?->media_id:''}}"
                                                                label="{{ __('frontendmanage.Quiz Page Banner') }}"
                                                                note="{{__('student.Recommended size')}} (1920x500)"
                                                            />
                                                        </div>

                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row pt-0">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element4{{$language->code}}"
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
                                                         id="element4{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Instructor Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Instructor Page Title') }}"
                                                                           type="text"
                                                                           name="instructor_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('instructor_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'instructor_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Instructor Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Instructor Page Sub Title') }}"
                                                                           type="text"
                                                                           name="instructor_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('instructor_page_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'instructor_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">

                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')

                                                    <div class="col-xl-6">
                                                        <div class=" mb-25">
                                                            <x-upload-file
                                                                name="instructor_page_banner"
                                                                type="image"
                                                                media_id="{{isset($instructor_page_banner)?$instructor_page_banner->value_media?->media_id:''}}"
                                                                label="{{ __('frontendmanage.Instructor Page Banner') }}"
                                                                note="{{__('student.Recommended size')}} (1920x500)"
                                                            />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="row pt-0">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element5{{$language->code}}"
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
                                                         id="element5{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Become Instructor Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Become Instructor Page Title') }}"
                                                                           type="text"
                                                                           name="become_instructor_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('become_instructor_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'become_instructor_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Become Instructor Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Become Instructor Page Sub Title') }}"
                                                                           type="text"
                                                                           name="become_instructor_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('become_instructor_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'become_instructor_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="row">

                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')

                                                    <div class="col-xl-6">
                                                        <div class=" mb-25">
                                                            <x-upload-file
                                                                name="become_instructor_page_banner"
                                                                type="image"
                                                                media_id="{{isset($become_instructor_page_banner)?$become_instructor_page_banner->value_media?->media_id:''}}"
                                                                label="{{ __('frontendmanage.Become Instructor Page Banner') }}"
                                                                note="{{__('student.Recommended size')}} (1920x500)"
                                                            />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>


                                            @if(currentTheme() == 'wetech' || currentTheme() == 'teachery')
                                                <div class="row pt-0">
                                                    @if(isModuleActive('FrontendMultiLang'))
                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                            role="tablist">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <li class="nav-item">
                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                       href="#element6{{$language->code}}"
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
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.About Page Title') }}
                                                                        </label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.About Page Title') }}"
                                                                               type="text"
                                                                               name="about_page_title[{{$language->code}}]"
                                                                               {{ $errors->has('about_page_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'about_page_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.About Page Sub Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.About Page Sub Title') }}"
                                                                               type="text"
                                                                               name="about_sub_title[{{$language->code}}]"
                                                                               {{ $errors->has('about_sub_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'about_sub_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row">

                                                    <div class="col-xl-6">
                                                        <div class=" mb-25">
                                                            <x-upload-file
                                                                name="about_page_banner"
                                                                type="image"
                                                                media_id="{{isset($about_page_banner)?$about_page_banner->value_media?->media_id:''}}"
                                                                label="{{ __('frontendmanage.About Page Banner') }}"
                                                                note="{{__('student.Recommended size')}} (1920x500)"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(isModuleActive('Subscription') || isModuleActive('BundleSubscription'))
                                                <div class="row pt-0">
                                                    @if(isModuleActive('FrontendMultiLang'))
                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                            role="tablist">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <li class="nav-item">
                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                       href="#element7{{$language->code}}"
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
                                                             id="element7{{$language->code}}">
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('subscription.Subscription Page Title') }}
                                                                        </label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('subscription.Subscription Page Title') }}"
                                                                               type="text"
                                                                               name="subscription_page_title[{{$language->code}}]"
                                                                               {{ $errors->has('subscription_page_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'subscription_page_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('subscription.Subscription Page Sub Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('subscription.Subscription Page Sub Title') }}"
                                                                               type="text"
                                                                               name="subscription_page_sub_title[{{$language->code}}]"
                                                                               {{ $errors->has('subscription_page_sub_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'subscription_page_sub_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row">


                                                    <div class="col-xl-6">

                                                        <div class=" mb-25">
                                                            <x-upload-file
                                                                name="subscription_page_banner"
                                                                type="image"
                                                                media_id="{{isset($subscription_page_banner)?$subscription_page_banner->value_media?->media_id:''}}"
                                                                label="{{ __('frontendmanage.Subscription Page Banner') }}"
                                                                note="{{__('student.Recommended size')}} (1920x500)"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(isModuleActive('Forum'))
                                                <div class="row pt-0">
                                                    @if(isModuleActive('FrontendMultiLang'))
                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                            role="tablist">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <li class="nav-item">
                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                       href="#element8{{$language->code}}"
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
                                                             id="element8{{$language->code}}">
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('forum.Forum Page Title') }}
                                                                        </label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('forum.Forum Page Title') }}"
                                                                               type="text"
                                                                               name="forum_title[{{$language->code}}]"
                                                                               {{ $errors->has('forum_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'forum_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('forum.Forum Page Sub Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('forum.Forum Page Sub Title') }}"
                                                                               type="text"
                                                                               name="forum_sub_title[{{$language->code}}]"
                                                                               {{ $errors->has('forum_sub_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'forum_sub_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row">


                                                    @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')

                                                        <div class="col-xl-6">
                                                            <div class=" mb-25">
                                                                <x-upload-file
                                                                    name="forum_banner"
                                                                    type="image"
                                                                    media_id="{{isset($forum_banner)?$forum_banner->value_media?->media_id:''}}"
                                                                    label="{{ __('forum.Forum Page Banner') }}"
                                                                    note="{{__('student.Recommended size')}} (1920x500)"
                                                                />
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="row pt-0">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element9{{$language->code}}"
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
                                                         id="element9{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Blog Page Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Blog Page Title') }}"
                                                                           type="text"
                                                                           name="blog_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('blog_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'blog_page_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Blog Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Blog Page Sub Title') }}"
                                                                           type="text"
                                                                           name="blog_page_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('blog_page_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'blog_page_sub_title',$language->code) : ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">


                                                @if(currentTheme() == 'infixlmstheme' || currentTheme() == 'wetech' || currentTheme() == 'teachery')
                                                    <div class="col-xl-6">
                                                        <div class=" mb-25">
                                                            <x-upload-file
                                                                name="blog_page_banner"
                                                                type="image"
                                                                media_id="{{isset($blog_page_banner)?$blog_page_banner->value_media?->media_id:''}}"
                                                                label="{{ __('frontendmanage.Blog Page Banner') }}"
                                                                note="{{__('student.Recommended size')}} (1920x500)"
                                                            />
                                                        </div>
                                                    </div>
                                                @endif


                                                <div class="col-xl-12">
                                                    <hr>
                                                    <br>
                                                </div>

                                            </div>

                                            @if(isModuleActive('LmsSaas'))
                                                <div class="row pt-0">
                                                    @if(isModuleActive('FrontendMultiLang'))
                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                            role="tablist">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <li class="nav-item">
                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                       href="#element10{{$language->code}}"
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
                                                             id="element10{{$language->code}}">
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.Saas Page Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.Saas Page Title') }}"
                                                                               type="text"
                                                                               name="saas_title{{$language->code}}"
                                                                               {{ $errors->has('saas_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'saas_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.Saas Page Sub Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.Saas Page Sub Title') }}"
                                                                               type="text"
                                                                               name="saas_sub_title{{$language->code}}"
                                                                               {{ $errors->has('saas_sub_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'saas_sub_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row">

                                                    <div class="col-xl-6">
                                                        <div class=" mb-25">
                                                            <x-upload-file
                                                                name="saas_banner"
                                                                type="image"
                                                                media_id="{{isset($saas_banner)?$saas_banner->value_media?->media_id:''}}"
                                                                label="{{ __('frontendmanage.Saas Plan Banner') }}"
                                                                note="{{__('student.Recommended size')}} (1920x500)"
                                                            />
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <hr>
                                                        <br>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(isModuleActive('CourseOffer'))
                                                <div class="row pt-0">
                                                    @if(isModuleActive('FrontendMultiLang'))
                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                            role="tablist">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <li class="nav-item">
                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                       href="#element11{{$language->code}}"
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
                                                             id="element11{{$language->code}}">
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.Offer Page Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.Offer Page Title') }}"
                                                                               type="text"
                                                                               name="offer_page_title[{{$language->code}}]"
                                                                               {{ $errors->has('offer_page_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'offer_page_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>


                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.Offer Page Sub Title') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.Offer Page Sub Title') }}"
                                                                               type="text"
                                                                               name="offer_page_sub_title[{{$language->code}}]"
                                                                               {{ $errors->has('offer_page_sub_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'offer_page_sub_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class=" mb-25">
                                                            <x-upload-file
                                                                name="offer_page_banner"
                                                                type="image"
                                                                media_id="{{isset($offer_page_banner)?$offer_page_banner->value_media?->media_id:''}}"
                                                                label="{{ __('frontendmanage.Offer Page Banner') }}"
                                                                note="{{__('student.Recommended size')}} (1920x500)"
                                                            />
                                                        </div>
                                                    </div>


                                                    <div class="col-xl-12">
                                                        <hr>
                                                        <br>
                                                    </div>

                                                </div>
                                            @endif

                                        </div>
                                    </div>--}}
                                </div>
                            </div>

                            <div class="row  ">
                                <div class="col-lg-12 d-flex justify-content-center align-items-center">
                                    <button type="submit" class="primary-btn fix-gr-bg" data-bs-toggle="tooltip"
                                    >
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
        $(".imgInput4").change(function () {
            readURL4(this);
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

        function readURL7(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview7").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput7").change(function () {
            readURL7(this);
        });

        function readURL8(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview8").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput8").change(function () {
            readURL8(this);
        });


        function readURL9(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview9").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput9").change(function () {
            readURL9(this);
        });

        function readURL10(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview10").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput10").change(function () {
            readURL10(this);
        });


        function readURL11(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview11").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput11").change(function () {
            readURL11(this);
        });

        function readURL12(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview12").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput12").change(function () {
            readURL12(this);
        });
    </script>
@endpush
