<div class="accordion" id="faq-section">

    @foreach($result as $key=>$faq)

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button {{$key==0?'':'collapsed'}}" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faq{{$key}}" aria-expanded="{{$key?"true":"false"}}" aria-controls="faq{{$key}}">
                <div class="faq-title">
                    {{$faq->question}}
                </div>
            </button>
        </h2>
        <div id="faq{{$key}}" class="accordion-collapse collapse {{$key==0?' show':''}} " aria-labelledby="faq{{$key}}"
             data-bs-parent="#faq-section">
            <div class="accordion-body">
                {!! $faq->answer !!}
            </div>
        </div>
    </div>


    @endforeach
</div>
