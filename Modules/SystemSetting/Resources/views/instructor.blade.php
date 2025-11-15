@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}{{assetVersion()}}"/>
@endpush

@section('table')
    @php
        $table_name='users';
    @endphp
    {{$table_name}}
@stop
@section('mainContent')

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="white-box">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{__('quiz.Instructor')}} {{__('common.List')}}</h3>
                                @if (permissionCheck('instructor.store'))
                                    <ul class="d-flex">
                                        <li>
                                            @if(isModuleActive('Appointment'))
                                                <a class="primary-btn radius_30px   fix-gr-bg"
                                                   id="add_instructor_btn"
                                                   href="{{ route('appointment.instructor.create') }}"><i
                                                        class="ti-plus"></i>{{__('instructor.Add Instructor')}}</a>
                                            @else
                                                <a class="primary-btn radius_30px   fix-gr-bg"
                                                   href="{{route('instructor.store')}}"><i
                                                        class="ti-plus"></i>{{__('instructor.Add Instructor')}}</a>
                                            @endif

                                        </li>
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
                                    <table id="lms_table" class="table Crm_table_active3">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('common.SL')}}</th>
                                            <th scope="col">{{__('common.Image')}}</th>
                                            <th scope="col">{{__('common.Name')}}</th>
                                            <th scope="col">{{__('common.Email')}}</th>
                                            @if(isModuleActive('OrgInstructorPolicy'))
                                                <th scope="col">{{__('policy.Group')}} {{__('policy.Policy')}}</th>
                                            @endif
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
                    <!-- Add Modal Item_Details -->
                    <!-- new product -->


                    <div class="modal fade admin-query" id="deleteInstructor">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{route('instructor.delete')}}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{__('common.Delete')}} {{__('quiz.Instructor')}} </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                                class="ti-close "></i></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="text-center">

                                            <h4>{{__('common.Are you sure to delete ?')}}</h4>
                                        </div>
                                        <input type="hidden" name="id" value="" id="instructorDeleteId">

                                        <div class="mt-40 d-flex justify-content-between">
                                            <button type="button" class="primary-btn tr-bg"
                                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                                            <button class="primary-btn fix-gr-bg"
                                                    type="submit">{{__('common.Delete')}}</button>

                                        </div>
                                    </div>
                                </form>
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
        <script type="application/javascript">
            @if(Session::has('type'))
            @if(Session::get('type')=="store")
            $('#add_instructor').modal('show');
            @else
            $('#editInstructor').modal('show');
            @endif
            @endif
        </script>
    @endif

    @php
        $url = route('getAllInstructorData');
    @endphp

    <script type="application/javascript">

        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = '{!! $url !!}';
        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'image', name: 'image', orderable: false},
            {data: 'name', name: 'name', orderable: true},
            {data: 'email', name: 'email', orderable: true},
                @if(isModuleActive('OrgInstructorPolicy'))
            {
                data: 'group_policy', name: 'group_policy', orderable: true
            },
                @endif
            {
                data: 'status', name: 'status', orderable: false
            },
            {data: 'action', name: 'action', orderable: false},
        ]

        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 2, 3,]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
    <script type="application/javascript"
            src="{{asset('public/backend/js/instructor_list.js')}}{{assetVersion()}}"></script>
@endpush
