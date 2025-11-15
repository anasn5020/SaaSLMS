@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('public/backend/css/daterangepicker.css') }}{{assetVersion()}}">
    </style>

@endpush

@php
    $table_name='course_canceleds';
@endphp
@section('table')
    {{$table_name}}
@stop

@section('mainContent')

    {!! generateBreadcrumb() !!}



    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_box">
                        <div class="white_box_tittle list_header main-title mb-0">
                            <h3 class="mb-20">{{__('courses.Advanced Filter')}}</h3>
                        </div>
                        <form action="#" method="GET">
                            <div class="row row-gap-24">

                                <div class="col-lg-3">
                                    <label class="primary_input_label" for="f_course">{{__('common.Course')}}</label>
                                    <select class="primary_select" name="f_course" id="f_course">
                                        <option value="">{{__('common.Select One')}}</option>
                                        @foreach($courses as $course)
                                            <option value="{{$course->id}}">{{@$course->title}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3">
                                    <label class="primary_input_label" for="f_user">{{__('common.Student')}}</label>
                                    <select class="primary_select" name="f_user" id="f_user">
                                        <option value="">{{__('common.Select One')}}</option>
                                        @foreach($students as $student)
                                            <option value="{{$student->id}}">{{@$student->name}} </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-lg-3">
                                    <label class="primary_input_label" for="f_status">{{__('common.Status')}}</label>
                                    <select class="primary_select" name="f_status" id="f_status">
                                        <option value="">{{__('common.Select One')}}</option>
                                        <option value="3">{{__('common.Pending')}}</option>
                                        <option value="1">{{__('common.Approved')}}</option>
                                        <option value="2">{{__('common.Reject')}}</option>
                                    </select>
                                </div>

                                <div class="col-lg-3">
                                    <label class="primary_input_label" for="f_type">{{__('common.Type')}}</label>
                                    <select class="primary_select" name="f_type" id="f_type">
                                        <option value="">{{__('common.Select One')}}</option>
                                        <option value="1">{{__('common.Refund')}}</option>
                                        <option value="2">{{__('common.Cancel')}}</option>
                                    </select>
                                </div>

                                <div class="col-lg-3">
                                    <div class="primary_input mb-15 date_range">
                                        <div class="primary_datepicker_input filter">
                                            <label class="primary_input_label" for="">{{__('common.Date')}}</label>
                                            <div class="g-0  input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="{{__('common.Date')}}" readonly
                                                               class="primary_input_field date_range_input" type="text"
                                                               name="date_range_filter" value="">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="fa fa-refresh" id="reset-date-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-2 justify-content-center">
                                        <div class="  text-end">
                                            <a class="primary-btn radius_30px  fix-gr-bg w-fit reset_btn">{{__('common.Reset')}} </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white-box mt-30">
                        <div class="row">
                            <div class="col-12">
                                <div class="box_header common_table_header">
                                    <div class="main-title d-md-flex">
                                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{__('frontend.Refund & Cancellation')}} {{__('common.List')}}</h3>

                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">

                                        <div class="">
                                            <table id="lms_table" class="table Crm_table_active3">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{__('common.SL')}} </th>
                                                    <th scope="col">{{__('common.Name')}} </th>
                                                    <th scope="col">{{__('common.Email Address')}} </th>
                                                    <th scope="col">{{__('courses.Courses')}} </th>
                                                    <th scope="col">{{__('common.Price')}}</th>
                                                    <th scope="col">{{__('common.Type')}} </th>
                                                    <th scope="col">{{__('common.Status')}} </th>
                                                    <th scope="col">{{__('courses.Completed')}} </th>

                                                    <th scope="col">{{__('courses.Confirm By')}} </th>
                                                    <th scope="col">{{__('courses.Request From')}}</th>
                                                    <th scope="col">{{__('courses.Request')}} {{__('common.Date')}} </th>
                                                    <th scope="col">{{__('common.Approved')}}/{{__('common.Reject')}} {{__('common.Date')}} </th>
                                                    <th scope="col">{{__('common.Action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
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


    <div class="modal fade admin-query" id="confirm_cancel_delete">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.Cancel Confirmation') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">{{__('common.Are you sure to cancel')}}?</h3>
                    <p class="text-center">
                        {{__('common.Student can not access course anymore')}}.
                    </p>
                    <p class="text-center">
                        {{__('common.But not refund money to student')}}
                    </p>
                    <div class="col-lg-12 text-center">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                            <a id="delete_link" class="primary-btn semi_large2 fix-gr-bg">{{__('common.Delete')}}</a>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade admin-query" id="confirm_refund_delete">
        <div class="modal-dialog modal-dialog-centered modal_650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.Refund Confirmation') }} </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <p class="text-center">
                        {{__('common.Student can not access course anymore')}}.
                    </p>
                    <p class="text-center">
                        {{__('common.But also refund money to student')}}
                    </p>
                    <form action="{{route('admin.enrollDelete')}}" method="POST">
                        @csrf
                        <input type="hidden" name="refund" value="1">
                        <input type="hidden" name="cancel" value="1">
                        <input type="hidden" name="id" value="" id="itemId">

                        {{--                        Double id issue--}}
                        {{--                        <input type="hidden" name="id" value="" id="RejectItemId">--}}
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button class="primary-btn fix-gr-bg">{{__('common.Refund')}}</button>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade admin-query" id="showReason">
        <div class="modal-dialog modal-dialog-centered modal_650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('frontend.Reason')}} </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <div id="notification_msg">
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade admin-query" id="approved_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Approved Confirmation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Are you sure to approved ?</h3>
                    <p class="text-center">
                        {{__('common.Student can not access course anymore')}}.
                    </p>
                    <p class="text-center">
                        {{__('common.But also refund money to student')}}
                    </p>
                    <div class="col-lg-12 text-center">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                            <a id="approval_submit_link"
                               class="primary-btn semi_large2 fix-gr-bg">{{__('common.Approved')}}</a>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade admin-query" id="reject_modal">
        <div class="modal-dialog modal-dialog-centered modal_650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> {{__('courses.Reject Refund')}} </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <form id="reason_form">
                        @csrf
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="comment">{{__('frontend.Reason')}} <strong
                                        class="text-danger">*</strong> </label>

                                <textarea id="my-textarea" class="primary_input_field"
                                          name="reason" style="height: 200px"
                                          rows="3">{{old('reason')}}</textarea>
                            </div>
                            <span id="error_comment" class="text-danger error_msg"></span>
                        </div>
                        <input type="hidden" name="id" value="" id="RejectItemId">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button class="primary-btn fix-gr-bg">{{__('common.Submit')}}</button>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <input type="hidden" value="{{route('refund.reject')}}" id="refund_reject_url">

@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/daterangepicker.min.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('public/modules/common/date_range_init.js')}}"></script>

    @php
        $url =route('admin.getCancelLogsData');
    @endphp

    <script>
        let _token = $('meta[name=_token]').attr('content');

        function confirm_refund_modal(id) {
            $('#confirm_refund_delete #itemId').val(id);
            jQuery('#confirm_refund_delete').modal('show', {backdrop: 'static'});
        }

        function confirm_cancel_modal(delete_url) {
            jQuery('#confirm_cancel_delete').modal('show', {backdrop: 'static'});
            document.getElementById('delete_link').setAttribute('href', delete_url);
        }

        $(document).on('click', '.show_reason', function () {
            let comment = $(this).data('reason');
            $('#notification_msg').html(comment);
            $("#showReason").modal('show');
        });

        $(document).on('click', '.refund_approved', function (event) {
            event.preventDefault();
            let link = $(this).attr('href');
            $("#approval_submit_link").attr('href', link);
            $("#approved_modal").modal('show');
        });

        $(document).on('click', '.refund_reject', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            $('#RejectItemId').val(id);
            $("#reject_modal").modal('show');
        });


        $(document).on('submit', '#reason_form', function (event) {
            event.preventDefault();
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name, element.value);
            });
            formData.append('_token', _token);
            let url = $('#refund_reject_url').val();
            resetValidationError();
            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    create_form_reset();
                    $('#reject_modal').modal('hide');
                    toastr.success(response.msg, 'Success');
                    resetAfterChange();
                },
                error: function (response) {
                    showValidationErrors('#reason_form', response.responseJSON.errors);
                }
            });
        });

        function resetValidationError() {
            $('.error_msg').html('');
        }

        function create_form_reset() {
            $('#reason_form')[0].reset();
        }

        function showValidationErrors(formType, errors) {
            $(formType + ' #error_comment').text(errors.reason);
        }

        $(document).on('click', '.reset_btn', function (event) {
            event.preventDefault();
            $('#f_course').val('').niceSelect('update');
            $('#f_user').val('').niceSelect('update');
            $('#f_type').val('').niceSelect('update');
            $('#f_status').val('').niceSelect('update');
            $('.date_range_input').val('');
            resetAfterChange();
        });

        $(document).on('change', '#f_course,#f_user,#f_type,#f_status', function (event) {
            event.preventDefault();
            resetAfterChange();
        });


        // var selector = ".date_range_input"
        // $(selector).on('apply.daterangepicker', function (ev, picker) {
        //     $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        //     resetAfterChange();
        // });
        //
        // $(selector).daterangepicker({
        //     autoUpdateInput: false,
        //     // locale: {
        //     //     cancelLabel: 'Clear'
        //     // },
        //     // ranges: {
        //     //     'Today': [moment(), moment()],
        //     //     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //     //     'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        //     //     'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        //     //     'This Month': [moment().startOf('month'), moment().endOf('month')],
        //     //     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        //     //     'This Year': [moment().startOf('year'), moment().endOf('year')],
        //     //     'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        //     // }
        //
        //
        // }, function (start, end, label) {
        //
        // });

        function resetAfterChange() {
            let table = $('#lms_table').DataTable();
            // table.clearPipeline();
            table.ajax.reload();
        }
    </script>

    <script>
        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = {
            url: '{!! $url !!}',
            data: function (d) {
                d.f_course = $('#f_course').val();
                d.f_status = $('#f_status').val();
                d.f_type = $('#f_type').val();
                d.f_user = $('#f_user').val();
                d.f_date = $('.date_range_input').val();
                d.custom_variable = 'custom_value' // Add your custom variable here
            }
        };

        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'user_name', name: 'user.name'},
            {data: 'user_email', name: 'user.email'},
            {data: 'course', name: 'course.title'},
            {data: 'purchase_price', name: 'purchase_price'},
            {data: 'refund', name: 'refund'},
            {data: 'status', name: 'status'},
            {data: 'total_complete', name: 'total_complete'},

            {data: 'confirm_user', name: 'confirmUser.name'},
            {data: 'request_from', name: 'request_from'},
            {data: 'created_at', name: 'created_at'},
            {data: 'approved_date', name: 'approved_date'},
            {data: 'action', name: 'action', orderable: false},
        ]

        dataTableOptions = updateColumnExportOption(dataTableOptions, [0,1, 2, 3,4,5,7,8,9,10,11]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
