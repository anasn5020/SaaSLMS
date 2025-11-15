@extends(theme('auth.layouts.app'))
@section('content')
    <div class="login_wrapper">
        <div class="login_wrapper_left">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img style="width: 190px" src="{{asset(Settings('logo') )}} " alt="">
                </a>
            </div>
            <div class="login_wrapper_content">
                <h4>{{ __('frontend.2-step Verification') }} <br>
                </h4>
                <p class="pb-3">{{ __('frontend.We sent a verification code to your email. Enter the code from the email in the field below.') }}</p>

                <form action="{{ route('login') }}" method="POST" id="loginForm">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group custom_group_field">
                                <input type="hidden" name="email" value="{{ session()->get('email') }}">
                                <input type="hidden" name="password" value="{{ session()->get('password') }}">
                                <input type="hidden" name="force" value="{{ session()->get('force') }}">
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
                                <input type="password" name="two_step_verify_code" class="form-control"
                                       placeholder="{{ __('frontend.Verification Code') }}" aria-label="password"
                                       aria-describedby="basic-addon4">


                            </div>
                            @if ($errors->first('email'))
                                <span class="text-danger" role="alert">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="col-12 mt_20">

                            <button type="submit" class="theme_btn text-center w-100">
                                {{ __('frontend.Verify My Account') }}</button>

                        </div>
                    </div>
                </form>
                <p class="text-center mt_20">{{ __('frontend.Haven’t received it.') }} <a
                        href="{{ route('resend_verification_code') }}">
                        {{ __('frontend.Resend a new code.') }}
                    </a></p>
            </div>
        </div>
        @include(theme('auth.login_wrapper_right'))
    </div>
@endsection
