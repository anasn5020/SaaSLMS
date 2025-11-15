<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/about/become_instructor.jpg')}}"
     data-aoraeditor-title="Footer Button" data-aoraeditor-categories="About Us Page">
    <div class="service_cta_area" style="padding-top: 120px;">
        <div class="container">
            {{--            <div class="border_top_1px"></div>--}}
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="single_cta_service mb_30">
                                <div class="thumb">
                                    <img src="{{asset('public/frontend/infixlmstheme/img/services/1.png')}}" alt="">
                                </div>
                                <div class="cta_service_info">
                                    <h4>Become a Instructor.</h4>
                                    <p>Teach what you love. Corrector gives you the
                                        tools to create a course.</p>
                                    <a href="{{route('becomeInstructor')}}" class="theme_btn small_btn">Start Teaching</a>
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
                                    <a href="{{route('register')}}" class="theme_btn small_btn">For your Learning</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

