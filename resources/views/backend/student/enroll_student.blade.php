@extends('backend.master')


@push('styles')
    <style>
        .check_box_table .QA_table .table tbody td:first-child {
            padding-left: 35px !important;
            padding-right: 25px;
        }

        .check_box_table .QA_table .table tbody td:nth-child(2) {
            padding-left: 25px !important;
        }

    </style>
@endpush
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header main-title mb-0">
                            <h3 class="mb-20">{{__('student.Filter Enroll History')}}</h3>
                        </div>
                        <form action="{{route('admin.enrollFilter')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4 col-md-4 col-lg-4">
                                    <div class="primary_input ">
                                        <label class="primary_input_label"
                                               for="courseSelect">{{__('common.Select')}} {{__('courses.Course')}}</label>
                                    </div>
                                    <select class="primary_select" name="course" id="courseSelect">
                                        <option data-display="{{__('common.Select')}} {{__('courses.Course')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Course')}}</option>
                                        @foreach($courses as $course)
                                            <option
                                                value="{{$course->id}}" {{isset($courseId)?$courseId==$course->id?'selected':'':''}}>{{@$course->title}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-4 col-md-4 col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="startDate">{{__('common.Select')}} {{__('common.Start Date')}}</label>
                                        <div class="primary_datepicker_input">
                                            <div class="g-0  input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="{{__('common.Date')}}"
                                                               class="primary_input_field primary-input date form-control"
                                                               id="startDate" type="text" name="start_date"
                                                               value="{{isset($start)?!empty($start)?date('m/d/Y', strtotime($start)):'':''}}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4 col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="admissionDate">{{__('common.Select')}} {{__('common.End Date')}}</label>
                                        <div class="primary_datepicker_input">
                                            <div class="g-0  input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="{{__('common.Date')}}"
                                                               class="primary_input_field primary-input date form-control"
                                                               id="admissionDate" type="text" name="end_date"
                                                               value="{{isset($end)?!empty($end)?date('m/d/Y', strtotime($end)):'':''}}"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="admission-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 col-lg-4">
                                    <div class="search_course_btn text-center">
                                        <button type="submit"
                                                class="primary-btn radius_30px  fix-gr-bg">
                                            <i class="ti-search"></i>
                                            {{__('common.Filter History')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-12">
                                <div class="box_header common_table_header">
                                    <div class="main-title d-flex justify-content-between">
                                        <h3 class="mb-15 mr-30 mb_xs_15px mb_sm_20px"
                                            id="page_title">{{__('student.Enrolled Student')}} {{__('common.List')}}</h3>
                                        <button class="can_delete primary-btn small fix-gr-bg text-nowrap d-none "
                                                type="button" id="bulkDeleteBtn">
                                            {{__('common.Bulk')}}     {{__('common.Cancel')}}
                                        </button>

                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <form id="bulkDeleteForm">
                                            @csrf

                                            <div class="">
                                                <table id="lms_table_enroll" class="table Crm_table_active3">
                                                    <thead>
                                                    <tr>
                                                        <th class="can_delete" scope="col">

                                                            <label class="primary_checkbox d-flex mr-12 ">
                                                                <input name="" id="selectAll"
                                                                       type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>

                                                        </th>
                                                        <th scope="col">{{__('common.SL')}} </th>
                                                        <th scope="col">{{__('common.Image')}} </th>
                                                        <th scope="col">{{__('common.Name')}} </th>
                                                        <th scope="col">{{__('common.Email Address')}} </th>
                                                        <th scope="col">{{__('courses.Courses')}} {{__('courses.Enrolled')}}</th>
                                                        <th scope="col">{{__('common.Price')}}</th>
                                                        <th scope="col">{{__('courses.Enrollment')}} {{__('common.Date')}} </th>
                                                        <th scope="col">{{__('common.Action')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Modal Item_Details -->
            </div>
        </div>
    </section>
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
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="comment">{{__('frontend.Reason')}} <strong
                                        class="text-danger">*</strong> </label>

                                <textarea required id="my-textarea" class="primary_input_field"
                                          name="reason" style="height: 200px"
                                          rows="3">{{old('reason')}}</textarea>
                            </div>
                            <span id="error_comment" class="text-danger error_msg"></span>
                        </div>
                        <input type="hidden" name="refund" value="1">
                        <input type="hidden" name="id" value="" id="itemId">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button type="submit" class="primary-btn fix-gr-bg">
                                <i class="ti-check"></i>

                                {{__('common.Refund')}}</button>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade admin-query" id="confirm_cancel_delete">
        <div class="modal-dialog modal-dialog-centered modal_650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> {{ __('common.Cancel Confirmation') }} </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <p class="text-center">
                        {{__('common.Student can not access course anymore')}}.
                    </p>
                    <p class="text-center">
                        {{__('common.But not refund money to student')}}
                    </p>
                    <form action="{{route('admin.enrollDelete')}}" method="POST">
                        @csrf
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="comment">{{__('frontend.Reason')}} <strong
                                        class="text-danger">*</strong> </label>

                                <textarea required id="my-textarea" class="primary_input_field"
                                          name="reason" style="height: 200px"
                                          rows="3">{{old('reason')}}</textarea>
                            </div>
                            <span id="error_comment" class="text-danger error_msg"></span>
                        </div>
                        <input type="hidden" name="id" value="" id="cancelItemId">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button type="submit" class="primary-btn fix-gr-bg">
                                <i class="ti-check"></i>
                                {{__('common.Delete')}}
                            </button>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade admin-query" id="confirm_cancel_delete_bulk">
        <div class="modal-dialog modal-dialog-centered modal_650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Bulk')}} {{ __('common.Cancel Confirmation') }} </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <p class="text-center">
                        {{__('common.Students can not access course anymore')}}.
                    </p>
                    <p class="text-center">
                        {{__('common.But not refund money to students')}}
                    </p>
                    <form action="{{route('admin.enrollBulkDelete')}}" method="POST">
                        @csrf
                        <input type="hidden" id="bulk_cancle_ids" name="ids" value="">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="comment">{{__('frontend.Reason')}} <strong
                                        class="text-danger">*</strong> </label>

                                <textarea required id="my-textarea" class="primary_input_field"
                                          name="reason" style="height: 200px"
                                          rows="3">{{old('reason')}}</textarea>
                            </div>
                            <span id="error_comment" class="text-danger error_msg"></span>
                        </div>
                         <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button type="submit" class="primary-btn fix-gr-bg">
                                <i class="ti-check"></i>
                                {{__('common.Delete')}}
                            </button>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade admin-query" id="confirm_generate_certificate">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> {{ __('certificate.Generate Certificate') }} </h4>
                    <button type="button" class="close" data-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <p class="text-center">
                        {{__('certificate.Generate Certificate for student')}}.
                    </p>
                    <form action="{{route('admin.generateCertificate')}}" method="POST">
                        @csrf

                        <input type="hidden" name="id" value="" id="generate_certificate_id">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button class="primary-btn fix-gr-bg">{{__('common.Confirm')}}</button>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade admin-query" id="confirm_remove_certificate">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> {{ __('certificate.Remove Certificate') }} </h4>
                    <button type="button" class="close" data-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <div class="modal-body">
                    <p class="text-center">
                        {{__('certificate.Remove Certificate from student')}}.
                    </p>
                    <form action="{{route('admin.removeCertificate')}}" method="POST">
                        @csrf

                        <input type="hidden" name="id" value="" id="cancel_certificate_id">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">{{__('common.Cancel')}}</button>

                            <button class="primary-btn fix-gr-bg">{{__('common.Confirm')}}</button>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')

    @php
        $url =route('admin.getEnrollLogsData').'?course='.$courseId.'&start_date='.$start.'&end_date='.$end;
    @endphp

    <script>
        function confirm_generate_certificate_modal(id) {
            $('#generate_certificate_id').val(id);
            jQuery('#confirm_generate_certificate').modal('show', {backdrop: 'static'});
        }

        function confirm_remove_certificate_modal(id) {
            $('#cancel_certificate_id').val(id);
            jQuery('#confirm_remove_certificate').modal('show', {backdrop: 'static'});
        }

        function confirm_refund_modal(id) {
            $('#confirm_refund_delete #itemId').val(id);
            jQuery('#confirm_refund_delete').modal('show', {backdrop: 'static'});
        }

        function confirm_cancel_modal(id) {
            $('#confirm_cancel_delete #cancelItemId').val(id);
            jQuery('#confirm_cancel_delete').modal('show', {backdrop: 'static'});
        }
    </script>
    <script>
        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = '{!! $url !!}';
        dataTableOptions.columns = [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'DT_RowIndex', name: 'id', orderable: true},
            {data: 'image', name: 'image', orderable: false},
            {data: 'user.name', name: 'user.name'},
            {data: 'user.email', name: 'user.email'},
            {data: 'course.title', name: 'course.title'},
            {data: 'purchase_price', name: 'purchase_price'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false},
        ]
        dataTableOptions = updateColumnExportOption(dataTableOptions, [1, 3, 4, 5, 6, 7]);

        let table = $('#lms_table_enroll').DataTable(dataTableOptions);


    </script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '#selectAll', function () {
                $(".deleteCheckbox").prop("checked", this.checked);

                if ($('.deleteCheckbox:checked').length > 0) {
                    $('#bulkDeleteBtn').removeClass('d-none');
                } else {
                    $('#bulkDeleteBtn').addClass('d-none');
                }
            });

            $(document).on('click', '.paginate_button', function () {
                $('#bulkDeleteBtn').addClass('d-none');
                $("#selectAll").prop("checked", false);

            });
            $(document).on('click', '.deleteCheckbox', function () {
                if ($('.deleteCheckbox:checked').length === $('.deleteCheckbox').length) {
                    $('#selectAll').prop('checked', true);
                } else {
                    $('#selectAll').prop('checked', false);
                }
                if ($('.deleteCheckbox:checked').length > 0) {
                    $('#bulkDeleteBtn').removeClass('d-none');
                } else {
                    $('#bulkDeleteBtn').addClass('d-none');
                }
            });
            $(document).on('click', '#bulkDeleteBtn', function () {
                let ids = $(".deleteCheckbox:checked").map(function () {
                    return $(this).val();
                }).get();

                if (ids.length === 0) {
                    toastr.error('{{__('ticket.please_at_least_one_item')}}');
                    return;
                }

                $('#bulk_cancle_ids').val(ids);
                $('#confirm_cancel_delete_bulk').modal('show', {backdrop: 'static'});



            });
        });

    </script>
@endpush
