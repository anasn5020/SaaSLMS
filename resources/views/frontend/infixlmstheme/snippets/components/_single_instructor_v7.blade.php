<div class="team-slider owl-carousel">
    @foreach ($result as $instructor)
        <div class="team-section-item">
            <div class="img bg1">
                <img src="{{getProfileImage($instructor->image,$instructor->name)}}" alt="">
                @if(!Settings('hide_social_share_btn') =='1')
                    <ul class="social-links">
                        <li><a href="{{$instructor->facebook}}"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="{{$instructor->twitter}}"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="{{$instructor->linkedin}}"><i class="fab fa-linkedin"></i></a></li>
                        <li><a href="{{@$instructor->instagram}}"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                @endif
            </div>
            <h3 class="member-name">{{$instructor->name}}</h3>
            <div class="designation">{{$instructor->headline}}</div>
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

            if ($(".team-slider").children().length > 0) {

                $('.team-slider').owlCarousel({
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
                        },
                        1400: {
                            items: 4,
                        }
                    }

                });
            }
        })
    })();

</script>
