<!doctype html>
<html class="no-js" lang="en" dir={{isRtl() ? 'rtl' : ''}}>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}}
    </title>
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ Settings('site_name')  }}">
    <meta itemprop="description" content="{{ Settings('meta_description')  }}">
    <meta itemprop="image" content="{{asset(Settings('logo') )}}">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ Settings('site_title')  }}">
    <meta property="og:description" content="{{ Settings('meta_description')  }}">
    <meta property="og:image" content="{{asset(Settings('logo') )}}"/>
    <meta property="og:image:type" content="image/png"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{getCourseImage(Settings('favicon') )}}">


    <x-frontend-dynamic-style-color/>
    <x-backend-dynamic-color/>

    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/fluidplayer.min.css">

    {{--    <link rel="stylesheet" href="{{asset('public/backend/css/style.css')}}"/>--}}
    <link rel="stylesheet" href="{{asset('public/css/preloader.css')}}"/>
    @if(isRtl())
        <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/bootstrap.min.css">
    @endif

    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/app.css">
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/fontawesome.css ">
    <link rel="stylesheet" href="{{asset('public/backend/css/themify-icons.css')}}"/>
    @if(isRtl())
        <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/frontend_style_rtl.css">
    @else
        <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/frontend_style.css">
    @endif
    <script src="{{asset('public/frontend/infixlmstheme')}}/js/common.js{{assetVersion()}}"></script>
    {{-- <script src="{{asset('public/frontend/infixlmstheme/js/app.js')}}"></script> --}}
    @yield('css')
    <script>
        // $(document).on("click", ".play_toggle_btn", function () {
        //     $('.courseListPlayer').toggleClass("active");
        //     $('.course_fullview_wrapper').toggleClass("active");
        //     $('.floating-title').fadeToggle('fast')
        // });
        $(document).ready(function () {
            const height = $('.header_area').height();
            $('.course_fullview_wrapper .course__play_warp, .course_fullview_wrapper').css('--top', height + 'px');
            $('.mobile_display_content').css('margin-top', height + 35);
            $('.floating-title').css('top', height);


        });


    </script>

    <script>
        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! $jsonLang??''!!};

    </script>
</head>

<body>

@include('preloader')


<script src="{{ asset('public/frontend/infixlmstheme') }}/js/fluidplayer.min.js"></script>
<input type="hidden" name="base_url" class="base_url" value="{{url('/')}}">
<input type="hidden" name="csrf_token" class="csrf_token" value="{{csrf_token()}}">


@yield('mainContent')

<!-- FOOTER::END  -->
<!-- shoping_cart::start  -->
<div class="shoping_wrapper">
    <div class="dark_overlay"></div>
    <div class="shoping_cart">
        <div class="shoping_cart_inner">
            <div class="cart_header d-flex justify-content-between">
                <h4>{{__('frontend.Shoping Cart')}}</h4>
                <div class="chart_close">
                    <i class="ti-close"></i>
                </div>
            </div>
            <div id="cartView">
                <div class="single_cart">
                    <h4>{{__('frontend.No Item into cart')}}</h4>
                </div>
            </div>


        </div>
        <div class="view_checkout_btn d-flex justify-content-end " style="display: none!important;">
            <a href="{{url('my-cart')}}" class="theme_btn small_btn3 mr_10">{{__('frontend.View cart')}}</a>
            <a href="{{route('CheckOut')}}" class="theme_btn small_btn3">{{__('frontend.Checkout')}}</a>
        </div>
    </div>
</div>


<!-- UP_ICON  -->
<div id="back-top" style="display: none;">
    <a title="Go to Top" href="#">
        <i class="fa fa-angle-up"></i>
    </a>
</div>

@auth
    @if((int)Settings('device_limit_time')!=0)
        @if(\Illuminate\Support\Facades\Auth::user()->role_id==3)
            <script>
                function update() {
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/')}}" + "/update-activity",
                        success: function (data) {


                        }
                    });
                }

                var intervel = "{{Settings('device_limit_time')}}"
                var time = (intervel * 60) - 20;

                setInterval(function () {
                    update();
                }, time * 1000);

            </script>
        @endif
    @endif
@endauth


<script>
    setTimeout(function () {
        $('.preloader').fadeOut('slow', function () {
            $(this).remove();

        });
    }, 0);
</script>
{!! Toastr::message() !!}
@stack('js')
</body>
</html>
