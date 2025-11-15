<link rel="stylesheet" href="{{themeAsset('css/sections/sponsor.css')}}">

<div class="sponsor">
    @if(count($result)!=0)
        <div class="sponsor-title text-center">
            <h4 class="fw-bold text-primary">{{__('frontend.Our Partner')}}</h4>
        </div>
        <div class="sponsor-slider owl-carousel">
            @foreach ($result as $sponsor)
                <div class="sponsor-single no-shadow">
                    <img src="{{asset($sponsor->image)}}" alt="{{$sponsor->title}}">
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    (function () {
        'use strict'
        jQuery(document).ready(function () {
            const navLeft =
                '<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M8.3125 0.625244L0.499998 8.43778V10.6253L8.3125 18.4378L10.5313 16.2503L5.40625 11.094H22.8125V7.96903H5.40625L10.5625 2.81275L8.3125 0.625244Z" fill="currentColor"/></svg>';
            const navRight =
                '<svg width="23" height="18" viewBox="0 0 23 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.1875 17.8125L23 9.99996V7.81245L15.1875 -8.7738e-05L12.9687 2.18742L18.0937 7.3437H0.6875L0.6875 10.4687H18.0937L12.9375 15.625L15.1875 17.8125Z" fill="currentColor"/></svg>'
            const rtl = $("html").attr("dir");
            if ($(".sponsor-slider").children().length > 0) {

                $('.sponsor-slider').owlCarousel({
                    nav: true,
                    rtl: rtl === 'rtl',
                    navText: [navLeft, navRight],
                    dots: false,
                    items: 4,
                    lazyLoad: true,
                    autoplay: true,
                    autoplayHoverPause: true,
                    autoplayTimeout: $('#slider_transition_time').val() * 1000,

                    loop: true,
                    margin: 24,
                    responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 2
                        },
                        768: {
                            items: 3
                        },
                        992: {
                            items: 4
                        }
                    }
                });
            }
        })
    })();
</script>
