<div class="container">
    <input type="hidden" value="{{ asset('/') }}" id="baseUrl">

    <form action="{{route('makePlaceOrder')}}" id="orderFrom" method="post">
        @csrf

        <div class="checkout_wrapper" id="mainFormData">
            <input type="hidden" name="tracking_id" value="{{$checkout->tracking}}">
            <input type="hidden" name="id" value="{{$checkout->id}}">
            <div class="billing_details_wrapper">
                <div class="row">
                    @if(count($bills) > 0)

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
                        <div class="col-lg-12 col-12 w-100 prev_billings mt-2">
                            <label class="primary_label2">{{__('frontendmanage.Billing Address')}} <span
                                    class="required_mark">*</span>
                            </label>


                            <select name="old_billing" class="mb-3 wide mb_20 w-100 old_billing small_select">
                                @if(isset($bills))
                                    @foreach($bills as $bill)
                                        <option value="{{$bill->id}}"
                                                data-id="{{$bill}}">{{$bill->first_name}} {{$bill->last_name}}
                                            => {{$bill->address1}} {{$bill->cityDetails->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="billing_address" value="new">
                    @endif
                    @php
                        if (isset($is_physical)){
                             Session::put('is_physical', $is_physical);
                        }
                    @endphp
                    @if (isModuleActive('Store') && $is_physical > 0)
                        <div class="col-lg-12 col-12 w-100 prev_billings">
                            <label class="primary_label2">{{ __('product.Shipping Methods') }} <span>*</span>
                            </label>
                            <select name="shipping_methods"
                                    class="mb-3 wide mb_20 w-100 shipping_methods small_select">
                                @if (isset($shipping_methods))
                                    @foreach ($shipping_methods as $item)
                                        <option
                                            value="{{ $item->id }}" {{ $item->id == $shipping_charge->id ? 'selected':'' }} >
                                            {{ $item->method_name }} {{ $item->shipment_time }}
                                            => {{ getPriceFormat($item->cost) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif

                </div>

                <div class="d-none d-sm-none d-md-block d-lg-block d-xl-block">
                    <div class="d-flex gap-3 align-items-center mt-3 mb_30">
                        <h3 class="font_22 f_w_700 billing_heading mb-0">
                            <span class="billing_heading_edit">{{__('common.Edit')}}</span>
                            {{__('frontend.Billing Details')}}</h3>
                        <a href="{{route('CheckOut')}}" class="theme_btn py-2">{{__('frontend.Reset')}}</a>
                    </div>

                    <table class="table table-bordered billing_info"
                           style=" @if(count($bills) == 0) display: none @endif">
                        <tr>
                            <td colspan="2">
                                <button type="button" class="theme_btn small_btn4 float-end"
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
                        <tr class="">
                            <td>{{__('common.Phone')}}</td>
                            <td class="billing_phone">{{isset($bills[0]->phone)?$bills[0]->phone:''}}</td>
                        </tr>
                        <tr>
                            <td>{{__('frontend.Company Name')}}</td>
                            <td class="billing_company">{{isset($bills[0]->company_name)?$bills[0]->company_name:''}}</td>
                        </tr>
                        <tr>
                            <td>{{__('frontend.Country')}}</td>
                            <td class="billing_country">{{isset($bills[0]->country)?$bills[0]->countryDetails->name:''}}</td>
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
                            <td>{{__('frontend.Zip Code')}}</td>
                            <td class="billing_zip">{{isset($bills[0]->zip_code)?$bills[0]->zip_code:''}}</td>
                        </tr>
                        <tr>
                            <td>{{__('frontend.Street Address')}}</td>
                            <td class="billing_address">{{isset($bills[0]->address1)?$bills[0]->address1:''}} {{isset($bills[0]->address2)?$bills[0]->address2:''}}</td>
                        </tr>

                        <tr>
                            <td>{{__('frontend.Order Details')}}</td>
                            <td class="billing_details">{{isset($bills[0]->details)?$bills[0]->details:''}}</td>
                        </tr>
                    </table>
                </div>
                <div class="row billing_form" style=" @if(count($bills) > 0) display: none @endif">
                    <input type="hidden" name="previous_address_edit" value="0" id="previous_address_edit">
                    <div class="col-lg-4">

                        @php
                            $name =  explode(" ", $profile->name);

                        @endphp
                        <label class="primary_label2">{{__('frontend.First Name')}} <span class="required_mark">*</span></label>
                        <input id="first_name" name="first_name" placeholder="{{__('frontend.Enter First Name')}}"
                               class="primary_input3"
                               value="{{(!empty($current)) ? $current->first_name : $name[0]??''}}"
                               type="text" {{$errors->first('first_name') ? 'autofocus' : ''}}>
                        <span class="text-danger">{{$errors->first('first_name')}}</span>
                    </div>
                    <div class="col-lg-4">
                        <label class="primary_label2">{{__('frontend.Last Name')}} </label>
                        <input id="last_name" name="last_name" placeholder="{{__('frontend.Enter Last Name')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('frontend.Enter Last Name')}}'"
                               class="primary_input3"
                               value="@if(!empty($current)){{$current->last_name}}@else{{$name[1]??''}}@endif"
                               type="text" {{$errors->first('last_name') ? 'autofocus' : ''}}>
                        <span class="text-danger">{{$errors->first('last_name')}}</span>
                    </div>

                    <div class="col-lg-4">
                        <label class="primary_label2">{{__('frontend.Company Name')}} ({{__('frontend.Optional')}}
                            )</label>
                        <input id="company_name" name="company_name" placeholder="{{__('frontend.Enter Company Name')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('frontend.Enter Company Name')}}'"
                               class="primary_input3"
                               type="text"
                               value="@if(!empty($current)){{$current->company_name}}@else{{old('company_name')}}@endif">
                    </div>
                    <div class="col-lg-12 mt_20">
                        <label class="primary_label2">{{__('frontend.Country')}} <span class="required_mark">*</span>
                        </label>
                        <select id="country" name="country"
                                class="select2 mb-3 w-100" {{$errors->first('country') ? 'autofocus' : ''}}>
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


                    <div class="col-lg-4 mt_20">
                        <label class="primary_label2"> {{__('common.State')}} </label>

                        <select class=" select2 wide stateList" name="state" id="state">
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

                    <div class="col-lg-4 mt_20">
                        <label class="primary_label2">{{__("frontend.City / Town")}}  </label>

                        <select class=" select2 wide cityList" name="city" id="city">
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

                    <div class="col-lg-12 mt_20">
                        <label class="primary_label2">{{__('frontend.Street Address')}}  </label>
                        <input id="address1" name="address1"
                               placeholder="{{__('frontend.House Number and street address')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('frontend.House Number and street address')}}'"
                               class="primary_input3" type="text"
                               value="{{old('address1',!empty($current)?$current->address1:'')}}" {{$errors->first('address1') ? 'autofocus' : ''}}>
                        <span class="text-danger">{{$errors->first('address1')}}</span>
                    </div>
                    <div class="col-lg-12 mt-2">
                        <input id="address2" name="address2"
                               placeholder="{{__("frontend.Apartment, suite, unit etc (Optional)")}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__("frontend.Apartment, suite, unit etc (Optional)")}}'"
                               class="primary_input3" type="text"
                               value="{{old('address2',!empty($current)?$current->address2:'')}}">
                    </div>
                    <div class="col-lg-12 mt_20 ">
                        <label class="primary_label2">{{__("frontend.Postcode / ZIP")}} ({{__('frontend.Optional')}}
                            )</label>
                        <input id="zip_code" name="zip_code" placeholder="{{__('frontend.Enter Company Name')}}"
                               onfocus="this.placeholder = ''" class="primary_input3"
                               type="text"
                               value="@if(!empty($current)){{$current->zip_code}}@else{{old('zip_code')}}@endif">
                    </div>


                    <div class="col-lg-6 mt_20 ">
                        <label class="primary_label2">{{__('frontend.Phone No')}} <span
                                class="required_mark">*</span></label>
                        <input id="phone" name="phone" placeholder="01XXXXXXXXXX" onfocus="this.placeholder = ''"
                               onblur="this.placeholder ='01XXXXXXXXXX'" class="primary_input3"
                               type="text"
                               value="@if(!empty($current)){{$current->phone}}@else{{!empty($profile->phone)?$profile->phone:''}}@endif" {{$errors->first('phone') ? 'autofocus' : ''}}>
                        <span class="text-danger">{{$errors->first('phone')}}</span>
                    </div>
                    <div class="col-lg-6 mt_20 mb_35 ">
                        <label class="primary_label2">{{__('frontend.Email Address')}} <span
                                class="required_mark">*</span></label>
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
                        <textarea id="details" name="details" class="primary_textarea3 h100px"
                                  placeholder="{{ __('frontend.Note about your order, e.g. special note for your delivery') }}"
                                  onfocus="this.placeholder = ''"
                                  onblur="this.placeholder = '{{ __('frontend.Note about your order, e.g. special note for your delivery') }}'">{{ !empty($current) ? $current->details : old('details') }}</textarea>


                    </div>
                </div>
            </div>
            <div class="order_wrapper">
                <div>
                    <h3 class="font_22 f_w_700 mb_30">{{__('frontend.Your order')}}</h3>
                    <div class="ordered_products">
                        @php $totalSum=0; @endphp
                        @if(isset($carts))
                            @foreach($carts as $cart)
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
                                                if ($cart->course->discount_price>0) {
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

                                <div class="single_ordered_product gap-3">
                                    <div class="product_name d-flex align-items-center">
                                        <div class="thumb"
                                             style="background-image: url('{{getCourseImage(@$cart->course->thumbnail)}}')"></div>
                                        <span>
                                            @if ($cart->product_sku_label)
                                                {{  $cart->course->title . ' ('. $cart['product_sku_label'].')'}}
                                            @elseif (isModuleActive('BundleSubscription') && $cart->bundle_course_id)
                                                {{  $cart->bundle->title}}
                                            @elseif (isModuleActive('Appointment') && $cart->schedule_id)
                                                {{  showDate($cart->schedule->schedule_date)}}
                                            @else
                                                {{$cart?->course?->title??''}}
                                            @endif
                                        </span></div>
                                    <div class="d-flex justify-content-end gap-4 cart-qty-prise">
                                        {{--                                        <span class="cart_qty_added">x<span>1</span></span>--}}
                                        <span class="order_prise f_w_500 font_14 text-nowrap">
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
                    @if(showEcommerce())
                        <div class="ordered_products_lists">


                            <div class="single_lists">
                            <span class=" total_text">
                                @if($checkout->purchase_price == 0)
                                    {{__('frontend.Payable Amount')}}
                                @else
                                    {{__('frontend.Subtotal')}}
                                @endif
                            </span>
                                <span>{{getPriceFormat($checkout->price)}}</span>
                            </div>
                            @if($checkout->purchase_price > 0)

                                <div class="single_lists" id="couponBox"
                                     style="display: {{$checkout->discount ==0?'block':'none'}}">

                                    <div class="coupon_wrapper align-items-start">
                                        <input type="hidden" id="total"
                                               value="{{isset($totalSum)?$totalSum:0}}">

                                        <input id="code" name="code" placeholder="{{__('coupons.Enter coupon code')}}"
                                               class="primary_input3 " type="text">
                                        <button type="button" id="applyCoupon"
                                                class="theme_btn small_btn2 ">{{__('coupons.Apply')}}</button>
                                    </div>
                                    {{--                        </form>--}}
                                </div>



                                <div class="single_lists" id="discountBox"
                                     style="display: {{$checkout->discount !=0?'block':'none'}}">

                                    <span class="total_text">{{__('payment.Discount Amount')}}   </span>
                                    <div class="" id="cancelCoupon">

                                        <svg id="icon3" xmlns="http://www.w3.org/2000/svg" width="16"
                                             height="16" viewBox="0 0 16 16">
                                            <path data-name="Path 174" d="M0,0H16V16H0Z" fill="none"/>
                                            <path data-name="Path 175"
                                                  d="M14.95,6l-1-1L9.975,8.973,6,5,5,6,8.973,9.975,5,13.948l1,1,3.973-3.973,3.973,3.973,1-1L10.977,9.975Z"
                                                  transform="translate(-1.975 -1.975)"
                                                  fill="var(--system_primery_color)"/>
                                        </svg>

                                    </div>
                                    <span class="discountAmount"></span>
                                </div>



                                <div class="single_lists" id="discountBox"
                                     style="display: {{$checkout->discount !=0?'block':'none'}}">

                                    <span class="total_text">{{__('payment.Discount Amount')}}   </span>
                                    <div class="" id="cancelCoupon">

                                        <svg id="icon3" xmlns="http://www.w3.org/2000/svg" width="16"
                                             height="16" viewBox="0 0 16 16">
                                            <path data-name="Path 174" d="M0,0H16V16H0Z" fill="none"/>
                                            <path data-name="Path 175"
                                                  d="M14.95,6l-1-1L9.975,8.973,6,5,5,6,8.973,9.975,5,13.948l1,1,3.973-3.973,3.973,3.973,1-1L10.977,9.975Z"
                                                  transform="translate(-1.975 -1.975)"
                                                  fill="var(--system_primery_color)"/>
                                        </svg>

                                    </div>
                                    <span class="discountAmount"></span>
                                </div>

                                @if(hasTax())
                                    <div class="single_lists">
                                        <span class="total_text">{{__('tax.TAX')}}   </span>

                                        <span class="totalTax">{{getPriceFormat(taxAmount($checkout->price))}}</span>
                                    </div>
                                @endif
                                @if (isModuleActive('Store') && $is_physical > 0)
                                    <div class="single_lists">
                                        <span class=" total_text">
                                            {{ __('product.Shipping Charge') }}
                                        </span>
                                        <span>{{ getPriceFormat($shipping_charge->cost) }}</span>
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
                                    <span class="total_text">{{__('frontend.Payable Amount')}} </span>
                                    @if(hasTax())
                                        <span class="totalBalance">{{getPriceFormat($checkout->purchase_price)}}</span>
                                    @else
                                        <span class="totalBalance">{{getPriceFormat($checkout->purchase_price)}}</span>
                                    @endif

                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="bank_transfer">
                        <p class=" mb-2">{{__("frontend.Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy")}}
                            .</p>

                        <label class="primary_checkbox d-flex align-content-between justify-content-between"
                               for="checkbox">
                            <input type="checkbox" id="checkbox" required>
                            <span class="checkmark mr_15"></span>
                            <p class="">{{__('frontend.By signing up, you agree to')}}
                                <a target="_blank"
                                   href="{{url('pages/terms')}}">{{__('frontend.Terms of Service')}}
                                    ,{{__('frontend.Privacy Policy')}} </a> {{__('frontend.and')}}
                                <a target="_blank" href="{{url('privacy')}}">{{__('frontend.Refund policy')}}</a>
                            </p>

                        </label>
                        <div class="text-danger mb-2 d-none"
                             id="agreeAlert">{{__('frontend.Please read & agree with our terms and conditions')}}</div>
                        <button type="submit" id="submitBtn"
                                data-toggle="tooltip" data-placement="top"
                                class="theme_btn w-100 disable_btn">{{__('frontend.Place An Order')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>

    $(document).on('mouseover', '#submitBtn', function (event) {
        let alertMsgEle = $('#agreeAlert');
        if ($('#checkbox').is(':checked')) {
            alertMsgEle.addClass('d-none')
        } else {
            alertMsgEle.removeClass('d-none')
        }
    });
    $(function () {
        $('#checkbox').click(function () {
            let btn = $('#submitBtn');
            if ($(this).is(':checked')) {
                btn.removeClass('disable_btn');
                btn.removeAttr('disabled');

            } else {
                btn.addClass('disable_btn');
                btn.attr('disabled', 'disabled');

            }
        });
    });

    $(document).on('change', '.shipping_methods', function (event) {
        let shipping_method = $(this).val();
        var url = $('#baseUrl').val();
        window.location = url + '/checkout?shipping_method=' + shipping_method;
    });

</script>
