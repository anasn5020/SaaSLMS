@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('public/backend/css/daterangepicker.css') }}{{assetVersion()}}">
@endpush
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{__('courses.Advanced Filter')}} </h4>
                        </div>
                        <form action="#" method="POST">
                            @csrf
                            <div class="row">


                                <div class="col-lg-3 mb-3">
                                    <label class="primary_input_label" for="f_type">{{__('common.Type')}}</label>
                                    <select class="primary_select" name="f_type" id="f_type">
                                        <option value="">{{__('common.Select One')}}</option>
                                        <option value="1">{{trans('courses.Course')}}</option>
                                        <option value="2">{{trans('courses.Quiz')}}</option>
                                        <option value="3">{{trans('courses.Virtual Class')}}</option>
                                    </select>
                                </div>

                                <div class="col-lg-3">
                                    <label class="primary_input_label"
                                           for="f_category">{{__('courses.Category')}}</label>
                                    <select class="primary_select" name="f_category" id="f_category">
                                        <option data-display="{{__('common.Select')}} {{__('courses.Category')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Category')}}</option>
                                        @foreach($categories as $category)
                                            @if($category->parent_id==0)
                                                @include('backend.categories._single_select_option',['category'=>$category,'level'=>1])
                                            @endif
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

                            </div>
                            <div class="row">
                                <div class="col-lg-1 ">
                                    <div class="search_course_btn">
                                        <a href="{{route('users.my_topics.index')}}" class="primary-btn fix-gr-bg theme_btn_mini theme_btn mt-2 fit-b ">{{__('common.Reset')}} </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title"> {{ trans('courses.My Topics') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table white_box">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('common.Title')}}</th>
                                        <th scope="col">{{__('common.Type')}}</th>
                                        <th scope="col">{{__('courses.Curriculum')}}</th>
                                        <th scope="col">{{__('courses.Enroll Date')}}</th>
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

            <input type="hidden" value="{{route('users.my_topics.datatable')}}" id="my_topics_route">
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('public/backend/js/daterangepicker.min.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('public/modules/common/date_range_init.js')}}{{assetVersion()}}"></script>
    <script>
        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = {
            url: $('#my_topics_route').val(),
            data: function (d) {
                d.f_type = $('#f_type').val();
                d.f_category = $('#f_category').val();
                d.f_date = $('.date_range_input').val()
            }
        };

        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'topic_title', name: 'course.title'},
            {data: 'topic_type', name: 'course.type'},
            {data: 'curriculum', name: 'curriculum', orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        let table = $('#lms_table').DataTable(dataTableOptions);
        (function ($) {
            "use strict";
            $(document).ready(function () {


                $(document).on('change', '#f_type, #f_category', function (event) {
                    event.preventDefault();
                    resetAfterChange();
                });

                $(document).on('click', '.reset_btn', function (event) {
                    event.preventDefault();
                    $('#f_type').val('').niceSelect('update');
                    $('#f_category').val('').niceSelect('update');
                    $('.date_range_input').val('');
                    resetAfterChange();
                });


                function resetAfterChange() {
                    let table = $('#lms_table').DataTable();
                    table.ajax.reload();
                }


            });

        })(jQuery);

    </script>
@endpush
