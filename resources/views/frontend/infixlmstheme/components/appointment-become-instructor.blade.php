<section class="hero_area become_tutor">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-6 col-md-7">
                <!-- login popup:start -->
                <div class="login_popup">
                    <div class="reg_inner">
                        <div class="reg_inner_title">
                            <h3>Become a Tutor</h3>
                            <p>Earn money on your schedule</p>
                        </div>
                        <div class="reg_inner_content">
                            @if(Settings('instructor_reg') ==1)
                                @if (saasEnv('ALLOW_GOOGLE_LOGIN') == 'true')
                                    <a href="{{ route('social.oauth', 'google') }}" class="site_btn">
                                        <svg id="google" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                             viewBox="0 0 25 25">
                                            <path id="Path_739" data-name="Path 739"
                                                  d="M5.538,146.621l-.87,3.247-3.179.067A12.517,12.517,0,0,1,1.4,138.268h0l2.831.519,1.24,2.814a7.457,7.457,0,0,0,.07,5.021Z"
                                                  transform="translate(0 -131.514)" fill="#fbbb00"></path>
                                            <path id="Path_740" data-name="Path 740"
                                                  d="M273.63,208.176a12.49,12.49,0,0,1-4.454,12.078h0l-3.565-.182-.5-3.15a7.447,7.447,0,0,0,3.2-3.8h-6.681v-4.943h12Z"
                                                  transform="translate(-248.848 -198.005)" fill="#518ef8"></path>
                                            <path id="Path_741" data-name="Path 741"
                                                  d="M49.337,316.546h0a12.5,12.5,0,0,1-18.828-3.823l4.049-3.315a7.431,7.431,0,0,0,10.709,3.8Z"
                                                  transform="translate(-29.02 -294.297)" fill="#28b446"></path>
                                            <path id="Path_742" data-name="Path 742"
                                                  d="M47.7,2.877,43.65,6.19A7.43,7.43,0,0,0,32.7,10.081l-4.07-3.332h0A12.5,12.5,0,0,1,47.7,2.877Z"
                                                  transform="translate(-27.227)" fill="#f14336"></path>
                                        </svg>
                                        <span>Log In with Google</span>
                                    </a>
                                    <div class="position-relative text-center">
                                        <p>or Sign in with Email</p>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <form action="{{route('register')}}" method="POST" id="loginForm">
                            @csrf
                            <div class="input-control">
                                <label for="title" class="input-control-label">{{__('student.Enter Full Name')}} <span
                                        class="required_mark">*</span></label>
                                <input type="text"
                                       class="input-control-input {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       placeholder="{{__('student.Enter Full Name')}}"
                                       aria-label="Username"
                                       name="name" value="{{old('name')}}">

                                <span class="text-danger" role="alert">{{$errors->first('name')}}</span>
                            </div>
                            <div class="input-control">
                                <label for="title" class="input-control-label">{{__('common.Enter Phone Number')}}
                                    <span></span></label>
                                <input type="text" class="input-control-input"
                                       placeholder="{{__('common.Enter Phone Number')}}"

                                       aria-label="phone" name="phone" value="{{old('phone')}}">
                                <span class="text-danger" role="alert">{{$errors->first('phone')}}</span>
                            </div>
                            <div class="input-control">
                                <label for="title" class="input-control-label">{{__('common.Enter Email')}} <span
                                        class="required_mark">*</span></label>
                                <input type="email"
                                       class="input-control-input {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="Type e-mail address" aria-label="Username"
                                       aria-describedby="basic-addon3" name="email"
                                       required="" value="{{old('email')}}">
                                @if($errors->first('email'))
                                    <span class="text-danger" role="alert">{{$errors->first('email')}}</span>
                                @endif
                            </div>
                            <div class="input-control">
                                <label for="title" class="input-control-label">Password <span
                                        class="required_mark">*</span></label>
                                <input type="password" name="password" class="input-control-input"
                                       placeholder="Min. 8 Character"
                                       autocomplete="new-password"
                                       required="">
                                @if($errors->first('password'))
                                    <span class="text-danger" role="alert">{{$errors->first('password')}}</span>
                                @endif
                            </div>
                            <div class="input-control">
                                <label for="title" class="input-control-label">{{__('common.Enter Confirm Password')}}
                                    <span class="required_mark">*</span></label>
                                <input type="password" class="input-control-input"
                                       placeholder="{{__('common.Enter Confirm Password')}} *"
                                       name="password_confirmation" aria-label="password_confirmation">

                                <span class="text-danger"
                                      role="alert">{{$errors->first('password_confirmation')}}</span>
                            </div>
                            @if (Settings('student_reg') == 1 && saasPlanCheck('student') == false)
                                <div class="input-control">
                                    <input type="submit" class="input-control-input" value="{{ __('common.Sign Up') }}">
                                </div>
                            @endif
                        </form>
                        @if(!auth()->check())
                            <p>{{ __('appointment.have an Account?') }} <a
                                    href="{{ route('login') }}">{{ __('common.Login') }}</a></p>
                        @endif
                    </div>
                </div>
                <!-- login popup:end -->
            </div>
        </div>
    </div>
</section>

@if (in_array('tutor-feature', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('tutor-feature', 'become_instructor_page');
    @endphp

        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_tutor_feature'))
@endif


@if (in_array('tutor-sign-up', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('tutor-sign-up', 'become_instructor_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_tutor_sign_up'))

 @endif

@if (in_array('tutor-testimonial', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('tutor-testimonial', 'become_instructor_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_tutor_testimonial'))

 @endif


@if (in_array('tutor-connect', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('tutor-connect', 'become_instructor_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_tutor_connect'))

 @endif

@if (in_array('tutor-faq', $hasDescription))
    @php
        $decription = \Modules\Appointment\Entities\AppointmentFrontendPage::description('tutor-faq', 'become_instructor_page');
    @endphp
        <?php echo $decription; ?>
@else
    @include(theme('snippets.components._appointment_tutor_faq'))

 @endif
