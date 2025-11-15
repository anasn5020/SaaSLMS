<style>
    .nice-select.small_select {
        min-width: 200px;
    }
</style>
<section class="pricing_plan pt_100 pb_100  bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_tittle mb-3"><h2
                    >{{__('subscription.Pricing Plan & Package')}}</h2>
                    <p></p></div>
            </div>
        </div>
        @if(!request('plan'))

            <div class="row">
                <div class="col-12">
                    <div class="box_header d-flex flex-wrap align-items-center justify-content-center">
                        <div class="box_header_right mb_30">
                            <div class="short_select d-flex align-items-center">
                                <h5 class="mr_10 font_16 f_w_500 mb-0">{{__('frontend.Category')}}:</h5>
                                <select class="small_select" id="category">
                                    <option value=""
                                            data-display="{{__('frontend.All')}}">{{__('frontend.All')}}</option>
                                    @foreach($categories as $key=>$category)
                                        <option value="{{$category->id}}"
                                                @if(request('category')==$category->id) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row row-gap-24 justify-content-center">
            @foreach($plans as $key2=>$plan)
                <div class="col-lg-4 col-sm-6 d-flex">
                    <div
                        class="single_pricing_plan row_padding w-100">
                        <h5>{{$plan->title}}</h5>
                        @if($setting->type==1)
                            <h4>{{__('subscription.All Courses')}}</h4>
                        @elseif($setting->type==2)
                            <h4>
                                <a href="{{route('subscriptionCourseList',$plan->id)}}">{{__('subscription.Selected Courses')}}</a>
                            </h4>
                        @endif
                        <h2>
                            @php
                                $type =Settings('currency_show');
                            @endphp
                            <span
                                class="@if($type==3|| $type==4) right @endif">{{Settings('currency_symbol') }}</span>

                            {{translatedNumber($plan->price)}}</h2>
                        <p class="pb-2">{{$plan->about}}</p>
                        <form action="{{route('courseSubscriptionCheckout')}}">
                            <input type="hidden" name="price"
                                   value="{{$plan->price}}">
                            <input type="hidden" name="plan"
                                   value="{{$plan->id}}">
                            <button type="submit"
                                    class="theme_btn small_btn2 payment-link">
                                {{$plan->btn_txt}}
                            </button>
                        </form>


                    </div>
                </div>
            @endforeach
            @if(count($plans)==0)
                <div class="col-lg-4 col-sm-6 d-flex justify-content-center">
                    <h5>
                        {{__('common.No data Found')}}
                    </h5>
                </div>
            @endif
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-10">
                <div class="features_list pt_100 pb_100 list_style">
                    <h5>{{__('subscription.Included features')}} <span>({{__('subscription.These features for both of the plan')}})</span>
                    </h5>
                    <ul>
                        @foreach($plan_features as $key=>$feature)
                            <li>
                                <i class="fas fa-check-circle"></i>
                                {{$feature->title}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_tittle">
                    <h2>{{__('subscription.Frequently Ask Question')}}</h2>
                </div>
            </div>
            <div class="col-md-10">
                <div class="theme_according" id="accordion1">
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
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $("#category").on('change keyup paste', function (e) {
            let category = $('#category').find(":selected").val();
            let url = "{{route('courseSubscription')}}";
            url += '?category=' + category.toString();
            window.location.href = url;
        });
    });
</script>
