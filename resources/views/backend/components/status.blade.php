<div>
    @if(orgPermission($org_id) && (permissionCheck($route) || empty($route)))
        <label class="switch_toggle">
            <input type="checkbox"
                   class="status_enable_disable"
                   @if ($status == 1) checked
                   @endif value="{{$id }}">
            <i class="slider round"></i>
        </label>
    @else
        {{$status==1?trans('common.Active'):trans('common.Inactive')}}
    @endif
</div>
