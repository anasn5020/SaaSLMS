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
        <a class="dropdown-item show_notification" data-msg="{{$row->message}}">{{__('common.View')}}</a>
        @if(permissionCheck('notifications.posted.destroy'))
            <a class="dropdown-item delete_notification" data-id="{{$row->id}}">{{__('common.Delete')}}</a>
        @endif
    </div>
</div>
