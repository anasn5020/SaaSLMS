@php
    $refundUrl = route('admin.enrollDelete', $query->id) . '?refund&cancel';
@endphp

<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{trans('common.Action') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">

        {{--        @if ($query->refund != 1 && permissionCheck('course.delete'))--}}

        {{--            <a onclick="confirm_refund_modal('{{ $query->id}}')"--}}
        {{--               class="dropdown-item">--}}
        {{--                {{trans('common.Refund')}}--}}
        {{--            </a>--}}
        {{--        @endif--}}

        @if($query->reason)
            <a data-reason="{{$query->reason}}" class="dropdown-item show_reason">
                {{trans('frontend.Reason')}}
            </a>
        @endif

        @if(permissionCheck('refund.approved') && $query->status == 0)
            <a href="{{route('refund.approved',$query->id)}}" data-id="{{$query->id}}"
               class="dropdown-item refund_approved">
                {{trans('common.Approved')}}
            </a>
        @endif

        @if(permissionCheck('refund.reject') && $query->status == 0)
            <a href="{{route('refund.reject',$query->id)}}" data-id="{{$query->id}}"
               class="dropdown-item refund_reject">
                {{trans('common.Reject')}}
            </a>
        @endif


    </div>
</div>
