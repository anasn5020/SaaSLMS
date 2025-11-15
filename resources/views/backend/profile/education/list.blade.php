<ul class="list-group list-group-flush">
    @forelse($user->userEducations as $education )
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{$education->institution}}</h4>
                <p class="text-muted">{{$education->degree}}</p>
                <small class="text-muted">{{showDate($education->start_date)}} @if($education->end_date)
                        -
                    @endif {{showDate($education->end_date)}}</small>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a data-id="{{$education->id}}" href="javascript:void(0);"
                   class="primary-btn fix-gr-bg edit_education_btn">{{__('common.Edit')}}</a>
                <a href="{{route('users.educations.destroy',$education->id)}}"
                   class="primary-btn fix-gr-bg delete_item">{{__('common.Delete')}}</a>
            </div>

        </li>

    @empty
        @include('backend.profile._empty_data_msg')
    @endforelse
</ul>
