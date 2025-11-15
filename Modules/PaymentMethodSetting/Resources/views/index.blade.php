@extends('backend.master')

@section('mainContent')
    <style>
        small b {
            word-break: break-word;
        }
    </style>
    {!! generateBreadcrumb() !!}

    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-3 pb-30">
                    <div class="white-box ">
                        <div class="row row  justify-content-center">
                            <div class="col-12">
                                <div class="box_header common_table_header mb-0">
                                    <div class="main-title d-md-flex">
                                        <h3 class="mt-0 mb-20">{{__('setting.Gateway Status')}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{route('paymentmethodsetting.changePaymentGatewayStatus')}}"
                              accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            @csrf


                            <div class="row">

                                @foreach ($payment_methods as $Key=>$payment_method)
                                    @php
                                        if (!paymentGateWayCredentialsEmptyCheck($payment_method->method)){
                                        continue;
                                        }
                                    @endphp


                                    <div class="col-xl-12 mb-2">
                                        <div class="primary_input ">
                                            <div class="input-effect">

                                                <label
                                                    class="primary_checkbox d-flex mr-12 text-nowrap"
                                                    for="method_{{$payment_method->id}}">
                                                    <input type="checkbox"
                                                           name="gateways[]"
                                                           id="method_{{$payment_method->id}}"
                                                           value="{{$payment_method->id}}"
                                                           {{$payment_method->active_status==1?'checked':''}}
                                                           class="common-radio relationButton read-only-input">
                                                    <span
                                                        class="checkmark me-2"></span>{{$payment_method->method}}
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center pt_20">
                                        <button type="submit" class="primary-btn semi_large fix-gr-bg"
                                                id="save_button_parent">
                                            <i class="ti-check"></i>
                                            {{ __('common.Update') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
                <div class="col-lg-9 ">
                    <div class="white-box">
                        <div class="payment_getway_tab ">
                            <div class="main-title pt-0 ">
                                <h3 class="mb-25 d-flex justify-content-between flex-wrap row-gap-3">
                                    <span>{{__('setting.gateway_setting')}}</span>


                                    <a href="{{route('paymentmethodsetting.test')}}"
                                       class="primary-btn small fix-gr-bg"
                                       style="">
                                        <span class="ti-hand-drag pe-2"></span>
                                        {{__('common.Test')}}
                                    </a>
                                </h3>

                            </div>
                            <ul class="nav nav-tabs scrollable no-bottom-border  mt-sm-md-20 mb-10"
                                style="margin-left:0"
                                role="tablist">
                                @foreach ($payment_methods->where('method','!=','Offline Payment')->where('method','!=','Wallet')  as $Key=>$payment_method)
                                    @if($payment_method->method=="Instamojo")

                                        <li class="nav-item m-1">
                                            <a class="nav-link  {{$Key==0?'active':''}} "
                                               href="#method{{$payment_method->id}}"
                                               role="tab" data-bs-toggle="tab">{{@$payment_method->method}}</a>
                                        </li>

                                    @else
                                        <li class="nav-item m-1">
                                            <a class="nav-link  {{$Key==0?'active':''}} "
                                               href="#method{{$payment_method->id}}"
                                               role="tab" data-bs-toggle="tab">{{@$payment_method->method}}</a>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            @foreach ($payment_methods->where('method','!=','Offline Payment')->where('method','!=','Wallet') as $key=>$payment_method)

                                <div role="tabpanel" class="tab-pane fade  {{$key==0?'active':''}}  show "
                                     id="method{{$payment_method->id}}">

                                    <form class="form-horizontal"
                                          @if (permissionCheck('paymentmethodsetting.payment_method_setting_update'))
                                              action="{{route('paymentmethodsetting.update_payment_gateway')}}"
                                          @endif
                                          method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="white-box">


                                            <div class="col-md-12 ">
                                                <input type="hidden" name="payment_method_id"
                                                       value="{{@$payment_method->id}}">

                                                @if($payment_method->method=="Instamojo")
                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label class="mb-2">{{__('setting.API KEY')}}
                                                                        </label>
                                                                        <input
                                                                            class="primary-input-field form-control{{ $errors->has('instamojo_api_auth') ? ' is-invalid' : '' }}"
                                                                            type="text" name="instamojo_api_auth"
                                                                            id="instamojo_api_auth"
                                                                            required
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('Instamojo_API_AUTH')? getPaymentEnv('Instamojo_API_AUTH') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.API Auth Token')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control{{ $errors->has('instamojo_auth_token') ? ' is-invalid' : '' }}"
                                                                            type="text" name="instamojo_auth_token"
                                                                            id="instamojo_auth_token"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('Instamojo_API_AUTH_TOKEN')? getPaymentEnv('Instamojo_API_AUTH_TOKEN') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Instamojo URL')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control{{ $errors->has('instamojo_url') ? ' is-invalid' : '' }}"
                                                                            type="text" name="instamojo_url"
                                                                            id="instamojo_url"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('Instamojo_URL')? getPaymentEnv('Instamojo_URL') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>

                                                    </div>
                                                @endif

                                                @if($payment_method->method=="Midtrans")
                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">

                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label class="mb-2">{{__('setting.Server Key')}}
                                                                        </label>
                                                                        <input
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="midtrans_server_key"
                                                                            id="midtrans_server_key"
                                                                            required
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('MIDTRANS_SERVER_KEY')? getPaymentEnv('MIDTRANS_SERVER_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6 mb-25">
                                                                    <label
                                                                        class="mb-2">{{__('setting.Environment')}}
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <div class="input-effect">

                                                                            <div class="">
                                                                                <div class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="midtrans_env_local{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="midtrans_env"
                                                                                               @if(getPaymentEnv('MIDTRANS_ENV')=="0")
                                                                                                   checked
                                                                                               @endif
                                                                                               id="midtrans_env_local{{$payment_method->id}}"
                                                                                               value="false"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="midtrans_env_live{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="midtrans_env"
                                                                                               id="midtrans_env_live{{$payment_method->id}}"
                                                                                               @if(getPaymentEnv('MIDTRANS_ENV')!=0)
                                                                                                   checked
                                                                                               @endif
                                                                                               value="true"
                                                                                               class="common-radio relationButton read-only-input">

                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Live')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-6 mb-25">
                                                                    <label
                                                                        class="mb-2">
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">

                                                                        <div class="input-effect">
                                                                            <div
                                                                                class="text-start float-start text-nowrap">

                                                                                <label
                                                                                    class="primary_checkbox d-flex mr-12"
                                                                                    for="midtrans_sanitize_no{{$payment_method->id}}">
                                                                                    <input type="radio"
                                                                                           name="midtrans_sanitiz"
                                                                                           @if(getPaymentEnv('MIDTRANS_SANITIZE')!='1')
                                                                                               checked
                                                                                           @endif
                                                                                           id="midtrans_sanitize_no{{$payment_method->id}}"
                                                                                           value="false"
                                                                                           class="common-radio relationButton read-only-input">
                                                                                    <span
                                                                                        class="checkmark me-2"></span> {{__('common.Sanitize No')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="input-effect">
                                                                            <div
                                                                                class="text-start float-start text-nowrap">
                                                                                <label
                                                                                    class="primary_checkbox d-flex mr-12"
                                                                                    for="midtrans_sanitize_yes{{$payment_method->id}}">
                                                                                    <input type="radio"
                                                                                           name="midtrans_sanitiz"
                                                                                           id="midtrans_sanitize_yes{{$payment_method->id}}"
                                                                                           @if(getPaymentEnv('MIDTRANS_SANITIZE')=="1")
                                                                                               checked
                                                                                           @endif
                                                                                           value="true"
                                                                                           class="common-radio relationButton read-only-input">
                                                                                    <span
                                                                                        class="checkmark me-2"></span> {{__('common.Sanitize Yes')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                    </div>


                                                                </div>


                                                                <div class="col-lg-6 mb-25">
                                                                    <label
                                                                        class="mb-2">
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <div class="input-effect">
                                                                            <div class="text-start float-start">
                                                                                <label
                                                                                    class="primary_checkbox d-flex mr-12 text-nowrap"
                                                                                    for="midtrans_3ds_no{{$payment_method->id}}">
                                                                                    <input type="radio"
                                                                                           name="midtrans_3ds"
                                                                                           @if(getPaymentEnv('MIDTRANS_3DS')=='0')
                                                                                               checked
                                                                                           @endif
                                                                                           id="midtrans_3ds_no{{$payment_method->id}}"
                                                                                           value="false"
                                                                                           class="common-radio relationButton read-only-input">

                                                                                    <span
                                                                                        class="checkmark me-2"></span> {{__('common.3DS No')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-effect">
                                                                            <div class="text-start float-start">
                                                                                <label
                                                                                    class="primary_checkbox d-flex mr-12 text-nowrap"
                                                                                    for="midtrans_3ds_yes{{$payment_method->id}}">
                                                                                    <input type="radio"
                                                                                           name="midtrans_3ds"
                                                                                           id="midtrans_3ds_yes{{$payment_method->id}}"
                                                                                           @if(getPaymentEnv('MIDTRANS_3DS')!='0')
                                                                                               checked
                                                                                           @endif
                                                                                           value="true"
                                                                                           class="common-radio relationButton read-only-input">
                                                                                    <span
                                                                                        class="checkmark me-2"></span> {{__('common.3DS Yes')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <small>
                                                                {{__('quiz.Note')}}
                                                                : {{__('setting.Make sure you have')}}
                                                                <b>{{route('midtransPaymentSuccess')}}</b> |
                                                                <b>{{route('midtransPaymentPending')}}</b> |
                                                                <b>{{route('midtransPaymentfailed')}}</b> |

                                                                {{__('setting.Set Redirection Settings In Midtrans')}}
                                                                <a
                                                                    href="https://dashboard.sandbox.midtrans.com/settings/snap_preference ">{{__('dashboard.Dashboard')}}</a>


                                                            </small>
                                                        </div>

                                                    </div>
                                                @endif
                                                @if($payment_method->method=="Payeer")
                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">

                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Payeer Marchant')}}

                                                                        </label>
                                                                        <input
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="payeer_marchant"
                                                                            id="payeer_marchant"
                                                                            required
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYEER_MERCHANT')? getPaymentEnv('PAYEER_MERCHANT') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Payeer Key')}}

                                                                        </label>
                                                                        <input
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="payeer_key"
                                                                            id="payeer_key"
                                                                            required
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYEER_KEY')? getPaymentEnv('PAYEER_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <small>
                                                            {{__('quiz.Note')}}
                                                            : {{__('setting.Make sure you have')}}   {{__('setting.Set Redirection Settings In Payeer')}}
                                                            <br>

                                                            {{__('setting.Success URL')}}:
                                                            <b>{{route('payeerPaymentSuccess')}}</b> <br>
                                                            {{__('setting.Failed URL')}}:
                                                            <b>{{route('payeerPaymentfailed')}}</b>
                                                            <br>
                                                            <a
                                                                href="https://payeer.com/en/account/api/">{{__('dashboard.Dashboard')}}</a>


                                                        </small>
                                                    </div>
                                                @endif

                                                @if($payment_method->method=="Sslcommerz")

                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Store ID')}}
                                                                        </label>
                                                                        <input
                                                                            class="primary-input-field form-control{{ $errors->has('store_id') ? ' is-invalid' : '' }}"
                                                                            type="text" name="ssl_store_id"
                                                                            id="ssl_store_id"
                                                                            required
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('STORE_ID')? getPaymentEnv('STORE_ID') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Store Password')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control{{ $errors->has('store_password') ? ' is-invalid' : '' }}"
                                                                            type="text"
                                                                            name="ssl_store_password"
                                                                            id="ssl_store_password"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('STORE_PASSWORD')? getPaymentEnv('STORE_PASSWORD') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-3 mb-25">
                                                                    <label
                                                                        class="mb-2">{{__('setting.Environment')}}
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <div class="input-effect">
                                                                            <div class="text-start float-start">
                                                                                <label
                                                                                    class="primary_checkbox d-flex mr-12"
                                                                                    for="mode_check_{{$payment_method->id}}">
                                                                                    <input type="radio"
                                                                                           name="ssl_mode"
                                                                                           @if(getPaymentEnv('IS_LOCALHOST')=='true')
                                                                                               checked
                                                                                           @endif


                                                                                           id="mode_check_{{$payment_method->id}}"
                                                                                           value="1"
                                                                                           class="common-radio relationButton read-only-input">
                                                                                    <span
                                                                                        class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="live_mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="ssl_mode"
                                                                                               id="live_mode_check_{{$payment_method->id}}"
                                                                                               @if(getPaymentEnv('IS_LOCALHOST')!='true')
                                                                                                   checked
                                                                                               @endif
                                                                                               value="2"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Live')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                @elseif($payment_method->method=='Pesapal')
                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Client ID')}}
                                                                        </label>
                                                                        <input
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="pesapal_client_id"
                                                                            id="pesapal_client_id"
                                                                            required
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('PESAPAL_KEY')? getPaymentEnv('PESAPAL_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Client Secret')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control{{ $errors->has('pesapal_client_secret') ? ' is-invalid' : '' }}"
                                                                            type="text"
                                                                            name="pesapal_client_secret"
                                                                            id="pesapal_client_secret"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('PESAPAL_SECRET')? getPaymentEnv('PESAPAL_SECRET') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 mb-25">
                                                                    <label
                                                                        class="mb-2">{{__('setting.Environment')}}
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div class="text-start float-start">
                                                                                    <label class="primary_checkbox d-flex mr-12
    "
                                                                                           for="mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="pesapal_mode"
                                                                                               @if(getPaymentEnv('PESAPAL_IS_LIVE')=='false')
                                                                                                   checked
                                                                                               @endif


                                                                                               id="mode_check_{{$payment_method->id}}"
                                                                                               value="1"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="live_mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="pesapal_mode"
                                                                                               id="live_mode_check_{{$payment_method->id}}"
                                                                                               @if(getPaymentEnv('PESAPAL_IS_LIVE')=='true')
                                                                                                   checked
                                                                                               @endif
                                                                                               value="2"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Live')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>


                                                    </div>

                                                @elseif($payment_method->method=='Mobilpay')
                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Merchant ID')}}

                                                                        </label>
                                                                        <input
                                                                            class="primary-input-field form-control"
                                                                            type="text"
                                                                            name="mobilpay_merchant_id"
                                                                            id="mobilpay_merchant_id"
                                                                            required
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('MOBILPAY_MERCHANT_ID')? getPaymentEnv('MOBILPAY_MERCHANT_ID') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-3 mb-25">
                                                                    <label
                                                                        class="mb-2">{{__('setting.Environment')}}
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="mode_mobilpay_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="mobilpay_mode"
                                                                                               @if(getPaymentEnv('MOBILPAY_TEST_MODE')=='true')
                                                                                                   checked
                                                                                               @endif


                                                                                               id="mode_mobilpay_check_{{$payment_method->id}}"
                                                                                               value="1"
                                                                                               class="common-radio relationButton read-only-input">

                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="live_mobilpay_mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="mobilpay_mode"
                                                                                               id="live_mobilpay_mode_check_{{$payment_method->id}}"
                                                                                               @if(getPaymentEnv('MOBILPAY_TEST_MODE')!='true')
                                                                                                   checked
                                                                                               @endif
                                                                                               value="2"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Live')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{__('setting.Public Key')}}</label>
                                                                        <div class="primary_file_uploader">
                                                                            <input
                                                                                class="primary-input filePlaceholder"
                                                                                type="text"
                                                                                value="{{getPaymentEnv('MOBILPAY_PUBLIC_KEY_PATH')}}"
                                                                                placeholder="Browse public key file"
                                                                                readonly="">
                                                                            <button class="" type="button">
                                                                                <label
                                                                                    class="primary-btn small fix-gr-bg"
                                                                                    for="document_file_public_key_{{@$payment_method->id}}">{{__('common.Browse')}}</label>
                                                                                <input type="file"
                                                                                       class="d-none fileUpload"
                                                                                       name="public_key"
                                                                                       id="document_file_public_key_{{@$payment_method->id}}"
                                                                                >
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{__('setting.Private Key')}}</label>
                                                                        <div class="primary_file_uploader">
                                                                            <input
                                                                                class="primary-input filePlaceholder"
                                                                                type="text"
                                                                                value="{{getPaymentEnv('MOBILPAY_PRIVATE_KEY_PATH')}}"
                                                                                placeholder="{{__('setting.Browse Private key file')}}"
                                                                                readonly="">
                                                                            <button class="" type="button">
                                                                                <label
                                                                                    class="primary-btn small fix-gr-bg"
                                                                                    for="document_file_private_key_{{@$payment_method->id}}">{{__('common.Browse')}}</label>
                                                                                <input type="file"
                                                                                       class="d-none fileUpload"
                                                                                       name="private_key"
                                                                                       id="document_file_private_key_{{@$payment_method->id}}"
                                                                                >
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                @elseif($payment_method->method=='PayPal')
                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Client ID')}}
                                                                        </label>
                                                                        <input
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="paypal_client_id"
                                                                            id="paypal_client_id"
                                                                            required
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYPAL_CLIENT_ID')? getPaymentEnv('PAYPAL_CLIENT_ID') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Client Secret')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control{{ $errors->has('client_secret') ? ' is-invalid' : '' }}"
                                                                            type="text"
                                                                            name="paypal_client_secret"
                                                                            id="paypal_client_secret"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYPAL_CLIENT_SECRET')? getPaymentEnv('PAYPAL_CLIENT_SECRET') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-lg-4 mb-25 ">
                                                                    <label
                                                                        class="mb-2">{{__('setting.Environment')}}
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <div class="input-effect">
                                                                            <div class="">

                                                                                <div
                                                                                    class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="paypal_mode"
                                                                                               @if(getPaymentEnv('IS_PAYPAL_LOCALHOST')=='true')
                                                                                                   checked
                                                                                               @endif


                                                                                               id="mode_check_{{$payment_method->id}}"
                                                                                               value="1"
                                                                                               class="common-radio relationButton read-only-input">

                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div
                                                                                    class="text-start float-start">

                                                                                    <label class="primary_checkbox d-flex mr-12
    "
                                                                                           for="live_mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="paypal_mode"
                                                                                               id="live_mode_check_{{$payment_method->id}}"
                                                                                               @if(getPaymentEnv('IS_PAYPAL_LOCALHOST')!='true')
                                                                                                   checked
                                                                                               @endif
                                                                                               value="2"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Live')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>


                                                    </div>
                                                @elseif($payment_method->method=='Stripe')

                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">

                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Secret Key')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control "
                                                                            type="text" name="client_secret"
                                                                            id="secret_key" autocomplete="off"
                                                                            value="{{getPaymentEnv('STRIPE_SECRET')? getPaymentEnv('STRIPE_SECRET') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Publisher Key')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text"
                                                                            name="client_publisher_key"
                                                                            id="publisher_key"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('STRIPE_KEY')? getPaymentEnv('STRIPE_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                            </div>


                                                        </div>
                                                    </div>
                                                @elseif($payment_method->method=='PayStack')

                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">

                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.PayStack Public Key')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control "
                                                                            type="text" name="paystack_key"
                                                                            id="razor_key" autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYSTACK_PUBLIC_KEY')? getPaymentEnv('PAYSTACK_PUBLIC_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.PayStack Secret Key')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="paystack_secret"
                                                                            id="razor_secret" autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYSTACK_SECRET_KEY')? getPaymentEnv('PAYSTACK_SECRET_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Merchant Email')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="merchant_email"
                                                                            id="razor_secret" autocomplete="off"
                                                                            value="{{getPaymentEnv('MERCHANT_EMAIL')? getPaymentEnv('MERCHANT_EMAIL') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.PayStack Payment URL')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            readonly
                                                                            class="primary-input-field form-control"
                                                                            type="text"
                                                                            name="paystack_payment_url"
                                                                            id="razor_secret" autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYSTACK_PAYMENT_URL')? getPaymentEnv('PAYSTACK_PAYMENT_URL') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12 mb_30">
                                                                    @if(Route::has('payStackCallBack'))
                                                                        <small>
                                                                            {{__('quiz.Note')}}
                                                                            : {{__('setting.Make sure you have')}}

                                                                            <b>{{route('payStackCallBack')}}</b>
                                                                            {{__('setting.registered in PayStack')}}
                                                                            <a
                                                                                href="https://dashboard.paystack.co/#/settings/developer ">{{__('dashboard.Dashboard')}}</a>


                                                                        </small>

                                                                    @endif
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>

                                                @elseif($payment_method->method=='RazorPay')

                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">

                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Razor Key')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control "
                                                                            type="text" name="razor_key"
                                                                            id="razor_key" autocomplete="off"
                                                                            value="{{getPaymentEnv('RAZOR_KEY')? getPaymentEnv('RAZOR_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Razor Secret')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="razor_secret"
                                                                            id="razor_secret" autocomplete="off"
                                                                            value="{{getPaymentEnv('RAZOR_SECRET')? getPaymentEnv('RAZOR_SECRET') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                            </div>


                                                        </div>
                                                    </div>

                                                @elseif($payment_method->method=='MercadoPago')

                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">

                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Public Key')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control "
                                                                            type="text" name="public_key"
                                                                            id="public_key" autocomplete="off"
                                                                            value="{{getPaymentEnv('MERCADO_PUBLIC_KEY')? getPaymentEnv('MERCADO_PUBLIC_KEY') : ''}}">

                                                                        <span class="focus-border"></span>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Access Token')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="access_token"
                                                                            id="access_token" autocomplete="off"
                                                                            value="{{getPaymentEnv('MERCADO_ACCESS_TOKEN')? getPaymentEnv('MERCADO_ACCESS_TOKEN') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                            </div>


                                                        </div>
                                                    </div>

                                                @elseif($payment_method->method=='PayTM')

                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">

                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Merchant ID')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="paytm_merchant_id"
                                                                            id="paytm_merchant_id"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYTM_MERCHANT_ID')? getPaymentEnv('PAYTM_MERCHANT_ID') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 mb-25 ">
                                                                    <label
                                                                        class="mb-2">{{__('setting.Environment')}}
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <div class="input-effect">
                                                                            <div class="">

                                                                                <div
                                                                                    class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="paytm_mode"
                                                                                               @if(getPaymentEnv('PAYTM_ENVIRONMENT')=="local")
                                                                                                   checked
                                                                                               @endif

                                                                                               id="mode_check_{{$payment_method->id}}"
                                                                                               value="local"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div
                                                                                    class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="live_mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="paytm_mode"
                                                                                               id="live_mode_check_{{$payment_method->id}}"
                                                                                               @if(getPaymentEnv('PAYTM_ENVIRONMENT')=="production")
                                                                                                   checked
                                                                                               @endif
                                                                                               value="production"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Live')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Merchant Key')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control "
                                                                            type="text"
                                                                            name="paytm_merchant_key"
                                                                            id="razor_key" autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYTM_MERCHANT_KEY')? getPaymentEnv('PAYTM_MERCHANT_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.PayTM Merchant Website')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text"
                                                                            name="paytm_merchant_website"
                                                                            id="razor_secret" autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYTM_MERCHANT_WEBSITE')? getPaymentEnv('PAYTM_MERCHANT_WEBSITE') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.PayTM Channel')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control "
                                                                            type="text" name="paytm_channel"
                                                                            id="razor_key" autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYTM_CHANNEL')? getPaymentEnv('PAYTM_CHANNEL') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Industry Type')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="industry_type"
                                                                            id="razor_secret" autocomplete="off"
                                                                            value="{{getPaymentEnv('PAYTM_INDUSTRY_TYPE')? getPaymentEnv('PAYTM_INDUSTRY_TYPE') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                            </div>


                                                        </div>
                                                    </div>
                                                @elseif($payment_method->method=='Bkash')
                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.App Key')}}

                                                                        </label>
                                                                        <input
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="bkash_app_key"
                                                                            id="bkash_app_key"
                                                                            required
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('BKASH_APP_KEY')? getPaymentEnv('BKASH_APP_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.App Secret')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control{{ $errors->has('bkash_app_secret') ? ' is-invalid' : '' }}"
                                                                            type="text" name="bkash_app_secret"
                                                                            id="bkash_app_secret"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('BKASH_APP_SECRET')? getPaymentEnv('BKASH_APP_SECRET') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Username')}}

                                                                        </label>
                                                                        <input
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="bkash_username"
                                                                            id="bkash_username"
                                                                            required
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('BKASH_USERNAME')? getPaymentEnv('BKASH_USERNAME') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Password')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="bkash_password"
                                                                            id="bkash_password"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('BKASH_PASSWORD')? getPaymentEnv('BKASH_PASSWORD') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 mb-25">
                                                                    <label
                                                                        class="mb-2">{{__('setting.Environment')}}
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="bkash_mode"
                                                                                               @if(getPaymentEnv('IS_BKASH_LOCALHOST')=='true')
                                                                                                   checked
                                                                                               @endif


                                                                                               id="mode_check_{{$payment_method->id}}"
                                                                                               value="1"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="live_mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="bkash_mode"
                                                                                               id="live_mode_check_{{$payment_method->id}}"
                                                                                               @if(getPaymentEnv('IS_BKASH_LOCALHOST')!='true')
                                                                                                   checked
                                                                                               @endif
                                                                                               value="2"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Live')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>


                                                    </div>

                                                @elseif($payment_method->method=='Bank Payment')
                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">


                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Bank Name')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control "
                                                                            type="text" name="bank_name"
                                                                            id="bank_name" autocomplete="off"
                                                                            value="{{getPaymentEnv('BANK_NAME')? getPaymentEnv('BANK_NAME') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-4 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Branch Name')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="branch_name"
                                                                            id="branch_name" autocomplete="off"
                                                                            value="{{getPaymentEnv('BRANCH_NAME')? getPaymentEnv('BRANCH_NAME') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 mb-25"
                                                                     style="margin-top: -10px;">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Type')}}
                                                                        </label>
                                                                        <select class="primary_select"
                                                                                name="type"
                                                                                id="type"
                                                                                style="margin-top: -10px;">
                                                                            <option
                                                                                data-display="{{__('common.Select')}}  {{__('setting.Account Type')}}"
                                                                                value="">{{__('common.Select')}} {{__('setting.Account Type')}}</option>
                                                                            <option
                                                                                value="Current Account" {{(getPaymentEnv('ACCOUNT_TYPE')? getPaymentEnv('ACCOUNT_TYPE') : '')=='Current Account'?'selected':''}}>
                                                                                {{__('payment.Current Account')}}
                                                                            </option>

                                                                            <option
                                                                                value="Savings Account" {{(getPaymentEnv('ACCOUNT_TYPE')? getPaymentEnv('ACCOUNT_TYPE') : '')=='Savings Account'?'selected':''}}>
                                                                                {{__('payment.Savings Account')}}
                                                                            </option>
                                                                            <option
                                                                                value="Salary Account" {{(getPaymentEnv('ACCOUNT_TYPE')? getPaymentEnv('ACCOUNT_TYPE') : '')=='Salary Account'?'selected':''}}>
                                                                                {{__('payment.Salary Account')}}
                                                                            </option>
                                                                            <option
                                                                                value="Fixed Deposit" {{(getPaymentEnv('ACCOUNT_TYPE')? getPaymentEnv('ACCOUNT_TYPE') : '')=='Fixed Deposit'?'selected':''}}>
                                                                                {{__('payment.Fixed Deposit')}}
                                                                            </option>

                                                                        </select>


                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Account Number')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control "
                                                                            type="text" name="account_number"
                                                                            id="account_number"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('ACCOUNT_NUMBER')? getPaymentEnv('ACCOUNT_NUMBER') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Account Holder')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text" name="account_holder"
                                                                            id="razor_secret" autocomplete="off"
                                                                            value="{{getPaymentEnv('ACCOUNT_HOLDER')? getPaymentEnv('ACCOUNT_HOLDER') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                @elseif($payment_method->method=='RazerMS')
                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">

                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Merchant ID')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text"
                                                                            name="razer_ms_merchant_id"
                                                                            id="razer_ms_merchant_id"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('RAZERMS_MERCHANT_ID')? getPaymentEnv('RAZERMS_MERCHANT_ID') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 mb-25">
                                                                    <label
                                                                        class="mb-2">{{__('setting.Environment')}}
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <div class="input-effect">
                                                                            <div class="">

                                                                                <div class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="razerms_mode"
                                                                                               @if(getPaymentEnv('RAZERMS_ENVIRONMENT')=="local" || !getPaymentEnv('RAZERMS_ENVIRONMENT'))
                                                                                                   checked
                                                                                               @endif

                                                                                               id="mode_check_{{$payment_method->id}}"
                                                                                               value="local"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="live_mode_check_{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="razerms_mode"
                                                                                               id="live_mode_check_{{$payment_method->id}}"
                                                                                               @if(getPaymentEnv('RAZERMS_ENVIRONMENT')=="production")
                                                                                                   checked
                                                                                               @endif
                                                                                               value="production"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Live')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Verify Key')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control "
                                                                            type="text"
                                                                            name="razerms_verify_key"
                                                                            id="" autocomplete="off"
                                                                            value="{{getPaymentEnv('RAZERMS_VERIFY_KEY')? getPaymentEnv('RAZERMS_VERIFY_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.Private Key')}}
                                                                        </label>
                                                                        <input
                                                                            required
                                                                            class="primary-input-field form-control"
                                                                            type="text"
                                                                            name="razerms_private_key"
                                                                            id="razerms_private_key"
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('RAZERMS_PRIVATE_KEY')? getPaymentEnv('RAZERMS_PRIVATE_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                            </div>


                                                        </div>
                                                    </div>
                                                @elseif($payment_method->method == 'Easy Paisa')
                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class='input-effect mb-25'>
                                                                        <label class="mb-2"
                                                                               for="{{$payment_method->id}}">
                                                                            <span>{{__('setting.Store ID')}}</span>
                                                                        </label>
                                                                        <input type="hidden"
                                                                               name="payment_method_id"
                                                                               value="{{$payment_method->id}}">
                                                                        <input type="text"
                                                                               id='{{$payment_method->id}}'
                                                                               value="{{ !empty(getPaymentEnv('EASY_PAISA_STORE_ID')) ? getPaymentEnv("EASY_PAISA_STORE_ID"):'' }}"
                                                                               class="primary-input-field form-control"
                                                                               name="EASY_PAISA_STORE_ID">

                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class='input-effect mb-25'>
                                                                        <label class="mb-2">
                                                                            <span>{{__('setting.Hash Key')}}</span>
                                                                        </label>
                                                                        <input type="text"
                                                                               class="primary-input-field form-control"
                                                                               value='{{ !empty(getPaymentEnv('EASY_PAISA_HASH_KEY')) ? getPaymentEnv("EASY_PAISA_HASH_KEY"):'' }}'
                                                                               name="EASY_PAISA_HASH_KEY">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-2 mb-2">
                                                                <div class="col-lg-6 mb-25">
                                                                    <div class='input-effect'>
                                                                        <label
                                                                            for=""> {{__('setting.Auto Redirect')}} {{ getPaymentEnv('EASY_PAISA_AUTO_REDIRECT') }}</label>
                                                                        <select class="form-control"
                                                                                name="EASY_PAISA_AUTO_REDIRECT">
                                                                            <option
                                                                                {{ !empty(getPaymentEnv("EASY_PAISA_AUTO_REDIRECT")) && getPaymentEnv('EASY_PAISA_AUTO_REDIRECT') == 0 ? 'selected':'' }}  value="0">{{ trans('common.No')  }}</option>
                                                                            <option
                                                                                {{ !empty(getPaymentEnv("EASY_PAISA_AUTO_REDIRECT")) && getPaymentEnv('EASY_PAISA_AUTO_REDIRECT') == 1 ? 'selected':'' }}  value="1">{{ trans('common.Yes')  }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @elseif($payment_method->method == 'Authorize.Net')

                                                    <div class="row mb-25">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-4">
                                                                    <div class='input-effect mb-25'>
                                                                        <label class="mb-2"
                                                                               for="{{$payment_method->id}}">
                                                                            <span>{{__('setting.API KEY')}}</span>
                                                                        </label>
                                                                        <input type="hidden"
                                                                               name="payment_method_id"
                                                                               value="{{$payment_method->id}}">
                                                                        <input type="text"
                                                                               id='{{$payment_method->id}}'
                                                                               value="{{ !empty(getPaymentEnv('AUTHORIZE_NET_API_KEY')) ? getPaymentEnv("AUTHORIZE_NET_API_KEY"):'' }}"
                                                                               class="primary-input-field form-control"
                                                                               name="AUTHORIZE_NET_API_KEY">

                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 col-md-4">
                                                                    <div class='input-effect mb-25'>
                                                                        <label class="mb-2">
                                                                            <span>{{__('setting.Transaction Key')}}</span>
                                                                        </label>
                                                                        <input type="text"
                                                                               class="primary-input-field form-control"
                                                                               value='{{ !empty(getPaymentEnv('AUTHORIZE_NET_TRANSACTION_KEY')) ? getPaymentEnv("AUTHORIZE_NET_TRANSACTION_KEY"):'' }}'
                                                                               name="AUTHORIZE_NET_TRANSACTION_KEY">

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4">


                                                                    <label
                                                                        class="mb-2">{{__('setting.Environment')}}
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div
                                                                                    class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="AUTHORIZE_NET_ENVIRONMENT_0{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="AUTHORIZE_NET_ENVIRONMENT"
                                                                                               @if(getPaymentEnv('AUTHORIZE_NET_ENVIRONMENT')=="0")
                                                                                                   checked
                                                                                               @endif
                                                                                               id="AUTHORIZE_NET_ENVIRONMENT_0{{$payment_method->id}}"
                                                                                               value="false"
                                                                                               class="common-radio relationButton read-only-input">
                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="input-effect">
                                                                            <div class="">
                                                                                <div
                                                                                    class="text-start float-start">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex mr-12"
                                                                                        for="AUTHORIZE_NET_ENVIRONMENT_1{{$payment_method->id}}">
                                                                                        <input type="radio"
                                                                                               name="AUTHORIZE_NET_ENVIRONMENT"
                                                                                               id="AUTHORIZE_NET_ENVIRONMENT_1{{$payment_method->id}}"
                                                                                               @if(getPaymentEnv('AUTHORIZE_NET_ENVIRONMENT')!=0)
                                                                                                   checked
                                                                                               @endif
                                                                                               value="true"
                                                                                               class="common-radio relationButton read-only-input">

                                                                                        <span
                                                                                            class="checkmark me-2"></span> {{__('common.Live')}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                @elseif($payment_method->method == 'Braintree')

                                                    <div class="row">

                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{__('setting.Merchant ID')}}</span>
                                                                </label>
                                                                <input type="hidden"
                                                                       name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text"
                                                                       id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('BRAINTREE_MERCHANT_ID')) ? getPaymentEnv("BRAINTREE_MERCHANT_ID"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="BRAINTREE_MERCHANT_ID">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{__('setting.Public Key')}}</span>
                                                                </label>
                                                                <input type="text"
                                                                       id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('BRAINTREE_PUBLIC_KEY')) ? getPaymentEnv("BRAINTREE_PUBLIC_KEY"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="BRAINTREE_PUBLIC_KEY">

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ trans('setting.Private Key')}}</span>
                                                                </label>
                                                                <input type="text"
                                                                       id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('BRAINTREE_PRIVATE_KEY')) ? getPaymentEnv("BRAINTREE_PRIVATE_KEY"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="BRAINTREE_PRIVATE_KEY">

                                                            </div>
                                                        </div>


                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <label
                                                                class="mb-2">{{__('setting.Environment')}}
                                                            </label>
                                                            <div
                                                                class="d-flex justify-content-center align-items-center">

                                                                <div class="input-effect">
                                                                    <div class="">
                                                                        <div
                                                                            class="text-start float-start">
                                                                            <label
                                                                                class="primary_checkbox d-flex mr-12"
                                                                                for="BRAINTREE_ENVIRONMENT_0{{$payment_method->id}}">
                                                                                <input type="radio"
                                                                                       name="BRAINTREE_ENVIRONMENT"
                                                                                       @if(getPaymentEnv('BRAINTREE_ENVIRONMENT')=="sandbox")
                                                                                           checked
                                                                                       @endif
                                                                                       id="BRAINTREE_ENVIRONMENT_0{{$payment_method->id}}"
                                                                                       value="sandbox"
                                                                                       class="common-radio relationButton read-only-input">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="input-effect">
                                                                    <div class="">
                                                                        <div
                                                                            class="text-start float-start">
                                                                            <label
                                                                                class="primary_checkbox d-flex mr-12"
                                                                                for="BRAINTREE_ENVIRONMENT_1{{$payment_method->id}}">
                                                                                <input type="radio"
                                                                                       name="BRAINTREE_ENVIRONMENT"
                                                                                       id="BRAINTREE_ENVIRONMENT_1{{$payment_method->id}}"
                                                                                       @if(getPaymentEnv('BRAINTREE_ENVIRONMENT')!='sandbox')
                                                                                           checked
                                                                                       @endif
                                                                                       value="production"
                                                                                       class="common-radio relationButton read-only-input">

                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('common.Live')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif ($payment_method->method == 'Mollie')
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ trans("setting.Secret Key")}}</span>
                                                                </label>
                                                                <input type="hidden" name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('MOLLIE_SECRET_KEY')) ? getPaymentEnv("MOLLIE_SECRET_KEY"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="MOLLIE_SECRET_KEY">

                                                            </div>
                                                        </div>

                                                    </div>
                                                @elseif($payment_method->method == 'Flutterwave')
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ trans("setting.Public Key")}}</span>
                                                                </label>
                                                                <input type="hidden" name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('FLW_PUBLIC_KEY')) ? getPaymentEnv("FLW_PUBLIC_KEY"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="FLW_PUBLIC_KEY">

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ trans("setting.Secret Key")}}</span>
                                                                </label>
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('FLW_SECRET_KEY')) ? getPaymentEnv("FLW_SECRET_KEY"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="FLW_SECRET_KEY">

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ trans("setting.Secret Hash")}}</span>
                                                                </label>
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('FLW_SECRET_HASH')) ? getPaymentEnv("FLW_SECRET_HASH"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="FLW_SECRET_HASH">

                                                            </div>
                                                        </div>


                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                                            <label
                                                                class="mb-2">{{__('setting.Environment')}}
                                                            </label>
                                                            <div
                                                                class="d-flex justify-content-center align-items-center">
                                                                <div class="input-effect">
                                                                    <div class="">
                                                                        <div
                                                                            class="text-start float-start">
                                                                            <label
                                                                                class="primary_checkbox d-flex mr-12"
                                                                                for="FLW_ENVIRONMENT_0{{$payment_method->id}}">
                                                                                <input type="radio"
                                                                                       name="FLW_ENVIRONMENT"
                                                                                       @if(getPaymentEnv('FLW_ENVIRONMENT')=="sandbox")
                                                                                           checked
                                                                                       @endif
                                                                                       id="FLW_ENVIRONMENT_0{{$payment_method->id}}"
                                                                                       value="sandbox"
                                                                                       class="common-radio relationButton read-only-input">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="input-effect">
                                                                    <div class="">
                                                                        <div
                                                                            class="text-start float-start">
                                                                            <label
                                                                                class="primary_checkbox d-flex mr-12"
                                                                                for="FLW_ENVIRONMENT_1{{$payment_method->id}}">
                                                                                <input type="radio"
                                                                                       name="FLW_ENVIRONMENT"
                                                                                       id="FLW_ENVIRONMENT_1{{$payment_method->id}}"
                                                                                       @if(getPaymentEnv('FLW_ENVIRONMENT')!='sandbox')
                                                                                           checked
                                                                                       @endif
                                                                                       value="production"
                                                                                       class="common-radio relationButton read-only-input">

                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('common.Live')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($payment_method->method == 'Coinbase')
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ _trans("common.Api Key")}}</span>
                                                                </label>
                                                                <input type="hidden" name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('COINBASE_API_KEY')) ? getPaymentEnv("COINBASE_API_KEY"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="COINBASE_API_KEY">

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ _trans("common.Webhook Secret")}}</span>
                                                                </label>
                                                                <input type="hidden" name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('COINBASE_WEBHOOK_SECRET')) ? getPaymentEnv('COINBASE_WEBHOOK_SECRET'):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="COINBASE_WEBHOOK_SECRET">

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ _trans("common.Api Version")}}</span>
                                                                </label>
                                                                <input type="hidden" name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('COINBASE_API_VERSION')) ? getPaymentEnv('COINBASE_API_VERSION'):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="COINBASE_API_VERSION">

                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($payment_method->method == 'Jazz Cash')
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ _trans("common.Merchant ID")}}</span>
                                                                </label>
                                                                <input type="hidden" name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('JAZZ_CASH_MERCHANT_ID')) ? getPaymentEnv("JAZZ_CASH_MERCHANT_ID"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="JAZZ_CASH_MERCHANT_ID">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ _trans("common.Password")}}</span>
                                                                </label>
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('JAZZ_CASH_PASSWORD')) ? getPaymentEnv("JAZZ_CASH_PASSWORD"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="JAZZ_CASH_PASSWORD">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ _trans("common.Integrity Salt")}}</span>
                                                                </label>
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('JAZZ_CASH_INTEGRITY_SALT')) ? getPaymentEnv("JAZZ_CASH_INTEGRITY_SALT"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="JAZZ_CASH_INTEGRITY_SALT">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label
                                                                class="mb-2">{{__('setting.Environment')}}
                                                            </label>
                                                            <div
                                                                class="d-flex justify-content-center align-items-center">
                                                                <div class="input-effect">
                                                                    <div class="">
                                                                        <div class="text-start float-start">
                                                                            <label
                                                                                class="primary_checkbox d-flex mr-12"
                                                                                for="mode_check_{{$payment_method->id}}">
                                                                                <input type="radio"
                                                                                       name="JAZZ_CASH_ENVIROMENT"
                                                                                       @if(getPaymentEnv('JAZZ_CASH_ENVIROMENT')=='LIVE')
                                                                                           checked
                                                                                       @endif


                                                                                       id="mode_check_{{$payment_method->id}}"
                                                                                       value="LIVE"
                                                                                       class="common-radio relationButton read-only-input">

                                                                                <span
                                                                                    class="checkmark me-2"></span> {{_trans('common.LIVE')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="input-effect">
                                                                    <div class="">
                                                                        <div class="text-start float-start">
                                                                            <label
                                                                                class="primary_checkbox d-flex mr-12"
                                                                                for="mode_check_no_{{$payment_method->id}}">
                                                                                <input type="radio"
                                                                                       name="JAZZ_CASH_ENVIROMENT"
                                                                                       @if(getPaymentEnv('JAZZ_CASH_ENVIROMENT')=='SANDBOX')
                                                                                           checked
                                                                                       @endif


                                                                                       id="mode_check_no_{{$payment_method->id}}"
                                                                                       value="SANDBOX"
                                                                                       class="common-radio relationButton read-only-input">

                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($payment_method->method == 'CCAvenue')

                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ _trans("common.CC Key")}}</span>
                                                                </label>
                                                                <input type="hidden" name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('CCA_KEY')) ? getPaymentEnv("CCA_KEY"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="CCA_KEY">

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ _trans("common.Access Code")}}</span>
                                                                </label>
                                                                <input type="hidden" name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('CCA_ACCESS_CODE')) ? getPaymentEnv("CCA_ACCESS_CODE"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="CCA_ACCESS_CODE">

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-md-6">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ _trans("common.Merchant ID")}}</span>
                                                                </label>
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('CCA_MERCHANT_ID')) ? getPaymentEnv("CCA_MERCHANT_ID"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="CCA_MERCHANT_ID">

                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($payment_method->method == 'Tranzak')
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ _trans("setting.Api ID")}}</span>
                                                                </label>
                                                                <input type="hidden" name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('Tranzak_APP_ID')) ? getPaymentEnv("Tranzak_APP_ID"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="Tranzak_APP_ID">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="{{$payment_method->id}}">
                                                                    <span>{{ _trans("setting.Api Key")}}</span>
                                                                </label>
                                                                <input type="hidden" name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text" id='{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('Tranzak_API_KEY')) ? getPaymentEnv("Tranzak_API_KEY"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="Tranzak_API_KEY">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <label
                                                                class="mb-2">{{__('setting.Environment')}}
                                                            </label>
                                                            <div
                                                                class="d-flex justify-content-center align-items-center">
                                                                <div class="input-effect">
                                                                    <div class="">
                                                                        <div
                                                                            class="text-start float-start">
                                                                            <label
                                                                                class="primary_checkbox d-flex mr-12"
                                                                                for="Tranzak_ENVIRONMENT_0{{$payment_method->id}}">
                                                                                <input type="radio"
                                                                                       name="Tranzak_ENVIRONMENT"
                                                                                       @if(getPaymentEnv('Tranzak_ENVIRONMENT')=="sandbox")
                                                                                           checked
                                                                                       @endif
                                                                                       id="Tranzak_ENVIRONMENT_0{{$payment_method->id}}"
                                                                                       value="sandbox"
                                                                                       class="common-radio relationButton read-only-input">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="input-effect">
                                                                    <div class="">
                                                                        <div
                                                                            class="text-start float-start">
                                                                            <label
                                                                                class="primary_checkbox d-flex mr-12"
                                                                                for="Tranzak_ENVIRONMENT_1{{$payment_method->id}}">
                                                                                <input type="radio"
                                                                                       name="Tranzak_ENVIRONMENT"
                                                                                       @if(getPaymentEnv('Tranzak_ENVIRONMENT')=="live")
                                                                                           checked
                                                                                       @endif
                                                                                       id="Tranzak_ENVIRONMENT_1{{$payment_method->id}}"
                                                                                       value="live"
                                                                                       class="common-radio relationButton read-only-input">
                                                                                <span
                                                                                    class="checkmark me-2"></span> {{__('common.Live')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                @elseif($payment_method->method == 'AmazonPayment')
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="mi{{$payment_method->id}}">
                                                                    <span>{{ _trans("setting.Merchant Identifier")}}</span>
                                                                </label>
                                                                <input type="hidden" name="payment_method_id"
                                                                       value="{{$payment_method->id}}">
                                                                <input type="text"
                                                                       id='mi{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('AmazonPayment_merchant_identifier')) ? getPaymentEnv("AmazonPayment_merchant_identifier"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="AmazonPayment_merchant_identifier">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="ac{{$payment_method->id}}">
                                                                    <span>{{ _trans("setting.Access Code")}}</span>
                                                                </label>
                                                                <input type="text"
                                                                       id='ac{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('AmazonPayment_access_code')) ? getPaymentEnv("AmazonPayment_access_code"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="AmazonPayment_access_code">

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 col-md-3">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="sr{{$payment_method->id}}">
                                                                    <span>{{ _trans("setting.SHA Request Phrase")}}</span>
                                                                </label>
                                                                <input type="text"
                                                                       id='sr{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('AmazonPayment_SHARequestPhrase')) ? getPaymentEnv("AmazonPayment_SHARequestPhrase"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="AmazonPayment_SHARequestPhrase">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3">
                                                            <div class='input-effect mb-25'>
                                                                <label class="mb-2"
                                                                       for="srr{{$payment_method->id}}">
                                                                    <span>{{ _trans("setting.SHA Response Phrase")}}</span>
                                                                </label>
                                                                <input type="text"
                                                                       id='srr{{$payment_method->id}}'
                                                                       value="{{ !empty(getPaymentEnv('AmazonPayment_SHAResponsePhrase')) ? getPaymentEnv("AmazonPayment_SHAResponsePhrase"):'' }}"
                                                                       class="primary-input-field form-control"
                                                                       name="AmazonPayment_SHAResponsePhrase">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3">
                                                            <div class='input-effect mb-25'>

                                                                <select class="primary_select"
                                                                        name="AmazonPayment_SHAType"
                                                                        id="st{{$payment_method->id}}"
                                                                        style="margin-top: -10px;">
                                                                    <option
                                                                        data-display="{{__('common.Select')}}  {{__('setting.SHA Type')}}"
                                                                        value="">{{__('common.Select')}} {{__('setting.Account Type')}}</option>
                                                                    <option
                                                                        value="sha256" {{(getPaymentEnv('AmazonPayment_SHAType')? getPaymentEnv('AmazonPayment_SHAType') : '')=='sha256'?'selected':''}}>
                                                                        SHA-256
                                                                    </option>
                                                                    <option
                                                                        value="sha512" {{(getPaymentEnv('AmazonPayment_SHAType')? getPaymentEnv('AmazonPayment_SHAType') : '')=='sha512'?'selected':''}}>
                                                                        SHA-512
                                                                    </option>


                                                                </select>


                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <div class="input-effect">
                                                                        <div class="">
                                                                            <div
                                                                                class="text-start float-start">
                                                                                <label
                                                                                    class="primary_checkbox d-flex mr-12"
                                                                                    for="AmazonPayment_ENVIRONMENT_0{{$payment_method->id}}">
                                                                                    <input type="radio"
                                                                                           name="AmazonPayment_ENVIRONMENT"
                                                                                           @if(getPaymentEnv('AmazonPayment_ENVIRONMENT')=="sandbox")
                                                                                               checked
                                                                                           @endif
                                                                                           id="AmazonPayment_ENVIRONMENT_0{{$payment_method->id}}"
                                                                                           value="sandbox"
                                                                                           class="common-radio relationButton read-only-input">
                                                                                    <span
                                                                                        class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-effect">
                                                                        <div class="">
                                                                            <div
                                                                                class="text-start float-start">
                                                                                <label
                                                                                    class="primary_checkbox d-flex mr-12"
                                                                                    for="AmazonPayment_ENVIRONMENT_1{{$payment_method->id}}">
                                                                                    <input type="radio"
                                                                                           name="AmazonPayment_ENVIRONMENT"
                                                                                           @if(getPaymentEnv('AmazonPayment_ENVIRONMENT')=="live")
                                                                                               checked
                                                                                           @endif
                                                                                           id="AmazonPayment_ENVIRONMENT_1{{$payment_method->id}}"
                                                                                           value="live"
                                                                                           class="common-radio relationButton read-only-input">
                                                                                    <span
                                                                                        class="checkmark me-2"></span> {{__('common.Live')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @elseif($payment_method->method == 'TapPayment')
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-lg-12 mb-25">
                                                                    <div class="input-effect">
                                                                        <label
                                                                            class="mb-2">{{__('setting.API Secret')}}

                                                                        </label>
                                                                        <input
                                                                            class="primary-input-field form-control{{ $errors->has('TAP_PAYMENT_API_KEY') ? ' is-invalid' : '' }}"
                                                                            type="text"
                                                                            name="TAP_PAYMENT_API_KEY"
                                                                            id="TAP_PAYMENT_API_KEY"
                                                                            required
                                                                            autocomplete="off"
                                                                            value="{{getPaymentEnv('TAP_PAYMENT_API_KEY')? getPaymentEnv('TAP_PAYMENT_API_KEY') : ''}}">

                                                                        <span class="focus-border"></span>
                                                                        <span
                                                                            class="modal_input_validation red_alert"></span>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>

                                                @elseif($payment_method->method == 'AstraPay')
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-4">
                                                                    <div class='input-effect mb-25'>
                                                                        <label class="mb-2"
                                                                               for="AstraPay_CLIENT_ID{{$payment_method->id}}">
                                                                            <span>{{ __("setting.Client ID")}}</span>
                                                                        </label>
                                                                        <input type="text"
                                                                               id='AstraPay_CLIENT_ID{{$payment_method->id}}'
                                                                               value="{{ !empty(getPaymentEnv('AstraPay_CLIENT_ID')) ? getPaymentEnv("AstraPay_CLIENT_ID"):'' }}"
                                                                               class="primary-input-field form-control"
                                                                               name="AstraPay_CLIENT_ID">

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4">
                                                                    <div class='input-effect mb-25'>
                                                                        <label class="mb-2"
                                                                               for="AstraPay_MERCHANT_KEY{{$payment_method->id}}">
                                                                            <span>{{ __("setting.Merchant ID")}}</span>
                                                                        </label>
                                                                        <input type="text"
                                                                               id='AstraPay_MERCHANT_KEY{{$payment_method->id}}'
                                                                               value="{{ !empty(getPaymentEnv('AstraPay_MERCHANT_KEY')) ? getPaymentEnv("AstraPay_MERCHANT_KEY"):'' }}"
                                                                               class="primary-input-field form-control"
                                                                               name="AstraPay_MERCHANT_KEY">

                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 col-md-4">
                                                                    <div class='input-effect mb-25'>
                                                                        <label class="mb-2"
                                                                               for="AstraPay_SECRET_KEY{{$payment_method->id}}">
                                                                            <span>{{ __("setting.Secret Key")}}</span>
                                                                        </label>
                                                                        <input type="text"
                                                                               id='AstraPay_SECRET_KEY{{$payment_method->id}}'
                                                                               value="{{ !empty(getPaymentEnv('AstraPay_SECRET_KEY')) ? getPaymentEnv("AstraPay_SECRET_KEY"):'' }}"
                                                                               class="primary-input-field form-control"
                                                                               name="AstraPay_SECRET_KEY">

                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 col-md-4">
                                                                    <div class='input-effect mb-25'>
                                                                        <label class="mb-2"
                                                                               for="AstraPay_PRIVATE_KEY{{$payment_method->id}}">
                                                                            <span>{{ __("setting.Private Key")}}</span>
                                                                        </label>

                                                                        <div class="primary_file_uploader">
                                                                            <input
                                                                                class="primary-input filePlaceholder"
                                                                                type="text"
                                                                                value="{{getPaymentEnv('AstraPay_PRIVATE_KEY')}}"
                                                                                placeholder="{{__('setting.Browse Private key file')}}"
                                                                                readonly="">
                                                                            <button class="" type="button">
                                                                                <label
                                                                                    class="primary-btn small fix-gr-bg"
                                                                                    for="document_file_private_key_{{@$payment_method->id}}">{{__('common.Browse')}}</label>
                                                                                <input type="file"
                                                                                       class="d-none fileUpload"
                                                                                       name="astrapay_private_key"
                                                                                       id="document_file_private_key_{{@$payment_method->id}}"
                                                                                >
                                                                            </button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-md-4">

                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <label class="mb-2"
                                                                                   for=" Env{{$payment_method->id}}">
                                                                                <span>{{ __("setting.Environment")}}</span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-6 ps-0 pt-3">
                                                                            <div class="input-effect">


                                                                                <div class="">
                                                                                    <div
                                                                                        class="text-start float-start">
                                                                                        <label
                                                                                            class="primary_checkbox d-flex mr-12"
                                                                                            for="AstraPay_ENVIRONMENT_0{{$payment_method->id}}">
                                                                                            <input type="radio"
                                                                                                   name="AstraPay_ENVIRONMENT"
                                                                                                   @if(getPaymentEnv('AstraPay_ENVIRONMENT')!="live")
                                                                                                       checked
                                                                                                   @endif
                                                                                                   id="AstraPay_ENVIRONMENT_0{{$payment_method->id}}"
                                                                                                   value="sandbox"
                                                                                                   class="common-radio relationButton read-only-input">
                                                                                            <span
                                                                                                class="checkmark me-2"></span> {{__('common.Sandbox')}}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 ps-0 pt-3">
                                                                            <div class="input-effect">
                                                                                <div class="">
                                                                                    <div
                                                                                        class="text-start float-start">
                                                                                        <label
                                                                                            class="primary_checkbox d-flex mr-12"
                                                                                            for="AstraPay_ENVIRONMENT_1{{$payment_method->id}}">
                                                                                            <input type="radio"
                                                                                                   name="AstraPay_ENVIRONMENT"
                                                                                                   @if(getPaymentEnv('AstraPay_ENVIRONMENT')=="live")
                                                                                                       checked
                                                                                                   @endif
                                                                                                   id="AstraPay_ENVIRONMENT_1{{$payment_method->id}}"
                                                                                                   value="live"
                                                                                                   class="common-radio relationButton read-only-input">
                                                                                            <span
                                                                                                class="checkmark me-2"></span> {{__('common.Live')}}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>


                                                    </div>
                                                @endif
                                                @if($payment_method->method!="Bank Payment" && $payment_method->method!="Offline Payment" && $payment_method->method!="Wallet")

                                                    <div class="row imageBox mt-4">
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-35">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('setting.Logo')}}</label>
                                                                <div class="primary_file_uploader">
                                                                    <input class="primary-input filePlaceholder"
                                                                           type="text"
                                                                           value="{{showPicName(@$payment_method->logo)}}"
                                                                           placeholder="Browse Image file"
                                                                           readonly="">
                                                                    <button class="" type="button">
                                                                        <label
                                                                            class="primary-btn small fix-gr-bg"
                                                                            for="document_file_1_edit_{{@$payment_method->id}}">{{__('common.Browse')}}</label>
                                                                        <input type="file"
                                                                               class="d-none fileUpload"
                                                                               name="logo"
                                                                               id="document_file_1_edit_{{@$payment_method->id}}"
                                                                        >
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div
                                                                class="payment_gateway_preview_image_contaienr">
                                                                <div class="img">

                                                                    <img class="p-3 preview"
                                                                         src="{{asset($payment_method->logo)}}"
                                                                         alt="">


                                                                </div>
                                                            </div>



                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row mt-40">
                                                    <div class="col-lg-12 text-center">
                                                        <button type="submit"
                                                                class="primary-btn fix-gr-bg">
                                                            <i class="ti-check"></i>
                                                            {{__('common.Update')}}
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </form>


                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/gateway.js')}}"></script>
@endpush
