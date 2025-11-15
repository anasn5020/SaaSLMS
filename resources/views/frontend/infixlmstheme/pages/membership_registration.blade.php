<!-- hero area:start -->
@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ __('membership.Membership Registration') }}
@endsection
@section('css')

    <style>
        .theme_btn.icon-only {
            padding: 0;
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 50px;
            background: var(--system_primery_color);
            border: 1px solid transparent
        }

        .theme_btn.icon-only:hover {
            color: var(--system_primery_color);
            background-color: transparent;
            border-color: var(--system_primery_color)

        }

        .form-uploader {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #E3E6EF;
            padding: 6px;
            border-radius: 100px;
        }
    </style>
@endsection

@section('mainContent')
    <div class="container">

        <div class="checkout_wrapper" id="mainFormData">
            <form method="POST" action="{{ route('membership.registration.store') }}" id="orderFrom"
                  enctype="multipart/form-data">
                @csrf
                <div class="billing_details_wrapper">
                    <div class="row billing_form">
                        <div class="col-lg-6 mb_20">
                            <label class="primary_label2">{{ __('frontend.First Name') }} <span
                                    class="required_mark">*</span></label>
                            <input id="first_name" name="first_name" placeholder="{{ __('frontend.Enter First Name') }}"
                                   class="primary_input3" value="{{old('first_name')}}" type="text"
                                {{ $errors->first('first_name') ? 'autofocus' : '' }}>
                            <span class="text-danger">{{ $errors->first('first_name') }}</span>
                        </div>

                        <div class="col-lg-6 mb_20">
                            <label class="primary_label2">{{ __('frontend.Last Name') }} </label>
                            <input id="last_name" name="last_name" placeholder="{{ __('frontend.Enter Last Name') }}"
                                   onfocus="this.placeholder = ''"
                                   onblur="this.placeholder = '{{ __('frontend.Enter Last Name') }}'"
                                   class="primary_input3"
                                   value="{{old('last_name')}}"
                                   type="text" {{ $errors->first('last_name') ? 'autofocus' : '' }}>
                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                        </div>

                        <input type="hidden" value=" {{ isset($request) ? $request->plan_id :'' }}" name="plan_id">
                        <input type="hidden" value=" {{ isset($type) ? $type : '' }}" name="type">

                        <div class="col-lg-6 mb_20">
                            <label class="primary_label2">{{ __('frontend.Email') }} <span
                                    class="required_mark">*</span></label>
                            <input id="email" name="email" placeholder="{{ __('frontend.Enter Email') }}"
                                   class="primary_input3" value="{{old('email')}}" type="text"
                                {{ $errors->first('email') ? 'autofocus' : '' }}>
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>

                        <div class="col-lg-6 mb_20">
                            <label class="primary_label2">{{ __('frontend.Phone No') }}</label>
                            <input id="phone" name="phone_number" placeholder="01XXXXXXXXXX"
                                   onfocus="this.placeholder = ''"
                                   onblur="this.placeholder = '01XXXXXXXXXX'" class="primary_input3" type="text"
                                   value="{{old('phone')}}"
                                {{ $errors->first('phone') ? 'autofocus' : '' }}>
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        </div>

                        <div class="col-lg-6 mb_20">
                            <label class="primary_label2">{{ __('frontend.Password') }} <span
                                    class="required_mark">*</span></label>
                            <input id="password" name="password" placeholder="{{ __('frontend.Enter Password') }}"
                                   class="primary_input3" value="" type="password"
                                   autocomplete="new-password"
                                {{ $errors->first('password') ? 'autofocus' : '' }}>
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        </div>

                        <div class="col-lg-6 mb_20">
                            <label class="primary_label2">{{ __('frontend.CV') }}  </label>
                            <label for="cv" class="form-uploader mb-0 rounded-1">
                                <input onchange="readURL(this, '#placeholderCvName')" type="file" name="cv" id="cv"
                                       class="d-none" value="" {{ $errors->first('cv') ? 'autofocus' : '' }}>
                                <span id="placeholderCvName" class="ps-3">{{__('common.Browse File')}}</span>
                                <a class="theme_btn rounded-1 py-2 px-3 fw-normal">{{__('common.Browse')}}</a>
                            </label>
                        </div>

                        <div class="col-10 col-md-9 mb_20">
                            <label class="primary_label2">{{ __('frontend.Qualification') }}</label>
                            <label for="qualifications" class="form-uploader mb-0 rounded-1">
                                <input onchange="readURL(this, '#placeholderqualifications')" id="qualifications"
                                       name="qualifications[]" placeholder="{{ __('common.Choose File') }}"
                                       class="d-none"
                                       onfocus="this.placeholder = ''"
                                       onblur="this.placeholder = '{{ __('common.Choose File') }}'"
                                       class="primary_input3" type="file" value=""
                                    {{ $errors->first('qualifications') ? 'autofocus' : '' }}>
                                <span id="placeholderqualifications" class="ps-3">{{__('common.Browse File')}}</span>
                                <a class="theme_btn rounded-1 py-2 px-3 fw-normal">{{__('common.Browse')}}</a>
                            </label>
                            <span class="text-danger">{{ $errors->first('qualifications') }}</span>
                        </div>

                        <div class="col-2 col-md-3 mb_20">
                            <div class="mt_30 text-end pt-1">
                                <button type="button" class="theme_btn icon-only fix-gr-bg"
                                        id="addRowBtn">
                                    <span class="ti-plus "></span></button>
                            </div>
                        </div>

                        <div class="col-lg-12 appendDiv">

                        </div>
                    </div>
                    <div class="mt_20">
                        <button type="submit" id="submitBtn"
                                class="theme_btn w-100">{{ __('frontend.Register As Member') }}</button>
                    </div>
                </div>

            </form>
            <div class="order_wrapper">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h3 class="font_22 f_w_700 mb_30">{{ __('frontend.Login') }}</h3>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group custom_group_field align-items-center">
                                <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">
                                <!-- svg -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.328" height="10.662"
                                     viewBox="0 0 13.328 10.662">
                                    <path id="Path_44" data-name="Path 44"
                                          d="M13.995,4H3.333A1.331,1.331,0,0,0,2.007,5.333l-.007,8a1.337,1.337,0,0,0,1.333,1.333H13.995a1.337,1.337,0,0,0,1.333-1.333v-8A1.337,1.337,0,0,0,13.995,4Zm0,9.329H3.333V6.666L8.664,10l5.331-3.332ZM8.664,8.665,3.333,5.333H13.995Z"
                                          transform="translate(-2 -4)" fill="#687083"/>
                                </svg>
                                <!-- svg -->
                            </span>
                                </div>
                                <input type="email" value="{{old('email')}}"
                                       class="form-control bg-transparent {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="{{__('common.Enter Email')}}" name="email" aria-label="Username"
                                       aria-describedby="basic-addon3">
                            </div>
                            @if($errors->first('email'))
                                <span class="text-danger" role="alert">{{$errors->first('email')}}</span>
                            @endif
                        </div>

                        <div class="col-12 mt_20">
                            <div class="input-group custom_group_field align-items-center">
                                <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon4">
                                <!-- svg -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="10.697" height="14.039"
                                     viewBox="0 0 10.697 14.039">
                                <path id="Path_46" data-name="Path 46"
                                      d="M9.348,11.7A1.337,1.337,0,1,0,8.011,10.36,1.341,1.341,0,0,0,9.348,11.7ZM13.36,5.68h-.669V4.343a3.343,3.343,0,0,0-6.685,0h1.27a2.072,2.072,0,0,1,4.145,0V5.68H5.337A1.341,1.341,0,0,0,4,7.017V13.7a1.341,1.341,0,0,0,1.337,1.337H13.36A1.341,1.341,0,0,0,14.7,13.7V7.017A1.341,1.341,0,0,0,13.36,5.68Zm0,8.022H5.337V7.017H13.36Z"
                                      transform="translate(-4 -1)" fill="#687083"/>
                                </svg>
                                <!-- svg -->
                            </span>
                                </div>
                                <input type="password" name="password" class="form-control bg-transparent"
                                       autocomplete="new-password"
                                       placeholder="{{__('common.Enter Password')}}" aria-label="password"
                                       aria-describedby="basic-addon4">
                            </div>
                            @if($errors->first('password'))
                                <span class="text-danger" role="alert">{{$errors->first('password')}}</span>
                            @endif
                        </div>
                        <div class="col-12 mt_20">
                            @if(saasEnv('NOCAPTCHA_FOR_LOGIN')=='true')
                                @if(saasEnv('NOCAPTCHA_IS_INVISIBLE')=="true")
                                    {!! NoCaptcha::display(["data-size"=>"invisible"]) !!}
                                @else
                                    {!! NoCaptcha::display() !!}
                                @endif

                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger"
                                          role="alert">{{$errors->first('g-recaptcha-response')}}</span>
                                @endif
                            @endif
                        </div>
                        <div class="col-12 mt_20">
                            <div class="remember_forgot_pass d-flex justify-content-between">
                                <label class="primary_checkbox d-flex">
                                    <input type="checkbox" name="remember"
                                           {{ old('remember') ? 'checked' : '' }} value="1">
                                    <span class="checkmark mr_15"></span>
                                    <span class="label_name">{{__('common.Remember Me')}}</span>
                                </label>
                                <a href="{{route('SendPasswordResetLink')}}"
                                   class="forgot_pass">{{__('common.Forgot Password ?')}}</a>
                            </div>
                        </div>
                        <div class="col-12">

                            @if(saasEnv('NOCAPTCHA_FOR_LOGIN')=='true' && saasEnv('NOCAPTCHA_IS_INVISIBLE')=="true")

                                <button type="button" class="g-recaptcha theme_btn text-center w-100"
                                        data-sitekey="{{saasEnv('NOCAPTCHA_SITEKEY')}}" data-size="invisible"
                                        data-callback="onSubmit"
                                        class="theme_btn text-center w-100"> {{__('common.Login')}}</button>
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                <script>
                                    function onSubmit(token) {
                                        document.getElementById("loginForm").submit();
                                    }
                                </script>
                            @else
                                <button type="submit"
                                        class="theme_btn text-center w-100"> {{__('common.Login')}}</button>
                            @endif
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            var count = 0;
            $(document).on('click', '#addRowBtn', function () {
                count++;
                var row = `
                    <div class="row">
                        <div class="col-10 col-md-9 mb_20">
                            <label class="primary_label2">{{ __('frontend.Qualification') }}</label>
                            <label for="qualifications${count}" class="form-uploader mb-0 rounded-1">
                                <input onchange="readURL(this, '#placeholderQli${count}')" id="qualifications${count}" name="qualifications[]" placeholder="{{ __('common.Choose File') }}" class="d-none"
                                    onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = '{{ __('common.Choose File') }}'"
                                    class="primary_input3" type="file" value=""
                                    {{ $errors->first('qualifications') ? 'autofocus' : '' }}>
                                <span id="placeholderQli${count}" class="ps-3">{{__('common.Browse File')}}</span>
                                <a class="theme_btn rounded-1 py-2 px-3 fw-normal">{{__('common.Browse')}}</a>
                            </label>
                            <span class="text-danger">{{ $errors->first('qualifications') }}</span>
                        </div>
                        <div class="col-2 col-md-3 mb_20">
                            <div class="mt_30 text-end pt-1">
                                <button type="button" class="theme_btn icon-only fix-gr-bg removeQualification">
                                    <span class="ti-trash"></span></button>
                            </div>
                        </div>
                    </div>
                `;

                $('.appendDiv').append(row);
            })
            $(document).on('click', '.removeQualification', function () {
                $(this).parent().parent().parent().remove();
            })
        })
    </script>
    <script>
        function readURL(input, id) {
            if (input.files && input.files[0]) {
                $(id).html(input.files[0].name);
            } else {
                $(id).html("{{__('common.Browse File')}}");
            }
        }
    </script>
@endsection
