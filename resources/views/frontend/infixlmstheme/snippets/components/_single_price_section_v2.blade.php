@if(isset($result))
    <div class="row align-items-center">
        @php
            $i=0;
        @endphp
        @foreach($result as $plan)
            @php
                $bg='';
            @endphp
            <div class="col-md-4">
                <div class="price-item position-relative mb-4">
                    <span
                        class="price-item-meta position-absolute text-capitalize bg-{{$plan->popular==1?'primary':'green'}}">{{$plan->title}}</span>
                    <h4><span>{{Settings('currency_symbol')}}</span>{{translatedNumber($plan->price)}}
                        <small>{{translatedNumber($plan->days)}} {{__('common.Days')}}</small></h4>
                    <img src="{{themeAsset('img/shape/vector.svg')}}" alt="">
                    <ul>
                        @foreach($plan->features as $feature )
                            <li>{{$feature->title}}</li>
                        @endforeach
                    </ul>
                    {{--                    <a href="#" class="theme-btn bg-green">{{__('common.Get Started')}}</a>--}}

                    <form action="{{route('courseSubscriptionCheckout')}}">
                        <input type="hidden" name="price"
                               value="{{$plan->price}}">
                        <input type="hidden" name="plan"
                               value="{{$plan->id}}">
                        <button type="submit"
                                class="theme-btn bg-green">
                            {{$plan->btn_txt}}
                        </button>
                    </form>

                </div>
            </div>
        @endforeach
    </div>

@endif
