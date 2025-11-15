@php
    $category=request()->get('category');
    $required_type=request()->get('required_type');
    $type=request()->get('type',1);
    $mode_of_delivery=request()->get('mode_of_delivery',1);
    $job_position=request()->get('job_position');
    $org_branch_code_search=request()->get('org_branch_code_search');
    $student_status=request()->get('student_status',1);

   if($student_status==2){
        $student_status=0;
    }

    $parem ='?student_status='.$student_status.'&category='.$category. '&type='.$type. '&required_type='.$required_type.'&mode_of_delivery='.$mode_of_delivery.'&org_branch_code_search='.$org_branch_code_search.'&job_position='.$job_position;
    $url = route('course.courseStatisticsCourseData').$parem;
    $url2 = route('course.courseStatisticsQuizData').$parem;
    $url3 = route('course.courseStatisticsClassData').$parem;

@endphp

@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}"/>
    <style>
        .progress-bar {
            background-color: #9734f2;
        }

        .check_box_table .QA_table .table tbody td {
            text-align: center;
        }

        .check_box_table .QA_table .table tbody td:nth-child(2) {
            text-align: left;
        }

        .up_st_admin_visitor .dataTables_filter > label {
            top: -55px;
        }

    </style>
@endpush

@section('mainContent')
    <div class="admin-visitor-area up_st_admin_visitor">

        <div class="container-fluid p-0 ">
            <div class="">
                {!! generateBreadcrumb() !!}
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header main-title mb-0">
                            <h3 class="mb-0">{{__('courses.Advanced Filter')}} </h3>
                        </div>
                        <form action="{{route('course.courseStatistics')}}" method="GET">
                            <div class="row">

                                <div class="col-lg-4 mt-30">

                                    <label class="primary_input_label" for="category">{{__('courses.Category')}}</label>
                                    <select class="primary_select" name="category" id="category">
                                        <option data-display="{{__('common.Select')}} {{__('courses.Category')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Category')}}</option>
                                        @foreach($categories->where('parent_id',0) as $category)
                                            @include('coursesetting::parts_of_course_details.category_select_option',['category'=>$category,'level'=>1,'category_search'=>request('category')])

                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-30">
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
                                @if(isModuleActive('Org'))
                                    <div class="col-lg-4 mt-30">
                                        <label class="primary_input_label"
                                               for="required_type">{{__('courses.Required Type')}}</label>
                                        <select class="primary_select" name="required_type"
                                                id="required_type">
                                            <option
                                                data-display="{{__('common.Select')}} {{__('courses.Required Type')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Required Type')}}</option>
                                            <option
                                                value="1" {{request()->get('required_type')=="1"?'selected':''}}>{{__('courses.Compulsory')}} </option>
                                            <option
                                                value="0" {{request()->get('required_type')=="0"?'selected':''}}> {{__('courses.Open')}}</option>
                                        </select>

                                    </div>

                                    <div class="col-lg-4 mt-30">

                                        <label class="primary_input_label"
                                               for="status">{{__('courses.Delivery Mode')}}</label>
                                        <select class="primary_select" name="delivery_mode" id="status">

                                            <option
                                                value="1" {{request('delivery_mode')=="1"?'selected':''}}>{{__('courses.Online')}} </option>
                                            <option
                                                value="3" {{request('delivery_mode')=="3"?'selected':''}}>{{__('courses.Offline')}}</option>
                                        </select>

                                    </div>

                                    <div class="col-lg-4 mt-30">

                                        <label class="primary_input_label"
                                               for="org_branch_code_search">{{__('org.Org Chart')}}</label>
                                        <select class="primary_select" name="org_branch_code_search"
                                                id="org_branch_code_search">
                                            <option data-display="{{__('common.Select')}} {{__('org.Org Chart')}}"
                                                    value="">{{__('common.Select')}} {{__('org.Org Chart')}}</option>
                                            @foreach($branches as $key=>$branch)
                                                @include('coursesetting::_single_select_option',['branch'=>$branch,'level'=>1,'org_branch_code_search'=>request('org_branch_code_search')])
                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="col-lg-4 mt-30">

                                        <label class="primary_input_label"
                                               for="job_position">{{__('org.Job Position')}}</label>
                                        <select class="primary_select" name="job_position" id="job_position">
                                            <option data-display="{{__('common.Select')}} {{__('org.Job Position')}}"
                                                    value="">{{__('common.Select')}} {{__('org.Job Position')}}</option>
                                            @foreach($positions as $position)
                                                <option
                                                    value="{{$position->code}}" {{request('job_position')==$position->code?'selected':''}}>{{$position->name}} </option>
                                            @endforeach
                                        </select>

                                    </div>
                                @endif


                                <div class="col-lg-4 mt-30">

                                    <label class="primary_input_label"
                                           for="student_status">{{__('student.Student Status')}}</label>
                                    <select class="primary_select" name="student_status" id="student_status">

                                        <option
                                            value="1" {{request('student_status')=="1"?'selected':''}}>{{__('common.Active')}} </option>
                                        <option
                                            value="2" {{request('student_status')=="2"?'selected':''}}>{{__('common.Inactive')}}</option>

                                    </select>

                                </div>


                                <div class="col-lg-3  mt-30">
                                    <div class="   ">
                                        <button type="submit" class="primary-btn   fix-gr-bg">
                                            <i class="ti-check"></i>
                                            {{__('courses.Filter')}} </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if($type==1)

                    <div class="col-lg-9">

                        <div class="white-box">
                            <div class="QA_section QA_section_heading_custom check_box_table mt-60">
                                <div class="QA_table">
                                    <!-- table-responsive -->
                                    <div class="">
                                        <table id="" class="table coursesList">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('common.SL')}}</th>
                                                <th scope="col">{{__('courses.Course')}}</th>
                                                @if(isModuleActive('Org'))
                                                    <th scope="col">{{__('courses.Required Type')}}</th>
                                                @endif
                                                <th scope="col">{{__('courses.Enrolled')}}</th>
                                                <th scope="col">{{__('courses.Not Started yet')}}</th>
                                                <th scope="col">{{__('courses.In Progress')}}</th>
                                                <th scope="col">{{__('courses.Finished')}}</th>
                                                <th scope="col">{{__('courses.Finish Rate')}}</th>
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
                    <div class="col-lg-3">
                        <div class="white_box chart_box mt-20 mt-lg-0">
                            <h4>{{__('dashboard.Status Overview of Topics')}}</h4>
                            <canvas id="course_overview" width="200" height="200"></canvas>
                        </div>
                    </div>
                @endif
                @if($type==2)

                    <div class="col-lg-9">

                        <div class="white-box">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table">
                                    <!-- table-responsive -->
                                    <div class="">
                                        <table id="" class="table quizList">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('SL')}}</th>
                                                <th scope="col">{{__('quiz.Quiz')}}</th>
                                                @if(isModuleActive('Org'))
                                                    <th scope="col">{{__('courses.Required Type')}}</th>
                                                @endif
                                                <th scope="col">{{__('courses.Enrolled')}}</th>
                                                <th scope="col">{{__('courses.Not Started yet')}}</th>
                                                <th scope="col">{{__('common.Fail')}}</th>
                                                <th scope="col">{{__('common.Pass')}}</th>
                                                <th scope="col">{{__('quiz.Taken Pass Rate')}}</th>
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
                    <div class="col-lg-3">
                        <div class="white_box chart_box mt-20 mt-lg-0">
                            <h4>{{__('quiz.Quiz')}} {{__('quiz.Taken Rate')}}</h4>
                            <canvas id="token_rate" width="200" height="200"></canvas>
                        </div>

                        <div class="white_box chart_box mt-20 mt-lg-0">
                            <h4>{{__('quiz.Quiz')}} {{__('quiz.Taken Pass Rate')}}</h4>

                            <canvas id="token_pass_rate" width="200" height="200"></canvas>
                        </div>
                    </div>
                @endif

                @if($type==3)

                    <div class="col-lg-9">

                        <div class="white-box">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table">
                                    <!-- table-responsive -->
                                    <div class="">
                                        <table id="" class="table classList">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('common.SL')}}</th>
                                                <th scope="col">{{__('virtual-class.Virtual Class')}}</th>
                                                @if(isModuleActive('Org'))
                                                    <th scope="col">{{__('courses.Required Type')}}</th>
                                                @endif
                                                <th scope="col">{{__('courses.Enrolled')}}</th>
                                                <th scope="col">{{__('courses.Not Started yet')}}</th>
                                                <th scope="col">{{__('courses.In Progress')}}</th>
                                                <th scope="col">{{__('courses.Finished')}}</th>
                                                <th scope="col">{{__('courses.Finish Rate')}}</th>
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
                    <div class="col-lg-3">
                        <div class="white_box chart_box mt-20 mt-lg-0">
                            <h4>{{__('dashboard.Status Overview of Topics')}}</h4>
                            <canvas id="class_overview" width="200" height="200"></canvas>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </div>
