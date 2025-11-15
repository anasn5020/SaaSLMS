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
                <h4>{{__('frontend.Welcome back. Please login')}} <br>{{__('frontend.to your account')}} </h4>

                <div class="socail_links">


                    @if(saasEnv('ALLOW_FACEBOOK_LOGIN')=='true')

                        <a href="{{ route('social.oauth', 'facebook') }}"
                           class="theme_btn small_btn2 text-center facebookLoginBtn">
                            <i class="fab fa-facebook-f"></i>
                            {{__('frontend.Login with Facebook')}}</a>
                    @endif

                    @if(saasEnv('ALLOW_GOOGLE_LOGIN')=='true')
                        <a href="{{ route('social.oauth', 'google') }}"
                           class="theme_btn small_btn2 text-center googleLoginBtn">
                            <i class="fab fa-google"></i>
                            {{__('frontend.Login with Google')}}</a>
                    @endif
                </div>
                @if(saasEnv('ALLOW_FACEBOOK_LOGIN')=='true' || saasEnv('ALLOW_GOOGLE_LOGIN')=='true')
                    <p class="login_text">{{__('frontend.Or')}} {{__('frontend.login with Email Address')}}</p>
                @endif

                <form action="{{route('login')}}" method="POST" id="loginForm">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group custom_group_field">
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
                                       class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="{{__('common.Enter Email')}}" name="email" aria-label="Username"
                                       aria-describedby="basic-addon3">
                            </div>
                            @if($errors->first('email'))
                                <span class="text-danger" role="alert">{{$errors->first('email')}}</span>
                            @endif
                        </div>

                        <div class="col-12 mt_20">
                            <div class="input-group custom_group_field">
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
                                <input type="password" name="password" class="form-control"
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
                            <div class="remember_forgot_pass d-flex justify-content-between flex-wrap row-gap-4">
                                <label class="primary_checkbox d-flex mb-0">
                                <input type="checkbox" name="remember"
                                           {{ old('remember') ? 'checked' : '' }} value="1">
                                    <span class="checkmark me-2"></span>
                                    <span class="label_name">{{__('common.Remember Me')}}</span>
                                </label>
                                @if(Settings('allow_force_logout'))
                                    <label class="primary_checkbox d-flex mb-0">
                                        <input type="checkbox" name="force"
                                               {{ old('force') ? 'checked' : '' }} value="1">
                                        <span class="checkmark me-2"></span>
                                        <span class="label_name">{{__('auth.Force login')}}</span>
                                    </label>
                                @endif
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
            @if(Settings('student_reg')==1 && saasPlanCheck('student')==false)
                <h5 class="shitch_text mb-0">{{__("frontend.Don’t have an account")}}? <a href="{{route('register')}}">
                        {{__('common.Register')}}
                    </a></h5>
            @endif
            @if(config('app.demo_mode'))
                <div class="row g-2 mt-2">
                    @foreach($roles as $role)
                        <div class="col-sm-4 mb_10">
                            <a class="theme_btn small_btn2 text-center w-100"
                               href="{{route('auto.login',$role->id)}}">{{$role->name}}</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @include('frontend.infixlmstheme.auth.login_wrapper_right')
    </div>

    {!! Toastr::message() !!}
    <script>
        $('form').submit(function (e) {
            $(":submit").attr("disabled", true);
        });
    </script>
@endsection
