@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('public/backend/css/daterangepicker.css') }}{{assetVersion()}}">
    <style>
        .input-group-append button.primary-btn{
            border: 0 !important;
        }

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
        }

        .deposit_lists_wrapper .single_deposite img {
            width: 100%;
            max-width: 80px;
        }

        .deposit_lists_wrapper .single_deposite button {
            padding: 0;
            margin: 0;
            width: 100%;
            background: transparent;
            border: 0;
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

        .payment_btn_text2 {
            padding: 0 10px;
            background: linear-gradient(90deg, var(--backend-primary-color), var(--backend-primary-color) 51%, var(--backend-primary-color));
            color: #fff;
            border-radius: 5px;
            color: #fff !important;
            font-size: 18px !important;
            font-weight: 500;
            width: 100%;
            text-align: center;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom_append_group_btn {
            /*line-height: 0 !important;*/
            border-radius: 0 !important;
        }

    </style>
@endpush
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="row">
                            <div class="col-xl-12">
                                <form action="{{route('users.deposit.index')}}" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="primary_input_label"
                                                   for="deposit_amount">{{__('payment.Deposit Amount')}}
                                                ({{auth()->user()->currency->symbol}}) <strong
                                                    class="text-danger">*</strong></label>
                                            <div class="input-group mb-20">
                                                <input step="any" min="1" type="number" class="form-control"
                                                       name="deposit_amount" id="deposit_amount" required
                                                       value="{{!empty($amount)?$amount:''}}">
                                                <div class="input-group-append">
                                                    <button class="primary-btn fix-gr-bg custom_append_group_btn"
                                                            type="submit">{{__('payment.Save Info')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if(!empty($amount))
                            <div class="row">
                                <div class="col-12">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-30">
                                                    <h3 class="mb-0">{{__('common.Select')}} {{__('payment.Payment Method')}}</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">

                                                <div class="deposit_lists_wrapper mb-50">
                                                    @if(isset($methods))
                                                        @foreach($methods as $key=>$gateway)
                                                            @php
                                                                if (!paymentGateWayCredentialsEmptyCheck($gateway->method)){
                                                                continue;
                                                                }
                                                            @endphp
                                                            <div
                                                                class="single_deposite bg-light {{$gateway->method=="Bank Payment"?'p-0 border-0':''}}">

                                                                @if($gateway->method=="Stripe")
                                                                    <form action="{{route('depositSubmit')}}"
                                                                          method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="method"
                                                                               value="{{$gateway->method}}">
                                                                        <input type="hidden" name="deposit_amount"
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
                                                                @elseif($gateway->method=="MercadoPago")

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
                                                                                            $route =route('depositSubmit');
                                                                                            $payment_type ='Deposit'
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
                                                                            <form action="{{ route('depositSubmit') }}"
                                                                                  method="POST">
                                                                                <input type="hidden" name="method"
                                                                                       value="{{$gateway->method}}">
                                                                                <input type="hidden"
                                                                                       name="deposit_amount"
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

                                                                    <form action="{{route('depositSubmit')}}"
                                                                          method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="method"
                                                                               value="{{$gateway->method}}">
                                                                        <input type="hidden" name="deposit_amount"
                                                                               value="{{$amount}}">
                                                                        <button type="submit" class="">
                                                                            <img class=""
                                                                                 src="{{asset($gateway->logo)}}"
                                                                                 alt="">
                                                                        </button>

                                                                    </form>
                                                                @elseif($gateway->method=="PayTM")

                                                                    @includeIf('paytm::paytm_btn',['type'=>'deposit','amount'=>$amount])


                                                                @elseif($gateway->method=="PayStack")

                                                                    <form action="{{route('depositSubmit')}}"
                                                                          method="post">
                                                                        @csrf

                                                                        <input type="hidden" name="email"
                                                                               value="{{ @Auth::user()->email}}"> {{-- required --}}
                                                                        <input type="hidden" name="orderID"
                                                                               value="{{md5(uniqid(rand(), true))}}">
                                                                        <input type="hidden" name="amount"
                                                                               value="{{$amount*100}}">
                                                                        <input type="hidden" name="deposit_amount"
                                                                               value="{{$amount*100}}">

                                                                        <input type="hidden" name="currency"
                                                                               value="{{Settings('currency_code')}}">
                                                                        <input type="hidden" name="metadata"
                                                                               value="{{ json_encode($array = ['type' => 'Deposit',]) }}">
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


                                                                @elseif($gateway->method == 'Authorize.Net')
                                                                    @includeIf('authorizenet::diposit_form',['gateway' => $gateway, 'amount' => $amount])
                                                                @elseif($gateway->method == 'Braintree')
                                                                    @includeIf('braintree::disposit',['gateway' => $gateway, 'amount' => $amount])
                                                                @elseif($gateway->method == 'Mollie')
                                                                    @includeIf('mollie::deposit',['gateway' => $gateway, 'amount' => $amount])
                                                                @elseif($gateway->method == 'Flutterwave')
                                                                    @includeIf('flutterwave::deposit',['gateway' => $gateway, 'amount' => $amount])
                                                                @elseif($gateway->method == 'Jazz Cash')
                                                                    @includeIf('jazzcash::deposit',['gateway' => $gateway, 'amount' => $amount])
                                                                @elseif($gateway->method == 'Coinbase')
                                                                    @includeIf('coinbase::deposit',['gateway' => $gateway,'amount' => $amount])

                                                                @elseif($gateway->method=="Bank Payment")
                                                                    <form class="w-100" action="" method="post">
                                                                        @csrf

                                                                        <a href="#" data-bs-toggle="modal"
                                                                           data-bs-target="#bankModel"
                                                                           class="payment_btn_text2 w-100">
                                                                            {{$gateway->method}}
                                                                        </a>
                                                                    </form>
                                                                @else

                                                                    <form action="{{route('depositSubmit')}}"
                                                                          method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="method"
                                                                               value="{{$gateway->method}}">
                                                                        <input type="hidden" name="deposit_amount"
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
                            </div>
                        @endif


                    </div>
                </div>


            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{__('courses.Advanced Filter')}} </h4>
                        </div>
                        <form action="#" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-lg-3">
                                    <div class="primary_input mb-15 date_range">
                                        <div class="primary_datepicker_input filter">
                                            <label class="primary_input_label" for="">{{__('common.Date')}}</label>
                                            <div class="g-0  input-right-icon">
                                                <input placeholder="{{__('common.Date')}}" readonly
                                                       class="primary_input_field date_range_input" type="text"
                                                       name="date_range_filter" value="">
                                                <button class="" type="button">
                                                    <i class="fa fa-refresh" id="reset-date-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-1 ">
                                    <div class="search_course_btn">
                                        <a href="{{route('users.deposit.index')}}" class="primary-btn fix-gr-bg theme_btn_mini theme_btn mt-2 fit-b ">{{__('common.Reset')}} </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table white_box">

                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title"> {{__('payment.Deposit history')}}</h3>
                            </div>
                        </div>
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('common.Date')}}</th>
                                        <th scope="col">{{__('payment.Amount')}}
                                        </th>
                                        <th scope="col">{{__('payment.Method')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" value="{{route('users.deposit.datatable')}}" id="deposit_history_route">
            @include('backend.my_panel.deposit.bank_payment_modal')
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('public/backend/js/daterangepicker.min.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('public/modules/common/date_range_init.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('public/modules/my_panel/deposit_history.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/deposit.js')}}{{assetVersion()}}"></script>


@endpush

