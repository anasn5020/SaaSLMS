<div data-type="component-text"
     data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/home/homepage_how_to_buy_section.jpg')}}"
     data-aoraeditor-title="HomePage Feature" data-aoraeditor-categories="Home Page">
    <style>
        .modules_area .modile_main_wrap {
            grid-template-columns: repeat(2, 1fr);
        }

        @media (max-width: 767px) {
            .modules_area .modile_main_wrap {
                -ms-grid-columns: 1fr;
                grid-template-columns: repeat(1, 1fr);
            }
        }

    </style>
    <div class="modules_area section__padding_custom">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="modile_main_wrap">

                        <div class="single_module text-center">
                            <div class="icon">
                                <img src="{{asset('public/frontend/infixlmstheme/img/feature/feature1.png')}}" alt=""
                                     style="max-width: 100%">
                            </div>
                            <h2>
                                BobPrep Guarantee
                            </h2>
                            <p>
                                We guarantee you will get a higher score on the GMAT, GRE, or EA, or we will refund you
                            </p>
                        </div>


                        <div class="single_module text-center">
                            <div class="icon">
                                <img src="{{asset('public/frontend/infixlmstheme/img/feature/feature2.png')}}" alt=""
                                     style="max-width: 100%">
                            </div>
                            <h2>
                                Quality Content & Delivery.
                            </h2>
                            <p>
                                Access our platform from anywhere with an internet connection
                            </p>
                        </div>
                        <div class="single_module text-center">
                            <div class="icon">
                                <img src="{{asset('public/frontend/infixlmstheme/img/feature/feature3.png')}}" alt=""
                                     style="max-width: 100%">
                            </div>
                            <h2>
                                Expert Instructors
                            </h2>
                            <p>
                                Best-in-class materials created by subject-matter experts
                            </p>
                        </div>
                        <div class="single_module text-center">
                            <div class="icon">
                                <img src="{{asset('public/frontend/infixlmstheme/img/feature/feature4.png')}}" alt=""
                                     style="max-width: 100%">
                            </div>
                            <h2>
                                Efficient Preparation
                            </h2>
                            <p>
                                Content and tools designed to get you maximum results.
                            </p>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
