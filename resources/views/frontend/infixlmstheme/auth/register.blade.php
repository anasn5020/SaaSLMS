@php use Modules\StudentSetting\Entities\Institute; @endphp
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
                <h4>{{__('common.Sign Up Details')}}</h4>
                <form action="{{route('register')}}" method="POST" id="regForm">
                    @csrf
                    <div class="row">

                        @if(isModuleActive('Organization'))
                            <div class="col-12 mt_20">
                                <label>{{trans('organization.account_type')}}</label>
                                <ul class="quiz_select d-flex">
                                    <li>
                                        <label
                                            class="primary_bulet_checkbox d-flex">
                                            <input checked class="quizAns"
                                                   name="account_type"
                                                   type="radio"
                                                   value="3">

                                            <span
                                                class="checkmark mr_10"></span>
                                            <span
                                                class="label_name">{{__('common.Student')}} </span>
                                        </label>
                                    </li>

                                    <li class="ms-3">
                                        <label
                                            class="primary_bulet_checkbox d-flex">
                                            <input class="quizAns"
                                                   name="account_type"
                                                   type="radio"
                                                   value="5">

                                            <span
                                                class="checkmark mr_10"></span>
                                            <span
                                                class="label_name">{{__('organization.Organization')}} </span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        @endif

                        @if($custom_field->show_name)
                            <div class="col-12 mt_20">
                                <div class="input-group custom_group_field">
                                    <input type="text" class="form-control ps-0"
                                           placeholder="{{__('student.Enter Full Name')}} {{ $custom_field->required_name ? '*' : ''}}"
                                           {{ $custom_field->required_name ? 'required' : ''}} aria-label="Username"
                                           name="name" value="{{old('name')}}">
                                </div>
                                <span class="text-danger" role="alert">{{$errors->first('name')}}</span>
                            </div>
                        @endif
                        <div class="col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <input type="email" class="form-control ps-0" required
                                       placeholder="{{__('common.Enter Email')}} *" aria-label="email" name="email"
                                       value="{{old('email')}}">
                            </div>
                            <span class="text-danger" role="alert">{{$errors->first('email')}}</span>
                        </div>

                        @if($custom_field->show_phone)
                            <div class="col-12 mt_20">
                                <div class="input-group custom_group_field">
                                    <input type="text" class="form-control ps-0"
                                           placeholder="{{__('common.Enter Phone Number')}} {{ $custom_field->required_phone ? '*' : ''}}"
                                           {{ $custom_field->required_phone ? 'required' : ''}}
                                           aria-label="phone" name="phone" value="{{old('phone')}}">
                                </div>
                                <span class="text-danger" role="alert">{{$errors->first('phone')}}</span>
                            </div>
                        @endif
                        <div class="col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <input type="password" class="form-control ps-0" required
                                       placeholder="{{__('frontend.Enter Password')}} *"
                                       autocomplete="new-password"
                                       aria-label="password" name="password">
                            </div>
                            <span class="text-danger" role="alert">{{$errors->first('password')}}</span>
                        </div>
                        <div class="col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <input type="password" class="form-control ps-0" required
                                       placeholder="{{__('common.Enter Confirm Password')}} *"
                                       name="password_confirmation" aria-label="password_confirmation">
                            </div>
                            <span class="text-danger" role="alert">{{$errors->first('password_confirmation')}}</span>
                        </div>

                        @if($custom_field->show_dob)
                            <div class="col-12 mt_20">
                                <div class="input-group custom_group_field">
{{--                                    <label for="dob">{{__('common.Date of Birth')}} : </label>--}}
                                    <input id="dob" type="text" class="form-control ps-0 datepicker w-100" width="300"
                                           placeholder="{{__('common.Date of Birth')}} {{ $custom_field->required_dob ? '*' : ''}}"
                                           {{ $custom_field->required_dob ? 'required' : ''}} aria-label="Username"
                                           name="dob" data-prevent-future="1"  value="{{ old('dob') }}">
                                </div>
                                <span class="text-danger" role="alert">{{$errors->first('name')}}</span>
                            </div>
                        @endif


                        @if($custom_field->show_company)
                            <div class="col-12 mt_20">
                                <div class="input-group custom_group_field">
                                    <input type="text" class="form-control ps-0"
                                           placeholder="{{__('common.Enter Company')}} {{ $custom_field->required_company ? '*' : ''}}"
                                           {{ $custom_field->required_company ? 'required' : ''}} aria-label="email"
                                           name="company" value="{{old('company')}}">
                                </div>
                                <span class="text-danger" role="alert">{{$errors->first('company')}}</span>
                            </div>
                        @endif

                        @if($custom_field->show_identification_number)
                            <div class="col-12 mt_20">
                                <div class="input-group custom_group_field">
                                    <input type="text" class="form-control ps-0"
                                           placeholder="{{__('common.Enter Identification Number')}} {{ $custom_field->required_identification_number ? '*' : ''}}"
                                           {{ $custom_field->required_identification_number ? 'required' : ''}}
                                           aria-label="email" name="identification_number"
                                           value="{{old('identification_number')}}">
                                </div>
                                <span class="text-danger"
                                      role="alert">{{$errors->first('identification_number')}}</span>
                            </div>
                        @endif

                        @if($custom_field->show_job_title)
                            <div class="col-12 mt_20">
                                <div class="input-group custom_group_field">
                                    <input type="text" class="form-control ps-0"
                                           placeholder="{{__('common.Enter Job Title')}} {{ $custom_field->required_job_title ? '*' : ''}}"
                                           {{ $custom_field->required_job_title ? 'required' : ''}} aria-label="email"
                                           name="job_title" value="{{old('job_title')}}">
                                </div>
                                <span class="text-danger" role="alert">{{$errors->first('job_title')}}</span>
                            </div>
                        @endif

                        @if($custom_field->show_gender)
                            <div class="col-xl-12">
                                <div class="short_select mt-3">
                                    <div class="row">
                                        <div class="col-xl-5">
                                            <h5 class="mr_10 font_16 f_w_500 mb-0">{{ __('common.choose_gender') }} {{ $custom_field->required_gender ? '*' : '' }}</h5>
                                        </div>
                                        <div class="col-xl-7">
                                            <select class="small_select w-100"
                                                    name="gender" {{ $custom_field->required_gender ? 'selected' : '' }}>
                                                {{--                                                <option value="" data-display="Choose">{{__('common.Choose')}}</option>--}}
                                                <option value="male">{{__('common.Male')}}</option>
                                                <option value="female">{{__('common.Female')}}</option>
                                                <option value="other">{{__('common.Other')}}</option>
                                            </select>

                                        </div>
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('gender')}}</span>

                                </div>
                            </div>
                        @endif

                        @if($custom_field->show_student_type)
                            <div class="col-xl-12">
                                <div class="short_select mt-3">
                                    <div class="row">
                                        <div class="col-xl-5">
                                            <h5 class="mr_10 font_16 f_w_500 mb-0">{{ __('common.choose_student_type') }} {{ $custom_field->required_student_type ? '*' : '' }}</h5>
                                        </div>
                                        <div class="col-xl-7">
                                            <select class="small_select w-100"
                                                    name="student_type" {{ $custom_field->required_student_type ? 'selected' : '' }}>
                                                <option value="personal">{{__('common.Personal')}}</option>
                                                <option value="corporate">{{__('common.Corporate')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('student_type')}}</span>

                                </div>
                            </div>
                        @endif

                        @if($custom_field->show_institute)
                            <div class="col-xl-12">
                                <div class="short_select mt-3">
                                    <div class="row">
                                        <div class="col-xl-5">
                                            <h5 class="mr_10 font_16 f_w_500 mb-0">{{ __('common.choose_institute') }} {{ $custom_field->required_institute ? '*' : '' }}</h5>
                                        </div>
                                        <div class="col-xl-7">
                                            <select class="small_select w-100"
                                                    name="institute_id">
                                                <option
                                                    value="">{{__('common.select_one')}}</option>
                                                @foreach(Institute::where('status',1)->get() as $institute)
                                                    <option value="{{$institute->id}}">
                                                        {{$institute->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <span class="text-danger" role="alert">{{$errors->first('institute_id')}}</span>

                                </div>
                            </div>
                        @endif
                        @if(isModuleActive('Affiliate'))
                            <div class="col-12 mt_20">
                                <div class="input-group custom_group_field">
                                    <input type="text" class="form-control ps-0"
                                           placeholder="{{__('affiliate.Referral Code')}} ({{__('frontend.Optional')}})"
                                           name="referral_code" value="{{old('referral_code')}}">
                                </div>
                                <span class="text-danger" role="alert">{{$errors->first('referral_code')}}</span>
                            </div>
                        @endif

                        <div class="col-12 mt_20">
                            <div class="remember_forgot_passs d-flex align-items-center">
                                <label class="primary_checkbox d-flex" for="checkbox">
                                    <input type="checkbox" id="checkbox" required>
                                    <span class="checkmark mr_15"></span>
                                    <p>{{__('frontend.By signing up, you agree to')}} <a target="_blank"
                                                                                         href="{{url('terms')}}">{{__('frontend.Terms of Service')}}</a> {{__('frontend.and')}}
                                        <a target="_blank"
                                           href="{{url('privacy')}}">{{__('frontend.Privacy Policy')}}</a></p>
                                </label>

                            </div>
                        </div>
                        <div class="col-12 mt_20">
                            @if(saasEnv('NOCAPTCHA_FOR_REG')=='true')
                                @if(saasEnv('NOCAPTCHA_IS_INVISIBLE')=="true")
                                    {!! NoCaptcha::display(["data-size"=>"invisible"]) !!}
                                @else
                                    {!! NoCaptcha::display() !!}
                                @endif

                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger"
                                          role="alert">{{$errors->first('g-recaptcha-response')}}</span>s
                                @endif
                            @endif
                        </div>

                        <div class="col-12 mt_20">
                            @if(saasEnv('NOCAPTCHA_FOR_REG')=='true' && saasEnv('NOCAPTCHA_IS_INVISIBLE')=="true")

                                <button type="button" class="g-recaptcha theme_btn text-center w-100 disable_btn"
                                        disabled
                                        data-sitekey="{{saasEnv('NOCAPTCHA_SITEKEY')}}" data-size="invisible"
                                        data-callback="onSubmit"
                                        class="theme_btn text-center w-100">   {{__('common.Register')}}</button>
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                <script>
                                    function onSubmit(token) {
                                        document.getElementById("regForm").submit();
                                    }
                                </script>
                            @else
                                <button type="submit" class="theme_btn text-center w-100 disable_btn" disabled
                                        id="submitBtn">
                                    {{__('common.Register')}}
                                </button>
                            @endif

                        </div>
                    </div>
                </form>
            </div>


            <h5 class="shitch_text mb-0">
                {{__('common.You have already an account?')}} <a href="{{route('login')}}"> {{__('common.Login')}}</a>

            </h5>
        </div>

        @include(theme('auth.login_wrapper_right'))

    </div>
    <script>
        $(function () {
            $('#checkbox').click(function () {

                if ($(this).is(':checked')) {
                    $('#submitBtn').removeClass('disable_btn');
                    $('#submitBtn').removeAttr('disabled');

                } else {
                    $('#submitBtn').addClass('disable_btn');
                    $('#submitBtn').attr('disabled', 'disabled');

                }
            });
        });
    </script>

@endsection
