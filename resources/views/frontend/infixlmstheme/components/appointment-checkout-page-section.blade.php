<form method="POST" action="{{ route('makePlaceOrder') }}">
    @csrf

    <div>
        <div class="container">
        <input type="hidden" name="type" value="appointment">
        <input type="hidden" name="tracking_id" value="{{$checkout->tracking}}">
        <input type="hidden" name="id" value="{{$checkout->id}}">
        <div class="billing_details_wrapper">
            @if(count($bills) > 0)
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="remember_forgot_pass d-flex justify-content-between">
                            <label class="primary_checkbox d-flex">
                                <input type="radio" class="billing_address" checked="checked" name="billing_address"
                                       value="previous">
                                <span class="checkmark mr_15"></span>
                                <span class="label_name">{{__('frontendmanage.Previous Billing Address')}}</span>
                            </label>
                        </div>
                        <div class="remember_forgot_pass d-flex justify-content-between">
                            <label class="primary_checkbox d-flex">
                                <input type="radio" class="billing_address" name="billing_address"
                                       value="new">
                                <span class="checkmark mr_15"></span>
                                <span class="label_name">{{__('frontendmanage.New Billing Address')}}</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-12 col-12 w-100 prev_billings">
                        <label class="primary_label2">{{__('frontendmanage.Billing Address')}} <span
                                class="required_mark">*</span>
                        </label>


                        <select name="old_billing" class="mb-3 wide mb_20 w-100 old_billing small_select">
                            @if(isset($bills))
                                @foreach($bills as $bill)
                                    <option value="{{$bill->id}}"
                                            data-id="{{$bill}}">{{$bill->first_name}} {{$bill->last_name}}
                                        => {{$bill->address1}},{{$bill->city}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            @else
                <input type="hidden" name="billing_address" value="new">
            @endif
            <div class="d-none d-sm-none d-md-block d-lg-block d-xl-block">
                <h3 class="font_22 mt-3 f_w_700 mb_30 billing_heading">
                    <span class="billing_heading_edit">{{__('common.Edit')}}</span>
                    {{__('frontend.Billing Details')}}</h3>

                <table class="table table-bordered billing_info"
                       style=" @if(count($bills) == 0) display: none @endif">
                    <tr>
                        <td colspan="2">
                            <button type="button" class="theme_btn small_btn2 float-end"
                                    id="editPrevious">{{__('common.Edit')}}</button>
                        </td>
                    </tr>
                    <tr>
                        <td>{{__('common.Name')}}</td>
                        <td class="billing_name">{{isset($bills[0]->first_name)?$bills[0]->first_name:''}} {{isset($bills[0]->last_name)?$bills[0]->last_name:''}}</td>
                    </tr>
                    <tr>
                        <td>{{__('common.Email')}}</td>
                        <td class="billing_email"> {{isset($bills[0]->email)?$bills[0]->email:''}}</td>
                    </tr>
                    <tr class="d-none">
                        <td>{{__('common.Phone')}}</td>
                        <td class="billing_phone">{{isset($bills[0]->phone)?$bills[0]->phone:''}}</td>
                    </tr>
                    <tr>
                        <td>{{__('frontend.Company Name')}}</td>
                        <td class="billing_company">{{isset($bills[0]->company_name)?$bills[0]->company_name:''}}</td>
                    </tr>
                    <tr>
                        <td>{{__('frontend.Street Address')}}</td>
                        <td class="billing_address">{{isset($bills[0]->address1)?$bills[0]->address1:''}} {{isset($bills[0]->address2)?$bills[0]->address2:''}}</td>
                    </tr>
                    <tr>
                        <td>{{__('frontend.Zip Code')}}</td>
                        <td class="billing_zip">{{isset($bills[0]->zip_code)?$bills[0]->zip_code:''}}</td>
                    </tr>
                    <tr>
                        <td>{{__('common.State')}}</td>
                        <td class="billing_city">{{isset($bills[0]->state)?$bills[0]->stateDetails->name:''}}</td>
                    </tr>
                    <tr>
                        <td>{{__('frontend.City')}}</td>
                        <td class="billing_city">{{isset($bills[0]->city)?$bills[0]->cityDetails->name:''}}</td>
                    </tr>
                    <tr>
                        <td>{{__('frontend.Country')}}</td>
                        <td class="billing_country">{{isset($bills[0]->country)?$bills[0]->countryDetails->name:''}}</td>
                    </tr>
                    <tr>
                        <td>{{__('frontend.Order Details')}}</td>
                        <td class="billing_details">{{isset($bills[0]->details)?$bills[0]->details:''}}</td>
                    </tr>
                </table>
            </div>
            <div class="row billing_form" style=" @if(count($bills) > 0) display: none @endif">
                <input type="hidden" name="previous_address_edit" value="0" id="previous_address_edit">
                <div class="col-lg-6">

                    @php
                        $name =  explode(" ", $profile->name);

                    @endphp
                    <label class="primary_label2">{{__('frontend.First Name')}} <span
                            class="required_mark">*</span></label>
                    <input id="first_name" name="first_name" placeholder="{{__('frontend.Enter First Name')}}"
                           class="primary_input3"
                           value="{{old('first_name',(!empty($current)) ? $current->first_name : $name[0]??'')}}"
                           type="text" {{$errors->first('first_name') ? 'autofocus' : ''}}>
                    <span class="text-danger">{{$errors->first('first_name')}}</span>
                </div>
                <div class="col-lg-6">
                    <label class="primary_label2">{{__('frontend.Last Name')}} <span
                            class="required_mark">*</span></label>
                    <input id="last_name" name="last_name" placeholder="{{__('frontend.Enter Last Name')}}"
                           onfocus="this.placeholder = ''"
                           onblur="this.placeholder = '{{__('frontend.Enter Last Name')}}'"
                           class="primary_input3"
                           value="{{old('last_name',!empty($current) ? $current->last_name : $name[1]??'')}}"
                           type="text" {{$errors->first('last_name') ? 'autofocus' : ''}}>
                    <span class="text-danger">{{$errors->first('last_name')}}</span>
                </div>

                <div class="col-lg-12 mt_20">
                    <label class="primary_label2">{{__('frontend.Company Name')}} ({{__('frontend.Optional')}}
                        )</label>
                    <input id="company_name" name="company_name" placeholder="{{__('frontend.Enter Company Name')}}"
                           onfocus="this.placeholder = ''"
                           onblur="this.placeholder = '{{__('frontend.Enter Company Name')}}'"
                           class="primary_input3"
                           type="text"
                           value="{{old('company_name',!empty($current)?$current->company_name:'')}}"
                    >
                </div>
                <div class="col-lg-12 mt_20">
                    <label class="primary_label2">{{__('frontend.Country')}} <span class="required_mark">*</span>
                    </label>
                    <select id="country" name="country"
                            class="theme_select mb-3 wide w-100 " {{$errors->first('country') ? 'autofocus' : ''}}>
                        @if(isset($countries))
                            @foreach($countries as $country)
                                <option
                                    value="{{$country->id}}" @if(!empty($current))
                                    {{$current->country==$country->id?'selected':''}}
                                    @else
                                    {{$profile->country==$country->id?'selected':''}}
                                    @endif >{{$country->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <span class="text-danger">{{$errors->first('country')}}</span>
                </div>

                <div class="col-lg-12 mt_20">
                    <label class="primary_label2">{{__('frontend.Street Address')}} <span class="required_mark">*</span></label>
                    <input id="address1" name="address1"
                           placeholder="{{__('frontend.House Number and street address')}}"
                           onfocus="this.placeholder = ''"
                           onblur="this.placeholder = '{{__('frontend.House Number and street addres')}}s'"
                           class="primary_input3" type="text"
                           value="{{old('address1',!empty($current)?$current->address1:$profile->cityName)}}" {{$errors->first('address1') ? 'autofocus' : ''}}>
                    <span class="text-danger">{{$errors->first('address1')}}</span>
                </div>
                <div class="col-lg-12 mt-2">
                    <input id="address2" name="address2"
                           placeholder="{{__("frontend.Apartment, suite, unit etc (Optional)")}}"
                           onfocus="this.placeholder = ''"
                           onblur="this.placeholder = '{{__("frontend.Apartment, suite, unit etc (Optional)")}}'"
                           class="primary_input3" type="text"
                           value="{{old('address1',!empty($current)?$current->address2:'')}}">
                </div>
                <div class="col-lg-12 mt_20">
                    <label class="primary_label2"> {{__('common.State')}} </label>

                    <select class="theme_select wide stateList" name="state" id="state">
                        <option
                            data-display=" {{__('common.Select')}} {{__('common.State')}}"
                            value="">{{__('common.Select')}} {{__('common.State')}}
                        </option>
                        @foreach ($states as $state)
                            <option value="{{@$state->id}}"
                                    @if (@$user->state==$state->id) selected @endif>{{@$state->name}}</option>
                        @endforeach
                    </select>


                    <span class="text-danger">{{$errors->first('state')}}</span>
                </div>

                <div class="col-lg-12 mt_20">
                    <label class="primary_label2">{{__("frontend.City / Town")}}  </label>

                    <select class="theme_select wide cityList" name="city" id="city">
                        <option
                            data-display=" {{__('common.Select')}} {{__('common.City')}}"
                            value="">{{__('common.Select')}} {{__('common.City')}}
                        </option>
                        @foreach ($cities as $city)
                            <option value="{{@$city->id}}"
                                    @if (@$user->city==$city->id) selected @endif>{{@$city->name}}</option>
                        @endforeach
                    </select>


                    <span class="text-danger">{{$errors->first('city')}}</span>
                </div>
                <div class="col-lg-12 mt_20 mb_35">
                    <label class="primary_label2">{{__("frontend.Postcode / ZIP")}} ({{__('frontend.Optional')}}
                        )</label>
                    <input id="zip_code" name="zip_code" placeholder="{{__('frontend.Enter Company Name')}}"
                           onfocus="this.placeholder = ''" class="primary_input3"
                           type="text"
                           value="@if(!empty($current)){{$current->zip_code}}@else{{old('zip_code')}}@endif">
                </div>
                <div class="col-lg-12 mt_20 d-none">
                    <label class="primary_label2">{{__('frontend.Phone No')}} <span
                            class="required_mark">*</span></label>
                    <input id="phone" name="phone" placeholder="01XXXXXXXXXX" onfocus="this.placeholder = ''"
                           onblur="this.placeholder = '01XXXXXXXXXX'" class="primary_input3"
                           type="text"
                           value="@if(!empty($current)){{$current->phone}}@else{{!empty($profile->phone)?$profile->phone:'00000000000'}}@endif" {{$errors->first('phone') ? 'autofocus' : ''}}>
                    <span class="text-danger">{{$errors->first('phone')}}</span>
                </div>
                <div class="col-lg-12 mt_20 mb_35 d-none">
                    <label class="primary_label2">{{__('frontend.Email Address')}} <span class="required_mark">*</span></label>
                    <input id="email" name="email" placeholder="{{__("frontend.e.g example@domian.com")}}"
                           onfocus="this.placeholder = ''"
                           onblur="this.placeholder = '{{__("frontend.e.g example@domian.com")}}'"
                           class="primary_input3"
                           type="email"
                           value="@if(!empty($current)){{$current->email}}@else{{$profile->email}}@endif" {{$errors->first('email') ? 'autofocus' : ''}}>
                    <span class="text-danger">{{$errors->first('email')}}</span>
                </div>
                <div class="col-12">
                    <h3 class="font_22 f_w_700 mb_23">{{__('frontend.Additional Information')}}</h3>
                </div>
                <div class="col-lg-12">
                    <label class="primary_label2">{{__('frontend.Information details')}}</label>
                    <textarea id="details" name="details" class="primary_textarea3"
                              placeholder="{{__("frontend.Note about your order, e.g. special note for you delivery")}}"
                              onfocus="this.placeholder = ''"
                              onblur="this.placeholder = '{{__("frontend.Note about your order, e.g. special note for you delivery")}}'">  @if(!empty($current))
                            {{$current->details}}
                        @else
                            {{old('details')}}
                        @endif</textarea>

                </div>
            </div>
        </div>
        <div class="order_wrapper tutor_checkouts_bg">
            <h3 class="font_22 f_w_700 mb_30 p-4 pb-0">{{ __('appointment.Your order') }}</h3>
            <div class="tutor_checkouts_inner">
                <div class="tutor_checkouts_inner_head">
                    <div class="tutor_checkouts_inner_head_left position-relative">
                        <div class="tutor_checkouts_inner_head_img">
                            <img src="{{ getProfileImage($instructor->image, $instructor->name) }}" alt="">
                        </div>
                        @if($settings->review_option==1)
                            <span class="tutor_checkouts_inner_head_img_rating"><i class="fa fa-star"></i>{{ number_format($instructor->avgRating(), 1) }}</span>
                        @endif
                    </div>
                    <div class="tutor_checkouts_inner_head_right">
                        <div class="tutor_listing_item_info_profile">
                            <h4 class="m-0"><a
                                    href="{{ route('appointment.instructor',[$instructor->slug]) }}">{{ $instructor->name }}</a>
                                <span><img
                                        src="{{ asset('Modules/Appointment/Resources/assets/frontend/') }}/img/all-icons/country/{{ strtolower($instructor->userCountry->iso2) }}.svg"
                                        alt="" width="21" height="15"></span><span><img
                                        src="./img/all-icons/badge.svg" alt=""></span></h4>
                            <ul class="m-0">
                                @if($settings->number_of_student==1)
                                    <li><i class="fa fa-user-friends"></i>{{ count($instructor->bookStudents) }}
                                        {{ __('appointment.Students') }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @php
                    $tz = session()->get('timezone');
                @endphp
                <div class="tutor_checkouts_inner_date">
                    <span>{{ __('appointment.Date and time') }}</span>
                    <h5> {{ date('F j', strtotime($schedule->schedule_date)) }},

                        {{ \Carbon\Carbon::parse($schedule->schedule_date . ' ' . $schedule->slotInfo->start_time)->setTimeZone($tz)->format('h:i A') }}
                        -
                        {{ \Carbon\Carbon::parse($schedule->schedule_date . ' ' . $schedule->slotInfo->end_time)->setTimeZone($tz)->format('h:i A') }}
                    </h5>
                    <span>{{ $tz }}</span>
                </div>
                <div class="tutor_checkouts_inner_info">
                    <ul>
                        <li>
                            <b>{{ __('appointment.Service details') }}</b><span>{{ __('appointment.Price Per Hour') }}</span>
                        </li>
                        <li>
                            <b>{{ __('appointment.1 hour lesson') }}</b><span>{{ showPrice($instructor->hour_rate) }}</span>
                        </li>
                        {{-- <li><b>{{ __('appointment.Transaction Fee') }}</b><span>$0.30</span></li>
                        <li><b class="jade-green">{{ __('appointment.You save') }}</b><span
                                class="jade-green">$5.00</span></li>
                        <li><b>{{ __('appointment.Lesson Cancellation') }}</b><span class="jade-green">Free</span></li>
                        <li><b>{{ __('appointment.Grand Total') }}</b><span>$12,000.00</span></li> --}}
                    </ul>
                </div>
            </div>
            <div class="bank_transfer">
                {{-- <div class="bank_check">
                    <label class="primary_bulet_checkbox d-inline-flex">
                        <input name="qus" checked="" type="checkbox">
                        <span class="checkmark mr_10"></span>
                        <span class="label_name">{{ __('appointment.Direct Bank Transfer') }}</span>
                    </label>
                </div>
                <div class="quote">
                    <p>{{ __('appointment.Make your payment directly into our bank account Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account') }}.
                    </p>
                </div>
                <div class="payment">
                    <label class="primary_bulet_checkbox d-inline-flex">
                        <input name="qus" checked="" type="checkbox">
                        <span class="checkmark mr_10"></span>
                        <span class="label_name">{{ __('appointment.Offline Payment') }}</span>
                    </label>
                    <label class="primary_bulet_checkbox d-inline-flex">
                        <input name="qus" checked="" type="checkbox">
                        <span class="checkmark mr_10"></span>
                        <span class="label_name">{{ __('appointment.PayPal') }}</span>
                        <img src="img/cart/paypal.png" alt="">
                    </label>
                </div> --}}
                <p class="mb_35">
                    {{ __('appointment.Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy') }}
                    .
                </p>
                <button type="submit" id="submitBtn"
                        class="theme_btn w-100">{{ __('appointment.Place An Order') }}</button>
            </div>
        </div>

    </div>
</div>
</form>
