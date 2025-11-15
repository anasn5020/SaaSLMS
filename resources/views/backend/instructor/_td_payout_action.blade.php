@if(auth()->user()->role_id == 1 && $query->status != 1)
    <div class="dropdown CRM_dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button"
                id="dropdownMenu2" data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
            {{trans('common.Action')}}
        </button>
        <div class="dropdown-menu dropdown-menu-right"
             aria-labelledby="dropdownMenu2">
            <a href="#" class="dropdown-item makeAsPaid" data-instructor_id="{{$query->instructor_id}}"
               data-withdraw_id="{{$query->id}}"
               type="button">{{trans('common.Make Paid')}}</a>

        </div>
    </div>
@elseif(auth()->user()->role_id == 1 && $query->status == 1)
    {{trans('common.Marked as paid')}}
@else
    {{trans('common.N/A')}}
@endif
