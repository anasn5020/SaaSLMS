@include(theme('partials._header'))
@include(theme('partials._menu'))

<input type="hidden" name="base_url" class="base_url" value="{{url('/')}}">
<input type="hidden" name="csrf_token" class="csrf_token" value="{{csrf_token()}}">
@if(auth()->check())
    <input type="hidden" name="balance" class="user_balance" value="{{auth()->user()->balance}}">
@endif
<input type="hidden" name="currency_symbol" class="currency_symbol" value="{{Settings('currency_symbol') }}">
<input type="hidden" name="app_debug" class="app_debug" value="{{env('APP_DEBUG') }}">
@include('preloader')
@yield('mainContent')

@include(theme('partials._footer'))