@endsection
@push('scripts')
    <script src="{{asset('public/backend/vendors/chartlist/Chart.min.js')}}"></script>

    <script>
        @if($type==1)

            dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.dom = 'frtip'
        dataTableOptions.ajax = '{!! $url !!}';
        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'title', name: 'title'},
                @if(isModuleActive('Org'))
            {
                data: 'required_type', name: 'required_type'
            },
                @endif
            {
                data: 'total_enrolled', name: 'total_enrolled'
            }, {
                data: 'not_start', name: 'not_start'
            },
            {
                data: 'in_process', name: 'in_process'
            },
            {
                data: 'finished', name: 'finished'
            }, {
                data: 'finished_rate', name: 'finished_rate'
            },


        ];


        @if(isModuleActive('Org'))
            dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6, 7]);
        @else
            dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6]);
        @endif
        $('.coursesList').DataTable(dataTableOptions);

        @elseif($type==2)

            dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.dom = 'frtip'
        dataTableOptions.ajax = '{!! $url2 !!}';
        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'title', name: 'title'},
                @if(isModuleActive('Org'))
            {
                data: 'required_type', name: 'required_type'
            },
                @endif
            {
                data: 'total_enrolled', name: 'total_enrolled'
            }, {
                data: 'not_start', name: 'not_start'
            },
            {
                data: 'fail', name: 'fail'
            },
            {
                data: 'pass', name: 'pass'
            }, {
                data: 'pass_rate', name: 'pass_rate'
            },


        ];
        @if(isModuleActive('Org'))
            dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6, 7]);
        @else
            dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6]);
        @endif

        $('.quizList').DataTable(dataTableOptions)


        @elseif($type==3)
            dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.dom = 'frtip'
        dataTableOptions.ajax = '{!! $url3 !!}';
        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'title', name: 'title'},
                @if(isModuleActive('Org'))
            {
                data: 'required_type', name: 'required_type'
            },
                @endif
            {
                data: 'total_enrolled', name: 'total_enrolled'
            }, {
                data: 'not_start', name: 'not_start'
            },
            {
                data: 'in_process', name: 'in_process'
            },
            {
                data: 'finished', name: 'finished'
            }, {
                data: 'finished_rate', name: 'finished_rate'
            },


        ];


        @if(isModuleActive('Org'))
            dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6, 7]);
        @else
            dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6]);
        @endif
        $('.classList').DataTable(dataTableOptions);

        @endif


    </script>

    <script>
        @if($type==1)
        let ctx = document.getElementById('course_overview').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['{{__('courses.Finished')}}', '{{__('courses.In Progress')}}', '{{__('courses.Not Started yet')}}'],
                datasets: [{
                    label: '{{__('Status Overview of Topics')}}',
                    data: [{{$overviewStatus['finished']}}, {{$overviewStatus['in_process']}}, {{$overviewStatus['not_start']}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 159, 64, 0.2)'

                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            display: false,
                        }
                    }]
                }
            }
        });
        @elseif($type==2)
        let token_rate = document.getElementById('token_rate').getContext('2d');
        new Chart(token_rate, {
            type: 'doughnut',
            data: {
                labels: ['{{__('quiz.Taken')}}', '{{__('courses.Not Started yet')}}'],
                datasets: [{
                    label: '{{__('quiz.Quiz')}} {{__('quiz.Taken Rate')}}',
                    data: [{{$quizStatistics['fail']+$quizStatistics['pass']}}, {{$quizStatistics['not_start']}}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 159, 64, 0.2)'

                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            display: false,
                        }
                    }]
                }
            }
        });


        let token_pass_rate = document.getElementById('token_pass_rate').getContext('2d');
        new Chart(token_pass_rate, {
            type: 'doughnut',
            data: {
                labels: ['{{__('quiz.Pass Rate')}}', '{{__('quiz.Fail Rate')}}'],
                datasets: [{
                    label: '{{__('quiz.Quiz')}} {{__('quiz.Taken Pass Rate')}}',
                    data: [{{$quizStatistics['pass']}}, {{$quizStatistics['fail']}}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 159, 64, 0.2)'

                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            display: false,
                        }
                    }]
                }
            }
        });
        @elseif($type==3)
        let ctx = document.getElementById('class_overview').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['{{__('courses.Finished')}}', '{{__('courses.In Progress')}}', '{{__('courses.Not Started yet')}}'],
                datasets: [{
                    label: '{{__('Status Overview of Topics')}}',
                    data: [{{$overviewStatus['finished']}}, {{$overviewStatus['in_process']}}, {{$overviewStatus['not_start']}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 159, 64, 0.2)'

                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            display: false,
                        }
                    }]
                }
            }
        });
        @endif
    </script>
@endpush
