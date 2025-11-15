@extends('backend.master')
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
                            <form action="#" method="GET">
                                <div class="row">


                                    <div class="col-lg-4 mt-20">

                                        <label class="primary_input_label"
                                               for="category">{{__('common.Institutes')}}</label>
                                        <select class="primary_select" name="institute" id="institute">
                                            <option data-display="{{__('common.All')}} {{__('common.Institutes')}}"
                                                    value="">{{__('common.All')}} {{__('common.Institutes')}}</option>
                                            @foreach($institutes as $institute)
                                                <option
                                                    value="{{$institute->id}}" {{request('institute')==$institute->id?'selected':''}}>{{$institute->name}}</option>
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
            <div class="white_box">
                <div class="col-lg-12">
                    <div class="box_header">
                        <div class="main-title d-flex flex-wrap mb-0">
                            <h3 class="mb-0" id="page_title">{{__('report.Institution wise User')}}</h3>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
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
                                    <th scope="col">{{__('common.Institute Name')}}</th>
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
    </section>

@endsection

@push('scripts')

    @php
        $url = route('admin.institutionWiseUser').'?'.http_build_query(request()->query());
    @endphp

    <script>
        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = '{!! $url !!}';
        dataTableOptions.sDom = "Blrtip"

        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id', orderable: true},
            {data: 'image', name: 'image', orderable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'institute_name', name: 'institute_name'},
        ];

        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 2, 3, 4, 5]);
        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
