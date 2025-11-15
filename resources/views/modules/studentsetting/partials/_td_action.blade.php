<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{trans('common.Action')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">
        @if (permissionCheck('student.secretLogin'))
            <a class="dropdown-item" href="{{route('secretLogin', $query->id)}}"
               type="button">{{trans('common.Secret Login') }}</a>
        @endif

        <a class="dropdown-item"
           href="{{route('student.show', $query->id)}}">
            {{trans('common.Show') }}</a>

        @if (permissionCheck('student.edit'))
            <a
                href="{{route('student.edit',$query->id)}}"
                class="dropdown-item "
                type="button">{{trans('common.Edit') }}
            </a>
        @endif

        @if (permissionCheck('student.delete'))
            <button class="dropdown-item deleteStudent"
                    data-id="{{$query->id}}"
                    type="button">{{trans('common.Delete')}}
            </button>
        @endif

        @if (permissionCheck('student.courses'))
            <a class="dropdown-item" href="{{route('student.courses', $query->id)}}"
               data-id="{{$query->id}}" type="button">{{trans('courses.Course')}}</a>
        @endif

        @if (isModuleActive('SkillAndPathway'))
            <a class="dropdown-item" href="{{route('student.skillgroup', $query->id)}}"
               data-id="{{$query->id}}" type="button">{{trans('group.group')}}</a>
        @endif
        @if (permissionCheck('student.loginActivity'))
            <a class="dropdown-item" href="{{route('student.loginActivity', $query->id)}}"
               type="button">{{trans('student.Login Activity')}}</a>
        @endif


    </div>
</div>
