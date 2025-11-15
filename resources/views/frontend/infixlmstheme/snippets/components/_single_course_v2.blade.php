<style>

    .theme-btn {
        --btn-padding-y: 14px;
        --btn-padding-x: 24px;
        font-family: var(--font_family1);
        display: inline-flex;
        align-items: center;
        border-radius: 100px;
        background: var(--system_primery_color);
        background-size: 200% auto;
        color: #fff;
        font-size: 16px;
        line-height: 1.625;
        padding: var(--btn-padding-y) var(--btn-padding-x);
        border: 1px solid transparent;
        justify-content: center;
        text-align: center;
        font-weight: 500
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
        .theme-btn {
            --btn-padding-y: 10px;
            --btn-padding-x: 20px
        }
    }

    .theme-btn:hover {
        color: #fff;
        background-color: var(--system_secendory_color) !important;
        border-color: var(--system_secendory_color)
    }
</style>
<div class="row -mt-24  row-gap-24">
    @if(isset($result))
        @foreach($result as $course)
            <div class="col-lg-4 col-sm-6 d-flex">
                <div class="course-item w-100">
                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                        <div class="course-item-img lazy">
                            <img src="{{ getCourseImage($course->thumbnail) }}" alt="{{$course->title}}">
                        </div>
                    </a>
                    <div class="course-item-content">
                        <p class="fs-13 mb-2 fw-normal"><span
                                class="text-primary">{{__('frontend.in')}}:</span> {{$course->category->name}} </p>
                        <div class="course-item-rating">
                            <a href="{{route('instructorDetails',[$course->user->id,Str::slug($course->user->name,'-')])}}"
                               class="d-flex align-items-center">
                                <div class="user">
                                    <img src="{{getProfileImage($course->user->image,$course->user->name)}}" alt="">
                                </div>
                                <div class="content">
                                    <span class="lh-1">{{$course->user->name}}</span>
                                    <div class="lh-1 rating">
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
                            </a>
                        </div>
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
                            @if(showEcommerce())
                                <span>

                                @if(empty($course->price_text))
                                        @if (@$course->discount_price>0)
                                            <del>{{getPriceFormat($course->price)}}</del>
                                        @endif
                                        <strong class="fw-bold d-inline-block ms-2">
                                        @if (@$course->discount_price>0)
                                                {{getPriceFormat($course->discount_price)}}
                                            @else
                                                {{getPriceFormat($course->price)}}
                                            @endif
                                    </strong>
                                    @else
                                        <strong class="fw-bold d-inline-block ms-2">
                                        {{$course->price_text}}
                                        </strong>
                                    @endif
                                </span>
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
