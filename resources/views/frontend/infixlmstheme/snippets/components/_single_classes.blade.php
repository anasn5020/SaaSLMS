@if(isset($result))
    <div class="classes-slider owl-carousel">
        @foreach ($result as $classes)
            <div class="classes-item">
                <a href="{{courseDetailsUrl(@$classes->id,@$classes->type,@$classes->slug)}}"
                   class="classes-item-img d-block lazy">
                    <img src="{{ getCourseImage($classes->thumbnail) }}" alt="{{$classes->title}}">
                    <div class="classes-item-info">
                        <ul class="d-flex flex-column align-items-end">
                            <li class="theme-btn bg-red justify-content-center fw-500 text-white mb-2">{{__('common.Live')}}</li>
                            <li class="theme-btn bg-primary justify-content-center fw-500 text-white mb-2">{{$classes->class->category->name}}
                            </li>
                            <li class="theme-btn bg-green justify-content-center fw-500 text-white mb-2 nowrap text-white">
                                <div class="fa fa-history m-0"></div>

                                @php


                                    $str = ($classes->class->duration?? 0)*$classes->class->total_class;
                                    $duration =preg_replace('/[^0-9]/', '', $str);

                                @endphp
                                {{!empty(MinuteFormat($duration))?MinuteFormat($duration):0}}
                            </li>
                            @if(!Settings('hide_total_enrollment_count') == 1)
                                <li class="theme-btn bg-orange justify-content-center fw-500 text-white nowrap text-white">
                                    <div
                                        class="fa fa-user-friends m-0"></div>
                                    {{ translatedNumber((string)$classes->total_enrolled!=0?$classes->total_enrolled:0)}}
                                </li>
                            @endif
                        </ul>
                    </div>
                </a>
                <div class="classes-item-content d-flex flex-wrap align-items-center mx-auto align-items-center">
                    <div class="content">
                        <div class="classes-item-date">
                            <span
                                class="">{{ showDate($classes->class->start_date)}} - {{showDate($classes->class->end_date)}}</span>
                            <span class=""> {{date('h:i A', strtotime($classes->class->time))}} ({{Settings('active_time_zone')}})</span>
                        </div>
                        <h4 class="fw-500">
                            <a href="{{courseDetailsUrl(@$classes->id,@$classes->type,@$classes->slug)}}"
                               title="{{$classes->title}}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                               class="currentColor">
                                {{$classes->title}}
                            </a>
                        </h4>
                        {{--<a href="#" class="classes-item-user d-flex align-items-center gap-2">
                            <div id="img">
                                <img src="{{getProfileImage($classes->user->image,$classes->user->name)}}" alt="">
                            </div>
                            <div id="content">
                                <p>{{$classes->user->name}}</p>
                            </div>
                        </a>--}}
                    </div>
                    <div class="price text-center">
                        @if(showEcommerce())
                            @if(empty($classes->price_text))
                                @if ((int)$classes->discount_price!=null)
                                    <del class="fw-500 me-1">  {{getPriceFormat($classes->price)}}</del>
                                @endif
                                <strong class="fw-bold text-primary">
                                    @if ((int)$classes->discount_price!=null)
                                        {{getPriceFormat($classes->discount_price)}}
                                    @else
                                        {{getPriceFormat($classes->price)}}
                                    @endif
                                </strong>
                            @else
                                <strong class="fw-bold text-primary">
                                {{$classes->price_text}}
                                </strong>
                            @endif
                        @endif
                        <br>
                        @if(auth()->check() && $classes->isLoginUserEnrolled)
                            <a href="{{courseDetailsUrl(@$classes->id,@$classes->type,@$classes->slug)}}"
                               class="theme-btn">
                                {{__('courses.Get Started')}}
                            </a>
                        @else
                            <a href="{{route('buyNow',[@$classes->id])}}"
                               class="theme-btn">
                                {{__('frontend.Book Now')}}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<script>
    (function () {
        'use strict'
        jQuery(document).ready(function () {
            const navLeft = '<svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M8.3125 0.625244L0.499998 8.43778V10.6253L8.3125 18.4378L10.5313 16.2503L5.40625 11.094H22.8125V7.96903H5.40625L10.5625 2.81275L8.3125 0.625244Z" fill="currentColor"/></svg>';
            const navRight = '<svg width="23" height="18" viewBox="0 0 23 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.1875 17.8125L23 9.99996V7.81245L15.1875 -8.7738e-05L12.9687 2.18742L18.0937 7.3437H0.6875L0.6875 10.4687H18.0937L12.9375 15.625L15.1875 17.8125Z" fill="currentColor"/></svg>'
            const rtl = $("html").attr("dir");
            // classes slider
            if ($(".classes-slider").children().length > 0) {

                $('.classes-slider').owlCarousel({
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
                            items: 1,
                            nav: false,
                        },
                        768: {
                            items: 2,
                            nav: true,
                        },
                        992: {
                            items: 2,
                            nav: true,
                        }

                    }
                });
            }
        })
    })();
</script>
