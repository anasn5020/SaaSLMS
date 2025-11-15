<div>
    <div class="lms_section section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9">
                    <div class="section__title text-center mb_80">
                        <h3>{{__('saas.Choose a plan')}}</h3>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center ">
                <div class="col-xl-12">
                    <div class="row">
                        @foreach($plans as $key2=>$plan)
                            <div class="col-xl-4 col-lg-6">
                                <div class="lms_pricing_wized mb_30">
                                    <div class="lms_pricing_hader">
                                        <span>{{$plan->name}}</span>
                                        <h3>
                                            {{getPriceFormat($plan->price)}}</h3>
                                        <h5>
                                            @if($plan->days==0)
                                                {{__('saas.Unlimited')}}
                                            @else
                                                {{$plan->days}} {{__('common.Days')}}
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="lms_pricing_body">
                                        <ul>

                                            @if (isModuleActive('LmsSaasMD'))
                                                {
                                                @if($plan->course_access)
                                                    <li>{{__('saas.Course Limit')}}
                                                        : {{$plan->course_limit==0?trans('saas.Unlimited'):$plan->course_limit }}</li>
                                                @endif
                                                @if($plan->instructor_access)

                                                    <li>{{__('saas.Instructor Limit')}}:
                                                        {{$plan->instructor_limit==0?trans('saas.Unlimited'):$plan->instructor_limit }} </li>
                                                @endif
                                                @if($plan->student_access)

                                                    <li>{{__('saas.Student Limit')}}:
                                                        {{$plan->student_limit==0?trans('saas.Unlimited'):$plan->student_limit }} </li>
                                                @endif
                                                @if($plan->meeting_access)

                                                    <li>{{__('saas.Virtual Class Limit')}}:
                                                        {{$plan->meeting_limit==0?trans('saas.Unlimited'):$plan->meeting_limit }}  </li>
                                                @endif

                                                <li>{{__('saas.Course File Limit')}}:
                                                    {{$plan->upload_limit==0?trans('saas.Unlimited'):$plan->upload_limit/1024 }}
                                                    MB
                                                </li>
                                                @if($plan->quiz_access)
                                                    {{$plan->upload_limit==0?trans('saas.Unlimited'):$plan->upload_limit/1024 }}
                                                    MB
                                                    </li>
                                                    <li>{{__('saas.Quiz Question Limit')}}:
                                                        {{$plan->quiz_question_limit==0?trans('saas.Unlimited'):$plan->quiz_question_limit }} </li>
                                                @endif

                                                @if($plan->blog_access)
                                                    <li>{{__('saas.Blog post limit')}}:
                                                        {{$plan->blog_post_limit==0?trans('saas.Unlimited'):$plan->blog_post_limit }}  </li>
                                                @endif
                                            @else
                                                <li>{{__('saas.Course Limit')}}
                                                    : {{$plan->course_limit==0?trans('saas.Unlimited'):$plan->course_limit }}</li>

                                                <li>{{__('saas.Instructor Limit')}}:
                                                    {{$plan->instructor_limit==0?trans('saas.Unlimited'):$plan->instructor_limit }} </li>

                                                <li>{{__('saas.Student Limit')}}:
                                                    {{$plan->student_limit==0?trans('saas.Unlimited'):$plan->student_limit }} </li>

                                                <li>{{__('saas.Virtual Class Limit')}}:
                                                    {{$plan->meeting_limit==0?trans('saas.Unlimited'):$plan->meeting_limit }}  </li>

                                                <li>{{__('saas.Course File Limit')}}:
                                                    {{$plan->upload_limit==0?trans('saas.Unlimited'):$plan->upload_limit/1024 }}
                                                    MB
                                                </li>
                                                <li>{{__('saas.Quiz Question Limit')}}:
                                                    {{$plan->quiz_question_limit==0?trans('saas.Unlimited'):$plan->quiz_question_limit }} </li>

                                                <li>{{__('saas.Blog post limit')}}:
                                                    {{$plan->blog_post_limit==0?trans('saas.Unlimited'):$plan->blog_post_limit }}  </li>
                                            @endif


                                        </ul>
                                    </div>
                                    <div class="lms_pricing_footer">
                                        <form action="{{route('saasCheckout')}}">
                                            <input type="hidden" name="price"
                                                   value="{{$plan->price}}">
                                            <input type="hidden" name="plan"
                                                   value="{{$plan->id}}">
                                            <button type="submit"
                                                    class="theme_btn small_btn2 w-100 text-center">
                                                {{$plan->btn_txt}}
                                            </button>

                                        </form>
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
