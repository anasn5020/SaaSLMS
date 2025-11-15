<link rel="stylesheet" href="{{asset('backend/css/jquery-ui.css')}}{{assetVersion()}}"/>

<link rel="stylesheet" href="{{asset('backend/vendors/font_awesome/css/all.min.css')}}{{assetVersion()}}"/>
<link rel="stylesheet" href="{{asset('backend/css/themify-icons.css')}}{{assetVersion()}}"/>


<link rel="stylesheet" href="{{asset('chat/css/style.css')}}{{assetVersion()}}">
<link rel="stylesheet" href="{{asset('css/preloader.css')}}{{assetVersion()}}"/>
@if(isModuleActive("WhatsappSupport"))
    <link rel="stylesheet" href="{{asset('whatsapp-support/style.css')}}{{assetVersion()}}"/>
@endif

<link rel="stylesheet" href="{{asset('backend/css/fullcalendar.min.css')}}{{assetVersion()}}">

<link rel="stylesheet" href="{{asset('backend/css/app.css')}}{{assetVersion()}}">



@if(isRtl())
    <link rel="stylesheet" href="{{asset('backend/css/backend_style_rtl.css')}}{{assetVersion()}}"/>
@else
    <link rel="stylesheet" href="{{asset('backend/css/backend_style.css')}}{{assetVersion()}}"/>
@endif

<!-- uppy css -->
<link rel="stylesheet" href="{{asset('vendor/uppy/uppy.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/uppy/media.css')}}">

@stack('styles')




