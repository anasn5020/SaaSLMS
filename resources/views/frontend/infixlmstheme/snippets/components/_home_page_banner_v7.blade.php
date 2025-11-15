<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_banner.jpg')}}"
     data-aoraeditor-title="HomePage Default Banner" data-aoraeditor-categories="Home Page;Banner">
    <link rel="stylesheet" href="{{themeAsset('css/homepageV7/banner-v7.css')}}">
    <div class="banner-area">
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-2 order-md-1 text-center text-md-start">
                    <h1>The most trusted & worthy tech skill learning Platform</h1>
                    <p>With our interactive courses, you may explore an infinite array of learning possibilities from
                        thought leaders and industry professionals who will help you develop new skills, and realise
                        your
                        full potential. </p>

                    <div class="banner-area-btns">
                        <a href="{{route('login')}}" class="primary-btn">Get Started <i class="ti-arrow-right"></i></a>
                        <a href="{{route('register')}}" class="secondary-btn">Join Now <i
                                class="ti-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-md-6 order-1 order-md-2 text-center banner-image">
                    <img src="{{asset('public/frontend/infixlmstheme/img/banner/banner-default.jpg')}}"
                         alt="banner">
                </div>
            </div>
        </div>
    </div>
</div>
