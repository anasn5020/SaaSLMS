@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('public/backend/css/daterangepicker.css') }}">
@endpush
@php
    $table_name='course_reveiws';
@endphp
@section('table')
    {{$table_name}}
@endsection
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header main-title mb-0">
                            <h3 class="mb-20">{{__('courses.Advanced Filter')}} </h3>
                        </div>
                        <form action="#" method="POST">
                            @csrf
                            <div class="row">




                                <div class="col-lg-3">
                                    <label class="primary_input_label" for="f_course">{{__('common.Course')}}</label>
                                    <select class="primary_select" name="f_course" id="f_course">
                                        <option value="">{{__('common.Select One')}}</option>
                                        @foreach($courses as $course)
                                            <option value="{{$course->id}}">{{$course->title}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3">
                                    <div class="primary_input mb-15 date_range">
                                        <div class="primary_datepicker_input filter">
                                            <label class="primary_input_label" for="">{{__('common.Date')}}</label>
                                            <div class="g-0  input-right-icon">

                                                <input placeholder="{{__('common.Date')}}" readonly
                                                       class="primary_input_field date_range_input" type="text"
                                                       name="date_range_filter" value="">

                                                <button class="" type="button">
                                                    <i class="fa fa-refresh" id="reset-date-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-20">
                                    <div class="search_course_btn text-end">
                                        <a class="primary-btn radius_30px   fix-gr-bg reset_btn w-fit">{{__('common.Reset')}} </a>
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
                                    <div class="main-title d-md-flex">
                                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"
                                            id="page_title">{{__('courses.Topic Reviews')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <!-- table-responsive -->
                                        <div class="">
                                            <table id="lms_table" class="table Crm_table_active3">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{__('common.SL')}}</th>
                                                    <th scope="col">{{__('setting.Created Date')}}</th>
                                                    <th scope="col">{{__('common.User')}}</th>
                                                    <th scope="col">{{__('courses.Topic')}}</th>
                                                    <th scope="col">{{__('common.Star')}}</th>
                                                    <th scope="col">{{__('frontend.Comment')}}</th>
                                                    <th scope="col">{{__('common.Status')}}</th>
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

        <div class="modal fade admin-query" id="deleteItem">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('common.Delete')}} </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                class="ti-close "></i></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{route('topic.reviews.destroy')}}" method="POST">
                            @csrf

                            <div class="text-center">

                                <h4>{{__('common.Are you sure to delete ?')}} </h4>
                            </div>
                            <input type="hidden" name="id" value="" id="itemDeleteId">
                            <input type="hidden" name="source_table" value="" id="itemSourceTable">
                            <div class="mt-40 d-flex justify-content-between">
                                <button type="button" class="primary-btn tr-bg"
                                        data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                <button class="primary-btn fix-gr-bg"
                                        type="submit">{{__('common.Delete')}}</button>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


     </section>

@endsection
@push('scripts')

    <script src="{{asset('public/backend/js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('public/modules/common/date_range_init.js')}}"></script>


    @php
        $url = route('topic.reviews.datatable');
    @endphp

    <script>
        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        // dataTableOptions.sDom = 'Bltip'

        dataTableOptions.ajax = {
            url: '{!! $url !!}',
            data: function (d) {
                d.f_type = $('#f_type').val();
                d.f_course = $('#f_course').val();
                d.f_user = $('#f_user').val();
                d.f_date = $('.date_range_input').val()

            }
        };

        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id', orderable: true},
            {data: 'created_at', name: 'created_at'},
            {data: 'user_name', name: 'users.name', orderable: false},
            {data: 'course_title', name: 'courses.title', orderable: false},
            {data: 'star', name: 'star', orderable: false},
            {data: 'comment', name: 'comment', orderable: false},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false},
        ];
        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4,5,6]);
        let table = $('#lms_table').DataTable(dataTableOptions);
        let _token = $('meta[name=_token]').attr('content');

        $(document).on('click', '.delete_item', function () {
            let id = $(this).data('id');
            let source = $(this).data('table');
            $('#itemDeleteId').val(id);
            $('#itemSourceTable').val(source);
            $("#deleteItem").modal('show');
        });

        $(document).on('click', '.comment_show', function () {
            let comment = $(this).data('comment');
            $('#notification_msg').html(comment);
            $("#showComment").modal('show');
        });

        $(document).on('click', '.reset_btn', function (event) {
            event.preventDefault();
            $('#f_type').val('').niceSelect('update');
            $('#f_user').val('').niceSelect('update');
            $('#f_course').val('').niceSelect('update');
            $('.date_range_input').val('');
            resetAfterChange();
        });

        $(document).on('change', '#f_type,#f_user,#f_course,.date_range_input', function (event) {
            event.preventDefault();
            resetAfterChange();
        });


        function resetAfterChange() {
            let table = $('#lms_table').DataTable();
            table.ajax.reload();
        }


        $(document).on('click', '.reply_item', function () {
            let id = $(this).data('id');
            let source = $(this).data('table');
            $('#itemId').val(id);
            $('#itemTable').val(source);
            $("#replyComment").modal('show');
        });

        $(document).on('submit', '#reply_form', function (event) {
            event.preventDefault();
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name, element.value);
            });
            formData.append('_token', _token);
            let url = $('#reply_store_url').val();
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
                    $('#replyComment').modal('hide');
                    toastr.success(response.msg, 'Success');
                    resetAfterChange();
                },
                error: function (response) {
                    showValidationErrors('#reply_form', response.responseJSON.errors);
                }
            });
        });

        function resetValidationError() {
            $('.error_msg').html('');
        }

        function create_form_reset() {
            $('#reply_form')[0].reset();
        }

        function showValidationErrors(formType, errors) {
            $(formType + ' #error_comment').text(errors.comment);
        }
    </script>

@endpush

