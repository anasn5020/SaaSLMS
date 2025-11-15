<div class="row">

    @if(isset($result))
        @foreach($result as $course)
            <div class="col-lg-4 col-xl-3 col-md-6">
                <div class="couse_wizged">
                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                        <div class="thumb">

                            <div class="thumb_inner lazy"
                                 data-src="{{ getCourseImage($course->thumbnail) }}">
                            </div>
                            @if(showEcommerce()  && empty($course->price_text))
                                <span class="prise_tag">
                               @if (@$course->discount_price>0)
                                        <span class="prev_prise">
                                  {{getPriceFormat($course->price)}}
                                  </span>
                                    @endif
                                <span>
                                @if (@$course->discount_price>0)
                                        {{getPriceFormat($course->discount_price)}}
                                    @else
                                        {{getPriceFormat($course->price)}}
                                    @endif
                                </span>
                                </span>
                            @else
                                <span>
                                {{$course->price_text}}
                                </span>

                            @endif
                        </div>
                    </a>
                    <div class="course_content">
                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                            <h4 class="noBrake" title=" {{$course->title}}">
                                {{$course->title}}
                            </h4>
                        </a>

                        <div class="rating_cart">
                            @if (courseSetting()->show_rating==1)
                                <div class="rateing">
                                    <span>{{translatedNumber($course->totalReview)}}/{{translatedNumber(5)}}</span>
                                    <i class="fas fa-star"></i>
                                </div>
                            @endif
                            @if (courseSetting()->show_cart==1)
                                @auth()
                                    @if(!$course->isLoginUserEnrolled && !$course->isLoginUserCart)
                                        <a href="#" class="cart_store"
                                           data-id="{{$course->id}}">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    @endif
                                @endauth
                                @guest()
                                    @if(!$course->isGuestUserCart)
                                        <a href="#" class="cart_store"
                                           data-id="{{$course->id}}">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    @endif
                                @endguest
                            @endif

                        </div>
                        <div class="course_less_students">
                            <a> <i class="ti-agenda"></i> {{$course->total_lessons}}
                                {{__('frontend.Lessons')}}</a>
                            @if (courseSetting()->show_enrolled_or_level_section==1)
                                @if (courseSetting()->enrolled_or_level==1)
                                    @if(!Settings('hide_total_enrollment_count') == 1)
                                        <a>
                                            <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                        </a>
                                    @endif
                                @elseif(courseSetting()->enrolled_or_level==3)
                                    <a>
                                        <i class="ti-thumb-up"></i>
                                        @if ($course->mode_of_delivery==1)
                                            {{__('courses.Online')}}
                                        @elseif($course->mode_of_delivery==2)
                                            {{__('courses.Distance Learning')}}
                                        @else
                                            {{__('courses.Face-to-Face')}}
                                        @endif
                                    </a>
                                @else
                                    @if($course->type!=3)
                                        <a>
                                            <i class="ti-thumb-up"></i> {{@$course->courseLevel->title}}
                                        </a>
                                    @endif
                                @endif

                            @endif
                        </div>
                    </div>
                </div>


            </div>
        @endforeach
    @endif

    <script>
        if ($.isFunction($.fn.lazy)) {
            $('.lazy').lazy();
        }
    </script>
</div>
