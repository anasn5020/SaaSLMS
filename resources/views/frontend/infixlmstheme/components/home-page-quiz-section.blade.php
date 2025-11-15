<div>
    <div class="quiz_area">
        <div class="container">
            <div class="white_box">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section__title text-center mb_80">
                            <h3>{{@$homeContent->quiz_title}}</h3>
                            <p>
                                {{@$homeContent->quiz_sub_title}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if(isset($top_quizzes))
                        @foreach($top_quizzes as $quiz)

                            <div class="col-lg-4 col-xl-3 col-md-6">
                                <div class="quiz_wizged mb_30">
                                    <a href="{{courseDetailsUrl(@$quiz->id,@$quiz->type,@$quiz->slug)}}">
                                        <div class="thumb">
                                            <div class="thumb_inner lazy"
                                                 data-src="{{ file_exists($quiz->thumbnail) ? asset($quiz->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                            </div>
                                            <x-price-tag :price="$quiz->price"
                                                         :text="$quiz->price_text"
                                                         :discount="$quiz->discount_price"/>
                                            <span class="live_quiz">{{__('quiz.Quiz')}}</span>
                                        </div>

                                    </a>

                                    <div class="course_content">
                                        <a href="{{courseDetailsUrl(@$quiz->id,@$quiz->type,@$quiz->slug)}}">
                                            <h4 class="noBrake" title=" {{$quiz->title}}">
                                                {{$quiz->title}}
                                            </h4>
                                        </a>
                                        <div class="rating_cart">
                                            <div class="rateing">
                                                <span>{{$quiz->totalReview}}/5</span>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            @auth()
                                                @if(!$quiz->isLoginUserEnrolled && !$quiz->isLoginUserCart)
                                                    <a href="#" class="cart_store"
                                                       data-id="{{$quiz->id}}">
                                                        <i class="fas fa-shopping-cart"></i>
                                                    </a>
                                                @endif
                                            @endauth
                                            @guest()
                                                @if(!$quiz->isGuestUserCart)
                                                    <a href="#" class="cart_store"
                                                       data-id="{{$quiz->id}}">
                                                        <i class="fas fa-shopping-cart"></i>
                                                    </a>
                                                @endif
                                            @endguest
                                        </div>
                                        <div class="course_less_students">
                                            <a> <i class="ti-agenda"></i> {{$quiz->quiz->total_questions}}
                                                {{__('frontend.Question')}}</a>
                                            @if(!Settings('hide_total_enrollment_count') == 1)
                                                <a>
                                                    <i class="ti-user"></i> {{$quiz->total_enrolled}} {{__('frontend.Students')}}
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
                        <a href="{{route('quizzes')}}"
                           class="theme_btn mb_30">{{__('frontend.View All Quiz')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
