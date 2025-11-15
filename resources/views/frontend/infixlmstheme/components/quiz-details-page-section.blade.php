<div>
    @php
        if (@$course->discount_price>0) {
                $course_price=@$course->discount_price;
            } else {
                $course_price=@$course->price;
            }
            $showWaitList =false;
            $alreadyWaitListRequest =false;
            if(isModuleActive('WaitList') && $course->waiting_list_status == 1 && auth()->check()){
               $count = $course->waitList->where('user_id',auth()->id())->count();
                if ($count==0){
                    $showWaitList=true;
                }else{
                    $alreadyWaitListRequest =true;
                }
            }
    @endphp

    <div class="quiz__details">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-xl-12">
                    <!-- <div class="row">

                    </div> -->
                    <div class="row row-gap-24 position-relative">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div>
                                <div class="quiz_test_wrapper mb-4">
                                    <div class="quiz_test_header">
                                        <h3> {{$course->quiz->title}}</h3>
                                    </div>
                                    <div class="quiz_test_body">

                                        <ul class="quiz_test_info">

                                            @php

                                                $duration =0;

                                                                                        $type =$course->quiz->question_time_type;
                                                                                        if ($type==0){
                                                                                            $duration = $course->quiz->question_time*$course->quiz->total_questions;
                                                                                        }else{
                                                                                            $duration = $course->quiz->question_time;

                                                                                        }


                                            @endphp
                                            <li>
                                                <span>{{__('frontend.Questions')}} <span>:</span></span>{{$course->quiz->total_questions}}
                                                {{__('frontend.Question')}}.
                                            </li>
                                            <li class="nowrap">
                                                <span>{{__('frontend.Duration')}}   <span>:</span></span> {{MinuteFormat($duration)}}
                                            </li>
                                        </ul>
                                        @if($course->is_upcoming_course && $course->publish_status == 'pending')
                                        @else

                                            @if (Auth::check() && $isEnrolled)

                                                @if($alreadyJoin == 0 || $course->quiz->multiple_attend == 1)
                                                    <a href="{{route('quizStart',[$course->id,$course->quiz->id,$course->slug])}}"
                                                       class="theme_btn mr_15 m-auto mt-4 text-center"
                                                    >{{__('frontend.Start Quiz')}}</a>
                                                @endif


                                                @if(count($preResult)!=0)
                                                    <button type="button"
                                                            class="theme_line_btn mr_15 m-auto mt-4  text-center  showHistory ">{{__('frontend.View History')}}</button>
                                                @endif

                                                @if($alreadyJoin == 1 && $certificate)
                                                    @if($isPass==1)
                                                        <a href="{{$isPass==1?route('getCertificate',[$course->id,$course->title]):'#'}}"
                                                           class="theme_line_btn mr_15 m-auto mt-4  text-center">
                                                            {{__('frontend.Get Certificate')}}
                                                        </a>
                                                    @endif
                                                @endif
                                            @else
                                                @if(!onlySubscription())
                                                    @if($isFree)
                                                        @if($is_cart == 1)
                                                            <a href="javascript:void(0)"
                                                               class="theme_btn text-center height_50 mb_10">{{__('common.Added To Cart')}}</a>
                                                        @else
                                                            <a href="{{route('addToCart',[@$course->id])}}"
                                                               class="theme_btn text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                        @endif
                                                    @else
                                                        <a href="{{route('buyNow',[@$course->id])}}"
                                                           class="theme_btn mr_15 m-auto mt-4 text-center"
                                                        >{{__('frontend.Buy Now')}}</a>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif


                                        @if(count($preResult)!=0)
                                            <div id="historyDiv" class="pt-5 " style="display:none;">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>{{__('common.Date')}}</th>
                                                        <th>{{__('quiz.Marks')}}</th>
                                                        <th>{{__('quiz.Percentage')}}</th>
                                                        <th>{{__('common.Rating')}}</th>
                                                        <th>{{__('common.Details')}}</th>
                                                    </tr>
                                                    @foreach($preResult as $pre)
                                                        <tr>
                                                            <td>{{$pre['date']}}</td>
                                                            <td>{{$pre['publish']==1?$pre['score']:'--'}}
                                                                /{{$pre['totalScore']}}</td>
                                                            <td>
                                                                {{$pre['publish']==1?$pre['mark']:'--'}} %
                                                            </td>
                                                            @if($pre['publish']==1)
                                                                <td class="{{$pre['text_color']}}">{{$pre['status']}}</td>
                                                            @else
                                                                <td class="">{{__('quiz.Pending')}}</td>
                                                            @endif

                                                            <td>
                                                                <a href="{{$course->quiz->show_ans_sheet==1?route('quizResultPreview',$pre['quiz_test_id']):'#'}}"
                                                                   data-quiz_test_id="{{$pre['quiz_test_id']}}"
                                                                   title="{{$course->quiz->show_ans_sheet!=1?__('quiz.Answer Sheet is currently locked by Teacher'):''}}"
                                                                   class=" font_1 font_16 f_w_600 theme_text3 submit_q_btn">{{__('student.See Answer Sheet')}}</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>

                                                @if($course->quiz->show_ans_with_explanation==1)
                                                    <x-quiz-details-question-list :quiz="$course->quiz"/>
                                                @endif
                                            </div>

                                        @endif


                                    </div>
                                </div>
                            </div>
                            <div class="bg-white quiz_border">
                                <div class="course_tabs gradient">
                                    <ul class="nav lms_tabmenu gradient_border" role="tablist" id="quiz_tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" id="Overview-tab"
                                               href="#Overview"
                                               role="tab" aria-controls="Overview"
                                               aria-selected="true">{{__('frontend.Overview')}}</a>
                                        </li>
                                        @if(Settings('hide_review_section')!='1')
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" id="Reviews-tab"
                                                   href="#Reviews"
                                                   role="tab" aria-controls="Instructor"
                                                   aria-selected="false">{{__('frontend.Reviews')}}</a>
                                            </li>
                                        @endif
                                        @if(Settings('hide_qa_section')!='1')
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" id="QA-tab" href="#QASection"
                                                   role="tab" aria-controls="Instructor"
                                                   aria-selected="false">{{__('frontend.QA')}}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="px-4 pb-4 lms_tab_content tab-content">
                                    <div class="tab-pane fade show active" id="Overview"
                                         aria-labelledby="Overview-tab">
                                        <!-- content  -->
                                        @if(isModuleActive('Installment') && $course_price > 0)
                                            @includeIf(theme('partials._installment_plan_details'), ['course' => $course,'position'=>'top_of_page'])
                                        @endif
                                        <div class="course_overview_description">
                                            <div class="single_overview">
                                                <h4 class="font_22 f_w_700 mb_20">{{__('frontend.Instructions')}}</h4>
                                                <div class="theme_border"></div>
                                                <p class="mb_25">  {{$course->quiz->instruction}} </p>

                                                @if(!empty($course->requirements))
                                                    <h4 class="font_22 f_w_700 mb_20">{{__('frontend.Course Requirements')}}</h4>
                                                    <div class="theme_border"></div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                {!! $course->requirements !!}
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <p class="mb_20">
                                                    </p>
                                                @endif
                                                @if(!empty($course->about))
                                                    <h4 class="font_22 f_w_700 mb_20">{{__('frontend.Course Description')}}</h4>
                                                    <div class="theme_border"></div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                {!! $course->about !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mb_20">
                                                    </p>
                                                @endif

                                                @if(!empty($course->outcomes))
                                                    <h4 class="font_22 f_w_700 mb_20">{{__('frontend.Course Outcomes')}}</h4>
                                                    <div class="theme_border"></div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                {!! $course->outcomes !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mb_20">
                                                    </p>
                                                @endif

                                            </div>


                                        </div>
                                        @if(isModuleActive('Installment') && $course_price > 0)
                                            @includeIf(theme('partials._installment_plan_details'), ['course' => $course,'position'=>'bottom_of_page'])
                                        @endif
                                        <!--/ content  -->
                                    </div>
                                    <div class="tab-pane fade" id="Reviews"
                                         aria-labelledby="Reviews-tab">
                                        <!-- content  -->
                                        <div class="course_review_wrapper">
                                            <div class="details_title">
                                                <h4 class="font_22 f_w_700">{{__('frontend.Student Feedback')}}</h4>
                                                <p class="font_16 f_w_400">{{$course->title}}</p>
                                            </div>
                                            <div class="course_feedback">
                                                <div class="course_feedback_left">
                                                    <h2>{{$course->total_rating}}</h2>
                                                    <div class="feedmak_stars">
                                                        @php

                                                            $main_stars=$course->total_rating;
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
                                                    <span>{{__('frontend.Course Rating')}}</span>
                                                </div>
                                                <div class="feedbark_progressbar">
                                                    <div class="single_progrssbar">
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: {{getPercentageRating($course->starWiseReview,5)}}%"
                                                                 aria-valuenow="{{getPercentageRating($course->starWiseReview,5)}}"
                                                                 aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <div class="rating_percent d-flex align-items-center">
                                                            <div class="feedmak_stars d-flex align-items-center">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </div>
                                                            <span>{{getPercentageRating($course->starWiseReview,5)}}%</span>
                                                        </div>
                                                    </div>
                                                    <div class="single_progrssbar">
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: {{getPercentageRating($course->starWiseReview,4)}}%"
                                                                 aria-valuenow="{{getPercentageRating($course->starWiseReview,4)}}"
                                                                 aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <div class="rating_percent d-flex align-items-center">
                                                            <div class="feedmak_stars d-flex align-items-center">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                            </div>
                                                            <span>{{getPercentageRating($course->starWiseReview,4)}}%</span>
                                                        </div>
                                                    </div>
                                                    <div class="single_progrssbar">
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: {{getPercentageRating($course->starWiseReview,3)}}%"
                                                                 aria-valuenow="{{getPercentageRating($course->starWiseReview,3)}}"
                                                                 aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <div class="rating_percent d-flex align-items-center">
                                                            <div class="feedmak_stars d-flex align-items-center">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                                <i class="far fa-star"></i>

                                                            </div>
                                                            <span>{{getPercentageRating($course->starWiseReview,3)}}%</span>
                                                        </div>
                                                    </div>
                                                    <div class="single_progrssbar">
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: {{getPercentageRating($course->starWiseReview,2)}}%"
                                                                 aria-valuenow="{{getPercentageRating($course->starWiseReview,2)}}"
                                                                 aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <div class="rating_percent d-flex align-items-center">
                                                            <div class="feedmak_stars d-flex align-items-center">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                            </div>
                                                            <span>{{getPercentageRating($course->starWiseReview,2)}}%</span>
                                                        </div>
                                                    </div>
                                                    <div class="single_progrssbar">
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: {{getPercentageRating($course->starWiseReview,1)}}%"
                                                                 aria-valuenow="{{getPercentageRating($course->starWiseReview,1)}}"
                                                                 aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <div class="rating_percent d-flex align-items-center">
                                                            <div class="feedmak_stars d-flex align-items-center">
                                                                <i class="fas fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                                <i class="far fa-star"></i>
                                                            </div>
                                                            <span>{{getPercentageRating($course->starWiseReview,1)}}%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="course_review_header mb_20 mt-3">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <div class="review_poients">
                                                            @if ($course->reviews->count()<1)
                                                                @if (Auth::check() && $isEnrolled)
                                                                    <p class="theme_color font_16 mb-0">{{ __('frontend.Be the first reviewer') }}</p>
                                                                @else

                                                                    <p class="theme_color font_16 mb-0">{{ __('frontend.No Review found') }}</p>
                                                                @endif

                                                            @else


                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="rating_star text-end">

                                                            @php
                                                                $PickId=$course->id;
                                                            @endphp
                                                            @if (Auth::check() && Auth::user()->role_id==3)
                                                                @if (!in_array(Auth::user()->id,$reviewer_user_ids) && $isEnrolled)

                                                                    <div
                                                                        class="star_icon d-flex align-items-center justify-content-end">
                                                                        <a class="rating">
                                                                            <input type="radio" id="star5" name="rating"
                                                                                   value="5"
                                                                                   class="rating"/><label
                                                                                class="full" for="star5" id="star5"
                                                                                title="Awesome - 5 stars"
                                                                                onclick="Rates(5, {{@$PickId }})"></label>

                                                                            <input type="radio" id="star4" name="rating"
                                                                                   value="4"
                                                                                   class="rating"/><label
                                                                                class="full" for="star4"
                                                                                title="Pretty good - 4 stars"
                                                                                onclick="Rates(4, {{@$PickId }})"></label>

                                                                            <input type="radio" id="star3" name="rating"
                                                                                   value="3"
                                                                                   class="rating"/><label
                                                                                class="full" for="star3"
                                                                                title="Meh - 3 stars"
                                                                                onclick="Rates(3, {{@$PickId }})"></label>

                                                                            <input type="radio" id="star2" name="rating"
                                                                                   value="2"
                                                                                   class="rating"/><label
                                                                                class="full" for="star2"
                                                                                title="Kinda bad - 2 stars"
                                                                                onclick="Rates(2, {{@$PickId }})"></label>

                                                                            <input type="radio" id="star1" name="rating"
                                                                                   value="1"
                                                                                   class="rating"/><label
                                                                                class="full" for="star1"
                                                                                title="Bad  - 1 star"
                                                                                onclick="Rates(1,{{@$PickId }})"></label>

                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            @else

                                                                <p class="font_14 f_w_400 mt-0"><a
                                                                        href="{{url('login')}}"
                                                                        class="theme_color2">{{__('frontend.Sign In')}}</a>
                                                                    {{__('frontend.or')}} <a
                                                                        class="theme_color2"
                                                                        href="{{url('register')}}">{{__('frontend.Sign Up')}}</a>
                                                                    {{__('frontend.as student to post a review')}}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="course_cutomer_reviews">
                                                <div class="details_title">
                                                    <h4 class="font_22 f_w_700">{{__('frontend.Reviews')}}</h4>

                                                </div>
                                                <div class="customers_reviews" id="customers_reviews">


                                                </div>
                                            </div>

                                            <div class="author_courses">
                                                <div>
                                                    <h4 class="font_40 f_w_700 mb_20">{{__('frontend.Course you might like')}}</h4>
                                                </div>
                                                <div class="row row-gap-24">
                                                    @foreach(@$related as $r)
                                                        <div class="col-md-6">
                                                            <div class="course-item">
                                                                <a href="{{courseDetailsUrl(@$r->id,@$r->type,@$r->slug)}}">
                                                                    <div class="course-item-img lazy">
                                                                        <img class="w-100"
                                                                             src="{{ file_exists($r->thumbnail) ? asset($r->thumbnail) : asset('public/\uploads/course_sample.png') }}"
                                                                             alt="">
                                                                        <span
                                                                            class="course-tag"><span>Static</span></span>
                                                                    </div>
                                                                </a>

                                                                <div class="course-item-info">
                                                                    <a href="{{courseDetailsUrl(@$r->id,@$r->type,@$r->slug)}}"
                                                                       class="title">
                                                                        {{@$r->title}}
                                                                    </a>
                                                                    <div
                                                                        class="d-flex align-itemes-center justify-content-between meta">
                                                                        <div class="rating">
                                                                            <svg width="16" height="15"
                                                                                 viewBox="0 0 16 15" fill="none"
                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M14.9922 5.21624L10.2573 4.53056L8.1344 0.242104C8.09105 0.168678 8.02784 0.10754 7.9513 0.0649862C7.87476 0.0224321 7.78764 0 7.69892 0C7.6102 0 7.52308 0.0224321 7.44654 0.0649862C7.37 0.10754 7.3068 0.168678 7.26345 0.242104L5.14222 4.52977L0.40648 5.21624C0.31946 5.22916 0.237852 5.2645 0.170564 5.31841C0.103275 5.37231 0.0528901 5.44272 0.0249085 5.52194C-0.00307309 5.60116 -0.00757644 5.68614 0.01189 5.76762C0.0313563 5.8491 0.0740445 5.92394 0.135295 5.98398L3.57501 9.33111L2.76146 14.0591C2.74696 14.1436 2.75782 14.2304 2.79281 14.3094C2.8278 14.3883 2.88549 14.4564 2.95932 14.5058C3.03314 14.5551 3.12011 14.5838 3.2103 14.5886C3.30049 14.5933 3.39026 14.5739 3.46936 14.5325L7.6985 12.3153L11.9276 14.5333C12.0068 14.5746 12.0965 14.5941 12.1867 14.5893C12.2769 14.5846 12.3639 14.5559 12.4377 14.5066C12.5115 14.4572 12.5692 14.3891 12.6042 14.3101C12.6392 14.2311 12.6501 14.1444 12.6356 14.0599L11.822 9.3319L15.2634 5.98398C15.3253 5.92392 15.3685 5.84885 15.3883 5.76699C15.4082 5.68515 15.4039 5.59969 15.3758 5.52003C15.3478 5.44036 15.2972 5.36956 15.2295 5.31541C15.1618 5.26126 15.0797 5.22586 14.9922 5.21308V5.21624Z"
                                                                                    fill="#FFC107"/>
                                                                            </svg>
                                                                            <span>{{$r->totalReview}} ({{$r->total_rating}} {{__("frontend.Ratings")}})</span>
                                                                            <i class="fas fa-star"></i>
                                                                        </div>
                                                                        <div class="enrolled-student">
                                                                            @if(!Settings('hide_total_enrollment_count') == 1)
                                                                                <a href="#">
                                                                                    <svg width="16" height="18"
                                                                                         viewBox="0 0 16 18" fill="none"
                                                                                         xmlns="http://www.w3.org/2000/svg">
                                                                                        <path
                                                                                            d="M14.2508 3.87484L9.30078 1.0165C8.49245 0.549837 7.49245 0.549837 6.67578 1.0165L1.73411 3.87484C0.925781 4.3415 0.425781 5.20817 0.425781 6.14984V11.8498C0.425781 12.7832 0.925781 13.6498 1.73411 14.1248L6.68411 16.9832C7.49245 17.4498 8.49245 17.4498 9.30911 16.9832L14.2591 14.1248C15.0674 13.6582 15.5674 12.7915 15.5674 11.8498V6.14984C15.5591 5.20817 15.0591 4.34984 14.2508 3.87484ZM7.99245 5.1165C9.06745 5.1165 9.93411 5.98317 9.93411 7.05817C9.93411 8.13317 9.06745 8.99984 7.99245 8.99984C6.91745 8.99984 6.05078 8.13317 6.05078 7.05817C6.05078 5.9915 6.91745 5.1165 7.99245 5.1165ZM10.2258 12.8832H5.75911C5.08411 12.8832 4.69245 12.1332 5.06745 11.5748C5.63411 10.7332 6.73411 10.1665 7.99245 10.1665C9.25078 10.1665 10.3508 10.7332 10.9174 11.5748C11.2924 12.1248 10.8924 12.8832 10.2258 12.8832Z"
                                                                                            fill="#292D32"/>
                                                                                    </svg>
                                                                                    {{$r->total_enrolled}}
                                                                                    {{__('frontend.Students')}} </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <div class="course-item-info-description">
                                                                        {{Str::limit(strip_tags($r->about), 100)}}
                                                                    </div>

                                                                    <div
                                                                        class="course-item-footer d-flex justify-content-between">
                                                                        <x-price-tag :price="$r->price"
                                                                                     :text="$r->price_text"
                                                                                     :discount="$r->discount_price"/>

                                                                        @if(!onlySubscription())
                                                                            @auth()
                                                                                @if(!$r->isLoginUserEnrolled && !$r->isLoginUserCart)
                                                                                    <a href="#" class="cart_store"
                                                                                       data-id="{{$r->id}}">
                                                                                        <svg width="23" height="20"
                                                                                             viewBox="0 0 23 20"
                                                                                             fill="none"
                                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                                            <path
                                                                                                d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z"
                                                                                                fill="url(#paint0_linear_2677_3208)"/>
                                                                                            <path
                                                                                                d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z"
                                                                                                fill="url(#paint1_linear_2677_3208)"/>
                                                                                            <path
                                                                                                d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z"
                                                                                                fill="url(#paint2_linear_2677_3208)"/>
                                                                                            <defs>
                                                                                                <linearGradient
                                                                                                    id="paint0_linear_2677_3208"
                                                                                                    x1="2.00048"
                                                                                                    y1="13.4568"
                                                                                                    x2="20.837"
                                                                                                    y2="8.70962"
                                                                                                    gradientUnits="userSpaceOnUse">
                                                                                                    <stop
                                                                                                        stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                                                    <stop offset="1"
                                                                                                          stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                                </linearGradient>
                                                                                                <linearGradient
                                                                                                    id="paint1_linear_2677_3208"
                                                                                                    x1="2.00048"
                                                                                                    y1="13.4568"
                                                                                                    x2="20.837"
                                                                                                    y2="8.70962"
                                                                                                    gradientUnits="userSpaceOnUse">
                                                                                                    <stop
                                                                                                        stop-color="#660AFB"/>
                                                                                                    <stop offset="1"
                                                                                                          stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                                </linearGradient>
                                                                                                <linearGradient
                                                                                                    id="paint2_linear_2677_3208"
                                                                                                    x1="2.00048"
                                                                                                    y1="13.4568"
                                                                                                    x2="20.837"
                                                                                                    y2="8.70962"
                                                                                                    gradientUnits="userSpaceOnUse">
                                                                                                    <stop
                                                                                                        stop-color="#660AFB"/>
                                                                                                    <stop offset="1"
                                                                                                          stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                                </linearGradient>
                                                                                            </defs>
                                                                                        </svg>

                                                                                    </a>
                                                                                @endif
                                                                            @endauth
                                                                            @guest()
                                                                                @if(!$r->isGuestUserCart)
                                                                                    <a href="#" class="cart_store"
                                                                                       data-id="{{$r->id}}">
                                                                                        <svg width="23" height="20"
                                                                                             viewBox="0 0 23 20"
                                                                                             fill="none"
                                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                                            <path
                                                                                                d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z"
                                                                                                fill="url(#paint0_linear_2677_3208)"/>
                                                                                            <path
                                                                                                d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z"
                                                                                                fill="url(#paint1_linear_2677_3208)"/>
                                                                                            <path
                                                                                                d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z"
                                                                                                fill="url(#paint2_linear_2677_3208)"/>
                                                                                            <defs>
                                                                                                <linearGradient
                                                                                                    id="paint0_linear_2677_3208"
                                                                                                    x1="2.00048"
                                                                                                    y1="13.4568"
                                                                                                    x2="20.837"
                                                                                                    y2="8.70962"
                                                                                                    gradientUnits="userSpaceOnUse">
                                                                                                    <stop
                                                                                                        stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                                                    <stop offset="1"
                                                                                                          stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                                </linearGradient>
                                                                                                <linearGradient
                                                                                                    id="paint1_linear_2677_3208"
                                                                                                    x1="2.00048"
                                                                                                    y1="13.4568"
                                                                                                    x2="20.837"
                                                                                                    y2="8.70962"
                                                                                                    gradientUnits="userSpaceOnUse">
                                                                                                    <stop
                                                                                                        stop-color="#660AFB"/>
                                                                                                    <stop offset="1"
                                                                                                          stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                                </linearGradient>
                                                                                                <linearGradient
                                                                                                    id="paint2_linear_2677_3208"
                                                                                                    x1="2.00048"
                                                                                                    y1="13.4568"
                                                                                                    x2="20.837"
                                                                                                    y2="8.70962"
                                                                                                    gradientUnits="userSpaceOnUse">
                                                                                                    <stop
                                                                                                        stop-color="#660AFB"/>
                                                                                                    <stop offset="1"
                                                                                                          stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                                </linearGradient>
                                                                                            </defs>
                                                                                        </svg>

                                                                                    </a>
                                                                                @endif
                                                                            @endguest
                                                                        @endif
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <!-- content  -->
                                    </div>
                                    <div class="tab-pane fade" id="QASection" aria-labelledby="QA-tab">
                                        <!-- content  -->

                                        <div class="conversition_box">
                                            <div id="conversition_box"></div>

                                            <div class="row">
                                                @if ($isEnrolled)
                                                    <div class="col-lg-12 " id="mainComment">
                                                        <form action="{{route('saveComment')}}" method="post" class="">
                                                            @csrf
                                                            <input type="hidden" name="course_id"
                                                                   value="{{@$course->id}}">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="section_title3 mb_20">
                                                                        <h3>{{__('frontend.Leave a question/comment') }}</h3>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="single_input mb_25">
                                                                                            <textarea
                                                                                                placeholder="{{__('frontend.Leave a question/comment') }}"
                                                                                                name="comment"
                                                                                                class="primary_textarea gray_input"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 mb_30">

                                                                    <button type="submit"
                                                                            class="theme_btn height_50">
                                                                        <i class="fas fa-comments"></i>
                                                                        {{__('frontend.Question') }}/
                                                                        {{__('frontend.comment') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="col-lg-12 text-center" id="mainComment">
                                                        <h4>{{__('frontend.You must be enrolled to ask a question')}}</h4>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 order-1 order-xl-2">
                            <div class="course_sidebar mt-0">

                                <div class="quiz_details_thumb">
                                    <img src="{{asset($course->image)}}" alt="image">
                                </div>

                                <div class="sidebar__widget quiz_sidebar__widget mb_30">
                                    @if(isModuleActive('EarlyBird') && Auth::check() && !$isEnrolled)
                                        @includeIf(theme('partials._early_bird_offer'), ['price_plans' => $course->pricePlans, 'product' => $course])
                                    @endif

                                        <div class="sidebar__title flex-wrap flex-column align-items-start gap-2">
                                        <div id="price-container" class="d-flex align-items-end gap-2">
                                            @if(empty($course->price_text))
                                                <h3 id="price_show_tag">
                                                    {{getPriceFormat($course_price)}}
                                                </h3>

                                                @if($course->discount_price)
                                                    <del class="previous_price">
                                                        {{getPriceFormat($course->price)}}
                                                    </del>
                                                @endif
                                            @else
                                                <h3 id="price_show_tag">
                                                    {{$course->price_text}}
                                                </h3>
                                            @endif
                                            <div class="price_loader"></div>
                                        </div>

                                        <p>
                                            @if (Auth::check() && $isBookmarked )
                                                <i class="fas fa-heart"></i>
                                                <a href="{{route('bookmarkSave',[$course->id])}}"
                                                   class=" mr_10 sm_mb_10">{{__('frontend.Already In Wishlist')}}
                                                </a>
                                            @elseif (Auth::check() && !$isBookmarked )
                                                <a href="{{route('bookmarkSave',[$course->id])}}"
                                                   class="">
                                                    <i
                                                        class="far fa-heart"></i>
                                                    {{__('frontend.Add To Wishlist')}}  </a>
                                        @endif
                                    </div>
                                    @if($showWaitList)
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#courseWaitList"
                                           class="theme_btn d-block text-center height_50 mb_10">
                                            {{ __('frontend.Enter to Wait List') }}
                                        </a>
                                    @endif
                                    @if($alreadyWaitListRequest)
                                        <a href="#"
                                           class="theme_btn d-block text-center height_50 mb_10">
                                            {{ __('frontend.Already In Wait List') }}
                                        </a>
                                    @endif
                                    @if(!onlySubscription())

                                        @if($course->is_upcoming_course && $course->publish_status == 'pending')
                                            <x-upcoming-course-action :course="$course"/>
                                        @else
                                            @if (Auth::check())
                                                @if ($isEnrolled)
                                                    <a href="#"
                                                       class="theme_btn d-block text-center height_50 mb_10">{{__('common.Already Enrolled')}}</a>
                                                @else
                                                    @if($isFree)
                                                        @if($is_cart == 1)
                                                            <a href="javascript:void(0)"
                                                               class="theme_btn d-block text-center height_50 mb_10">{{__('common.Added To Cart')}}</a>
                                                        @else
                                                            <a href="{{route('addToCart',[@$course->id])}}"
                                                               class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                        @endif
                                                    @else
                                                        @if($is_cart == 1)
                                                            <a href="javascript:void(0)"
                                                               class="theme_btn d-block text-center height_50 mb_10">{{__('common.Added To Cart')}}</a>
                                                        @else
                                                            <a href=" {{route('addToCart',[@$course->id])}} "
                                                               class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                            <a href="{{route('buyNow',[@$course->id])}}"
                                                               class="theme_line_btn d-block text-center height_50 mb_20">{{__('common.Buy Now')}}</a>
                                                        @endif
                                                    @endif
                                                @endif

                                            @else
                                                @if($isFree)
                                                    @if($is_cart == 1)
                                                        <a href="javascript:void(0)"
                                                           class="theme_btn d-block text-center height_50 mb_10">{{__('common.Added To Cart')}}</a>
                                                    @else
                                                        <a href=" {{route('addToCart',[@$course->id])}} "
                                                           class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                    @endif
                                                @else
                                                    @if($is_cart == 1)
                                                        <a href="javascript:void(0)"
                                                           class="theme_btn d-block text-center height_50 mb_10">{{__('common.Added To Cart')}}</a>
                                                    @else
                                                        <a href=" {{route('addToCart',[@$course->id])}} "
                                                           class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                        <a href="{{route('buyNow',[@$course->id])}}"
                                                           class="theme_line_btn d-block text-center height_50 mb_20">{{__('common.Buy Now')}}</a>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                    @includeIf('gift::buttons.course_details_page_button', ['course' => $course])
                                    @if(isModuleActive('Installment') && $course_price > 0)
                                        @includeIf(theme('partials._installment_plan_button'), ['course' => $course])
                                    @endif
                                    @if(isModuleActive('Cashback'))
                                        @includeIf(theme('partials._cashback_card'), ['product' => $course])
                                    @endif

                                    <h4 class="f_w_700 mb_10">{{__('frontend.This course includes')}}:</h4>
                                    <ul class="course_includes">
                                        <li>
                                            <!-- <i class="ti-thumb-up"></i> -->
                                            <svg width="13" height="14" viewBox="0 0 13 14" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.8723 11.0096C11.955 9.6917 11.9985 8.32591 11.9985 6.92641C11.9985 6.35961 11.9914 5.79834 11.9774 5.24353C11.9676 4.85377 11.8411 4.47499 11.6104 4.1607C10.731 2.96274 10.0305 2.21799 8.87601 1.32696C8.55874 1.08209 8.16941 0.949243 7.76875 0.940484C7.36697 0.931705 6.94742 0.927246 6.49924 0.927246C5.14247 0.927246 4.04803 0.96811 2.91543 1.04598C1.95193 1.11223 1.1867 1.87925 1.1262 2.84314C1.04348 4.16113 1 5.52692 1 6.92641C1 8.32591 1.04348 9.6917 1.1262 11.0096C1.1867 11.9736 1.95193 12.7406 2.91543 12.8068C4.04803 12.8847 5.14247 12.9256 6.49924 12.9256C7.856 12.9256 8.95044 12.8847 10.083 12.8068C11.0465 12.7406 11.8118 11.9736 11.8723 11.0096Z"
                                                    fill="white" stroke="url(#paint0_linear_0_1)"/>
                                                <path
                                                    d="M3.5 1.00901V6.71933C3.5 7.16473 4.0385 7.38778 4.35343 7.07284L5.49972 5.92655L6.64601 7.07284C6.96095 7.38778 7.49944 7.16473 7.49944 6.71933V0.935285C7.1801 0.929946 6.84851 0.927246 6.49958 0.927246C5.37685 0.927246 4.43374 0.955232 3.5 1.00901Z"
                                                    fill="white" stroke="url(#paint1_linear_0_1)"
                                                    stroke-linejoin="round"/>
                                                <defs>
                                                    <linearGradient id="paint0_linear_0_1" x1="1.99534" y1="9.0002"
                                                                    x2="11.5455" y2="7.00406"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                        <stop offset="1"
                                                              stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                    <linearGradient id="paint1_linear_0_1" x1="3.86194" y1="5.16144"
                                                                    x2="7.41189" y2="4.64701"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                        <stop offset="1"
                                                              stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                </defs>
                                            </svg>

                                            <p>{{__('frontend.Skill Level')}}
                                                @foreach($levels as $level)
                                                    @if (@$course->level==$level->id)
                                                        {{ $level->title}}
                                                    @endif
                                                @endforeach
                                            </p>
                                        </li>
                                        <li>
                                            <!--<i class="ti-agenda"></i> -->
                                            <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.03926 2.09603C4.98431 1.52996 6.06521 1.23081 7.16683 1.23047C8.08338 1.22993 8.98823 1.43627 9.81394 1.83411C10.6396 2.23196 11.3649 2.81104 11.9356 3.5282C12.5064 4.24536 12.9079 5.08209 13.1103 5.97602C13.3127 6.86995 13.3107 7.79803 13.1044 8.69108C12.8981 9.58413 12.493 10.4191 11.919 11.1337C11.3452 11.8484 10.6174 12.4244 9.78998 12.8186C8.96256 13.2128 8.05681 13.4152 7.14027 13.4106C6.3753 13.4069 5.61927 13.259 4.91136 12.9763L1.58264 13.5305C1.21072 13.5925 0.906715 13.236 1.0265 12.8786L1.87804 10.337C1.40371 9.50499 1.13126 8.57099 1.08549 7.61045C1.03307 6.51008 1.28008 5.4161 1.80024 4.44501C2.32039 3.47393 3.0942 2.66211 4.03926 2.09603Z"
                                                    fill="white" stroke="url(#paint0_linear_0_1)" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                                <path
                                                    d="M7.16401 7.97156C7.16401 7.61055 7.45762 7.38911 7.97563 7.04299C8.45611 6.72194 8.70956 6.30548 8.59681 5.73871C8.48408 5.17195 8.01577 4.70364 7.44901 4.59091C6.55935 4.41394 5.70312 5.11662 5.70312 6.02372"
                                                    stroke="url(#paint1_linear_0_1)" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                                <path d="M7.16406 10.0215V10.334" stroke="url(#paint2_linear_0_1)"
                                                      stroke-linecap="round"/>
                                                <defs>
                                                    <linearGradient id="paint0_linear_0_1" x1="2.10956" y1="9.51117"
                                                                    x2="12.6755" y2="7.11105"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                        <stop offset="1"
                                                              stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                    <linearGradient id="paint1_linear_0_1" x1="5.9674" y1="6.85657"
                                                                    x2="8.51657" y2="6.35851"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                        <stop offset="1"
                                                              stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                    <linearGradient id="paint2_linear_0_1" x1="7.25456" y1="10.2318"
                                                                    x2="7.84599" y2="9.80026"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                        <stop offset="1"
                                                              stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                </defs>
                                            </svg>

                                            <p>{{__('frontend.Questions')}} {{$course->quiz->total_questions}} </p></li>
                                        @if(!Settings('hide_total_enrollment_count') == 1)
                                            <li>
                                                <!-- <i class="ti-user"></i> -->
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.32422 7.7373C7.28047 7.73105 7.22422 7.73105 7.17422 7.7373C6.07422 7.6998 5.19922 6.7998 5.19922 5.69355C5.19922 4.5623 6.11172 3.64355 7.24922 3.64355C8.38047 3.64355 9.29922 4.5623 9.29922 5.69355C9.29297 6.7998 8.42422 7.6998 7.32422 7.7373Z"
                                                        stroke="url(#paint0_linear_0_1)" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                    <path
                                                        d="M11.4641 11.8626C10.3516 12.8813 8.87656 13.5001 7.25156 13.5001C5.62656 13.5001 4.15156 12.8813 3.03906 11.8626C3.10156 11.2751 3.47656 10.7001 4.14531 10.2501C5.85781 9.1126 8.65781 9.1126 10.3578 10.2501C11.0266 10.7001 11.4016 11.2751 11.4641 11.8626Z"
                                                        stroke="url(#paint1_linear_0_1)" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                    <path
                                                        d="M7.25 13.5C10.7018 13.5 13.5 10.7018 13.5 7.25C13.5 3.79822 10.7018 1 7.25 1C3.79822 1 1 3.79822 1 7.25C1 10.7018 3.79822 13.5 7.25 13.5Z"
                                                        stroke="url(#paint2_linear_0_1)" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                    <defs>
                                                        <linearGradient id="paint0_linear_0_1" x1="5.57026" y1="6.39799"
                                                                        x2="9.10171" y2="5.59153"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop
                                                                stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1"
                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint1_linear_0_1" x1="3.80151" y1="12.1577"
                                                                        x2="10.0639" y2="9.22571"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop
                                                                stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1"
                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint2_linear_0_1" x1="2.13122" y1="9.41049"
                                                                        x2="12.8995" y2="6.95514"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop
                                                                stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1"
                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                    </defs>
                                                </svg>

                                                <p>{{__('frontend.Enrolled')}} {{$course->total_enrolled}} {{__('frontend.students')}}</p>
                                            </li>
                                        @endif
                                        @if($course->certificate)
                                            <li>
                                                <!-- <i class="ti-user"></i> -->
                                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.4877 4.19436C13.4877 5.13038 13.1838 6.02806 12.6429 6.68993C12.216 7.21217 11.6693 7.55383 11.0819 7.67475L3.39607 7.67273C2.8123 7.55006 2.26921 7.20929 1.84478 6.68993C1.30389 6.02806 1.00002 5.13038 1.00002 4.19436L1 2.69762C0.999997 2.51334 1.12107 2.35094 1.29769 2.29834C5.17755 1.14274 9.31007 1.14274 13.1899 2.29835C13.3666 2.35095 13.4877 2.51334 13.4877 2.69762V4.19436Z"
                                                        stroke="url(#paint0_linear_0_1)" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                    <path d="M7.23438 10.897V13.9239" stroke="url(#paint1_linear_0_1)"
                                                          stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M4.83594 13.9238H9.64296" stroke="url(#paint2_linear_0_1)"
                                                          stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path
                                                        d="M3.76768 7.27052C3.82825 9.18136 5.33539 10.8896 7.2472 10.8896C9.19267 10.8896 10.658 9.21146 10.725 7.26714C10.7376 6.9011 10.7444 6.53128 10.7444 6.15769C10.7444 4.64268 10.6433 3.09965 10.478 1.7311C9.43894 1.49914 8.37042 1.42578 7.2472 1.42578C6.12398 1.42578 5.0339 1.49023 4.01642 1.7311C3.84211 3.09389 3.75 4.64268 3.75 6.15769C3.75 6.53256 3.75604 6.90347 3.76768 7.27052Z"
                                                        fill="white" stroke="url(#paint3_linear_0_1)"/>
                                                    <defs>
                                                        <linearGradient id="paint0_linear_0_1" x1="2.13011" y1="5.63225"
                                                                        x2="11.4983" y2="1.35953"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop
                                                                stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1"
                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint1_linear_0_1" x1="7.32487" y1="12.9336"
                                                                        x2="8.22601" y2="12.8657"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop
                                                                stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1"
                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint2_linear_0_1" x1="5.27096" y1="14.5967"
                                                                        x2="7.24986" y2="12.4276"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop
                                                                stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1"
                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint3_linear_0_1" x1="4.38298" y1="7.79339"
                                                                        x2="10.5466" y2="6.75468"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop
                                                                stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1"
                                                                  stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                    </defs>
                                                </svg>

                                                <p>{{__('frontend.Certificate of Completion')}}</p></li>
                                        @endif

                                        <li>
                                            <!-- <i class="ti-blackboard"></i> -->
                                            <svg width="12" height="15" viewBox="0 0 12 15" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1.09592 11.2785C1.25851 12.7129 2.47157 13.8315 3.91433 13.8827C4.64619 13.9086 5.39767 13.9221 6.20761 13.9221C7.01754 13.9221 7.76902 13.9086 8.50088 13.8827C9.94363 13.8315 11.1567 12.7129 11.3193 11.2785C11.3759 10.7785 11.4152 10.2705 11.4152 9.75593C11.4152 9.24137 11.3759 8.73337 11.3193 8.23338C11.1567 6.79889 9.94363 5.68043 8.50088 5.62923C7.76902 5.60326 7.01754 5.58984 6.20761 5.58984C5.39767 5.58984 4.64619 5.60326 3.91433 5.62923C2.47157 5.68043 1.25851 6.79889 1.09592 8.23338C1.03923 8.73337 1 9.24137 1 9.75593C1 10.2705 1.03923 10.7785 1.09592 11.2785Z"
                                                    fill="white" stroke="url(#paint0_linear_0_1)"/>
                                                <path
                                                    d="M8.26744 2.27798C7.72053 1.73108 6.97877 1.42383 6.20533 1.42383C5.43188 1.42383 4.69013 1.73108 4.14322 2.27798C3.59631 2.82488 3.28906 3.56665 3.28906 4.34009V5.58992"
                                                    stroke="url(#paint1_linear_0_1)" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                                <path d="M6.21094 9.25586V10.2557" stroke="url(#paint2_linear_0_1)"
                                                      stroke-linecap="round" stroke-linejoin="round"/>
                                                <defs>
                                                    <linearGradient id="paint0_linear_0_1" x1="1.94255" y1="11.1961"
                                                                    x2="10.6722" y2="8.70796"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                        <stop offset="1"
                                                              stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                    <linearGradient id="paint1_linear_0_1" x1="3.73959" y1="4.22694"
                                                                    x2="7.93944" y2="3.08258"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                        <stop offset="1"
                                                              stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                    <linearGradient id="paint2_linear_0_1" x1="6.30144" y1="9.92856"
                                                                    x2="7.16288" y2="9.7321"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                        <stop offset="1"
                                                              stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                    </linearGradient>
                                                </defs>
                                            </svg>

                                            @if($course->access_limit>0)
                                                <p>{{$course->access_limit}} {{__('frontend.Days')}} {{__('frontend.Access')}}</p>
                                            @else
                                                <p>{{__('frontend.Full lifetime access')}}</p>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal cs_modal fade admin-query" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('frontend.Review') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <form action="{{route('submitReview')}}" method="Post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="course_id" id="rating_course_id"
                               value="">
                        <input type="hidden" name="rating" id="rating_value" value="">

                        <div class="text-center">
                                                                <textarea class="lms_summernote" name="review" id=""
                                                                          placeholder="{{__('frontend.Write your review') }}"
                                                                          cols="30"
                                                                          rows="10">{{old('review')}}</textarea>
                            <span class="text-danger" role="alert">{{$errors->first('review')}}</span>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="theme_line_btn me-2"
                                    data-bs-dismiss="modal">{{ __('common.Cancel') }}
                            </button>
                            <button class="theme_btn "
                                    type="submit">{{ __('common.Submit') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @if($showWaitList)
        @include(theme('partials._course_wait_list_form'),['course' => $course])
    @endif
    @include(theme('partials._delete_model'))

</div>

<script>
    $(document).ready(function () {
        "use strict";

        function toggleVideoScreen() {

            const scrollTopPosition = $(window).scrollTop();
            const screenWidth = $(window).width();


            if (screenWidth > 1200) {
                if (scrollTopPosition > 200) {
                    $(".quiz_details_thumb").slideUp(400);
                } else {
                    $(".quiz_details_thumb").slideDown(400);
                }

            } else {
                console.log("this should");

                // Always show on small screens
                $(".quiz_details_thumb").stop(true, true).show();
                $(".quiz_details_thumb").show();

            }
        }

        // Run on scroll
        $(window).on("scroll", toggleVideoScreen);

        // Run on resize
        $(window).on("resize", toggleVideoScreen);

        // Initial check
        toggleVideoScreen();

        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            setTimeout(function () {
                const headerHeight = $('header').outerHeight() || 0;
                const navTabHeight = $('.course_tabs').outerHeight() || 0;
                const activeTabPane = $('.tab-pane.active');
                if (activeTabPane.length) {
                    $('html, body').animate({
                        scrollTop: activeTabPane.offset().top - (headerHeight + navTabHeight + 50)
                    }, 100);
                }
            }, 50);
        });

    });

</script>

