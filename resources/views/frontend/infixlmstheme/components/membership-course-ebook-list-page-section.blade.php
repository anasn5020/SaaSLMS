<div>
    <div class="courses_area">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="section_tittle">
                                <h2>{{__('subscription.Plan')}}: {{$plan->title}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if(isset($plan))
                            @foreach ($plan->courses as $list)
                                @php
                                    $course =$list->course;
                                @endphp
                                <div class="col-lg-4 col-xl-3">

                                    @if($course->type==1)
                                        <div class="couse_wizged">
                                            <div class="thumb">
                                                <div class="thumb_inner lazy"
                                                     data-src="{{ getCourseImage($course->thumbnail) }}">

                                                    <x-price-tag :price="$course->price"
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
                            @foreach ($plan->ebooks as $item)
                                @php
                                    $ebook =$item->ebook;
                                @endphp
                                <div class="col-lg-4 col-xl-3">
                                    <div class="couse_wizged">
                                        <div class="thumb">
                                            <div class="thumb_inner lazy"
                                                 data-src="{{ getCourseImage($ebook->thumbnail) }}">


                                            </div>

                                        </div>
                                        <div class="course_content">
                                            <a href="#">
                                                <h4 class="noBrake" title="{{$ebook->name}}">
                                                    {{$ebook->name}}
                                                </h4>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @endif
                        @if(($plan->courses_count==0) && ($plan->ebooks_count==0) )

                            <div class="col-lg-12">
                                <div
                                    class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
                                    <h1>
                                        <div class="thumb">
                                            <img style="width: 50px"
                                                 src="{{ asset('public/frontend/infixlmstheme') }}/img/not-found.png"
                                                 alt="">
                                            {{__('frontend.No Course or Ebook Found')}}
                                        </div>

                                    </h1>
                                </div>
                            </div>

                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
