@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/daterangepicker.css')}}">
@endpush
@section('mainContent')

    <section class="sms-breadcrumb mb-10 white-box">
        <div class="container-fluid p-0">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="text-uppercase">{{__("common.Dashboard")}}</h1>
            </div>
        </div>
    </section>

    <div class="container-fluid p-0">

        <div class="row row-gap-4 justify-content-center mt-0">

            @if (permissionCheck('dashboard.number_of_student'))
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <a href="#" class="d-block h-100">
                        <div class="white-box single-summery h-100">
                            <div class="d-flex justify-content-between gap-20">
                                <div>
                                    <h3>{{__('student.Students')}}</h3>
                                    <p class="mb-0">{{__('student.Number of Students')}}</p>
                                </div>
                                <h1 class="gradient-color2" id="totalStudent"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif


            @if (permissionCheck('dashboard.number_of_instructor'))
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <a href="#" class="d-block h-100">
                        <div class="white-box single-summery h-100">
                            <div class="d-flex justify-content-between gap-20">
                                <div>
                                    <h3>{{__('quiz.Instructor')}}</h3>
                                    <p class="mb-0">{{__('quiz.Number of Instructor')}}</p>
                                </div>
                                <h1 class="gradient-color2" id="totalInstructor"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            @if (permissionCheck('dashboard.number_of_subject'))
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <a href="#" class="d-block h-100">
                        <div class="white-box single-summery h-100">
                            <div class="d-flex justify-content-between gap-20">
                                <div>
                                    <h3>{{__('dashboard.Subjects')}}</h3>
                                    <p class="mb-0">{{__('dashboard.Number of Subjects')}}</p>
                                </div>
                                <h1 class="gradient-color2" id="totalCourses"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            @if (permissionCheck('dashboard.number_of_enrolled'))
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <a href="#" class="d-block h-100">
                        <div class="white-box single-summery h-100">
                            <div class="d-flex justify-content-between gap-20">
                                <div>
                                    <h3>{{__('dashboard.Enrolled')}}</h3>
                                    <p class="mb-0">{{__('dashboard.Number of Enrolled')}}</p>
                                </div>
                                <h1 class="gradient-color2" id="totalEnroll"> ...
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            @if(showEcommerce())
                @if (permissionCheck('dashboard.total_amount_from_enrolled'))
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <a href="#" class="d-block h-100">
                            <div class="white-box single-summery h-100">
                                <div class="d-flex justify-content-between gap-20">
                                    <div>
                                        <h3>{{__('dashboard.Enrolled Amount')}}</h3>
                                        <p class="mb-0">{{__('dashboard.Total Enrolled Amount')}}</p>
                                    </div>
                                    <h1 class="gradient-color2" id="totalSell"> ...
                                    </h1>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if (permissionCheck('dashboard.total_revenue'))
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <a href="#" class="d-block h-100">
                            <div class="white-box single-summery h-100">
                                <div class="d-flex justify-content-between gap-20">
                                    <div>
                                        <h3>{{__('courses.Revenue')}}</h3>
                                        <p class="mb-0">{{__('courses.Total Revenue')}} {{__('common.Amount')}}</p>
                                    </div>
                                    <h1 class="gradient-color2" id="totalRevenue"> ...
                                    </h1>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (permissionCheck('dashboard.total_enrolled_today'))
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <a href="#" class="d-block h-100">
                            <div class="white-box single-summery h-100">
                                <div class="d-flex justify-content-between gap-20">
                                    <div>
                                        <h3>{{__('dashboard.Enrolled Today')}}</h3>
                                        <p class="mb-0">{{__('dashboard.Total Enrolled Today')}} {{__('common.Amount')}}</p>
                                    </div>
                                    <h1 class="gradient-color2" id="totalToday"> ...
                                    </h1>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if (permissionCheck('dashboard.total_enrolled_this_month'))
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <a href="#" class="d-block h-100">
                            <div class="white-box single-summery h-100">
                                <div class="d-flex justify-content-between gap-20">
                                    <div>
                                        <h3>{{__('dashboard.This Month')}}</h3>
                                        <p class="mb-0">{{__('dashboard.Total Enrolled This Month')}} {{__('common.Amount')}}</p>
                                    </div>
                                    <h1 class="gradient-color2" id="totalThisMonth"> ...
                                    </h1>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                <div class="container-fluid">
                    <div class="row row-gap-4">
                        @if (permissionCheck('dashboard.monthly_income'))
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="white_box chart_box">
                                    <h4>{{__('dashboard.Monthly Income Stats for')}} {{translatedNumber(date('Y'))}}</h4>
                                    <div class="">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="myChart" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (permissionCheck('dashboard.payment_statistic'))
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="white_box chart_box">
                                    <h4>{{__('dashboard.Payment Statistics for')}} {{\Carbon\Carbon::now()->translatedFormat('F')}}</h4>
                                    <div class="">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                    </div>
                                    <canvas id="payment_statistics" width="400" height="400"></canvas>
                                </div>
                            </div>
                        @endif
                        @if (permissionCheck('dashboard.overview_status_of_courses'))
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="white_box chart_box">
                                    <h4>{{__('dashboard.Status Overview of Topics')}}</h4>
                                    <div class="">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                    </div>
                                    <canvas id="course_overview" width="400" height="400"></canvas>
                                </div>
                            </div>
                        @endif
                        @if (permissionCheck('dashboard.overview_of_courses'))
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="white_box chart_box">
                                    <h4>{{__('dashboard.Overview of Topics')}}</h4>
                                    <div class="">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                    </div>
                                    <canvas id="course_overview2" width="400" height="400"></canvas>
                                </div>
                            </div>
                        @endif

                        @if(isModuleActive('CPD'))
                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="white_box chart_box">
                                    <div class="main-title d-md-flex justify-content-between">
                                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">
                                            {{__('cpd.CPD')}} {{translatedNumber(date('Y'))}}</h3>

                                        <ul class="d-flex float-end">

                                            <li>

                                                <a href="{{route('cpd.cpdGraph-export')}}"
                                                   class="primary-btn small fix-gr-bg">
                                                    <span class="ti-download pe-2"></span>
                                                    {{__('common.Export')}}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="myChartCPD" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (permissionCheck('dashboard.daily_wise_enroll'))

                            <div class="col-xl-4 col-lg-6 col-md-6">
                                <div class="white_box chart_box">
                                    <div class="white_box_tittle list_header">
                                        <h4>{{__('dashboard.Daily Wise Enroll Status for')}} {{\Carbon\Carbon::now()->translatedFormat('F')}}</h4>
                                    </div>
                                    <div class="row  justify-content-center">
                                        <div class="col-md-12 3 mb-3 mb-lg-0">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <canvas id="enroll_overview" width="400" height="400"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (permissionCheck('userLoginChartByDays'))
                            <div class="col-lg-6">
                                <div class="white_box chart_box">
                                    <div class="white_box_tittle list_header">
                                        <h4>{{__('dashboard.User Login Chart')}} ({{__('dashboard.By Date')}})</h4>
                                    </div>
                                    <div class="row  justify-content-center">
                                        <div class="col-md-3 mb-3 mb-lg-0">
                                            <input type="radio" checked
                                                   class="common-radio userLoginChartByDays "
                                                   id="userLoginChartByDays7"
                                                   name="userLoginChartByDays"
                                                   value="7">
                                            <label class="text-nowrap"
                                                   for="userLoginChartByDays7">{{__('dashboard.Last 7 Days')}}</label>
                                        </div>
                                        <div class="col-md-3 mb-3 mb-lg-0">
                                            <input type="radio"
                                                   class="common-radio userLoginChartByDays "
                                                   id="userLoginChartByDays14"
                                                   name="userLoginChartByDays"
                                                   value="14">
                                            <label class="text-nowrap"
                                                   for="userLoginChartByDays14">{{__('dashboard.Last 14 Days')}}</label>
                                        </div>

                                        <div class="col-md-3 mb-3 mb-lg-0">
                                            <input type="radio"
                                                   class="common-radio userLoginChartByDays"
                                                   id="userLoginChartByDays30"
                                                   name="userLoginChartByDays"
                                                   value="30">
                                            <label class="text-nowrap"
                                                   for="userLoginChartByDays30">{{__('dashboard.Last 30 Days')}}</label>
                                        </div>


                                        <div class="col-md-3 mb-3 mb-lg-0">
                                            <input type="radio"
                                                   class="common-radio "
                                                   id="userLoginChartByDaysCustom"
                                                   name="userLoginChartByDays"
                                                   value="custom">
                                            <label class="text-nowrap"
                                                   for="userLoginChartByDaysCustom">{{__('dashboard.Others')}}</label>

                                            <input type="text" class="form-control userLoginChartDateRange"
                                                   name="userLoginChartByDaysDateRange" id="userLoginDayChartDateRange"
                                                   value="{{date('m/d/Y')}} - {{date('m/d/Y')}}"/>
                                        </div>
                                    </div>
                                    <div class="">
                                        <canvas id="userLoginChartByDays" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (permissionCheck('userLoginChartByTime'))
                            <div class="col-lg-6">
                                <div class="white_box chart_box">
                                    <div class="white_box_tittle list_header">
                                        <h4>{{__('dashboard.User Login Chart')}} ({{__('dashboard.By Time')}})</h4>
                                    </div>
                                    <div class="row  justify-content-center">
                                        <div class="col-md-3 mb-3 mb-lg-0">
                                            <input type="radio" checked
                                                   class="common-radio userLoginChartByTime "
                                                   id="userLoginChartByTime7"
                                                   name="userLoginChartByTime"
                                                   value="7">
                                            <label class="text-nowrap"
                                                   for="userLoginChartByTime7">{{__('dashboard.Last 7 Days')}}</label>
                                        </div>
                                        <div class="col-md-3 mb-3 mb-lg-0">
                                            <input type="radio"
                                                   class="common-radio userLoginChartByTime "
                                                   id="userLoginChartByTime14"
                                                   name="userLoginChartByTime"
                                                   value="14">
                                            <label class="text-nowrap"
                                                   for="userLoginChartByTime14">{{__('dashboard.Last 14 Days')}}</label>
                                        </div>

                                        <div class="col-md-3 mb-3 mb-lg-0">
                                            <input type="radio"
                                                   class="common-radio userLoginChartByTime"
                                                   id="userLoginChartByTime30"
                                                   name="userLoginChartByTime"
                                                   value="30">
                                            <label class="text-nowrap"
                                                   for="userLoginChartByTime30">{{__('dashboard.Last 30 Days')}}</label>
                                        </div>


                                        <div class="col-md-3 mb-3 mb-lg-0">
                                            <input type="radio"
                                                   class="common-radio "
                                                   id="userLoginChartByTimeCustom"
                                                   name="userLoginChartByTime"
                                                   value="custom">
                                            <label class="text-nowrap"
                                                   for="userLoginChartByTimeCustom">{{__('dashboard.Others')}}</label>

                                            <input type="text" class="form-control userLoginChartDateRange"
                                                   name="userLoginTimeChartDateRange" id="userLoginTimeChartDateRange"
                                                   value="{{date('m/d/Y')}} - {{date('m/d/Y')}}"/>
                                        </div>
                                    </div>
                                    <div class="">
                                        <canvas id="userLoginChartByTime" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- <div class="row justify-content-center">

        </div> --}}

        <div class="row row-gap-4">
            @if (permissionCheck('dashboard.total_student_by_each_course'))
                <div class="col-lg-6">
                    <div class="white_box QA_section mt_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{__('dashboard.Total student by each course')}}</h4>
                        </div>
                        <div class="table-responsive QA_table" style="max-height: 400px; overflow:auto">
                            <table class="table lms_table_active">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('courses.Course Title')}}</th>
                                    <th scope="col">{{__('courses.Instructor')}}</th>
                                    <th scope="col">{{__('dashboard.Enrolled')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($allCourses->where('type',1) as $key =>$course)

                                    <tr>
                                        <th scope="row">
                                            <a target="_blank"
                                               href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}"
                                               class="question_content">{{@$course->title}}
                                            </a>
                                        </th>
                                        <td>{{@$course->user->name}}</td>
                                        <td>{{@translatedNumber($course->enrolls->count())}}</td>
                                    </tr>

                                @endforeach
                                @if(count($allCourses->where('type',1))==0)
                                    <tr>
                                        <td>{{__('common.No data available in the table')}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            @if (permissionCheck('dashboard.recent_enrolls'))
                <div class="col-lg-6">
                    <div class="white_box QA_section mt_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{__('dashboard.Recent Enrolls')}}</h4>
                        </div>
                        <div class="table-responsive QA_table"
                             style="max-height: 400px; overflow:auto">
                            <table class="table lms_table_active">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('courses.Course Title')}}</th>
                                    <th scope="col">{{__('courses.Instructor')}}</th>
                                    <th scope="col">{{__('common.Email Address')}}</th>
                                    @if(showEcommerce())
                                        <th scope="col">{{__('dashboard.Recent Enrolls')}}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($recentEnroll as $key =>$enroll)
                                    <tr>
                                        <th scope="row"><a target="_blank"
                                                           href="{{courseDetailsUrl(@$enroll->course->id,@$enroll->course->type,@$enroll->course->slug)}}"
                                                           class="question_content">{{@$enroll->course->title}}
                                            </a>
                                        </th>
                                        <td>{{@$enroll->course->user->name}}</td>
                                        <td>{{@$enroll->user->email}}</td>
                                        @if(showEcommerce())
                                            <td>
                                                @if(isModuleActive('Organization') && auth()->user()->isOrganization())
                                                    {{getPriceFormat(@$enroll->reveune)}}
                                                @else
                                                    {{getPriceFormat($enroll->purchase_price - @$enroll->reveune)}}
                                                @endif

                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @if(count($recentEnroll)==0)
                                    <tr>
                                        <td>{{__('common.No data available in the table')}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>


    @if(count($badges)!=0)
        <div class="row row-gap-4 justify-content-center mt-20">
            <div class="col-lg-12">
                <div class="white_box chart_box position-relative">
                    <div class="white_box_tittle list_header">
                        <h4>{{__('frontend.Upcoming Badge')}}</h4>
                    </div>

                    <div class="dashboard_badge_carousel owl-carousel overflow-hidden" id="badge_carousel">

                        @foreach($badges as $type)
                            @foreach($type->take(1) as  $badge)
                                <div class="dashboard_badge_item text-center">
                                    <p>{{$badge->title}} -
                                        <small>{{ucfirst($badge->type).' '.trans('setting.Badge')}}</small></p>
                                    <div class="img"><img
                                            src="{{asset($badge->image)}}"
                                            alt=""></div>
                                    <span class="f_w_600">
                                        {{trans('common.Required')}}    {{$badge->point}}
                                        @if($badge->type=='activity')
                                            {{__('setting.logins')}}
                                        @elseif($badge->type=='courses')
                                            {{__('setting.completed courses')}}
                                        @elseif($badge->type=='registration')
                                            {{__('setting.Days')}}
                                        @elseif($badge->type=='test')
                                            {{__('setting.passed tests')}}
                                        @elseif($badge->type=='assignment')
                                            {{__('setting.passed assignments')}}
                                        @elseif($badge->type=='survey')
                                            {{__('setting.completed surveys')}}
                                        @elseif($badge->type=='communication')
                                            {{__('setting.topics or comments')}}
                                        @elseif($badge->type=='certification')
                                            {{__('setting.certificates')}}
                                        @elseif($badge->type=='perfectionism')
                                            {{__('setting.tests or assignments with score 90%+')}}
                                        @endif
                                        </span>
                                </div>
                            @endforeach
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(isModuleActive('Noticeboard'))
        @includeIf('noticeboard::_dashboard_noticeboard_list')
    @endif
@endsection
@push('scripts')
    <script src="{{asset('public/backend/vendors/chartlist/Chart.min.js')}}"></script>
    <script src="{{asset('public/backend/js/daterangepicker.min.js')}}"></script>

    <script>
        $('.userLoginChartDateRange').daterangepicker();
        @if (permissionCheck('userLoginChartByDays'))
        var userLoginChartByDaysElement = $('input[name="userLoginChartByDays"]');
        var userLoginChartByDaysDateRangeElement = $('input[name="userLoginChartByDaysDateRange"]');


        userLoginChartByDaysDateRangeElement.change(function () {
            getLoginUserDataFromDays('custom', this.value);
        });
        userLoginChartByDaysElement.change(function () {
            if (this.value === 'custom') {
                $('#userLoginDayChartDateRange').show();
            } else {
                $('#userLoginDayChartDateRange').hide();
                getLoginUserDataFromDays('days', this.value);
            }
        });


        var userLoginChartByDaysCanvas = $('#userLoginChartByDays').get(0).getContext('2d');

        function getLoginUserDataFromDays(type, days) {
            $.ajax({
                url: '{{url('userLoginChartByDays')}}',
                type: 'GET',
                data: {type: type, days: days},
                success: function (result) {

                    var userLoginChartByDaysData = {
                        labels: result.date,
                        datasets: [
                            {
                                label: '{{__('dashboard.User Login Attempt')}}',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 0.5)',
                                pointRadius: true,
                                pointColor: '#3b8bba',
                                borderWidth: 3,
                                pointDot: true,
                                pointDotRadius: 10,
                                pointHoverRadius: 15,
                                pointStrokeColor: 'rgba(54, 162, 235, 1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(54, 162, 235, 1)',
                                data: result.data
                            },
                        ]
                    }

                    var userLoginChartByDaysOptions = {
                        maintainAspectRatio: false,
                        responsive: true,
                        legend: {
                            display: true
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: false,
                                }
                            }]
                        }
                    }


                    new Chart(userLoginChartByDaysCanvas, {
                        type: 'line',
                        data: userLoginChartByDaysData,
                        options: userLoginChartByDaysOptions
                    })

                }, error: function (result, statut, error) { // Handle errors
                    console.log(error);
                }

            });
        }

        getLoginUserDataFromDays('days', 7);
        @endif
        // ------------------------
        @if (permissionCheck('userLoginChartByTime'))

        var userLoginChartByTimeElement = $('input[name="userLoginChartByTime"]');
        var userLoginTimeChartDateRange = $('input[name="userLoginTimeChartDateRange"]');


        userLoginTimeChartDateRange.change(function () {
            getLoginUserDataFromTime('custom', this.value);
        });
        userLoginChartByTimeElement.change(function () {
            if (this.value === 'custom') {
                $('#userLoginTimeChartDateRange').show();
            } else {
                $('#userLoginTimeChartDateRange').hide();
                getLoginUserDataFromTime('days', this.value);
            }
        });


        var userLoginChartByTimeCanvas = $('#userLoginChartByTime').get(0).getContext('2d');
        @php
            $hours24 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];

            $hours12 = array_map(function ($hour) {
                $suffix = $hour < 12 ? trans('common.AM') : trans('common.PM');
                $hour12 = $hour % 12;
                $hour12 = $hour12 === 0 ? 12 : $hour12;
                $hour12 =translatedNumber($hour12);
                return "$hour12 $suffix";
            }, $hours24);
        @endphp
        function getLoginUserDataFromTime(type, days) {
            $.ajax({
                url: '{{url('userLoginChartByTime')}}',
                type: 'GET',
                data: {type: type, days: days},
                success: function (result) {

                    var hours12 = [
                        @foreach($hours12 as $hour)
                            "{{ $hour }}",
                        @endforeach
                    ];
                    var userLoginChartByTimeData = {
                        labels:hours12,
                        datasets: [
                            {
                                label: '{{__('dashboard.User Login Attempt')}}',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 0.5)',
                                pointRadius: true,
                                pointColor: '#3b8bba',
                                borderWidth: 3,
                                pointDot: true,
                                pointDotRadius: 10,
                                pointHoverRadius: 15,
                                pointStrokeColor: 'rgba(54, 162, 235, 1)',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(54, 162, 235, 1)',
                                data: result
                            },
                        ]
                    }

                    var userLoginChartByTimeOptions = {
                        maintainAspectRatio: false,
                        responsive: true,
                        legend: {
                            display: true
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: false,
                                }
                            }]
                        }
                    }


                    new Chart(userLoginChartByTimeCanvas, {
                        type: 'line',
                        data: userLoginChartByTimeData,
                        options: userLoginChartByTimeOptions
                    })

                }, error: function (result, statut, error) { // Handle errors
                    console.log(error);
                }

            });
        }

        getLoginUserDataFromTime('days', 7);
        @endif
    </script>

    <script>

        @if (permissionCheck('dashboard.overview_status_of_courses'))
        var ctx = document.getElementById('course_overview').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['{{__('dashboard.Active')}}', '{{__('dashboard.Pending')}}'],
                datasets: [{
                    label: '{{__('Status Overview of Topics')}}',
                    data: [{{$course_overview['active']}}, {{$course_overview['pending']}}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)'

                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            display: false,
                        }
                    }]
                }
            }
        });
        @endif
        @if (permissionCheck('dashboard.overview_of_courses'))
        var ctx = document.getElementById('course_overview2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['{{__('dashboard.Courses')}}', '{{__('dashboard.Quizzes')}}', '{{__('dashboard.Classes')}}'],
                datasets: [{
                    label: '{{__('Overview of Topics')}}',
                    data: [{{$course_overview['courses']}}, {{$course_overview['quizzes']}}, {{$course_overview['classes']}}],
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
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        @endif


        @if (permissionCheck('dashboard.payment_statistic'))
        var ctx = document.getElementById('payment_statistics').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['{{__('dashboard.Completed')}}', '{{__('dashboard.Pending')}}'],
                datasets: [{
                    label: '{{__('dashboard.Payment Statistics for')}} {{@$payment_statistics['month']}}',
                    data: [{{$payment_statistics['paid']->count()}}, {{$payment_statistics['unpaid']->count()}}],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            format: {
                                numberingSystem: 'thai'
                            }
                        }
                    }]
                }
            }
        });
        @endif
        var enroll_day = [];
        @foreach($enroll_day as $key => $val)
        enroll_day.push('{{$val}}');
        @endforeach

        var enroll_count = [];
        @foreach($enroll_count as $key => $val)
        enroll_count.push('{{$val}}');
        @endforeach
        var ctx = document.getElementById('enroll_overview').getContext('2d');
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        @if (permissionCheck('dashboard.daily_wise_enroll'))
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {

                labels: enroll_day,
                datasets: [{
                    label: '{{__('dashboard.Daily Wise Enroll Status for')}} {{\Carbon\Carbon::now()->format('F')}}',
                    data: enroll_count,
                    backgroundColor: 'rgba(124, 50, 255, 0.5)',
                    borderColor: 'rgba(124, 50, 255, 0.5)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        @endif
        var month_name = [];
        @foreach($courshEarningM_onth_name as $key => $val)
        month_name.push('{{$val}}');
        @endforeach

        var monthly_earn = [];
        @foreach($courshEarningMonthly as $key => $val)
        monthly_earn.push('{{$val}}');
        @endforeach


        @if (permissionCheck('dashboard.monthly_income'))
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {

                labels: month_name,
                datasets: [{
                    label: '{{__('dashboard.Monthly Income Stats for')}} {{@$payment_statistics['month']}} {{$payment_statistics['year']}}',
                    data: monthly_earn,
                    backgroundColor: 'rgba(124, 50, 255, 0.5)',
                    borderColor: 'rgba(124, 50, 255, 0.5)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        @endif
        @if(isModuleActive('CPD'))
        var student_name = [];
        var total_course = [];
        @foreach($students as $key => $val)
        student_name.push('{{$val->name}}');
        total_course.push('{{$val->cpds_count}}');
        @endforeach

        var ctx = document.getElementById('myChartCPD').getContext('2d');
        var myChartCPD = new Chart(ctx, {
            type: 'bar',
            maintainAspectRatio: false,
            responsive: true,
            data: {

                labels: student_name,
                datasets: [{
                    label: '{{__('cpd.Student Course Statistic')}}',
                    data: total_course,
                    backgroundColor: 'rgba(124, 50, 255, 0.5)',
                    borderColor: 'rgba(124, 50, 255, 0.5)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        @endif
    </script>


    <script>
        let url = "{{route('getDashboardData')}}";
        $(document).ready(function () {
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    $('#totalStudent').html(data.student);
                    $('#totalInstructor').html(data.instructor);
                    $('#totalCourses').html(data.allCourse);
                    $('#totalEnroll').html(data.totalEnroll);
                    $('#totalSell').html(data.totalSell);
                    $('#totalRevenue').html(data.adminRev);
                    $('#totalToday').html(data.today);
                    $('#totalThisMonth').html(data.thisMonthEnroll);
                }
            });
        });

    </script>
@endpush
