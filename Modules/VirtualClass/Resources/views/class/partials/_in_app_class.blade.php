<table id="lms_table" class="table Crm_table_active3">
    <thead>
    <tr>
    <tr>
        <th>#</th>
        <th>   {{__('jitsi.ID')}}</th>
        <th>   {{__('jitsi.Topic')}}</th>
        <th>   {{__('jitsi.Date')}}</th>
        <th>   {{__('jitsi.Time')}}</th>
        <th>   {{__('jitsi.Duration')}}</th>
        <th>   {{__('jitsi.Join')}}</th>

        <th>{{__('jitsi.Actions')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($class->inAppMeetings as $key => $meeting )
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $meeting->meeting_id }}</td>
            <td>{{ $meeting->topic }}</td>
            <td>
                {{showDate($meeting->date)}}
            </td>            <td>{{ $meeting->time }}</td>
            <td> @if($meeting->duration==0)
                    {{__('common.Unlimited')}}
                @else
                    {{ MinuteFormat($meeting->duration) }}
                @endif
            </td>

            <td>
                <a class="primary-btn small fix-gr-bg text-white" target="_blank"
                   href="{{ route('inappliveclass.meetings.show', $meeting->id) }}">{{__('common.Start')}}</a>
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
                           href="#">{{__('common.Delete')}}</a>

                    </div>
                </div>


            </td>
        </tr>


        <div class="modal fade admin-query" id="d{{$meeting->id}}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('common.Delete')}} {{__('virtual-class.Class')}}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">&times;
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="text-center">
                            <h4>{{__('common.Are you sure to delete ?')}}</h4>
                        </div>

                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                            <form class=""
                                  action="{{ route('inappliveclass.meetings.destroy',$meeting->id) }}"
                                  method="POST">
                                @csrf
                                @method('delete')
                                <button class="primary-btn fix-gr-bg"
                                        type="submit">{{__('common.Delete')}}</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    @endforeach
    </tbody>
</table>
