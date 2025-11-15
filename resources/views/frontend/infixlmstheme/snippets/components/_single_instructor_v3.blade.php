@if(isset($result))
    <div class="col-12">
        <div class="instrucotr-slider owl-carousel">
            @foreach ($result as $instructor)
                <div class="instrucotr-item">
                    <div class="instrucotr-item-head position-relative">
                        <a href="{{route('instructorDetails',[$instructor->id,Str::slug($instructor->name,'-')])}}"
                           class="instrucotr-item-img mx-auto">
                            <img src="{{getProfileImage($instructor->image,$instructor->name)}}" alt="">
                        </a>
                    </div>
                    <div class="instrucotr-item-content mx-auto text-center">
                        <h4>
                            <a href="{{route('instructorDetails',[$instructor->id,Str::slug($instructor->name,'-')])}}"
                               class="currentColor">{{$instructor->name}}</a>
                        </h4>
                        <p>{{$instructor->headline}}</p>
                        <div class="instrucotr-item-actions">

                            <ul class="social-list v2 gap-2">
                                <li><a href="{{$instructor->facebook}}"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="{{$instructor->twitter}}"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="{{$instructor->linkedin}}"><i class="fab fa-linkedin"></i></a></li>
                                <li><a href="{{@$instructor->instagram}}"><i class="fab fa-instagram"></i></a></li>
{{--                                <li><a href="{{$instructor->youtube}}"><i class="fab fa-youtube"></i></a></li>--}}
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<script>
    (function () {
        'use strict'
        jQuery(document).ready(function () {
            const navLeft = '<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M8.3125 0.625244L0.499998 8.43778V10.6253L8.3125 18.4378L10.5313 16.2503L5.40625 11.094H22.8125V7.96903H5.40625L10.5625 2.81275L8.3125 0.625244Z" fill="currentColor"/></svg>';
            const navRight = '<svg width="23" height="18" viewBox="0 0 23 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.1875 17.8125L23 9.99996V7.81245L15.1875 -8.7738e-05L12.9687 2.18742L18.0937 7.3437H0.6875L0.6875 10.4687H18.0937L12.9375 15.625L15.1875 17.8125Z" fill="currentColor"/></svg>'
            const rtl = $('html').attr('dir');
            // instrucotr slider
            if ($(".instrucotr-slider").children().length > 0) {

                $('.instrucotr-slider').owlCarousel({
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
                    stagePadding: 0,
                    responsive: {
                        0: {items: 1},
                        768: {items: 2},
                        992: {items: 3, stagePadding: 24,},
                        1200: {
                            stagePadding: 0
                        }
                    }
                });
            }
        })
    })();
</script>
