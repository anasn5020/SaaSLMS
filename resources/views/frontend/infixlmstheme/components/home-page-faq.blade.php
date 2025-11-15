<div>
    <div class="blog_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section__title text-center mb_80">
                        <h3>
                            {{@$homeContent->home_page_faq_title}}
                        </h3>
                        <p>
                            {{@$homeContent->home_page_faq_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="theme_according mb_100" id="accordion1">
                        @foreach($faqs as $key=>$faq)
                            <div class="card">
                                <div class="card-header pink_bg" id="headingFour{{$key}}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link text_white collapsed"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseFour{{$key}}"
                                                aria-expanded="false"
                                                aria-controls="collapseFour{{$key}}">
                                            {{$faq->question}}
                                        </button>
                                    </h5>
                                </div>
                                <div class="collapse" id="collapseFour{{$key}}"
                                     aria-labelledby="headingFour{{$key}}"
                                     data-bs-parent="#accordion1">
                                    <div class="card-body">
                                        <div class="curriculam_list">

                                            <div class="curriculam_single">
                                                <div class="">

                                                    <span>{!! $faq->answer !!}</span>
                                                </div>

                                            </div>

                                        </div>
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
