@if($class->show_record)
    <a class="dropdown-item btn-modal"
       type="button"
       data-container="#commonModal"
       href="{{route('virtual-class.records.create', [$class->id,$meeting->id])}}">{{__('common.Add')}} {{__('virtual-class.Record')}}</a>

    <a class="dropdown-item btn-modal"
       type="button"
       data-container="#commonModal"
       href="{{route('virtual-class.records.index', [$class->id,$meeting->id])}}">{{__('common.View')}} {{__('virtual-class.Record')}}</a>
@endif

