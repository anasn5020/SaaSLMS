<table id="lms_table" class="table Crm_table_active3">
    <thead>
    <tr>
    <tr>
        <th>{{__('common.SL')}}</th>
        <th>   {{__('bbb.ID')}}</th>
        <th>   {{__('bbb.Topic')}}</th>
        <th>   {{__('bbb.Date')}}</th>
        <th>   {{__('bbb.Time')}}</th>
        <th>   {{__('bbb.Duration')}}</th>
        <th>   {{__('bbb.Join as Moderator')}}</th>
        <th>   {{__('bbb.Join as Attendee')}}</th>

        <th>{{__('bbb.Actions')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($class->bbbMeetings as $key => $meeting )
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $meeting->meeting_id }}</td>
            <td>{{ $meeting->topic }}</td>
            <td>
                {{showDate($meeting->date)}}
            </td>
            <td>{{ $meeting->time }}</td>
            <td> @if($meeting->duration==0)
                    Unlimited
                @else
                    {{ MinuteFormat($meeting->duration) }}
                @endif

            </td>
            <td>
                <form action="{{route('bbb.meetingStart')}}" method="post">
                    @csrf
                    <input type="hidden" name="meetingID"
                           value="{{$meeting->meeting_id}}">
                    <input type="hidden" name="type"
                           value="Moderator">
                    <button type="submit" class="primary-btn small fix-gr-bg">Join
                    </button>
                </form>
            </td>
            <td>
                <form action="{{route('bbb.meetingStart')}}" method="post">
                    @csrf
                    <input type="hidden" name="meetingID"
                           value="{{$meeting->meeting_id}}">
                    <input type="hidden" name="type"
                           value="Attendee">
                    <button type="submit" class="primary-btn small fix-gr-bg">Join
                    </button>
                </form>
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

                        <a class="dropdown-item"
                           href="{{ route('bbb.meetings.show', $meeting->id) }}">{{__('bbb.View')}}</a>

                        <a class="dropdown-item"
                           href="{{ route('bbb.recordList', $meeting->id) }}">{{__('bbb.Record List')}}</a>


                        <a class="dropdown-item" data-bs-toggle="modal"
                           data-bs-target="#d{{$meeting->id}}"
                           href="#">{{__('bbb.Delete')}}</a>

                    </div>
                </div>


            </td>
        </tr>


        <div class="modal fade admin-query" id="d{{$meeting->id}}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('bbb.Delete Class')}}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">&times;
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="text-center">
                            <h4>{{__('common.Are you sure to delete ?')}}</h4>
                        </div>

                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('bbb.Cancel')}}</button>
                            <form class=""
                                  action="{{ route('bbb.meetings.destroy',$meeting->id) }}"
                                  method="POST">
                                @csrf
                                @method('delete')
                                <button class="primary-btn fix-gr-bg"
                                        type="submit">{{__('bbb.Delete')}}</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    @endforeach
    </tbody>
</table>
