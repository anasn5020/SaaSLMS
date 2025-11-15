@extends('backend.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-between">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <form action="{{route('appearance.themes-customize.settingUpdate')}}" method="POST">
                            @csrf
                            <div class="row">
                                @if(currentTheme()!='wetech')
                                    <div class="col-xl-6">
                                        <div class="primary_input">
                                            <label class="primary_input_label"

                                                   for="">{{__('frontendmanage.Global Theme Color')}}</label>
                                            <div class="primary_datepicker_input">
                                                <div class="input-right-icon container">
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col-md-2 mb-25 ps-0">
                                                                <label class="primary_checkbox d-flex me-12"
                                                                       for="frontend_global_color_scheme">
                                                                    <input type="radio"
                                                                           class="common-radio "
                                                                           id="frontend_global_color_scheme"
                                                                           name="frontend_global_color_scheme"
                                                                           {{Settings('frontend_global_color_scheme')=="yes"?'checked':''}}
                                                                           value="yes">
                                                                    <span
                                                                        class="checkmark me-2"></span> {{__('common.Yes')}}
                                                                </label>
                                                            </div>
                                                            <div class="col-md-2 mb-25  ps-0">
                                                                <label class="primary_checkbox d-flex me-12"
                                                                       for="frontend_global_color_scheme_no">
                                                                    <input type="radio"
                                                                           class="common-radio "
                                                                           id="frontend_global_color_scheme_no"
                                                                           name="frontend_global_color_scheme"
                                                                           {{Settings('frontend_global_color_scheme')=="yes"?'':'checked'}}
                                                                           value="no">
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
                                @else
                                    <div class="col-xl-4">
                                        <div class="primary_input mb-15">

                                            <div class="primary_input">
                                                <label class="primary_input_label"
                                                       for="">{{__('frontendmanage.Select Theme Scheme')}}</label>
                                                <select class="primary_select mb-15 theme" name="wetech_color"
                                                        id="wetech_color">
                                                    @foreach($colors as $key=>$color)
                                                        <option
                                                            value="{{$key}}" {{Settings('wetech_color')==$key?'selected':''}}>{{$color['name']??''}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">{{$errors->first('wetech_color')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12  ">
                                    <div class="  text-center">
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
            </div>
            @if(currentTheme()!='wetech')
                <div class="white-box">

                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-flex flex-wrap">
                                    <h3 class="mb-0 me-30 mb_xs_15px mb_sm_20px" id="page_title">{{__('setting.Frontend Theme Color')}}</h3>
                                    @if(permissionCheck('appearance.themes-customize.index'))
                                        <a class="primary-btn radius_30px me-10 fix-gr-bg "

                                           href="{{ route('appearance.themes-customize.create') }}"><i
                                                class="ti-plus"></i>{{__('setting.Add New')}}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table ">
                                    <!-- table-responsive -->
                                    <div class="">
                                        <table class="table Crm_table_active3">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('common.SL')}}</th>
                                                <th scope="col">{{__('common.Title')}}</th>
                                                <th scope="col">{{__('common.Theme')}}</th>
                                                <th scope="col">{{__('setting.Primary Color')}}</th>
                                                <th scope="col">{{__('setting.Primary Color')}}(2)</th>
                                                <th scope="col">{{__('setting.Secondary Color')}}</th>
                                                <th scope="col">{{__('common.Status')}}</th>
                                                <th scope="col">{{__('common.Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
@php
$i=0;
@endphp
                                            @foreach($themes as $theme)
                                                @php
                                                    if($theme->theme->name!=currentTheme()){
                                                        continue;
                                                    }
                                                @endphp


                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $theme->name }}</td>
                                                    <td>{{ $theme->theme->title }}</td>
                                                    <td>
                                                        <div class="row text-center">
                                                            <div class="col-6">
                                                                {{ $theme->primary_color }}
                                                            </div>
                                                            <div class="col-6">
                                                                <div
                                                                    style="height: 20px;width: 50px;background:      {{ $theme->primary_color }}"></div>
                                                            </div>
                                                        </div>


                                                    </td>
                                                    <td>
                                                        <div class="row text-center">
                                                            <div class="col-6">
                                                                {{ $theme->gradient_color }}
                                                            </div>
                                                            <div class="col-6">
                                                                <div
                                                                    style="height: 20px;width: 50px;background:      {{ $theme->gradient_color }}"></div>
                                                            </div>
                                                        </div>


                                                    </td>
                                                    <td>

                                                        <div class="row text-center">
                                                            <div class="col-6">
                                                                {{ $theme->secondary_color }}
                                                            </div>
                                                            <div class="col-6">
                                                                <div
                                                                    style="height: 20px;width: 50px;background:      {{ $theme->secondary_color }}"></div>
                                                            </div>
                                                        </div>

                                                    </td>

                                                    <td>
                                                        @if(!empty($theme->theme->id))
                                                            @if(@$theme->is_default==1)
                                                                <button type="button"
                                                                        class="primary-btn small fix-gr-bg w-fit"> @lang('common.Active') </button>
                                                            @else
                                                                @if(env('APP_SYNC'))
                                                                    <span class="d-inline-block" tabindex="0"
                                                                          data-bs-toggle="tooltip"
                                                                          title="Disabled For Demo ">
                                                            <a class="primary-btn small tr-bg text-nowrap  w-fit"
                                                               href="#"> @lang('common.Make Default')</a>
                                                </span>

                                                                @else
                                                                    <a class="primary-btn small tr-bg text-nowrap  w-fit"
                                                                       href="{{route('appearance.themes-customize.default',@$theme->id)}}"> @lang('common.Make Default') </a>

                                                                @endif
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>

                                                        <div class="dropdown CRM_dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle"
                                                                    type="button"
                                                                    id="dropdownMenu2" data-bs-toggle="dropdown"
                                                                    aria-haspopup="true"
                                                                    aria-expanded="false"> {{__('common.Select')}}
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right"
                                                                 aria-labelledby="dropdownMenu2">
                                                                @if ($theme->id != 1)

                                                                    <a class="dropdown-item"
                                                                       href="{{ route('appearance.themes-customize.edit', $theme->id) }}">@lang('common.Edit')</a>

                                                                @endif


                                                                <a class="dropdown-item"
                                                                   type="button"
                                                                   href="{{ route('appearance.themes-customize.copy', $theme->id) }}">@lang('setting.Clone Theme')</a>

                                                                @if ($theme->id != 1)
                                                                    @if(permissionCheck('appearance.themes-customize.destroy'))
                                                                        <a class="dropdown-item"
                                                                           type="button" data-bs-toggle="modal"
                                                                           data-bs-target="#deletebackground_settingModal{{@$theme->id}}"
                                                                           href="#">@lang('common.Delete')</a>
                                                                    @endif
                                                                @endif

                                                            </div>
                                                        </div>

                                                    </td>

                                                    <div class="modal fade admin-query"
                                                         id="deletebackground_settingModal{{@$theme->id}}">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">@lang('common.Delete')</h4>
                                                                    <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"><i
                                                                            class="ti-close"></i>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="text-center">
                                                                        <h4>@lang('common.Are you sure to delete ?')</h4>
                                                                    </div>

                                                                    <div class="mt-40 d-flex justify-content-between">
                                                                        <button type="button" class="primary-btn tr-bg"
                                                                                data-bs-dismiss="modal">@lang('common.Cancel')
                                                                        </button>

                                                                        <form method="POST" action="{{ route('appearance.themes-customize.destroy', $theme->id) }}">
                                                                            @method('DELETE')
                                                                            @csrf                                                                        <button type="submit"
                                                                                class="primary-btn fix-gr-bg">@lang('common.Delete')</button>
                                                                        </form>


                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
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
            @endif
        </div>
    </section>
@endsection
@push('scripts')
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, ]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
