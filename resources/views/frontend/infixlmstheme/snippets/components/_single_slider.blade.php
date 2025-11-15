<div>
    <div class="owl-carousel" id="bannerSlider">
        @if($result)
            @foreach($result as $key=>$slider)
                <div class="banner_area" style="background-image: url({{asset(@$slider->image)}})">
                    <div class="container">
                        <div class=" d-flex align-items-center">
                            <div class="col-lg-9 offset-lg-1">
                                <div class="banner_text">
                                    <h3>{{@$slider->title}}</h3>
                                    <p>{{@$slider->sub_title}}</p>

                                    <div class=" d-flex align-items-center">
                                        @if($slider->btn_type1==1)
                                            @if(!empty($slider->btn_title1))
                                                <div class="single_slider d-inline-block">
                                                    <a href="{{$slider->btn_link1}}"
                                                       class="slider_btn_text text-center">{{$slider->btn_title1}}</a>
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
                                                       class="slider_btn_text text-center">{{$slider->btn_title2}}</a>
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
                </div>
            @endforeach
        @endif
    </div>

    <script>

    </script>
</div>
