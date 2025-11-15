@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Session::has("impersonated"))
    <div class="secret_login text-center p-3 d-flex align-items-center justify-content-center">
        <span class="me-1">{{__('common.Login as')}}&nbsp;</span>
        <b>{{\Illuminate\Support\Facades\Auth::user()->email}} &nbsp;</b>
        <a class="primary-btn fix-gr-bg ms-3 theme_btn_mini theme_btn " href="{{route('secretLoginExit')}}">
            {{__('common.Exit Now')}}
        </a>
    </div>
@endif
