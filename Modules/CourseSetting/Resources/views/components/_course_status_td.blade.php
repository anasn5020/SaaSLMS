@php
    $approve = false;
    if (Auth::user()->role_id != 2) {
    $approve = true;
    } else {
    $courseApproval = Settings('course_approval');
    if ($courseApproval == 0) {
    $approve = true;
    }
    }

@endphp
@if ($approve)
    @php
        if (permissionCheck('course.status_update')) {
        $status_enable_eisable = "status_enable_disable";
        } else {
        $status_enable_eisable = "";
        }
        $checked = $query->status == 1 ? "checked" : "";
    @endphp

    <label class="switch_toggle">
        <input type="checkbox" class="{{$status_enable_eisable}}"
               value="{{$query->id}}"
            {{$checked}}><i class="slider round"></i></label>
@else
    {{$query->status == 1 ? trans('common.Approved') : trans('common.Pending')}}
@endif


