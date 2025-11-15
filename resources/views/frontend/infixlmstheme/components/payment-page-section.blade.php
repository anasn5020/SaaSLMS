@php use Modules\Invoice\Entities\PrintedCertificate; @endphp
<div class="container">
    <div class="checkout_wrapper payment_area" id="mainFormData">

        <div class="billing_details_wrapper">
            <div class="biling_address gray-bg">
                <div class="biling-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('frontendmanage.Billing Address') }}</h4>

                    @if(isModuleActive('Invoice') && ($type == 'invoice' || $type == 'certificate' ))
                        <a class="billingUpdate">{{ __('common.Edit') }}</a>
                        <a class="billingUpdateShow d-none">{{ __('common.Show') }}</a>
                    @else
                        <a href="{{ route('CheckOut') }}?type=edit">{{ __('common.Edit') }}</a>
                    @endif
                </div>
                <div class="biling_body_content" id="deafult">
                    <p>{{ @$checkout->billing->first_name }} {{ @$checkout->billing->last_name }}</p>
                    <p>{{ @$checkout->billing->address }}</p>
                    <p>{{ @$checkout->billing->stateDetails->name }},{{ @$checkout->billing->cityDetails->name }} -
                        {{ @$checkout->billing->zip_code }} </p>
                    <p> {{ @$checkout->billing->countryDetails->name }} </p>
                </div>

            </div>
            @if(isModuleActive('Invoice'))
                @includeIf('invoice::billing')
            @endif
            <div class="select_payment_method">
                <div class="input_box_tittle">
                    <h4>@lang('frontendmanage.Payment Method')</h4>

                </div>

                <div class="privaci_polecy_area section-padding checkout_area ">
                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <div class="payment_method_wrapper">

                                    @if (isset($methods))
                                        @php
                                            $withMoule = $methods;

                                            $methods = $methods->where('method', '!=', 'Bank Payment')->where('method', '!=', 'Offline Payment');
                                            $payment_type = isModuleActive('Invoice') && $checkout->invoice ? $checkout->invoice->payment_type : null;
                                            if (isModuleActive('Invoice') && $payment_type == 2) {
                                                $methods = $withMoule->where('method', 'Bank Payment');
                                            }

                                        @endphp

                                        @foreach ($methods as $key => $gateway)
                                            @php
                                                if (!paymentGateWayCredentialsEmptyCheck($gateway->method)) {
                                                    continue;
                                                }
                                            @endphp
                                            <div class="payment_method_single">
                                                <div class="deposite_payment_wrapper customer_payment_wrapper">
                                                    @if ($gateway->method == 'Stripe')
                                                        <form action="{{ route('paymentSubmit') }}" method="post">

                                                            <input type="hidden" name="tracking_id"
                                                                   value="{{ $checkout->tracking }}">
                                                            <input type="hidden" name="id"
                                                                   value="{{ $checkout->id }}">
                                                            @csrf
                                                            <input type="hidden" name="payment_method"
                                                                   value="{{ $gateway->method }}">
                                                            <!-- single_deposite_item  -->
                                                            <button type="submit" class="Payment_btn">
                                                                <img class=" w-100 "
                                                                     style="padding: 12px; margin-top: -9px;"
                                                                     src="{{ asset($gateway->logo) }}" alt="">
                                                            </button>
                                                            @csrf
                                                            <script src="https://checkout.stripe.com/checkout.js"
                                                                    class="stripe-button"
                                                                    data-key="{{ getPaymentEnv('STRIPE_KEY') }}"
                                                                    data-name="Stripe Payment"
                                                                    data-image="{{ asset(Settings('favicon')) }}"
                                                                    data-locale="auto" data-currency="usd"></script>

                                                            <input hidden
                                                                   value="{{ convertCurrency(Settings('currency_code') ?? 'BDT', 'USD', $checkout->purchase_price) }}"
                                                                   readonly="readonly" type="text" id="amount"
                                                                   name="amount">


                                                        </form>
                                                    @elseif($gateway->method == 'Wallet')
                                                        <form action="{{ route('paymentSubmit') }}" method="post">

                                                            @csrf

                                                            <div class="bank_check">

                                                                <a href="#" data-bs-toggle="modal"
                                                                   data-bs-target="#MakePaymentFromCredit"
                                                                   class=" payment_btn_text">{{__('payment.Wallet')}}</a>

                                                            </div>
                                                        </form>

                                                        <div class="modal fade " id="MakePaymentFromCredit"
                                                             tabindex="-1" role="dialog"
                                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            {{ __('student.My Account') }}</h5>
                                                                    </div>
                                                                    <form action="{{ route('paymentSubmit') }}"
                                                                          id="infix_payment_form1" method="POST"
                                                                          name="payment_main_balance">
                                                                        @csrf

                                                                        <input type="hidden" name="payment_method"
                                                                               value="{{ $gateway->method }}">
                                                                        <input name="payment_method" value="Wallet"
                                                                               id="balanceInput"
                                                                               style="display: {{ Auth::user()->balance >= $checkout->purchase_price ? '' : 'none' }}"
                                                                               class="method" type="hidden">
                                                                        <input type="hidden" name="tracking_id"
                                                                               value="{{ $checkout->tracking }}">
                                                                        <input type="hidden" name="id"
                                                                               value="{{ $checkout->id }}">


                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="col-xl-6 col-md-6">
                                                                                    <label for="name"
                                                                                           class="mb-2">{{ __('frontend.Balance') }}</label>
                                                                                    <input type="text"
                                                                                           class="primary_input3"
                                                                                           value="@if (Auth::user()->balance == 0) {{ Settings('currency_symbol') ?? '৳' }}0 @else{{ getPriceFormat(Auth::user()->balance) }} @endif"
                                                                                           readonly>
                                                                                </div>
                                                                                <div class="col-xl-6 col-md-6">
                                                                                    <label for="name"
                                                                                           class="mb-2">@lang('common.Purchase Price')</label>
                                                                                    <input type="text" name="amount"
                                                                                           class="primary_input3"
                                                                                           value="{{ getPriceFormat($checkout->purchase_price) }}"
                                                                                           readonly>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                        <div
                                                                            class="modal-footer payment_btn d-flex justify-content-between">
                                                                            <button type="button"
                                                                                    class="theme_line_btn"
                                                                                    data-bs-dismiss="modal">@lang('common.Cancel')</button>

                                                                            @if (Auth::user()->balance >= $checkout->purchase_price)
                                                                                <button class=" theme_btn"
                                                                                        type="submit">
                                                                                    @lang('common.Pay')
                                                                                </button>
                                                                            @else
                                                                                <a class="theme_btn"
                                                                                   href="{{ route('deposit') }}">{{ __('common.Deposit') }}</a>
                                                                            @endif
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif($gateway->method == 'MercadoPago')
                                                        <div class="">

                                                            <a href="#" data-bs-toggle="modal"
                                                               data-bs-target="#MakePaymentFromCreditMercadoPago"
                                                               class=" Payment_btn">
                                                                <img class=" w-100"
                                                                     style="    padding: 0;
                                                                        margin-top: -2px;"
                                                                     src="{{ asset($gateway->logo) }}" alt="">
                                                            </a>
                                                        </div>


                                                        <div class="modal fade " id="MakePaymentFromCreditMercadoPago"
                                                             tabindex="-1" role="dialog"
                                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="">
                                                                            MercadoPago</h5>
                                                                    </div>


                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            @php
                                                                                $total_amount = $checkout->purchase_price;
                                                                                $route = route('paymentSubmit');
                                                                            @endphp
                                                                            <div class="col-md-12">
                                                                                @include('mercadopago::partials._checkout',
                                                                                    compact(
                                                                                        'total_amount',
                                                                                        'checkout'
                                                                                    ))
                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif($gateway->method == 'RazorPay')
                                                        @csrf

                                                        <div class="single_deposite_item">

                                                            <div class="deposite_button text-center">
                                                                <form action="{{ route('paymentSubmit') }}"
                                                                      method="POST">
                                                                    <input type="hidden" name="payment_method"
                                                                           value="{{ $gateway->method }}">
                                                                    <button type="submit" class="Payment_btn">
                                                                        <img class=" w-100"
                                                                             style="padding: 0; margin-top: -2px;"
                                                                             src="{{ asset($gateway->logo) }}"
                                                                             alt="">
                                                                    </button>
                                                                    <input type="hidden" name="tracking_id"
                                                                           value="{{ $checkout->tracking }}">
                                                                    <input type="hidden" name="id"
                                                                           value="{{ $checkout->id }}">
                                                                    @csrf
                                                                    <script
                                                                        src="https://checkout.razorpay.com/v1/checkout.js"
                                                                        data-key="{{ getPaymentEnv('RAZOR_KEY') }}"
                                                                        data-amount="{{ convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $checkout->purchase_price) * 100 }}"
                                                                        data-name="{{ str_replace('_', ' ', Settings('site_title')) }}"
                                                                        data-description="Cart Payment"
                                                                        data-image="{{ asset(Settings('favicon')) }}"
                                                                        data-prefill.name="{{ @Auth::user()->username }}"
                                                                        data-prefill.email="{{ @Auth::user()->email }}"
                                                                        data-theme.color="#ff7529"></script>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @elseif($gateway->method == 'PayPal')
                                                        <form action="{{ route('paymentSubmit') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="payment_method"
                                                                   value="{{ $gateway->method }}">
                                                            <input type="hidden" name="tracking_id"
                                                                   value="{{ $checkout->tracking }}">
                                                            <input type="hidden" name="id"
                                                                   value="{{ $checkout->id }}">
                                                            <button type="submit" class="Payment_btn">
                                                                <img class=" w-100"
                                                                     style="    padding: 0;
                                                                        margin-top: -2px;"
                                                                     src="{{ asset($gateway->logo) }}" alt="">
                                                            </button>

                                                        </form>
                                                    @elseif($gateway->method == 'PayTM')

                                                        @includeIf('paytm::paytm_btn',['type'=>'payment','amount'=>$checkout->purchase_price])
                                                    @elseif($gateway->method == 'PayStack')
                                                        <form action="{{ route('paymentSubmit') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="email"
                                                                   value="{{ @Auth::user()->email }}">
                                                            {{-- required --}}
                                                            <input type="hidden" name="orderID"
                                                                   value="{{ $checkout->tracking }}">
                                                            <input type="hidden" name="amount"
                                                                   value="{{ $checkout->purchase_price * 100 }}">
                                                            {{-- required in kobo --}}

                                                            <input type="hidden" name="currency"
                                                                   value="{{ Settings('currency_code') }}">
                                                            <input type="hidden" name="metadata"
                                                                   value="{{ json_encode($array = ['type' => 'Payment']) }}">
                                                            <input type="hidden" name="reference"
                                                                   value="{{ Paystack::genTranxRef() }}">
                                                            {{-- required --}}

                                                            <input type="hidden" name="payment_method"
                                                                   value="{{ $gateway->method }}">
                                                            <input type="hidden" name="tracking_id"
                                                                   value="{{ $checkout->tracking }}">
                                                            <input type="hidden" name="id"
                                                                   value="{{ $checkout->id }}">
                                                            <button type="submit" class="Payment_btn">
                                                                <img class=" w-100"
                                                                     style=" padding: 10px; margin-top: -6px;"
                                                                     src="{{ asset($gateway->logo) }}" alt="">
                                                            </button>

                                                        </form>

                                                    @elseif($gateway->method == 'Authorize.Net')
                                                        @includeIf('authorizenet::pay_form',['gateway' => $gateway, 'checkout' => $checkout])
                                                    @elseif($gateway->method == 'Braintree')
                                                        @includeIf('braintree::course_pay',['gateway' => $gateway, 'checkout' => $checkout])
                                                    @elseif($gateway->method == 'Flutterwave')
                                                        @includeIf('flutterwave::course_pay',['gateway' => $gateway, 'checkout' => $checkout])
                                                    @elseif($gateway->method == 'Mollie')
                                                        @includeIf('mollie::course_pay',['gateway' => $gateway, 'checkout' => $checkout])
                                                    @elseif($gateway->method == 'Jazz Cash')
                                                        @includeIf('jazzcash::purchase',['gateway' => $gateway, 'checkout' => $checkout])
                                                    @elseif($gateway->method == 'Coinbase')
                                                        @include("coinbase::purchase",['gateway' => $gateway, 'checkout' => $checkout])
                                                    @elseif($gateway->method == 'AmazonPayment')
                                                        @include("amazonpayment::_payment",['gateway' => $gateway, 'location' => 'checkout', 'checkout' => $checkout])

                                                    @elseif($gateway->method == 'Bank Payment' && isModuleActive('Invoice'))
                                                        <form class="w-100" action="" method="post">
                                                            @csrf

                                                            <a href="#" data-bs-toggle="modal"
                                                               data-bs-target="#bankModel"
                                                               class="payment_btn_text2 w-100 text-nowrap">
                                                                {{ $gateway->method }}
                                                            </a>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('paymentSubmit') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="payment_method"
                                                                   value="{{ $gateway->method }}">
                                                            <input type="hidden" name="tracking_id"
                                                                   value="{{ $checkout->tracking }}">
                                                            <input type="hidden" name="id"
                                                                   value="{{ $checkout->id }}">
                                                            <button type="submit" class="Payment_btn">
                                                                <img class=" w-100" src="{{ asset($gateway->logo) }}"
                                                                     alt="">
                                                            </button>

                                                        </form>
                                                    @endif

                                                </div>

                                            </div>
                                        @endforeach

                                        @if (isModuleActive('Store') && $all_physical && Settings('cash_on_delivery')==1)
                                            <div class="payment_method_single">
                                                <div class="deposite_payment_wrapper customer_payment_wrapper">
                                                    <form action="{{ route('paymentSubmit') }}" method="post">

                                                        @csrf
                                                        <div class="bank_check">

                                                            <a href="#" data-bs-toggle="modal"
                                                               data-bs-target="#MakePaymentFromCOD"
                                                               class=" payment_btn_text w-100 text-nowrap">
                                                                {{ __('product.COD') }}
                                                            </a>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade " id="MakePaymentFromCOD"
                                                 tabindex="-1" role="dialog"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ __('product.Cash on Delivery') }}</h5>
                                                        </div>
                                                        <form action="{{ route('paymentSubmit') }}"
                                                              id="infix_payment_form1" method="POST"
                                                              name="payment_main_balance">
                                                            @csrf

                                                            <input type="hidden" name="payment_method"
                                                                   value="{{ $gateway->method }}">
                                                            <input name="payment_method" value="COD"
                                                                   id="balanceInput"
                                                                   style="display: {{ Auth::user()->balance >= $checkout->purchase_price ? '' : 'none' }}"
                                                                   class="method" type="hidden">
                                                            <input type="hidden" name="tracking_id"
                                                                   value="{{ $checkout->tracking }}">
                                                            <input type="hidden" name="id"
                                                                   value="{{ $checkout->id }}">


                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-md-12">
                                                                        <p>{{ __('product.Do you want to pay in cash on delivery?') }}</p>
                                                                    </div>

                                                                </div>


                                                            </div>
                                                            <div
                                                                class="modal-footer payment_btn d-flex justify-content-between">
                                                                <button type="button"
                                                                        class="theme_line_btn"
                                                                        data-bs-dismiss="modal">@lang('common.Cancel')</button>


                                                                <button class=" theme_btn"
                                                                        type="submit">
                                                                    @lang('common.Submit')
                                                                </button>

                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="order_wrapper">
            <h3 class="font_22 f_w_700 mb_30">{{ __('frontend.Your order') }}</h3>
            <div class="ordered_products">
                @php $totalSum=0; @endphp

                @if (isset($carts))

                    @foreach ($carts as $cart)
                        @php
                                   if ($cart->course_id !=0){
                                       if (isModuleActive('Installment') && $cart->is_installment == 1) {
                                           $price=installmentProductPrice($cart->course_id, $cart->plan_id,$cart->course->discount_price?:$cart->course->price);
                                       }elseif (isModuleActive('EarlyBird') && $cart->is_earlybird_offer == 1) {
                                           $price=verifyEarlybirdOffer($cart->course,null)['price'];
                                       }else {

                                       if (isModuleActive('Store') && $cart->is_store == 1) {
                                               $price = $cart->price * $cart->qty;
                                           } else {
                                               if ($cart->course->discount_price != null) {
                                                   $price = $cart->course->discount_price;
                                               } else {
                                                   $price = $cart->course?->price;
                                               }

                                                if (hasCouponApply($cart->course_id)) {
                                                 $price =  getCouponPrice($cart->course_id);
                                               }
                                           }
                                       }
                                   }else{
                                           $price = $cart->bundle?->price;
                                   }

                                       $totalSum =  $totalSum + @$price;

                        @endphp

                        <div class="single_ordered_product">
                            <div class="product_name d-flex align-items-center">
                                <div class="thumb">
                                    @if (isModuleActive('Appointment') && $cart->schedule_id)
                                        <img
                                            src="{{ getProfileImage($cart->schedule->userInfo->image,$cart->schedule->userInfo->name) }}"
                                            alt="">
                                    @else
                                        <img src="{{ getCourseImage(@$cart->course->thumbnail) }}" alt="">
                                    @endif
                                </div>
                                <span>
                                    @if ($cart->product_sku_label)
                                        {{  $cart->course->title . ' ('. $cart['product_sku_label'].')'}}
                                    @elseif (isModuleActive('BundleSubscription') && $cart->bundle_course_id)
                                        {{  $cart->bundle->title}}
                                    @elseif (isModuleActive('Appointment') && $cart->schedule_id)
                                        {{ $cart->schedule->userInfo->name. ' - '. showDate($cart->schedule->schedule_date)}}
                                    @else
                                        {{$cart->course->title}}
                                    @endif
                                    {{ $type == 'certificate' ? '['.__('certificate.Certificate').']' :'' }}</span>
                            </div>
                            <div class="d-flex justify-content-between gap-4 cart-qty-prise">

                                <span class="order_prise f_w_500 font_16">
                               @if (isModuleActive('Store') && $cart->is_store == 1)
                                        {{ $cart->qty . ' x ' . getPriceFormat($cart->price) . ' = ' . getPriceFormat($price) }}
                                @else
                                    {{ getPriceFormat($price) }}
                                @endif


                                </span>
                            </div>

                        </div>
                    @endforeach
                @endif
            </div>
            <div class="ordered_products_lists">

                <div class="single_lists">
                    <span class=" total_text">{{ __('frontend.Subtotal') }}</span>
                    <span>{{ getPriceFormat($checkout->price) }}</span>
                </div>
                @php
                    $is_physical = Session::get('is_physical');
                @endphp
                @if (isModuleActive('Store') && $is_physical > 0)
                    <div class="single_lists">
                        <span class=" total_text">
                            {{ __('product.Shipping Charge') }}
                        </span>
                        <span>{{ getPriceFormat($checkout->shipping->cost,false) }}</span>
                    </div>
                @endif

                @if ($checkout->purchase_price > 0)
                    <div class="single_lists">

                        <span class="total_text">{{ __('payment.Discount Amount') }}</span>
                        <span>{{( $checkout->discount == '' ||  $checkout->discount == 0) ? 0 : getPriceFormat($checkout->discount) }}</span>
                    </div>
                    @if (hasTax())
                        <div class="single_lists">
                            <span class="total_text">{{ __('tax.TAX') }} </span>

                            <span class="totalTax">{{ getPriceFormat($checkout->tax) }}</span>
                        </div>
                    @endif
                    @if(isModuleActive('UpcomingCourse') && $checkout->pre_booking_amount > 0)
                        <div class="single_lists">
                                 <span class=" total_text">
                                    {{__('frontend.Pre Booking Amount')}}
                                </span>
                            <span>{{getPriceFormat($checkout->pre_booking_amount)}}</span>
                        </div>
                    @endif
                    @if(isModuleActive('UserGroup') && $checkout->group_discount > 0)
                        <div class="single_lists">
                                 <span class=" total_text">
                                    {{__('group.group_discount')}}
                                </span>
                            <span>{{getPriceFormat($checkout->group_discount)}}</span>
                        </div>
                    @endif

                    <div class="single_lists">
                        <span class="total_text">{{ __('frontend.Payable Amount') }} </span>
                        <span class="totalBalance">{{ getPriceFormat($checkout->purchase_price) }}</span>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@if (isModuleActive('Invoice') && $payment_type == 2)
    <div class="modal fade " id="bankModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('invoice.Bank Payment') }} </h5>
                    <button type="button" class="close " data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>

                </div>
                <form name="bank_payment" enctype="multipart/form-data"
                      action="{{ route('invoice.offline-payment.store') }} "
                      class="single_account-form" method="POST">
                    <div class="modal-body">
                        @csrf

                        <input type="hidden" name="method" value="Bank Payment">
                        <input type="hidden" name="tracking" value="{{ $checkout->tracking }}">
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <label for="name" class="mb-2">@lang('setting.Bank Name')
                                    <span class="required_mark">*</span></label>
                                <input type="text" required class="primary_input mb_20" placeholder="Bank Name"
                                       name="bank_name" value="{{ @old('bank_name') }}">
                                <span class="invalid-feedback" role="alert" id="bank_name"></span>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <label for="name" class="mb-2">@lang('setting.Branch Name')
                                    <span class="required_mark">*</span></label>
                                <input type="text" required name="branch_name" class="primary_input mb_20"
                                       placeholder="Name of account owner" value="{{ @old('branch_name') }}">
                                <span class="invalid-feedback" role="alert" id="owner_name"></span>
                            </div>
                        </div>
                        <div class="row mb-20">

                            <div class="col-xl-6 col-md-6">
                                <label for="name" class="mb-2">@lang('setting.Account Number')
                                    <span class="required_mark">*</span></label>
                                <input type="text" required class="primary_input mb_20"
                                       placeholder="Account number" name="account_number"
                                       value="{{ @old('account_number') }}">
                                <span class="invalid-feedback" role="alert" id="account_number"></span>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <label for="name" class="mb-2">@lang('setting.Account Holder')
                                    <span class="required_mark">*</span></label>
                                <input type="text" required name="account_holder" class="primary_input mb_20"
                                       placeholder="Account Holder" value="{{ @old('account_holder') }}">
                                <span class="invalid-feedback" role="alert" id="account_holder"></span>
                            </div>
                            <input type="hidden" name="deposit_amount" value="{{ $checkout->price }}">


                        </div>

                        <div class="row  mb-20">


                            <div class="col-xl-6 col-md-12">
                                <label for="name" class="mb-2">@lang('setting.Account Type')
                                    <span class="required_mark">*</span></label>
                                <select class="theme_select wide update-select-arrow" name="type" required
                                        id="type" style="margin-top: -10px;">
                                    <option
                                        data-display="{{ __('common.Select') }}  {{ __('setting.Account Type') }}"
                                        value="">{{ __('common.Select') }} {{ __('setting.Account Type') }}
                                    </option>
                                    <option value="Current Account"
                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Current Account' ? 'selected' : '' }}>
                                        {{ __('invoice.Current Account') }}
                                    </option>

                                    <option value="Savings Account"
                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Savings Account' ? 'selected' : '' }}>
                                        {{ __('invoice.Savings Account') }}
                                    </option>
                                    <option value="Salary Account"
                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Salary Account' ? 'selected' : '' }}>
                                        {{ __('invoice.Salary Account') }}
                                    </option>
                                    <option value="Fixed Deposit"
                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Fixed Deposit' ? 'selected' : '' }}>

                                        {{ __('invoice.Fixed Deposit') }}
                                    </option>

                                </select>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <label for="name" class="mb-2">{{ __('invoice.Cheque Slip') }}
                                    <span class="required_mark">*</span></label>
                                <input type="file" required name="image" class="primary_input mb_20">
                                <span class="invalid-feedback" role="alert" id="amount_validation"></span>
                            </div>
                        </div>

                        <fieldset class="mt-3">
                            <legend>{{ __('invoice.Bank Account Info') }}
                            </legend>
                            <table class="table table-bordered">

                                <tr>
                                    <td>@lang('setting.Bank Name')</td>
                                    <td>{{ getPaymentEnv('BANK_NAME') }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('setting.Branch Name')</td>
                                    <td>{{ getPaymentEnv('BRANCH_NAME') }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('setting.Account Type')</td>
                                    <td>{{ getPaymentEnv('ACCOUNT_TYPE') }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('setting.Account Number')</td>
                                    <td>{{ getPaymentEnv('ACCOUNT_NUMBER') }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('setting.Account Holder')</td>
                                    <td>{{ getPaymentEnv('ACCOUNT_HOLDER') }}</td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class=" theme_line_btn "
                                data-bs-dismiss="modal">@lang('common.Cancel')</button>
                        <button class="  theme_btn" type="submit">@lang('payment.Payment')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
