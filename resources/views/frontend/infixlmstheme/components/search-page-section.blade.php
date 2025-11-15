<div>
    <div class="courses_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xl-3">
                    <x-class-page-section-sidebar :level="$level" :type="$type" :categories="$categories"
                                                  :category="$category" :languages="$languages" :language="$language"
                                                  :mode="$mode"/>
                </div>
                <div class="col-lg-8 col-xl-9">

                    <div class="row">
                        <div class="col-12">
                            <div class="box_header d-flex flex-wrap align-items-center justify-content-between">

                                <h5 class="font_16 f_w_500 ">
                                    @if(isset($search) && !empty($search))

                                        {{__('courses.Search result for')}} "{{$search}}
                                        "<br style="line-break: auto">
                                        @if($courses->count()==0)

                                        @else
                                            <span
                                                class="subtitle">{{$total}} {{__('coupons.Topics are available')}}</span>
                                        @endif
                                    @endif
                                </h5>

                                <div class="box_header_right mb_30">
                                    <div class="short_select d-flex align-items-center">
                                        <h5 class="mr_10 font_16 f_w_500 mb-0">{{__('frontend.Order By')}}:</h5>
                                        <select class="small_select" id="order">
                                            <option value="" data-display="None">{{__('frontend.None')}}</option>
                                            <option
                                                value="price" {{$order=="price"?'selected':''}}>{{__('frontend.Price')}}</option>
                                            <option
                                                value="date" {{$order=="date"?'selected':''}}>{{__('frontend.Date')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(isset($courses))
                            @foreach ($courses as $course)
                                <div class="col-sm-6 col-xl-4">

                                    @if($course->type==1)
                                        <div class="couse_wizged">
                                            <div class="thumb">
                                                <div class="thumb_inner lazy"
                                                     data-src="{{ getCourseImage($course->thumbnail) }}">

                                                    <x-price-tag :price="$course->price"
                                                                 :text="$course->price_text"
                                                                 :discount="$course->discount_price"/>

                                                </div>

                                            </div>
                                            <div class="course_content">
                                                <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                    <h4 class="noBrake" title="{{$course->title}}">
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
                                                </div>
                                                <div class="course_less_students">
                                                    <a>
                                                        <i class="ti-agenda"></i> {{$course->total_lessons}} {{__('student.Lessons')}}
                                                    </a>
                                                    @if(!Settings('hide_total_enrollment_count') == 1)
                                                        <a>
                                                            <i class="ti-user"></i> {{$course->total_enrolled}} {{__('student.Students')}}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($course->type==2)
                                        <div class="quiz_wizged">
                                            <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                <div class="thumb">
                                                    <div class="thumb_inner lazy"
                                                         data-src="{{ getCourseImage($course->thumbnail) }}">

                                                        <x-price-tag :price="$course->price"
                                                                     :text="$course->price_text"
                                                                     :discount="$course->discount_price"/>


                                                    </div>
                                                    <span class="quiz_tag">{{__('quiz.Quiz')}}</span>
                                                </div>
                                            </a>
                                            <div class="course_content">
                                                <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                    <h4 class="noBrake"
                                                        title="{{$course->title}}"> {{$course->title}}</h4>
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
                                                </div>
                                                <div class="course_less_students">

                                                    <a>
                                                        <i class="ti-agenda"></i> {{$course->quiz->total_questions}}
                                                        {{__('student.Question')}}</a>
                                                    @if(!Settings('hide_total_enrollment_count') == 1)
                                                        <a>
                                                            <i class="ti-user"></i> {{$course->total_enrolled}} {{__('student.Students')}}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    @elseif($course->type==3)
                                        <div class="quiz_wizged">
                                            <div class="thumb">
                                                <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                    <div class="thumb">
                                                        <div class="thumb_inner lazy"
                                                             data-src="{{ getCourseImage($course->thumbnail) }}">

                                                            <x-price-tag :price="$course->price"
                                                                         :text="$course->price_text"
                                                                         :discount="$course->discount_price"/>


                                                        </div>
                                                        <span class="live_tag">{{__('student.Live')}}</span>
                                                    </div>
                                                </a>


                                            </div>
                                            <div class="course_content">
                                                <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                    <h4 class="noBrake"
                                                        title="{{$course->title}}"> {{$course->title}}</h4>
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
                                                </div>
                                                <div class="course_less_students">
                                                    <a> <i
                                                            class="ti-agenda"></i> {{$course->class->total_class}}
                                                        {{__('student.Classes')}}</a>
                                                    @if(!Settings('hide_total_enrollment_count') == 1)
                                                        <a>
                                                            <i class="ti-user"></i> {{$course->total_enrolled}} {{__('student.Students')}}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                        @if(count($courses)==0)

                            <div class="col-lg-12">
                                <div
                                    class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
                                    <h1>
                                        <div class="thumb">
                                            <img style="width: 50px"
                                                 src="{{ asset('public/frontend/infixlmstheme') }}/img/not-found.png"
                                                 alt="">
                                            @if(!isset($search))
                                                {{__('frontend.No Course Found')}}
                                            @else
                                                {{__('frontend.No results found for')}} {{$search}}
                                            @endif
                                        </div>

                                    </h1>
                                </div>
                            </div>

                        @endif
                    </div>
                    <div class="mt-4">
                        {{ $courses->appends(Request::all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" class="class_route" name="class_route" value="{{url()->current()}}">

    <input type="hidden" class="search" value="{{isset($search)?$search:''}}">
</div>
