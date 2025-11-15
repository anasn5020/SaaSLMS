@php
    $tz = isset($userTimeZone) ? $userTimeZone : Settings('active_time_zone');
@endphp

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
                {{ $key + 1 }}. <a data-bs-toggle="modal" id="" data-bs-target="#showDetail{{ $scheduleInfo['id'] }}"
                                   href="#" class="primary-btn small icon-only" data-modal-size="modal-md">
                    <span class="ti-eye selected" id=""></span>
                </a> <br>
            </div>

            <div class="modal fade admin-query" id="showDetail{{ $scheduleInfo['id'] }}">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Schedule</h4>
                            <button type="button" class="close " data-bs-dismiss="modal">
                                <i class="ti-close "></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    {{ \Carbon\Carbon::parse($date->format('Y-m-d') . ' ' . $scheduleInfo['start_time'])->setTimeZone($tz)->format('h:i A') }}
                                    -
                                    {{ \Carbon\Carbon::parse($date->format('Y-m-d') . ' ' . $scheduleInfo['end_time'])->setTimeZone($tz)->format('h:i A') }}

                                    <p> {{ $scheduleInfo['category'] }}
                                        {{ $scheduleInfo['subCategory'] ? '(' . $scheduleInfo['subCategory'] . ')' : '' }}
                                    </p>
                                    <p> {{ __('common.Instructor') }} :
                                        {{ $scheduleInfo['instructor'] }}</p>
                                    <p>{{ __('appointment.Link') }} :
                                        <a href="{{ $scheduleInfo['share_link'] }}">Link</a>
                                        {{ $scheduleInfo['share_link'] }}
                                    </p>
                                    <p> {{ __('common.Note') }} :
                                        {{ $scheduleInfo['note'] }}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
