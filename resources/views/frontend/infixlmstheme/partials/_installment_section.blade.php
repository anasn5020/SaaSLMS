<style>
    .installment-price.active .circle::before, .installment-price.active::before, .installment-price.checked .circle::before, .installment-price.checked::before {
        background: var(--system_primery_color)
    }

    /* .dots_checked {
        background: var(--system_primery_color)
    } */

    .installment-payment {
        border-radius: 24px;
        margin-bottom: 54px
    }

    .installment-payment .progress, .installment-payment .progress-bar {
        border-radius: 100px
    }

    .installment-payment h3 {
        border-bottom: 1px solid #e9e7f7;
        margin-bottom: 30px;
        padding-bottom: 20px
    }

    .installment-payment h4 {
        font-size: 18px;
        line-height: 1.2;
        margin-bottom: 20px;
        font-weight: 500
    }

    .installment-payment ul {
        border-radius: 24px;
        padding: 24px 30px;
        background-color: #eceffd;
        row-gap: 10px;
        margin-top: 40px
    }

    @media (max-width: 767.98px) {
        .installment-payment h4 {
            margin-bottom: 10px
        }

        .installment-payment ul {
            margin-top: 24px
        }
    }

    .installment-payment ul li {
        flex: 0 0 auto;
        font-size: 14px;
        color: #2d375a;
        font-weight: 700;
        margin-right: 20px
    }

    /* .installment-payment ul li:nth-child(3n+3) {
        margin-right: 0
    } */

    @media (min-width: 992px) and (max-width: 1339px) {
        .installment-payment ul li:nth-child(3n+3) {
            margin-right: 20px
        }
    }

    .installment-payment ul li i {
        color: #00ca81;
        margin-right: 10px
    }

    .installment-price {
        flex: 0 0 auto;
        width: calc(100% / 12 * 3);
        position: relative
    }

    .installment-price:first-child::before {
        display: none
    }

    .installment-price::before {
        content: "";
        width: 100%;
        height: 2px;
        background-color: #d1d5db;
        position: absolute;
        left: -47px;
        top: 16px;
        z-index: -1
    }

    .installment-price.active .circle, .installment-price.checked .circle {
        border-color: var(--system_primery_color)
    }

    .dots_checked {
        border-color: var(--system_primery_color)
    }

    .installment-price.checked .circle::before {
        content: "\f00c";
        transform: translate(-50%, -50%) scale(1.1)
    }

    .installment-price.active .circle::before, .installment-price.dots .circle::before {
        content: ""
    }

    .installment-price .circle {
        --width: 32px;
        width: var(--width);
        height: var(--width);
        border-radius: 100%;
        margin: auto auto 16px;
        border: 2px solid #9ca3af;
        position: relative;
        z-index: 1;
        background-color: #fff;
        animation: none
    }

    .installment-price .circle::before {
        width: 100%;
        height: 100%;
        background-color: #d1d5db;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(.36);
        border-radius: 100%;
        font-family: "Font Awesome 5 Free";
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center
    }

    .installment-price h6 {
        font-size: 14px;
        line-height: 1.16667;
        font-weight: 700;
        color: #505050
    }

    @media (min-width: 992px) and (max-width: 1199.98px) {
        .installment-price h6 {
            font-size: 14px
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 991.98px) {
        .installment-payment ul li {
            font-size: 13px
        }

        .installment-price h6 {
            font-size: 14px
        }
    }

    .text-primary {
        color: var(--system_primery_color) !important
    }

    .installment_progress {
        background: var(--system_primery_color) !important;
    }

    .installment-payment .theme_btn {
        padding: 12px 18px !important;
    }

    .installment_card {
        border: 1px solid #e9e7f7;
        padding: 20px;
        border-radius: 24px;
        margin-bottom: 20px;
    }

    .installment-price .active_circle {
        border: 2px solid #fb1159 !important;

    }
</style>

@php
    $topic_price = 0;
        if ($course->discount_price != null) {
            $topic_price = $course->discount_price;
        } else {
            $topic_price = $course->price;
        }
@endphp
<div class="installment-payment installment_card">
    <h3 class="font_22">
        {{$installment_plan->title}}
    </h3>
    <div class="row">
        <div class="col-md-8">
            <h4>
                {{_trans('installment.Installment Timeline')}}
            </h4>
            <div class="d-flex align-items-center">
                @foreach ($installment_plan->paymentSteps as $key => $payment_step)

                    <div class="installment-price dots text-center">
                        <div class="circle {{$key ==0? 'active_circle' :''}}"></div>
                        <span class="font_14 d-block mb-1">
                                    {{$payment_step->payment_title}}
                                </span>
                        <h6>
                            @if($payment_step->amount_type=='percent')
                                @php
                                    $amount = ($topic_price*$payment_step->payment_amount)/100;
                                    echo getPriceFormat($amount).' ('.$payment_step->payment_amount.'%)';
                                @endphp
                            @else
                                {{getPriceFormat($payment_step->payment_amount)}}
                            @endif

                        </h6>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-4 mt-3 mt-lg-0">
            <h4>{{_trans('installment.Capacity')}}</h4>
            <div class="text-end ">
                <div class="progress">
                    <div class="progress-bar installment_progress" role="progressbar"
                         style="width: {{$installment_plan->planCapacity()['booked_percentage']}}%"
                         aria-valuenow="{{$installment_plan->planCapacity()['booked_percentage']}}" aria-valuemin="0"
                         aria-valuemax="100">
                    </div>
                </div>
                <div class="text-primary font_14 mt-2">{{$installment_plan->planCapacity()['booked_percentage']}}
                    % {{_trans('installment.Capacity Fillup')}} </div>
                <a href="{{route('installment.purchase',[@$course->id,$installment_plan->id])}}"
                   class="theme_btn mt-3 mt-lg-4  text-center ">{{_trans('installment.Pay in Installments')}}</a>
            </div>
        </div>
    </div>
    <ul class="d-flex align-items-center flex-wrap">
        @foreach ($installment_plan->features as $feature)
            <li>
                <i class="fa fa-check"></i>
                <span>
                            {{$feature->title}}
                        </span>
            </li>
        @endforeach
    </ul>
</div>
