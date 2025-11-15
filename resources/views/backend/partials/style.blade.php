<link rel="stylesheet" href="{{asset('public/backend/css/jquery-ui.css')}}{{assetVersion()}}"/>

<link rel="stylesheet" href="{{asset('public/backend/vendors/font_awesome/css/all.min.css')}}{{assetVersion()}}"/>
<link rel="stylesheet" href="{{asset('public/backend/css/themify-icons.css')}}{{assetVersion()}}"/>


<link rel="stylesheet" href="{{asset('public/chat/css/style.css')}}{{assetVersion()}}">
<link rel="stylesheet" href="{{asset('public/css/preloader.css')}}{{assetVersion()}}"/>
@if(isModuleActive("WhatsappSupport"))
    <link rel="stylesheet" href="{{asset('public/whatsapp-support/style.css')}}{{assetVersion()}}"/>
@endif

<link rel="stylesheet" href="{{asset('public/backend/css/fullcalendar.min.css')}}{{assetVersion()}}">

<link rel="stylesheet" href="{{asset('public/backend/css/app.css')}}{{assetVersion()}}">



@if(isRtl())
    <link rel="stylesheet" href="{{asset('public/backend/css/backend_style_rtl.css')}}{{assetVersion()}}"/>
@else
    <link rel="stylesheet" href="{{asset('public/backend/css/backend_style.css')}}{{assetVersion()}}"/>
@endif

<!-- uppy css -->
<link rel="stylesheet" href="{{asset('public/vendor/uppy/uppy.min.css')}}">
<link rel="stylesheet" href="{{asset('public/vendor/uppy/media.css')}}">

@stack('styles')




