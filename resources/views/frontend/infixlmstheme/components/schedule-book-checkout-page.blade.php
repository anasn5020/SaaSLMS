<form method="POST" action="{{ route('appointment.makePlaceOrder') }}">
    @csrf
    <div>
    <div class="checkout_wrapper">
        <div class="billing_details_wrapper">
            <h3 class="font_22 f_w_700 mb_30">{{ __('appointment.Billing Details') }}</h3>
            <div class="row">
                <div class="col-lg-6">
                    <label class="primary_label2">{{ __('appointment.First Name') }} <span
                            class="required_mark">*</span></label>
                    <input name="name" placeholder="{{ __('appointment.Enter First Name') }} "
                           onfocus="this.placeholder = ''"
                           onblur="this.placeholder = '{{ __('appointment.Enter First Name') }} '"
                           class="primary_input3 mb_20" required="" type="text" value="">
                </div>
                <div class="col-lg-6">
                    <label class="primary_label2">{{ __('appointment.Last Name') }} <span class="required_mark">*</span></label>
                    <input name="lname" placeholder="{{ __('appointment.Enter Last Name') }} "
                           onfocus="this.placeholder = ''"
                           onblur="this.placeholder = '{{ __('appointment.Enter Last Name') }} '"
                           class="primary_input3 mb_20" required="" type="text">
                </div>
                <div class="col-lg-12">
                    <label class="primary_label2">{{ __('appointment.Company Name (Optional)') }}</label>
                    <input name="cname" placeholder="Enter Company Name" onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'Enter Company Name'" class="primary_input3 mb_20" required=""
                           type="text">
                </div>
                <div class="col-lg-12">
                    <label class="primary_label2">{{ __('common.Country') }} <span class="required_mark">*</span>
                    </label>
                    <select class="theme_select wide mb_20" style="display: none;">

                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                            @if (!empty($current))
                                {{ $current->country == $country->id ? 'selected' : '' }}
                                @else
                                {{ $instructor->country == $country->id ? 'selected' : '' }}
                                @endif>
                                {{ $country->name }}</option>
                        @endforeach

                    </select>

                </div>
                <div class="col-lg-12">
                    <label class="primary_label2">{{ __('frontend.Street Address') }} <span
                            class="required_mark">*</span></label>
                    <input name="sname" placeholder="House Number and street address" onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'House Number and street address'" class="primary_input3 mb_20"
                           required="" type="text">
                </div>
                <div class="col-lg-12">
                    <input name="cname" placeholder="{{ __('frontend.Apartment, suite, unit etc (Optional)') }}"
                           onfocus="this.placeholder = ''"
                           onblur="this.placeholder = '{{ __('frontend.Apartment, suite, unit etc (Optional)') }}'"
                           class="primary_input3 mb_20" required="" type="text">
                </div>
                <div class="col-lg-12">
                    <label class="primary_label2">{{ __('frontend.City / Town') }}</label>
                    <input name="cname" placeholder="Enter city/town name" onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'Enter city/town name'" class="primary_input3 mb_20" required=""
                           type="text">
                </div>

                <div class="col-lg-12">
                    <label class="primary_label2">{{ __('appointment.Postcode / ZIP (Optional)') }}</label>
                    <input name="cname" placeholder="Enter Company Name" onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'Enter Company Name'" class="primary_input3 mb_20" required=""
                           type="text">
                </div>
                <div class="col-lg-12">
                    <label class="primary_label2">{{ __('frontend.Phone No') }}</label>
                    <input name="cname" placeholder="01XXXXXXXXXX" onfocus="this.placeholder = ''"
                           onblur="this.placeholder = '01XXXXXXXXXX'" class="primary_input3 mb_20" required=""
                           type="text">
                </div>
                <div class="col-lg-12 mb_35">
                    <label class="primary_label2">{{ __('frontend.Email Address') }} <span
                            class="required_mark">*</span></label>
                    <input name="cname" placeholder="e.g example@domian.com" onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'e.g example@domian.com'" class="primary_input3 mb_20" required=""
                           type="email">
                </div>
                <div class="col-12">
                    <h3 class="font_22 f_w_700 mb_23">{{ __('frontend.Additional Information') }}</h3>
                </div>
                <div class="col-lg-12">
                    <label class="primary_label2">{{ __('frontend.Information details') }}</label>
                    <textarea class="primary_textarea3"
                              placeholder="{{ __('frontend.Note about your order, e.g. special note for you delivery') }}"
                              onfocus="this.placeholder = ''"
                              onblur="this.placeholder = '{{ __('frontend.Note about your order, e.g. special note for you delivery') }}'"></textarea>
                </div>
            </div>
        </div>


    </div>
</div>
</form>
