@php
    $flag = true;
    if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
        if($query->course->user_id == auth()->id() || $query->course->user->organization_id ==  auth()->id()){
           $flag = true;
        }else{
             $flag = false;
        }

    }
@endphp


@if ($query->refund != 1 && permissionCheck('course.delete') && $flag)

    @php
        $deleteUrl = route('admin.enrollDelete', $query->id);
        $refundUrl = route('admin.enrollDelete', $query->id) . '?refund';


        $hasCertificate=false;
        if ($query->course->certificate_records->where('student_id', $query->user_id)->count() > 0) {
            $hasCertificate = true;
        }
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
            @if(Settings('manually_assign_certificate') == '1')
                @if($hasCertificate)
                    <a onclick="confirm_remove_certificate_modal('{{$query->id}}')"
                       class="dropdown-item  ">
                        {{trans('certificate.Remove Certificate')}}
                    </a>
                @else
                    <a onclick="confirm_generate_certificate_modal('{{$query->id}}')"
                       class="dropdown-item  ">
                        {{trans('certificate.Generate Certificate')}}
                    </a>
                @endif
            @endif

            <a onclick="confirm_refund_modal('{{$query->id}}')"
               class="dropdown-item edit_brand">
                {{trans('common.Refund') .' '. trans('common.Course')}}
            </a>
            <a onclick="confirm_cancel_modal('{{$query->id}}')"
               class="dropdown-item edit_brand">{{trans('common.Cancel') . ' ' . trans('common.Course') }}</a>
        </div>
    </div>

@endif
