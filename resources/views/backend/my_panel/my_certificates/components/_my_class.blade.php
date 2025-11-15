@if(isModuleActive('MyClass') && routeIsExist('get-transcript'))
    <div class="dropdown CRM_dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button"
                id="dropdownMenu2"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
            {{ __('common.Select') }}
        </button>
        <div class="dropdown-menu dropdown-menu-right"
             aria-labelledby="dropdownMenu2">
            <a class="dropdown-item"
               href="{{ route('get-transcript', [$certificate->course_id, auth()->user()->id, 'download']) }}">{{__('common.Download')}}</a>
            <a class="dropdown-item"
               href="{{ route('get-transcript', [$certificate->course_id, auth()->user()->id]) }}">{{__('common.View')}}</a>
        </div>
    </div>
@endif
