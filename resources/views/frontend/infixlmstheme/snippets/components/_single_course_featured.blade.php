<div class="row -mt-24">
    <div class="col-12">
        @if(isset($result))
            <div class="featured-slider owl-carousel">
                @foreach($result as $course)
                    <div class="container">
                        <div class="featured-item">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <div
                                        class="featured-img d-flex align-items-end justify-content-center position-relative"
                                        style="--featured-img: url('{{getCourseImage($course->thumbnail)}}')">
                                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}"
                                           class="featured-play">
                                            <span class="fa fa-play"></span>
                                        </a>
                                        <div class="featured-info bg-primary">
                                            <span
                                                class="d-flex align-items-center justify-content-center">{{@$course->courseLevel->title}}</span>
                                            <span class="d-flex align-items-center justify-content-center"><i
                                                    class="fa text-orange fa-star me-2"></i>{{translatedNumber($course->totalReview)}} ({{translatedNumber($course->total_rating)}} {{__('frontend.Rating')}})</span>
                                            @if(!Settings('hide_total_enrollment_count') == 1)
                                            <span class="d-flex align-items-center justify-content-center"><i
                                                    class="fa text-primary fa-user me-2"></i>{{translatedNumber($course->total_enrolled)}} {{__('frontend.Students')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="featured-content">
                                        <h3>
                                            <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}"
                                               class="currentColor">
                                                {{$course->title}}
                                            </a>
                                        </h3>
                                        <a href="#" class="author d-flex flex-wrap">
                                            <div class="author-img rounded-circle overflow-hidden"><img
                                                    src="{{getProfileImage($course->user->image,$course->user->name)}}"
                                                    alt=""></div>
                                            <div class="author-content">
                                                <p class="fw-bold fs-14 lh-base">{{$course->user->name}} <span
                                                        class="d-block fw-500 fs-12">{{$course->user->headline}}</span>
                                                </p>
                                            </div>
                                        </a>
                                        <p>{!! \Illuminate\Support\Str::limit(strip_tags($course->about),100) !!} </p>
                                        <div class="d-flex aling-items-center justify-content-between flex-column-reverse flex-md-row gap-3">

                                            @if(auth()->check() && $course->isLoginUserEnrolled)
                                                <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}"
                                                   class="theme-btn">
                                                    {{__('courses.Get Started')}}
                                                </a>
                                            @else
                                                <a href="{{route('buyNow',[@$course->id])}}"
                                                   class="theme-btn">
                                                    {{__('frontend.Join Now')}}
                                                </a>
                                            @endif

                                            @if(showEcommerce())
                                                <div class="d-flex align-items-center">
                                                    @if(empty($course->price_text))

                                                    <strong>
                                                        @if (@$course->discount_price>0)
                                                            {{getPriceFormat($course->discount_price)}}
                                                        @else
                                                            {{getPriceFormat($course->price)}}
                                                        @endif
                                                    </strong>
                                                    @if (@$course->discount_price>0)
                                                        <del>{{getPriceFormat($course->price)}}</del>
                                                    @endif
                                                    @else
                                                        <strong>
                                                        {{$course->price_text}}
                                                        </strong>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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
            const rtl = $('html').attr('dir');
            if ($(".featured-slider").children().length > 0) {

                $('.featured-slider').owlCarousel({
                    nav: false,
                    rtl: rtl === 'rtl',
                    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                    dots: true,
                    items: 1,
                    lazyLoad: true,
                    autoplay: true,
                    autoplayHoverPause: false,
                    autoplayTimeout: $('#slider_transition_time').val() * 1000,
                    loop: true,
                    margin: 0,

                });
            }
        })
    })();
</script>
