@php
    $user = Auth::user() ?? session()->get('membershipUser');
@endphp
<div class="container">

    <div class="checkout_wrapper payment_area" id="mainFormData">

        <div class="billing_details_wrapper">
            <div class="biling_address gray-bg">
                <div class="biling-header d-flex justify-content-between align-items-center">
                    <h4>{{__('frontendmanage.Billing Address')}}</h4>
                    <a href="{{ route('CheckOut') }}?type=edit">{{__('common.Edit')}}</a>
                </div>
                <div class="biling_body_content">
                    <p>{{ @$bill->first_name }} {{ @$bill->last_name }}</p>
                    <p>{{ @$bill->address }}</p>
                    <p>{{ @$bill->city }} - {{ @$bill->zip_code }} </p>
                    <p>  {{ @$bill->countryDetails->name }} </p>
                </div>
            </div>
            <div class="select_payment_method">
                <div class="input_box_tittle">
                    <h4>@lang('frontendmanage.Payment Method')</h4>
                </div>

                <div class="privaci_polecy_area section-padding checkout_area ">
                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <div class="payment_method_wrapper">
                                    @if(isset($methods))
                                        @foreach($methods as $key=>$gateway)
                                            @php
                                                if (!paymentGateWayCredentialsEmptyCheck($gateway->method)){
                                                continue;
                                                }
                                            @endphp
                                            <div class="payment_method_single">
                                                <div
                                                    class="deposite_payment_wrapper customer_payment_wrapper">
                                                    @if($gateway->method=="Stripe")
                                                        <form
                                                            action="{{route('membershipPaymentSubmit')}}"
                                                            method="post">

                                                            <input type="hidden"
                                                                   name="id"
                                                                   value="">
                                                            @csrf
                                                            <input type="hidden"
                                                                   name="payment_method"
                                                                   value="{{$gateway->method}}">
                                                            <!-- single_deposite_item  -->
                                                            <button type="submit"
                                                                    class="Payment_btn">
                                                                <img class=" w-100 "
                                                                     style="padding: 12px;
                                        margin-top: -9px;"
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

                                                            <input
                                                                value="{{ convertCurrency(Settings('currency_code') ??'BDT', 'USD', $checkout->purchase_price)}}"
                                                                readonly="readonly"
                                                                type="hidden"
                                                                id="amount"
                                                                name="amount">


                                                        </form>
                                                    @elseif($gateway->method=="MercadoPago")

                                                        <div class="">

                                                            <a href="#" data-bs-toggle="modal"
                                                               data-bs-target="#MakePaymentFromCreditMercadoPago"
                                                               class=" Payment_btn">
                                                                <img class=" w-100" style="    padding: 0;
                                                                    margin-top: -2px;"
                                                                     src="{{asset($gateway->logo)}}"
                                                                     alt="">
                                                            </a>
                                                        </div>


                                                        <div class="modal fade " id="MakePaymentFromCreditMercadoPago"
                                                             tabindex="-1"
                                                             role="dialog" aria-labelledby="exampleModalLabel"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="">MercadoPago</h5>
                                                                    </div>


                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            @php
                                                                                $total_amount =$checkout->purchase_price;
                                                                                $route =route('membershipPaymentSubmit');
                                                                                 $payment_type ='Subscription'
                                                                            @endphp
                                                                            <div class="col-md-12">
                                                                                @include('mercadopago::partials._checkout',compact('total_amount','route','payment_type'))
                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    @elseif($gateway->method=="Wallet")

                                                        <form
                                                            action="{{route('membershipPaymentSubmit')}}"
                                                            method="post">

                                                            @csrf

                                                            <div class="bank_check">

                                                                <a href="#"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#MakePaymentFromCredit"
                                                                   class=" payment_btn_text">Wallet</a>

                                                            </div>
                                                        </form>

                                                        <div class="modal fade "
                                                             id="MakePaymentFromCredit"
                                                             tabindex="-1"
                                                             role="dialog"
                                                             aria-labelledby="exampleModalLabel"
                                                             aria-hidden="true">
                                                            <div
                                                                class="modal-dialog modal-lg"
                                                                role="document">
                                                                <div
                                                                    class="modal-content">
                                                                    <div
                                                                        class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="exampleModalLabel">
                                                                            Subscription
                                                                            submit</h5>
                                                                    </div>
                                                                    <form
                                                                        action="{{route('membershipPaymentSubmit')}}"
                                                                        id="infix_payment_form1"
                                                                        method="POST"
                                                                        name="payment_main_balance">
                                                                        @csrf

                                                                        <input
                                                                            type="hidden"
                                                                            name="payment_method"
                                                                            value="{{$gateway->method}}">
                                                                        <input
                                                                            name="payment_method"
                                                                            value="Wallet"
                                                                            id="balanceInput"
                                                                            style="display: {{$user->balance >=$checkout->purchase_price?'':'none'}}"
                                                                            class="method"
                                                                            type="hidden">


                                                                        <div
                                                                            class="modal-body">
                                                                            <div
                                                                                class="row">
                                                                                <div
                                                                                    class="col-xl-6 col-md-6">
                                                                                    <label
                                                                                        for="name"
                                                                                        class="mb-2">{{__('frontend.Balance')}}</label>
                                                                                    <input
                                                                                        type="text"
                                                                                        class="primary_input3"
                                                                                        value="@if($user->balance==0)
                                                                                        {{Settings('currency_symbol') ??'৳'}} 0  @else   {{getPriceFormat($user->balance)}}
                                                                                        @endif"
                                                                                        readonly>
                                                                                </div>
                                                                                <div
                                                                                    class="col-xl-6 col-md-6">
                                                                                    <label
                                                                                        for="name"
                                                                                        class="mb-2">@lang('subscription.Subscription Price')</label>
                                                                                    <input
                                                                                        type="text"
                                                                                        name="amount"
                                                                                        class="primary_input3"
                                                                                        value="{{getPriceFormat($checkout->purchase_price)}}"

                                                                                        readonly>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                        <div
                                                                            class="modal-footer payment_btn d-flex justify-content-between">
                                                                            <button
                                                                                type="button"
                                                                                class="theme_line_btn"
                                                                                data-bs-dismiss="modal">@lang('common.Cancel')</button>

                                                                            @if ($user->balance >= $checkout->purchase_price)
                                                                                <button
                                                                                    class=" theme_btn"
                                                                                    type="submit">
                                                                                    @lang('common.Pay')
                                                                                </button>
                                                                            @else
                                                                                <a class="theme_btn"
                                                                                   href="{{route('deposit')}}">{{__('common.Deposit')}}</a>
                                                                            @endif
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif($gateway->method=="RazorPay")

                                                        @csrf

                                                        <div
                                                            class="single_deposite_item">

                                                            <div
                                                                class="deposite_button text-center">
                                                                <form
                                                                    action="{{ route('membershipPaymentSubmit') }}"
                                                                    method="POST">
                                                                    <input type="hidden"
                                                                           name="payment_method"
                                                                           value="{{$gateway->method}}">
                                                                    <button
                                                                        type="submit"
                                                                        class="Payment_btn">
                                                                        <img
                                                                            class=" w-100"
                                                                            style="padding: 0;
                                        margin-top: -2px;"
                                                                            src="{{asset($gateway->logo)}}"
                                                                            alt="">
                                                                    </button>

                                                                    @csrf
                                                                    <script
                                                                        src="https://checkout.razorpay.com/v1/checkout.js"
                                                                        data-key="{{ getPaymentEnv('RAZOR_KEY') }}"
                                                                        data-amount="{{ convertCurrency(Settings('currency_code') ??'BDT', 'INR', $checkout->purchase_price)*100}}"
                                                                        data-name="{{Settings('site_title') }}"
                                                                        data-description="Cart Payment"
                                                                        data-image="{{asset(Settings('favicon') )}}"
                                                                        data-prefill.name="{{ @$user->username }}"
                                                                        data-prefill.email="{{ @$user->email }}"
                                                                        data-theme.color="#ff7529">
                                                                    </script>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    @elseif($gateway->method=="PayPal")

                                                        <form
                                                            action="{{route('membershipPaymentSubmit')}}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden"
                                                                   name="id"
                                                                   value="{{$plan->id}}">

                                                            <input type="hidden"
                                                                   name="id"
                                                                   value="{{$plan->id}}">

                                                            <input type="hidden"
                                                                   name="payment_method"
                                                                   value="{{$gateway->method}}">

                                                            <button type="submit"
                                                                    class="Payment_btn">
                                                                <img class=" w-100"
                                                                     style="    padding: 0;
                                        margin-top: -2px;"
                                                                     src="{{asset($gateway->logo)}}"
                                                                     alt="">
                                                            </button>

                                                        </form>
                                                    @elseif($gateway->method=="PayTM")

                                                        <form
                                                            action="{{route('membershipPaymentSubmit')}}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden"
                                                                   name="payment_method"
                                                                   value="{{$gateway->method}}">

                                                            <button type="submit"
                                                                    class="Payment_btn">
                                                                <img class=" w-100"
                                                                     style="    padding: 10px;
                                        margin-top: -6px;"
                                                                     src="{{asset($gateway->logo)}}"
                                                                     alt="">
                                                            </button>

                                                        </form>
                                                    @elseif($gateway->method=="PayStack")

                                                        <form
                                                            action="{{route('membershipPaymentSubmit')}}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden"
                                                                   name="email"
                                                                   value="{{ @$user->email}}"> {{-- required --}}

                                                            <input type="hidden"
                                                                   name="amount"
                                                                   value="{{ convertCurrency(Settings('currency_code') ??'BDT', Settings('currency_code'), 999)*100}}"> {{-- required in kobo --}}

                                                            <input type="hidden" name="currency"
                                                                   value="{{Settings('currency_code')}}">

                                                            <input type="hidden"
                                                                   name="metadata"
                                                                   value="{{ json_encode($array = ['type' => 'Subscription',]) }}">
                                                            <input type="hidden"
                                                                   name="reference"
                                                                   value="{{ Paystack::genTranxRef() }}"> {{-- required --}}

                                                            <input type="hidden"
                                                                   name="payment_method"
                                                                   value="{{$gateway->method}}">

                                                            <button type="submit"
                                                                    class="Payment_btn">
                                                                <img class=" w-100"
                                                                     style="    padding: 10px;
                                        margin-top: -6px;"
                                                                     src="{{asset($gateway->logo)}}"
                                                                     alt="">
                                                            </button>

                                                        </form>

                                                    @else

                                                        <form
                                                            action="{{route('membershipPaymentSubmit')}}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden"
                                                                   name="payment_method"
                                                                   value="{{$gateway->method}}">

                                                            <button type="submit"
                                                                    class="Payment_btn">
                                                                <img class=" w-100"
                                                                     src="{{asset($gateway->logo)}}"
                                                                     alt="">
                                                            </button>

                                                        </form>

                                                    @endif

                                                </div>

                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="order_wrapper">
            <h3 class="font_22 f_w_700 mb_30">{{__('frontend.Your order')}}</h3>
            <div class="ordered_products">

                <div class="single_ordered_product">
                    <div class="product_name d-flex align-items-center">

                        <span>{{__('frontend.Plan Title')}}</span>
                    </div>
                    <span class="order_prise f_w_500 font_16">
                           {{@$cart->plan->title}}
                            </span>
                </div>

                <div class="single_ordered_product">
                    <div class="product_name d-flex align-items-center">
                        <span>{{__('frontend.Plan Validity')}}</span>
                    </div>
                    <span class="order_prise f_w_500 font_16">
                           {{@$cart->plan->expire}} [{{@$cart->plan->expire_type}}]
                            </span>
                </div>

            </div>
            <div class="ordered_products_lists">


                <div class="single_lists">
                    <span class="total_text">{{__('frontend.Payable Amount')}} </span>
                    <span class="totalBalance"> {{getPriceFormat($checkout->purchase_price)}}</span>

                </div>

            </div>

        </div>
    </div>
</div>
