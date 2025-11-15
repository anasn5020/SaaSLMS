<div class="theme_according mb_100" id="accordion1">
    @foreach($result as $key=>$faq)
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
                            <div class="curriculam_left">

                                <span>{!! $faq->answer !!}</span>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
