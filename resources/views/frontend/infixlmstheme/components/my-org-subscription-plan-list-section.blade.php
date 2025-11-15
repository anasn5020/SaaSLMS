<div>
    <div>
        <div class="main_content_iner main_content_padding">
            <div class="container">
                <div class="my_courses_wrapper">
                    <div class="row">
                        <div class="col-xl-7">
                            <div class="section__title3">
                                <h3>
                                    {{__('org-subscription.My Plan')}} | {{$plan->title}}
                                </h3>
                            </div>
                        </div>
                        <div class="col-xl-5">
                            <form action="">
                                <div class="input-group theme_search_field pt-0 pb-3 float-end w-50">
                                    <div class="input-group-prepend">
                                        <button class="btn" type="button" id="button-addon1"><i
                                                class="ti-search"></i>
                                        </button>
                                    </div>

                                    <input type="text" class="form-control" name="search"
                                           placeholder="" value="{{$request->search}}"
                                           onfocus="this.placeholder = '{{__('org-subscription.My Plan')}}'"
                                           onblur="this.placeholder = '{{__('org-subscription.My Plan')}}'">

                                </div>
                            </form>
                        </div>
                        <div class="col-xl-12 col-md-6 pb-4">
                            <div class="statistic d-flex flex-wrap gap_15  justify-content-between">
                                <div class="item d-flex gap_15 align-items-center">
                                    <i class="far fa-calendar-minus"></i>
                                    <div class="status text-nowrap">
                                        @if($plan->type ==1)
                                            {{showDate($plan->join_date)}}
                                        @else
                                            {{showDate($plan->subscription->start_date)}}
                                        @endif

                                        <br>
                                        {{__('frontend.Start Date')}}
                                    </div>
                                </div>
                                <div class="item d-flex gap_15 align-items-center">
                                    <i class="far fa-calendar-minus"></i>
                                    <div class="status text-nowrap">
                                        @if($plan->type ==1)
                                            {{showDate($plan->end_date)}}
                                        @else
                                            {{showDate($plan->subscription->end_date)}}
                                        @endif

                                        <br>
                                        {{__('frontend.End Date')}}
                                    </div>
                                </div>
                                <div class="item d-flex gap_15 align-items-center">
                                    <i class="far fa-clock"></i>
                                    <div class="status text-nowrap">
                                        {{$plan->remaining()}}
                                        <br>
                                        {{__('frontend.Day remaining')}}
                                    </div>
                                </div>
                                <div class="item d-flex gap_15 align-items-center">
                                    <i class="fas fa-code-branch"></i>
                                    <div class="status text-nowrap">
                                        {{$plan->sequence == 1 ? 'Yes' : "No"}}
                                        <br>
                                        {{__('frontend.Complete By Sequence')}}
                                    </div>
                                </div>
                                <div class="item d-flex gap_15 align-items-center">
                                    <i class="far fa-check-circle"></i>
                                    <div class="status text-nowrap">
                                        {{$plan->totalCompleted()['completed_course']}}/{{count($plan->assign)}}
                                        <br>
                                        {{__('frontend.Complete Item')}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(isset($courses))
                            @foreach ($courses as $SingleCourse)
                                @php
                                    $course=$SingleCourse->course;

                                @endphp

                                <div class="col-xl-4 col-md-6">
                                    @if($course->type==1)
                                        <div class="couse_wizged">
                                            <div class="thumb">
                                                <div class="thumb_inner lazy"
                                                     data-src="{{ getCourseImage($course->thumbnail) }}">


                                                </div>

                                            </div>
                                            <div class="course_content">
                                                <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                    <h4 class="twoLine_ellipsis" title="{{$course->title}}">
                                                        {{$course->title}}
                                                    </h4>
                                                </a>
                                                <div class="d-flex align-items-center gap_15">
                                                    <div class="rating_cart">
                                                        <div class="rateing">
                                                            <span>{{$course->total_rating}}/5</span>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                    </div>

                                                    <div class="progress_percent flex-fill text-end">
                                                        <div class="progress theme_progressBar ">
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: {{round($course->loginUserTotalPercentage)}}%"
                                                                 aria-valuenow="25"
                                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <p class="font_14 f_w_400">{{round($course->loginUserTotalPercentage)}}
                                                            % {{__('student.Complete')}}</p>
                                                    </div>
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


                                                    </div>
                                                    <span class="quiz_tag">{{__('quiz.Quiz')}}</span>
                                                </div>
                                            </a>
                                            <div class="course_content">
                                                <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                    <h4 class="twoLine_ellipsis"
                                                        title="{{$course->title}}"> {{$course->title}}</h4>
                                                </a>
                                                <div class="rating_cart">
                                                    <div class="rateing">
                                                        <span>{{$course->total_rating}}/5</span>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <div class="course_less_students">

                                                    <a> <i class="ti-agenda"></i>{{$course->quiz->total_questions}}
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
                                                            <x-class-close-tag :class="$course->class"/>


                                                        </div>
                                                        <span class="live_tag">{{__('student.Live')}}</span>
                                                    </div>
                                                </a>


                                            </div>
                                            <div class="course_content">
                                                <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                    <h4 class="twoLine_ellipsis"
                                                        title="{{$course->title}}"> {{$course->title}}</h4>
                                                </a>
                                                <div class="rating_cart">
                                                    <div class="rateing">
                                                        <span>{{$course->total_rating}}/5</span>
                                                        <i class="fas fa-star"></i>
                                                    </div>
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
                                {{--                                @if(round($course->loginUserTotalPercentage) < 100 && $plan->sequence == 1 )--}}
                                {{--                                    @break--}}
                                {{--                                @endif--}}
                            @endforeach
                        @endif
                        @if(count($courses)==0)
                            <div class="col-12">
                                <div class="section__title3 margin_50">
                                    @if( routeIs('myClasses'))
                                        <p class="text-center">{{__('student.No Class Purchased Yet')}}!</p>
                                    @elseif( routeIs('myQuizzes'))
                                        <p class="text-center">{{__('student.No Quiz Purchased Yet')}}!</p>
                                    @else
                                        <p class="text-center">{{__('student.No Course Purchased Yet')}}!</p>
                                    @endif

                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
