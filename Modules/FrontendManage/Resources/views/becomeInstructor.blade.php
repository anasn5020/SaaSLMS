@extends('backend.master')
@section('table')
    {{__('testimonials')}}
@endsection
@section('mainContent')
    @php
        $LanguageList = getLanguageList();
    @endphp
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-end">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-7">
                                <div class="box_header common_table_header">
                                    <div class="main-title d-flex flex-wrap mb-0">
                                        <h3 class="mb-0" id="page_title">{{__('frontendmanage.Become Instructor')}} </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5 text-end">
                                <a target="_blank" href="{{route('becomeInstructor')}}"
                                   class="primary-btn small fix-gr-bg w-fit float-end"> <span
                                        class="ti-eye pe-2"></span> {{__('student.Preview')}} </a>
                            </div>
                        </div>
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table Crm_table_active3">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{__('common.Section')}} </th>
                                            <th scope="col">{{__('common.Title')}}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach($settings as $key => $setting)
                                            <tr>
                                                <td>{{ translatedNumber($key+1) }}</td>
                                                <td>{{ucfirst(str_replace('_',' ',$setting->section))}}</td>
                                                <td>{{$setting->title}}</td>
                                                <td>
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu2" data-bs-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false">
                                                            {{__('common.Action')}}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu2">
                                                            <a href="#" data-bs-toggle="modal"
                                                               data-bs-target="#editSetting{{@$setting->id}}"
                                                               class="dropdown-item"
                                                               type="button">{{__('common.Edit')}}</a>
                                                            @if($setting->id==6)
                                                                <a href="{{route('frontend.workProcess')}}"
                                                                   class="dropdown-item"
                                                                   type="button">{{__('setting.Manage')}}</a>
                                                            @endif

                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>

                                            <div class="modal fade admin-query" id="editSetting{{@$setting->id}}">
                                                <div class="modal-dialog modal_1000px modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">{{__('common.Edit')}}  </h4>
                                                            <button type="button" class="close "
                                                                    data-bs-dismiss="modal">
                                                                <i class="ti-close "></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body  student-details header-menu">
                                                            <form action="{{route('frontend.becomeInstructorUpdate')}}"
                                                                  method="POST"
                                                                  enctype="multipart/form-data">

                                                                @csrf
                                                                <input name="id"
                                                                       value="{{@$setting->id}}"

                                                                       type="hidden">


                                                                <div class="row pt-0">
                                                                    @if(isModuleActive('FrontendMultiLang'))
                                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                                            role="tablist">
                                                                            @foreach ($LanguageList as $key => $language)
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                                       href="#element{{@$setting->id}}{{$language->code}}"
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
                                                                             id="element{{@$setting->id}}{{$language->code}}">
                                                                            <div class="row">
                                                                                @if($setting->id==6)
                                                                                    <div class="col-xl-12">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <label
                                                                                                class="primary_input_label"
                                                                                                for=""> {{__('common.Section')}} </label>
                                                                                            <input
                                                                                                class="primary_input_field"
                                                                                                name="section[{{$language->code}}]"
                                                                                                value="{{@$setting->getTranslation('section',$language->code)}}"
                                                                                                placeholder="-"
                                                                                                type="text">
                                                                                        </div>
                                                                                    </div>
                                                                                @endif

                                                                                <div class="col-xl-12">
                                                                                    <div class="primary_input mb-25">
                                                                                        <label
                                                                                            class="primary_input_label"
                                                                                            for=""> {{__('common.Title')}} </label>
                                                                                        <input
                                                                                            class="primary_input_field"
                                                                                            name="title[{{$language->code}}]"
                                                                                            value="{{@$setting->getTranslation('title',$language->code)}}"
                                                                                            placeholder="-"
                                                                                            type="text">
                                                                                    </div>
                                                                                </div>
                                                                                @if($setting->id!=6)
                                                                                    <div class="col-xl-12">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <label
                                                                                                class="primary_input_label"
                                                                                                for=""> {{__('common.Details')}} </label>
                                                                                            <input
                                                                                                class="primary_input_field"
                                                                                                name="description[{{$language->code}}]"
                                                                                                value="{{@$setting->getTranslation('description',$language->code)}}"
                                                                                                placeholder="-"
                                                                                                type="text">
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if($setting->id==4 || $setting->id==5)
                                                                                    <div class="col-xl-12">
                                                                                        <div
                                                                                            class="primary_input mb-25">
                                                                                            <label
                                                                                                class="primary_input_label"
                                                                                                for=""> {{__('frontendmanage.Button Name')}} </label>
                                                                                            <input
                                                                                                class="primary_input_field"
                                                                                                name="btn_name[{{$language->code}}]"
                                                                                                value="{{@$setting->getTranslation('btn_name',$language->code)}}"
                                                                                                placeholder="Become instructor"
                                                                                                type="text">
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>

                                                                <div class="row">

                                                                    @if($setting->id==4)
                                                                        <div class="col-xl-12">

                                                                            <div class="primary_input mb-25">
                                                                                <label class="primary_input_label"
                                                                                       for=""> {{__('frontendmanage.Background Image')}} </label>
                                                                                <div class="primary_file_uploader">
                                                                                    <input
                                                                                        class="primary-input filePlaceholder"
                                                                                        type="text"
                                                                                        id="placeholderFileOneName"
                                                                                        placeholder="{{__('frontendmanage.Browse Image')}}"
                                                                                        readonly="">
                                                                                    <button class="" type="button">
                                                                                        <label
                                                                                            class="primary-btn small fix-gr-bg"
                                                                                            for="document_file_3_edit_{{@$setting->id}}">{{__('common.Browse') }}</label>
                                                                                        <input type="file"
                                                                                               class="d-none fileUpload"
                                                                                               name="bg_image"
                                                                                               id="document_file_3_edit_{{@$setting->id}}">
                                                                                    </button>


                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    @if($setting->id==1 || $setting->id==2 ||$setting->id==3)
                                                                        <div class="col-xl-12">

                                                                            <div class="primary_input mb-25">
                                                                                <label class="primary_input_label"
                                                                                       for=""> {{__('frontendmanage.Icon')}} </label>
                                                                                <select name="icon" id="icon"
                                                                                        class="primary_select">
                                                                                    @php
                                                                                        $name = explode("-", $setting->icon);
                            $name1 = explode($name[0].'-', $setting->icon);
                                                                                    @endphp
                                                                                    <option value="{{$setting->icon}}">
                                                                                        <i class="{{$setting->icon}}"></i> {{$name1[1]??''}}
                                                                                    </option>

                                                                                    {!! returnList() !!}
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    @if($setting->id==6)
                                                                        <div class="col-xl-12">
                                                                            <div class="primary_input mb-25">
                                                                                <label class="primary_input_label"
                                                                                       for=""> {{__('courses.Image')}} </label>
                                                                                <div class="primary_file_uploader">
                                                                                    <input class="primary-input"
                                                                                           type="text"
                                                                                           id="placeholderFileOneName"
                                                                                           placeholder="{{__('frontendmanage.Browse Image')}}"
                                                                                           readonly="">
                                                                                    <button class="" type="button">
                                                                                        <label
                                                                                            class="primary-btn small fix-gr-bg"
                                                                                            for="document_file_3_edit_{{@$setting->id}}">{{__('common.Browse') }}</label>
                                                                                        <input type="file"
                                                                                               class="d-none"
                                                                                               name="image"
                                                                                               id="document_file_3_edit_{{@$setting->id}}">
                                                                                    </button>


                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-xl-12">
                                                                            <div class="primary_input mb-25">
                                                                                <label class="primary_input_label"
                                                                                       for=""> {{__('courses.Video URL')}} </label>
                                                                                <input class="primary_input_field"
                                                                                       name="video"
                                                                                       value="{{@$setting->video}}"
                                                                                       placeholder="{{__('frontendmanage.Youtube Video Link')}}"
                                                                                       type="text">
                                                                            </div>
                                                                        </div>
                                                                    @endif


                                                                </div>


                                                                <div class="col-lg-12 text-center pt_15">
                                                                    <div class="d-flex justify-content-center">
                                                                        <button
                                                                            class="primary-btn semi_large2  fix-gr-bg"
                                                                            id="save_button_parent" type="submit"><i
                                                                                class="ti-check"></i> {{__('common.Update')}}
                                                                        </button>
                                                                    </div>
                                                                </div>


                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    </section>

@endsection
@push('scripts')
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
