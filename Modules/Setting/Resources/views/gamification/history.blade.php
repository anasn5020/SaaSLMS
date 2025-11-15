@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}{{assetVersion()}}"/>
@endpush
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
            <div class="white_box mb_30">
                <div class="row justify-content-center">

                    <div class="col-lg-12">
                        <div class="white_box mb_30">
                            <div class="white_box_tittle list_header main-title mb-0">
                                <h3 class="mb-0">{{__('courses.Advanced Filter')}} </h3>
                            </div>
                            <form action="{{route('gamification.history')}}" method="GET">
                                <div class="row">

                                    <div class="col-lg-4 mt-20">
                                        <label class="primary_input_label"
                                               for="category"> {{__('courses.Course')}} {{__('common.Levels')}}</label>
                                        <select class="primary_select" name="level" id="level">
                                            <option data-display="{{__('common.All')}} {{__('common.Levels')}}"
                                                    value="">{{__('common.All')}} {{__('common.Levels')}}</option>
                                            @foreach($levels as $level)
                                                <option value="{{$level->id}}" {{request('level')==$level->id?'selected':''}}>{{$level->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-4 mt-20 courseDiv">
                                        <label class="primary_input_label"
                                               for="category">{{__("courses.Courses")}}</label>
                                        <select class="primary_select" name="course" id="course">
                                            <option data-display="{{__('common.All')}} {{__("courses.Courses")}}"
                                                    value="">{{__('common.All')}} {{__("courses.Courses")}}</option>
                                            @foreach($courses as $course)
                                                <option value="{{$course->id}}" {{request('course')==$course->id?'selected':''}}>{{$course->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-4 mt-20">

                                        <label class="primary_input_label"
                                               for="category">{{__('common.Institutes')}}</label>
                                        <select class="primary_select" name="institute" id="institute">
                                            <option data-display="{{__('common.All')}} {{__('common.Institutes')}}"
                                                    value="">{{__('common.All')}} {{__('common.Institutes')}}</option>
                                            @foreach($institutes as $institute)
                                                <option value="{{$institute->id}}" {{request('institute')==$institute->id?'selected':''}}>{{$institute->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 mt-20">
                                        <div class="search_course_btn text-end">
                                            <button type="submit"
                                                    class="primary-btn radius_30px   fix-gr-bg">
                                                <span class="ti-search pe-2"></span>

                                                {{__('courses.Filter')}} </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="white_box mb_30">
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('common.Image')}}</th>
                                        <th scope="col">{{__('common.Name')}}</th>
                                        <th scope="col">{{__('common.Email')}}</th>
                                        <th scope="col">{{__('common.Total')}} {{__('common.Point')}}</th>
                                        <th scope="col">{{__('common.Spent')}} {{__('common.Point')}}</th>
                                        <th scope="col">{{__('common.Remained')}} {{__('common.Point')}}</th>
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
            <div class="row justify-content-center">
            </div>

        </div>
    </section>


    <div class="modal fade admin-query" id="view_details">
        <div class="modal-dialog modal_1000px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ViewTitle"></h4>
                    <button type="button" class="close " data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body" id="viewBody" style="max-height: 500px;overflow-y: auto">

                </div>
            </div>
        </div>
    </div>
<h1 id="page_title" class="d-none">{{__('setting.Gamification')}}</h1>
@endsection
@push('scripts')

    @php

        $url = route('gamification.historyData').'?'.http_build_query(request()->all());
    @endphp

    <script>

        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = '{!! $url !!}';
        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id', orderable: true},
            {data: 'image', name: 'image', orderable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'gamification_total_points', name: 'gamification_total_points'},
            {data: 'gamification_total_spent_points', name: 'gamification_total_spent_points'},
            {data: 'gamification_total_remain_points', name: 'gamification_total_remain_points', orderable: false},
            {data: 'action', name: 'action', orderable: false},
        ];
        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 2, 3, 4, 5, 6]);

        let table = $('#lms_table').DataTable(dataTableOptions);


        $(document).on('click', '.detailsHistory', function () {
            let id = $(this).data('id');
            let type = $(this).data('type');
            let title = $(this).data('title');
            let url = '{{url('/')}}/gamification/history-details/' + type + '/' + id;


            $.ajax({
                type: 'GET',
                url: url,
                dataType: "html",
                success: function (data) {
                    $("#ViewTitle").text(title);
                    $("#viewBody").html(data);
                    $("#view_details").modal('show');
                },
                error: function (data) {
                    toastr.error('Something Went Wrong', 'Error');
                }
            });


        });

        $("#level").on("change", function () {
            var url = $("#url").val();
            var formData = { id: $(this).val() };
            var lang = window._locale;
            console.log(lang)
            // AJAX request to fetch subcategory data
            $.ajax({
                type: "GET",
                data: formData,
                dataType: "json",
                url: url + "/admin/course/ajaxGetCourseByLevel",
                success: function (data) {
                    var $courseSelect = $("#course");
                    var $courseDiv = $("#courseDiv ul");

                    // Clear previous options except the first one
                    $courseSelect.find("option:not(:first)").remove();
                    $courseDiv.find("li:not(:first)").remove();

                    if (data.length) {
                        // Loop through the subcategories and append them
                        $.each(data, function (i, item) {
                            $.each(item, function (i, section) {
                                var option = $("<option>", {
                                    value: section.id,
                                    text: section.title[lang],
                                });
                                $courseSelect.append(option);

                                var listItem = "<li data-value='" + section.id + "' class='option'>" + section.title[lang] + "</li>";
                                $courseDiv.append(listItem);
                            });
                        });
                    } else {
                        // Reset subcategory if no data is available
                        $("#courseDiv .current").html("All Course");
                    }

                    // Refresh NiceSelect plugin
                    $courseSelect.niceSelect('update');
                },
                error: function (data) {
                    console.log("Error:", data);
                },
            });
        });

    </script>

@endpush
