<div>
    <div>
        <div class="main_content_iner main_content_padding">
            <div class="container">
                <div class="my_courses_wrapper pricing_plan">
                    <div class="row">
                        <div class="col-12">
                            <div class="section__title3">
                                <h3>
                                    {{__('org-subscription.My Plan')}}
                                </h3>
                            </div>
                        </div>


                        <div class="col-xl-6 col-md-6">
                            <div class="short_select d-flex align-items-center pt-0 pb-3">

                            </div>
                        </div>
                        <div class=" col-xl-6 col-md-6">
                            <form action="{{route(Request::route()->getName())}}">
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
                        @if(isset($plans))
                            @foreach ($plans as $plan)
                                @php
                                    $plan=$plan->plan;
                                @endphp
                                <div class="col-xl-4 col-md-6">

                                    <div class="couse_wizged single_pricing_plan  row_padding d-flex flex-column">

                                        <div class="course_content pt-1  pe-0 d-flex flex-column flex-fill">
                                            <a href="{{route('orgSubscriptionPlanList',$plan->id)}}">
                                                <h4 class="twoLine_ellipsis" title="{{$plan->title}}">
                                                    {{$plan->title}}
                                                </h4>
                                            </a>
                                            <p class="pb-2">
                                                {{Str::limit($plan->about,'90','...')}}
                                            </p>
                                            <div class="d-flex align-items-end gap_15 flex-fill ">

                                                <div class="progress_percent flex-fill text-end">
                                                    <div class="progress theme_progressBar ">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{round($plan->totalCompleted()['totalProgress'])}}%"
                                                             aria-valuenow="25"
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <p class="font_14 f_w_400">{{round($plan->totalCompleted()['totalProgress'])}}
                                                        % {{__('student.Complete')}}</p>
                                                </div>
                                            </div>
                                            <div class="course_less_students subscriptionPlanItem">
                                                <div class="d-flex justify-content-between">
                                                    <div class="text-nowrap">
                                                        <a>
                                                            <i class="ti-agenda"></i>{{count($plan->assign)}} {{__('org.Items')}}
                                                        </a>
                                                    </div>
                                                    <div class="text-nowrap">
                                                        <a>
                                                            <i class="ti-timer"></i>{{$plan->remaining()}} {{__('org.Day')}}
                                                        </a>

                                                    </div>
                                                    @if(!Settings('hide_total_enrollment_count') == 1)
                                                        <div class="text-nowrap">
                                                            <a>
                                                                <i class="ti-user"></i>{{$plan->total_enrolled}} {{__('student.Students')}}
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                            @if(count($plans)==0)
                                <div class="col-12">
                                    <div class="section__title3 margin_50">
                                        <p class="text-center">{{__('org-subscription.No Plan Purchased Yet')}}!</p>

                                    </div>
                                </div>
                            @endif
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
