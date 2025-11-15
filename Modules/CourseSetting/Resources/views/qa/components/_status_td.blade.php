@php
    $status_enable_eisable='status_enable_disable';
    $checked = $query->status == 1 ? "checked" : "";
@endphp
<label class="switch_toggle">
    <input type="checkbox" class="status_enable_disable"
           value="{{$query->id}}"
        {{$checked}}><i class="slider round"></i></label>
