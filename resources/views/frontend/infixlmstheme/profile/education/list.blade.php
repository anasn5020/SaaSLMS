<ul class="list-group list-group-flush">
    @forelse($user->userEducations as $education )
        <li class="list-group-item d-flex flex-column flex-sm-row gap-3 justify-content-between align-items-start align-items-sm-center px-0">
            <div>
                <h4 class="mb-1">{{$education->institution}}</h4>
                <p class="text-muted">{{$education->degree}}</p>
                <small class="text-muted">{{showDate($education->start_date)}}
                    - {{showDate($education->end_date)}}</small>
            </div>
            <div>
                <a data-id="{{$education->id}}" href="javascript:void(0);"
                   class="link_value theme_btn small_btn4 edit_education_btn">{{__('common.Edit')}}</a>
                <a href="{{route('users.educations.destroy',$education->id)}}"
                   class="link_value theme_btn small_btn4 delete_item">{{__('common.Delete')}}</a>
            </div>

        </li>

    @empty
        @include(theme('profile._empty_data_msg'))
    @endforelse
</ul>
