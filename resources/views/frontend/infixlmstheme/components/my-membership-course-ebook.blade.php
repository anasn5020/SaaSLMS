<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="my_courses_wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title3">
                            <h3>
                                {{ $membership }}
                            </h3>
                        </div>
                    </div>

                    @if(isset($courses))
                        @foreach ($courses as $singleCourse)
                            @php
                                $course = $singleCourse->course;
                            @endphp

                            <div class="col-xl-4 col-md-6">
                                @if($course->type==1)
                                    <div class="couse_wizged">
                                        <div class="thumb">
                                            <div class="thumb_inner lazy"
                                                 data-src="{{ getCourseImage($course->thumbnail) }}">

                                                {{-- <x-price-tag :price="$course->price"
                                                             :discount="$course->discount_price"/> --}}

                                            </div>

                                        </div>
                                        <div class="course_content">
                                            <a href="{{route('continueCourse',[$course->slug])}}">
                                                <h4 class="noBrake" title="{{$course->title}}">
                                                    {{$course->title}}
                                                </h4>
                                            </a>
                                            @if ($singleCourse->pathway_id!=null)
                                                <x-my-course-pathway-info :enrolld="$singleCourse"/>
                                            @endif
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
                                                             aria-valuenow="{{round($course->loginUserTotalPercentage)}}"
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

                                                    {{-- <x-price-tag :price="$course->price"
                                                                 :discount="$course->discount_price"/> --}}


                                                </div>
                                                <span class="quiz_tag">{{__('quiz.Quiz')}}</span>
                                            </div>
                                        </a>
                                        <div class="course_content">
                                            <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                <h4 class="noBrake" title="{{$course->title}}"> {{$course->title}}</h4>
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

                                                        <x-price-tag :price="$course->price"
                                                                     :discount="$course->discount_price"/>


                                                    </div>
                                                    <span class="live_tag">{{__('student.Live')}}</span>
                                                </div>
                                            </a>


                                        </div>
                                        <div class="course_content">
                                            <a href="{{courseDetailsUrl($course->id,$course->type,$course->slug)}}">
                                                <h4 class="noBrake" title="{{$course->title}}"> {{$course->title}}</h4>
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
                        @endforeach

                        <div class="pt-3">
                        </div>
                    @endif
                    @foreach ($ebooks as $item)
                        @php
                            $ebook = $item->ebook;
                        @endphp
                        <div class="col-lg-4 col-xl-3">
                            <div class="couse_wizged">
                                <div class="thumb">
                                    <div class="thumb_inner lazy"
                                         data-src="{{ getCourseImage($ebook->thumbnail) }}">

                                    </div>

                                </div>
                                <div class="course_content">
                                    <a href="{{ route('e-library.file', [$ebook->id]) }}">
                                        <h4 class="noBrake" title="{{$ebook->name}}">
                                            {{$ebook->name}}
                                        </h4>
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if(count($courses)==0 && count($ebooks)==0)
                        <div class="col-12">
                            <div class="section__title3 margin_50">
                                {{__('frontend.No Course or Ebook Found')}}

                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
