@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('public/backend/css/daterangepicker.css') }}">
    <style>
        .QA_section .QA_table tbody td a, .QA_section .QA_table tbody th a {
            color: var(--backend-primary-color);
        }

        .btn_outline_primary {
            color: var(--backend-primary-color);
            border-color: var(--backend-primary-color);
        }

        .btn_outline_primary:hover {
            color: #fff !important;
            background-color: var(--backend-primary-color);
            border-color: var(--backend-primary-color);
        }
    </style>

@endpush

@php
    $table_name='blog_comments';
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


                                <div class="col-lg-6 mb-3">
                                    <label class="primary_input_label" for="f_type">{{__('common.Type')}}</label>
                                    <select class="primary_select" name="f_type" id="f_type">
                                        <option value="">{{__('common.Select One')}}</option>
                                        <option value="1">{{__('frontend.Main Comment')}}</option>
                                        <option value="2">{{__('frontend.Replied')}}</option>
                                    </select>
                                </div>

                                <div class="col-lg-6 mb-3">
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

                                <div class="col-lg-3  ">
                                    <div class="search_course_btn">
                                        <a class="primary-btn radius_30px  w-fit  fix-gr-bg reset_btn  ">{{__('common.Reset')}} </a>
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
                                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{__('blog.Blog Comments')}}</h3>
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
                                                    <th scope="col">{{__('blog.Blog')}}</th>
                                                    <th scope="col">{{__('common.Type')}}</th>
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
                        <form action="{{route('blogs.comments.destroy')}}" method="POST">
                            @csrf

                            <div class="text-center">

                                <h4>{{__('common.Are you sure to delete ?')}} </h4>
                            </div>
                            <input type="hidden" name="id" value="" id="itemDeleteId">
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

        <div class="modal fade admin-query" id="showComment">
            <div class="modal-dialog modal-dialog-centered modal_650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('blog.Comment')}} </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                class="ti-close "></i></button>
                    </div>

                    <div class="modal-body">
                        <div id="notification_msg">
                        </div>

                        <div class="mt-40 d-flex justify-content-end">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade admin-query" id="replyComment">
            <div class="modal-dialog modal-dialog-centered modal_650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('blog.Reply')}} {{__('blog.Comment')}} </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                class="ti-close "></i></button>
                    </div>

                    <div class="modal-body">
                        <form id="reply_form">
                            @csrf
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="comment">{{__('blog.Comment')}} <strong
                                            class="text-danger">*</strong> </label>

                                    <textarea id="my-textarea" class="primary_input_field"
                                              name="comment" style="height: 200px"
                                              rows="3">{{old('comment')}}</textarea>
                                </div>
                                <span id="error_comment" class="text-danger error_msg"></span>
                            </div>
                            <input type="hidden" name="id" value="" id="itemId">
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

        <input type="hidden" value="{{route('blogs.comments.reply')}}" id="reply_store_url">
    </section>

@endsection
@push('scripts')

    <script src="{{asset('public/backend/js/daterangepicker.min.js')}}"></script>
    <script src="{{asset('public/modules/common/date_range_init.js')}}"></script>


    @php
        $url = route('blogs.comments.datatable');
    @endphp

    <script>
        dataTableOptions.serverSide = true
        dataTableOptions.processing = true


        dataTableOptions.ajax = {
            url: '{!! $url !!}',
            data: function (d) {
                // d.name = $('#name').val();
                // d.search_course = $('#search_course').val();
                d.f_type = $('#f_type').val();
                d.f_date = $('.date_range_input').val()
            }
        };

        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id', orderable: true},
            {data: 'created_at', name: 'created_at'},
            {data: 'user', name: 'user.name', orderable: false},
            {data: 'blog', name: 'blog.title', orderable: false},
            {data: 'type', name: 'type', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false},
        ];
        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4]);

        let table = $('#lms_table').DataTable(dataTableOptions);
        let _token = $('meta[name=_token]').attr('content');

        $(document).on('click', '.delete_item', function () {
            let id = $(this).data('id');
            $('#itemDeleteId').val(id);
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
            $('.date_range_input').val('');
            resetAfterChange();
        });

        $(document).on('change', '#f_type', function (event) {
            event.preventDefault();
            resetAfterChange();
        });


        function resetAfterChange() {
            let table = $('#lms_table').DataTable();
            table.ajax.reload();
        }

        $(document).on('click', '.reply_item', function () {
            let id = $(this).data('id');
            $('#itemId').val(id);
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
