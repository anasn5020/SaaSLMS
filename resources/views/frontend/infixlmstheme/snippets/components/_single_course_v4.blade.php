<div class="row -mt-24 row-gap-24">
@if(isset($result))
        @foreach($result as $course)
            <div class="col-lg-4 col-sm-6 d-flex">
                <div class="course-item w-100">
                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                        <div class="course-item-img lazy">
                            <img src="{{ getCourseImage($course->thumbnail) }}" alt="{{$course->title}}">
                        </div>
                    </a>
                    <div class="course-item-info-wrap">
                        <div class="course-item-info flex-row bg-primary">
                            <span class="d-inline-block">{{@$course->courseLevel->title}}</span>
                            <span class="d-inline-block"><i class="fa fa-history me-1"></i>
                                {{!empty(MinuteFormat($course->duration))?MinuteFormat($course->duration):0}}
                            </span>
                            @if(!Settings('hide_total_enrollment_count') == 1)
                                <span class="d-inline-block"><i
                                        class="fas fa-graduation-cap me-1"></i>{{$course->total_enrolled}} {{__('frontend.Students')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="course-item-content">

                        <div class="course-item-rating">
                            <a href="{{route('instructorDetails',[$course->user->id,Str::slug($course->user->name,'-')])}}"
                               class="d-flex align-items-center">
                                <div class="user">
                                    <img src="{{getProfileImage($course->user->image,$course->user->name)}}" alt="">
                                </div>
                                <div class="content">
                                    <span class="lh-1">{{$course->user->name}}</span>
                                    <div class="lh-1 rating">

                                        <div class="stars">
                                            @php

                                                $main_stars= $course->total_rating;

                                                $stars=intval($main_stars);

                                            @endphp
                                            @for ($i = 0; $i <  $stars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            @if ($main_stars>$stars)
                                                <i class="fas fa-star-half"></i>
                                            @endif
                                            @if($main_stars==0)
                                                @for ($i = 0; $i <  5; $i++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            @endif

                                        </div>

                                    </div>
                                </div>
                            </a>
                        </div>
                        <p class="fs-13 mb-2 fw-normal"><span
                                class="text-primary">{{__('frontend.in')}}:</span> <span
                                class=""> {{$course->category->name}}</span></p>

                        <a class="course-item-title" data-bs-toggle="tooltip" data-bs-placement="bottom"
                           title="{{$course->title}}"
                           href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                            {{$course->title}}
                        </a>
                        <div class="course-item-price d-flex flex-wrap align-items-center justify-content-between">
                            @if(auth()->check() && $course->isLoginUserEnrolled)
                                <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}"
                                   class="theme-btn">
                                    {{__('courses.Get Started')}}
                                </a>
                            @else
                                <a href="{{route('buyNow',[@$course->id])}}"
                                   class="theme-btn">
                                    {{__('frontend.Buy Now')}}
                                </a>
                            @endif
                            <span>
                                @if(empty($course->price_text))
                                    @if (@$course->discount_price>0)
                                        <del class="me-3">{{getPriceFormat($course->price)}}</del>
                                    @endif
                                    <strong class="fw-bold d-inline-block">
                                    @if (@$course->discount_price>0)
                                            {{getPriceFormat($course->discount_price)}}
                                        @else
                                            {{getPriceFormat($course->price)}}
                                        @endif
                                </strong>
                                @else
                                    <strong class="fw-bold d-inline-block">
                                    {{$course->price_text}}
                                    </strong>
                                @endif

                            </span>
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
