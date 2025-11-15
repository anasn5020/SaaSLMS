<table id="lms_table" class="table Crm_table_active3">
    <thead>
    <tr>
    <tr>
        <th> {{__('common.SL')}}</th>
        <th>{{__('zoom.ID')}}</th>
        <th>{{__('zoom.Date')}}</th>
        <th>{{__('zoom.Time')}}</th>
        <th>{{__('zoom.Timezone')}}</th>
        <th>{{__('zoom.Duration')}}</th>
        <th>{{__('zoom.Start Join')}}</th>
        <th>{{__('zoom.Actions')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($class->googleMeetMeetings as $key => $meeting )

        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $meeting->meetingId }}</td>
            <td>{{ showDate($meeting->start_date_time) }}</td>
            <td>{{ showTime($meeting->start_date_time) }}</td>
            <td>
                @php
                    $start_response = json_decode($meeting->start_response);
                @endphp

                {{$start_response->timeZone}}
                ( {{\Carbon\Carbon::parse($meeting->start_date_time)->tz()}} )
            </td>
            <td>{{ MinuteFormat(\Carbon\Carbon::parse($meeting->start_date_time)->diffInMinutes($meeting->end_date_time)) }}</td>

            <td>
                @if($meeting->currentStatus == 'started')

                    <a class="primary-btn small fix-gr-bg small   text-white border-0"
                       href="{{ $meeting->hangoutLink }}"
                       target="_blank">
                        @if (Auth::user()->role_id == 1 || Auth::user()->id == $meeting->instructor_id)
                            {{__('zoom.Start')}}
                        @else
                            {{__('zoom.Join')}}
                        @endif
                    </a>

                @elseif( $meeting->currentStatus == 'waiting')
                    <a href="#"
                       class="primary-btn small bg-info text-white border-0">Waiting</a>
                @else
                    <a href="#"
                       class="primary-btn small bg-warning text-white border-0">Closed</a>
                @endif
            </td>
            <td>

                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenu2" data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                        {{ __('common.Select') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right"
                         aria-labelledby="dropdownMenu2">
                        @include('virtualclass::class.partials._record_action')

                        <a class="dropdown-item" data-bs-toggle="modal"
                           data-bs-target="#d{{$meeting->id}}"
                           href="#">{{__('zoom.Delete')}}</a>


                    </div>
                </div>


            </td>
        </tr>


        <div class="modal fade admin-query" id="d{{$meeting->id}}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('zoom.Delete Class')}}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">&times;
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="text-center">
                            <h4>{{__('common.Are you sure to delete ?')}}</h4>
                        </div>

                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('zoom.Cancel')}}</button>
                            <form class=""
                                  action="{{ route('google_meet.meetings.destroy',$meeting->id) }}"
                                  method="POST">
                                @csrf
                                @method('delete')
                                <button class="primary-btn fix-gr-bg"
                                        type="submit">{{__('zoom.Delete')}}</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    @endforeach
    </tbody>
</table>
