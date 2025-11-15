@php
    $ip = request()->ip();
    $browser = Browser::browserName();
    $os = Browser::platformName();
@endphp
@if(($login->os != $os && $login->browser != $browser && $login->ip != $ip) || $login->token != session()->get('login_token'))
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
            <a data-id="{{$login->id}}" class="dropdown-item logout_device"
               href="javascript:void(0)">{{__('frontend.LogOut')}}</a>

        </div>
    </div>
@endif
