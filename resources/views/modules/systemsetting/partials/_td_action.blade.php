<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{trans('common.Action')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">
        @if (permissionCheck('instructor.secretLogin'))
            <a class="dropdown-item" href="{{route('secretLogin', $query->id)}}"
               type="button">{{trans('common.Secret Login') }}</a>
        @endif

        <a class="dropdown-item"
           href="{{route('instructor.show', $query->id)}}">
            {{trans('common.Show') }}</a>

        @if (permissionCheck('instructor.edit'))
            @if (isModuleActive('Appointment'))
                <a class="dropdown-item" target="_blank"
                   href="{{route('appointment.instructor.edit', [$query->id])}}"> {{trans('common.Edit')}}
                </a>
            @else

                <a href="{{route('instructor.edit', $query->id)}}"
                   class="dropdown-item "
                   type="button">{{trans('common.Edit')}}
                </a>
            @endif
        @endif

        @if (permissionCheck('instructor.delete'))
            <button class="dropdown-item deleteInstructor"
                    data-id="{{$query->id}}"
                    type="button">{{trans('common.Delete')}}
            </button>
        @endif


    </div>
</div>
