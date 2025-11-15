@extends('backend.master')

@section('mainContent')
    @php
        if(\Session::has('footer_tab')){
            $footerTab = \Session::get('footer_tab');
        }else{
            $footerTab = 1;
        }
    @endphp
    @php
        $LanguageList = getLanguageList();
    @endphp
    {!! generateBreadcrumb() !!}

    @push('css')
        <style>
            .addWidget {
                width: fit-content;
            }
        </style>
    @endpush

    @php
        $tooltip = "";
      $isDemo =config('app.demo_mode');
         if($isDemo){
            $tooltip =trans('common.For the demo version, you cannot change this');
        }
    @endphp
    <section class="mb-40 student-details up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row ">
                <h1 id="page_title" class="d-none"></h1>
                <div class="col-lg-12">
                    <ul class="nav nav-tabs no-bottom-border justify-content-end mt-sm-md-20 mb-20" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $footerTab == 1?'active':'' }} show" href="#copyrightText" role="tab"
                               data-bs-toggle="tab" id="1" onclick="sectionControl(this.id)"
                               aria-selected="true">{{__('footer.Copyright Text')}}</a>
                        </li>
                        @if(Settings('frontend_active_theme')=='tvt')
                            <li class="nav-item">
                                <a class="nav-link {{ $footerTab == 6?'active':'' }} show" href="#footer_6" role="tab"
                                   data-bs-toggle="tab" id="6" onclick="sectionControl(this.id)"
                                   aria-selected="true">{{$setting->where('key','footer_section_four_title')->first()->value??''}}</a>
                            </li>
                        @endif

                        @if(Settings('frontend_active_theme')!='tvt')
                            <li class="nav-item">
                                <a class="nav-link {{ $footerTab == 2?'active':'' }} show" href="#footer_1" role="tab"
                                   data-bs-toggle="tab" id="2" onclick="sectionControl(this.id)"
                                   aria-selected="false">{{__('footer.About Text')}}</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ $footerTab == 3?'active':'' }} show" href="#footer_2" role="tab"
                               data-bs-toggle="tab" id="3" onclick="sectionControl(this.id)"
                               aria-selected="false">{{$setting->where('key','footer_section_one_title')->first()->value??''}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $footerTab == 4?'active':'' }} show" href="#footer_3" role="tab"
                               data-bs-toggle="tab" id="4" onclick="sectionControl(this.id)"
                               aria-selected="true">{{$setting->where('key','footer_section_two_title')->first()->value??''}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $footerTab == 5?'active':'' }} show" href="#footer_4" role="tab"
                               data-bs-toggle="tab" id="5" onclick="sectionControl(this.id)"
                               aria-selected="true">{{$setting->where('key','footer_section_three_title')->first()->value??''}}</a>
                        </li>


                    </ul>
                </div>
                <div class="col-lg-12">

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade {{ $footerTab == 1?'active show':'' }} "
                             id="copyrightText">
                            <div class="col-lg-12">


                                <form method="POST" action="" id="copyright_form" accept-charset="UTF-8"
                                      class="form-horizontal" enctype="multipart/form-data">
                                    <div class="student-details header-menu">
                                        <div class="add-visitor">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-35">
                                                        <input type="hidden" name="key"
                                                               value="footer_copy_right">
                                                        <div class="row pt-0">
                                                            @if(isModuleActive('FrontendMultiLang'))
                                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                    role="tablist">
                                                                    @foreach ($LanguageList as $key => $language)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code)
                                        active

                                    @endif"
                                                                               href="#footer_copy_right{{$language->code}}"
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
                                                                     class="tab-pane fade @if (auth()->user()->language_code == $language->code)
                                    show active

                                @endif  "
                                                                     id="footer_copy_right{{$language->code}}">
                                                            <textarea name="value[{{$language->code}}]"
                                                                      placeholder="copy_right" class="lms_summernote"
                                                                      id="copy_right">{!! $setting->where('key','footer_copy_right')->first()->getTranslation('value',$language->code)??'' !!}</textarea>
                                                                </div>

                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <span class="text-danger" id="error_copy_right"></span>
                                                </div>
                                            </div>

                                            <div class="row ">
                                                <div class="col-lg-12 text-center tooltip-wrapper" data-title=""
                                                     data-original-title="" title="">
                                                    <button
                                                        class="primary-btn fix-gr-bg tooltip-wrapper  text-nowrap"
                                                        type="{{$isDemo?'button':'submit'}}"
                                                        id="{{!$isDemo?'copyrightBtn':''}}" data-bs-toggle="tooltip"
                                                        title="{{$tooltip}}"
                                                        >
                                                        <i class="ti-check"></i>
                                                        {{__('common.Update')}} </button>
                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if(currentTheme()!='tvt')
                            <div role="tabpanel" class="tab-pane {{ $footerTab == 2?'active show':'' }} fade"
                                 id="footer_1">
                                <div class="row">
                                    <div class="col-lg-3 mb-5 mb-lg-0 ">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="white-box">
                                                    <div class="main-title">
                                                        <h3 class="mb-20">
                                                            {{__('common.Update')}} </h3>
                                                    </div>

                                                    <form method="POST" action="" id="aboutForm"
                                                          accept-charset="UTF-8" class="form-horizontal"
                                                          enctype="multipart/form-data">
                                                        <input type="hidden" name="key" value="footer_about_title">
                                                        <div class="student-details header-menu">
                                                            <div class="add-visitor">
                                                                <div class="row pt-0">
                                                                    @if(isModuleActive('FrontendMultiLang'))
                                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                            role="tablist">
                                                                            @foreach ($LanguageList as $key => $language)
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code)
                                        active

                                    @endif"
                                                                                       href="#footer_about_title{{$language->code}}"
                                                                                       role="tab"
                                                                                       data-bs-toggle="tab">{{ $language->native }}  </a>
                                                                                </li>

                                                                            @endforeach
                                                                        </ul>

                                                                    @endif
                                                                </div>
                                                                <div class="tab-content pt-3">
                                                                    @foreach ($LanguageList as $key => $language)
                                                                        <div role="tabpanel"
                                                                             class="tab-pane fade @if (auth()->user()->language_code == $language->code)
                                    show active

                                @endif  "
                                                                             id="footer_about_title{{$language->code}}">
                                                                            <div class="row">
                                                                                <div class="col-lg-12">

                                                                                    <div class="input-effect">
                                                                                        <label
                                                                                            class="mb-2">{{__('footer.Section name')}}
                                                                                            <span
                                                                                                class="required_mark">*</span></label>
                                                                                        <input
                                                                                            class="primary_input_field read-only-input"
                                                                                            type="text"
                                                                                            name="value[{{$language->code}}]"
                                                                                            autocomplete="off"
                                                                                            value="{{ $setting->where('key','footer_about_title')->first()->getTranslation('value',$language->code)??''}}">
                                                                                        <span
                                                                                            class="focus-border"></span>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    @endforeach
                                                                </div>
                                                                <div class="row mt-3">

                                                                    <div class="col-lg-12 text-center tooltip-wrapper"
                                                                         data-title=""
                                                                         data-original-title="" title="">
                                                                        <button
                                                                            class="primary-btn fix-gr-bg tooltip-wrapper  text-nowrap"
                                                                            type="{{$isDemo?'button':'submit'}}"
                                                                            id="{{!$isDemo?'aboutSectionBtn':''}}" data-bs-toggle="tooltip"
                                                                            title="{{$tooltip}}"
                                                                            data-original-title="" title="">
                                                                            <i class="ti-check"></i>
                                                                            {{__('common.Update')}} </button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 mt-4 mt-lg-0  student-details header-menu">
                                        <div class="white-box">
                                            <form method="POST" action=""
                                                  accept-charset="UTF-8" class="form-horizontal"
                                                  enctype="multipart/form-data"
                                                  id="aboutDescriptionForm">
                                                <input type="hidden" name="key" value="footer_about_description">
                                                <div class="student-details header-menu">
                                                    <div class="row pt-0">
                                                        @if(isModuleActive('FrontendMultiLang'))
                                                            <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                role="tablist">
                                                                @foreach ($LanguageList as $key => $language)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link  @if (auth()->user()->language_code == $language->code)
                                        active

                                    @endif"
                                                                           href="#footer_about_description{{$language->code}}"
                                                                           role="tab"
                                                                           data-bs-toggle="tab">{{ $language->native }}  </a>
                                                                    </li>

                                                                @endforeach
                                                            </ul>

                                                        @endif
                                                    </div>

                                                    <div class="tab-content pt-3">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <div role="tabpanel"
                                                                 class="tab-pane fade @if (auth()->user()->language_code == $language->code)
                                    show active

                                @endif  "
                                                                 id="footer_about_description{{$language->code}}">
                                                                <div class="row justify-content-center mb-20 mt40">
                                                                    <div class="col-lg-12">
                                                                        <div class="input-effect">
                                                                            <label
                                                                                class="mb-2">{{__('footer.About Description')}}
                                                                                <span class="required_mark">*</span>
                                                                            </label>
                                                                            <textarea
                                                                                class="primary_input_field read-only-input h-120 pt-2"
                                                                                name="value[{{$language->code}}]"
                                                                                id="about_description">{!! $setting->where('key','footer_about_description')->first()->getTranslation('value',$language->code)??''  !!}</textarea>
                                                                            <span class="focus-border"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        @endforeach
                                                    </div>
                                                    <div class="row mt-30">

                                                        <div class="col-lg-12 text-center tooltip-wrapper" data-title=""
                                                             data-original-title="" title="">
                                                            <button
                                                                class="primary-btn fix-gr-bg tooltip-wrapper  text-nowrap"
                                                                type="{{$isDemo?'button':'submit'}}"
                                                                id="{{!$isDemo?'aboutDescriptionBtn':''}}" data-bs-toggle="tooltip"
                                                                title="{{$tooltip}}"
                                                                data-original-title="" title="">
                                                                <i class="ti-check"></i>
                                                                {{__('common.Update')}} </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif
                        @include('footersetting::footer.components.widget_create')

                        <div role="tabpanel" class="tab-pane {{ $footerTab == 3?'active show':'' }} fade"
                             id="footer_2">
                            <div class="row row-gap-24">
                                <div class="col-xxl-3 mt-4 mt-lg-0">

                                <div class="white-box">
                                        <div class="main-title">
                                            <h3 class="mb-20">
                                                {{__('common.Update')}}
                                            </h3>
                                        </div>
                                        <form method="POST" action=""
                                              accept-charset="UTF-8" class="form-horizontal"
                                              enctype="multipart/form-data"
                                              id="companyForm">
                                            <input type="hidden" name="key" value="footer_section_one_title">
                                            <div class="student-details header-menu">
                                                <div class="add-visitor">
                                                    <input type="hidden"
                                                           value="footer_section_one_title" name="key">
                                                    <div class="row pt-0">
                                                        @if(isModuleActive('FrontendMultiLang'))
                                                            <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                role="tablist">
                                                                @foreach ($LanguageList as $key => $language)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link  @if (auth()->user()->language_code == $language->code)
                                        active

                                    @endif"
                                                                           href="#footer_section_one_title{{$language->code}}"
                                                                           role="tab"
                                                                           data-bs-toggle="tab">{{ $language->native }}  </a>
                                                                    </li>

                                                                @endforeach
                                                            </ul>

                                                        @endif
                                                    </div>
                                                    <div class="tab-content pt-3">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <div role="tabpanel"
                                                                 class="tab-pane fade @if (auth()->user()->language_code == $language->code)
                                    show active

                                @endif  "
                                                                 id="footer_section_one_title{{$language->code}}">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="input-effect">
                                                                            <label
                                                                                class="mb-2">{{__('footer.Section name')}}
                                                                                <span
                                                                                    class="required_mark">*</span></label>
                                                                            <input
                                                                                class="primary_input_field read-only-input"

                                                                                type="text"
                                                                                name="value[{{$language->code}}]"
                                                                                autocomplete="off"
                                                                                value="{{ $setting->where('key','footer_section_one_title')->first()->getTranslation('value',$language->code)??''}}">
                                                                            <span class="focus-border"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        @endforeach
                                                    </div>
                                                    <div class="row mt-40">

                                                        <div class="col-lg-12 text-center tooltip-wrapper"
                                                             data-title=""
                                                             data-original-title="" title="">
                                                            <button
                                                                class="primary-btn fix-gr-bg tooltip-wrapper  text-nowrap"
                                                                data-original-title=""
                                                                id="{{!$isDemo?'companyBtn':''}}" data-bs-toggle="tooltip"
                                                                title="{{$tooltip}}"
                                                                type="{{$isDemo?'button':'submit'}}"

                                                                >
                                                                <i class="ti-check"></i>
                                                                {{__('common.Update')}} </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-xxl-9 mb-20">
                                    <div class="white-box">
                                        @if(permissionCheck('footerSetting.footer.widget-store'))
                                            <div class="d-flex justify-content-end">
                                                <a href="#" data-type="1"
                                                   class="primary-btn addWidget small fix-gr-bg mb-2 w-fit">{{__('footer.Add New Page')}}</a>
                                            </div>

                                        @endif
                                        <div class="QA_section QA_section_heading_custom check_box_table mt-20">
                                            <div class="QA_table">
                                                <!-- table-responsive -->
                                                <div class="">
                                                    <table class="table Crm_table_active3">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">{{ __('common.SL') }}</th>
                                                            <th scope="col">{{ __('common.Name') }}</th>
                                                            <th scope="col">{{ __('common.Status') }}</th>
                                                            <th scope="col">{{ __('common.Action') }}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($SectionOnePages as $key => $page)
                                                            <tr>
                                                                <td>{{$key +1}}</td>
                                                                <td>{{$page->name}}</td>
                                                                <td>
                                                                    @if(permissionCheck('footerSetting.footer.widget-status'))
                                                                        <label class="switch_toggle">
                                                                            <input type="checkbox"
                                                                                   onchange="statusChange('{{$page->id}}','{{$page->status}}')"
                                                                                   class=""
                                                                                   @if (@$page->status == 1)
                                                                                       checked


                                                                                   @endif value="{{@$page->id }}"/>
                                                                            <i class="slider round"></i>
                                                                        </label>

                                                                    @else
                                                                        {{$page->status==1?trans('common.Active'):trans('common.Inactive')}}
                                                                    @endif
                                                                </td>
                                                                <td>

                                                                    <div class="dropdown CRM_dropdown">
                                                                        <button
                                                                            class="btn btn-secondary dropdown-toggle"
                                                                            type="button" id="dropdownMenu2"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            {{ __('common.Select') }}
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right"
                                                                             aria-labelledby="dropdownMenu2">

                                                                            @if(permissionCheck('footerSetting.footer.widget-update'))
                                                                                <a href="javascript:void(0)"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#editModal"
                                                                                   class="dropdown-item edit_brand"
                                                                                   onclick="showEditModal({{$page}})">{{ __('common.Edit') }}</a>

                                                                            @endif
                                                                            @if(permissionCheck('footerSetting.footer.widget-delete'))
                                                                                <a href="javascript:void(0)"
                                                                                   class="dropdown-item edit_brand"
                                                                                   onclick="showDeleteModal({{$page->id}})">{{ __('common.Delete') }}</a>

                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div role="tabpanel" class="tab-pane {{ $footerTab == 4?'active show':'' }} fade"
                             id="footer_3">
                            <div class="row">
                                <div class="col-xxl-3 mt-4 mt-lg-0">
                                    <div class="white-box">
                                        <div class="main-title">
                                            <h3 class="mb-20">
                                                {{ __('common.Update') }} </h3>
                                        </div>
                                        <form method="POST" action=""
                                              accept-charset="UTF-8" class="form-horizontal"
                                              enctype="multipart/form-data"
                                              id="accountForm">
                                            <input type="hidden" name="key" value="footer_section_two_title">
                                            <div class="student-details header-menu">
                                                <div class="add-visitor">
                                                    <div class="row pt-0">
                                                        @if(isModuleActive('FrontendMultiLang'))
                                                            <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                role="tablist">
                                                                @foreach ($LanguageList as $key => $language)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link  @if (auth()->user()->language_code == $language->code)
                                        active

                                    @endif"
                                                                           href="#footer_section_two_title{{$language->code}}"
                                                                           role="tab"
                                                                           data-bs-toggle="tab">{{ $language->native }}  </a>
                                                                    </li>

                                                                @endforeach
                                                            </ul>

                                                        @endif
                                                    </div>
                                                    <div class="tab-content pt-3">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <div role="tabpanel"
                                                                 class="tab-pane fade @if (auth()->user()->language_code == $language->code)
                                    show active

                                @endif  "
                                                                 id="footer_section_two_title{{$language->code}}">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="input-effect">
                                                                            <label
                                                                                class="mb-2">{{__('footer.Section name')}}
                                                                                <span
                                                                                    class="required_mark">*</span></label>
                                                                            <input
                                                                                class="primary_input_field read-only-input"

                                                                                type="text"
                                                                                name="value[{{$language->code}}]"
                                                                                autocomplete="off"
                                                                                value="{{ $setting->where('key','footer_section_two_title')->first()->getTranslation('value',$language->code)??''}}">
                                                                            <span class="focus-border"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        @endforeach
                                                    </div>
                                                    <div class="row mt-40">

                                                        <div class="col-lg-12 text-center tooltip-wrapper"
                                                             data-title=""
                                                             data-original-title="" title="">
                                                            <button
                                                                class="primary-btn fix-gr-bg tooltip-wrapper  text-nowrap"
                                                                id="{{!$isDemo?'accountBtn':''}}" data-bs-toggle="tooltip"
                                                                title="{{$tooltip}}"
                                                                type="{{$isDemo?'button':'submit'}}"

                                                                >
                                                                <i class="ti-check"></i>
                                                                {{ __('common.Update') }} </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-xxl-9 mb-20">
                                    <div class="white-box">
                                        @if(permissionCheck('footerSetting.footer.widget-store'))

                                            <div class="d-flex justify-content-end">
                                                <a href="#" data-type="2"
                                                   class="primary-btn addWidget small fix-gr-bg mb-2 w-fit">{{__('footer.Add New Page')}}</a>
                                            </div>

                                        @endif
                                        <div class="QA_section QA_section_heading_custom check_box_table mt-20">
                                            <div class="QA_table">
                                                <!-- table-responsive -->
                                                <div class="">
                                                    <table class="table Crm_table_active3">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">{{ __('common.SL') }}</th>
                                                            <th scope="col">{{ __('common.Name') }}</th>
                                                            <th scope="col">{{ __('common.Status') }}</th>
                                                            <th scope="col">{{ __('common.Action') }}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($SectionTwoPages as $key => $page)
                                                            <tr>
                                                                <td>{{$key +1}}</td>
                                                                <td>{{$page->name}}</td>
                                                                <td>
                                                                    @if(permissionCheck('footerSetting.footer.widget-status'))
                                                                        <label class="switch_toggle">
                                                                            <input type="checkbox"
                                                                                   onchange="statusChange('{{$page->id}}','{{$page->status}}')"
                                                                                   @if (@$page->status == 1)  checked
                                                                                   @endif value="{{@$page->id }}">
                                                                            <i class="slider round"></i>
                                                                        </label>

                                                                    @else
                                                                        {{$page->status==1?trans('common.Active'):trans('common.Inactive')}}
                                                                    @endif
                                                                </td>
                                                                <td>

                                                                    <div class="dropdown CRM_dropdown">
                                                                        <button
                                                                            class="btn btn-secondary dropdown-toggle"
                                                                            type="button" id="dropdownMenu2"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            {{ __('common.Select') }}
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right"
                                                                             aria-labelledby="dropdownMenu2">
                                                                            @if(permissionCheck('footerSetting.footer.widget-update'))
                                                                                <a href="javascript:void(0)"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#editModal"
                                                                                   class="dropdown-item edit_brand"
                                                                                   onclick="showEditModal({{$page}})">{{ __('common.Edit') }}</a>

                                                                            @endif
                                                                            @if(permissionCheck('footerSetting.footer.widget-delete'))
                                                                                <a href="javascript:void(0)"
                                                                                   class="dropdown-item edit_brand"
                                                                                   onclick="showDeleteModal({{$page->id}})">{{ __('common.Delete') }}</a>

                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div role="tabpanel" class="tab-pane {{ $footerTab == 5?'active show':'' }} fade"
                             id="footer_4">
                            <div class="row">
                                <div class="col-xxl-3 mt-4 mt-lg-0">
                                    <div class="white-box">
                                        <div class="main-title">
                                            <h3 class="mb-20">
                                                {{__('common.Update')}} </h3>
                                        </div>
                                        <form method="POST" action=""
                                              accept-charset="UTF-8" class="form-horizontal"
                                              enctype="multipart/form-data"
                                              id="serviceForm">
                                            <input type="hidden" name="key" value="footer_section_three_title">
                                            <div class="student-details header-menu">
                                                <div class="add-visitor">
                                                    <div class="row pt-0">
                                                        @if(isModuleActive('FrontendMultiLang'))
                                                            <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                role="tablist">
                                                                @foreach ($LanguageList as $key => $language)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link  @if (auth()->user()->language_code == $language->code)
                                        active

                                    @endif"
                                                                           href="#footer_section_three_title{{$language->code}}"
                                                                           role="tab"
                                                                           data-bs-toggle="tab">{{ $language->native }}  </a>
                                                                    </li>

                                                                @endforeach
                                                            </ul>

                                                        @endif
                                                    </div>
                                                    <div class="tab-content pt-3">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <div role="tabpanel"
                                                                 class="tab-pane fade @if (auth()->user()->language_code == $language->code)
                                    show active

                                @endif  "
                                                                 id="footer_section_three_title{{$language->code}}">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="input-effect">
                                                                            <label
                                                                                class="mb-2">{{__('footer.Section name')}}
                                                                                <span
                                                                                    class="required_mark">*</span></label>
                                                                            <input
                                                                                class="primary_input_field read-only-input"

                                                                                type="text"
                                                                                name="value[{{$language->code}}]"
                                                                                autocomplete="off"
                                                                                value="{{$setting->where('key','footer_section_three_title')->first()->getTranslation('value',$language->code)??''}}">
                                                                            <span class="focus-border"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        @endforeach
                                                    </div>
                                                    <div class="row mt-40">

                                                        <div class="col-lg-12 text-center tooltip-wrapper"
                                                             data-title=""
                                                             data-original-title="" title="">
                                                            <button
                                                                id="{{!$isDemo?'serviceBtn':''}}" data-bs-toggle="tooltip"
                                                                title="{{$tooltip}}"
                                                                class="primary-btn fix-gr-bg tooltip-wrapper  text-nowrap"
                                                                type="{{$isDemo?'button':'submit'}}"
                                                            >
                                                                <i class="ti-check"></i>
                                                                {{__('common.Update')}} </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-xxl-9 mb-20">
                                    <div class="white-box">
                                        @if(permissionCheck('footerSetting.footer.widget-store'))
                                            <div class="d-flex justify-content-end">
                                                <a href="#" data-type="3"
                                                   class="primary-btn addWidget small fix-gr-bg mb-2 w-fit">{{__('footer.Add New Page')}}</a>
                                            </div>

                                        @endif
                                        <div class="QA_section QA_section_heading_custom check_box_table mt-20">
                                            <div class="QA_table">
                                                <!-- table-responsive -->
                                                <div class="">
                                                    <table class="table Crm_table_active3">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">{{ __('common.SL') }}</th>
                                                            <th scope="col">{{ __('common.Name') }}</th>
                                                            <th scope="col">{{ __('common.Status') }}</th>
                                                            <th scope="col">{{ __('common.Action') }}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($SectionThreePages as $key=> $page)
                                                            <tr>
                                                                <td>{{$key +1}}</td>
                                                                <td>{{$page->name}}</td>
                                                                <td>
                                                                    @if(permissionCheck('footerSetting.footer.widget-status'))
                                                                        <label class="switch_toggle">
                                                                            <input type="checkbox"
                                                                                   onchange="statusChange('{{$page->id}}','{{$page->status}}')"
                                                                                   class=""
                                                                                   @if (@$page->status == 1)  checked
                                                                                   @endif value="{{@$page->id }}">
                                                                            <i class="slider round"></i>
                                                                        </label>

                                                                    @else
                                                                        {{$page->status==1?trans('common.Active'):trans('common.Inactive')}}
                                                                    @endif
                                                                </td>

                                                                <td>

                                                                    <div class="dropdown CRM_dropdown">
                                                                        <button
                                                                            class="btn btn-secondary dropdown-toggle"
                                                                            type="button" id="dropdownMenu2"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            {{ __('common.Select') }}
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right"
                                                                             aria-labelledby="dropdownMenu2">

                                                                            @if(permissionCheck('footerSetting.footer.widget-update'))
                                                                                <a href="javascript:void(0)"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#editModal"
                                                                                   class="dropdown-item edit_brand"
                                                                                   onclick="showEditModal({{$page}})">{{ __('common.Edit') }}</a>

                                                                            @endif
                                                                            @if(permissionCheck('footerSetting.footer.widget-delete'))
                                                                                <a href="javascript:void(0)"
                                                                                   class="dropdown-item edit_brand"
                                                                                   onclick="showDeleteModal({{$page->id}})">{{ __('common.Delete') }}</a>

                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(currentTheme()=='tvt')
                            <div role="tabpanel" class="tab-pane {{ $footerTab == 6?'active show':'' }} fade"
                                 id="footer_6">
                                <div class="row">
                                    <div class="col-xxl-3 mt-4 mt-lg-0">
                                        <div class="white-box">
                                            <div class="main-title">
                                                <h3 class="mb-20">
                                                    {{__('common.Update')}} </h3>
                                            </div>
                                            <form method="POST" action=""
                                                  accept-charset="UTF-8" class="form-horizontal"
                                                  enctype="multipart/form-data"
                                                  id="aboutForm">
                                                <input type="hidden" name="key" value="footer_section_four_title">
                                                <div class="student-details header-menu">
                                                    <div class="add-visitor">
                                                        <div class="row pt-0">
                                                            @if(isModuleActive('FrontendMultiLang'))
                                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                    role="tablist">
                                                                    @foreach ($LanguageList as $key => $language)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                               href="#footer_section_four_title{{$language->code}}"
                                                                               role="tab"
                                                                               data-bs-toggle="tab">{{ $language->native }}  </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </div>
                                                        <div class="tab-content pt-3">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <div role="tabpanel"
                                                                     class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                                     id="footer_section_four_title{{$language->code}}">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="input-effect">
                                                                                <label
                                                                                    class="mb-2">{{__('footer.Section name')}}
                                                                                    <span
                                                                                        class="required_mark">*</span></label>
                                                                                <input
                                                                                    class="primary_input_field read-only-input"

                                                                                    type="text"
                                                                                    name="value[{{$language->code}}]"
                                                                                    autocomplete="off"
                                                                                    value="{{$setting->where('key','footer_section_four_title')->first()->getTranslation('value',$language->code)??''}}">
                                                                                <span class="focus-border"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="row mt-40">

                                                            <div class="col-lg-12 text-center tooltip-wrapper"
                                                                 data-title=""
                                                                 data-original-title="" title="">
                                                                <button
                                                                    class="primary-btn fix-gr-bg tooltip-wrapper  text-nowrap"
                                                                     id="{{!$isDemo?'aboutSectionBtn':''}}" data-bs-toggle="tooltip"
                                                                    title="{{$tooltip}}"
                                                                    type="{{$isDemo?'button':'submit'}}"

                                                                >
                                                                    <i class="ti-check"></i>
                                                                    {{__('common.Update')}} </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-xxl-9 mb-20">
                                        <div class="white-box">
                                            @if(permissionCheck('footerSetting.footer.widget-store'))
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" data-type="4"
                                                       class="primary-btn addWidget small fix-gr-bg mb-2 w-fit">{{__('footer.Add New Page')}}</a>
                                                </div>
                                            @endif
                                            <div class="QA_section QA_section_heading_custom check_box_table mt-20">
                                                <div class="QA_table">
                                                    <!-- table-responsive -->
                                                    <div class="">
                                                        <table class="table Crm_table_active3">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">{{ __('common.SL') }}</th>
                                                                <th scope="col">{{ __('common.Name') }}</th>
                                                                <th scope="col">{{ __('common.Status') }}</th>
                                                                <th scope="col">{{ __('common.Action') }}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($SectionFourPages as $key=> $page)
                                                                <tr>
                                                                    <td>{{$key +1}}</td>
                                                                    <td>{{$page->name}}</td>
                                                                    <td>
                                                                        @if(permissionCheck('footerSetting.footer.widget-status'))
                                                                            <label class="switch_toggle">
                                                                                <input type="checkbox"
                                                                                       onchange="statusChange('{{$page->id}}','{{$page->status}}')"
                                                                                       @if (@$page->status == 1) checked
                                                                                       @endif value="{{@$page->id }}">
                                                                                <i class="slider round"></i>
                                                                            </label>
                                                                        @else
                                                                            {{$page->status==1?trans('common.Active'):trans('common.Inactive')}}
                                                                        @endif
                                                                    </td>

                                                                    <td>

                                                                        <div class="dropdown CRM_dropdown">
                                                                            <button
                                                                                class="btn btn-secondary dropdown-toggle"
                                                                                type="button" id="dropdownMenu2"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                {{ __('common.Select') }}
                                                                            </button>
                                                                            <div
                                                                                class="dropdown-menu dropdown-menu-right"
                                                                                aria-labelledby="dropdownMenu2">


                                                                                @if(permissionCheck('footerSetting.footer.widget-update'))
                                                                                    <a href="javascript:void(0)"
                                                                                       data-bs-toggle="modal"
                                                                                       data-bs-target="#editModal"
                                                                                       class="dropdown-item edit_brand"
                                                                                       onclick="showEditModal({{$page}})">{{ __('common.Edit') }}</a>
                                                                                @endif
                                                                                @if(permissionCheck('footerSetting.footer.widget-delete'))
                                                                                    <a href="javascript:void(0)"
                                                                                       class="dropdown-item edit_brand"
                                                                                       onclick="showDeleteModal({{$page->id}})">{{ __('common.Delete') }}</a>
                                                                                @endif

                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        @include('footersetting::footer.components.widget_edit')
        @include('footersetting::footer.components.delete')
    </section>

@endsection

@include('footersetting::footer.components.scripts')
