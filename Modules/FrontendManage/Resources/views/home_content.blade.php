@extends('backend.master')
@section('table')
    {{__('testimonials')}}
@endsection
@push('styles')
    <link href="{{asset('public/backend/vendors/nestable/jquery.nestable.min.css')}}" rel="stylesheet">
    <style>
        .row > .accordion {
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        .row .accordion .card .card-header {
            padding: 5px 5px;
            background-color: rgba(237, 239, 245, 0.35);
        }

        .row .accordion .card .card-header::before {
            content: "\e656";
            font-family: 'themify';
            font-weight: 500;
            line-height: 1.5;
            font-size: 14px;
            color: #00124E;
            position: absolute;
            top: 13px;
            right: 25px;
        }

        .card-header button[aria-expanded]::before {
            font-family: 'themify';
            font-weight: 500;
            line-height: 1.5;
            font-size: 14px;
            color: #00124E;
            position: absolute;
            right: 55px;
            top: 13px;
            -webkit-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
        }

        .card-header button[aria-expanded = false]::before {
            content: "\e64b";
        }

        .card-header button[aria-expanded = true]::before {
            content: "\e648";
        }
    </style>
@endpush
@section('mainContent')
    @include("backend.partials.alertMessage")
    @php
        $currentTheme=currentTheme();
        if($currentTheme=='wetech'){
            $currentTheme='infixlmstheme';
        }
        $LanguageList = getLanguageList();
    @endphp
    <section class="sms-breadcrumb mb-20 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('frontendmanage.Home Content')}}</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('common.Dashboard')}}</a>
                    <a href="#">{{__('frontendmanage.Frontend CMS')}}</a>
                    <a class="active" href="{{url('frontend/home-content')}}">{{__('frontendmanage.Home Content')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class=" student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="offset-lg-10 col-lg-2 text-end col-md-12 mb-15">
                    <a target="_blank"
                       href="{{url('/')}}"
                       class="primary-btn small fix-gr-bg"> <span
                            class="ti-eye pe-2"></span> {{__('student.Preview')}} </a></div>
                <div class="col-lg-12">


                    <form class="form-horizontal" action="{{route('frontend.homeContent_Update')}}" method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        <div class="white-box  student-details header-menu">

                            <div class="col-md-12 ">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                <div class="row mb-30">
                                    <div class="col-md-12 item_list">

                                        @php
                                            if ($currentTheme=='tvt'){
                                                $ids =[1,3,18,19,20,21];
                                                $blocks =$blocks->whereIn('id', $ids);
                                            }
                                        @endphp

                                        @foreach($blocks as $block)
                                            @if($block->id==1)
                                                <div data-id="{{$block->id}}" class="row">
                                                    <div class="accordion" id="accordionHomeContent">
                                                        <div class="card">
                                                            <div class="card-header" id="heading{{$block->id}}">
                                                                <h2 class="mb-0 d-flex align-item-center justify-content-between">
                                                                    <button class="btn btn-block text-start"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                        {{ __('frontendmanage.Homepage Banner') }}
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div id="collapse{{ $block->id }}" class="collapse show"
                                                                 aria-labelledby="heading{{$block->id}}"
                                                                 data-parent="#accordionHomeContent">
                                                                <div class="card-body">
                                                                    <div class="col-xl-12 ">
                                                                        <div class="mb_25">
                                                                            <label class="switch_toggle "
                                                                                   for="show_banner_section">
                                                                                <input type="checkbox"
                                                                                       class="status_enable_disable"
                                                                                       name="show_banner_section"
                                                                                       id="show_banner_section"
                                                                                       @if (@getRawHomeContents($home_content,'show_banner_section','en') == 1) checked
                                                                                       @endif value="1">
                                                                                <i class="slider round"></i>


                                                                            </label>
                                                                            <span id="show_banner_section_title">
                                                                                    @if (@getRawHomeContents($home_content,'show_banner_section','en') == 1)
                                                                                    {{__('frontendmanage.Banner Section Show In Homepage')}}
                                                                                    <i class="ms-2 fa fa-question-circle"
                                                                                       data-bs-toggle="tooltip"
                                                                                       data-placement="top"
                                                                                       title="If disable, Slider will be shown"></i>
                                                                                @else
                                                                                    {{__('frontendmanage.Slider Show In Homepage')}}
                                                                                    <i class="ms-2 fa fa-question-circle"
                                                                                       data-bs-toggle="tooltip"
                                                                                       data-placement="top"
                                                                                       title="If enable, Banner Image will be shown"></i>

                                                                                @endif

                                                                                </span>
                                                                            <i class="ti-move  float-end"></i>
                                                                        </div>
                                                                    </div>
                                                                    @if (@getRawHomeContents($home_content,'show_banner_section','en') == 1)
                                                                        <div class="primary_input mb-25">
                                                                            <div id="show_banner_section_box"
                                                                                 class="col-md-12">
                                                                                <div class="row">

                                                                                    <div class="col-xl-4">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <img
                                                                                                class="  imagePreview5"
                                                                                                style="max-width: 100%"
                                                                                                src="{{ asset('/'.getRawHomeContents($home_content,'slider_banner','en'))}}"
                                                                                                alt="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-8">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <label
                                                                                                class="primary_input_label"
                                                                                                for="">{{ __('frontendmanage.Homepage Banner') }}
                                                                                                <small>({{__('common.Recommended Size')}}
                                                                                                    @if($currentTheme!="Edume")
                                                                                                        1920x500
                                                                                                    @else
                                                                                                        570x610
                                                                                                    @endif
                                                                                                                                                                                                               )
                                                                                                </small>
                                                                                            </label>
                                                                                            <div
                                                                                                class="primary_file_uploader">
                                                                                                <input
                                                                                                    class="primary-input  filePlaceholder {{ @$errors->has('slider_banner') ? ' is-invalid' : '' }}"
                                                                                                    type="text"
                                                                                                    id=""
                                                                                                    placeholder="{{__('setting.Browse file')}}"
                                                                                                    readonly="" {{ $errors->has('slider_banner') ? ' autofocus' : '' }}>
                                                                                                <button class=""
                                                                                                        type="button">
                                                                                                    <label
                                                                                                        class="primary-btn small fix-gr-bg"
                                                                                                        for="file5">{{ __('common.Browse') }}</label>
                                                                                                    <input
                                                                                                        type="file"
                                                                                                        class="d-none fileUpload imgInput5"
                                                                                                        name="slider_banner"
                                                                                                        id="file5">
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-3">

                                                                                        <div class="mb_25">
                                                                                            <label
                                                                                                class="switch_toggle "
                                                                                                for="show_menu_search_box">
                                                                                                <input
                                                                                                    type="checkbox"
                                                                                                    class="status_enable_disable"
                                                                                                    name="show_menu_search_box"
                                                                                                    id="show_menu_search_box"
                                                                                                    @if (@getRawHomeContents($home_content,'show_menu_search_box','en') == 1) checked
                                                                                                    @endif value="1">
                                                                                                <i class="slider round"></i>


                                                                                            </label>
                                                                                            {{__('frontendmanage.Show Menu Search Box')}}

                                                                                        </div>


                                                                                    </div>
                                                                                    @if($currentTheme=="teachery")
                                                                                        <div class="col-xl-3">

                                                                                            <div class="mb_25">
                                                                                                <label
                                                                                                    class="switch_toggle "
                                                                                                    for="show_category_slider">
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        class="status_enable_disable"
                                                                                                        name="show_category_slider"
                                                                                                        id="show_category_slider"
                                                                                                        @if (@getRawHomeContents($home_content,'show_category_slider','en') == 1) checked
                                                                                                        @endif value="1">
                                                                                                    <i class="slider round"></i>


                                                                                                </label>
                                                                                                {{__('frontendmanage.show Category Slider')}}

                                                                                            </div>


                                                                                        </div>
                                                                                    @endif
                                                                                    @if($currentTheme=="infixlmstheme")
                                                                                        <div class="col-xl-3">

                                                                                            <div class="mb_25">
                                                                                                <label
                                                                                                    class="switch_toggle "
                                                                                                    for="show_banner_search_box">
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        class="status_enable_disable"
                                                                                                        name="show_banner_search_box"
                                                                                                        id="show_banner_search_box"
                                                                                                        @if (@getRawHomeContents($home_content,'show_banner_search_box','en') == 1) checked
                                                                                                        @endif value="1">
                                                                                                    <i class="slider round"></i>


                                                                                                </label>
                                                                                                {{__('frontendmanage.Show Banner Search Box')}}

                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                    @if($currentTheme == "edume"  || $currentTheme =="teachery")
                                                                                        <div class="col-xl-3">

                                                                                            <div class="mb_25">

                                                                                                <label
                                                                                                    class="switch_toggle "
                                                                                                    for="show_banner_subscription_box">
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        class="status_enable_disable"
                                                                                                        name="show_banner_subscription_box"
                                                                                                        id="show_banner_subscription_box"
                                                                                                        @if (@getRawHomeContents($home_content,'show_banner_subscription_box','en') == 1) checked
                                                                                                        @endif value="1">
                                                                                                    <i class="slider round"></i>


                                                                                                </label>
                                                                                                {{__('frontendmanage.Show Banner Subscription Box')}}

                                                                                            </div>
                                                                                        </div>
                                                                                    @endif

                                                                                    @if($currentTheme=="Edume")
                                                                                        <div class="col-xl-4">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                <img
                                                                                                    class="  imagePreview11"
                                                                                                    style="max-width: 100%"
                                                                                                    src="{{ asset('/'.getRawHomeContents($home_content,'banner_logo','en'))}}"
                                                                                                    alt="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-xl-8">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                <label
                                                                                                    class="primary_input_label"
                                                                                                    for="">{{ __('frontendmanage.Homepage Banner Logo') }}
                                                                                                </label>
                                                                                                <div
                                                                                                    class="primary_file_uploader">
                                                                                                    <input
                                                                                                        class="primary-input  filePlaceholder {{ @$errors->has('banner_logo') ? ' is-invalid' : '' }}"
                                                                                                        type="text"
                                                                                                        id=""
                                                                                                        placeholder="{{__('setting.Browse file')}}"
                                                                                                        readonly="" {{ $errors->has('banner_logo') ? ' autofocus' : '' }}>
                                                                                                    <button class=""
                                                                                                            type="button">
                                                                                                        <label
                                                                                                            class="primary-btn small fix-gr-bg"
                                                                                                            for="file11">{{ __('common.Browse') }}</label>
                                                                                                        <input
                                                                                                            type="file"
                                                                                                            class="d-none fileUpload imgInput11"
                                                                                                            name="banner_logo"
                                                                                                            id="file11">
                                                                                                    </button>
                                                                                                </div>
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
                                                                                                       href="#element{{$block->id}}{{$language->code}}"
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
                                                                                             id="element{{$block->id}}{{$language->code}}">
                                                                                            <div class="row">
                                                                                                <div class="col-xl-12">
                                                                                                    <div
                                                                                                        class="primary_input mb-25">
                                                                                                        <label
                                                                                                            class="primary_input_label"
                                                                                                            for="">{{__('frontendmanage.Homepage Banner Title')}} </label>
                                                                                                        <input
                                                                                                            class="primary_input_field"
                                                                                                            {{ $errors->has('slider_title') ? ' autofocus' : '' }}
                                                                                                            placeholder="{{__('frontendmanage.Homepage Banner Title')}}"
                                                                                                            type="text"
                                                                                                            name="slider_title[{{$language->code}}]"
                                                                                                            value="{{isset($home_content)? getRawHomeContents($home_content,'slider_title',$language->code) : ''}}">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-xl-12">
                                                                                                    <div
                                                                                                        class="primary_input mb-25">
                                                                                                        <label
                                                                                                            class="primary_input_label"
                                                                                                            for="">{{ __('frontendmanage.Homepage Banner Text') }} </label>
                                                                                                        <input
                                                                                                            class="primary_input_field"
                                                                                                            placeholder="{{ __('frontendmanage.Homepage Banner Text') }}"
                                                                                                            type="text"
                                                                                                            name="slider_text[{{$language->code}}]"
                                                                                                            {{ $errors->has('slider_text') ? ' autofocus' : '' }}
                                                                                                            value="{{isset($home_content)? getRawHomeContents($home_content,'slider_text',$language->code) : ''}}">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($block->id==2)
                                                @if($currentTheme != "teachery")
                                                    <div data-id="{{$block->id}}" class="row">
                                                        <div class="accordion" id="accordionHomeContent">
                                                            <div class="card">
                                                                <div class="card-header" id="heading{{$block->id}}">
                                                                    <h2 class="mb-0">
                                                                        <button class="btn btn-block text-start"
                                                                                type="button" data-bs-toggle="collapse"
                                                                                data-bs-target="#collapse{{ $block->id }}"
                                                                                aria-expanded="true"
                                                                                aria-controls="collapse{{ $block->id }}">
                                                                            {{__('frontendmanage.Key Features Show In Homepage')}}

                                                                            <small class="text-danger">
                                                                                @if (@getRawHomeContents($home_content,'show_key_feature','en') == 1 && @getRawHomeContents($home_content,'show_category_section','en') != 1)
                                                                                    ({{__('frontendmanage.Category Section Show In Homepage')}}
                                                                                    {{__('frontend.is required')}})
                                                                                @endif
                                                                            </small>
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <div id="collapse{{ $block->id }}" class="collapse show"
                                                                     aria-labelledby="heading{{$block->id}}"
                                                                     data-parent="#accordionHomeContent">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-xl-12 ">
                                                                                <div class="mb_25">
                                                                                    <label class="switch_toggle "
                                                                                           for="key_feature_show">
                                                                                        <input type="checkbox"
                                                                                               class="status_enable_disable"
                                                                                               name="show_key_feature"
                                                                                               id="key_feature_show"
                                                                                               @if (@getRawHomeContents($home_content,'show_key_feature','en') == 1) checked
                                                                                               @endif value="1">
                                                                                        <i class="slider round"></i>


                                                                                    </label>
                                                                                    {{__('frontendmanage.Key Features Show In Homepage')}}
                                                                                </div>
                                                                            </div>


                                                                            <div id="keyFeatureBox"
                                                                                 class="col-md-12 text-center"
                                                                                 style="@if (@getRawHomeContents($home_content,'show_key_feature','en') == 0) display:none
                                                                                 @endif ">

                                                                                <div class="row col-xl-12">
                                                                                    <div class="col-xl-3 text-start">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            {{isset($home_content)? getRawHomeContents($home_content,'key_feature_title1',app()->getLocale()) : ''}}
                                                                                        </div>
                                                                                    </div>

                                                                                    @if($currentTheme!="Edume")
                                                                                        <div class="col-xl-3 text-start">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                {{isset($home_content)? getRawHomeContents($home_content,'key_feature_subtitle1',app()->getLocale()) : ''}}
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif

                                                                                    <div class="col-xl-3">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <img
                                                                                                style="max-width: 100%"
                                                                                                src="{{isset($home_content)? asset(getRawHomeContents($home_content,'key_feature_logo1','en')) : ''}} "
                                                                                                alt="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-3">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <button type="button"
                                                                                                    class="primary-btn radius_30px   fix-gr-bg"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#keyFeature1">
                                                                                                {{__('frontendmanage.Change')}}
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>


                                                                                <div class="row col-xl-12">
                                                                                    <div class="col-xl-3 text-start">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            {{isset($home_content)? getRawHomeContents($home_content,'course_page_sub_title',app()->getLocale()) : ''}}
                                                                                        </div>
                                                                                    </div>
                                                                                    @if($currentTheme!="Edume")
                                                                                        <div class="col-xl-3 text-start">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                {{isset($home_content)? getRawHomeContents($home_content,'key_feature_subtitle2',app()->getLocale()) : ''}}
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif

                                                                                    <div class="col-xl-3">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <img
                                                                                                style="max-width: 100%"
                                                                                                src="{{isset($home_content)? asset(getRawHomeContents($home_content,'key_feature_logo2','en')) : ''}} "
                                                                                                alt="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-3">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <button type="button"
                                                                                                    class="primary-btn radius_30px   fix-gr-bg"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#keyFeature2">
                                                                                                {{__('frontendmanage.Change')}}

                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>


                                                                                <div class="row col-xl-12">
                                                                                    <div class="col-xl-3 text-start">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            {{isset($home_content)? getRawHomeContents($home_content,'key_feature_title3',app()->getLocale()) : ''}}
                                                                                        </div>
                                                                                    </div>
                                                                                    @if($currentTheme!="Edume")
                                                                                        <div class="col-xl-3 text-start">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                {{isset($home_content)? getRawHomeContents($home_content,'key_feature_subtitle3',app()->getLocale()) : ''}}
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                    <div class="col-xl-3">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <img
                                                                                                style="max-width: 100%"
                                                                                                src="{{isset($home_content)? asset(getRawHomeContents($home_content,'key_feature_logo3','en')) : ''}} "
                                                                                                alt="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-3">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <button type="button"
                                                                                                    class="primary-btn radius_30px   fix-gr-bg"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#keyFeature3">
                                                                                                {{__('frontendmanage.Change')}}

                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-12">
                                                                            <div class="modal fade admin-query"
                                                                                 id="keyFeature1">
                                                                                <div
                                                                                    class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h4 class="modal-title">{{__('frontendmanage.Change Key Feature')}}
                                                                                                1 </h4>
                                                                                            <button type="button"
                                                                                                     class="btn-close"
                                                                                                    data-bs-dismiss="modal">
                                                                                                <i
                                                                                                    class="ti-close "></i>
                                                                                            </button>
                                                                                        </div>

                                                                                        <div
                                                                                            class="modal-body student-details header-menu">
                                                                                            <div class="row pt-0">
                                                                                                @if(isModuleActive('FrontendMultiLang'))
                                                                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                                        role="tablist">
                                                                                                        @foreach ($LanguageList as $key => $language)
                                                                                                            <li class="nav-item">
                                                                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                                                   href="#elementkey1{{$language->code}}"
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
                                                                                                         id="elementkey1{{$language->code}}">
                                                                                                        <div
                                                                                                            class="row">
                                                                                                            <div
                                                                                                                class="col-xl-12">
                                                                                                                <div
                                                                                                                    class="primary_input mb-25">
                                                                                                                    <label
                                                                                                                        class="primary_input_label"
                                                                                                                        for="">{{__('common.Title')}}</label>
                                                                                                                    <input
                                                                                                                        class="primary_input_field"
                                                                                                                        placeholder=""
                                                                                                                        type="text"
                                                                                                                        name="key_feature_title1[{{$language->code}}]"
                                                                                                                        {{ $errors->has('key_feature_title1') ? ' autofocus' : '' }}
                                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'key_feature_title1',$language->code) : ''}}">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            @if($currentTheme!="Edume")
                                                                                                                <div
                                                                                                                    class="col-xl-12">
                                                                                                                    <div
                                                                                                                        class="primary_input mb-25">
                                                                                                                        <label
                                                                                                                            class="primary_input_label"
                                                                                                                            for="">                                                                          {{__('frontendmanage.Change')}}
                                                                                                                            {{__('frontendmanage.Key Feature Subtitle')}}
                                                                                                                        </label>
                                                                                                                        <input
                                                                                                                            class="primary_input_field"
                                                                                                                            placeholder=""
                                                                                                                            type="text"
                                                                                                                            name="key_feature_subtitle1[{{$language->code}}]"
                                                                                                                            {{ $errors->has('key_feature_subtitle1') ? ' autofocus' : '' }}
                                                                                                                            value="{{isset($home_content)? getRawHomeContents($home_content,'key_feature_subtitle1',$language->code) : ''}}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>

                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{__('frontendmanage.Page Link')}}</label>

                                                                                                    <select
                                                                                                        class="primary_select   "
                                                                                                        name="key_feature_link1"
                                                                                                        {{$errors->has('host') ? 'autofocus' : ''}}
                                                                                                        id="">
                                                                                                        <option
                                                                                                            data-display="{{__('common.Select')}} {{__('frontendmanage.Page Link')}}"
                                                                                                            value="">{{__('common.Select')}} {{__('frontendmanage.Page Link')}}

                                                                                                        </option>
                                                                                                        @foreach($pages as $page)
                                                                                                            <option
                                                                                                                @if(getRawHomeContents($home_content,'key_feature_link1','en')==$page->id) selected
                                                                                                                @endif value="{{$page->id}}">

                                                                                                                {{$page->title}}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>

                                                                                                </div>
                                                                                            </div>


                                                                                            <div class="col-xl-12 mt-3">
                                                                                                <div
                                                                                                    class="primary_input mt_25 mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Key Feature Icon') }}
                                                                                                        1
                                                                                                    </label>
                                                                                                    <small>
                                                                                                        {{__('courses.Recommended Size')}}
                                                                                                        50x50 px
                                                                                                    </small>
                                                                                                    <div
                                                                                                        class="primary_file_uploader">
                                                                                                        <input
                                                                                                            class="primary-input  filePlaceholder "
                                                                                                            type="text"
                                                                                                            id=""
                                                                                                            placeholder="{{__('setting.Browse file')}}"
                                                                                                            readonly="">
                                                                                                        <button class=""
                                                                                                                type="button">
                                                                                                            <label
                                                                                                                class="primary-btn small fix-gr-bg"
                                                                                                                for="file6">{{ __('common.Browse') }}</label>
                                                                                                            <input
                                                                                                                type="file"
                                                                                                                class="d-none fileUpload imgInput6"
                                                                                                                name="key_feature_logo1"
                                                                                                                id="file6">
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mt_25 mb-25">
                                                                                                    <img
                                                                                                        class=" imagePreview6"
                                                                                                        style="max-width: 100%"
                                                                                                        src="{{ asset('/'.getRawHomeContents($home_content,'key_feature_logo1','en'))}}"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            </div>


                                                                                            <div
                                                                                                class="mt-40 d-flex justify-content-between">
                                                                                                <button type="button"
                                                                                                        class="primary-btn tr-bg"
                                                                                                        data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                                                                                <button
                                                                                                    class="primary-btn fix-gr-bg"
                                                                                                    type="submit">{{__('common.Submit')}}
                                                                                                </button>

                                                                                            </div>

                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal fade admin-query"
                                                                                 id="keyFeature2">
                                                                                <div
                                                                                    class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h4 class="modal-title">{{__('frontendmanage.Change Key Feature')}}
                                                                                                2 </h4>
                                                                                            <button type="button"
                                                                                                     class="btn-close"
                                                                                                    data-bs-dismiss="modal">
                                                                                                <i
                                                                                                    class="ti-close "></i>
                                                                                            </button>
                                                                                        </div>

                                                                                        <div class="modal-body">

                                                                                            <div class="row pt-0">
                                                                                                @if(isModuleActive('FrontendMultiLang'))
                                                                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                                        role="tablist">
                                                                                                        @foreach ($LanguageList as $key => $language)
                                                                                                            <li class="nav-item">
                                                                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                                                   href="#elementkey2{{$language->code}}"
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
                                                                                                         id="elementkey2{{$language->code}}">
                                                                                                        <div
                                                                                                            class="row">
                                                                                                            <div
                                                                                                                class="col-xl-12">
                                                                                                                <div
                                                                                                                    class="primary_input mb-25">
                                                                                                                    <label
                                                                                                                        class="primary_input_label"
                                                                                                                        for="">{{__('common.Title')}}</label>
                                                                                                                    <input
                                                                                                                        class="primary_input_field"
                                                                                                                        placeholder=""
                                                                                                                        type="text"
                                                                                                                        name="key_feature_title2[{{$language->code}}]"
                                                                                                                        {{ $errors->has('key_feature_title2') ? ' autofocus' : '' }}
                                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'key_feature_title2',$language->code) : ''}}">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            @if($currentTheme!="Edume")
                                                                                                                <div
                                                                                                                    class="col-xl-12">
                                                                                                                    <div
                                                                                                                        class="primary_input mb-25">
                                                                                                                        <label
                                                                                                                            class="primary_input_label"
                                                                                                                            for="">                                                                          {{__('frontendmanage.Change')}}
                                                                                                                            {{__('frontendmanage.Key Feature Subtitle')}}
                                                                                                                        </label>
                                                                                                                        <input
                                                                                                                            class="primary_input_field"
                                                                                                                            placeholder=""
                                                                                                                            type="text"
                                                                                                                            name="key_feature_subtitle2[{{$language->code}}]"
                                                                                                                            {{ $errors->has('key_feature_subtitle1') ? ' autofocus' : '' }}
                                                                                                                            value="{{isset($home_content)? getRawHomeContents($home_content,'key_feature_subtitle2',$language->code) : ''}}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{__('frontendmanage.Page Link')}}</label>

                                                                                                    <select
                                                                                                        class="primary_select   "
                                                                                                        name="key_feature_link2"
                                                                                                        {{$errors->has('host') ? 'autofocus' : ''}}
                                                                                                        id="">
                                                                                                        <option
                                                                                                            data-display="{{__('common.Select')}} {{__('frontendmanage.Page Link')}}"
                                                                                                            value="">{{__('common.Select')}} {{__('frontendmanage.Page Link')}}

                                                                                                        </option>
                                                                                                        @foreach($pages as $page)
                                                                                                            <option
                                                                                                                @if(getRawHomeContents($home_content,'key_feature_link2','en')==$page->id) selected
                                                                                                                @endif
                                                                                                                value="{{$page->id}}">
                                                                                                                {{$page->title}}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>

                                                                                                </div>
                                                                                            </div>

                                                                                            <div
                                                                                                class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mt_25 mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Key Feature Icon') }}
                                                                                                        2
                                                                                                    </label>
                                                                                                    <small>
                                                                                                        {{__('courses.Recommended Size')}}
                                                                                                        50x50 px
                                                                                                    </small>
                                                                                                    <div
                                                                                                        class="primary_file_uploader">
                                                                                                        <input
                                                                                                            class="primary-input  filePlaceholder"
                                                                                                            type="text"
                                                                                                            id=""
                                                                                                            placeholder="{{__('setting.Browse file')}}"
                                                                                                            readonly="">
                                                                                                        <button
                                                                                                            class=""
                                                                                                            type="button">
                                                                                                            <label
                                                                                                                class="primary-btn small fix-gr-bg"
                                                                                                                for="file7">{{ __('common.Browse') }}</label>
                                                                                                            <input
                                                                                                                type="file"
                                                                                                                class="d-none fileUpload imgInput7"
                                                                                                                name="key_feature_logo2"
                                                                                                                id="file7">
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mt_25 mb-25">
                                                                                                    <img
                                                                                                        class=" imagePreview7"
                                                                                                        style="max-width: 100%"
                                                                                                        src="{{ asset('/'.getRawHomeContents($home_content,'key_feature_logo2','en'))}}"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            </div>


                                                                                            <div
                                                                                                class="mt-40 d-flex justify-content-between">
                                                                                                <button
                                                                                                    type="button"
                                                                                                    class="primary-btn tr-bg"
                                                                                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                                                                                <button
                                                                                                    class="primary-btn fix-gr-bg"
                                                                                                    type="submit">{{__('common.Submit')}}
                                                                                                </button>

                                                                                            </div>

                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal fade admin-query"
                                                                                 id="keyFeature3">
                                                                                <div
                                                                                    class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h4 class="modal-title">{{__('frontendmanage.Change Key Feature')}}
                                                                                                3 </h4>
                                                                                            <button type="button"
                                                                                                     class="btn-close"
                                                                                                    data-bs-dismiss="modal">
                                                                                                <i
                                                                                                    class="ti-close "></i>
                                                                                            </button>
                                                                                        </div>

                                                                                        <div class="modal-body">
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
                                                                                            <div
                                                                                                class="tab-content">
                                                                                                @foreach ($LanguageList as $key => $language)
                                                                                                    <div
                                                                                                        role="tabpanel"
                                                                                                        class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                                                                        id="element{{$language->code}}">
                                                                                                        <div
                                                                                                            class="row">
                                                                                                            <div
                                                                                                                class="col-xl-12">
                                                                                                                <div
                                                                                                                    class="primary_input mb-25">
                                                                                                                    <label
                                                                                                                        class="primary_input_label"
                                                                                                                        for="">{{__('common.Title')}}</label>
                                                                                                                    <input
                                                                                                                        class="primary_input_field"
                                                                                                                        placeholder=""
                                                                                                                        type="text"
                                                                                                                        name="key_feature_title3[{{$language->code}}]"
                                                                                                                        {{ $errors->has('key_feature_title3') ? ' autofocus' : '' }}
                                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'key_feature_title3',$language->code) : ''}}">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            @if($currentTheme!="Edume")
                                                                                                                <div
                                                                                                                    class="col-xl-12">
                                                                                                                    <div
                                                                                                                        class="primary_input mb-25">
                                                                                                                        <label
                                                                                                                            class="primary_input_label"
                                                                                                                            for="">                                                                          {{__('frontendmanage.Change')}}
                                                                                                                            {{__('frontendmanage.Key Feature Subtitle')}}
                                                                                                                        </label>
                                                                                                                        <input
                                                                                                                            class="primary_input_field"
                                                                                                                            placeholder=""
                                                                                                                            type="text"
                                                                                                                            name="key_feature_subtitle3[{{$language->code}}]"
                                                                                                                            {{ $errors->has('key_feature_subtitle3') ? ' autofocus' : '' }}
                                                                                                                            value="{{isset($home_content)? getRawHomeContents($home_content,'key_feature_subtitle3',$language->code) : ''}}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{__('frontendmanage.Page Link')}}</label>

                                                                                                    <select
                                                                                                        class="primary_select   "
                                                                                                        name="key_feature_link3"
                                                                                                        {{$errors->has('host') ? 'autofocus' : ''}}
                                                                                                        id="">
                                                                                                        <option
                                                                                                            data-display="{{__('common.Select')}} {{__('frontendmanage.Page Link')}}"
                                                                                                            value="">{{__('common.Select')}} {{__('frontendmanage.Page Link')}}

                                                                                                        </option>
                                                                                                        @foreach($pages as $page)
                                                                                                            <option
                                                                                                                @if(getRawHomeContents($home_content,'key_feature_link3','en')==$page->id) selected
                                                                                                                @endif
                                                                                                                value=" {{$page->id}}">

                                                                                                                {{$page->title}}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>

                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mt_25 mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Key Feature Icon') }}
                                                                                                        3
                                                                                                    </label>
                                                                                                    <small>
                                                                                                        {{__('courses.Recommended Size')}}
                                                                                                        50x50 px
                                                                                                    </small>
                                                                                                    <div
                                                                                                        class="primary_file_uploader">
                                                                                                        <input
                                                                                                            class="primary-input  filePlaceholder {{ @$errors->has('instructor_banner') ? ' is-invalid' : '' }}"
                                                                                                            type="text"
                                                                                                            id=""
                                                                                                            placeholder="{{__('setting.Browse file')}}"
                                                                                                            readonly="" {{ $errors->has('instructor_banner') ? ' autofocus' : '' }}>
                                                                                                        <button
                                                                                                            class=""
                                                                                                            type="button">
                                                                                                            <label
                                                                                                                class="primary-btn small fix-gr-bg"
                                                                                                                for="file8">{{ __('common.Browse') }}</label>
                                                                                                            <input
                                                                                                                type="file"
                                                                                                                class="d-none fileUpload imgInput8"
                                                                                                                name="key_feature_logo3"
                                                                                                                id="file8">
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mt_25 mb-25">
                                                                                                    <img
                                                                                                        class=" imagePreview8"
                                                                                                        style="max-width: 100%"
                                                                                                        src="{{ asset('/'.getRawHomeContents($home_content,'key_feature_logo3','en'))}}"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            </div>


                                                                                            <div
                                                                                                class="mt-40 d-flex justify-content-between">
                                                                                                <button
                                                                                                    type="button"
                                                                                                    class="primary-btn tr-bg"
                                                                                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                                                                                <button
                                                                                                    class="primary-btn fix-gr-bg"
                                                                                                    type="submit">{{__('common.Submit')}}
                                                                                                </button>

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
                                                    </div>
                                                @endif
                                            @elseif($block->id==3)
                                                @if($currentTheme=="infixlmstheme" || $currentTheme=='tvt' || $currentTheme=="teachery")
                                                    <div data-id="{{$block->id}}" class="row">
                                                        <div class="accordion" id="accordionHomeContent">
                                                            <div class="card">
                                                                <div class="card-header"
                                                                     id="heading{{ $block->id }}">
                                                                    <h2 class="mb-0">
                                                                        <button
                                                                            class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                            {{__('frontendmanage.Category Section Show In Homepage')}}
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <div id="collapse{{ $block->id }}"
                                                                     class="collapse show"
                                                                     aria-labelledby="heading{{ $block->id }}"
                                                                     data-parent="#accordionHomeContent">
                                                                    <div class="card-body">
                                                                        <div class="col-xl-12 ">
                                                                            <div class="mb_25">
                                                                                <label
                                                                                    class="switch_toggle "
                                                                                    for="show_category_section">
                                                                                    <input type="checkbox"
                                                                                           class="status_enable_disable"
                                                                                           name="show_category_section"
                                                                                           id="show_category_section"
                                                                                           @if (@getRawHomeContents($home_content,'show_category_section','en') == 1) checked
                                                                                           @endif value="1">
                                                                                    <i class="slider round"></i>


                                                                                </label>
                                                                                {{__('frontendmanage.Category Section Show In Homepage')}}

                                                                            </div>
                                                                            <div
                                                                                id="show_category_section_box"
                                                                                class="col-md-12"
                                                                                style="@if (@getRawHomeContents($home_content,'show_category_section','en') == 0) display:none
                                                                                @endif ">
                                                                                <div class="row pt-0">
                                                                                    @if(isModuleActive('FrontendMultiLang'))
                                                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                            role="tablist">
                                                                                            @foreach ($LanguageList as $key => $language)
                                                                                                <li class="nav-item">
                                                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                                       href="#elementblock3{{$language->code}}"
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
                                                                                             id="elementblock3{{$language->code}}">
                                                                                            <div class="row">
                                                                                                <div class="col-xl-12">
                                                                                                    <div
                                                                                                        class="primary_input mb-25">
                                                                                                        <label
                                                                                                            class="primary_input_label"
                                                                                                            for="">{{ __('frontendmanage.Category Title') }}
                                                                                                        </label>
                                                                                                        <input
                                                                                                            class="primary_input_field"
                                                                                                            placeholder="{{ __('frontendmanage.Category Title') }}"
                                                                                                            type="text"
                                                                                                            name="category_title[{{$language->code}}]"
                                                                                                            {{ $errors->has('category_title') ? ' autofocus' : '' }}
                                                                                                            value="{{isset($home_content)? getRawHomeContents($home_content,'category_title',$language->code) : ''}}">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-xl-12">
                                                                                                    <div
                                                                                                        class="primary_input mb-25">
                                                                                                        <label
                                                                                                            class="primary_input_label"
                                                                                                            for="">{{ __('frontendmanage.Category Sub Title') }}</label>
                                                                                                        <input
                                                                                                            class="primary_input_field"
                                                                                                            placeholder="{{ __('frontendmanage.Category Sub Title') }}"
                                                                                                            type="text"
                                                                                                            name="category_sub_title[{{$language->code}}]"
                                                                                                            {{ $errors->has('category_sub_title') ? ' autofocus' : '' }}
                                                                                                            value="{{isset($home_content)? getRawHomeContents($home_content,'category_sub_title',$language->code) : ''}}">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @elseif($block->id==4)
                                                @if($currentTheme=="infixlmstheme" || $currentTheme=="teachery")
                                                    <div data-id="{{$block->id}}" class="row">
                                                        <div class="accordion" id="accordionHomeContent">
                                                            <div class="card">
                                                                <div class="card-header"
                                                                     id="heading{{ $block->id }}">
                                                                    <h2 class="mb-0">
                                                                        <button
                                                                            class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                            {{__('frontendmanage.Instructor Section Show In Homepage')}}
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <div id="collapse{{ $block->id }}"
                                                                     class="collapse show"
                                                                     aria-labelledby="heading{{ $block->id }}"
                                                                     data-parent="#accordionHomeContent">
                                                                    <div class="card-body">
                                                                        <div class="col-xl-12 ">
                                                                            <div class="mb_25">
                                                                                <label
                                                                                    class="switch_toggle "
                                                                                    for="show_instructor_section">
                                                                                    <input type="checkbox"
                                                                                           class="status_enable_disable"
                                                                                           name="show_instructor_section"
                                                                                           id="show_instructor_section"
                                                                                           @if (@getRawHomeContents($home_content,'show_instructor_section','en') == 1) checked
                                                                                           @endif value="1">
                                                                                    <i class="slider round"></i>


                                                                                </label>
                                                                                {{__('frontendmanage.Instructor Section Show In Homepage')}}

                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            id="show_instructor_section_box"
                                                                            class="col-md-12"
                                                                            style="@if (@getRawHomeContents($home_content,'show_instructor_section','en') == 0) display:none
                                                                            @endif ">
                                                                            <div class="row">
                                                                                @if($currentTheme != "teachery")
                                                                                    <div class="col-xl-4">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <img
                                                                                                class=" imagePreview1"
                                                                                                style="max-width: 100%"
                                                                                                src="{{ asset('/'.getRawHomeContents($home_content,'instructor_banner','en'))}}"
                                                                                                alt="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-8">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <label
                                                                                                class="primary_input_label"
                                                                                                for="">{{ __('frontendmanage.Instructor  Banner') }}
                                                                                                <small>({{__('common.Recommended Size')}}
                                                                                                    1920x500)</small>
                                                                                            </label>
                                                                                            <div
                                                                                                class="primary_file_uploader">
                                                                                                <input
                                                                                                    class="primary-input  filePlaceholder {{ @$errors->has('instructor_banner') ? ' is-invalid' : '' }}"
                                                                                                    type="text"
                                                                                                    id=""
                                                                                                    placeholder="{{__('setting.Browse file')}}"
                                                                                                    readonly="" {{ $errors->has('instructor_banner') ? ' autofocus' : '' }}>
                                                                                                <button class=""
                                                                                                        type="button">
                                                                                                    <label
                                                                                                        class="primary-btn small fix-gr-bg"
                                                                                                        for="file1">{{ __('common.Browse') }}</label>
                                                                                                    <input
                                                                                                        type="file"
                                                                                                        class="d-none fileUpload imgInput1"
                                                                                                        name="instructor_banner"
                                                                                                        id="file1">
                                                                                                </button>
                                                                                            </div>
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
                                                                                                   href="#elementblock5{{$language->code}}"
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
                                                                                         id="elementblock5{{$language->code}}">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Instructor Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Instructor Title') }}"
                                                                                                        type="text"
                                                                                                        name="instructor_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('instructor_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'instructor_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Instructor Sub Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Instructor Sub Title') }}"
                                                                                                        type="text"
                                                                                                        name="instructor_sub_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('instructor_sub_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'instructor_sub_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                @endif
                                            @elseif($block->id==6)
                                                <div data-id="{{$block->id}}" class="row">
                                                    <div class="accordion" id="accordionHomeContent">
                                                        <div class="card">
                                                            <div class="card-header"
                                                                 id="heading{{ $block->id }}">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                        {{__('frontendmanage.Best Category Section Show In Homepage')}}
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div id="collapse{{ $block->id }}"
                                                                 class="collapse show"
                                                                 aria-labelledby="heading{{ $block->id }}"
                                                                 data-parent="#accordionHomeContent">
                                                                <div class="card-body">
                                                                    <div class="col-xl-12 ">
                                                                        <div class="mb_25">
                                                                            <label class="switch_toggle "
                                                                                   for="show_best_category_section">
                                                                                <input type="checkbox"
                                                                                       class="status_enable_disable"
                                                                                       name="show_best_category_section"
                                                                                       id="show_best_category_section"
                                                                                       @if (@getRawHomeContents($home_content,'show_best_category_section','en') == 1) checked
                                                                                       @endif value="1">
                                                                                <i class="slider round"></i>


                                                                            </label>
                                                                            {{__('frontendmanage.Best Category Section Show In Homepage')}}

                                                                        </div>
                                                                    </div>
                                                                    <div id="show_best_category_section_box"
                                                                         class="col-md-12"
                                                                         style="@if (@getRawHomeContents($home_content,'show_best_category_section','en') == 0) display:none
                                                                         @endif ">
                                                                        <div class="row">
                                                                            @if($currentTheme=="infixlmstheme")
                                                                                <div class="col-xl-4">
                                                                                    <div
                                                                                        class="primary_input mb-25">

                                                                                        <img
                                                                                            class="  imagePreview2"
                                                                                            style="max-width: 100%"
                                                                                            src="{{asset('/'.getRawHomeContents($home_content,'best_category_banner','en'))}}"
                                                                                            alt="">

                                                                                    </div>
                                                                                </div>
                                                                            @endif

                                                                            <div class="col-xl-8">
                                                                                <div
                                                                                    class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="">{{ __('frontendmanage.Best Category  Banner') }}
                                                                                        <small>({{__('common.Recommended Size')}}
                                                                                            1920x500)</small>
                                                                                    </label>
                                                                                    <div
                                                                                        class="primary_file_uploader">
                                                                                        <input
                                                                                            class="primary-input  filePlaceholder {{ @$errors->has('best_category_banner') ? ' is-invalid' : '' }}"
                                                                                            type="text"
                                                                                            id=""
                                                                                            placeholder="{{__('setting.Browse file')}}"
                                                                                            readonly="" {{ $errors->has('best_category_banner') ? ' autofocus' : '' }}>
                                                                                        <button class=""
                                                                                                type="button">
                                                                                            <label
                                                                                                class="primary-btn small fix-gr-bg"
                                                                                                for="file2">{{ __('common.Browse') }}</label>
                                                                                            <input
                                                                                                type="file"
                                                                                                class="d-none imgInput2"
                                                                                                name="best_category_banner"
                                                                                                id="file2">
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row pt-0">
                                                                            @if(isModuleActive('FrontendMultiLang'))
                                                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                    role="tablist">
                                                                                    @foreach ($LanguageList as $key => $language)
                                                                                        <li class="nav-item">
                                                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                               href="#elementblock6{{$language->code}}"
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
                                                                                     id="elementblock6{{$language->code}}">
                                                                                    <div class="row">
                                                                                        <div class="col-xl-12">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                <label
                                                                                                    class="primary_input_label"
                                                                                                    for="">{{ __('frontendmanage.Best Course Title') }}</label>
                                                                                                <input
                                                                                                    class="primary_input_field"
                                                                                                    placeholder="{{ __('frontendmanage.Best Course Title') }}"
                                                                                                    type="text"
                                                                                                    name="best_category_title[{{$language->code}}]"
                                                                                                    {{ $errors->has('course_title') ? ' autofocus' : '' }}
                                                                                                    value="{{isset($home_content)? getRawHomeContents($home_content,'best_category_title',$language->code) : ''}}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-xl-12">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                <label
                                                                                                    class="primary_input_label"
                                                                                                    for="">{{ __('frontendmanage.Best Course Sub Title') }}</label>
                                                                                                <input
                                                                                                    class="primary_input_field"
                                                                                                    placeholder="{{ __('frontendmanage.Best Course Sub Title') }}"
                                                                                                    type="text"
                                                                                                    name="best_category_sub_title[{{$language->code}}]"
                                                                                                    {{ $errors->has('best_category_sub_title') ? ' autofocus' : '' }}
                                                                                                    value="{{isset($home_content)? getRawHomeContents($home_content,'best_category_sub_title',$language->code) : ''}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                            @elseif($block->id==13)
                                                @if($currentTheme!='infixlmstheme')
                                                    <div data-id="{{$block->id}}" class="row">
                                                        <div class="accordion" id="accordionHomeContent">
                                                            <div class="card">
                                                                <div class="card-header"
                                                                     id="heading{{ $block->id }}">
                                                                    <h2 class="mb-0">
                                                                        <button
                                                                            class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">

                                                                            {{__('frontendmanage.Live Class Section Show In Homepage')}}
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <div id="collapse{{ $block->id }}"
                                                                     class="collapse show"
                                                                     aria-labelledby="heading{{ $block->id }}"
                                                                     data-parent="#accordionHomeContent">
                                                                    <div class="card-body">
                                                                        <div class="col-xl-12 ">
                                                                            <div class="mb_25">
                                                                                <label
                                                                                    class="switch_toggle "
                                                                                    for="show_live_class_section">
                                                                                    <input type="checkbox"
                                                                                           class="status_enable_disable"
                                                                                           name="show_live_class_section"
                                                                                           id="show_live_class_section"
                                                                                           @if (@getRawHomeContents($home_content,'show_live_class_section','en') == 1) checked
                                                                                           @endif value="1">
                                                                                    <i class="slider round"></i>


                                                                                </label>
                                                                                {{__('frontendmanage.Live Class Section Show In Homepage')}}

                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            id="show_live_class_section_box"
                                                                            class="col-md-12"
                                                                            style="@if (@getRawHomeContents($home_content,'show_live_class_section','en') == 0) display:none
                                                                            @endif ">
                                                                            <div class="row pt-0">
                                                                                @if(isModuleActive('FrontendMultiLang'))
                                                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                        role="tablist">
                                                                                        @foreach ($LanguageList as $key => $language)
                                                                                            <li class="nav-item">
                                                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                                   href="#elementblock13{{$language->code}}"
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
                                                                                         id="elementblock13{{$language->code}}">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Live Class Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Live Class Title') }}"
                                                                                                        type="text"
                                                                                                        name="live_class_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('live_class_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'live_class_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="live_class_sub_title">{{ __('frontendmanage.Live Class Sub Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Live Class Sub Title') }}"
                                                                                                        type="text"
                                                                                                        name="live_class_sub_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('live_class_sub_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'live_class_sub_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @elseif($block->id==14 && $currentTheme=='compact')
                                                <div data-id="{{$block->id}}" class="row">
                                                    <div class="accordion" id="accordionHomeContent">
                                                        <div class="card">
                                                            <div class="card-header"
                                                                 id="heading{{ $block->id }}">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                        {{__('frontendmanage.About LMS Section Show In Homepage')}}
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div id="collapse{{ $block->id }}"
                                                                 class="collapse show"
                                                                 aria-labelledby="heading{{ $block->id }}"
                                                                 data-parent="#accordionHomeContent">
                                                                <div class="card-body">
                                                                    <div class="col-xl-12 ">
                                                                        <div class="mb_25">
                                                                            <label class="switch_toggle "
                                                                                   for="show_about_lms_section">
                                                                                <input type="checkbox"
                                                                                       class="status_enable_disable"
                                                                                       name="show_about_lms_section"
                                                                                       id="show_about_lms_section"
                                                                                       @if (@getRawHomeContents($home_content,'show_about_lms_section','en') == 1) checked
                                                                                       @endif value="1">
                                                                                <i class="slider round"></i>


                                                                            </label>
                                                                            {{__('frontendmanage.About LMS Section Show In Homepage')}}

                                                                        </div>
                                                                    </div>
                                                                    <div id="show_about_lms_section_box"
                                                                         class="col-md-12"
                                                                         style="@if (@getRawHomeContents($home_content,'show_about_lms_section','en') == 0) display:none
                                                                         @endif ">
                                                                        <div class="row pt-0">
                                                                            @if(isModuleActive('FrontendMultiLang'))
                                                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                    role="tablist">
                                                                                    @foreach ($LanguageList as $key => $language)
                                                                                        <li class="nav-item">
                                                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                               href="#elementblock14{{$language->code}}"
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
                                                                                     id="elementblock14{{$language->code}}">
                                                                                    <div class="row">
                                                                                        <div class="col-xl-12">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                <label
                                                                                                    class="primary_input_label"
                                                                                                    for="">
                                                                                                    Title</label>
                                                                                                <input
                                                                                                    class="primary_input_field"
                                                                                                    placeholder="About LMS Title"
                                                                                                    type="text"
                                                                                                    name="about_lms_title[{{$language->code}}]"
                                                                                                    {{ $errors->has('about_lms_title') ? ' autofocus' : '' }}
                                                                                                    value="{{isset($home_content)? getRawHomeContents($home_content,'about_lms_title',$language->code) : ''}}">
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-xl-12">
                                                                                            <div class="input-effect">
                                                                                    <textarea
                                                                                        class="primary-input form-control"
                                                                                        cols="0" rows="4"
                                                                                        name="about_lms[{{$language->code}}]">{{isset($home_content)? getRawHomeContents($home_content,'about_lms',$language->code) : ''}}</textarea>
                                                                                                <label class="primary_input_label mt-1">Description
                                                                                                    <span class="required_mark">*</span>
                                                                                                </label>
                                                                                                <span
                                                                                                    class="focus-border textarea"></span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                {{--                                            @elseif($block->id==15 && isModuleActive('Subscription') && $currentTheme=='compact')--}}
                                            @elseif($block->id==15)
                                                @if($currentTheme != "teachery" &&  $currentTheme != "wetech" &&  $currentTheme != "edume")
                                                    <div data-id="{{$block->id}}" class="row">
                                                        <div class="accordion" id="accordionHomeContent">
                                                            <div class="card">
                                                                <div class="card-header"
                                                                     id="heading{{ $block->id }}">
                                                                    <h2 class="mb-0">
                                                                        <button class="btn btn-block text-start"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#collapse{{ $block->id }}"
                                                                                aria-expanded="true"
                                                                                aria-controls="collapse{{ $block->id }}">
                                                                            {{__('frontendmanage.Subscription Section Show In Homepage')}}
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <div id="collapse{{ $block->id }}"
                                                                     class="collapse show"
                                                                     aria-labelledby="heading{{ $block->id }}"
                                                                     data-parent="#accordionHomeContent">
                                                                    <div class="card-body">
                                                                        <div class="col-xl-12 ">
                                                                            <div class="mb_25">
                                                                                <label class="switch_toggle "
                                                                                       for="show_subscription_plan">
                                                                                    <input type="checkbox"
                                                                                           class="status_enable_disable"
                                                                                           name="show_subscription_plan"
                                                                                           id="show_subscription_plan"
                                                                                           @if (@getRawHomeContents($home_content,'show_subscription_plan','en') == 1) checked
                                                                                           @endif value="1">
                                                                                    <i class="slider round"></i>


                                                                                </label>
                                                                                {{__('frontendmanage.Subscription Section Show In Homepage')}}

                                                                            </div>
                                                                        </div>

                                                                        <div id="show_subscription_plan_box"
                                                                             class="col-md-12"
                                                                             style="@if (@getRawHomeContents($home_content,'show_subscription_plan','en') == 0) display:none
                                                                             @endif ">
                                                                            <div class="row pt-0">
                                                                                @if(isModuleActive('FrontendMultiLang'))
                                                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                        role="tablist">
                                                                                        @foreach ($LanguageList as $key => $language)
                                                                                            <li class="nav-item">
                                                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                                   href="#elementblock15{{$language->code}}"
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
                                                                                         id="elementblock15{{$language->code}}">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Subscription Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Subscription Title') }}"
                                                                                                        type="text"
                                                                                                        name="subscription_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('subscription_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'subscription_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Subscription Sub Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Subscription Sub Title') }}"
                                                                                                        type="text"
                                                                                                        name="subscription_sub_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('subscription_sub_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'subscription_sub_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endif
                                                {{-- End Compact Theme --}}

                                            @elseif($block->id==5)
                                                <div data-id="{{$block->id}}" class="row">
                                                    <div class="accordion" id="accordionHomeContent">
                                                        <div class="card">
                                                            <div class="card-header"
                                                                 id="heading{{ $block->id }}">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                        {{__('frontendmanage.Course Section Show In Homepage')}}
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div id="collapse{{ $block->id }}"
                                                                 class="collapse show"
                                                                 aria-labelledby="heading{{ $block->id }}"
                                                                 data-parent="#accordionHomeContent">
                                                                <div class="card-body">
                                                                    <div class="col-xl-12 ">
                                                                        <div class="mb_25">
                                                                            <label class="switch_toggle "
                                                                                   for="show_course_section">
                                                                                <input type="checkbox"
                                                                                       class="status_enable_disable"
                                                                                       name="show_course_section"
                                                                                       id="show_course_section"
                                                                                       @if (@getRawHomeContents($home_content,'show_course_section','en') == 1) checked
                                                                                       @endif value="1">
                                                                                <i class="slider round"></i>


                                                                            </label>
                                                                            {{__('frontendmanage.Course Section Show In Homepage')}}

                                                                        </div>
                                                                    </div>

                                                                    <div id="show_course_section_box"
                                                                         class="col-md-12 test"
                                                                         style="@if (@getRawHomeContents($home_content,'show_course_section','en') == 0) display:none
                                                                         @endif ">
                                                                        <div class="row pt-0">
                                                                            @if(isModuleActive('FrontendMultiLang'))
                                                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                    role="tablist">
                                                                                    @foreach ($LanguageList as $key => $language)
                                                                                        <li class="nav-item">
                                                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                               href="#elementblock5{{$language->code}}"
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
                                                                                     id="elementblock5{{$language->code}}">
                                                                                    <div class="row">
                                                                                        <div class="col-xl-12">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                <label
                                                                                                    class="primary_input_label"
                                                                                                    for="">{{ __('frontendmanage.Course Title') }}</label>
                                                                                                <input
                                                                                                    class="primary_input_field"
                                                                                                    placeholder="{{ __('frontendmanage.Course Title') }}"
                                                                                                    type="text"
                                                                                                    name="course_title[{{$language->code}}]"
                                                                                                    {{ $errors->has('course_title') ? ' autofocus' : '' }}
                                                                                                    value="{{isset($home_content)? getRawHomeContents($home_content,'course_title',$language->code) : ''}}">
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-xl-12">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                <label
                                                                                                    class="primary_input_label"
                                                                                                    for="">{{ __('frontendmanage.Course Sub Title') }}</label>
                                                                                                <input
                                                                                                    class="primary_input_field"
                                                                                                    placeholder="{{ __('frontendmanage.Course Sub Title') }}"
                                                                                                    type="text"
                                                                                                    name="course_sub_title[{{$language->code}}]"
                                                                                                    {{ $errors->has('instructor_title') ? ' autofocus' : '' }}
                                                                                                    value="{{isset($home_content)? getRawHomeContents($home_content,'course_sub_title',$language->code) : ''}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($block->id==7)
                                                <div data-id="{{$block->id}}" class="row">
                                                    <div class="accordion" id="accordionHomeContent">
                                                        <div class="card">
                                                            <div class="card-header"
                                                                 id="heading{{ $block->id }}">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                        {{__('frontendmanage.Quiz Section Show In Homepage')}}
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div id="collapse{{ $block->id }}"
                                                                 class="collapse show"
                                                                 aria-labelledby="heading{{ $block->id }}"
                                                                 data-parent="#accordionHomeContent">
                                                                <div class="card-body">
                                                                    <div class="col-xl-12 ">
                                                                        <div class="mb_25">
                                                                            <label class="switch_toggle "
                                                                                   for="show_quiz_section">
                                                                                <input type="checkbox"
                                                                                       class="status_enable_disable"
                                                                                       name="show_quiz_section"
                                                                                       id="show_quiz_section"
                                                                                       @if (@getRawHomeContents($home_content,'show_quiz_section','en') == 1) checked
                                                                                       @endif value="1">
                                                                                <i class="slider round"></i>


                                                                            </label>
                                                                            {{__('frontendmanage.Quiz Section Show In Homepage')}}

                                                                        </div>
                                                                    </div>

                                                                    <div id="show_quiz_section_box"
                                                                         class="col-md-12"
                                                                         style="@if (@getRawHomeContents($home_content,'show_quiz_section','en') == 0) display:none
                                                                         @endif ">

                                                                        <div class="row pt-0">
                                                                            @if(isModuleActive('FrontendMultiLang'))
                                                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                    role="tablist">
                                                                                    @foreach ($LanguageList as $key => $language)
                                                                                        <li class="nav-item">
                                                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                               href="#elementblock7{{$language->code}}"
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
                                                                                     id="elementblock7{{$language->code}}">
                                                                                    <div class="row">
                                                                                        <div class="col-xl-12">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                <label
                                                                                                    class="primary_input_label"
                                                                                                    for="">{{ __('frontendmanage.Quiz Title') }}</label>
                                                                                                <input
                                                                                                    class="primary_input_field"
                                                                                                    placeholder="{{ __('frontendmanage.Quiz Title') }}"
                                                                                                    type="text"
                                                                                                    name="quiz_title[{{$language->code}}]"
                                                                                                    {{ $errors->has('quiz_title') ? ' autofocus' : '' }}
                                                                                                    value="{{isset($home_content)? getRawHomeContents($home_content,'quiz_title',$language->code) : ''}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-xl-12">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                <label
                                                                                                    class="primary_input_label"
                                                                                                    for="">{{ __('frontendmanage.Quiz Sub Title') }}</label>
                                                                                                <input
                                                                                                    class="primary_input_field"
                                                                                                    placeholder="{{ __('frontendmanage.Quiz Sub Title') }}"
                                                                                                    type="text"
                                                                                                    name="quiz_sub_title[{{$language->code}}]"
                                                                                                    {{ $errors->has('quiz_sub_title') ? ' autofocus' : '' }}
                                                                                                    value="{{isset($home_content)? getRawHomeContents($home_content,'quiz_sub_title',$language->code) : ''}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @elseif($block->id==8)
                                                @if($currentTheme=="infixlmstheme")
                                                    <div data-id="{{$block->id}}" class="row">
                                                        <div class="accordion" id="accordionHomeContent">
                                                            <div class="card">
                                                                <div class="card-header"
                                                                     id="heading{{ $block->id }}">
                                                                    <h2 class="mb-0">
                                                                        <button
                                                                            class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                            {{__('frontendmanage.Testimonial Section Show In Homepage')}}
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <div id="collapse{{ $block->id }}"
                                                                     class="collapse show"
                                                                     aria-labelledby="heading{{ $block->id }}"
                                                                     data-parent="#accordionHomeContent">
                                                                    <div class="card-body">
                                                                        <div class="col-xl-12 ">
                                                                            <div class="mb_25">
                                                                                <label
                                                                                    class="switch_toggle "
                                                                                    for="show_testimonial_section">
                                                                                    <input type="checkbox"
                                                                                           class="status_enable_disable"
                                                                                           name="show_testimonial_section"
                                                                                           id="show_testimonial_section"
                                                                                           @if (@getRawHomeContents($home_content,'show_testimonial_section','en') == 1) checked
                                                                                           @endif value="1">
                                                                                    <i class="slider round"></i>
                                                                                </label>
                                                                                {{__('frontendmanage.Testimonial Section Show In Homepage')}}

                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            id="show_testimonial_section_box"
                                                                            class="col-md-12"
                                                                            style="@if (@getRawHomeContents($home_content,'show_testimonial_section','en') == 0) display:none
                                                                            @endif ">

                                                                            <div class="row pt-0">
                                                                                @if(isModuleActive('FrontendMultiLang'))
                                                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                        role="tablist">
                                                                                        @foreach ($LanguageList as $key => $language)
                                                                                            <li class="nav-item">
                                                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                                   href="#elementblock8{{$language->code}}"
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
                                                                                         id="elementblock8{{$language->code}}">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Testimonial Title') }}
                                                                                                    </label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Testimonial Title') }}"
                                                                                                        type="text"
                                                                                                        name="testimonial_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('testimonial_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'testimonial_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Testimonial Sub Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Testimonial Sub Title') }}"
                                                                                                        type="text"
                                                                                                        name="testimonial_sub_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('testimonial_sub_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'testimonial_sub_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @elseif($block->id==10)
                                                <div data-id="{{$block->id}}" class="row">
                                                    <div class="accordion" id="accordionHomeContent">
                                                        <div class="card">
                                                            <div class="card-header"
                                                                 id="heading{{ $block->id }}">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                        {{__('frontendmanage.Article Section Show In Homepage')}}
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div id="collapse{{ $block->id }}"
                                                                 class="collapse show"
                                                                 aria-labelledby="heading{{ $block->id }}"
                                                                 data-parent="#accordionHomeContent">
                                                                <div class="card-body">
                                                                    <div class="col-xl-12 ">
                                                                        <div class="mb_25">
                                                                            <label class="switch_toggle "
                                                                                   for="show_article_section">
                                                                                <input type="checkbox"
                                                                                       class="status_enable_disable"
                                                                                       name="show_article_section"
                                                                                       id="show_article_section"
                                                                                       @if (@getRawHomeContents($home_content,'show_article_section','en') == 1) checked
                                                                                       @endif value="1">
                                                                                <i class="slider round"></i>


                                                                            </label>
                                                                            {{__('frontendmanage.Article Section Show In Homepage')}}

                                                                        </div>
                                                                    </div>
                                                                    <div id="show_article_section_box"
                                                                         class="col-md-12"
                                                                         style="@if (@getRawHomeContents($home_content,'show_article_section','en') == 0) display:none
                                                                         @endif ">

                                                                        <div class="row pt-0">
                                                                            @if(isModuleActive('FrontendMultiLang'))
                                                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                    role="tablist">
                                                                                    @foreach ($LanguageList as $key => $language)
                                                                                        <li class="nav-item">
                                                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                               href="#elementblock10{{$language->code}}"
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
                                                                                     id="elementblock10{{$language->code}}">
                                                                                    <div class="row">
                                                                                        <div class="col-xl-12">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                <label
                                                                                                    class="primary_input_label"
                                                                                                    for="">{{ __('frontendmanage.Article Title') }}</label>
                                                                                                <input
                                                                                                    class="primary_input_field"
                                                                                                    placeholder="{{ __('frontendmanage.Article Title') }}"
                                                                                                    type="text"
                                                                                                    name="article_title[{{$language->code}}]"
                                                                                                    {{ $errors->has('article_title') ? ' autofocus' : '' }}
                                                                                                    value="{{isset($home_content)? getRawHomeContents($home_content,'article_title',$language->code) : ''}}">
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-xl-12">
                                                                                            <div
                                                                                                class="primary_input mb-25">
                                                                                                <label
                                                                                                    class="primary_input_label"
                                                                                                    for="">{{ __('frontendmanage.Article Sub Title') }}</label>
                                                                                                <input
                                                                                                    class="primary_input_field"
                                                                                                    placeholder="{{ __('frontendmanage.Article Sub Title') }}"
                                                                                                    type="text"
                                                                                                    name="article_sub_title[{{$language->code}}]"
                                                                                                    {{ $errors->has('article_sub_title') ? ' autofocus' : '' }}
                                                                                                    value="{{isset($home_content)? getRawHomeContents($home_content,'article_sub_title',$language->code) : ''}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($block->id==12)
                                                @if($currentTheme=="infixlmstheme"  || $currentTheme=="teachery")
                                                    <div data-id="{{$block->id}}" class="row">
                                                        <div class="accordion" id="accordionHomeContent">
                                                            <div class="card">
                                                                <div class="card-header"
                                                                     id="heading{{ $block->id }}">
                                                                    <h2 class="mb-0">
                                                                        <button
                                                                            class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                            {{__('frontendmanage.Subscribe Section Show In Homepage')}}
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <div id="collapse{{ $block->id }}"
                                                                     class="collapse show"
                                                                     aria-labelledby="heading{{ $block->id }}"
                                                                     data-parent="#accordionHomeContent">
                                                                    <div class="card-body">
                                                                        <div class="col-xl-12 ">
                                                                            <div class="mb_25">
                                                                                <label
                                                                                    class="switch_toggle "
                                                                                    for="show_subscribe_section">
                                                                                    <input type="checkbox"
                                                                                           class="status_enable_disable"
                                                                                           name="show_subscribe_section"
                                                                                           id="show_subscribe_section"
                                                                                           @if (@getRawHomeContents($home_content,'show_subscribe_section','en') == 1) checked
                                                                                           @endif value="1">
                                                                                    <i class="slider round"></i>


                                                                                </label>
                                                                                {{__('frontendmanage.Subscribe Section Show In Homepage')}}

                                                                            </div>
                                                                        </div>

                                                                        <div id="show_subscribe_section_box"
                                                                             class="col-md-12"
                                                                             style="@if (@getRawHomeContents($home_content,'show_subscribe_section','en') == 0) display:none
                                                                             @endif ">
                                                                            @if($currentTheme != "teachery")
                                                                                <div class="row">
                                                                                    <div class="col-xl-4">
                                                                                        <div
                                                                                            class="primary_input mb-25">

                                                                                            <img
                                                                                                class="  imagePreview3"
                                                                                                style="max-width: 100%"
                                                                                                src="{{asset('/'.getRawHomeContents($home_content,'subscribe_logo','en'))}}"
                                                                                                alt="">

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-8">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <label
                                                                                                class="primary_input_label"
                                                                                                for="">{{ __('frontendmanage.Subscribe Logo') }}
                                                                                            </label>
                                                                                            <small>
                                                                                                {{__('courses.Recommended Size')}}
                                                                                                80x60 px
                                                                                            </small>
                                                                                            <div
                                                                                                class="primary_file_uploader">
                                                                                                <input
                                                                                                    class="primary-input  filePlaceholder {{ @$errors->has('subscribe_logo') ? ' is-invalid' : '' }}"
                                                                                                    type="text"
                                                                                                    id=""
                                                                                                    placeholder="{{__('setting.Browse file')}}"
                                                                                                    readonly="" {{ $errors->has('subscribe_logo') ? ' autofocus' : '' }}>
                                                                                                <button class=""
                                                                                                        type="button">
                                                                                                    <label
                                                                                                        class="primary-btn small fix-gr-bg"
                                                                                                        for="file3">{{ __('common.Browse') }}</label>
                                                                                                    <input
                                                                                                        type="file"
                                                                                                        class="d-none imgInput3"
                                                                                                        name="subscribe_logo"
                                                                                                        id="file3">
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>


                                                                                </div>
                                                                            @endif
                                                                            <div class="row pt-0">
                                                                                @if(isModuleActive('FrontendMultiLang'))
                                                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                        role="tablist">
                                                                                        @foreach ($LanguageList as $key => $language)
                                                                                            <li class="nav-item">
                                                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                                   href="#elementblock12{{$language->code}}"
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
                                                                                         id="elementblock12{{$language->code}}">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Subscribe Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Subscribe Title') }}"
                                                                                                        type="text"
                                                                                                        name="subscribe_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('subscribe_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'subscribe_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                            @if($currentTheme != "teachery")
                                                                                                <div class="col-xl-12">
                                                                                                    <div
                                                                                                        class="primary_input mb-25">
                                                                                                        <label
                                                                                                            class="primary_input_label"
                                                                                                            for="">{{ __('frontendmanage.Subscribe Sub Title') }}</label>
                                                                                                        <input
                                                                                                            class="primary_input_field"
                                                                                                            placeholder="{{ __('frontendmanage.Subscribe Sub Title') }}"
                                                                                                            type="text"
                                                                                                            name="subscribe_sub_title[{{$language->code}}]"
                                                                                                            {{ $errors->has('subscribe_sub_title') ? ' autofocus' : '' }}
                                                                                                            value="{{isset($home_content)? getRawHomeContents($home_content,'subscribe_sub_title',$language->code) : ''}}">
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endif
                                            @elseif($block->id==11)
                                                @if($currentTheme != "teachery")
                                                    <div data-id="{{$block->id}}" class="row">
                                                        <div class="accordion" id="accordionHomeContent">
                                                            <div class="card">
                                                                <div class="card-header"
                                                                     id="heading{{ $block->id }}">
                                                                    <h2 class="mb-0">
                                                                        <button class="btn btn-block text-start"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#collapse{{ $block->id }}"
                                                                                aria-expanded="true"
                                                                                aria-controls="collapse{{ $block->id }}">
                                                                            {{__('frontendmanage.Become Instructor Section Show In Homepage')}}
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <div id="collapse{{ $block->id }}"
                                                                     class="collapse show"
                                                                     aria-labelledby="heading{{ $block->id }}"
                                                                     data-parent="#accordionHomeContent">
                                                                    <div class="card-body">
                                                                        <div class="col-xl-12 ">
                                                                            <div class="mb_25">
                                                                                <label class="switch_toggle "
                                                                                       for="show_become_instructor_section">
                                                                                    <input type="checkbox"
                                                                                           class="status_enable_disable"
                                                                                           name="show_become_instructor_section"
                                                                                           id="show_become_instructor_section"
                                                                                           @if (@getRawHomeContents($home_content,'show_become_instructor_section','en') == 1) checked
                                                                                           @endif value="1">
                                                                                    <i class="slider round"></i>


                                                                                </label>
                                                                                {{__('frontendmanage.Become Instructor Section Show In Homepage')}}

                                                                            </div>
                                                                        </div>

                                                                        <div
                                                                            id="show_become_instructor_section_box"
                                                                            class="col-md-12"
                                                                            style="@if (@getRawHomeContents($home_content,'show_become_instructor_section','en') == 0) display:none
                                                                            @endif ">
                                                                            <div class="row">
                                                                                <div class="col-xl-4">
                                                                                    <div
                                                                                        class="primary_input mb-25">

                                                                                        <img
                                                                                            class=" imagePreview4"
                                                                                            style="max-width: 100%"
                                                                                            src="{{asset('/'.getRawHomeContents($home_content,'become_instructor_logo','en'))}}"
                                                                                            alt="">

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-8">
                                                                                    <div
                                                                                        class="primary_input mb-25">
                                                                                        <label
                                                                                            class="primary_input_label"
                                                                                            for="">{{ __('frontendmanage.Become Instructor Logo/Image') }}
                                                                                            <small>({{__('common.Recommended Size')}}
                                                                                                110x110)</small>
                                                                                        </label>
                                                                                        <div
                                                                                            class="primary_file_uploader">
                                                                                            <input
                                                                                                class="primary-input  filePlaceholder {{ @$errors->has('become_instructor_logo') ? ' is-invalid' : '' }}"
                                                                                                type="text"
                                                                                                id=""
                                                                                                placeholder="{{__('setting.Browse file')}}"
                                                                                                readonly="" {{ $errors->has('become_instructor_logo') ? ' autofocus' : '' }}>
                                                                                            <button class=""
                                                                                                    type="button">
                                                                                                <label
                                                                                                    class="primary-btn small fix-gr-bg"
                                                                                                    for="file4">{{ __('common.Browse') }}</label>
                                                                                                <input
                                                                                                    type="file"
                                                                                                    class="d-none imgInput4"
                                                                                                    name="become_instructor_logo"
                                                                                                    id="file4">
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <div class="row pt-0">
                                                                                @if(isModuleActive('FrontendMultiLang'))
                                                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                        role="tablist">
                                                                                        @foreach ($LanguageList as $key => $language)
                                                                                            <li class="nav-item">
                                                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                                   href="#elementblock11{{$language->code}}"
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
                                                                                         id="elementblock11{{$language->code}}">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Become Instructor Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Become Instructor Title') }}"
                                                                                                        type="text"
                                                                                                        name="become_instructor_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('become_instructor_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'become_instructor_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Become Instructor Sub Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Become Instructor Sub Title') }}"
                                                                                                        type="text"
                                                                                                        name="become_instructor_sub_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('become_instructor_sub_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'become_instructor_sub_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endif
                                            @elseif($block->id==9)
                                                @if($currentTheme != "teachery")
                                                    <div data-id="{{$block->id}}" class="row">
                                                        <div class="accordion" id="accordionHomeContent">
                                                            <div class="card">
                                                                <div class="card-header"
                                                                     id="heading{{ $block->id }}">
                                                                    <h2 class="mb-0">
                                                                        <button class="btn btn-block text-start"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#collapse{{ $block->id }}"
                                                                                aria-expanded="true"
                                                                                aria-controls="collapse{{ $block->id }}">
                                                                            {{__('frontendmanage.Sponsor Section Show In Homepage')}}
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <div id="collapse{{ $block->id }}"
                                                                     class="collapse show"
                                                                     aria-labelledby="heading{{ $block->id }}"
                                                                     data-parent="#accordionHomeContent">
                                                                    <div class="card-body">
                                                                        <div class="col-xl-12 ">
                                                                            <div class="mb_25">
                                                                                <label class="switch_toggle "
                                                                                       for="show_sponsor_section">
                                                                                    <input type="checkbox"
                                                                                           class="status_enable_disable"
                                                                                           name="show_sponsor_section"
                                                                                           id="show_sponsor_section"
                                                                                           @if (@getRawHomeContents($home_content,'show_sponsor_section','en') == 1) checked
                                                                                           @endif value="1">
                                                                                    <i class="slider round"></i>


                                                                                </label>
                                                                                {{__('frontendmanage.Sponsor Section Show In Homepage')}}

                                                                            </div>
                                                                        </div>
                                                                        <div id="show_sponsor_section_box"
                                                                             class="col-xl-12"
                                                                             style="@if (@getRawHomeContents($home_content,'show_sponsor_section','en') == 0) display:none
                                                                             @endif ">

                                                                            <div class="row pt-0">
                                                                                @if(isModuleActive('FrontendMultiLang'))
                                                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                        role="tablist">
                                                                                        @foreach ($LanguageList as $key => $language)
                                                                                            <li class="nav-item">
                                                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                                   href="#elementblock9{{$language->code}}"
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
                                                                                         id="elementblock9{{$language->code}}">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Sponsor Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Sponsor Title') }}"
                                                                                                        type="text"
                                                                                                        name="sponsor_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('sponsor_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'sponsor_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Sponsor Sub Title') }}</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Sponsor Sub Title') }}"
                                                                                                        type="text"
                                                                                                        name="sponsor_sub_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('sponsor_sub_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'sponsor_sub_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endif
                                            @elseif($block->id==16)
                                                @if($currentTheme=="infixlmstheme")
                                                    <div data-id="{{$block->id}}" class="row">
                                                        <div class="accordion" id="accordionHomeContent">
                                                            <div class="card">
                                                                <div class="card-header"
                                                                     id="heading{{ $block->id }}">
                                                                    <h2 class="mb-0">
                                                                        <button
                                                                            class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                            {{__('frontendmanage.How To Buy In Homepage')}}
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <div id="collapse{{ $block->id }}"
                                                                     class="collapse show"
                                                                     aria-labelledby="heading{{ $block->id }}"
                                                                     data-parent="#accordionHomeContent">
                                                                    <div class="card-body">
                                                                        <div class="col-xl-12 ">
                                                                            <div class="mb_25">
                                                                                <label
                                                                                    class="switch_toggle "
                                                                                    for="show_how_to_buy">
                                                                                    <input type="checkbox"
                                                                                           class="status_enable_disable"
                                                                                           name="show_how_to_buy"
                                                                                           id="show_how_to_buy"
                                                                                           @if (@getRawHomeContents($home_content,'show_how_to_buy','en') == 1) checked
                                                                                           @endif value="1">
                                                                                    <i class="slider round"></i>


                                                                                </label>
                                                                                {{__('frontendmanage.How To Buy In Homepage')}}

                                                                            </div>
                                                                        </div>

                                                                        <div id="show_how_to_buy_box"
                                                                             class="col-xl-12"
                                                                             style="@if (@getRawHomeContents($home_content,'show_how_to_buy','en') == 0) display:none
                                                                             @endif ">

                                                                            <div class="row pt-0">
                                                                                @if(isModuleActive('FrontendMultiLang'))
                                                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                        role="tablist">
                                                                                        @foreach ($LanguageList as $key => $language)
                                                                                            <li class="nav-item">
                                                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                                   href="#elementblock16{{$language->code}}"
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
                                                                                         id="elementblock16{{$language->code}}">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Title') }}
                                                                                                    </label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Title') }}"
                                                                                                        type="text"
                                                                                                        name="how_to_buy_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('how_to_buy_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'how_to_buy_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>


                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Sub Title') }}
                                                                                                    </label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Sub Title') }}"
                                                                                                        type="text"
                                                                                                        name="how_to_buy_sub_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('how_to_buy_sub_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'how_to_buy_sub_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="row">
                                                                                            <div class="col-xl-6">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Title') }}
                                                                                                        (1)</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Title') }}"
                                                                                                        type="text"
                                                                                                        name="how_to_buy_title1[{{$language->code}}]"
                                                                                                        {{ $errors->has('how_to_buy_title1') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'how_to_buy_title1',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xl-6">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Details') }}
                                                                                                        (1)</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Details') }}"
                                                                                                        type="text"
                                                                                                        name="how_to_buy_details1[{{$language->code}}]"
                                                                                                        {{ $errors->has('how_to_buy_details1') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'how_to_buy_details1',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>


                                                                                        <div class="row">
                                                                                            <div class="col-xl-6">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Title') }}
                                                                                                        (2)</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Title') }}"
                                                                                                        type="text"
                                                                                                        name="how_to_buy_title2[{{$language->code}}]"
                                                                                                        {{ $errors->has('how_to_buy_title2') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'how_to_buy_title2',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xl-6">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Details') }}
                                                                                                        (2)</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Details') }}"
                                                                                                        type="text"
                                                                                                        name="how_to_buy_details2[{{$language->code}}]"
                                                                                                        {{ $errors->has('how_to_buy_details2') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'how_to_buy_details2',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>


                                                                                        <div class="row">
                                                                                            <div class="col-xl-6">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Title') }}
                                                                                                        (3)</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Title') }}"
                                                                                                        type="text"
                                                                                                        name="how_to_buy_title3[{{$language->code}}]"
                                                                                                        {{ $errors->has('how_to_buy_title3') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'how_to_buy_title3',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xl-6">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Details') }}
                                                                                                        (3)</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Details') }}"
                                                                                                        type="text"
                                                                                                        name="how_to_buy_details3[{{$language->code}}]"
                                                                                                        {{ $errors->has('how_to_buy_details3') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'how_to_buy_details3',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>


                                                                                        <div class="row">
                                                                                            <div class="col-xl-6">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Title') }}
                                                                                                        (4)</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Title') }}"
                                                                                                        type="text"
                                                                                                        name="how_to_buy_title4[{{$language->code}}]"
                                                                                                        {{ $errors->has('how_to_buy_title4') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'how_to_buy_title4',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xl-6">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Details') }}
                                                                                                        (4)</label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Details') }}"
                                                                                                        type="text"
                                                                                                        name="how_to_buy_details4[{{$language->code}}]"
                                                                                                        {{ $errors->has('how_to_buy_details4') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'how_to_buy_details4',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-xl-2">
                                                                                    <div
                                                                                        class="primary_input mb-25  mt-35">

                                                                                        <img
                                                                                            class=" imagePreview12"
                                                                                            style="max-width: 100%"
                                                                                            src="{{asset('/'.getRawHomeContents($home_content,'how_to_buy_logo1','en'))}}"
                                                                                            alt="">

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-4">
                                                                                    <div
                                                                                        class="primary_input mb-25">
                                                                                        <label
                                                                                            class="primary_input_label"
                                                                                            for="">{{ __('frontendmanage.Icon') }}
                                                                                            (1)</label>
                                                                                        <div
                                                                                            class="primary_file_uploader">
                                                                                            <input
                                                                                                class="primary-input  filePlaceholder {{ @$errors->has('slider_banner') ? ' is-invalid' : '' }}"
                                                                                                type="text"
                                                                                                id=""
                                                                                                placeholder="{{__('setting.Browse file')}}"
                                                                                                readonly="" {{ $errors->has('slider_banner') ? ' autofocus' : '' }}>
                                                                                            <button class=""
                                                                                                    type="button">
                                                                                                <label
                                                                                                    class="primary-btn small fix-gr-bg"
                                                                                                    for="file12">{{ __('common.Browse') }}</label>
                                                                                                <input
                                                                                                    type="file"
                                                                                                    class="d-none fileUpload imgInput12"
                                                                                                    name="how_to_buy_logo1"
                                                                                                    id="file12">
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-xl-2">
                                                                                    <div
                                                                                        class="primary_input mb-25  mt-35">

                                                                                        <img
                                                                                            class=" imagePreview13"
                                                                                            style="max-width: 100%"
                                                                                            src="{{asset('/'.getRawHomeContents($home_content,'how_to_buy_logo2','en'))}}"
                                                                                            alt="">

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-4">
                                                                                    <div
                                                                                        class="primary_input mb-25">
                                                                                        <label
                                                                                            class="primary_input_label"
                                                                                            for="">{{ __('frontendmanage.Icon') }}
                                                                                            (2)</label>
                                                                                        <div
                                                                                            class="primary_file_uploader">
                                                                                            <input
                                                                                                class="primary-input  filePlaceholder {{ @$errors->has('slider_banner') ? ' is-invalid' : '' }}"
                                                                                                type="text"
                                                                                                id=""
                                                                                                placeholder="{{__('setting.Browse file')}}"
                                                                                                readonly="" {{ $errors->has('slider_banner') ? ' autofocus' : '' }}>
                                                                                            <button class=""
                                                                                                    type="button">
                                                                                                <label
                                                                                                    class="primary-btn small fix-gr-bg"
                                                                                                    for="file13">{{ __('common.Browse') }}</label>
                                                                                                <input
                                                                                                    type="file"
                                                                                                    class="d-none fileUpload imgInput13"
                                                                                                    name="how_to_buy_logo2"
                                                                                                    id="file13">
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-xl-2">
                                                                                    <div
                                                                                        class="primary_input mb-25  mt-35">

                                                                                        <img
                                                                                            class=" imagePreview14"
                                                                                            style="max-width: 100%"
                                                                                            src="{{asset('/'.getRawHomeContents($home_content,'how_to_buy_logo3','en'))}}"
                                                                                            alt="">

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-4">
                                                                                    <div
                                                                                        class="primary_input mb-25">
                                                                                        <label
                                                                                            class="primary_input_label"
                                                                                            for="">{{ __('frontendmanage.Icon') }}
                                                                                            (3)</label>
                                                                                        <div
                                                                                            class="primary_file_uploader">
                                                                                            <input
                                                                                                class="primary-input  filePlaceholder {{ @$errors->has('slider_banner') ? ' is-invalid' : '' }}"
                                                                                                type="text"
                                                                                                id=""
                                                                                                placeholder="{{__('setting.Browse file')}}"
                                                                                                readonly="" {{ $errors->has('slider_banner') ? ' autofocus' : '' }}>
                                                                                            <button class=""
                                                                                                    type="button">
                                                                                                <label
                                                                                                    class="primary-btn small fix-gr-bg"
                                                                                                    for="file14">{{ __('common.Browse') }}</label>
                                                                                                <input
                                                                                                    type="file"
                                                                                                    class="d-none fileUpload imgInput14"
                                                                                                    name="how_to_buy_logo3"
                                                                                                    id="file14">
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-xl-2">
                                                                                    <div
                                                                                        class="primary_input mb-25  mt-35">

                                                                                        <img
                                                                                            class=" imagePreview15"
                                                                                            style="max-width: 100%"
                                                                                            src="{{asset('/'.getRawHomeContents($home_content,'how_to_buy_logo4','en'))}}"
                                                                                            alt="">

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-4">
                                                                                    <div
                                                                                        class="primary_input mb-25">
                                                                                        <label
                                                                                            class="primary_input_label"
                                                                                            for="">{{ __('frontendmanage.Icon') }}
                                                                                            (4)</label>
                                                                                        <div
                                                                                            class="primary_file_uploader">
                                                                                            <input
                                                                                                class="primary-input  filePlaceholder {{ @$errors->has('slider_banner') ? ' is-invalid' : '' }}"
                                                                                                type="text"
                                                                                                id=""
                                                                                                placeholder="{{__('setting.Browse file')}}"
                                                                                                readonly="" {{ $errors->has('slider_banner') ? ' autofocus' : '' }}>
                                                                                            <button class=""
                                                                                                    type="button">
                                                                                                <label
                                                                                                    class="primary-btn small fix-gr-bg"
                                                                                                    for="file15">{{ __('common.Browse') }}</label>
                                                                                                <input
                                                                                                    type="file"
                                                                                                    class="d-none fileUpload imgInput15"
                                                                                                    name="how_to_buy_logo4"
                                                                                                    id="file15">
                                                                                            </button>
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
                                                @endif
                                            @elseif($block->id==17)
                                                @if($currentTheme=="infixlmstheme")
                                                    <div data-id="{{$block->id}}" class="row">
                                                        <div class="accordion" id="accordionHomeContent">
                                                            <div class="card">
                                                                <div class="card-header"
                                                                     id="heading{{ $block->id }}">
                                                                    <h2 class="mb-0">
                                                                        <button
                                                                            class="btn btn-block text-start"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse{{ $block->id }}"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse{{ $block->id }}">
                                                                            {{__('frontendmanage.FAQ In Homepage')}}
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <div id="collapse{{ $block->id }}"
                                                                     class="collapse show"
                                                                     aria-labelledby="heading{{ $block->id }}"
                                                                     data-parent="#accordionHomeContent">
                                                                    <div class="card-body">
                                                                        <div class="col-xl-12 ">
                                                                            <div class="mb_25">
                                                                                <label
                                                                                    class="switch_toggle "
                                                                                    for="show_home_page_faq">
                                                                                    <input type="checkbox"
                                                                                           class="status_enable_disable"
                                                                                           name="show_home_page_faq"
                                                                                           id="show_home_page_faq"
                                                                                           @if (@getRawHomeContents($home_content,'show_home_page_faq','en') == 1) checked
                                                                                           @endif value="1">
                                                                                    <i class="slider round"></i>


                                                                                </label>

                                                                                {{__('frontendmanage.FAQ In Homepage')}}

                                                                            </div>
                                                                        </div>
                                                                        <div id="show_home_page_faq_box"
                                                                             class="col-xl-12"
                                                                             style=" @if(getRawHomeContents($home_content,'show_home_page_faq','en') != 1) display:none @endif ">

                                                                            <div class="row pt-0">
                                                                                @if(isModuleActive('FrontendMultiLang'))
                                                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                                        role="tablist">
                                                                                        @foreach ($LanguageList as $key => $language)
                                                                                            <li class="nav-item">
                                                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                                   href="#elementblock17{{$language->code}}"
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
                                                                                         id="elementblock17{{$language->code}}">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Title') }}
                                                                                                    </label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Title') }}"
                                                                                                        type="text"
                                                                                                        name="home_page_faq_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('home_page_faq_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'home_page_faq_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-12">
                                                                                                <div
                                                                                                    class="primary_input mb-25">
                                                                                                    <label
                                                                                                        class="primary_input_label"
                                                                                                        for="">{{ __('frontendmanage.Sub Title') }}
                                                                                                    </label>
                                                                                                    <input
                                                                                                        class="primary_input_field"
                                                                                                        placeholder="{{ __('frontendmanage.Sub Title') }}"
                                                                                                        type="text"
                                                                                                        name="home_page_faq_sub_title[{{$language->code}}]"
                                                                                                        {{ $errors->has('home_page_faq_sub_title') ? ' autofocus' : '' }}
                                                                                                        value="{{isset($home_content)? getRawHomeContents($home_content,'home_page_faq_sub_title',$language->code) : ''}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-40">
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="primary-btn fix-gr-bg">
                                        <i class="ti-check"></i>
                                        {{__('common.Update')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>


            </div>
    </section>

@endsection
@push('scripts')
    <script src="{{asset('public/backend/vendors/nestable/jquery.nestable.min.js')}}"></script>
    <script>
        let show_why_choose = $('#show_why_choose');
        let whyChooseBox = $('#show_home_page_why_choose_box');
        show_why_choose.change(function () {
            if (show_why_choose.is(':checked')) {
                whyChooseBox.show();
            } else {
                whyChooseBox.hide();
            }
        });

        let key_feature_show = $('#key_feature_show');
        let keyFeatureBox = $('#keyFeatureBox');
        key_feature_show.change(function () {
            if (key_feature_show.is(':checked')) {
                keyFeatureBox.show();
            } else {
                keyFeatureBox.hide();
            }
        });

        let show_banner_section = $('#show_banner_section');
        let show_banner_section_box = $('#show_banner_section_box');
        let show_banner_section_title = $('#show_banner_section_title');
        show_banner_section.change(function () {
            if (show_banner_section.is(':checked')) {
                show_banner_section_box.show();
                show_banner_section_title.html('{{__('frontendmanage.Banner Section Show In Homepage')}}');
            } else {
                show_banner_section_box.hide();
                show_banner_section_title.html(' {{__('frontendmanage.Slider Show In Homepage')}}');

            }
        });

        let show_category_section = $('#show_category_section');
        let show_category_section_box = $('#show_category_section_box');
        show_category_section.change(function () {
            if (show_category_section.is(':checked')) {
                show_category_section_box.show();
            } else {
                show_category_section_box.hide();
            }
        });


        // -----


        let show_instructor_section = $('#show_instructor_section');
        let show_instructor_section_box = $('#show_instructor_section_box');
        show_instructor_section.change(function () {
            if (show_instructor_section.is(':checked')) {
                show_instructor_section_box.show();
            } else {
                show_instructor_section_box.hide();
            }
        });

        let show_best_category_section = $('#show_best_category_section');
        let show_best_category_section_box = $('#show_best_category_section_box');
        show_best_category_section.change(function () {
            if (show_best_category_section.is(':checked')) {
                show_best_category_section_box.show();
            } else {
                show_best_category_section_box.hide();
            }
        });

        // ---
        let show_course_section = $('#show_course_section');
        let show_course_section_box = $('#show_course_section_box');
        show_course_section.change(function () {
            if (show_course_section.is(':checked')) {
                show_course_section_box.show();
            } else {
                show_course_section_box.hide();
            }
        });
        // ---
        let show_quiz_section = $('#show_quiz_section');
        let show_quiz_section_box = $('#show_quiz_section_box');
        show_quiz_section.change(function () {
            if (show_quiz_section.is(':checked')) {
                show_quiz_section_box.show();
            } else {
                show_quiz_section_box.hide();
            }
        });


        // ---
        let show_testimonial_section = $('#show_testimonial_section');
        let show_testimonial_section_box = $('#show_testimonial_section_box');
        show_testimonial_section.change(function () {
            if (show_testimonial_section.is(':checked')) {
                show_testimonial_section_box.show();
            } else {
                show_testimonial_section_box.hide();
            }
        });

        // ---
        let show_article_section = $('#show_article_section');
        let show_article_section_box = $('#show_article_section_box');
        show_article_section.change(function () {
            if (show_article_section.is(':checked')) {
                show_article_section_box.show();
            } else {
                show_article_section_box.hide();
            }
        });

        // ---
        let show_subscribe_section = $('#show_subscribe_section');
        let show_subscribe_section_box = $('#show_subscribe_section_box');
        show_subscribe_section.change(function () {
            if (show_subscribe_section.is(':checked')) {
                show_subscribe_section_box.show();
            } else {
                show_subscribe_section_box.hide();
            }
        });


        let show_about_lms_section = $('#show_about_lms_section');
        let show_about_lms_section_box = $('#show_about_lms_section_box');
        show_about_lms_section.change(function () {
            if (show_about_lms_section.is(':checked')) {
                show_about_lms_section_box.show();
            } else {
                show_about_lms_section_box.hide();
            }
        });

        let show_live_class_section = $('#show_live_class_section');
        let show_live_class_section_box = $('#show_live_class_section_box');
        show_live_class_section.change(function () {
            if (show_live_class_section.is(':checked')) {
                show_live_class_section_box.show();
            } else {
                show_live_class_section_box.hide();
            }
        });
        // ---
        let show_become_instructor_section = $('#show_become_instructor_section');
        let show_become_instructor_section_box = $('#show_become_instructor_section_box');
        show_become_instructor_section.change(function () {
            if (show_become_instructor_section.is(':checked')) {
                show_become_instructor_section_box.show();
            } else {
                show_become_instructor_section_box.hide();
            }
        });


        let show_how_to_buy = $('#show_how_to_buy');
        let show_how_to_buy_box = $('#show_how_to_buy_box');
        show_how_to_buy.change(function () {
            if (show_how_to_buy.is(':checked')) {
                show_how_to_buy_box.show();
            } else {
                show_how_to_buy_box.hide();
            }
        });

        let show_home_page_faq = $('#show_home_page_faq');
        let show_home_page_faq_box = $('#show_home_page_faq_box');
        show_home_page_faq.change(function () {
            if (show_home_page_faq.is(':checked')) {
                show_home_page_faq_box.show();
            } else {
                show_home_page_faq_box.hide();
            }
        });
        let show_cta_section_toggle = $('#show_cta_section_toggle');
        let show_cta_section = $('#show_cta_section');
        show_cta_section_toggle.change(function () {
            if (show_cta_section_toggle.is(':checked')) {
                show_cta_section.show();
            } else {
                show_cta_section.hide();
            }
        });

        let banner_type = $('#banner_type');
        let banner_type_box = $('#banner_type_box');
        banner_type_box.change(function () {
            if (banner_type.is(':checked')) {
                banner_type_box.show();
            } else {
                banner_type_box.hide();
            }
        });

        let show_sponsor_section = $('#show_sponsor_section');
        let show_sponsor_section_box = $('#show_sponsor_section_box');
        show_sponsor_section.change(function () {
            if (show_sponsor_section.is(':checked')) {
                show_sponsor_section_box.show();
            } else {
                show_sponsor_section_box.hide();
            }
        });

        let show_subscription_plan = $('#show_subscription_plan');
        let show_subscription_plan_box = $('#show_subscription_plan_box');
        show_subscription_plan.change(function () {
            if (show_subscription_plan.is(':checked')) {
                show_subscription_plan_box.show();
            } else {
                show_subscription_plan_box.hide();
            }
        });

        // ---


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


        function readURL13(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview13").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput13").change(function () {
            readURL13(this);
        });


        function readURL14(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview14").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput14").change(function () {
            readURL14(this);
        });


        function readURL15(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview15").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput15").change(function () {
            readURL15(this);
        });
        $(document).on('mouseover', 'body', function () {

            $(".item_list").sortable({
                cursor: "move",
                // connectWith: ["#elementDiv", ".item_list"],
                update: function (event, ui) {
                    let ids = $(this).sortable('toArray', {attribute: 'data-id'});
                    console.log(ids);
                    if (ids.length > 0) {
                        $.post("{{ route('frontend.changeHomePageBlockOrder') }}", {
                            '_token': '{{ csrf_token() }}',
                            'ids': ids
                        }, function (data) {

                        });
                    }

                },
            });
        });
    </script>
@endpush
