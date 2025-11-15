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
        <a class="dropdown-item  comment_show" data-comment="{{$row->comment}}"
           href="javascript:void(0);">{{__('common.View')}}</a>

        @if(permissionCheck('blogs.comments.reply') && $row->type == 1)
            <a class="dropdown-item reply_item" data-id="{{$row->id}}">{{__('blog.Reply')}}</a>
        @endif

        @if(permissionCheck('blogs.comments.destroy'))
            <a class="dropdown-item delete_item" data-id="{{$row->id}}">{{__('common.Delete')}}</a>
        @endif
    </div>
</div>
