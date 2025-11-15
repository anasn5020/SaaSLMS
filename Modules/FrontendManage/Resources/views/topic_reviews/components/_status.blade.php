<label class="switch_toggle">
    <input type="checkbox"
           class="{{permissionCheck('topics.comments.status')?'status_enable_disable':""}}"
           data-table="{{$row->getTable()}}"
            @if ($row->status == 1) checked
           @endif value="{{$row->id}}">
    <i class="slider round"></i>
</label>
