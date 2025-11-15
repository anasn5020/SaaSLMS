@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}"/>
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
            <div class="white-box">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{__('student.Students List')}}</h3>

                                <ul class="d-flex">
                                    @if (permissionCheck('student.store'))
                                        <li><a class="primary-btn radius_30px   fix-gr-bg"
                                               id=""
                                               href="{{route('student.store')}}"><i
                                                    class="ti-plus"></i>{{__('student.Add Student')}}</a>
                                        </li>
                                    @endif
                                         <li><a class="primary-btn radius_30px   fix-gr-bg"
                                               href="{{route('regular_student_import')}}"><i
                                                    class="ti-plus"></i>{{__('student.Import Student')}}</a></li>
                                 </ul>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 ">
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
                                            <th scope="col">{{__('student.Phone')}}</th>
                                            <th scope="col">{{__('courses.Courses')}}</th>
                                            <th scope="col">{{__('common.gender')}}</th>
                                            <th scope="col">{{__('common.Date of Birth')}}</th>
                                            <th scope="col">{{__('common.Country')}}</th>
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


                    <div class="modal fade admin-query" id="deleteStudent">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{__('common.Delete')}} {{__('student.Student')}} </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                            class="ti-close "></i></button>
                                </div>

                                <div class="modal-body">
                                    <form action="{{route('student.delete')}}" method="post">
                                        @csrf

                                        <div class="text-center">

                                            <h4>{{__('common.Are you sure to delete ?')}} </h4>
                                        </div>
                                        <input type="hidden" name="id" value="" id="studentDeleteId">
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
                </div>
            </div>

        </div>
    </section>

@endsection
@push('scripts')

    @if ($errors->any())
        <script>
            @if(Session::has('type'))
            @if(Session::get('type')=="store")
            $('#add_student').modal('show');
            @else
            $('#editStudent').modal('show');
            @endif
            @endif
        </script>
    @endif


    @php
        $url = route('student.getAllStudentData');
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
            {data: 'phone', name: 'phone'},
            {data: 'course_count', name: 'course_count'},
            {data: 'gender', name: 'gender'},
            {data: 'dob', name: 'dob'},
            {data: 'country', name: 'country'},
            {data: 'status', name: 'status', orderable: false},
            {data: 'action', name: 'action', orderable: false},
        ];

        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 2, 3, 4, 5, 6, 7, 8]);
        // dataTableOptions = updateColumnExportOption(dataTableOptions, ':visible');
        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>

    <script src="{{asset('public/backend/js/student_list.js')}}"></script>

@endpush
