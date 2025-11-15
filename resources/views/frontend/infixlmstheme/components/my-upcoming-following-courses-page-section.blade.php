<div>
    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="my_courses_wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="section__title3">
                                <h3>
                                    {{$page_heading}}
                                </h3>
                            </div>
                        </div>

                    </div>
                    <div class="row d-flex align-items-center mb-4 mb-lg-5">
                        <div class="col-xl-6 col-md-6">
                            <div class="short_select d-flex align-items-center pt-0 pb-3">
                                <h5 class="mr_10 font_16 f_w_500 mb-0">{{ __('frontend.Filter By') }}:</h5>
                                <input type="hidden" id="siteUrl" value="{{ route(\Request::route()->getName()) }}">
                                <select class="theme_select my-course-select w-50" id="categoryFilter">
                                    <option value="" data-display="{{ __('frontend.All Categories') }}">
                                        {{ __('frontend.All Categories') }}</option>
                                    @foreach ($categories->where('parent_id',0) as $category)
                                        @include('backend.categories._single_select_option',['category'=>$category,'level'=>1])

                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class=" col-xl-6 col-md-6 pb-3">
                            <form action="{{ route(\Request::route()->getName()) }}">
                                <div class="input-group theme_search_field pt-0 pb-3 float-end  w-50">
                                    <div class="input-group-prepend">
                                        <button class="btn" type="button" id="button-addon1"><i class="ti-search"></i>
                                        </button>
                                    </div>

                                    <input type="text" class="form-control" name="search"
                                           placeholder="{{ $search_text }}" value="{{ $search }}"
                                           onfocus="this.placeholder = ''"
                                           onblur="this.placeholder = '{{ $search_text }}'">

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        @if (isset($courses))
                            @foreach ($courses as $SingleCourse)
                                @php
                                    $course = $SingleCourse->course;
                                @endphp
                                <div class="col-xl-4 col-md-6">
                                    @if ($course->type == 1)
                                        <div class="couse_wizged">
                                            <div class="thumb">
                                                <div class="thumb_inner lazy"
                                                     data-src="{{ getCourseImage($course->thumbnail) }}">

                                                    <x-price-tag :price="$course->price"
                                                                 :discount="$course->discount_price"/>

                                                </div>

                                            </div>
                                            <div class="course_content">
                                                <a href="{{ route('courseDetailsView', [$course->slug]) }}">
                                                    <h4 class="noBrake" title="{{ $course->title }}">
                                                        {{ $course->title }}
                                                    </h4>
                                                </a>
                                                @if ($SingleCourse->pathway_id != null)
                                                    <x-my-course-pathway-info :enrolld="$SingleCourse"/>
                                                @endif
                                                <div class="d-flex align-items-center gap_15">
                                                    <div class="rating_cart">
                                                        <div class="rateing">
                                                            <span>{{ $course->total_rating }}/5</span>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                    </div>

                                                    <div class="progress_percent flex-fill text-end">
                                                        <div class="progress theme_progressBar ">
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: {{ round($course->loginUserTotalPercentage) }}%"
                                                                 aria-valuenow="25" aria-valuemin="0"
                                                                 aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <p class="font_14 f_w_400">
                                                            {{ round($course->loginUserTotalPercentage) }}
                                                            % {{ __('student.Complete') }}</p>
                                                    </div>
                                                </div>
                                                <div class="course_less_students">
                                                    <a>
                                                        <i class="ti-agenda"></i> {{ $course->total_lessons }}
                                                        {{ __('student.Lessons') }}
                                                    </a>
                                                    @if(!Settings('hide_total_enrollment_count') == 1)
                                                    <a>
                                                        <i class="ti-user"></i> {{ $course->total_enrolled }}
                                                        {{ __('student.Students') }}
                                                    </a>
                                                    @endif
                                                    @if (isModuleActive('CPD') && isset($cpds))
                                                        @if(count((array)$cpds)>0)
                                                            <a class="cpd cpdValue"
                                                               data-course_id={{ $course->id }} data-bs-toggle="modal"
                                                               data-bs-target="#exampleModal">
                                                                <i class="ti-bolt"></i>
                                                                {{ __('cpd.CPD') }}
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($course->type == 2)
                                        <div class="quiz_wizged">
                                            <a href="{{ courseDetailsUrl($course->id, $course->type, $course->slug) }}">
                                                <div class="thumb">
                                                    <div class="thumb_inner lazy"
                                                         data-src="{{ getCourseImage($course->thumbnail) }}">

                                                        <x-price-tag :price="$course->price"
                                                                     :discount="$course->discount_price"/>


                                                    </div>
                                                    <span class="quiz_tag">{{ __('quiz.Quiz') }}</span>
                                                </div>
                                            </a>
                                            <div class="course_content">
                                                <a href="{{ courseDetailsUrl($course->id, $course->type, $course->slug) }}">
                                                    <h4 class="noBrake"
                                                        title="{{ $course->title }}"> {{ $course->title }}
                                                    </h4>
                                                </a>
                                                <div class="rating_cart">
                                                    <div class="rateing">
                                                        <span>{{ $course->total_rating }}/5</span>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <div class="course_less_students">

                                                    <a> <i class="ti-agenda"></i>{{ $course->quiz->total_questions }}
                                                        {{ __('student.Question') }}</a>
                                                    @if(!Settings('hide_total_enrollment_count') == 1)
                                                    <a>
                                                        <i class="ti-user"></i> {{ $course->total_enrolled }}
                                                        {{ __('student.Students') }}
                                                    </a>
                                                    @endif
                                                    @if (isModuleActive('CPD'))
                                                        @if(count($cpds)>0)
                                                            {{-- <a onclick="cpd({{ $course->id }})" class="cpd">
                                                                <i class="ti-bolt"></i> {{ __('cpd.CPD') }}
                                                            </a> --}}
                                                            <a class="cpd cpdvalue" data-bs-toggle="modal"
                                                               data-course_id={{ $course->id }} data-bs-target="#exampleModal">
                                                                <i class="ti-bolt"></i>
                                                                {{ __('cpd.CPD') }}
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($course->type == 3)
                                        <div class="quiz_wizged">
                                            <div class="thumb">
                                                <a href="{{ courseDetailsUrl($course->id, $course->type, $course->slug) }}">
                                                    <div class="thumb">
                                                        <div class="thumb_inner lazy"
                                                             data-src="{{ getCourseImage($course->thumbnail) }}">
                                                            <x-class-close-tag :class="$course->class"/>

                                                            <x-price-tag :price="$course->price"
                                                                         :discount="$course->discount_price"/>


                                                        </div>
                                                        <span class="live_tag">{{ __('student.Live') }}</span>
                                                    </div>
                                                </a>


                                            </div>
                                            <div class="course_content">
                                                <a href="{{ courseDetailsUrl($course->id, $course->type, $course->slug) }}">
                                                    <h4 class="noBrake"
                                                        title="{{ $course->title }}"> {{ $course->title }}
                                                    </h4>
                                                </a>
                                                <div class="rating_cart">
                                                    <div class="rateing">
                                                        <span>{{ $course->total_rating }}/5</span>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <div class="course_less_students">
                                                    <a> <i class="ti-agenda"></i> {{ $course->class->total_class }}
                                                        {{ __('student.Classes') }}</a>
                                                    @if(!Settings('hide_total_enrollment_count') == 1)
                                                    <a>
                                                        <i class="ti-user"></i> {{ $course->total_enrolled }}
                                                        {{ __('student.Students') }}
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <div class="mt-4">
                                {{ $courses->links() }}
                            </div>
                        @endif
                        @if (count($courses) == 0)
                            <div class="col-12">
                                <div class="section__title3 margin_50">
                                    <p class="text-center">{{ __('student.No Data found') }}!</p>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
