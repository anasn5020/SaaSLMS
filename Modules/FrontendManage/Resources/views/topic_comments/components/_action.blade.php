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

        @if(permissionCheck('topics.comments.reply') && ($row->reply_id == null || empty($row->reply_id)) )
            <a class="dropdown-item reply_item" data-table="{{$row->source_table}}"
               data-id="{{$row->id}}">{{__('blog.Reply')}}</a>
        @endif

        @if(permissionCheck('topics.comments.destroy'))
            <a class="dropdown-item delete_item" data-table="{{$row->source_table}}"
               data-id="{{$row->id}}">{{__('common.Delete')}}</a>
        @endif
    </div>
</div>
