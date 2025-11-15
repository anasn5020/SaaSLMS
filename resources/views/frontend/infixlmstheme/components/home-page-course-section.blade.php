<div>
    <div class="course_area section_spacing">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_80">
                        <h3>
                            {{@$homeContent->course_title}}


                        </h3>
                        <p>
                            {{@$homeContent->course_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(isset($top_courses))
                    @foreach($top_courses as $course)
                        <div class="col-lg-4 col-xl-3 col-md-6">
                            <div class="couse_wizged">
                                <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                    <div class="thumb">

                                        <div class="thumb_inner lazy"
                                             data-src="{{ getCourseImage($course->thumbnail) }}">
                                        </div>
                                        <x-price-tag :price="$course->price"
                                                     :text="$course->price_text"
                                                     :discount="$course->discount_price"/>
                                    </div>
                                </a>
                                <div class="course_content">
                                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                                        <h4 class="noBrake" title=" {{$course->title}}">
                                            {{$course->title}}
                                        </h4>
                                    </a>

                                    <div class="rating_cart">
                                        <div class="rateing">
                                            <span>{{$course->total_rating}}/5</span>
                                            <i class="fas fa-star"></i>
                                        </div>
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

                                    </div>
                                    <div class="course_less_students">
                                        <a> <i class="ti-agenda"></i> {{$course->total_lessons}}
                                            {{__('frontend.Lessons')}}</a>
                                        @if(!Settings('hide_total_enrollment_count') == 1)
                                            <a>
                                                <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-12 text-center pt_70">
                    <a href="{{route('courses')}}"
                       class="theme_btn mb_30">{{__('frontend.View All Courses')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
