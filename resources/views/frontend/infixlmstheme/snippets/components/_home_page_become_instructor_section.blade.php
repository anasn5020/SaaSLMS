<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_become_instructor_section.jpg')}}"
     data-aoraeditor-title="HomePage Become Instructor Section" data-aoraeditor-categories="Home Page">
    <div class="service_cta_area">
        <div class="container">
            <div class="border_top_1px"></div>
            <div class="row justify-content-center">
                <div class="col-xl-10">


                    <div class="row">
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
                            <div class="single_cta_service mb_30">
                                <div class="thumb">
                                    <img src="{{asset('public/frontend/infixlmstheme/img/services/2.png')}}" alt="">
                                </div>
                                <div class="cta_service_info">
                                    <h4>Learn with InfixLMS.</h4>
                                    <p>Teach what you love. Corrector gives you the
                                        tools to create a course.</p>
                                    <a href="#" class="theme_btn small_btn">For your Business</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
