<div>


    @if($homeContent->show_banner_section==1)
        <form action="{{route('search')}}">
            <div class="banner_area"
                 @if(isset($homeContent->slider_banner) && !empty($homeContent->slider_banner))
                     style="background-image: url('{{asset(@$homeContent->slider_banner)}}')"
                @endif>
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-9 offset-lg-1">
                            <div class="banner_text">
                                <h3>{{@$homeContent->slider_title}}</h3>
                                <p>{{@$homeContent->slider_text}}</p>
                                @if(@$homeContent->show_banner_search_box==1)
                                    <div class="input-group theme_search_field large_search_field">
                                        <div class="input-group-prepend">
                                            <button class="btn" type="button" id="button-addon2"><i
                                                    class="ti-search"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="query" class="form-control"
                                               placeholder="{{__('frontend.Search for course, skills and Videos')}}">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else

        <div class="owl-carousel" id="bannerSlider">
            @if($sliders)
                @foreach($sliders as $key=>$slider)
                    <div class="banner_area" style="background-image: url({{asset(@$slider->image)}})">
                        <div class="container">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg-9 offset-lg-1">
                                    <div class="banner_text">
                                        <h3>{{@$slider->title}}</h3>
                                        <p>{{@$slider->sub_title}}</p>

                                        <div class="row d-flex align-items-center">
                                            @if($slider->btn_type1==1)
                                                @if(!empty($slider->btn_title1))
                                                    <div class="single_slider">
                                                        <a href="{{$slider->btn_link1}}"
                                                           class="slider_btn_text text-center">{{$slider->btn_title1}}</a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="single_slider">
                                                    <a href="{{$slider->btn_link1}}">
                                                        <img
                                                            src="{{asset($slider->btn_image1)}}"
                                                            alt="">

                                                    </a>
                                                </div>
                                            @endif
                                            @if($slider->btn_type2==1)
                                                @if(!empty($slider->btn_title2))
                                                    <div class="single_slider">
                                                        <a href="{{$slider->btn_link2}}"
                                                           class="slider_btn_text text-center">{{$slider->btn_title2}}</a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="single_slider">
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
    @endif

</div>
