<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu1"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{ __('common.Select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu1">
        <a target="_blank" class="dropdown-item"
           href="{{route('addToCart',[$row->course->id])}}"> {{__('common.Add To Cart')}}</a>
        <a data-heading="{{$row->status == 2 ?'Reject Reason':"Refund/Cancellation Reason"}}"
           data-reason="{{$row->status == 2 ?$row->cancel_reason:$row->reason}}"
           class="dropdown-item show_reason" href="javascript:void(0)"> {{__('frontend.Reason')}}</a>
    </div>
</div>

