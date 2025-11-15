<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_faq_section.jpg')}}"
     data-aoraeditor-title="HomePage Default Call To Action Section" data-aoraeditor-categories="Home Page">
    <link rel="stylesheet" href="{{themeAsset('css/homepageV7/cta-v7.css')}}">

    <div class="container cta-section-container">
        <div class="row">
            <div class="col-md-6">
                <div class="cta-section d-flex align-items-center bg1">
                    <div class="cta-section-content">
                        <h3>Level - Up Your Raw Coding
                            Skills in Lockdown</h3>
                        <p class="lh2">With our interactive courses, you may explore an infinite array of learning
                            possibilities from thought</p>
                        <a href="{{route('register')}}" class="theme-btn">Join now</a>
                    </div>
                    <div class="cta-section-img align-self-end">
                        <img src="{{themeAsset('img/cta/cta-1-default.png')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="cta-section d-flex align-items-center bg2">
                    <div class="cta-section-content">
                        <p class="meta">New Information</p>
                        <h3>Become a new instructor</h3>
                        <p class="lh-base">With our interactive courses, you may explore an infinite array of learning
                            possibilities from thought</p>
                        <a href="{{route('becomeInstructor')}}" class="theme-btn">Join now</a>
                    </div>
                    <div class="cta-section-img align-self-end">
                        <img src="{{themeAsset('img/cta/cta-2-default.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
