<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{trans('common.Action')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">


        <a target="_blank" href="{{route('fullScreenView', [$query->course_id, $query->lesson_id])}}"
           class="dropdown-item">
            {{trans('common.View')}}    {{trans('courses.Lesson')}}
        </a>

        @if (permissionCheck('qa.questions.show'))
            @php
                $id = $query->id;
             if ($query->parent_id) {
                 $id = $query->parent_id;
             }
            @endphp
            <a href="{{route('qa.questions.show', [$id])}}" class="dropdown-item">
                {{trans('common.View')}} {{trans('common.Details') }}
            </a>
        @endif

        @if (permissionCheck('qa.questions.edit'))
            <a href="{{route('qa.questions.edit', [$query->id])}}" class="dropdown-item">
                {{__('common.Edit') }}
            </a>
        @endif


        @if (permissionCheck('qa.questions.delete'))
            <a onclick="confirm_modal('{{route('qa.questions.delete', $query->id)}}')"
               class="dropdown-item ">{{trans('common.Delete') }}</a>
        @endif
    </div>
</div>


