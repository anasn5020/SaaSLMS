<div>
    <div class="cta_area" style="background-image: url('{{asset(@$homeContent->instructor_banner)}}')">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-1">
                    <div class="section__title white_text">
                        <h3 class="large_title">
                            {{@$homeContent->instructor_title}}

                        </h3>
                        <p>

                            {{@$homeContent->instructor_sub_title}}
                        </p>
                        <a href="{{route('instructors')}}"
                           class="theme_btn">{{__('frontend.Find Our Instructor')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
