<!doctype html>
<html dir="{{isRtl()?'rtl':''}}" class="{{isRtl()?'rtl':''}}" lang="en" itemscope
      itemtype="{{url('/')}}">

<head>
    @laravelPWA
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="icon" href="{{asset(Settings('favicon'))}}{{assetVersion()}}" type="image/png"/>

    {{-- Open Graph Meta Tags --}}
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="@yield('meta_title', Settings('site_title'))"/>
    <meta property="og:description" content="@yield('meta_description', Settings('footer_about_description'))"/>
    <meta property="og:image" content="@yield('og_image', Settings('logo'))"/>
    <meta property="og:image:type" content="image/png"/>

    {{-- Twitter Meta Tags --}}
    <meta property="twitter:title" content="@yield('meta_title', Settings('site_title'))"/>
    <meta property="twitter:description" content="@yield('meta_description', Settings('meta_description'))"/>
    <meta property="twitter:image" content="@yield('og_image', Settings('logo'))"/>
    <meta property="twitter:url" content="{{ url()->current() }}"/>
    <meta property="twitter:card" content="summary_large_image"/>

    {{-- Standard Meta Tags --}}
    <meta name="title" content="@yield('meta_title', Settings('site_title'))">
    <meta name="description" content="@yield('meta_description', Settings('meta_description'))">
    <meta name="keywords" content="{{ Settings('meta_keywords') }}">


    {{-- Structured Data --}}
    <meta itemprop="name" content="@yield('meta_title', Settings('site_title'))">
    <meta itemprop="description" content="@yield('meta_description', Settings('meta_description'))">
    <meta itemprop="image" content="@yield('og_image', Settings('logo'))">
    <meta itemprop="author" content="{{ Settings('site_name') }}">



    {{-- Title Tag --}}
    <title>@yield('title', Settings('site_title'))</title>



    {{-- Conditional Meta Tags Based on Route --}}
    @if(routeIs('frontendHomePage'))
        <meta itemprop="description" content="{{ Settings('meta_description') }}">
        <meta property="og:description" content="{{ Settings('meta_description') }}">
        <meta itemprop="keywords" content="{{ Settings('meta_keywords') }}">
    @elseif(routeIs('courseDetailsView') || routeIs('quizDetailsView'))
        <meta itemprop="description" content="{{ $course->meta_description }}">
        <meta property="og:description" content="{{ $course->meta_description }}">
        <meta itemprop="keywords" content="{{ $course->meta_keywords }}">
    @endif


    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset(Settings('favicon') )}}">
    <!-- Place favicon.ico in the root directory -->


    <x-frontend-dynamic-style-color/>
    <x-backend-dynamic-color/>

    @if(isRtl())
        <link rel="stylesheet"
              href="{{ asset('public/frontend/infixlmstheme') }}/css/bootstrap.rtl.min.css{{assetVersion()}} ">
    @else
        <link rel="stylesheet"
              href="{{ asset('public/frontend/infixlmstheme') }}/css/bootstrap.min.css{{assetVersion()}} ">
    @endif

    <link rel="stylesheet" href="{{asset('public/backend/css/themify-icons.css')}}{{assetVersion()}}"/>
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/notification.css{{assetVersion()}}">
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/css/mega_menu.css') }}">

    <link href="{{asset('public/backend/css/summernote-bs5.min.css')}}{{assetVersion()}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/css/preloader.css')}}{{assetVersion()}}"/>

    @if(str_contains(request()->url(), 'chat'))
        <link rel="stylesheet" href="{{asset('public/backend/css/jquery-ui.css')}}{{assetVersion()}}"/>
        <link rel="stylesheet" href="{{asset('public/backend/vendors/select2/select2.css')}}{{assetVersion()}}"/>
        <link rel="stylesheet" href="{{asset('public/chat/css/style-student.css')}}{{assetVersion()}}">
    @endif

    @if(auth()->check() && auth()->user()->role_id == 3 && !str_contains(request()->url(), 'chat'))
        <link rel="stylesheet" href="{{asset('public/chat/css/notification.css')}}{{assetVersion()}}">
    @endif

    @if(isModuleActive("WhatsappSupport"))
        <link rel="stylesheet" href="{{ asset('public/whatsapp-support/style.css') }}{{assetVersion()}}">
    @endif
    <script>
        window.Laravel = {
            "baseUrl": '{{ url('/') }}' + '/',
            "current_path_without_domain": '{{request()->path()}}',
            "csrfToken": '{{csrf_token()}}',
        }
    </script>


    <script>
        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! $jsonLang??''!!};

    </script>


    @if(!empty(Settings('facebook_pixel')))
        <!-- Facebook Pixel Code -->
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', {{Settings('facebook_pixel')}});
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                 src="https://www.facebook.com/tr?id={{Settings('facebook_pixel')}}/&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
    @endif

    <input type="hidden" name="lat" class="lat" value="{{Settings('lat') }}">
    <input type="hidden" name="lng" class="lng" value="{{Settings('lng') }}">
    <input type="hidden" name="zoom" class="zoom" value="{{Settings('zoom_level')}}">
    <input type="hidden" id="baseUrl" value="{{url('/')}}">
    <input type="hidden" name="chat_settings" id="chat_settings" value="{{ env('BROADCAST_DRIVER') }}">
    <input type="hidden" name="slider_transition_time" id="slider_transition_time"
           value="{{Settings('slider_transition_time')?Settings('slider_transition_time'):5}}">

    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/app.css{{assetVersion()}}"
          media="screen,print">

    @if(isRtl())
        <link rel="stylesheet"
              href="{{ asset('public/frontend/infixlmstheme') }}/css/frontend_style_rtl.css{{assetVersion()}}"
              media="screen,print">
    @else
        <link rel="stylesheet"
              href="{{ asset('public/frontend/infixlmstheme') }}/css/frontend_style.css{{assetVersion()}}"
              media="screen,print">
    @endif
    <script src="{{asset('public/frontend/infixlmstheme')}}/js/common.js{{assetVersion()}}"></script>
    @yield('css')

    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/css/custom.css') }}">

    {{--    //analytics tools--}}
    <x-analytics-tool/>
</head>

<body>

@include('secret_login')
