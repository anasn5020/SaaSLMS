@extends('backend.master')
@push('styles')
    <style>
        .image_td {
            width: 120px;
            height: 90px;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .custom-hr {
            background-color: rgba(0, 0, 0, .1);
            width: 100%;
            height: 2px;
        }
    </style>
@endpush
@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">

                @if($active_sms_gateways->count() > 0 && permissionCheck('admin.send_test_sms'))
                    <div class="col-lg-12">
                        <div class="white_box mb_30">
                            <div class="white_box_tittle list_header">
                                <h4>{{__('setting.Send Test Sms')}} </h4>
                            </div>

                            <form action="{{route('admin.send_test_sms')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="receiver_number">{{ __('setting.Receiver Number') }}
                                                <small>({{__('profile.With Country Code without plus')}}
                                                    )</small><strong
                                                    class="text-danger">*</strong></label>
                                            <input name="receiver_number" class="primary_input_field"
                                                   placeholder="-" type="text" id="receiver_number">
                                            <span class="text-danger">{{$errors->first('receiver_number')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="message">{{ __('setting.Message') }} <strong
                                                    class="text-danger">*</strong></label>
                                            <input name="message" class="primary_input_field"
                                                   placeholder="-" type="text" id="message">
                                            <span class="text-danger">{{$errors->first('message')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <button type="submit" class="primary-btn radius_30px  fix-gr-bg  mt-1">
                                            {{ __('setting.Send') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif


                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-12   ">
                                <div class="box_header common_table_header">
                                    <div class="main-title d-md-flex">
                                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{ __('setting.Sms Gateways') }}</h3>
                                        <ul class="d-flex">
                                            @if (permissionCheck('admin.sms_settings.create'))
                                                <li>
                                                    <a class="primary-btn radius_30px   fix-gr-bg"
                                                       href="{{route('admin.sms_settings.create')}}">
                                                        <i class="ti-plus"></i>{{ __('common.Add New') }}
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table Crm_table_active3">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.SL') }}</th>
                                            <th scope="col">{{ __('setting.Gateway Name') }}</th>
                                            <th scope="col">{{ __('common.Logo') }}</th>
                                            <th scope="col">{{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sms_gateways as $key=>$row)
                                            <tr>
                                                <th>{{ $key+1 }}</th>
                                                <td>{{ $row->gateway_name }}</td>
                                                <td>
                                                    <img class="image_td" src="{{showImage($row->gateway_logo)}}"
                                                         alt="logo">
                                                </td>
                                                <td>

                                                    <div>
                                                        <label class="switch_toggle">
                                                            <input type="checkbox"
                                                                   class="{{permissionCheck('admin.sms_settings.status')?'gateway_status_update':""}}"
                                                                   @if ($row->status == 1) checked
                                                                   @endif value="{{$row->id}}">
                                                            <i class="slider round"></i>
                                                        </label>
                                                    </div>

                                                </td>
                                                <td>

                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu2" data-bs-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu2">

                                                            @if (permissionCheck('admin.sms_settings.show'))
                                                                <a data-id="{{$row->id}}" href="javascript:void(0);"
                                                                   class="dropdown-item show_gateway_item"
                                                                >{{__('common.View')}}
                                                                </a>
                                                            @endif

                                                            @if (permissionCheck('admin.sms_settings.edit'))
                                                                <a href="{{route('admin.sms_settings.edit',$row->id)}}"
                                                                   class="dropdown-item"
                                                                >{{__('common.Edit')}}</a>
                                                            @endif

                                                            @if (permissionCheck('admin.sms_settings.destroy'))
                                                                <a onclick="confirm_modal('{{route('admin.sms_settings.destroy', $row->id)}}');"
                                                                   class="dropdown-item">{{__('common.Delete')}}</a>
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
    <div id="append_html"></div>
    <input type="hidden" id="status_change_url" value="{{route('admin.sms_settings.status')}}">
    <input type="hidden" id="gateway_show_route" value="{{route('admin.sms_settings.show',':id')}}">
    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script src="{{asset('public/modules/profile/repeater/repeater.js')}}"></script>
    <script src="{{asset('public/modules/profile/repeater/indicator-repeater.js')}}"></script>
    <script>
        (function ($) {
            "use strict";
            let _token = $('meta[name=_token]').attr('content');
            $(document).ready(function () {

                $(document).on('change', '.gateway_status_update', function (event) {
                    event.preventDefault();
                    let status = 0;
                    if ($(this).prop('checked')) {
                        status = 1;
                    } else {
                        status = 0;
                    }
                    let id = $(this).val();
                    let formData = new FormData();
                    formData.append('_token', _token);
                    formData.append('id', id);
                    formData.append('status', status);
                    $.ajax({
                        url: $('#status_change_url').val(),
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            toastr.success(response.msg);
                            location.reload();
                        },
                        error: function (response) {
                            toastr.error("Something went wrong");
                        }
                    });
                });
                $(document).on('click', '.show_gateway_item', function (event) {
                    event.preventDefault();
                    let id = $(this).data('id');
                    let url = $('#gateway_show_route').val();
                    url = url.replace(':id', id);
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function (response) {
                            $('#append_html').html(response);
                            $('#show_gateway_modal').modal('show');
                        },
                        error: function (response) {
                            toastr.error(response.responseJSON.error);
                        }
                    });

                });


            });

        })(jQuery);

    </script>

    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, ]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>

@endpush
