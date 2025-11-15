<div>
    <input type="hidden" class="class_route" name="class_route" value="{{route('freeCourses')}}">
    <div class="courses_area">
        <div class="container">
            <div class="row">
                @if (courseSetting()->show_cql_left_sidebar==1)

                    <div class="col-lg-4 col-xl-3">
                        <x-class-page-section-sidebar :level="$level" :type="$type" :categories="$categories"
                                                      :category="$category" :languages="$languages"
                                                      :language="$language" :mode="$mode"/>
                    </div>
                @endif

                @php
                    if(courseSetting()->show_cql_left_sidebar==1){
                        $col_lg=8;
                        $col_xl=9;
                        $grid_size_lg=6;
                        $grid_size_xl=courseSetting()->size_of_grid;
                    }else{
                        $col_lg=12;
                        $col_xl=12;
                        $grid_size_lg=6;
                        $grid_size_xl=courseSetting()->size_of_grid;
                    }
                @endphp
                <div class="col-lg-{{@$col_lg}} col-xl-{{@$col_xl}}">
                    <div class="row">
                        <div class="col-12">
                            <div class="box_header d-flex flex-wrap align-items-center justify-content-between">
                                <h5 class="font_16 f_w_500 mb_30">{{$total}} {{__('frontend.Course are found')}}</h5>
                                @if (courseSetting()->show_search_in_category==1)

                                    <div class="mb_30">
                                        <form action="{{route('search')}}">
                                            <div class="input-group theme_search_field">
                                                <div class="input-group-prepend">
                                                    <button class="btn" type="button" id="button-addon1"><i
                                                            class="ti-search"></i>
                                                    </button>
                                                </div>

                                                <input type="text" class="form-control" name="query"
                                                       placeholder="{{__('frontend.Search for course, skills and Videos')}}"
                                                       onfocus="this.placeholder = ''"
                                                       onblur="this.placeholder = '{{__('frontend.Search for course, skills and Videos')}}'">

                                            </div>
                                        </form>
                                    </div>
                                @endif
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
                                <div class="col-lg-{{@$grid_size_lg}} col-xl-{{@$grid_size_xl}}">
                                    <div class="couse_wizged">
                                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                            <div class="thumb">

                                                <div class="thumb_inner lazy"
                                                     data-src="{{ getCourseImage($course->thumbnail) }}">
                                                </div>
                                                <span class="prise_tag">
                                        <span>
                                            @if (@$course->discount_price!=null)
                                                {{getPriceFormat($course->discount_price)}}
                                            @else
                                                {{getPriceFormat($course->price)}}
                                            @endif

                                          </span>
                                    </span>
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
                                                        <span>{{$course->total_rating}}/5</span>
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
                                                    {{__('frontend.Lessons')}}
                                                </a>

                                                @if (courseSetting()->show_enrolled_or_level_section==1)
                                                    @if (courseSetting()->enrolled_or_level==1)
                                                        <a>
                                                            <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                                        </a>
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
                                                        <a>
                                                            <i class="ti-thumb-up"></i> {{@$course->courseLevel->title}}
                                                        </a>
                                                    @endif

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @if(count($courses)==0)
                            <div class="col-lg-12">
                                <div
                                    class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
                                    <div class="thumb">
                                        <img style="width: 50px"
                                             src="{{ asset('public/frontend/infixlmstheme') }}/img/not-found.png"
                                             alt="">
                                    </div>
                                    <h1>
                                        {{__('frontend.No Course Found')}}
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
</div>
