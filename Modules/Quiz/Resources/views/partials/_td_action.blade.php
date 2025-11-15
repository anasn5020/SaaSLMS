<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{trans('common.Action')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">
        @if (permissionCheck('question-bank.edit'))
            <a class="dropdown-item edit_brand"
               href="{{route('question-bank-edit', [$query->id])}}">{{trans('common.Edit') }}</a>
        @endif
        @if (permissionCheck('question-bank.delete'))
            <button class="dropdown-item deleteQuiz_bank"
                    data-id="{{$query->id}}"
                    data-total="{{$query->quiz_assign_count}}"
                    type="button">{{trans('common.Delete')}}
            </button>
        @endif
    </div>
</div>
