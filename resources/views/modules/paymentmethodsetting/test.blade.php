@extends('backend.master')

@section('mainContent')
    <style>
        .deposit_lists_wrapper {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-gap: 15px;
            margin-bottom: 50px;
        }

        .deposit_lists_wrapper .single_deposite {
            border: 1px solid #ddd;
            padding: 10px 10px;
            border-radius: 5px;
            text-align: center;
            height: 50px;
            display: flex;
            align-content: center;
            justify-content: center;
            align-items: center;
            background: #ffffff;

        }

        .deposit_lists_wrapper .single_deposite img {
            width: 100%;
            max-width: 80px;
        }

        .deposit_lists_wrapper .single_deposite button:not(.primary-btn, .close) {
            padding: 0;
            margin: 0;
            width: 100%;
            background: transparent;
            border: 0;
        }
        .dark .single_deposite select option {
            background: var(--white-box-bg);
        }

        .deposit_lists_wrapper .single_deposite .Payment_btn2 img {
            width: 100% !important;
            max-width: 80px !important;
        }

        @media (max-width: 575.98px) {
            .deposit_lists_wrapper {
                grid-template-columns: repeat(2, 1fr);
                grid-gap: 10px;
            }
        }
    </style>

    <section class="sms-breadcrumb mb-10 white-box">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between">
                <h1>{{__('setting.Payment Method Settings')}}</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">{{__('common.Dashboard')}} </a>
                    <a href="#">{{__('setting.System Settings')}}</a>
                    <a href="#">{{__('setting.Payment Method Settings')}}</a>
                    <a href="#">{{__('common.Test')}}</a>
                </div>
            </div>
        </div>
    </section>
    @php
        $amount =10;
    @endphp
    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-12 ">

                    <div class="white-box ">
                        <div class="row row justify-content-center">
                            <div class="col-12">
                                <div class="box_header common_table_header mb-20">
                                    <div class="main-title d-md-flex">
                                        <h3 class="mt-0">
                                            {{__('common.Test')}}    {{__('payment.Payment')}} {{getPriceFormat($amount)}}
                                        </h3>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="deposit_lists_wrapper mb-50">

                            @if(isset($payment_methods))
                                @foreach($payment_methods as $key=>$gateway)
                                    <div
                                        class="single_deposite {{$gateway->method=="Bank Payment"?'p-0 border-0':''}}">

                                        @if($gateway->method=="Stripe")
                                            <form action="{{route('paymentmethodsetting.test')}}"
                                                  method="post">
                                                @csrf
                                                <input type="hidden" name="method"
                                                       value="{{$gateway->method}}">
                                                <input type="hidden" name="test_amount"
                                                       value="{{$amount}}">
                                                <!-- single_deposite_item  -->
                                                <button type="submit" class="">
                                                    <img
                                                        src="{{asset($gateway->logo)}}"
                                                        alt="">
                                                </button>
                                                @csrf
                                                <script
                                                    src="https://checkout.stripe.com/checkout.js"
                                                    class="stripe-button"
                                                    data-key="{{ getPaymentEnv('STRIPE_KEY') }}"
                                                    data-name="Stripe Payment"
                                                    data-image="{{asset(Settings('favicon') )}}"
                                                    data-locale="auto"
                                                    data-currency="usd">
                                                </script>


                                            </form>
                                        @elseif($gateway->method=="MercadoPago" && isModuleActive('MercadoPago'))

                                            <div class="">

                                                <a href="#" data-bs-toggle="modal"
                                                   data-bs-target="#MakePaymentFromCreditMercadoPago"
                                                   class=" ">
                                                    <img class=" w-100" style="    padding: 0;
                                                                    margin-top: -2px;"
                                                         src="{{asset($gateway->logo)}}"
                                                         alt="">
                                                </a>
                                            </div>


                                            <div class="modal fade "
                                                 id="MakePaymentFromCreditMercadoPago"
                                                 tabindex="-1"
                                                 role="dialog"
                                                 aria-labelledby="exampleModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-lg"
                                                     role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="">MercadoPago</h5>
                                                        </div>


                                                        <div class="modal-body">
                                                            <div class="row">
                                                                @php
                                                                    $total_amount =$amount;
                                                                    $route =route('paymentmethodsetting.test');
                                                                    $payment_type ='Test'
                                                                @endphp
                                                                <div class="col-md-12">
                                                                    @include('mercadopago::partials._checkout',compact('total_amount','payment_type'))
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        @elseif($gateway->method=="RazorPay")

                                            @csrf

                                            <div class="single_deposite_item">

                                                <div class="deposite_button text-center">
                                                    <form action="{{ route('paymentmethodsetting.test') }}"
                                                          method="POST">
                                                        <input type="hidden" name="method"
                                                               value="{{$gateway->method}}">
                                                        <input type="hidden"
                                                               name="test_amount"
                                                               value="{{$amount}}">
                                                        <button type="button"
                                                                class="">
                                                            <img class="submitBtn"
                                                                 src="{{asset($gateway->logo)}}"
                                                                 alt="">
                                                        </button>
                                                        @csrf
                                                        <script
                                                            src="https://checkout.razorpay.com/v1/checkout.js"
                                                            data-key="{{ getPaymentEnv('RAZOR_KEY') }}"
                                                            data-amount="{{ convertCurrency(Settings('currency_code') ??'BDT', 'INR', $amount)*100}}"
                                                            data-name="{{Settings('site_title') }}"
                                                            data-description="Cart Payment"
                                                            data-image="{{asset(Settings('favicon') )}}"
                                                            data-prefill.name="{{ @Auth::user()->username }}"
                                                            data-prefill.email="{{ @Auth::user()->email }}"
                                                            data-theme.color="#ff7529">
                                                        </script>
                                                    </form>
                                                </div>
                                            </div>

                                        @elseif($gateway->method=="PayPal")

                                            <form action="{{route('paymentmethodsetting.test')}}"
                                                  method="post">
                                                @csrf
                                                <input type="hidden" name="method"
                                                       value="{{$gateway->method}}">
                                                <input type="hidden" name="test_amount"
                                                       value="{{$amount}}">
                                                <button type="submit" class="">
                                                    <img class=""
                                                         src="{{asset($gateway->logo)}}"
                                                         alt="">
                                                </button>

                                            </form>
                                        @elseif($gateway->method=="PayTM")

                                            @includeIf('paytm::paytm_btn',['type'=>'test'])

                                        @elseif($gateway->method=="PayStack")

                                            <form action="{{route('paymentmethodsetting.test')}}"
                                                  method="post">
                                                @csrf

                                                <input type="hidden" name="email"
                                                       value="{{ @Auth::user()->email}}"> {{-- required --}}
                                                <input type="hidden" name="orderID"
                                                       value="{{md5(uniqid(rand(), true))}}">
                                                <input type="hidden" name="amount"
                                                       value="{{$amount*100}}">
                                                <input type="hidden" name="test_amount"
                                                       value="{{$amount*100}}">

                                                <input type="hidden" name="currency"
                                                       value="{{Settings('currency_code')}}">
                                                <input type="hidden" name="metadata"
                                                       value="{{ json_encode($array = ['type' => 'Test',]) }}">
                                                <input type="hidden" name="reference"
                                                       value="{{ Paystack::genTranxRef() }}"> {{-- required --}}

                                                <input type="hidden" name="method"
                                                       value="{{$gateway->method}}">

                                                <button type="submit" class="">
                                                    <img
                                                        src="{{asset($gateway->logo)}}"
                                                        alt="">
                                                </button>

                                            </form>

                                        @elseif($gateway->method=="RazerMS")
                                            <form action="{{route('paymentmethodsetting.test')}}"
                                                  method="post">
                                                @csrf

                                                <input type="hidden" name="test_amount"
                                                       value="5">
                                                <input type="hidden" name="method"
                                                       value="{{$gateway->method}}">

                                                <button type="submit" class="">
                                                    <img
                                                        src="{{asset($gateway->logo)}}"
                                                        alt="">
                                                </button>

                                            </form>
                                        @elseif($gateway->method=="Bank Payment")
                                            <form class="w-100" action="" method="post">
                                                @csrf

                                                <a href="#" data-bs-toggle="modal"
                                                   data-bs-target="#bankModel"
                                                   class="payment_btn_text2 w-100">
                                                    {{$gateway->method}}
                                                </a>
                                            </form>
                                        @elseif($gateway->method == 'Authorize.Net')
                                            @includeIf('authorizenet::test',['gateway' => $gateway])
                                        @elseif($gateway->method == 'Braintree')
                                            @includeIf('braintree::test',['gateway' => $gateway])
                                        @elseif($gateway->method == 'Mollie')
                                            @includeIf('mollie::test',['gateway' => $gateway])
                                        @elseif($gateway->method == 'Flutterwave')
                                            @includeIf("flutterwave::test",['gateway' => $gateway])
                                        @elseif($gateway->method == 'Coinbae')
                                            @includeIf("coinbase::test",['gateway' => $gateway])
                                        @elseif($gateway->method == 'Jazz Cash')
                                            @includeIf("jazzcash::test",['gateway' => $gateway])
                                        @elseif($gateway->method == 'CCAvenue')
                                            @includeIf('ccavenue::test_payment',['gateway' => $gateway])

                                        @else

                                            <form action="{{route('paymentmethodsetting.test')}}"
                                                  method="post">
                                                @csrf
                                                <input type="hidden" name="method"
                                                       value="{{$gateway->method}}">
                                                <input type="hidden" name="test_amount"
                                                       value="{{$amount}}">
                                                <button type="submit" class="">
                                                    <img
                                                        src="{{asset($gateway->logo)}}"
                                                        alt="">
                                                </button>

                                            </form>

                                        @endif


                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>


                </div>


            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/gateway.js')}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/deposit.js')}}"></script>
@endpush
