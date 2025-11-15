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
                                    <div class="col-lg-4 mt-20">
                                        <label class="primary_input_label"
                                               for="type">{{__('courses.Topic')}} {{__('common.Type')}}</label>
                                        <select class="primary_select" name="type"
                                                id="type">
                                            <option
                                                value="1" {{request()->get('type')=="1"?'selected':''}}>{{__('courses.Course')}} </option>
                                            <option
                                                value="2" {{request()->get('type')=="2"?'selected':''}}> {{__('quiz.Quiz')}}</option>
                                            <option
                                                value="3" {{request()->get('type')=="3"?'selected':''}}> {{__('virtual-class.Virtual Class')}}</option>
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
                            <h3 class="mb-0" id="page_title">{{__('report.Institution wise Performance')}}</h3>
                        </div>
                    </div>
                </div>
                @php
                    $type = request()->get('type');
                    if(!$type){
                          request()->merge(['type'=>1]);
                          request()->merge(['from'=>'institute_wise']);
                          $type = 1;
                    }
                    $url = route('admin.institutionWisePerformance').'?'.http_build_query(request()->query());
                @endphp
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <!-- table-responsive -->
                        <div class="">
                            <table id="lms_table" class="table Crm_table_active3">
                                <thead>
                                @if($type==1)
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('courses.Course')}}</th>
                                        <th scope="col">{{__('courses.Enrolled')}}</th>
                                        <th scope="col">{{__('courses.Not Started yet')}}</th>
                                        <th scope="col">{{__('courses.In Progress')}}</th>
                                        <th scope="col">{{__('courses.Finished')}}</th>
                                        <th scope="col">{{__('courses.Finish Rate')}}</th>
                                    </tr>
                                @elseif($type==2)
                                    <tr>
                                        <th scope="col">{{__('SL')}}</th>
                                        <th scope="col">{{__('quiz.Quiz')}}</th>
                                        <th scope="col">{{__('courses.Enrolled')}}</th>
                                        <th scope="col">{{__('courses.Not Started yet')}}</th>
                                        <th scope="col">{{__('common.Fail')}}</th>
                                        <th scope="col">{{__('common.Pass')}}</th>
                                        <th scope="col">{{__('quiz.Taken Pass Rate')}}</th>
                                    </tr>
                                @elseif($type==3)
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('virtual-class.Virtual Class')}}</th>
                                        <th scope="col">{{__('courses.Enrolled')}}</th>
                                        <th scope="col">{{__('courses.Not Started yet')}}</th>
                                        <th scope="col">{{__('courses.In Progress')}}</th>
                                        <th scope="col">{{__('courses.Finished')}}</th>
                                        <th scope="col">{{__('courses.Finish Rate')}}</th>
                                    </tr>
                                @endif
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
    <script>

        let data = [];
        @if($type==1)
            data = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'total_enrolled', name: 'total_enrolled'},
            {data: 'not_start', name: 'not_start'},
            {data: 'in_process', name: 'in_process'},
            {data: 'finished', name: 'finished'},
            {data: 'finished_rate', name: 'finished_rate'},
        ];
        @elseif($type==2)
            data = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'total_enrolled', name: 'total_enrolled'},
            {data: 'not_start', name: 'not_start'},
            {data: 'fail', name: 'fail'},
            {data: 'pass', name: 'pass'},
            {data: 'pass_rate', name: 'pass_rate'},
        ];
        @elseif($type==3)
            data = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'total_enrolled', name: 'total_enrolled'},
            {data: 'not_start', name: 'not_start'},
            {data: 'in_process', name: 'in_process'},
            {data: 'finished', name: 'finished'},
            {data: 'finished_rate', name: 'finished_rate'},
        ];
        @endif

            dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.sDom = "Blrtip"
        dataTableOptions.ajax = '{!! $url !!}';
        dataTableOptions.columns = data;
        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6]);
        $('#lms_table').DataTable(dataTableOptions);
    </script>
@endpush
