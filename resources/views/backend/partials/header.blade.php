<!DOCTYPE html>
<html dir="{{isRtl()?'rtl':'ltr'}}"
      class="{{isRtl()?'rtl':'ltr'}} {{auth()->check() && auth()->user()->dark_mode==1 ? 'dark' : 'light'}}"
      lang="{{app()->getLocale()}}">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset(Settings('favicon'))}}{{assetVersion()}}" type="image/png"/>
    <title>
        {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}}
    </title>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    @include('backend.partials.style')
    <script src="{{asset('public/js/common.js')}}{{assetVersion()}}" type="application/javascript"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">



    <script>
        window.Laravel = {
            "baseUrl": '{{ url("/") }}' + '/',
            "current_path_without_domain": '{{request()->path()}}',
            "csrfToken": '{{csrf_token()}}',
        }
    </script>

    <script>
        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! $jsonLang??''!!};
        window.jsLang = function (key, replace) {
            let output = '';

            if (key.includes('.')) {
                const parts = key.split('.');
                key = parts[1];
            }

            if (window._translations.hasOwnProperty(key)) {
                output = window._translations[key];
            } else {
                output = key;
            }
            return output;

        }

        function localizeNumbers(text) {
            let numberMap = {
                '0': '{{translatedNumber(0)}}',
                '1': '{{translatedNumber(1)}}',
                '2': '{{translatedNumber(2)}}',
                '3': '{{translatedNumber(3)}}',
                '4': '{{translatedNumber(4)}}',
                '5': '{{translatedNumber(5)}}',
                '6': '{{translatedNumber(6)}}',
                '7': '{{translatedNumber(7)}}',
                '8': '{{translatedNumber(8)}}',
                '9': '{{translatedNumber(9)}}',
            };
            text = text.toString();
            return text.replace(/[0-9]/g, function (match) {
                return numberMap[match];
            });
        }

        window.translatedNumber = function (data) {

            var parsedValue = parseFloat(data);

            if (!isNaN(parsedValue) && isFinite(parsedValue)) {
                return localizeNumbers(data);
            } else {
                return data;
            }

        }

    </script>


    <x-frontend-dynamic-style-color/>
    <x-backend-dynamic-color/>

    <script>
        const RTL = "{{isRtl()}}";
        const LANG = "{{ app()->getLocale() }}";
    </script>

    @livewireStyles

</head>

<body class="admin">
@include('preloader')
<input type="hidden" name="demoMode" id="demoMode" value="{{Config::get('app.demo_mode')}}">
<input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
<input type="hidden" name="active_date_format" id="active_date_format" value="{{Settings('active_date_format')}}">
<input type="hidden" name="js_active_date_format" id="js_active_date_format" value="{{getActiveJsDateFormat()}}">
<input type="hidden" name="table_name" id="table_name" value="@yield('table')">
<input type="hidden" name="csrf_token" class="csrf_token" value="{{csrf_token()}}">
<input type="hidden" name="currency_symbol" class="currency_symbol" value="{{Settings('currency_symbol')}}">
<input type="hidden" name="currency_show" class="currency_show" value="{{Settings('currency_show')}}">
<input type="hidden" name="chat_settings" id="chat_settings" value="{{ env('BROADCAST_DRIVER') }}">
<div class="main-wrapper" style="min-height: 600px">
    <!-- Sidebar  -->
    @if (isModuleActive('LmsSaas') && Auth::user()->is_saas_admin==1 && Auth::user()->active_panel=='saas')
        @include('lmssaas::partials.sidebar')
    @elseif(isModuleActive('LmsSaasMD') && Auth::user()->is_saas_admin==1 && Auth::user()->active_panel=='saas')
        @include('lmssaasmd::partials.sidebar')
    @else
        @include('backend.partials.sidebar')
    @endif


    <!-- Page Content  -->
    <div id="main-content"
         class="{{auth()->check() && auth()->user()->sidebar==1 ? '' : 'top-padding full-width'}}"
    >
@include('secret_login')

@include('backend.partials.menu')
