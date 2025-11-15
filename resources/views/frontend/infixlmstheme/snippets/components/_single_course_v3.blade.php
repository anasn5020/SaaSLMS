<div class="row -mt-40  row-gap-24">
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
                        {{-- need to dynamic --}}
                        <div class="meta d-flex align-items-center gap-2">
                            <span
                                class="bg-primary fs-14 lh-1 text-white rounded-2 fw-bold">{{@$course->courseLevel->title}}</span>
                        </div>
                        <a href="#" class="author d-flex flex-wrap">
                            <div class="author-img rounded-circle overflow-hidden"><img
                                    src="{{getProfileImage($course->user->image,$course->user->name)}}" alt=""></div>
                            <div class="author-content">
                                <p class="fw-bold fs-14 lh-base text-secondary">{{$course->user->name}} <span
                                        class="d-block fw-500 fs-12">{{$course->user->headline}}</span></p>
                            </div>
                        </a>
                        {{-- need to dynamic --}}
                        <a class="course-item-title" data-bs-toggle="tooltip" data-bs-placement="bottom"
                           title="{{$course->title}}"
                           href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                            {{$course->title}}
                        </a>
                        <div class="course-item-content-rating d-flex align-items-center justify-content-between">
                            <div>
                                @if (courseSetting()->show_rating==1)
                                    <i class="fa fa-star text-orange"></i>
                                    <span
                                        class="fw-bold">{{translatedNumber($course->total_rating)}} ({{translatedNumber(count($course->reviews))}} {{__('quiz.Rating')}})</span>
                                @endif
                            </div>
                            @if(!Settings('hide_total_enrollment_count') == 1)
                                <div>
                                    <i class="fa fa-user"></i>
                                    <span
                                        class="fw-bold">{{translatedNumber($course->total_enrolled)}} {{__('frontend.Students')}}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div
                        class="course-item-footer bg-primary d-flex align-items-center justify-content-between flex-wrap no-border">
                        <div class="d-flex align-items-center">
                            @if(showEcommerce())
                                @if(empty($course->price_text))

                                    <strong>
                                        @if (@$course->discount_price>0)
                                            {{getPriceFormat($course->discount_price)}}
                                        @else
                                            {{getPriceFormat($course->price)}}
                                        @endif
                                    </strong>
                                    @if (@$course->discount_price>0)
                                        <del class="ms-2 fw-normal">{{getPriceFormat($course->price)}}</del>
                                    @endif
                                @else
                                    <strong>
                                    {{$course->price_text}}
                                    </strong>
                                @endif
                            @endif
                        </div>
                        <div>
                            @if (courseSetting()->show_cart==1)
                                @auth()
                                    @if(!$course->isLoginUserEnrolled && !$course->isLoginUserCart)
                                        <button data-id="{{$course->id}}"
                                                class="cart_store bg-transparent border-0 text-white"><i
                                                class="fa fa-shopping-cart"></i></button>
                                    @endif
                                @endauth
                                @guest()
                                    @if(!$course->isGuestUserCart)
                                        <button data-id="{{$course->id}}"
                                                class="cart_store bg-transparent border-0 text-white"><i
                                                class="fa fa-shopping-cart"></i></button>
                                    @endif
                                @endguest
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
