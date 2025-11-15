<div class="banner-slider owl-carousel">
    @if(isset($result))
        @foreach($result as $key=>$slider)
            <div class="banner-area">
                <div class="banner-img">
                    <img src="{{asset(@$slider->image)}}" alt="">
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-7 col-lg-8 col-md-9">
                            <div class="banner-text pb-5">
                                <h1 class="text-white">{{ @$slider->title }}</h1>
                                <p class="pe-0 pe-xl-5 text-white">{{ @$slider->sub_title }}</p>

                                @if($slider->btn_type1==1)
                                    @if(!empty($slider->btn_title1))
                                        <div class="single_slider d-inline-block">
                                            <a href="{{$slider->btn_link1}}"
                                               class="theme-btn text-capitalize">{{$slider->btn_title1}}</a>
                                        </div>
                                    @endif
                                @else
                                    <div class="single_slider d-inline-block">
                                        <a href="{{$slider->btn_link1}}">
                                            <img
                                                src="{{asset($slider->btn_image1)}}"
                                                alt="">

                                        </a>
                                    </div>
                                @endif
                                @if($slider->btn_type2==1)
                                    @if(!empty($slider->btn_title2))
                                        <div class="single_slider d-inline-block">
                                            <a href="{{$slider->btn_link2}}"
                                               class="theme-btn text-capitalize bg-transparent">{{$slider->btn_title2}}</a>
                                        </div>
                                    @endif
                                @else
                                    <div class="single_slider d-inline-block">
                                        <a href="{{$slider->btn_link2}}">
                                            <img
                                                src="{{asset($slider->btn_image2)}}"
                                                alt="">

                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<script>
    (function () {
        $(document).ready(function () {
            const rtl = $('html').attr('dir');
            if ($(".banner-slider").children().length > 0) {
                $('.banner-slider').owlCarousel({
                    nav: true,
                    rtl: rtl === 'rtl',
                    navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
                    dots: true,
                    items: 1,
                    lazyLoad: true,
                    autoplay: true,
                    autoplayHoverPause: true,
                    autoplayTimeout: $('#slider_transition_time').val() * 1000,
                    loop: true,
                    margin: 0,
                });
            }
        })
    })();
</script>
