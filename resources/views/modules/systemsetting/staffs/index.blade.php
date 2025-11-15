@extends('backend.master')
@php
    $table_name='users';
@endphp
@section('table')
    {{$table_name}}
@endsection
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{ __('common.Staff List') }}</h3>
                                @if(permissionCheck('staffs.store'))
                                    <ul class="d-flex">
                                        <li><a class="primary-btn radius_30px   fix-gr-bg"
                                               href="{{ route('staffs.create') }}"><i
                                                    class="ti-plus"></i>{{ __('common.Add New') }} {{ __('common.Staff') }}
                                            </a></li>
                                        {{-- <li><a class="primary-btn radius_30px   fix-gr-bg" href="{{route('staffs.csv_upload')}}"><i class="ti-export"></i>{{__('leave.Upload Via CSV')}}</a></li> --}}
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table"  class="table Crm_table_active3">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('common.ID') }}</th>
                                            <th scope="col">{{ __('common.Name') }}</th>
                                            <th scope="col">{{ __('common.Email') }}</th>
                                            <th scope="col">{{ __('common.Phone') }}</th>
                                            <th scope="col">{{ __('role.Role') }}</th>
                                            <th scope="col">{{ __('department.Department') }}</th>
                                            <th scope="col">{{ __('common.Registered Date') }}</th>
                                            <th scope="col">{{ __('common.Status') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($staffs as $key => $staff)
                                            <tr>

                                                <th>{{translatedNumber( ++$key )}}</th>
                                                <td>{{ @$staff->user->name }}</td>
                                                <td>
                                                    <a href="mailto:{{ @$staff->user->email }}">{{ @$staff->user->email }}</a>
                                                </td>
                                                <td><a href="tel:{{ @$staff->phone }}">{{ @$staff->phone }}</a></td>
                                                <td>{{ @$staff->user->role->name }}</td>

                                                <td>{{ @$staff->department->name ?? ''}}</td>
                                                <td>{{ showDate($staff->created_at )}}</td>
                                                <td>
                                                     <x-backend.status :org="null" :id="$staff->user->id"
                                                                      :status="$staff->user->status"
                                                                      :route="'staffs.edit'"></x-backend.status>

                                                </td>

                                                <td>
                                                    <!-- shortby  -->
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle"
                                                                type="button"
                                                                id="dropdownMenu2" data-bs-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false">
                                                            {{ __('common.Select') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu2">

                                                            @if (permissionCheck('staffs.secretLogin'))
                                                                <a class="dropdown-item"
                                                                   href="{{route('secretLogin', $staff->user->id)}}"
                                                                   type="button">{{trans('common.Secret Login') }}</a>
                                                            @endif

                                                            @if(permissionCheck('staffs.update'))
                                                                <a href="{{ route('staffs.edit', $staff->id) }}"
                                                                   class="dropdown-item">{{__('common.Edit')}}</a>
                                                            @endif

                                                            @if(permissionCheck('staffs.view'))
                                                                <a href="{{ route('staffs.view', $staff->id) }}"
                                                                   class="dropdown-item">{{__('common.View')}}</a>
                                                            @endif

                                                            @if(permissionCheck('staffs.destroy'))
                                                                <a onclick="confirm_modal('{{route('staffs.destroy', $staff->user->id)}}');"
                                                                   class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                            @endif

                                                            @if(permissionCheck('staffs.resume'))
                                                                <a data-id="{{$staff->user->id}}"
                                                                   class="dropdown-item staff_resume">{{__('common.Resume')}}</a>
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
    <div id="inactive_form"></div>
    <input type="hidden" value="{{ route("staffs.resume", ":id") }}" id="resume_url">
    <input type="hidden" value="{{ route("staffs.active", ":id") }}" id="active_url">
    <input type="hidden" value="{{ route("staffs.inactive", ":id") }}" id="inactive_url">
    <input type="hidden" value="{{ route("staffs.inactive.update", ":id") }}" id="inactive_update_url">
    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        let _token = $('meta[name=_token]').attr('content');
        // $(document).on('click', '.active_staff', function (event) {
        //     event.preventDefault();
        //     let id = $(this).data('id');
        //     let url = $('#active_url').val();
        //     url = url.replace(':id', id);
        //     $.ajax({
        //         url: url,
        //         type: "GET",
        //         success: function (response) {
        //             if (response) {
        //                 window.location.reload();
        //                 toastr.success('Staff Active Successfully');
        //             }
        //         },
        //         error: function (response) {
        //             toastr.error("Something went wrong");
        //         }
        //     });
        //
        // });
        // $(document).on('click', '.inactive_staff', function (event) {
        //     event.preventDefault();
        //     let id = $(this).data('id');
        //     let url = $('#inactive_url').val();
        //     url = url.replace(':id', id);
        //     $.ajax({
        //         url: url,
        //         type: "GET",
        //         success: function (response) {
        //             if (response) {
        //                 $('#inactive_form').html(response);
        //                 $('.date').datepicker();
        //                 $('#inactive_staff_modal').modal('show');
        //             }
        //         },
        //         error: function (response) {
        //             toastr.error("Something went wrong");
        //         }
        //     });
        //
        // });
        $(document).on('submit', '#inactive_staff_submit', function (event) {
            event.preventDefault();
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name, element.value);
            });
            formData.append('_token', _token);
            let id = $('#rowId').val();
            let url = $('#inactive_update_url').val();
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    $('#inactive_staff_modal').modal('hide');
                    window.location.reload();
                    toastr.success('Staff Inactive Successfully');
                },
                error: function (response) {
                    $('#inactive_staff_modal').modal('show');
                }
            });
        });
        $(document).on('click', '.staff_resume', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            let url = $('#resume_url').val();
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    if (response) {
                        $('#inactive_form').html(response);
                        $('#resume_staff_modal').modal('show');
                    }
                },
                error: function (response) {
                    toastr.error("Something went wrong");
                }
            });

        });

        {{--function update_active_status(el) {--}}
        {{--    if (el.checked) {--}}
        {{--        var status = 1;--}}
        {{--    } else {--}}
        {{--        var status = 0;--}}
        {{--    }--}}
        {{--    $.post('{{ route('staffs.update_active_status') }}', {--}}
        {{--        _token: '{{ csrf_token() }}',--}}
        {{--        id: el.value,--}}
        {{--        status: status--}}
        {{--    }, function (data) {--}}
        {{--        if (data.success) {--}}
        {{--            toastr.success(data.success);--}}
        {{--        } else {--}}
        {{--            toastr.error(data.error);--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
    </script>

    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
