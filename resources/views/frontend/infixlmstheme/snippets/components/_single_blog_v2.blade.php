@php use Illuminate\Support\Str; @endphp
@if(isset($result))
    <div class="blog-slider owl-carousel">
        @foreach($result as $blog)
            <div class="blog-single bg-white">
                <div class="blog-single-img">
                    <a href="{{route('blogDetails',[$blog->slug])}}" class="d-block w-100 h-100">
                        <img src="{{getBlogImage($blog->thumbnail)}}" alt="">
                    </a>
                    @if($blog->category && $blog->category->title)
                        <span class="blog-single-meta fw-bold">{{ $blog->category->title }}</span>
                    @endif

                </div>
                <div class="blog-single-rating">
                    <div class="mb-4 p-2 d-flex align-items-center justify-content-between flex-wrap bg-white">

                        <a href="#" class="d-flex align-items-center">
                            <div class="user">
                                <img src="{{getProfileImage($blog->user->image, $blog->user->name)}}" alt="">
                            </div>
                            <span class="user-content fw-500 ps-2">{{$blog->user->name}} </span>
                        </a>
                        <div class="date text-end">
                            <span
                                class="text-primary fw-500">{{ showDate(@$blog->authored_date ) }} {{ translatedNumber($blog->authored_time) }}</span>
                        </div>
                    </div>
                </div>
                <div class="blog-single-content pt-0">
                    <h4 class="fw-500">
                        <a href="{{route('blogDetails',[$blog->slug])}}" class="currentColor" data-bs-toggle="tooltip"
                           data-bs-placement="bottom" title="{{$blog->title}}">
                            {{$blog->title}}
                        </a>
                    </h4>
                    <p>{!! Str::limit(strip_tags($blog->description),200) !!}</p>
                    <a href="{{route('blogDetails',[$blog->slug])}}"
                       class="theme-btn fw-500">{{__('common.Read More')}}</a>
                </div>
            </div>
        @endforeach
    </div>
@endif


<script>
    $(function () {
        if ($.isFunction($.fn.lazy)) {
            $('.lazy').lazy();
        }
    });
    (function () {
        'use strict'
        jQuery(document).ready(function () {
            const navLeft = '<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M8.3125 0.625244L0.499998 8.43778V10.6253L8.3125 18.4378L10.5313 16.2503L5.40625 11.094H22.8125V7.96903H5.40625L10.5625 2.81275L8.3125 0.625244Z" fill="currentColor"/></svg>';
            const navRight = '<svg width="23" height="18" viewBox="0 0 23 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.1875 17.8125L23 9.99996V7.81245L15.1875 -8.7738e-05L12.9687 2.18742L18.0937 7.3437H0.6875L0.6875 10.4687H18.0937L12.9375 15.625L15.1875 17.8125Z" fill="currentColor"/></svg>';
            const rtl = $('html').attr('dir');
            // blog slider
            if ($(".blog-slider").children().length > 0) {

                $('.blog-slider').owlCarousel({
                    nav: true,
                    rtl: rtl === 'rtl',
                    navText: [navLeft, navRight],
                    dots: false,
                    items: 3,
                    lazyLoad: true,
                    autoplay: true,
                    autoplayHoverPause: true,
                    autoplayTimeout: $('#slider_transition_time').val() * 1000,
                    loop: true,
                    margin: 24,
                    responsive: {
                        0: {items: 1},
                        480: {items: 1.3},
                        768: {items: 2},
                        992: {items: 3},
                        1200: {items: 3},
                    }
                });
            }
        })
    })();
</script>
