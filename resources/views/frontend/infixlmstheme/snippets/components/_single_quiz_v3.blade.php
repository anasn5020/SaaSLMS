<div class="row">
    <div class="col-12">
        <div class="quiz-slider owl-carousel">
            @if(isset($result))
                @foreach($result as $quiz)
                    <div class="quiz-item mt-0 w-100">
                        <a href="{{courseDetailsUrl(@$quiz->id,@$quiz->type,@$quiz->slug)}}">
                            <div class="quiz-item-img lazy">
                                <img src="{{ getCourseImage($quiz->thumbnail) }}" alt="{{$quiz->title}}">
                            </div>
                        </a>
                        <div class="quiz-item-content">
                            <div class="meta d-flex align-items-center flex-wrap gap-2">
                            <span
                                class="bg-primary fs-14 lh-1 text-white rounded-2 fw-bold">{{$quiz->quiz->category->name}} </span>
                                <span
                                    class="bg-primary fs-14 lh-1 text-white rounded-2 fw-bold">{{__('quiz.Quiz')}}</span>
                            </div>
                            <a href="#" class="author d-flex flex-wrap">
                                <div class="author-img rounded-circle overflow-hidden"><img
                                        src="{{getProfileImage($quiz->user->image,$quiz->user->name)}}" alt=""></div>
                                <div class="author-content">
                                    <p class="fw-bold fs-14 lh-base text-secondary">{{$quiz->user->name}} <span
                                            class="d-block fw-500 fs-12">{{$quiz->user->headline}}</span></p>
                                </div>
                            </a>

                            <a class="quiz-item-title" data-bs-toggle="tooltip" data-bs-placement="bottom"
                               title="{{$quiz->title}}"
                               href="{{courseDetailsUrl(@$quiz->id,@$quiz->type,@$quiz->slug)}}">
                                {{$quiz->title}}
                            </a>
                            <div class="quiz-item-content-rating d-flex align-items-center justify-content-between">

                                <div>
                                    @if (courseSetting()->show_rating==1)
                                        <i class="fa fa-star text-orange"></i>
                                        <span
                                            class="fw-bold">{{translatedNumber($quiz->total_rating)}} ({{translatedNumber(count($quiz->reviews))}} {{__('quiz.Rating')}})</span>
                                    @endif
                                </div>
                                @if(!Settings('hide_total_enrollment_count') == 1)
                                    <div>
                                        <i class="fa fa-user"></i>
                                        <span
                                            class="fw-bold">{{translatedNumber($quiz->total_enrolled)}} {{__('frontend.Students')}}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div
                            class="quiz-item-footer bg-primary d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center">
                                <strong>
                                    @if (@$quiz->discount_price!=null)
                                        {{getPriceFormat($quiz->discount_price)}}
                                    @else
                                        {{getPriceFormat($quiz->price)}}
                                    @endif
                                </strong>
                                @if (@$quiz->discount_price!=null)
                                    <del class="ms-2 fw-normal">{{getPriceFormat($quiz->price)}}</del>
                                @endif
                            </div>
                            <div>
                                @auth()
                                    @if(!$quiz->isLoginUserEnrolled && !$quiz->isLoginUserCart)
                                        <button data-id="{{$quiz->id}}"
                                                class="cart_store bg-transparent border-0 text-white"><i
                                                class="fa fa-shopping-cart"></i></button>
                                    @endif
                                @endauth
                                @guest()
                                    @if(!$quiz->isGuestUserCart)
                                        <button data-id="{{$quiz->id}}"
                                                class="cart_store bg-transparent border-0 text-white"><i
                                                class="fa fa-shopping-cart"></i></button>
                                    @endif
                                @endguest
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        if ($.isFunction($.fn.lazy)) {
            $('.lazy').lazy();
        }

        (function () {
            'use strict'
            jQuery(document).ready(function () {
                const navLeft =
                    '<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M8.3125 0.625244L0.499998 8.43778V10.6253L8.3125 18.4378L10.5313 16.2503L5.40625 11.094H22.8125V7.96903H5.40625L10.5625 2.81275L8.3125 0.625244Z" fill="currentColor"/></svg>';
                const navRight =
                    '<svg width="23" height="18" viewBox="0 0 23 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.1875 17.8125L23 9.99996V7.81245L15.1875 -8.7738e-05L12.9687 2.18742L18.0937 7.3437H0.6875L0.6875 10.4687H18.0937L12.9375 15.625L15.1875 17.8125Z" fill="currentColor"/></svg>'
                const rtl = $('html').attr('dir');
                if ($(".quiz-slider").children().length > 0) {

                    $('.quiz-slider').owlCarousel({
                        nav: true,
                        rtl: rtl === 'rtl',
                        navText: [navLeft, navRight],
                        dots: false,
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
                                items: 1
                            },
                            768: {
                                items: 2
                            },
                            922: {
                                items: 3
                            },
                            1200: {
                                items: 3
                            }
                        }
                    });
                }
            });
        })();
    </script>
</div>
