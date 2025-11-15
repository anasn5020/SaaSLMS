<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{trans('common.Action')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">


        <a target="_blank"
           href="{{courseDetailsUrl($query->id, $query->type, $query->slug)}}"
           class="dropdown-item"
        > {{trans('courses.Frontend View')}}</a>

        <a class="dropdown-item edit_brand"
           href="{{route('virtual-class.details', [$query->id])}}">{{trans('common.Details')}}</a>

        @if (permissionCheck('virtual-class.edit'))
            <a class="dropdown-item edit_brand"
               href="{{route('virtual-class.edit', [$query->id])}}">{{trans('common.Edit')}}</a>
        @endif

        @if (permissionCheck('virtual-class.destroy'))
            <button class="dropdown-item deleteClass"
                    data-id="{{$query->id}}"
                    type="button">{{trans('common.Delete')}}
            </button>
        @endif
        @if (isModuleActive('EarlyBird') && permissionCheck('earlybird.plan.virtual_class_plan_list'))
            <a class="dropdown-item"
               href="{{route('earlybird.plan.virtual_class_plan_list', $query->id)}}">
                {{_trans('price_plan.Price Plan')}}
            </a>
        @endif

    </div>
</div>


