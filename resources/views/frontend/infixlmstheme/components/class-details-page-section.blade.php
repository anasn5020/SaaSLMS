<div>
    @php
        use Illuminate\Support\Carbon;function secondsToTime($seconds) {
         $dtF = new \DateTime('@0');
         $dtT = new \DateTime("@$seconds");
         return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes');
     }

             function secondsToHour($seconds) {
              $dtF = new \DateTime('@0');
              $dtT = new \DateTime("@$seconds");
           return $dtF->diff($dtT)->format('%h : %i Hour(s)');

          }

    if (Auth::check() &&  $isEnrolled){
        $allow=true;
    }else{
        $allow=false;
    }

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

    <input type="hidden" name="start_time" class="class_start_time"
           value="{{isset($course->nextMeeting->start_time)?$course->nextMeeting->start_time:''}}">
    <div class="position-relative">
        <div class="course__details_head"
             style="background-image: url({{asset('/public/frontend/infixlmstheme/img/course_details/header_bg.png')}})">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <p class="location">
                            <span>{{__('virtual-class.Class')}} / {{__('frontend.Class Details')}}</span>
                        </p>
                        <h2 class="title">
                            {{$course->title}}
                        </h2>
                        <ul class="d-flex gap-12 flex-wrap align-items-center category">
                            <li class="category_item"><a href="#">{{@$course->class->category->name}}</a></li>
                            <li class="category_item"><a href="#">{{@$course->class->subCategory->name}}</a></li>
                        </ul>

                        <ul class="d-flex gap-3 flex-wrap align-items-center meta">
                            <li class="meta_item highlight">
                                <img src="{{getProfileImage(@$course->user->image,$course->user->name)}}"
                                     alt="{{@$course->user->name}} image">
                                <p><span>{{__('frontend.By')}} - </span><span>{{@$course->user->name}}</span></p>
                            </li>
                            @if(!Settings('hide_total_enrollment_count') == 1)

                                <li class="meta_item">
                                    <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.2667 0L10.0614 0.0802968L1.8638 3.62012L0 4.41211L1.08536 4.86008V12.2559C0.693844 12.5491 0.429554 13.0842 0.429554 13.7096C0.429554 14.158 0.567742 14.588 0.813717 14.905C1.05969 15.222 1.39331 15.4001 1.74117 15.4001C2.08903 15.4001 2.42265 15.222 2.66862 14.905C2.9146 14.588 3.05278 14.158 3.05278 13.7096C3.05278 13.0842 2.78849 12.5491 2.39698 12.2559V5.44329L3.70859 5.99691V10.3287C3.70859 11.0218 4.0365 11.5966 4.42604 11.9938C4.81559 12.3886 5.29958 12.6675 5.88063 12.9177C7.04403 13.4164 8.57731 13.7096 10.2667 13.7096C11.956 13.7096 13.4893 13.4172 14.6527 12.9168C15.2338 12.6675 15.7177 12.3886 16.1073 11.993C16.4968 11.5966 16.8247 11.0218 16.8247 10.3287V5.99691L18.6695 5.20409L20.5333 4.41211L18.6689 3.61928L10.4713 0.0802968L10.2667 0ZM10.2667 1.77076L16.4149 4.41211L10.2667 7.05345L4.11847 4.41211L10.2667 1.77076ZM5.02021 6.57843L10.0621 8.74392L10.2667 8.82337L10.4719 8.74307L15.5131 6.57759V10.3287C15.5131 10.3372 15.5157 10.4352 15.3079 10.6457C15.1006 10.857 14.7288 11.1232 14.2422 11.3329C13.2703 11.7496 11.8373 12.0192 10.2667 12.0192C8.69601 12.0192 7.26307 11.7504 6.29051 11.332C5.80521 11.1232 5.43271 10.8561 5.22547 10.6457C5.01693 10.4344 5.02021 10.3372 5.02021 10.3287V6.57843Z"
                                            fill="url(#paint0_linear_2677_2458)"/>
                                        <defs>
                                            <linearGradient id="paint0_linear_2677_2458" x1="1.85822" y1="10.3618"
                                                            x2="18.8921" y2="5.18313" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <span> {{$course->total_enrolled}} {{__('frontend.students')}}</span>
                                </li>
                            @endif
                            <li class="meta_item">
                                <svg width="19" height="16" viewBox="0 0 19 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.788 0.580566C6.60781 0.580566 3.20725 3.93037 3.10568 8.10023V8.29301H0.875L4.25488 11.955L7.54071 8.29301H5.0279V8.10023C5.12853 4.99399 7.66861 2.50938 10.788 2.50938C13.9723 2.50938 16.5537 5.09932 16.5537 8.29301C16.5537 11.4867 13.9723 14.0766 10.788 14.0766C9.56025 14.0774 8.36467 13.6841 7.37708 12.9547L6.05484 14.3691C7.40436 15.4298 9.07154 16.0055 10.788 16.0036C15.034 16.0036 18.475 12.5522 18.475 8.29301C18.475 4.03382 15.034 0.580566 10.788 0.580566ZM9.84757 3.59088V8.29301C9.84864 8.54221 9.9476 8.78099 10.1231 8.9579L13.1325 11.9673C13.3986 11.7952 13.6497 11.6014 13.8726 11.3767L11.7284 9.23344V3.59088H9.84757Z"
                                        fill="url(#paint0_linear_2677_2455)"/>
                                    <defs>
                                        <linearGradient id="paint0_linear_2677_2455" x1="2.46776" y1="10.9578" x2="17.4063"
                                                        y2="7.07072" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                            <stop offset="1" stop-color="var(--system_primery_gredient1,#BF37FF)"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <span>{{MinuteFormat($course->class->duration)}}</span>
                            </li>
                            <li class="meta_item">
                                <div class="rating d-flex gap-1">

                                    @php

                                        $main_stars=$course->total_rating;
                                       $stars=intval($main_stars);

                                    @endphp
                                    @for ($i = 0; $i <  $stars; $i++)
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.5337 0.673391C7.95805 -0.224464 9.1848 -0.224464 9.60915 0.673391L11.6306 4.95051L16.151 5.63621C17.1 5.77944 17.4789 6.99866 16.7922 7.69779L13.5209 11.0269L14.2933 15.7266C14.4561 16.7148 13.4634 17.4677 12.6139 17.0013L8.571 14.7813L4.52898 17.0013C3.68028 17.4668 2.68756 16.7148 2.84873 15.7275L3.62113 11.0269L0.35065 7.69689C-0.336023 6.99866 0.0428904 5.78033 0.991887 5.63621L5.51227 4.95051L7.5337 0.673391Z" fill="url(#paint0_linear_2618_3008aa)"/>
                                            <defs>
                                                <linearGradient id="paint0_linear_2618_3008aa" x1="1.55139" y1="11.5344" x2="16.3193" y2="8.1671" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#660AFB"/>
                                                    <stop offset="1" stop-color="#BF37FF"/>
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                    @endfor
                                    @if ($main_stars>$stars)
                                        <img src="{{asset('public/frontend/infixlmstheme/img/svg/half_star.svg')}}" alt="">
                                    @endif
                                    @if($main_stars==0)
                                        @for ($i = 0; $i <  5; $i++)
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.57309 2.43977e-05C8.15989 2.43977e-05 7.74669 0.223819 7.53408 0.674095L5.51265 4.95037L0.992267 5.63608C0.0432706 5.7802 -0.3365 6.99854 0.35103 7.69767L3.62151 11.0268L2.84997 15.7274C2.72138 16.5089 3.31632 17.1436 3.99099 17.1427C4.16931 17.1427 4.35276 17.0989 4.53107 17.0013L8.57224 14.783L12.6143 17.0013C13.463 17.4677 14.4557 16.7148 14.2945 15.7274L13.5212 11.0268L16.7926 7.69767C17.4784 6.99854 17.1003 5.7802 16.1514 5.63608L11.631 4.95037L9.60953 0.674095C9.51527 0.47089 9.36781 0.299726 9.18423 0.180429C9.00065 0.0611318 8.78932 -0.0014181 8.57309 2.43977e-05Z" fill="var(--system_primery_gredient1)" fill-opacity="0.3"/>
                                            </svg>
                                        @endfor
                                    @endif

                                </div>
                                <span>({{$course->total_rating}})</span>


                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- course_details::start  -->
        <div class="course__details position-relative">
            <div class="container">
                <div class="row justify-content-center ">
                    <div class="col-xl-12">

                        <div class="row row-gap-24 ">
{{--                            <div class="{{onlySubscription()?"col-xl-12 col-lg-12 order-2 order-xl-1":"col-xl-8 order-2 order-xl-1"}}">--}}
                            <div class="col-xl-8 order-2 order-xl-1">
                                <div class="bg-white details_shadow mb-0 mb-lg-5">
                                    <div class="course_tabs gradient text-center">
                                        <ul class="nav lms_tabmenu gradient_border justify-content-start" id="class_tabs" role="tablist"
                                        >
                                            <li class="nav-item">
                                                <a class="nav-link active"  data-bs-toggle="tab" id="Overview-tab"
                                                   href="#Overview"
                                                   role="tab" aria-controls="Overview"
                                                   aria-selected="true">{{__('frontend.Overview')}}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"  data-bs-toggle="tab" id="Curriculum-tab"
                                                   href="#Curriculum"
                                                   role="tab" aria-controls="Curriculum"
                                                   aria-selected="false">{{__('frontend.Course Schedule')}}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"  data-bs-toggle="tab" id="Instructor-tab"
                                                   href="#Instructor"
                                                   role="tab" aria-controls="Instructor"
                                                   aria-selected="false">{{__('frontend.Instructor')}}</a>
                                            </li>
                                            @if(Settings('hide_review_section')!='1')
                                                <li class="nav-item">
                                                    <a class="nav-link"  data-bs-toggle="tab" id="Reviews-tab"
                                                       href="#Reviews"
                                                       role="tab" aria-controls="Instructor"
                                                       aria-selected="false">{{__('frontend.Reviews')}}</a>
                                                </li>
                                            @endif
                                            @if(Settings('hide_qa_section')!='1')
                                                <li class="nav-item">
                                                    <a class="nav-link"  data-bs-toggle="tab" id="QA-tab" href="#QASection"
                                                       role="tab" aria-controls="Instructor"
                                                       aria-selected="false">{{__('frontend.QA')}}</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="px-4 lms_tab_content tab-content" role="tabpanel">
                                        <div id="Overview" class="tab-pane fade show active" role="tabpanel"
                                             aria-labelledby="Overview-tab">
                                            <!-- content  -->
                                            @if(isModuleActive('Installment') && $course_price > 0)
                                                @includeIf(theme('partials._installment_plan_details'), ['course' => $course,'position'=>'top_of_page'])
                                            @endif
                                            <div class="course_overview_description">
                                                <div class="row mb_40">
                                                    <div class="col-12">
                                                        <div class="description_grid">

                                                            <div class="single_description_grid">
                                                                <h5> {{__('common.Start Date & Time')}}</h5>
                                                                <p>
                                                                    {{ showDate($course->class->start_date)}}  {{__('common.At')}}
                                                                    {{date('h:i A', strtotime($course->class->time))}}
                                                                </p>
                                                            </div>
                                                            <div class="single_description_grid">
                                                                <h5> {{__('common.End Date & Time')}}</h5>
                                                                <p>{{showDate($course->class->end_date)}} {{__('common.At')}}
                                                                    @php
                                                                        $duration =$course->class->duration??0;

                                                                    @endphp
                                                                    {{date('h:i A', strtotime("+".$duration." minutes", strtotime($course->class->time)))}}
                                                                </p>
                                                            </div>

                                                            <div class="single_description_grid">
                                                                <h5> {{__('common.Duration')}}</h5>
                                                                @php

                                                                    $days =1;
                                                                    if ($course->class->host=="Zoom"){
                                                                        $days=count($course->class->zoomMeetings);
                                                                    }elseif($course->class->host=="BBB"){
                                                                        $days=count($course->class->bbbMeetings);
                                                                    }elseif ($course->class->host=="Jitsi"){
                                                                        $days=count($course->class->jitsiMeetings);
                                                                    }elseif ($course->class->host=="InAppLiveClass"){
                                                                        $days=count($course->class->inAppMeetings);
                                                                    }elseif ($course->class->host=="Custom"){
                                                                        $days=count($course->class->customMeetings);
                                                                    }

                                                                        $str = ($course->class->duration?? 0)*$days;
                                                                        $duration =preg_replace('/[^0-9]/', '', $str);

                                                                @endphp
                                                                <p class="nowrap">{{MinuteFormat($duration)}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="single_overview">
                                                    <h4 class="font_32 f_w_700 mb-40">{{__('frontend.Course Description')}}</h4>
                                                    <div class="theme_border"></div>
                                                    <div class="">
                                                        {!! $course->about !!}
                                                    </div>
                                                    <p class="mb_20">

                                                    </p>
                                                    @if(isModuleActive('Installment') && $course_price > 0)
                                                        @includeIf(theme('partials._installment_plan_details'), ['course' => $course,'position'=>'bottom_of_page'])
                                                    @endif
                                                    @if(!Settings('hide_social_share_btn') =='1')
                                                        <div class="social_btns">
                                                            <a target="_blank"
                                                               href="https://www.facebook.com/sharer/sharer.php?u={{URL::current()}}"
                                                               class="social_btn fb_bg"> <i class="fab fa-facebook-f"></i>
                                                                {{__('frontend.Facebook')}}</a>
                                                            <a target="_blank"
                                                               href="https://twitter.com/intent/tweet?text={{$course->title}}&amp;url={{URL::current()}}"
                                                               class="social_btn Twitter_bg"> <i
                                                                    class="fab fa-twitter"></i> {{__('frontend.Twitter')}}
                                                            </a>
                                                            <a target="_blank"
                                                               href="https://pinterest.com/pin/create/link/?url={{URL::current()}}&amp;description={{$course->title}}"
                                                               class="social_btn Pinterest_bg"> <i
                                                                    class="fab fa-pinterest-p"></i> {{__('frontend.Pinterest')}}
                                                            </a>
                                                            <a target="_blank"
                                                               href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{URL::current()}}&amp;title={{$course->title}}&amp;summary={{$course->title}}"
                                                               class="social_btn Linkedin_bg"> <i
                                                                    class="fab fa-linkedin-in"></i> {{__('frontend.Linkedin')}}
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!--/ content  -->
                                        </div>
                                        <div id="Curriculum" class="tab-pane fade " role="tabpanel"
                                             aria-labelledby="Curriculum-tab">
                                            <!-- content  -->
                                            <h4 class="font_32 f_w_700 mb-40">{{__('frontend.Course Schedule')}}</h4>

                                            <div class="single_description mb_25">


                                                @if($course->class->host=="BBB")
                                                    @foreach($course->class->bbbMeetings as $key=>$meeting)
                                                        <div class="row justify-content-between text-center p-3 m-2"
                                                             style="border:1px solid #E1E2E6">
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto "
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                        <span>
                                                      {{__('common.Start Date')}}
                                                    </span>

                                                                <h6 class="mb-0">{{date('d M Y',$meeting->datetime)}}  </h6>
                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                         <span>
                                                       {{__('common.Time')}} <br>
                                                             ({{__('common.Start')}} - {{__('common.End')}})
                                                    </span>
                                                                <h6 class="mb-0">{{date('g:i A',$meeting->datetime)}}
                                                                    - @if($meeting->duration==0)
                                                                        N/A
                                                                    @else
                                                                        {{date('g:i A',$meeting->datetime+($meeting->duration*60))}}
                                                                    @endif</h6>

                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                        <span>
                                                       {{__('common.Duration')}}
                                                    </span>
                                                                @php

                                                                    $str = $meeting->duration?? 0;
                                                                    $duration =preg_replace('/[^0-9]/', '', $str);

                                                                @endphp
                                                                <h6 class="mb-0 nowrap">{{MinuteFormat($duration)}}</h6>
                                                            </div>


                                                            @if (Auth::check() &&  $isEnrolled)

                                                                <div class="col-sm-3 margin_auto">

                                                                    @if(@$meeting->isRunning())
                                                                        <a target="_blank"
                                                                           href="{{route('classStart', [$course->slug,'BBB',$meeting->id])}}"
                                                                           class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                            {{__('common.Watch Now')}}
                                                                        </a>

                                                                    @else

                                                                        @php
                                                                            $last_time = Illuminate\Support\Carbon::parse($meeting->date. ' ' . $meeting->time);
                                                                           $nowDate = Illuminate\Support\Carbon::now();
                                                                           $isWaiting = $last_time->gt($nowDate);

                                                                        @endphp
                                                                        @if($isWaiting)
                                                                            <span
                                                                                class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                    {{__('frontend.Waiting')}}
                                                                </span>
                                                                        @else
                                                                            <span
                                                                                class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                    {{__('frontend.Closed')}}
                                                                </span>
                                                                        @endif

                                                                    @endif
                                                                </div>
                                                            @endif


                                                        </div>
                                                    @endforeach

                                                @elseif($course->class->host=="Jitsi")

                                                    @foreach($course->class->jitsiMeetings as $key=>$meeting)
                                                        <div class="row justify-content-between text-center p-3 m-2"
                                                             style="border:1px solid #E1E2E6">
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                        <span>
                                                        {{__('common.Start Date')}}
                                                    </span>

                                                                <h6 class="mb-0">{{date('d M Y',$meeting->datetime)}}  </h6>
                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                         <span>
                                                        {{__('common.Time')}} <br>
                                                             ({{__('common.Start')}} - {{__('common.End')}})
                                                    </span>
                                                                <h6 class="mb-0">{{date('g:i A',$meeting->datetime)}}
                                                                    - @if($meeting->duration==0)
                                                                        N/A
                                                                    @else
                                                                        {{date('g:i A',$meeting->datetime+($meeting->duration*60))}}
                                                                    @endif</h6>

                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                        <span>
                                                       {{__('common.Duration')}}
                                                    </span>
                                                                @php
                                                                    $str = $meeting->duration?? 0;
                                                                    $duration =preg_replace('/[^0-9]/', '', $str);

                                                                @endphp
                                                                <h6 class="mb-0 nowrap">{{MinuteFormat($duration)}}</h6>
                                                            </div>


                                                            @if (Auth::check() &&  $isEnrolled)

                                                                <div class="col-sm-3 margin_auto">
                                                                    @php
                                                                        $start = \Illuminate\Support\Carbon::parse($meeting->date . ' ' .$meeting->time);
                                                                         $nowDate = \Illuminate\Support\Carbon::now();
                                                                         $not_start = $start->gt($nowDate);
                                                                         $end =$start->addMinutes((int)$meeting->duration);
                                                                         $not_end =$end->gt($nowDate);
                                                                    @endphp
                                                                    @if(!$not_start && $not_end)

                                                                        <a target="_blank"
                                                                           href="{{route('classStart', [$course->slug,'Jitsi',$meeting->id])}}"
                                                                           class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                            {{__('common.Watch Now')}}
                                                                        </a>

                                                                    @else

                                                                        @php
                                                                            $last_time = Illuminate\Support\Carbon::parse($meeting->date. ' ' . $meeting->time);
                                                                           $nowDate = Illuminate\Support\Carbon::now();
                                                                           $isWaiting = $last_time->gt($nowDate);

                                                                        @endphp
                                                                        @if($isWaiting)
                                                                            <span
                                                                                class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                    {{__('frontend.Waiting')}}
                                                                </span>
                                                                        @else
                                                                            <span
                                                                                class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                    {{__('frontend.Closed')}}
                                                                </span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            @endif


                                                        </div>
                                                    @endforeach

                                                @elseif($course->class->host=="Custom")

                                                    @foreach($course->class->customMeetings as $key=>$meeting)
                                                        <div class="row justify-content-between text-center p-3 m-2"
                                                             style="border:1px solid #E1E2E6">
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                        <span>
                                                        {{__('common.Start Date')}}
                                                    </span>

                                                                <h6 class="mb-0">{{date('d M Y',$meeting->datetime)}}  </h6>
                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                         <span>
                                                        {{__('common.Time')}} <br>
                                                             ({{__('common.Start')}} - {{__('common.End')}})
                                                    </span>
                                                                <h6 class="mb-0">{{date('g:i A',$meeting->datetime)}}
                                                                    - @if($meeting->duration==0)
                                                                        N/A
                                                                    @else
                                                                        {{date('g:i A',$meeting->datetime+($meeting->duration*60))}}
                                                                    @endif</h6>

                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                        <span>
                                                       {{__('common.Duration')}}
                                                    </span>
                                                                @php
                                                                    $str = $meeting->duration?? 0;
                                                                    $duration =preg_replace('/[^0-9]/', '', $str);

                                                                @endphp
                                                                <h6 class="mb-0 nowrap">{{MinuteFormat($duration)}}</h6>
                                                            </div>


                                                            @if (Auth::check() &&  $isEnrolled)

                                                                <div class="col-sm-3 margin_auto">
                                                                    @php
                                                                        $start = \Illuminate\Support\Carbon::parse($meeting->date . ' ' .$meeting->time);
                                                                         $nowDate = \Illuminate\Support\Carbon::now();
                                                                         $not_start = $start->gt($nowDate);
                                                                         $end =$start->addMinutes((int)$meeting->duration);
                                                                         $not_end =$end->gt($nowDate);
                                                                    @endphp
                                                                    @if(!$not_start && $not_end && !empty($meeting->link))

                                                                        <a target="_blank"
                                                                           href="{{route('classStart', [$course->slug,'Custom',$meeting->id])}}"
                                                                           class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                            {{__('common.Watch Now')}}
                                                                        </a>

                                                                    @else

                                                                        @php
                                                                            $last_time = Illuminate\Support\Carbon::parse($meeting->date. ' ' . $meeting->time);
                                                                           $nowDate = Illuminate\Support\Carbon::now();
                                                                           $isWaiting = $last_time->gt($nowDate);

                                                                        @endphp
                                                                        @if($isWaiting)
                                                                            <span
                                                                                class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                    {{__('frontend.Waiting')}}
                                                                </span>
                                                                        @else
                                                                            <span
                                                                                class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                    {{__('frontend.Closed')}}
                                                                </span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            @endif


                                                        </div>
                                                    @endforeach
                                                @elseif($course->class->host=="InAppLiveClass")

                                                    @foreach($course->class->inAppMeetings as $key=>$meeting)
                                                        <div class="row justify-content-between text-center p-3 m-2"
                                                             style="border:1px solid #E1E2E6">
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                        <span>
                                                        {{__('common.Start Date')}}
                                                    </span>

                                                                <h6 class="mb-0">{{date('d M Y',$meeting->datetime)}}  </h6>
                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                         <span>
                                                        {{__('common.Time')}} <br>
                                                             ({{__('common.Start')}} - {{__('common.End')}})
                                                    </span>
                                                                <h6 class="mb-0">{{date('g:i A',$meeting->datetime)}}
                                                                    - @if($meeting->duration==0)
                                                                        N/A
                                                                    @else
                                                                        {{date('g:i A',$meeting->datetime+($meeting->duration*60))}}
                                                                    @endif</h6>

                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                        <span>
                                                       {{__('common.Duration')}}
                                                    </span>
                                                                @php
                                                                    $str = $meeting->duration?? 0;
                                                                    $duration =preg_replace('/[^0-9]/', '', $str);

                                                                @endphp
                                                                <h6 class="mb-0 nowrap">{{MinuteFormat($duration)}}</h6>
                                                            </div>


                                                            @if (Auth::check() &&  $isEnrolled)

                                                                <div class="col-sm-3 margin_auto">
                                                                    @php
                                                                        $start = \Illuminate\Support\Carbon::parse($meeting->date . ' ' .$meeting->time);
                                                                         $nowDate = \Illuminate\Support\Carbon::now();
                                                                         $not_start = $start->gt($nowDate);
                                                                         $end =$start->addMinutes((int)$meeting->duration);
                                                                         $not_end =$end->gt($nowDate);
                                                                    @endphp
                                                                    @if(!$not_start && $not_end)

                                                                        <a target="_blank"
                                                                           href="{{route('classStart', [$course->slug,'InAppLiveClass',$meeting->id])}}"
                                                                           class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                            {{__('common.Watch Now')}}
                                                                        </a>

                                                                    @else

                                                                        @php
                                                                            $last_time = Illuminate\Support\Carbon::parse($meeting->date. ' ' . $meeting->time);
                                                                           $nowDate = Illuminate\Support\Carbon::now();
                                                                           $isWaiting = $last_time->gt($nowDate);

                                                                        @endphp
                                                                        @if($isWaiting)
                                                                            <span
                                                                                class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                    {{__('frontend.Waiting')}}
                                                                </span>
                                                                        @else
                                                                            <span
                                                                                class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                    {{__('frontend.Closed')}}
                                                                </span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            @endif


                                                        </div>
                                                    @endforeach

                                                @elseif($course->class->host=="Zoom")
                                                    @foreach($course->class->zoomMeetings as $key=>$meeting)

                                                        <div class="row justify-content-between text-center p-3 m-2"
                                                             style="border:1px solid #E1E2E6">
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                        <span>
                                                     {{__('common.Start Date')}}
                                                    </span>

                                                                <h6 class="mb-0">{{date('d M Y',strtotime($meeting->start_time))}}  </h6>
                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                         <span>
                                                       {{__('common.Time')}} <br>
                                                             ({{__('common.Start')}} - {{__('common.End')}})
                                                    </span>
                                                                <h6 class="mb-0">{{date('g:i A',strtotime($meeting->start_time))}}
                                                                    -{{date('g:i A',strtotime($meeting->end_time))}}</h6>


                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                        <span>
                                                       {{__('common.Duration')}}
                                                    </span>
                                                                @php

                                                                    $str = $meeting->meeting_duration?? 0;
                                                                    $duration =preg_replace('/[^0-9]/', '', $str);


                                                                @endphp
                                                                <h6 class="mb-0 nowrap">{{MinuteFormat($duration)}}</h6>
                                                            </div>


                                                            @if (Auth::check() &&  $isEnrolled)
                                                                <div class="col-sm-3 margin_auto">
                                                                    @if(@$meeting->currentStatus=="started")
                                                                        <a target="_blank"
                                                                           href="{{route('classStart', [$course->slug,'Zoom',$meeting->id])}}"
                                                                           class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                            {{__('common.Watch Now')}}
                                                                        </a>
                                                                    @elseif (@$meeting->currentStatus== 'waiting')
                                                                        <span
                                                                            class="theme_line_btn  small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Waiting')}}
                                                               </span>
                                                                    @else
                                                                        <span
                                                                            class="theme_line_btn  small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Closed')}}
                                                                </span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach

                                                @elseif($course->class->host=="GoogleMeet")
                                                    @foreach($course->class->googleMeetMeetings as $key=>$meeting)

                                                        <div class="row justify-content-between text-center p-3 m-2"
                                                             style="border:1px solid #E1E2E6">
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                    <span>
                                                 {{__('common.Start Date')}}
                                                </span>

                                                                <h6 class="mb-0">{{date('d M Y',strtotime($meeting->start_date_time))}}  </h6>
                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="border-right: 1px solid #E1E2E6;">
                                                     <span>
                                                   {{__('common.Time')}} <br>
                                                         ({{__('common.Start')}} - {{__('common.End')}})
                                                </span>
                                                                <h6 class="mb-0">{{date('g:i A',strtotime($meeting->start_date_time))}}
                                                                    -{{date('g:i A',strtotime($meeting->end_date_time))}}</h6>


                                                            </div>
                                                            <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                                 style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                    <span>
                                                   {{__('common.Duration')}}
                                                </span>

                                                                <h6 class="mb-0 nowrap">{{MinuteFormat(\Carbon\Carbon::parse($meeting->start_date_time)->diffInMinutes($meeting->end_date_time))}}</h6>
                                                            </div>


                                                            @if (Auth::check() &&  $isEnrolled)
                                                                <div class="col-sm-3 margin_auto">
                                                                    @if(@$meeting->currentStatus=="started")
                                                                        <a target="_blank"
                                                                           href="{{route('classStart', [$course->slug,'GoogleMeet',$meeting->id])}}"
                                                                           class="theme_btn small_btn2 d-block text-center height_50   p-3  mt-3">
                                                                            {{__('common.Watch Now')}}
                                                                        </a>
                                                                    @elseif (@$meeting->currentStatus== 'waiting')
                                                                        <span
                                                                            class="theme_line_btn  small_btn2 d-block text-center height_50   p-3 ">
                                                                {{__('frontend.Waiting')}}
                                                           </span>
                                                                    @else
                                                                        <span
                                                                            class="theme_line_btn  small_btn2 d-block text-center height_50   p-3 ">
                                                                {{__('frontend.Closed')}}
                                                            </span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach

                                                @endif
                                            </div>

                                        </div>
                                        <div id="Instructor" class="tab-pane fade " role="tabpanel"
                                             aria-labelledby="Instructor-tab">
                                            <div class="instractor_details_wrapper">
                                                <div class="instractor_title">
                                                    <h4 class="font_32 f_w_700 mb-40">{{__('frontend.Instructor')}}</h4>
                                                    {{--<p class="font_16 f_w_400">{{@$course->user->headline}}</p>--}}
                                                </div>
                                                <div class="instructor_box">
                                                    <div class="instractor_details_inner row">
                                                        <div class="d-flex col-md-8 gap-20">
                                                            <div class="thumb">
                                                                <img class="w-100"
                                                                     src="{{getProfileImage(@$course->user->image,$course->user->name)}}"
                                                                     alt="">
                                                            </div>
                                                            <div class="instractor_details_info">
                                                                <a href="{{route('instructorDetails',[$course->user->id,$course->user->name])}}">
                                                                    <h4 class="font_32 f_w_700 mb-40">{{@$course->user->name}}</h4>
                                                                </a>
                                                                {{--<h5>  {{@$course->user->headline}}</h5>--}}
                                                                <div class="ins_details">
                                                                    {{--<p>
                                                                        {!! @$course->user->short_details !!}

                                                                    </p>--}}
                                                                    <p class="about_instructor">
                                                                        {!!@$course->user->about!!}                           </p>
                                                                    <ul class="social_links d-flex">
                                                                        <li class="facebook"><a href="#"><i
                                                                                    class="fab fa-facebook-f"></i></a></li>
                                                                        <li class="twitter"><a href="#"><i
                                                                                    class="fab fa-twitter"></i></a></li>
                                                                        <li class="youtube"><a href="#"><i
                                                                                    class="fab fa-youtube"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="intractor_qualification">
                                                                <div class="single_qualification">
                                                                    <svg width="23" height="21" viewBox="0 0 23 21"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M15.14 10.3776C17.2625 10.3776 18.9831 8.657 18.9831 6.53451C18.9831 4.41202 17.2625 2.69141 15.14 2.69141C13.0175 2.69141 11.2969 4.41202 11.2969 6.53451C11.2969 8.657 13.0175 10.3776 15.14 10.3776Z"
                                                                            fill="#D7E0FF"/>
                                                                        <path
                                                                            d="M15.1406 10.3778C17.2631 10.3778 18.9837 8.65715 18.9837 6.53466C18.9837 4.89279 17.9541 3.4914 16.5054 2.94092"
                                                                            stroke="url(#paint0_linear_0_1aa)"
                                                                            stroke-width="1.71429" stroke-linecap="round"
                                                                            stroke-linejoin="round"/>
                                                                        <path
                                                                            d="M8.67371 9.61596C10.9745 9.61596 12.8396 7.75083 12.8396 5.45008C12.8396 3.14931 10.9745 1.28418 8.67371 1.28418C6.37295 1.28418 4.50781 3.14931 4.50781 5.45008C4.50781 7.75083 6.37295 9.61596 8.67371 9.61596Z"
                                                                            fill="#D7E0FF" stroke="url(#paint1_linear_0_1zz)"
                                                                            stroke-width="1.71429" stroke-linecap="round"
                                                                            stroke-linejoin="round"/>
                                                                        <path
                                                                            d="M15.051 15.4688C17.0888 16.826 15.7128 19.4436 13.2644 19.4436H4.07015C1.62181 19.4436 0.245821 16.826 2.28356 15.4688C4.11139 14.2515 6.30648 13.542 8.66729 13.542C11.0281 13.542 13.2232 14.2515 15.051 15.4688Z"
                                                                            fill="#D7E0FF" stroke="url(#paint2_linear_0_1e4)"
                                                                            stroke-width="1.71429"/>
                                                                        <path
                                                                            d="M12.9062 19.4433H18.7338C20.9925 19.4433 22.2618 17.0286 20.3819 15.7764C19.8629 15.4307 19.3116 15.1294 18.7338 14.8779"
                                                                            stroke="url(#paint3_linear_0_122)"
                                                                            stroke-width="1.71429" stroke-linecap="round"/>
                                                                        <defs>
                                                                            <linearGradient id="paint0_linear_0_1aa"
                                                                                            x1="15.4884" y1="7.94473"
                                                                                            x2="18.9235" y2="7.53997"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                <stop stop-color="#660AFB"/>
                                                                                <stop offset="1" stop-color="#BF37FF"/>
                                                                            </linearGradient>
                                                                            <linearGradient id="paint1_linear_0_1zz"
                                                                                            x1="5.26182" y1="6.89013"
                                                                                            x2="12.4393" y2="5.25353"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                <stop stop-color="#660AFB"/>
                                                                                <stop offset="1" stop-color="#BF37FF"/>
                                                                            </linearGradient>
                                                                            <linearGradient id="paint2_linear_0_1e4"
                                                                                            x1="2.63089" y1="17.5128"
                                                                                            x2="12.7179" y2="11.768"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                <stop stop-color="#660AFB"/>
                                                                                <stop offset="1" stop-color="#BF37FF"/>
                                                                            </linearGradient>
                                                                            <linearGradient id="paint3_linear_0_122"
                                                                                            x1="13.6652" y1="17.9497"
                                                                                            x2="20.1307" y2="15.2417"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                <stop stop-color="#660AFB"/>
                                                                                <stop offset="1" stop-color="#BF37FF"/>
                                                                            </linearGradient>
                                                                        </defs>
                                                                    </svg>
                                                                    {{@$course->user->totalRating()['rating']}}
                                                                    {{__('frontend.Rating')}}
                                                                </div>
                                                                <div class="single_qualification">
                                                                    <svg width="22" height="21" viewBox="0 0 22 21"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M9.3186 2.31937C10.0297 0.598114 12.4126 0.542313 13.1271 2.26214C13.6219 3.45293 13.9994 4.67916 14.3796 6.28135C16.0597 6.26422 17.3732 6.30055 18.6987 6.41968C20.5624 6.58716 21.3145 8.85334 19.8637 10.035C19.0436 10.7029 18.163 11.3206 17.0592 12.0134C16.7485 12.2084 16.6087 12.5899 16.7214 12.939C17.2365 14.5362 17.5844 15.8327 17.855 17.1929C18.2151 19.0017 16.3096 20.3818 14.7608 19.3802C13.5734 18.6124 12.4947 17.7285 11.1672 16.4676C9.85163 17.6787 8.77826 18.538 7.60447 19.301C6.04677 20.3139 4.10022 18.9486 4.46185 17.1261C4.72325 15.8089 5.07174 14.5276 5.6021 12.9465C5.72027 12.5942 5.58046 12.206 5.26518 12.0093C4.12785 11.2999 3.22459 10.6679 2.37715 9.97143C0.949662 8.79827 1.67841 6.56216 3.51828 6.39216C4.86482 6.26772 6.20934 6.24133 7.95477 6.28135C8.41435 4.71806 8.82696 3.50942 9.3186 2.31937Z"
                                                                            fill="#D7E0FF"
                                                                            stroke="url(#paint0_linear_2677_2575)"
                                                                            stroke-width="1.71429" stroke-linejoin="round"/>
                                                                        <defs>
                                                                            <linearGradient id="paint0_linear_2677_2575"
                                                                                            x1="3.34446" y1="13.5936"
                                                                                            x2="19.6876" y2="9.81077"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                <stop stop-color="#660AFB"/>
                                                                                <stop offset="1" stop-color="#BF37FF"/>
                                                                            </linearGradient>
                                                                        </defs>
                                                                    </svg> {{@$course->user->totalRating()['total']}}
                                                                    {{__('frontend.Reviews')}}
                                                                </div>
                                                                <div class="single_qualification">
                                                                    <svg width="23" height="22" viewBox="0 0 23 22"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M6.65309 2.41194C8.19469 1.48854 9.9579 1.00056 11.7549 1C13.25 0.999121 14.7261 1.33571 16.073 1.98469C17.4199 2.63367 18.603 3.57829 19.534 4.74816C20.465 5.91802 21.12 7.28294 21.4501 8.74115C21.7802 10.1994 21.777 11.7133 21.4405 13.1701C21.104 14.6269 20.4431 15.9889 19.5069 17.1546C18.5709 18.3205 17.3837 19.2599 16.0339 19.9031C14.6842 20.5462 13.2067 20.8763 11.7116 20.8688C10.4637 20.8627 9.23047 20.6215 8.07569 20.1603L2.64574 21.0643C2.03905 21.1655 1.54314 20.584 1.73854 20.0009L3.12761 15.8549C2.35386 14.4978 1.90944 12.9742 1.83477 11.4073C1.74925 9.61234 2.1522 7.82778 3.0007 6.2437C3.84919 4.65962 5.11146 3.33535 6.65309 2.41194Z"
                                                                            fill="#D7E0FF" stroke="url(#paint0_linear_0_1bb)"
                                                                            stroke-width="1.71429" stroke-linecap="round"
                                                                            stroke-linejoin="round"/>
                                                                        <path d="M7.92969 8.69727H15.8809"
                                                                              stroke="url(#paint1_linear_0_1xx)"
                                                                              stroke-width="1.71429" stroke-linecap="round"
                                                                              stroke-linejoin="round"/>
                                                                        <path d="M7.92969 13.5903H13.9441"
                                                                              stroke="url(#paint2_linear_0_1e42)"
                                                                              stroke-width="1.71429" stroke-linecap="round"
                                                                              stroke-linejoin="round"/>
                                                                        <defs>
                                                                            <linearGradient id="paint0_linear_0_1bb"
                                                                                            x1="3.50527" y1="14.5078"
                                                                                            x2="20.7409" y2="10.5927"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                <stop stop-color="#660AFB"/>
                                                                                <stop offset="1" stop-color="#BF37FF"/>
                                                                            </linearGradient>
                                                                            <linearGradient id="paint1_linear_0_1xx"
                                                                                            x1="8.64925" y1="9.37011"
                                                                                            x2="10.3301" y2="6.32273"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                <stop stop-color="#660AFB"/>
                                                                                <stop offset="1" stop-color="#BF37FF"/>
                                                                            </linearGradient>
                                                                            <linearGradient id="paint2_linear_0_1e42"
                                                                                            x1="8.47397" y1="14.2632"
                                                                                            x2="10.3661" y2="11.6684"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                <stop stop-color="#660AFB"/>
                                                                                <stop offset="1" stop-color="#BF37FF"/>
                                                                            </linearGradient>
                                                                        </defs>
                                                                    </svg>

                                                                    {{@$course->user->totalEnrolled()}}
                                                                    {{__('frontend.Students')}}
                                                                </div>
                                                                <div class="single_qualification">
                                                                    <svg width="23" height="21" viewBox="0 0 23 21"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M1.84341 13.1702C1.96522 13.9848 2.67115 14.5926 3.49448 14.568C6.01744 14.4925 8.58767 14.3954 11.2812 14.3954C13.9643 14.3954 16.535 14.4562 19.0433 14.5496C19.8771 14.5806 20.5993 13.9702 20.7229 13.1452C20.9811 11.4208 21.2812 9.62412 21.2812 7.77812C21.2812 5.93858 20.9832 4.14804 20.7256 2.42912C20.6008 1.59663 19.8667 0.984501 19.0257 1.01983C16.5459 1.12397 13.9517 1.16088 11.2812 1.16088C8.59999 1.16088 6.00551 1.08823 3.51154 1.001C2.68103 0.971941 1.96383 1.58152 1.84082 2.40338C1.58237 4.13016 1.28125 5.9294 1.28125 7.77812C1.28125 9.63303 1.58439 11.4381 1.84341 13.1702Z"
                                                                            fill="#D7E0FF" stroke="url(#paint0_linear_0_1cc)"
                                                                            stroke-width="1.71429"/>
                                                                        <path d="M7.29688 19.2856H15.2702"
                                                                              stroke="url(#paint1_linear_0_1yy)"
                                                                              stroke-width="1.71429"
                                                                              stroke-linecap="round"/>
                                                                        <path d="M11.2812 14.3994V19.2852"
                                                                              stroke="url(#paint2_linear_0_1e421)"
                                                                              stroke-width="1.71429"
                                                                              stroke-linecap="round"/>
                                                                        <defs>
                                                                            <linearGradient id="paint0_linear_0_1cc"
                                                                                            x1="3.0912" y1="10.1296"
                                                                                            x2="19.3766" y2="4.65615"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                <stop stop-color="#660AFB"/>
                                                                                <stop offset="1" stop-color="#BF37FF"/>
                                                                            </linearGradient>
                                                                            <linearGradient id="paint1_linear_0_1yy"
                                                                                            x1="8.01844" y1="19.9585"
                                                                                            x2="9.69678" y2="16.9072"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                <stop stop-color="#660AFB"/>
                                                                                <stop offset="1" stop-color="#BF37FF"/>
                                                                            </linearGradient>
                                                                            <linearGradient id="paint2_linear_0_1e421"
                                                                                            x1="11.3717" y1="17.6868"
                                                                                            x2="12.276" y2="17.6446"
                                                                                            gradientUnits="userSpaceOnUse">
                                                                                <stop stop-color="#660AFB"/>
                                                                                <stop offset="1" stop-color="#BF37FF"/>
                                                                            </linearGradient>
                                                                        </defs>
                                                                    </svg>
                                                                    {{@$course->user->totalCourses()}}
                                                                    {{__('frontend.Courses')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="Reviews" class="tab-pane fade " role="tabpanel"
                                             aria-labelledby="Reviews-tab">
                                            <!-- content  -->
                                            <div class="course_review_wrapper">
                                                <div class="details_title">
                                                    <h4 class="font_32 f_w_700 mb-40">{{__('frontend.Student Feedback')}}</h4>
                                                    {{--<p class="font_16 f_w_400">{{$course->title}}</p>--}}
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

                                                <div class="course_review_header mb_20">
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
                                                                            class="theme_color2">Sign
                                                                            In</a>
                                                                        or <a
                                                                            class="theme_color2" href="{{url('register')}}">Sign
                                                                            Up</a>
                                                                        as student to post a review</p>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="course_cutomer_reviews">
                                                    <div class="details_title">
                                                        <h4 class="font_32 f_w_700 mb-40">{{__('frontend.Reviews')}}</h4>

                                                    </div>
                                                    <div class="customers_reviews" id="customers_reviews">


                                                    </div>
                                                </div>

                                                <div class="author_courses">
                                                    <div class="details_title">
                                                        <h4 class="font_32 f_w_700 mb-40">{{__('frontend.Course you might like')}}</h4>
                                                    </div>
                                                    <div class="row row-gap-24">
                                                        @foreach(@$related as $r)
                                                            <div class="col-xl-6">
                                                                <div class="course-item">
                                                                    <a href="{{courseDetailsUrl(@$r->id,@$r->type,@$r->slug)}}">
                                                                        <div class="course-item-img lazy">
                                                                            <img class="w-100"
                                                                                 src="{{ file_exists($r->thumbnail) ? asset($r->thumbnail) : asset('public/\uploads/course_sample.png') }}"
                                                                                 alt="">

                                                                            @if($r->level)
                                                                                <span class="course-tag">
                                                                            <span>
                                                                                {{$r->courseLevel->title}}
                                                                            </span>
                                                                        </span>
                                                                            @endif
                                                                        </div>
                                                                    </a>
                                                                    <div class="course-item-info">
                                                                        <a href="{{courseDetailsUrl(@$r->id,@$r->type,@$r->slug)}}" class="title">
                                                                            {{@$r->title}}
                                                                        </a>
                                                                        <div class="d-flex align-itemes-center justify-content-between meta">
                                                                            <div class="rating">
                                                                                <svg width="16" height="15"
                                                                                     viewBox="0 0 16 15" fill="none"
                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                    <path
                                                                                        d="M14.9922 5.21624L10.2573 4.53056L8.1344 0.242104C8.09105 0.168678 8.02784 0.10754 7.9513 0.0649862C7.87476 0.0224321 7.78764 0 7.69892 0C7.6102 0 7.52308 0.0224321 7.44654 0.0649862C7.37 0.10754 7.3068 0.168678 7.26345 0.242104L5.14222 4.52977L0.40648 5.21624C0.31946 5.22916 0.237852 5.2645 0.170564 5.31841C0.103275 5.37231 0.0528901 5.44272 0.0249085 5.52194C-0.00307309 5.60116 -0.00757644 5.68614 0.01189 5.76762C0.0313563 5.8491 0.0740445 5.92394 0.135295 5.98398L3.57501 9.33111L2.76146 14.0591C2.74696 14.1436 2.75782 14.2304 2.79281 14.3094C2.8278 14.3883 2.88549 14.4564 2.95932 14.5058C3.03314 14.5551 3.12011 14.5838 3.2103 14.5886C3.30049 14.5933 3.39026 14.5739 3.46936 14.5325L7.6985 12.3153L11.9276 14.5333C12.0068 14.5746 12.0965 14.5941 12.1867 14.5893C12.2769 14.5846 12.3639 14.5559 12.4377 14.5066C12.5115 14.4572 12.5692 14.3891 12.6042 14.3101C12.6392 14.2311 12.6501 14.1444 12.6356 14.0599L11.822 9.3319L15.2634 5.98398C15.3253 5.92392 15.3685 5.84885 15.3883 5.76699C15.4082 5.68515 15.4039 5.59969 15.3758 5.52003C15.3478 5.44036 15.2972 5.36956 15.2295 5.31541C15.1618 5.26126 15.0797 5.22586 14.9922 5.21308V5.21624Z"
                                                                                        fill="#FFC107"/>
                                                                                </svg>
                                                                                <span>{{$r->totalReview}}  ({{translatedNumber($r->total_reviews)}} {{__('common.Rating')}})</span>
                                                                            </div>
                                                                            <div class="enrolled-student">
                                                                                @if(!Settings('hide_total_enrollment_count') == 1)
                                                                                    <a href="#">
                                                                                        <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                            <path d="M14.2508 3.87484L9.30078 1.0165C8.49245 0.549837 7.49245 0.549837 6.67578 1.0165L1.73411 3.87484C0.925781 4.3415 0.425781 5.20817 0.425781 6.14984V11.8498C0.425781 12.7832 0.925781 13.6498 1.73411 14.1248L6.68411 16.9832C7.49245 17.4498 8.49245 17.4498 9.30911 16.9832L14.2591 14.1248C15.0674 13.6582 15.5674 12.7915 15.5674 11.8498V6.14984C15.5591 5.20817 15.0591 4.34984 14.2508 3.87484ZM7.99245 5.1165C9.06745 5.1165 9.93411 5.98317 9.93411 7.05817C9.93411 8.13317 9.06745 8.99984 7.99245 8.99984C6.91745 8.99984 6.05078 8.13317 6.05078 7.05817C6.05078 5.9915 6.91745 5.1165 7.99245 5.1165ZM10.2258 12.8832H5.75911C5.08411 12.8832 4.69245 12.1332 5.06745 11.5748C5.63411 10.7332 6.73411 10.1665 7.99245 10.1665C9.25078 10.1665 10.3508 10.7332 10.9174 11.5748C11.2924 12.1248 10.8924 12.8832 10.2258 12.8832Z"
                                                                                                  fill="#292D32"/>
                                                                                        </svg> {{$r->total_enrolled}}
                                                                                        {{__('frontend.Students')}} </a>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="course-item-info-description">
                                                                            {{ getLimitedText($r->about,120) }}
                                                                        </div>
                                                                        <div class="course-item-footer d-flex justify-content-between">
                                                                            <x-price-tag :price="$r->price"
                                                                                         :text="$r->price_text"
                                                                                         :discount="$r->discount_price"/>

                                                                            @if(!onlySubscription())
                                                                                @auth()
                                                                                    @if(!$r->isLoginUserEnrolled && !$r->isLoginUserCart)
                                                                                        <a href="#" class="cart_store"
                                                                                           data-id="{{$r->id}}">
                                                                                            <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                <path d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z" fill="url(#paint0_linear_2677_320861513121111)"/>
                                                                                                <path d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z" fill="url(#paint1_linear_2677_320862523222122)"/>
                                                                                                <path d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z" fill="url(#paint2_linear_2677_320863533323133)"/>
                                                                                                <defs>
                                                                                                    <linearGradient id="paint0_linear_2677_320861513121111" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                                    </linearGradient>
                                                                                                    <linearGradient id="paint1_linear_2677_320862523222122" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                                        <stop stop-color="#660AFB"/>
                                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                                    </linearGradient>
                                                                                                    <linearGradient id="paint2_linear_2677_320863533323133" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                                        <stop stop-color="#660AFB"/>
                                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
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
                                                                                            <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                <path d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z" fill="url(#paint0_linear_2677_320861513121)"/>
                                                                                                <path d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z" fill="url(#paint1_linear_2677_320862523222)"/>
                                                                                                <path d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z" fill="url(#paint2_linear_2677_320863533323)"/>
                                                                                                <defs>
                                                                                                    <linearGradient id="paint0_linear_2677_320861513121" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                                    </linearGradient>
                                                                                                    <linearGradient id="paint1_linear_2677_320862523222" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                                        <stop stop-color="#660AFB"/>
                                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                                    </linearGradient>
                                                                                                    <linearGradient id="paint2_linear_2677_320863533323" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                                        <stop stop-color="#660AFB"/>
                                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
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

                                        <div id="QASection" class="tab-pane fade " role="tabpanel" aria-labelledby="QA-tab">
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
                                    <div class="students_also_bought">
                                        <h4 class="font_40 f_w_700 mb_20">
                                            {{__("frontend.Students also bought")}}
                                        </h4>
                                        @foreach($others as $o)
                                            <div class="single_related_product">
                                                <div class="row g-0">
                                                    <div class="col-lg-7">
                                                        <div class="d-flex gap-2 left">
                                                            <img
                                                                src="{{getCourseImage($o->image)}}"
                                                                class="thumb" alt="">
                                                            <div>
                                                                <h5 class="title">
                                                                    <a href="{{courseDetailsUrl(@$o->id,@$o->type,@$o->slug)}}">
                                                                        {{$o->title}}
                                                                    </a>
                                                                </h5>

                                                                <div class="d-flex gap-2 flex-wrap">
                                                                    @if($o->level)
                                                                        <div class="skill_lavel-tag">
                                                                            {{$o->courseLevel->title}}
                                                                        </div>
                                                                    @endif
                                                                    <ul class="d-flex align-items-center gap-2 info flex-wrap">

                                                                        <li>{{count($o->lessons)}} {{__('frontend.Lectures')}}</li>
                                                                        <li>
                                                                            {{MinuteFormat($o->duration)}}
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="row g-0 right h-100 border-top border-top-md-0">
                                                            <ul class="col-6 stats">
                                                                <li>
                                                                    <svg width="16" height="15" viewBox="0 0 16 15"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M14.9922 5.21624L10.2573 4.53056L8.1344 0.242104C8.09105 0.168678 8.02784 0.10754 7.9513 0.0649862C7.87476 0.0224321 7.78764 0 7.69892 0C7.6102 0 7.52308 0.0224321 7.44654 0.0649862C7.37 0.10754 7.3068 0.168678 7.26345 0.242104L5.14222 4.52977L0.40648 5.21624C0.31946 5.22916 0.237852 5.2645 0.170564 5.31841C0.103275 5.37231 0.0528901 5.44272 0.0249085 5.52194C-0.00307309 5.60116 -0.00757644 5.68614 0.01189 5.76762C0.0313563 5.8491 0.0740445 5.92394 0.135295 5.98398L3.57501 9.33111L2.76146 14.0591C2.74696 14.1436 2.75782 14.2304 2.79281 14.3094C2.8278 14.3883 2.88549 14.4564 2.95932 14.5058C3.03314 14.5551 3.12011 14.5838 3.2103 14.5886C3.30049 14.5933 3.39026 14.5739 3.46936 14.5325L7.6985 12.3153L11.9276 14.5333C12.0068 14.5746 12.0965 14.5941 12.1867 14.5893C12.2769 14.5846 12.3639 14.5559 12.4377 14.5066C12.5115 14.4572 12.5692 14.3891 12.6042 14.3101C12.6392 14.2311 12.6501 14.1444 12.6356 14.0599L11.822 9.3319L15.2634 5.98398C15.3253 5.92392 15.3685 5.84885 15.3883 5.76699C15.4082 5.68515 15.4039 5.59969 15.3758 5.52003C15.3478 5.44036 15.2972 5.36956 15.2295 5.31541C15.1618 5.26126 15.0797 5.22586 14.9922 5.21308V5.21624Z"
                                                                            fill="#FFC107"/>
                                                                    </svg>
                                                                    <span>{{$o->totalReview}}  ({{translatedNumber($o->total_reviews)}} {{__('common.Rating')}})</span>
                                                                </li>
                                                                @if(!Settings('hide_total_enrollment_count') == 1)
                                                                    <li>
                                                                        <svg width="16" height="18" viewBox="0 0 16 18"
                                                                             fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M14.2469 3.87484L9.29687 1.0165C8.48854 0.549837 7.48854 0.549837 6.67188 1.0165L1.73021 3.87484C0.921875 4.3415 0.421875 5.20817 0.421875 6.14984V11.8498C0.421875 12.7832 0.921875 13.6498 1.73021 14.1248L6.68021 16.9832C7.48854 17.4498 8.48854 17.4498 9.30521 16.9832L14.2552 14.1248C15.0635 13.6582 15.5635 12.7915 15.5635 11.8498V6.14984C15.5552 5.20817 15.0552 4.34984 14.2469 3.87484ZM7.98854 5.1165C9.06354 5.1165 9.93021 5.98317 9.93021 7.05817C9.93021 8.13317 9.06354 8.99984 7.98854 8.99984C6.91354 8.99984 6.04688 8.13317 6.04688 7.05817C6.04688 5.9915 6.91354 5.1165 7.98854 5.1165ZM10.2219 12.8832H5.75521C5.08021 12.8832 4.68854 12.1332 5.06354 11.5748C5.63021 10.7332 6.73021 10.1665 7.98854 10.1665C9.24687 10.1665 10.3469 10.7332 10.9135 11.5748C11.2885 12.1248 10.8885 12.8832 10.2219 12.8832Z"
                                                                                fill="#292D32"/>
                                                                        </svg>

                                                                        <span> {{$o->total_enrolled}}
                                                                            {{__('frontend.Students')}}</span>
                                                                    </li>
                                                                @endif
                                                            </ul>

                                                            <ul class="col-4 price">
                                                                @if(empty($o->price_text))
                                                                <li>
                                                                    <div class="current">
                                                                        @php
                                                                            if ($o->discount_price > 0) {
                                                                                $price = $o->discount_price;
                                                                            }else{
                                                                                $price = $o->price;
                                                                            }
                                                                            echo getPriceFormat($price);
                                                                        @endphp
                                                                    </div>
                                                                </li>
                                                                @if ($o->discount_price > 0)

                                                                    <li>
                                                                        <del>{{getPriceFormat($o->price)}}</del>
                                                                    </li>
                                                                @endif
                                                                @else
                                                                    <li>
                                                                        <div class="current text-center">
                                                                            {{$o->price_text}}
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            </ul>

                                                            @if(!onlySubscription())
                                                                @auth()
                                                                    @if(!$o->isLoginUserEnrolled && !$o->isLoginUserCart)
                                                                        <a href="#" class="cart_store card_area col-2 align-self-center"
                                                                           data-id="{{$o->id}}">
                                                                            <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z" fill="url(#paint0_linear_2677_32086151312111)"/>
                                                                                <path d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z" fill="url(#paint1_linear_2677_32086252322212)"/>
                                                                                <path d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z" fill="url(#paint2_linear_2677_32086353332313)"/>
                                                                                <defs>
                                                                                    <linearGradient id="paint0_linear_2677_32086151312111" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                    </linearGradient>
                                                                                    <linearGradient id="paint1_linear_2677_32086252322212" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                        <stop stop-color="#660AFB"/>
                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                    </linearGradient>
                                                                                    <linearGradient id="paint2_linear_2677_32086353332313" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                        <stop stop-color="#660AFB"/>
                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                    </linearGradient>
                                                                                </defs>
                                                                            </svg>

                                                                        </a>
                                                                    @endif
                                                                @endauth
                                                                @guest()
                                                                    @if(!$o->isGuestUserCart)
                                                                        <a href="#" class="cart_store card_area col-2 align-self-center"
                                                                           data-id="{{$o->id}}">
                                                                            <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z" fill="url(#paint0_linear_2677_3208615131)"/>
                                                                                <path d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z" fill="url(#paint1_linear_2677_3208625232)"/>
                                                                                <path d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z" fill="url(#paint2_linear_2677_3208635333)"/>
                                                                                <defs>
                                                                                    <linearGradient id="paint0_linear_2677_3208615131" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                    </linearGradient>
                                                                                    <linearGradient id="paint1_linear_2677_3208625232" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                        <stop stop-color="#660AFB"/>
                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                                    </linearGradient>
                                                                                    <linearGradient id="paint2_linear_2677_3208635333" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                                        <stop stop-color="#660AFB"/>
                                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
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
                            <div class="col-xl-4 order-1 order-xl-2">
                                <div class="course_sidebar">
                                    <div class="video_screen theme__overlaxy">
                                        <div class="video_play text-center">

                                            @if (Auth::check())
                                                @if ($isEnrolled)

                                                    @if(@$course->class->host=="Zoom")
                                                        @if(@$course->nextMeeting->currentStatus=="started")
                                                            <a target="_blank"
                                                               href="{{route('classStart', [$course->slug,'Zoom',$course->nextMeeting->id])}}"
                                                               class="theme_btn d-block text-center height_50 mb_10">
                                                                {{__('common.Watch Now')}}
                                                            </a>
                                                        @elseif (@$course->nextMeeting->currentStatus== 'waiting')
                                                            <span
                                                                class="theme_btn d-block text-center height_50 mb_10">
                                                            {{__('frontend.Waiting')}}
                                                    </span>
                                                        @else
                                                            @if($isWaiting)
                                                                <span
                                                                    class="theme_line_btn d-block text-center height_50 mb_10">
                                                                {{__('frontend.Waiting')}}
                                                            </span>
                                                            @else
                                                                @if($certificateCanDownload)
                                                                    <a href="{{route('getCertificate',[$course->id,$course->title])}}"
                                                                       class="theme_btn certificate_btn mt-5">
                                                                        {{__('frontend.Get Certificate')}}
                                                                    </a>
                                                                @else
                                                                    <span
                                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                            {{__('frontend.Closed')}}
                                                        </span>
                                                                @endif
                                                            @endif

                                                        @endif
                                                    @endif
                                                    @if(@$course->class->host=="BBB")
                                                        @php
                                                            $hasClass=false;
                                                        @endphp
                                                        @foreach($course->class->bbbMeetings as $key=>$meeting)
                                                            @if(!$hasClass)
                                                                @if(@$meeting->isRunning())
                                                                    <a target="_blank"
                                                                       href="{{route('classStart', [$course->slug,'BBB',$meeting->id])}}"
                                                                       class="theme_btn d-block text-center height_50 mb_10">
                                                                        {{__('common.Watch Now')}}
                                                                    </a>
                                                                    @php
                                                                        $hasClass=true;
                                                                    @endphp
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                        @if(!$hasClass)
                                                            @if($isWaiting)
                                                                <span
                                                                    class="theme_line_btn d-block text-center height_50 mb_10">
                                                                {{__('frontend.Waiting')}}
                                                            </span>
                                                            @else
                                                                <span
                                                                    class="theme_line_btn d-block text-center height_50 mb_10">
                                                            {{__('frontend.Closed')}}
                                                        </span>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    @if(@$course->class->host=="Jitsi")
                                                        @if($course->nextMeeting)
                                                            @php
                                                                $start = \Illuminate\Support\Carbon::parse($course->nextMeeting->date . ' ' .$course->nextMeeting->time);
                                                                $nowDate = \Illuminate\Support\Carbon::now();
                                                                $not_start = $start->gt($nowDate);

                                                                $end =$start->addMinutes((int)$course->nextMeeting->duration);
                                                                $not_end =$end->gt($nowDate);
                                                            @endphp
                                                            @if(!$not_start && $not_end)
                                                                <a target="_blank"
                                                                   href="{{route('classStart', [$course->slug,'Jitsi',$course->nextMeeting->id])}}"
                                                                   class="theme_btn d-block text-center height_50 mb_10">
                                                                    {{__('common.Watch Now')}}
                                                                </a>

                                                            @else
                                                                @if($isWaiting)
                                                                    <span
                                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                                {{__('frontend.Waiting')}}
                                                            </span>
                                                                @else
                                                                    <span
                                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                            {{__('frontend.Closed')}}
                                                        </span>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif

                                                    @if(@$course->class->host=="Custom")
                                                        @if($course->nextMeeting)
                                                            @php
                                                                $start = \Illuminate\Support\Carbon::parse($course->nextMeeting->date . ' ' .$course->nextMeeting->time);
                                                                $nowDate = \Illuminate\Support\Carbon::now();
                                                                $not_start = $start->gt($nowDate);

                                                                $end =$start->addMinutes((int)$course->nextMeeting->duration);
                                                                $not_end =$end->gt($nowDate);
                                                            @endphp
                                                            @if(!$not_start && $not_end)
                                                                <a target="_blank"
                                                                   href="{{route('classStart', [$course->slug,'Custom',$course->nextMeeting->id])}}"
                                                                   class="theme_btn d-block text-center height_50 mb_10">
                                                                    {{__('common.Watch Now')}}
                                                                </a>

                                                            @else
                                                                @if($isWaiting)
                                                                    <span
                                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                                {{__('frontend.Waiting')}}
                                                            </span>
                                                                @else
                                                                    <span
                                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                            {{__('frontend.Closed')}}
                                                        </span>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                    @if(@$course->class->host=="InAppLiveClass")
                                                        @if($course->nextMeeting)
                                                            @php
                                                                $start = \Illuminate\Support\Carbon::parse($course->nextMeeting->date . ' ' .$course->nextMeeting->time);
                                                                $nowDate = \Illuminate\Support\Carbon::now();
                                                                $not_start = $start->gt($nowDate);

                                                                $end =$start->addMinutes((int)$course->nextMeeting->duration);
                                                                $not_end =$end->gt($nowDate);
                                                            @endphp
                                                            @if(!$not_start && $not_end)
                                                                <a target="_blank"
                                                                   href="{{route('classStart', [$course->slug,'InAppLiveClass',$course->nextMeeting->id])}}"
                                                                   class="theme_btn d-block text-center height_50 mb_10">
                                                                    {{__('common.Watch Now')}}
                                                                </a>

                                                            @else
                                                                @if($isWaiting)
                                                                    <span
                                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                                {{__('frontend.Waiting')}}
                                                            </span>
                                                                @else
                                                                    <span
                                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                            {{__('frontend.Closed')}}
                                                        </span>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                    @if(@$course->class->host=="GoogleMeet")

                                                        @if(@$course->nextMeeting->currentStatus=="started")
                                                            <a target="_blank"
                                                               href="{{route('classStart', [$course->slug,'GoogleMeet',$course->nextMeeting->id])}}"
                                                               class="theme_btn d-block text-center height_50 mb_10">
                                                                {{__('common.Watch Now')}}
                                                            </a>
                                                        @elseif (@$course->nextMeeting->currentStatus== 'waiting')
                                                            <span
                                                                class="theme_btn d-block text-center height_50 mb_10">
                                                            {{__('frontend.Waiting')}}
                                                    </span>
                                                        @else
                                                            @if($isWaiting)
                                                                <span
                                                                    class="theme_line_btn d-block text-center height_50 mb_10">
                                                                {{__('frontend.Waiting')}}
                                                            </span>
                                                            @else
                                                                @if($certificateCanDownload)
                                                                    <a href="{{route('getCertificate',[$course->id,$course->title])}}"
                                                                       class="theme_btn certificate_btn mt-5">
                                                                        {{__('frontend.Get Certificate')}}
                                                                    </a>
                                                                @else
                                                                    <span
                                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                            {{__('frontend.Closed')}}
                                                        </span>
                                                                @endif
                                                            @endif

                                                        @endif
                                                    @endif

                                                @else
                                                    {{--
                                                    @if(!onlySubscription())
                                                        @if($isFree)
                                                            @if($is_cart == 1)
                                                                <a href="javascript:void(0)"
                                                                   class="theme_btn d-block text-center height_50 mb_10">{{__('common.Added To Cart')}}</a>
                                                            @else
                                                                <a href="{{route('addToCart',[@$course->id])}}"
                                                                   class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                            @endif
                                                        @else
                                                            <a href=" {{route('addToCart',[@$course->id])}} "
                                                               class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                            <a href="{{route('buyNow',[@$course->id])}}"
                                                               class="theme_line_btn d-block text-center height_50 mb_20">{{__('common.Buy Now')}}</a>
                                                        @endif
                                                    @endif
                                                    --}}
                                                @endif

                                            @else
                                                {{-- @if(!onlySubscription())
                                                     @if($isFree)
                                                         <a href=" {{route('addToCart',[@$course->id])}} "
                                                            class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                     @else
                                                         <a href=" {{route('addToCart',[@$course->id])}} "
                                                            class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                         <a href="{{route('buyNow',[@$course->id])}}"
                                                            class="theme_line_btn d-block text-center height_50 mb_20">{{__('common.Buy Now')}}</a>
                                                     @endif
                                                 @endif--}}
                                            @endif

                                        </div>
                                    </div>
                                    <div class="sidebar__widget mb_30">
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
                                                       class="theme_button mr_10 sm_mb_10">{{__('frontend.Already In Wishlist')}}
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
                                            @if (Auth::check())
                                                @if ($isEnrolled)
                                                    <a href="#"
                                                       class="theme_btn d-block text-center height_50 mb_10">{{__('common.Already Enrolled')}}</a>

                                                    {{--                                        @if($certificateCanDownload)--}}
                                                    {{--                                            <a href="{{route('getCertificate',[$course->id,$course->title])}}"--}}
                                                    {{--                                               class="theme_line_btn d-block text-center height_50 mb_10">--}}
                                                    {{--                                                {{__('frontend.Get Certificate')}}--}}
                                                    {{--                                            </a>--}}
                                                    {{--                                        @endif--}}
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
                                                               class="theme_line_btn d-block text-center height_50 mb_10">{{__('common.Buy Now')}}</a>
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
                                                           class="theme_line_btn d-block text-center height_50 mb_10">{{__('common.Buy Now')}}</a>
                                                    @endif
                                                @endif
                                            @endif
                                            <x-google-calendar-reminder :title="$course->title"
                                                                        :date="$course->class->start_date"
                                                                        :time="$course->class->time"
                                                                        :duration="$course->class->duration"/>
                                        @endif

                                        @includeIf('gift::buttons.course_details_page_button', ['course' => $course])
                                        @if(isModuleActive('Installment') && $course_price > 0)
                                            @includeIf(theme('partials._installment_plan_button'), ['course' => $course])
                                        @endif
                                        @if(isModuleActive('Cashback'))
                                            @includeIf(theme('partials._cashback_card'), ['product' => $course])
                                        @endif
                                        <p class="font_14 f_w_500 text-center mb_30"></p>
                                        {{--<h4 class="f_w_700 mb_10">{{__('frontend.This class includes')}}:</h4>--}}
                                        <ul class="course_includes">

                                            <li>
                                                <svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.09592 11.2785C1.25851 12.7129 2.47157 13.8315 3.91433 13.8827C4.64619 13.9086 5.39767 13.9221 6.20761 13.9221C7.01754 13.9221 7.76902 13.9086 8.50088 13.8827C9.94363 13.8315 11.1567 12.7129 11.3193 11.2785C11.3759 10.7785 11.4152 10.2705 11.4152 9.75593C11.4152 9.24137 11.3759 8.73337 11.3193 8.23338C11.1567 6.79889 9.94363 5.68043 8.50088 5.62923C7.76902 5.60326 7.01754 5.58984 6.20761 5.58984C5.39767 5.58984 4.64619 5.60326 3.91433 5.62923C2.47157 5.68043 1.25851 6.79889 1.09592 8.23338C1.03923 8.73337 1 9.24137 1 9.75593C1 10.2705 1.03923 10.7785 1.09592 11.2785Z" fill="white" stroke="url(#paint0_linear_0_1dd)"/>
                                                    <path d="M8.26744 2.27798C7.72053 1.73108 6.97877 1.42383 6.20533 1.42383C5.43188 1.42383 4.69013 1.73108 4.14322 2.27798C3.59631 2.82488 3.28906 3.56665 3.28906 4.34009V5.58992" stroke="url(#paint1_linear_0_1vv)" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M6.21094 9.25586V10.2557" stroke="url(#paint2_linear_0_1r421)" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <defs>
                                                        <linearGradient id="paint0_linear_0_1dd" x1="1.94255" y1="11.1961" x2="10.6722" y2="8.70796" gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint1_linear_0_1vv" x1="3.73959" y1="4.22694" x2="7.93944" y2="3.08258" gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint2_linear_0_1r421" x1="6.30144" y1="9.92856" x2="7.16288" y2="9.7321" gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                    </defs>
                                                </svg>

                                                <p class="nowrap">  {{ __('common.Start Date') }}  {{ showDate($course->class->start_date)}}  {{__('common.At')}}
                                                    {{date('h:i A', strtotime($course->class->time))}}
                                                </p>
                                            </li>

                                            @if(!Settings('hide_total_enrollment_count') == 1)
                                                <li>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M7.32422 7.7373C7.28047 7.73105 7.22422 7.73105 7.17422 7.7373C6.07422 7.6998 5.19922 6.7998 5.19922 5.69355C5.19922 4.5623 6.11172 3.64355 7.24922 3.64355C8.38047 3.64355 9.29922 4.5623 9.29922 5.69355C9.29297 6.7998 8.42422 7.6998 7.32422 7.7373Z"
                                                            stroke="url(#paint0_linear_0_1ee)" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path
                                                            d="M11.4641 11.8626C10.3516 12.8813 8.87656 13.5001 7.25156 13.5001C5.62656 13.5001 4.15156 12.8813 3.03906 11.8626C3.10156 11.2751 3.47656 10.7001 4.14531 10.2501C5.85781 9.1126 8.65781 9.1126 10.3578 10.2501C11.0266 10.7001 11.4016 11.2751 11.4641 11.8626Z"
                                                            stroke="url(#paint1_linear_0_1qq)" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path
                                                            d="M7.25 13.5C10.7018 13.5 13.5 10.7018 13.5 7.25C13.5 3.79822 10.7018 1 7.25 1C3.79822 1 1 3.79822 1 7.25C1 10.7018 3.79822 13.5 7.25 13.5Z"
                                                            stroke="url(#paint2_linear_0_1q421)" stroke-linecap="round" stroke-linejoin="round" />
                                                        <defs>
                                                            <linearGradient id="paint0_linear_0_1ee" x1="5.57026" y1="6.39799" x2="9.10171" y2="5.59153"
                                                                            gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                            </linearGradient>
                                                            <linearGradient id="paint1_linear_0_1qq" x1="3.80151" y1="12.1577" x2="10.0639" y2="9.22571"
                                                                            gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                            </linearGradient>
                                                            <linearGradient id="paint2_linear_0_1q421" x1="2.13122" y1="9.41049" x2="12.8995" y2="6.95514"
                                                                            gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>


                                                    <p>{{__('frontend.Enrolled')}} {{$course->total_enrolled}} {{__('frontend.students')}}</p>
                                                </li>
                                            @endif

                                            <li>
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.32422 7.7373C7.28047 7.73105 7.22422 7.73105 7.17422 7.7373C6.07422 7.6998 5.19922 6.7998 5.19922 5.69355C5.19922 4.5623 6.11172 3.64355 7.24922 3.64355C8.38047 3.64355 9.29922 4.5623 9.29922 5.69355C9.29297 6.7998 8.42422 7.6998 7.32422 7.7373Z"
                                                        stroke="url(#paint0_linear_0_1ff)" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M11.4641 11.8626C10.3516 12.8813 8.87656 13.5001 7.25156 13.5001C5.62656 13.5001 4.15156 12.8813 3.03906 11.8626C3.10156 11.2751 3.47656 10.7001 4.14531 10.2501C5.85781 9.1126 8.65781 9.1126 10.3578 10.2501C11.0266 10.7001 11.4016 11.2751 11.4641 11.8626Z"
                                                        stroke="url(#paint1_linear_0_1ff)" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M7.25 13.5C10.7018 13.5 13.5 10.7018 13.5 7.25C13.5 3.79822 10.7018 1 7.25 1C3.79822 1 1 3.79822 1 7.25C1 10.7018 3.79822 13.5 7.25 13.5Z"
                                                        stroke="url(#paint2_linear_0_1q4q21)" stroke-linecap="round" stroke-linejoin="round" />
                                                    <defs>
                                                        <linearGradient id="paint0_linear_0_1ff" x1="5.57026" y1="6.39799" x2="9.10171" y2="5.59153"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint1_linear_0_1ff" x1="3.80151" y1="12.1577" x2="10.0639" y2="9.22571"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint2_linear_0_1q4q21" x1="2.13122" y1="9.41049" x2="12.8995" y2="6.95514"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                    </defs>
                                                </svg>

                                                <p class="nowrap"> {{ __('virtual-class.Capacity') }} {{$course->class->capacity>0?$course->class->capacity:trans('common.Unlimited')}}</p>
                                            </li>


                                            <li>
                                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.24913 13.7839C10.7004 13.7839 13.4983 10.9861 13.4983 7.53478C13.4983 4.08348 10.7004 1.28564 7.24913 1.28564C3.79783 1.28564 1 4.08348 1 7.53478C1 10.9861 3.79783 13.7839 7.24913 13.7839Z" fill="white" stroke="url(#paint0_linear_0_1gg)"/>
                                                    <path d="M7.25 5.04736V7.54702L8.74979 9.04681" stroke="url(#paint1_linear_0_1jj)" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <defs>
                                                        <linearGradient id="paint0_linear_0_1gg" x1="2.13106" y1="9.69497" x2="12.8978" y2="7.23996" gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint1_linear_0_1jj" x1="7.38573" y1="7.73835" x2="8.73505" y2="7.62297" gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                    </defs>
                                                </svg>

                                                <p class="nowrap"> {{ __('frontend.Duration') }} {{convertMinutesToHourAndMinute($course->class->duration)}}
                                                    Hours</p>
                                            </li>

                                            <li>
                                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.24921 13.7824C6.53069 13.7824 6.5246 13.2597 5.90559 12.8137C4.82877 12.038 3.17357 11.125 1.85568 10.9463C1.61944 10.9201 1.40125 10.8074 1.24324 10.6299C1.08522 10.4523 0.998576 10.2225 1.00002 9.98486V2.24547C1.00001 2.10661 1.03008 1.96939 1.08817 1.84325C1.14626 1.71712 1.23098 1.60506 1.33651 1.5148C1.44019 1.42618 1.56152 1.36063 1.69247 1.32251C1.82342 1.28438 1.96099 1.27455 2.09603 1.29368C4.08067 1.62306 5.89623 2.61213 7.24921 4.10101V13.7824Z" fill="white" stroke="url(#paint0_linear_0_1hh)" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M7.25 13.7824C7.96852 13.7824 7.97461 13.2597 8.59362 12.8137C9.67043 12.038 11.3256 11.125 12.6436 10.9463C12.8798 10.9201 13.098 10.8074 13.256 10.6299C13.4139 10.4523 13.5006 10.2225 13.4992 9.98486V2.24547C13.4992 2.10661 13.4691 1.96939 13.411 1.84325C13.353 1.71712 13.2683 1.60506 13.1627 1.5148C13.059 1.42618 12.9377 1.36063 12.8067 1.32251C12.6757 1.28438 12.5383 1.27455 12.4032 1.29368C10.4186 1.62306 8.60298 2.61213 7.25 4.10101V13.7824Z" fill="white" stroke="url(#paint1_linear_0_111)" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <defs>
                                                        <linearGradient id="paint0_linear_0_1hh" x1="1.56554" y1="9.69349" x2="7.15621" y2="9.05609" gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint1_linear_0_111" x1="7.81554" y1="9.69349" x2="13.4062" y2="9.05609" gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                            <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                        </linearGradient>
                                                    </defs>
                                                </svg>

                                                <p>{{__('frontend.Sessions')}} {{$course->class->total_class}} </p>
                                            </li>

                                            @if($course->certificate)
                                                <li>
                                                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13.4877 4.19436C13.4877 5.13038 13.1838 6.02806 12.6429 6.68993C12.216 7.21217 11.6693 7.55383 11.0819 7.67475L3.39607 7.67273C2.8123 7.55006 2.26921 7.20929 1.84478 6.68993C1.30389 6.02806 1.00002 5.13038 1.00002 4.19436L1 2.69762C0.999997 2.51334 1.12107 2.35094 1.29769 2.29834C5.17755 1.14274 9.31007 1.14274 13.1899 2.29835C13.3666 2.35095 13.4877 2.51334 13.4877 2.69762V4.19436Z" stroke="url(#paint0_linear_0_1i)" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M7.23438 10.897V13.9239" stroke="url(#paint1_linear_0_155)" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M4.83594 13.9238H9.64296" stroke="url(#paint2_linear_0_1q4q2)" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M3.76768 7.27052C3.82825 9.18136 5.33539 10.8896 7.2472 10.8896C9.19267 10.8896 10.658 9.21146 10.725 7.26714C10.7376 6.9011 10.7444 6.53128 10.7444 6.15769C10.7444 4.64268 10.6433 3.09965 10.478 1.7311C9.43894 1.49914 8.37042 1.42578 7.2472 1.42578C6.12398 1.42578 5.0339 1.49023 4.01642 1.7311C3.84211 3.09389 3.75 4.64268 3.75 6.15769C3.75 6.53256 3.75604 6.90347 3.76768 7.27052Z" fill="white" stroke="url(#paint3_linear_0_144)"/>
                                                        <defs>
                                                            <linearGradient id="paint0_linear_0_1i" x1="2.13011" y1="5.63225" x2="11.4983" y2="1.35953" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                            </linearGradient>
                                                            <linearGradient id="paint1_linear_0_155" x1="7.32487" y1="12.9336" x2="8.22601" y2="12.8657" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                            </linearGradient>
                                                            <linearGradient id="paint2_linear_0_1q4q2" x1="5.27096" y1="14.5967" x2="7.24986" y2="12.4276" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                            </linearGradient>
                                                            <linearGradient id="paint3_linear_0_144" x1="4.38298" y1="7.79339" x2="10.5466" y2="6.75468" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>


                                                    <p>{{__('frontend.Certificate of Completion')}}</p></li>
                                            @endif

                                            @if(isModuleActive('SupportTicket') && $course->support)
                                                <li>
                                                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4.03926 2.09603C4.98431 1.52996 6.06521 1.23081 7.16683 1.23047C8.08338 1.22993 8.98823 1.43627 9.81394 1.83411C10.6396 2.23196 11.3649 2.81104 11.9356 3.5282C12.5064 4.24536 12.9079 5.08209 13.1103 5.97602C13.3127 6.86995 13.3107 7.79803 13.1044 8.69108C12.8981 9.58413 12.493 10.4191 11.919 11.1337C11.3452 11.8484 10.6174 12.4244 9.78998 12.8186C8.96256 13.2128 8.05681 13.4152 7.14027 13.4106C6.3753 13.4069 5.61927 13.259 4.91136 12.9763L1.58264 13.5305C1.21072 13.5925 0.906715 13.236 1.0265 12.8786L1.87804 10.337C1.40371 9.50499 1.13126 8.57099 1.08549 7.61045C1.03307 6.51008 1.28008 5.4161 1.80024 4.44501C2.32039 3.47393 3.0942 2.66211 4.03926 2.09603Z" fill="white" stroke="url(#paint0_linear_0_1ii)" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M7.16401 7.97156C7.16401 7.61055 7.45762 7.38911 7.97563 7.04299C8.45611 6.72194 8.70956 6.30548 8.59681 5.73871C8.48408 5.17195 8.01577 4.70364 7.44901 4.59091C6.55935 4.41394 5.70312 5.11662 5.70312 6.02372" stroke="url(#paint1_linear_0_1e4)" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M7.16406 10.0215V10.334" stroke="url(#paint2_linear_0_1q4qv)" stroke-linecap="round"/>
                                                        <defs>
                                                            <linearGradient id="paint0_linear_0_1ii" x1="2.10956" y1="9.51117" x2="12.6755" y2="7.11105" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                            </linearGradient>
                                                            <linearGradient id="paint1_linear_0_1e4" x1="5.9674" y1="6.85657" x2="8.51657" y2="6.35851" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                            </linearGradient>
                                                            <linearGradient id="paint2_linear_0_1q4qv" x1="7.25456" y1="10.2318" x2="7.84599" y2="9.80026" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>

                                                    <p>{{__('common.Support')}}</p>
                                                </li>
                                            @endif

                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="more_course_section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="author_courses">
                    <div class="section__title mb_30">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div>
                                <h3 class="mb-0">{{__('frontend.More Courses by Author')}}</h3>
                                <p>{{__('frontend.Discover Additional Learning Opportunities')}}</p>
                            </div>
                            <div class="view-all-btn">
                                <a href="{{route('instructorDetails',[$course->user->id,$course->user->name])}}"
                                   class="view_all text-nowrap">
                                    {{__('frontend.View All')}}
                                    <i class="fas fa-arrow-right fa-fw"></i>
                                </a></div>
                        </div>
                    </div>
                    <div class="more_course_section_slider owl-carousel">
                        @foreach(@$course->user->courses->where('scope',1)->where('status',1)->take(6) as $c)
                            <div class="slider_item">
                                <div class="course-item">
                                    <a href="{{courseDetailsUrl(@$c->id,@$c->type,@$c->slug)}}">
                                        <div class="course-item-img lazy">
                                            <img class="w-100"
                                                 src="{{ file_exists($c->thumbnail) ? asset($c->thumbnail) : asset('public/\uploads/course_sample.png') }}"
                                                 alt="">
                                            <span class="course-tag"><span>
                                                                                        {{$c->courseLevel->title}}

                                                </span></span>
                                        </div>
                                    </a>
                                    <div class="course-item-info">
                                        <a href="{{courseDetailsUrl(@$c->id,@$c->type,@$c->slug)}}"
                                           class="title">
                                            {{@$c->title}}
                                        </a>
                                        <div class="d-flex align-itemes-center justify-content-between meta">
                                            <div class="rating">
                                                <svg width="16" height="15" viewBox="0 0 16 15" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M14.9922 5.21624L10.2573 4.53056L8.1344 0.242104C8.09105 0.168678 8.02784 0.10754 7.9513 0.0649862C7.87476 0.0224321 7.78764 0 7.69892 0C7.6102 0 7.52308 0.0224321 7.44654 0.0649862C7.37 0.10754 7.3068 0.168678 7.26345 0.242104L5.14222 4.52977L0.40648 5.21624C0.31946 5.22916 0.237852 5.2645 0.170564 5.31841C0.103275 5.37231 0.0528901 5.44272 0.0249085 5.52194C-0.00307309 5.60116 -0.00757644 5.68614 0.01189 5.76762C0.0313563 5.8491 0.0740445 5.92394 0.135295 5.98398L3.57501 9.33111L2.76146 14.0591C2.74696 14.1436 2.75782 14.2304 2.79281 14.3094C2.8278 14.3883 2.88549 14.4564 2.95932 14.5058C3.03314 14.5551 3.12011 14.5838 3.2103 14.5886C3.30049 14.5933 3.39026 14.5739 3.46936 14.5325L7.6985 12.3153L11.9276 14.5333C12.0068 14.5746 12.0965 14.5941 12.1867 14.5893C12.2769 14.5846 12.3639 14.5559 12.4377 14.5066C12.5115 14.4572 12.5692 14.3891 12.6042 14.3101C12.6392 14.2311 12.6501 14.1444 12.6356 14.0599L11.822 9.3319L15.2634 5.98398C15.3253 5.92392 15.3685 5.84885 15.3883 5.76699C15.4082 5.68515 15.4039 5.59969 15.3758 5.52003C15.3478 5.44036 15.2972 5.36956 15.2295 5.31541C15.1618 5.26126 15.0797 5.22586 14.9922 5.21308V5.21624Z"
                                                        fill="#FFC107"/>
                                                </svg>
                                                <span>{{$c->totalReview}} ({{$c->total_rating}} {{__("frontend.Ratings")}})</span>
                                            </div>
                                            <div class="enrolled-student">
                                                @if(!Settings('hide_total_enrollment_count') == 1)
                                                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14.2508 3.87484L9.30078 1.0165C8.49245 0.549837 7.49245 0.549837 6.67578 1.0165L1.73411 3.87484C0.925781 4.3415 0.425781 5.20817 0.425781 6.14984V11.8498C0.425781 12.7832 0.925781 13.6498 1.73411 14.1248L6.68411 16.9832C7.49245 17.4498 8.49245 17.4498 9.30911 16.9832L14.2591 14.1248C15.0674 13.6582 15.5674 12.7915 15.5674 11.8498V6.14984C15.5591 5.20817 15.0591 4.34984 14.2508 3.87484ZM7.99245 5.1165C9.06745 5.1165 9.93411 5.98317 9.93411 7.05817C9.93411 8.13317 9.06745 8.99984 7.99245 8.99984C6.91745 8.99984 6.05078 8.13317 6.05078 7.05817C6.05078 5.9915 6.91745 5.1165 7.99245 5.1165ZM10.2258 12.8832H5.75911C5.08411 12.8832 4.69245 12.1332 5.06745 11.5748C5.63411 10.7332 6.73411 10.1665 7.99245 10.1665C9.25078 10.1665 10.3508 10.7332 10.9174 11.5748C11.2924 12.1248 10.8924 12.8832 10.2258 12.8832Z"
                                                            fill="#292D32"/>
                                                    </svg> {{$c->total_enrolled}}
                                                    {{__('frontend.Students')}}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="course-item-info-description">
                                            {{Str::limit(strip_tags($c->about), 100)}}
                                        </div>
                                        <div class="course-item-footer d-flex justify-content-between">
                                            <x-price-tag :price="$c->price"
                                                         :text="$c->price_text"
                                                         :discount="$c->discount_price"/>

                                            <div class="rating_cart">
                                                @auth()
                                                    @if(!$c->isLoginUserEnrolled && !$c->isLoginUserCart)
                                                        <a href="#" class="cart_store"
                                                           data-id="{{$c->id}}">
                                                            <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z" fill="url(#paint0_linear_2677_32086151)"/>
                                                                <path d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z" fill="url(#paint1_linear_2677_32086252)"/>
                                                                <path d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z" fill="url(#paint2_linear_2677_32086353)"/>
                                                                <defs>
                                                                    <linearGradient id="paint0_linear_2677_32086151" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                    </linearGradient>
                                                                    <linearGradient id="paint1_linear_2677_32086252" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                        <stop stop-color="#660AFB"/>
                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                    </linearGradient>
                                                                    <linearGradient id="paint2_linear_2677_32086353" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                        <stop stop-color="#660AFB"/>
                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                    </linearGradient>
                                                                </defs>
                                                            </svg>

                                                        </a>
                                                    @endif
                                                @endauth
                                                @guest()
                                                    @if(!$c->isGuestUserCart)
                                                        <a href="#" class="cart_store"
                                                           data-id="{{$c->id}}">
                                                            <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M7.16467 13.3359H18.8653C19.0059 13.3364 19.1428 13.2894 19.2551 13.202C19.3675 13.1146 19.4491 12.9917 19.4877 12.8519L22.0801 3.51851C22.1078 3.41929 22.1127 3.31476 22.0945 3.21323C22.0762 3.1117 22.0353 3.01597 21.975 2.93366C21.9143 2.85128 21.8361 2.78451 21.7464 2.73853C21.6566 2.69256 21.5579 2.66862 21.4577 2.6686H5.66957L5.20675 0.522304C5.17445 0.373931 5.09423 0.241358 4.97931 0.14642C4.86439 0.0514822 4.72163 -0.000159516 4.57453 3.70146e-07H0.645078C0.473992 3.70146e-07 0.309914 0.0702685 0.188939 0.195346C0.0679633 0.320424 0 0.490067 0 0.666954C0 0.843841 0.0679633 1.01348 0.188939 1.13856C0.309914 1.26364 0.473992 1.33391 0.645078 1.33391H4.05423L6.3933 12.1686C5.98505 12.3512 5.65023 12.6738 5.44536 13.082C5.24049 13.4902 5.17812 13.959 5.26877 14.4092C5.35942 14.8595 5.59754 15.2636 5.94294 15.5534C6.28834 15.8432 6.71986 16.0009 7.16467 15.9998H18.8653C19.0364 15.9998 19.2005 15.9296 19.3214 15.8045C19.4424 15.6794 19.5104 15.5098 19.5104 15.3329C19.5104 15.156 19.4424 14.9864 19.3214 14.8613C19.2005 14.7362 19.0364 14.6659 18.8653 14.6659H7.16467C6.99359 14.6659 6.82951 14.5957 6.70853 14.4706C6.58756 14.3455 6.51959 14.1759 6.51959 13.999C6.51959 13.8221 6.58756 13.6525 6.70853 13.5274C6.82951 13.4023 6.99359 13.332 7.16467 13.332V13.3359Z" fill="url(#paint0_linear_2677_320861)"/>
                                                                <path d="M6.52262 18.0031C6.52322 18.3985 6.63716 18.7848 6.85005 19.1133C7.06294 19.4418 7.36524 19.6976 7.71872 19.8486C8.07221 19.9995 8.46104 20.0387 8.83607 19.9612C9.2111 19.8838 9.5555 19.6931 9.82577 19.4134C10.096 19.1336 10.28 18.7773 10.3545 18.3894C10.429 18.0016 10.3906 17.5996 10.2442 17.2343C10.0979 16.869 9.85003 16.5568 9.53207 16.3371C9.21411 16.1173 8.8403 16 8.45786 15.9998C7.94433 16.0003 7.45198 16.2115 7.08908 16.5872C6.72617 16.9628 6.52242 17.4721 6.52262 18.0031Z" fill="url(#paint1_linear_2677_320862)"/>
                                                                <path d="M15.6513 18.0031C15.6519 18.3984 15.7657 18.7846 15.9785 19.113C16.1913 19.4415 16.4935 19.6974 16.8468 19.8484C17.2002 19.9993 17.5889 20.0387 17.9639 19.9614C18.3388 19.8841 18.6833 19.6937 18.9536 19.4142C19.224 19.1347 19.4082 18.7786 19.4829 18.3909C19.5576 18.0032 19.5196 17.6013 19.3735 17.236C19.2275 16.8706 18.98 16.5582 18.6623 16.3382C18.3447 16.1182 17.9711 16.0005 17.5888 15.9998C17.3343 15.9997 17.0823 16.0515 16.8472 16.1521C16.6121 16.2528 16.3984 16.4003 16.2185 16.5863C16.0386 16.7724 15.8959 16.9933 15.7985 17.2363C15.7012 17.4794 15.6512 17.74 15.6513 18.0031Z" fill="url(#paint2_linear_2677_320863)"/>
                                                                <defs>
                                                                    <linearGradient id="paint0_linear_2677_320861" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                        <stop stop-color="var(--system_primery_gredient1, #660AFB)"/>
                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                    </linearGradient>
                                                                    <linearGradient id="paint1_linear_2677_320862" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                        <stop stop-color="#660AFB"/>
                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                    </linearGradient>
                                                                    <linearGradient id="paint2_linear_2677_320863" x1="2.00048" y1="13.4568" x2="20.837" y2="8.70962" gradientUnits="userSpaceOnUse">
                                                                        <stop stop-color="#660AFB"/>
                                                                        <stop offset="1" stop-color="var(--system_primery_gredient2, #BF37FF)"/>
                                                                    </linearGradient>
                                                                </defs>
                                                            </svg>

                                                        </a>
                                                    @endif
                                                @endguest
                                            </div>
                                        </div>
                                        {{--<div class="course_less_students">
                                            <a href="#"> <i
                                                    class="ti-agenda"></i> {{count($c->lessons)}}
                                                {{__('frontend.Lessons')}}</a>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                                                                <textarea class="lms_summernote" name="review" name=""
                                                                          id=""
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
        let isRTL = $('html').attr('dir') === 'rtl';

        $(".more_course_section_slider").owlCarousel({
            items: 4,
            loop: true,
            margin: 24,
            nav: true,
            rtl: isRTL,

            navText: [
                '<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.65067 0.0180664L0.0703115 5.59845V7.16096L5.65067 12.7413L7.23549 11.1788L3.57478 7.49578H16.0078V5.26363H3.57478L7.25781 1.58057L5.65067 0.0180664Z" fill="currentColor"/></svg>',
                '<svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.425 12.0367L9.55117 11.1752L12.858 7.84826L13.7053 6.99578H12.5033H0.570312V5.76363H12.5033H13.7105L12.8569 4.91008L9.53243 1.58559L10.4225 0.720231L15.5078 5.80556V6.95385L10.425 12.0367Z" fill="currentColor" stroke="currentColor"/></svg>'
            ],
            dots: false,
            autoplay: true,
            autoplayTimeout: $('#slider_transition_time').val()*1000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                },
                600: {
                    items: 2,
                    nav: true,
                },
                1000: {
                    items: 3,
                    nav: true,
                },
                1500: {
                    items: 4,
                    nav: true,
                }
            }

        });
    });

    function toggleVideoScreen() {
        const scrollTopPosition = $(window).scrollTop();
        const screenWidth = $(window).width();

        if (screenWidth > 1200) {
            if (scrollTopPosition > 200) {
                $(".course_sidebar .video_screen").slideUp(400);
            } else {
                $(".course_sidebar .video_screen").slideDown(400);
            }

        } else {
            // Always show on small screens
            $(".course_sidebar .video_screen").stop(true, true).show();
            $(".course_sidebar .video_screen").show();

        }
    }

    // Run on scroll
    $(window).on("scroll", toggleVideoScreen);

    // Run on resize
    $(window).on("resize", toggleVideoScreen);

    // Initial check
    toggleVideoScreen();


    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        setTimeout(function() {
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

</script>
