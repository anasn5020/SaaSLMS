<ul class="list-group list-group-flush">
    @forelse($user->userExperiences as $experience )
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{$experience->title}}</h4>
                <p class="text-muted">{{$experience->company_name}}</p>
                @if($experience->duration())
                    <small class="text-muted">{{showDate($experience->start_date)}}
                        - {{$experience->currently_working?'Present':showDate($experience->end_date)}}
                        [ {{$experience->duration()}} ]</small>
                @endif
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a data-id="{{$experience->id}}" href="javascript:void(0);"
                   class="primary-btn fix-gr-bg edit_experience_btn">{{__('common.Edit')}}</a>
                <a href="{{route('users.experiences.destroy',$experience->id)}}"
                   class="primary-btn fix-gr-bg delete_item">{{__('common.Delete')}}</a>
            </div>

        </li>

    @empty
        @include('backend.profile._empty_data_msg')
    @endforelse

</ul>
