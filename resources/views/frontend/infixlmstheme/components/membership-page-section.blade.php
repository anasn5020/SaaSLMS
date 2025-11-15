<section class="pricing_plan pt_100 pb_100 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_tittle mb-4">
                    <h2 class="mb-0 fw-bold">{{ __('membership.Membership Pricing Plan & Package') }}</h2>
                </div>
            </div>
        </div>
        <div class="row row-gap-24 justify-content-center">
            @foreach ($plans as $key2 => $plan)
                <div class="col-lg-4 col-sm-6 d-flex mt-4">
                    <div class="single_pricing_plan row_padding w-100">
                        <h5>{{ $plan->title }}</h5>
                        <h4>
                            <a href="{{route('membershipCourseEbookList',$plan->id)}}">{{__('membership.Selected Courses & Ebooks')}}</a>
                        </h4>
                        <h2 class="mb-3">
                            @php
                                $type = Settings('currency_show');
                            @endphp
                            <span
                                class="@if ($type == 3 || $type == 4) right @endif">{{ Settings('currency_symbol') }}</span>
                            {{ $plan->price }}.00
                        </h2>
                        / {{ $plan->expire !=1 ? '('.$plan->expire.')' :'' }}
                        {{ $plan->expire_type }}
                        <p class="pb-2">{{ $plan->detail }}</p>
                        <form
                            action="{{ route('membershipPlanCheckout') }}">
                            <input type="hidden" name="price"
                                   value="{{ $plan->price }}">
                            <input type="hidden" name="plan_id"
                                   value="{{ $plan->id }}">
                            <button type="submit"
                                    class="theme_btn small_btn2 payment-link">
                                {{ $plan->btn_txt ?? __('membership.Started Now') }}
                            </button>
                        </form>


                    </div>
                </div>
            @endforeach
        </div>
        @isset($plan_features)
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="features_list pt_100 pb_100 list_style  ">
                        <h5>{{ __('subscription.Included features') }}
                            <span>({{ __('subscription.These features for both of the plan') }})</span>
                        </h5>
                        <ul>
                            @foreach ($plan_features as $key => $feature)
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    {{ $feature->title }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endisset
        @isset($faqs)
            <div class="row">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <h3 style="text-align: center;margin-bottom: 72px;">
                                {{ __('subscription.Frequently Ask Question') }} </h3>
                            <div class="theme_according mb_100" id="accordion1">
                                @foreach ($faqs as $key => $faq)
                                    <div class="card">
                                        <div class="card-header pink_bg"
                                             id="headingFour{{ $key }}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link text_white collapsed"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseFour{{ $key }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapseFour{{ $key }}">
                                                    {{ $faq->question }}
                                                </button>
                                            </h5>
                                        </div>
                                        <div class="collapse" id="collapseFour{{ $key }}"
                                             aria-labelledby="headingFour{{ $key }}"
                                             data0bs-parent="#accordion1">
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
            </div>
        @endisset
    </div>
</section>
