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
        @if(permissionCheck('admin.user_delete_request.destroy'))
            <a class="dropdown-item delete_item" data-id="{{$row->id}}">{{__('common.Delete')}}</a>
        @endif

        @if(permissionCheck('admin.user_delete_request.reject'))
            <a class="dropdown-item reject_item" data-id="{{$row->id}}">{{__('common.Reject')}}</a>
        @endif
    </div>
</div>
