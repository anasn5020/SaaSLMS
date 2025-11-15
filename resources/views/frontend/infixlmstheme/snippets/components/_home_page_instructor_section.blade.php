<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_instructor_section.jpg')}}"
     data-aoraeditor-title="HomePage Instructor Section" data-aoraeditor-categories="Home Page">
    <div class="cta_area">
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
