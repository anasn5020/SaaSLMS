@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('Modules/SidebarManager/Resources/assets/css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('Modules/SidebarManager/Resources/assets/css/icon-picker.css')}}"/>
@endpush

@section('mainContent')
    @php
        $LanguageList = getLanguageList();
    @endphp
    {{generateBreadcrumb()}}
    <div class="role_permission_wrap">
        <div class="permission_title d-flex flex-wrap justify-content-between mb_20">
            <h4>
                {{ trans('setting.Sidebar Manager') }}
            </h4>
            <a href="{{route('sidebar-manager.resetPermissionCache')}}" id=" "
               class="primary-btn radius_30px   fix-gr-bg">{{__('setting.Clear Cache')}}</a>
            <a href="#" id="resetMenu"
               class="primary-btn radius_30px   fix-gr-bg">{{__('setting.Reset to default')}}</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb_20">
            <div class="white-box available_box  student-details ">
                <div class="add-visitor">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header pt-0 pb-0" id="headingOne">
                                <h5 class="mb-0 create-title" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="false"
                                    aria-controls="collapseOne">
                                    <button class="btn btn-link add_btn_link">
                                        {{__('common.Add')}}       {{__('common.Section')}}
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                 data-parent="#accordion">
                                <div class="card-body">
                                    <form action="" id="addSectionForm">
                                        <div class="row pt-0">
                                            @if(isModuleActive('FrontendMultiLang') || isModuleActive('Org'))
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
                                        <div id="row_element_div">
                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="name">{{ __('common.Name') }} <span
                                                                            class="textdanger">*</span>
                                                                    </label>
                                                                    <input class="primary_input_field name section_name"
                                                                           type="text"
                                                                           id=""
                                                                           name="name[{{$language->code}}]"
                                                                           autocomplete="off"
                                                                           placeholder="{{__('common.Name')}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{__('common.Icon')}}


                                                            </label>
                                                            <input class="primary_input_field" placeholder=""
                                                                   type="text" id="sectionIcon"
                                                                   name="icon"
                                                                   value=" ">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <button id="addSectionBtn" type="button"
                                                        class="primary-btn fix-gr-bg submit_btn "
                                                        data-bs-toggle="tooltip"
                                                        title="" data-original-title="">
                                                    <i class="ti-check"></i>
                                                    {{__('common.Save')}} </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if(isModuleActive('Org'))
                            <div class="card mt-2">
                                <div class="card-header pt-0 pb-0" id="headingTwo">
                                    <h5 class="mb-0 create-title" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <button class="btn btn-link add_btn_link">
                                            {{__('common.Add')}}       {{__('common.Menu')}}
                                        </button>
                                    </h5>
                                </div>
                                @if(isModuleActive('Org') || isModuleActive('FrontendMultiLang'))
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                         data-parent="#accordion">
                                        <div class="card-body">
                                            <form action="" id="addMenuForm">

                                                <div class="row pt-0">
                                                    @if(isModuleActive('FrontendMultiLang') || isModuleActive('Org'))
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

                                                    <div class="col-lg-12">
                                                        <div class="tab-content">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <div role="tabpanel"
                                                                     class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                                     id="element1{{$language->code}}">


                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="name">{{ __('common.Label') }} <span
                                                                                class="textdanger">*</span>
                                                                        </label>
                                                                        <input
                                                                            class="primary_input_field name menu_name"
                                                                            type="text"
                                                                            name="label[{{$language->code}}]"
                                                                            autocomplete="off"
                                                                            placeholder="{{__('common.Label')}}">
                                                                    </div>


                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="name">{{ __('common.Route') }} {{ __('common.Name') }}

                                                                <span
                                                                    class="textdanger">*</span>
                                                            </label>
                                                            <input class="primary_input_field name route_name"
                                                                   type="text"

                                                                   name="route" autocomplete="off"
                                                                   placeholder="{{__('common.Route')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center">
                                                        <button id="addMenuBtn" type="button"
                                                                class="primary-btn fix-gr-bg submit_btn"
                                                                data-bs-toggle="tooltip"
                                                                title="" data-original-title="">
                                                            <i class="ti-check"></i>
                                                            {{__('common.Save')}} </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        @endif
                    </div>
                    <div class="mt_20" id="available_menu_div">
                        @include('sidebarmanager::components.available_list')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb_20">
            <div class="white-box">
                <input type="hidden" name="data" id="items-data" value="">
                <div class="add-visitor" id="menu_idv">
                    @include('sidebarmanager::components.components')
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="white-box">
                <div class="add-visitor" id="live_preview_div">
                    @include('sidebarmanager::components.live_preview')
                </div>
            </div>
        </div>
    </div>

    {{--    @include('sidebarmanager::components.edit_modal')--}}



    <input type="hidden" id="order_change_url" value="{{route('sidebar-manager.menu-update')}}">
    <input type="hidden" id="reset_sidebar_url" value="{{route("sidebar-manager.reset-own-menu")}}">
    <input type="hidden" id="section_store_url" value="{{route("sidebar-manager.section.store")}}">
    <input type="hidden" id="section_delete_url" value="{{route("sidebar-manager.delete-section")}}">
    <input type="hidden" id="menu_delete_url" value="{{route("sidebar-manager.menu-store")}}">
    <input type="hidden" id="menu_remove_url" value="{{route("sidebar-manager.menu-remove")}}">
    <input type="hidden" id="menu_section_url" value="{{route("sidebar-manager.section-edit")}}">
    <input type="hidden" id="menu_edit_url" value="{{route("sidebar-manager.menu-edit")}}">
    <input type="hidden" id="section_sort_url" value="{{route("sidebar-manager.sort-section")}}">
@endsection



@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{asset('Modules/SidebarManager/Resources/assets/js/icon-picker.js')}}"></script>

    <script>
        $(document).on('mouseover', 'body', function () {
            $('#sectionIcon').iconpicker({
                animation: true,
                hideOnSelect: true
            });
        });
    </script>

@endpush
