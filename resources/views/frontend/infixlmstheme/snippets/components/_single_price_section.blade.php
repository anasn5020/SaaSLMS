@if(isset($result))
    @php
        $setting =\Modules\Subscription\Entities\SubscriptionSetting::first();
    @endphp
    <div class="row g-lg-0 align-items-center justify-content-center">
        @foreach($result as $plan)
            <div class="col">
                <div class="price-item position-relative mb-4">
                    <span class="price-item-meta text-capitalize">{{$plan->title}}</span>
                    <div class="price-item-content">
                        <h4>
                            <span>{{Settings('currency_symbol')}}</span>{{translatedNumber($plan->price)}}

                            <small>{{$plan->days}} {{__('common.Days')}}</small></h4>

                        @if($setting->type==1)
                            <h5>{{__('subscription.All Courses')}}</h5>
                        @elseif($setting->type==2)
                            <h5>
                                <a href="{{route('subscriptionCourseList',$plan->id)}}">{{__('subscription.Selected Courses')}}</a>
                            </h5>
                        @endif
                        <ul>
                            @foreach($plan->features as $feature )
                                <li>{{$feature->title}}</li>
                            @endforeach
                        </ul>
                        <form action="{{route('courseSubscriptionCheckout')}}">
                            <input type="hidden" name="price"
                                   value="{{$plan->price}}">
                            <input type="hidden" name="plan"
                                   value="{{$plan->id}}">
                            <button type="submit"
                                    class="theme-btn">
                                {{$plan->btn_txt}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
