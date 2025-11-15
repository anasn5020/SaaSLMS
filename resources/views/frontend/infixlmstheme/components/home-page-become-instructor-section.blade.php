<div>
    <div class="service_cta_area">
        <div class="container">
            <div class="border_top_1px"></div>
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="row">
                        <div class="  col-lg-6 m-auto">
                            <div class="single_cta_service mb_30">
                                <div class="thumb">
                                    <img src="{{asset(@$homeContent->become_instructor_logo)}}" alt="">
                                </div>
                                <div class="cta_service_info">
                                    <h4>  {{@$homeContent->become_instructor_title}}</h4>
                                    <p>  {{@$homeContent->become_instructor_sub_title}}
                                    </p>
                                    <a href="{{route('becomeInstructor')}}"
                                       class="theme_btn small_btn">{{__('frontend.Start Teaching')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
