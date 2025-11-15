@extends('setting::layouts.master')

@section('mainContent')
    @php
        $LanguageList = getLanguageList();
    @endphp
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">

                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="">
                        <div class="row">

                            <div class="col-lg-12">
                                <!-- tab-content  -->
                                <div class="tab-content " id="myTabContent">
                                    <!-- General -->
                                    <div class="tab-pane fade white-box show active" id="Activation"
                                         role="tabpanel"
                                         aria-labelledby="Activation-tab">
                                        <div class="main-title mb-20">


                                            <form action="{{ route('frontend.loginpage.store') }}" id="form_data_id"
                                                  method="POST" enctype="multipart/form-data">

                                                @csrf
                                                <div class="main-title mb-20">
                                                    <h3 class="mb-0">{{ __('frontendmanage.Login Page') }}</h3>
                                                </div>
                                                <div class=" ">


                                                    <div class="single_system_wrap student-details header-menu">


                                                        <div class="row pt-0">
                                                            @if (isModuleActive('FrontendMultiLang'))
                                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                    role="tablist">
                                                                    @foreach ($LanguageList as $key => $language)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                               href="#element{{ $language->code }}"
                                                                               role="tab"
                                                                               data-bs-toggle="tab">{{ $language->native }} </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </div>
                                                        @if (currentTheme() != 'tvt')
                                                            <div class="tab-content">
                                                                @foreach ($LanguageList as $key => $language)
                                                                    <div role="tabpanel"
                                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                                         id="element{{ $language->code }}">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="">{{ __('frontendmanage.Title') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="InfixLMS"
                                                                                        type="text"
                                                                                        id="site_title"
                                                                                        name="title[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('title', $language->code) }}">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-xl-4">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="slogan1">{{ __('frontendmanage.Slogan 1') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="Excellence"
                                                                                        type="text"
                                                                                        id="slogan1"
                                                                                        name="slogan1[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('slogans1', $language->code) }}">
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-xl-4">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="slogan2">{{ __('frontendmanage.Slogan 2') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="Diversity."
                                                                                        type="text"
                                                                                        id="slogan2"
                                                                                        name="slogan2[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('slogans2', $language->code) }}">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-xl-4">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="slogan3">{{ __('frontendmanage.Slogan 3') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="Community."
                                                                                        type="text"
                                                                                        id="slogan3"
                                                                                        name="slogan3[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('slogans3', $language->code) }}">
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                        <x-upload-file
                                                            name="banner"
                                                            type="image"
                                                            media_id="{{isset($page)?$page->banner_media?->media_id:''}}"
                                                            label="{{ __('frontendmanage.Banner Image') }}"
                                                        />

                                                        <div class="submit_btn text-center mt_60">
                                                            <button class="primary-btn fix-gr-bg" type="submit"
                                                                    data-bs-toggle="tooltip"
                                                                    id="general_info_sbmt_btn"><i
                                                                    class="ti-check"></i> {{ __('common.Save') }}
                                                            </button>
                                                        </div>
                                                    </div>


                                                </div>
                                                <hr>
                                                <div class="main-title mb-20">
                                                    <h3 class="mb-0">{{ __('frontendmanage.Registration Page') }}</h3>
                                                </div>

                                                <div class="">

                                                    <div class="single_system_wrap student-details header-menu">
                                                        <div class="row pt-0">
                                                            @if (isModuleActive('FrontendMultiLang'))
                                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                    role="tablist">
                                                                    @foreach ($LanguageList as $key => $language)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                               href="#element1{{ $language->code }}"
                                                                               role="tab"
                                                                               data-bs-toggle="tab">{{ $language->native }} </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </div>
                                                        @if (currentTheme() != 'tvt')
                                                            <div class="tab-content">
                                                                @foreach ($LanguageList as $key => $language)
                                                                    <div role="tabpanel"
                                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                                         id="element1{{ $language->code }}">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="">{{ __('frontendmanage.Title') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="InfixLMS"
                                                                                        type="text"
                                                                                        id="reg_title"
                                                                                        name="reg_title[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('reg_title', $language->code) }}">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-xl-4">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="slogan1">{{ __('frontendmanage.Slogan 1') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="Excellence"
                                                                                        type="text" id="reg_slogan1"
                                                                                        name="reg_slogan1[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('reg_slogans1', $language->code) }}">
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-xl-4">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="slogan2">{{ __('frontendmanage.Slogan 2') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="Diversity."
                                                                                        type="text" id="reg_slogan2"
                                                                                        name="reg_slogan2[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('reg_slogans2', $language->code) }}">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-xl-4">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="slogan3">{{ __('frontendmanage.Slogan 3') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="Community."
                                                                                        type="text" id="reg_slogan3"
                                                                                        name="reg_slogan3[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('reg_slogans3', $language->code) }}">
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                        <x-upload-file
                                                            name="reg_banner"
                                                            type="image"
                                                            media_id="{{isset($page)?$page->reg_banner_media?->media_id:''}}"
                                                            label="{{ __('frontendmanage.Banner Image') }}"
                                                        />
                                                        <div class="submit_btn text-center mt_60">
                                                            <button class="primary-btn fix-gr-bg" type="submit"
                                                                    data-bs-toggle="tooltip"
                                                                    id="general_info_sbmt_btn"><i
                                                                    class="ti-check"></i> {{ __('common.Save') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="main-title mb-20">
                                                    <h3 class="mb-0">{{ __('frontendmanage.Forget Password/Others Page') }}
                                                    </h3>
                                                </div>
                                                <div class="">
                                                    <div class="single_system_wrap student-details header-menu">
                                                        <div class="row pt-0">
                                                            @if (isModuleActive('FrontendMultiLang'))
                                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                    role="tablist">
                                                                    @foreach ($LanguageList as $key => $language)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                               href="#element2{{ $language->code }}"
                                                                               role="tab"
                                                                               data-bs-toggle="tab">{{ $language->native }} </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </div>

                                                        @if (currentTheme() != 'tvt')
                                                            <div class="tab-content">
                                                                @foreach ($LanguageList as $key => $language)
                                                                    <div role="tabpanel"
                                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                                         id="element2{{ $language->code }}">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="forget_site_title">{{ __('frontendmanage.Title') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="InfixLMS"
                                                                                        type="text"
                                                                                        id="forget_site_title"
                                                                                        name="forget_title[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('forget_title', $language->code) }}">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-xl-4">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="forget_slogan1">{{ __('frontendmanage.Slogan 1') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="Excellence"
                                                                                        type="text"
                                                                                        id="forget_slogan1"
                                                                                        name="forget_slogan1[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('forget_slogans1', $language->code) }}">
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-xl-4">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="forget_slogan2">{{ __('frontendmanage.Slogan 2') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="Diversity."
                                                                                        type="text"
                                                                                        id="forget_slogan2"
                                                                                        name="forget_slogan2[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('forget_slogans2', $language->code) }}">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-xl-4">
                                                                                <div class="primary_input mb-25">
                                                                                    <label
                                                                                        class="primary_input_label"
                                                                                        for="forget_slogan3">{{ __('frontendmanage.Slogan 3') }}</label>
                                                                                    <input
                                                                                        class="primary_input_field"
                                                                                        placeholder="Community."
                                                                                        type="text"
                                                                                        id="forget_slogan3"
                                                                                        name="forget_slogan3[{{ $language->code }}]"
                                                                                        value="{{ $page->getTranslation('forget_slogans3', $language->code) }}">
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        <x-upload-file
                                                            name="forget_banner"
                                                            type="image"
                                                            media_id="{{isset($page)?$page->forget_banner_media?->media_id:''}}"
                                                            label="{{ __('frontendmanage.Banner Image') }}"
                                                        />
                                                        <div class="submit_btn text-center mt_60">
                                                            <button class="primary-btn fix-gr-bg" type="submit"
                                                                    data-bs-toggle="tooltip"
                                                                    id="general_info_sbmt_btn"><i
                                                                    class="ti-check"></i> {{ __('common.Save') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('frontendmanage::script')
