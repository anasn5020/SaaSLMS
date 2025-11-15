<div class="owl-carousel popular-course-carousel">
    @if(isset($result))
        @foreach($result as $course)
            <div class="course-item">
                <div class="course-item-img">
                    <img src="{{ getCourseImage($course->thumbnail) }}" alt="course image">
                    @if($course->level)
                        <span class="course-tag">
                                <span>
                                    {{$course->courseLevel->title}}
                                </span>
                            </span>
                    @endif
                </div>

                <div class="course-item-info">
                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}" class="title"
                       title="{{$course->title}}">
                        {{$course->title}}
                    </a>
                    <div class="d-flex align-itemes-center justify-content-between meta">
                        <div class="rating">
                            <svg width="16" height="15" viewBox="0 0 16 15" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.9922 5.21624L10.2573 4.53056L8.1344 0.242104C8.09105 0.168678 8.02784 0.10754 7.9513 0.0649862C7.87476 0.0224321 7.78764 0 7.69892 0C7.6102 0 7.52308 0.0224321 7.44654 0.0649862C7.37 0.10754 7.3068 0.168678 7.26345 0.242104L5.14222 4.52977L0.40648 5.21624C0.31946 5.22916 0.237852 5.2645 0.170564 5.31841C0.103275 5.37231 0.0528901 5.44272 0.0249085 5.52194C-0.00307309 5.60116 -0.00757644 5.68614 0.01189 5.76762C0.0313563 5.8491 0.0740445 5.92394 0.135295 5.98398L3.57501 9.33111L2.76146 14.0591C2.74696 14.1436 2.75782 14.2304 2.79281 14.3094C2.8278 14.3883 2.88549 14.4564 2.95932 14.5058C3.03314 14.5551 3.12011 14.5838 3.2103 14.5886C3.30049 14.5933 3.39026 14.5739 3.46936 14.5325L7.6985 12.3153L11.9276 14.5333C12.0068 14.5746 12.0965 14.5941 12.1867 14.5893C12.2769 14.5846 12.3639 14.5559 12.4377 14.5066C12.5115 14.4572 12.5692 14.3891 12.6042 14.3101C12.6392 14.2311 12.6501 14.1444 12.6356 14.0599L11.822 9.3319L15.2634 5.98398C15.3253 5.92392 15.3685 5.84885 15.3883 5.76699C15.4082 5.68515 15.4039 5.59969 15.3758 5.52003C15.3478 5.44036 15.2972 5.36956 15.2295 5.31541C15.1618 5.26126 15.0797 5.22586 14.9922 5.21308V5.21624Z"
                                    fill="#FFC107"/>
                            </svg>
                            <span>{{translatedNumber($course->totalReview)}} ({{translatedNumber($course->total_reviews)}} {{__('common.Rating')}})</span>
                        </div>
                        <div class="enrolled-student">
                            @if(!Settings('hide_total_enrollment_count') == 1)
                                <a href="#">
                                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14.2508 3.87484L9.30078 1.0165C8.49245 0.549837 7.49245 0.549837 6.67578 1.0165L1.73411 3.87484C0.925781 4.3415 0.425781 5.20817 0.425781 6.14984V11.8498C0.425781 12.7832 0.925781 13.6498 1.73411 14.1248L6.68411 16.9832C7.49245 17.4498 8.49245 17.4498 9.30911 16.9832L14.2591 14.1248C15.0674 13.6582 15.5674 12.7915 15.5674 11.8498V6.14984C15.5591 5.20817 15.0591 4.34984 14.2508 3.87484ZM7.99245 5.1165C9.06745 5.1165 9.93411 5.98317 9.93411 7.05817C9.93411 8.13317 9.06745 8.99984 7.99245 8.99984C6.91745 8.99984 6.05078 8.13317 6.05078 7.05817C6.05078 5.9915 6.91745 5.1165 7.99245 5.1165ZM10.2258 12.8832H5.75911C5.08411 12.8832 4.69245 12.1332 5.06745 11.5748C5.63411 10.7332 6.73411 10.1665 7.99245 10.1665C9.25078 10.1665 10.3508 10.7332 10.9174 11.5748C11.2924 12.1248 10.8924 12.8832 10.2258 12.8832Z"
                                            fill="#292D32"/>
                                    </svg>
                                    {{translatedNumber($course->total_enrolled)}} {{__('frontend.Students')}}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="course-item-info-description">
                        {{ getLimitedText($course->about,120) }}
                    </div>

                    <div class="course-item-footer d-flex justify-content-between">
                        <x-price-tag :price="$course->price"
                                     :text="$course->price_text"
                                     :discount="$course->discount_price"/>

                        @if(!onlySubscription())
                            @auth()
                                @if(!$course->isLoginUserEnrolled && !$course->isLoginUserCart)
                                    <a href="#" class="cart_store"
                                       data-id="{{$course->id}}">
                                        <img src="{{asset('public/frontend/infixlmstheme/svg/cart.svg')}}" alt="cart">
                                    </a>
                                @endif
                            @endauth
                            @guest()
                                @if(!$course->isGuestUserCart)
                                    <a href="#" class="cart_store"
                                       data-id="{{$course->id}}">
                                        <img src="{{asset('public/frontend/infixlmstheme/svg/cart.svg')}}" alt="cart">
                                    </a>
                                @endif
                            @endguest
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif

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

            if ($(".popular-course-carousel").children().length > 0) {

                $('.popular-course-carousel').owlCarousel({
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
                            items: 4
                        }
                    }

                });
            }
        })
    })();
</script>
