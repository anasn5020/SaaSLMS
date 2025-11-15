<div class="testimonial-slider owl-carousel">
    @foreach ($result as $testimonial)

        <div class="testimonial-single-container">
            <div class="testimonial-single">
                <div class="testimonial-top d-inline-block">
                    <div class="rating">
                        @for($i=1;$i<=$testimonial->star;$i++)
                            <i class="fas fa-star"></i>
                        @endfor
                    </div>
                </div>
                <div class="testimonial-content mb-4">
                    <p>"{{@$testimonial->body}}"</p>
                </div>
                <div class="align-items-end d-flex flex-grow-1">
                    <div class="testimonial-user">
                        <div class="testimonial-user-img">
                            <img src="{{getProfileImage($testimonial->image,$testimonial->author)}}" alt="">
                        </div>
                        <div class="info">
                            <p><strong>{{@$testimonial->author}}</strong></p>
                            <span>{{$testimonial->profession}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
</div>

<script>
    (function () {
        'use strict'
        jQuery(document).ready(function () {

            let isRtl;
            if ($('html').attr('dir') === "rtl") {
                isRtl = true;
            } else {
                isRtl = false;
            }

            const navLeft = '<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M8.3125 0.625244L0.499998 8.43778V10.6253L8.3125 18.4378L10.5313 16.2503L5.40625 11.094H22.8125V7.96903H5.40625L10.5625 2.81275L8.3125 0.625244Z" fill="currentColor"/></svg>';
            const navRight = '<svg width="23" height="18" viewBox="0 0 23 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.1875 17.8125L23 9.99996V7.81245L15.1875 -8.7738e-05L12.9687 2.18742L18.0937 7.3437H0.6875L0.6875 10.4687H18.0937L12.9375 15.625L15.1875 17.8125Z" fill="currentColor"/></svg>'
            if ($(".testimonial-slider").children().length > 0) {

                $('.testimonial-slider').owlCarousel({
                    nav: true,
                    navText: [navLeft, navRight],
                    dots: true,
                    items: 4,
                    lazyLoad: true,
                    autoplay: true,
                    autoplayHoverPause: true,
                    autoplayTimeout: $('#slider_transition_time').val() * 1000,
                    loop: true,
                    margin: 24,
                    stagePadding: 0,
                    center: true,
                    rtl: isRtl,
                    responsive: {
                        0: {
                            items: 1,
                            nav: false,
                        },
                        480: {
                            items: 1,
                            nav: false,
                        },
                        768: {
                            items: 2,
                            nav: true,
                        },
                        1200: {
                            items: 3
                        }
                    }

                });
            }
        })
    })();
</script>
