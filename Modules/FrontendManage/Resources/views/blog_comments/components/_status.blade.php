<label class="switch_toggle">
    <input type="checkbox"
           class="{{permissionCheck('blogs.comments.status')?'status_enable_disable':""}}"
            @if ($row->status == 1) checked
           @endif value="{{$row->id}}">
    <i class="slider round"></i>
</label>
