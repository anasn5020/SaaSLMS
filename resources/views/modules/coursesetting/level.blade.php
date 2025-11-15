@extends('backend.master')
@php
    $table_name = 'course_levels';
@endphp
@section('table')
    {{ $table_name }}
@endsection
@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-xxl-3">
                    <div class="white-box mb_30  student-details header-menu">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">
                                    @if (!isset($edit))
                                        {{ __('courses.Add New Level') }}
                                    @else
                                        {{ __('courses.Update Level') }}
                                    @endif
                                </h3>
                            </div>
                        </div>
                        @if (isset($edit))
                            @if (permissionCheck('course-level.update'))
                                <form action="{{ route('course-level.update', $edit->id) }}" method="POST"
                                      id="category-form"
                                      name="category-form" enctype="multipart/form-data">
                                    @endif
                                    <input type="hidden" name="id" value="{{ @$edit->id }}">
                                    @method('PATCH')
                                    @else
                                        @if (permissionCheck('course-level.store'))
                                            <form action="{{ route('course-level.store') }}" method="POST"
                                                  id="category-form"
                                                  name="category-form" enctype="multipart/form-data">
                                                @endif
                                                @endif

                                                @csrf
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
                                                            <div class="row">


                                                                <div class="col-xl-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="nameInput">{{ __('common.Title') }}
                                                                            <strong
                                                                                class="text-danger">*</strong></label>
                                                                        <input name="title[{{ $language->code }}]"
                                                                               id="nameInput"
                                                                               class="primary_input_field title {{ @$errors->has('title') ? ' is-invalid' : '' }}"
                                                                               placeholder="{{ __('common.Title') }}"
                                                                               type="text"
                                                                               value="{{isset($edit)?$edit->getTranslation('title',$language->code):old('title.'.$language->code)}}">

                                                                        @if ($errors->has('title'))
                                                                            <span class="invalid-feedback d-block mb-10"
                                                                                  role="alert">
                                                        <strong>{{ @$errors->first('title') }}</strong>
                                                    </span>
                                                                        @endif
                                                                    </div>
                                                                </div>


                                                                @php
                                                                    $tooltip = '';
                                                                    if (permissionCheck('course-level.store') || permissionCheck('course-level.update')) {
                                                                        $tooltip = '';
                                                                    } else {
                                                                        $tooltip = _trans('courses.You have no permission');
                                                                    }
                                                                @endphp
                                                                <div class="col-lg-12 text-center">
                                                                    <div class="d-flex justify-content-center pt_20">
                                                                        <button type="submit"
                                                                                class="primary-btn semi_large fix-gr-bg"
                                                                                data-bs-toggle="tooltip"
                                                                                title="{{ @$tooltip }}"
                                                                                id="save_button_parent">
                                                                            <i class="ti-check"></i>
                                                                            @if (!isset($edit))
                                                                                {{ __('common.Save') }}
                                                                            @else
                                                                                {{ __('common.Update') }}
                                                                            @endif
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endforeach
                                                </div>

                                            </form>
                    </div>
                </div>
                <div class="col-xxl-9">
                    <div class="white-box">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="" id="page_title">{{ __('courses.Level List') }}</h3>
                            </div>
                        </div>
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table table-data">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('common.Title') }}</th>
                                            <th scope="col">{{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($levels as $key => $level)
                                            <tr>
                                                <th class="m-2">{{ translatedNumber($key + 1) }}</th>
                                                <td>{{ @$level->title }}</td>
                                                <td class="nowrap level_status" data-statue_value="{{$level->status}}">
                                                    @php
                                                        if (isModuleActive('Organization')) {
                                                            $org_id = $level->organization_id;
                                                        } else {
                                                            $org_id = null;
                                                        }

                                                    @endphp
                                                    <x-backend.status :org="$org_id" :id="$level->id"
                                                                      :status="$level->status"
                                                                      :route="'course-level.changeStatus'">
                                                    </x-backend.status>
                                                </td>
                                                <td>
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu1{{ @$level->id }}"
                                                                data-bs-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu1{{ @$level->id }}">
                                                            @if (permissionCheck('course-level.update') && orgPermission($level->organization_id))
                                                                <a class="dropdown-item edit_brand"
                                                                   href="{{ route('course-level.edit', @$level->id) }}">{{ __('common.Edit') }}</a>
                                                            @endif
                                                            @if (permissionCheck('course-level.destroy') && orgPermission($level->organization_id))
                                                                <a onclick="confirm_modal('{{ route('course-level.destroy', @$level->id) }}');"
                                                                   class="dropdown-item edit_brand">{{ __('common.Delete') }}</a>
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
    </section>
    <div id="edit_form">

    </div>
    <div id="view_details">

    </div>


    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush

