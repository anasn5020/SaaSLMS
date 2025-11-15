<div class="category-slider owl-carousel">
    @if(isset($result ))
        @foreach($result  as $category)
            <a href="{{route('courses')}}?category_id[]={{$category->id}}"

     class="category-slider-item">
                <div class="category-slider-item-inner">
                    <div class="category-slider-item-icon">
                        <img src="{{asset($category->image)}}" alt="">
                    </div>
                    <div class="category-slider-item-title">
                        {{$category->name}}
                    </div>
                </div>
            </a>
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
            if ($(".category-slider").children().length > 0) {

                $('.category-slider').owlCarousel({
                    loop: true,
                    margin: 0,
                    responsiveClass: true,
                    nav: false,
                    dots: false,
                    // center: true,
                    autoplay: true,
                    autoplayHoverPause: true,
                    autoplayTimeout: $('#slider_transition_time').val() * 1000,
                    rtl: isRtl,
                    responsive: {
                        300: {
                            items: 2,
                            nav: false,
                        },
                        400: {
                            items: 3,
                            nav: false,
                        },
                        500: {
                            items: 4,
                            nav: false,
                        },
                        768: {
                            items: 4,
                            nav: false,
                        },
                        1000: {
                            items: 5,
                            nav: false,
                        },
                        1400: {
                            items: 8,
                            nav: false,
                        }

                    }

                });
            }
        })
    })();
</script>
