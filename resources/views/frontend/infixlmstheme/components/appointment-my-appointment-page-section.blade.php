<div class="main_content_iner main_content_padding">

    @php
        $week_number = isset($week_number) ? $week_number : $this_week;
        $start_date = date('Y-m-d', strtotime($weekDates[0]));
        $end_date = date('Y-m-d', strtotime($weekDates[6]));
    @endphp
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div class="section__title3 mb_40">
                        <h3 class="mb-0">
                            {{ __('appointment.Schedule') }}
                        </h3>
                    </div>
                </div>

                <div class="col-12">
                    <div class="view_full_shedule_inner p-0">
                        <div class="view_full_shedule_inner_calendar">
                            <div class="view_full_shedule_inner_calendar_header">
                                <div class="d-flex align-items-center" id="calendarChanges">
                                    <button id='icon' class="preWeekSchedule me-1"
                                        {{ date('Y-m-d', strtotime($weekDates[0])) < \Carbon\Carbon::now()->format('Y-m-d') ? 'disabled' : '' }}>
                                        <i
                                            class="fa fa-angle-left"></i></button>
                                    <button id='icon' class="nextWeekSchedule"><i
                                            class="fa fa-angle-right"></i></button>
                                    <span class='text-primary-2 font-weight-semibold ms-4' id="schedule_date">
                                        {{ date('F j', strtotime($weekDates[0])) . ' - ' . date('F j', strtotime($weekDates[6])) . ' , ' . date('Y', strtotime($weekDates[0])) }}
                                    </span>
                                </div>

                            </div>

                            <div class="schedule_loader d-none" id="calender_pre_loader">
                                <div class="row position-relative text-center">
                                    <div class="course-preloader ">
                                        <i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="view_full_shedule_inner_calendar_body" id="calendar_body">


                                @foreach ($periods as $date)
                                    <div id="calender_date">
                                        @php
                                            $bookingList = \Modules\Appointment\Entities\Booking::bookingList($date, auth()->user());
                                        @endphp
                                        <div id="header" {{ count($bookingList) == 0 ? 'event-offday' : '' }}>
                                            <span>{{ $date->format('l') }}</span>
                                            <h4>{{ $date->format('d') }}</h4>
                                        </div>

                                        @foreach ($bookingList as $key => $scheduleInfo)
                                            @php
                                                $tz = $scheduleInfo->timezone ?? Settings('active_time_zone');
                                            @endphp
                                            <div id="event_date" class="selected m-1">

                                                {{ $key+1 }}. <a data-bs-toggle="modal" id=""
                                                                 data-bs-target="#showDetail{{ $scheduleInfo['id'] }}"
                                                                 href="#"
                                                                 class="primary-btn small icon-only"
                                                                 data-bs-modal-size="modal-md">
                                                    <span class="ti-eye selected" id=""></span>
                                                </a> <br>


                                            </div>

                                            <div class="modal fade admin-query"
                                                 id="showDetail{{ $scheduleInfo['id'] }}">
                                                <div class="modal-dialog  modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4>{{__('frontend.Schedule')}}</h4>
                                                            <button type="button" class="close "
                                                                    data-bs-dismiss="modal">
                                                                <i class="ti-close "></i>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <div class="pb-3">
                                                                        <table class="table table-striped">
                                                                            <tr>
                                                                                <th>
                                                                                    {{__('common.Time')}}
                                                                                </th>
                                                                                <td>
                                                                                    {{ \Carbon\Carbon::parse($date->format('Y-m-d') . ' ' . $scheduleInfo['start_time'])->setTimeZone($tz)->format('h:i A') }}
                                                                                    -
                                                                                    {{ \Carbon\Carbon::parse($date->format('Y-m-d') . ' ' . $scheduleInfo['end_time'])->setTimeZone($tz)->format('h:i A') }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>
                                                                                    {{__('common.Category')}}
                                                                                </th>
                                                                                <td>
                                                                                    {{ $scheduleInfo['category'] }}
                                                                                    {{ $scheduleInfo['subCategory'] ? '(' . $scheduleInfo['subCategory'] . ')' : '' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th> {{ __('common.Instructor') }}</th>
                                                                                <td> {{ $scheduleInfo['instructor'] }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>{{ __('appointment.Link') }}</th>
                                                                                <td>
                                                                                    @if($scheduleInfo['share_link']??'')
                                                                                        <a href="{{ $scheduleInfo['share_link']??"#" }}">{{__('common.Link')}}</a>
                                                                                    @else
                                                                                        {{__('common.N/A')}}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <th>{{ __('common.Note') }}</th>
                                                                                <td>
                                                                                    {{ $scheduleInfo['note'] }}
                                                                                </td>
                                                                            </tr>
                                                                        </table>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach

                            </div>

                            <div class="view_full_shedule_inner_calendar_bottom d-none">
                                <p>{{ __('appointment.The calendar is in your time zone') }} </p>
                                <a href="#" class="theme_btn">{{ __('appointment.Confirm time') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
