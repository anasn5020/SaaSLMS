<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-xl-12">
                    <!-- account_profile_wrapper  -->
                    <div class="account_profile_wrapper p-4">
                        <div class="account_profile_thumb text-center mb_30">

                            <x-student-profile-image-update :profile="$profile"/>
                            <h4>{{$profile->name}}</h4>
                            <p>{{$profile->headline}}</p>
                        </div>
                        <div class="account_profile_form">
                            <h3 class="font_22 f_w_700 mb_30">{{__('frontendmanage.My Profile')}}</h3>

                            <form action="{{route('myProfileUpdate')}}" method="POST"
                                  enctype="multipart/form-data">@csrf
                                <div class="row">
                                    <input type="hidden" name="username" value="{{$profile->email}}">
                                    <div class="col-lg-12">
                                        <label class="primary_label2">{{__('student.Full Name')}}
                                            <span class="required_mark">*</span></label>
                                        <input name="name" placeholder="{{__('frontend.Enter First Name')}}"
                                               onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = '{{__('frontend.Enter First Name')}}'"
                                               class="primary_input" {{$errors->first('name') ? 'autofocus' : ''}}
                                               {{ !$custom_field->editable_name ? 'readonly' : '' }}
                                               value="{{$profile->name !=""? @$profile->name:old('name')}}" type="text">
                                        <span class="text-danger" role="alert">{{$errors->first('name')}}</span>
                                    </div>


                                    <div class="col-lg-12 mt_20">
                                        <label class="primary_label2">{{__('student.Add a professional headline like')}}
                                            ({{__('student.Student')}})</label>
                                        <input name="headline" placeholder="{{__('student.Headline')}}"
                                               onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = '{{__('student.Headline')}}'"
                                               class="primary_input" type="text"
                                               value="{{$profile->headline !=""? @$profile->headline:old('headline')}}">
                                        <span class="text-danger" role="alert">{{$errors->first('headline')}}</span>
                                    </div>


                                    <div class="col-lg-6 col-md-6 mt_20">
                                        <div class="single_input ">
                                            <span class="primary_label2">{{__('student.Phone Number')}} </span>
                                            <input type="text" placeholder="{{__('student.Phone Number')}}"
                                                   class="primary_input  {{ @$errors->has('phone') ? ' is-invalid' : '' }}"
                                                   value="{{$profile->phone !=""? @$profile->phone:old('phone')}}"
                                                   name="phone" {{$errors->first('phone') ? 'autofocus' : ''}}>
                                            <span class="text-danger" role="alert">{{$errors->first('phone')}}</span>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 mt_20">
                                        <div class="single_input ">
                                            <span class="primary_label2">{{__('common.Email')}} <span
                                                    class=""> *</span></span>
                                            <input type="email" placeholder="{{__('common.Email')}}"
                                                   class="primary_input {{ @$errors->has('email') ? ' is-invalid' : '' }}"
                                                   value="{{$profile->email !=""? @$profile->email:old('email')}}"
                                                   name="email" {{$errors->first('email') ? 'autofocus' : ''}}>
                                            <span class="text-danger" role="alert">{{$errors->first('email')}}</span>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 mt_20">
                                        <div class="single_input ">
                                            <span class="primary_label2">{{__('common.Language')}}  <span
                                                    class=""> *</span> </span>
                                            <select class="theme_select wide mb_20"
                                                    name="language" {{$errors->first('language') ? 'autofocus' : ''}}>
                                                <option data-display="{{__('common.Language')}}"
                                                        value="#">{{__('common.Select')}} {{__('common.Language')}}</option>
                                                @if(isset($langs))
                                                    @foreach ($langs as $lang)
                                                        <option
                                                            value="{{@$lang->id}}|{{@$lang->code}}|{{@$lang->native}}|{{@$lang->rtl}}"
                                                            @if ($profile->language_code==$lang->code) selected @endif>{{@$lang->native}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger" role="alert">{{$errors->first('language')}}</span>
                                        </div>

                                    </div>


                                    @if($custom_field->show_dob)
                                        <div class="col-lg-6 col-md-6 mt_20">
                                            <div class="single_input ">
                                                <span
                                                    class="primary_label2">{{__('common.Date of Birth')}} <span>{{ $custom_field->required_dob ? '*' : ''}}</span> </span>
                                                <input type="date" placeholder="{{__('common.Date of Birth')}}"
                                                       class="primary_input  {{ @$errors->has('dob') ? ' is-invalid' : '' }}"
                                                       value="{{$profile->dob !=""? @$profile->dob:old('dob')}}"
                                                       name="dob" data-prevent-future="1"  {{$errors->first('dob') ? 'autofocus' : ''}}
                                                    {{ $custom_field->required_dob ? 'required' : ''}} {{$custom_field->editable_dob ? '' : 'readonly'}}>
                                                <span class="text-danger" role="alert">{{$errors->first('dob')}}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($custom_field->show_gender)
                                        <div class="col-lg-6 col-md-6 mt_20">
                                            <div class="single_input ">
                                                <span
                                                    class="primary_label2">{{__('common.gender')}} <span>{{ $custom_field->required_gender ? '*' : ''}}</span> </span>

                                                <select class="theme_select wide mb_20"
                                                        name="gender" {{$errors->first('gender') ? 'autofocus' : ''}}  {{$custom_field->editable_gender ? '' : 'readonly'}}>
                                                    {{$errors->first('gender') ? 'autofocus' : ''}}>
                                                    <option data-display="{{__('common.gender')}}"
                                                            value="">{{__('common.Select')}}</option>
                                                    <option value="male" @if ($profile->gender=='male') selected @endif>
                                                        Male
                                                    </option>
                                                    <option value="female"
                                                            @if ($profile->gender=='female') selected @endif>Female
                                                    </option>
                                                    <option value="other"
                                                            @if ($profile->gender=='other') selected @endif>Other
                                                    </option>
                                                </select>
                                                <span class="text-danger"
                                                      role="alert">{{$errors->first('gender')}}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($custom_field->show_company)
                                        <div class="col-lg-6 col-md-6 mt_20">
                                            <div class="single_input ">
                                                <span
                                                    class="primary_label2">{{__('common.company')}} <span>{{ $custom_field->required_company ? '*' : ''}}</span> </span>
                                                <input type="text" placeholder="{{__('common.company')}}"
                                                       class="primary_input  {{ @$errors->has('company_id') ? ' is-invalid' : '' }}"
                                                       value="{{$profile->company_id !=""? @$profile->company_id:old('company_id')}}"
                                                       name="company_id" {{$errors->first('company_id') ? 'autofocus' : ''}}
                                                    {{ $custom_field->required_company ? 'required' : ''}} {{$custom_field->editable_company ? '' : 'readonly'}}>
                                                <span class="text-danger"
                                                      role="alert">{{$errors->first('company_id')}}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($custom_field->show_student_type)
                                        <div class="col-lg-6 col-md-6 mt_20">
                                            <div class="single_input ">
                                                <span
                                                    class="primary_label2">{{__('common.student_type')}} <span>{{ $custom_field->required_student_type ? '*' : ''}}</span> </span>


                                                <select class="theme_select wide mb_20" name="student_type"
                                                        {{ $custom_field->required_student_type ? 'required' : ''}} {{$custom_field->editable_student_type ? '' : 'readonly'}}
                                                        id="student_type" {{$errors->first('student_type') ? 'autofocus' : ''}}>
                                                    <option data-display="{{__('common.student_type')}}"
                                                            value="">{{__('common.Select')}}</option>
                                                    <option value="personal"
                                                            @if ($profile->student_type=='personal') selected @endif>
                                                        Personal
                                                    </option>

                                                    <option value="corporate"
                                                            @if ($profile->student_type=='corporate') selected @endif>
                                                        Corporate
                                                    </option>
                                                </select>
                                                <span class="text-danger"
                                                      role="alert">{{$errors->first('student_type')}}</span>
                                            </div>
                                        </div>

                                    @endif

                                    @if($custom_field->show_identification_number)
                                        <div class="col-lg-6 col-md-6 mt_20">
                                            <div class="single_input ">
                                                <span
                                                    class="primary_label2">{{__('common.identification_number')}} <span>{{ $custom_field->required_identification_number ? '*' : ''}}</span> </span>
                                                <input type="text" placeholder="{{__('common.identification_number')}}"
                                                       class="primary_input  {{ @$errors->has('identification_number') ? ' is-invalid' : '' }}"
                                                       value="{{$profile->identification_number !=""? @$profile->identification_number:old('identification_number')}}"
                                                       name="identification_number" {{$errors->first('identification_number') ? 'autofocus' : ''}}
                                                    {{ $custom_field->required_identification_number ? 'required' : ''}} {{$custom_field->editable_identification_number ? '' : 'readonly'}}>
                                                <span class="text-danger"
                                                      role="alert">{{$errors->first('identification_number')}}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($custom_field->show_job_title)
                                        <div class="col-lg-6 col-md-6 mt_20">
                                            <div class="single_input ">
                                                <span
                                                    class="primary_label2">{{__('common.job_title')}} <span>{{ $custom_field->required_job_title ? '*' : ''}}</span> </span>
                                                <input type="text" placeholder="{{__('common.job_title')}}"
                                                       class="primary_input  {{ @$errors->has('job_title') ? ' is-invalid' : '' }}"
                                                       value="{{$profile->job_title !=""? @$profile->job_title:old('job_title')}}"
                                                       name="job_title" {{$errors->first('job_title') ? 'autofocus' : ''}}
                                                    {{ $custom_field->required_job_title ? 'required' : ''}} {{$custom_field->editable_job_title ? '' : 'readonly'}}>
                                                <span class="text-danger"
                                                      role="alert">{{$errors->first('job_title')}}</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-lg-6 col-md-6 mt_20">
                                        <div class="single_input ">
                                            <span class="primary_label2">{{__('common.Country')}} <span
                                                    class=""> *</span> </span>
                                            <select class="mb-3 wide w-100" name="country"
                                                    id="country" {{$errors->first('country') ? 'autofocus' : ''}}>
                                                <option data-display="{{__('common.Country')}}"
                                                        value="">{{__('common.Select')}}</option>
                                                @if(isset($countries))
                                                    @foreach ($countries as $country)
                                                        <option value="{{@$country->id}}"
                                                                @if ($profile->country==$country->id) selected @endif>{{@$country->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger" role="alert">{{$errors->first('country')}}</span>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 mt_20">
                                        <div class="single_input " id="state_div">
                                            <span class="primary_label2">{{__('common.State')}} </span>
                                            <select class="  wide mb_20 stateList" name="state"
                                                    id="state" {{$errors->first('state') ? 'autofocus' : ''}}>
                                                <option data-display="{{__('common.State')}}"
                                                        value="#">{{__('common.Select')}} {{__('common.State')}}</option>
                                                @if(isset($states))
                                                    @foreach ($states as $state)
                                                        <option value="{{$state->id}}"
                                                                @if ($profile->state==$state->id) selected @endif>{{$state->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger" role="alert">{{$errors->first('state')}}</span>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 mt_20">
                                        <div class="single_input " id="city_div">
                                            <span class="primary_label2">{{__('common.City')}}  </span>
                                            <select class="  wide mb_20 cityList" name="city"
                                                    id="city" {{$errors->first('city') ? 'autofocus' : ''}}>
                                                <option data-display="{{__('common.City')}}"
                                                        value="#">{{__('common.Select')}} {{__('common.City')}}</option>
                                                @if(isset($cities))
                                                    @foreach ($cities as $city)
                                                        <option value="{{$city->id}}"
                                                                @if ($profile->city==$city->id) selected @endif>{{$city->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger" role="alert">{{$errors->first('city')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 mt_20">
                                        <div class="single_input ">
                                            <span class="primary_label2">{{__('common.Address')}} </span>
                                            <input type="text" placeholder="{{__('common.Address')}}"
                                                   class="primary_input {{ @$errors->has('address') ? ' is-invalid' : '' }}"
                                                   value="{{$profile->address !=""? @$profile->address:old('address')}}"
                                                   name="address" {{$errors->first('address') ? 'autofocus' : ''}}>
                                            <span class="text-danger" role="alert">{{$errors->first('address')}}</span>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 mt_20">
                                        <div class="single_input ">
                                            <span class="primary_label2">{{__('common.Zip Code')}} </span>
                                            <input type="text" placeholder="{{__('common.Zip Code')}}"
                                                   class="primary_input {{ @$errors->has('zip') ? ' is-invalid' : '' }}"
                                                   value="{{$profile->zip !=""? @$profile->zip:old('zip')}}"
                                                   name="zip" {{$errors->first('zip') ? 'autofocus' : ''}}>
                                            <span class="text-danger" role="alert">{{$errors->first('zip')}}</span>
                                        </div>

                                    </div>

                                    @if (isModuleActive('TwoFA') && Settings('enable_student_two_fa'))

                                        <div class="col-lg-6 col-md-6 mt_20">
                                            <div class="single_input">
                                                <span class="primary_label2">{{ __('common.Two FA') }}  </span>
                                                <select class="select2 wide mb_20" name="two_step_verification"
                                                        id="two_step_verification">
                                                    <option value="0"
                                                            @if ($profile->two_step_verification == 0) selected @endif>
                                                        {{ __('common.N/A') }}</option>

                                                    <option value="1"
                                                            @if ($profile->two_step_verification == 1) selected @endif>
                                                        {{ __('common.Email') }}</option>

                                                    <option value="2"
                                                            @if ($profile->two_step_verification == 2) selected @endif>
                                                        {{ __('common.Google Auth') }}</option>
                                                </select>
                                                <span class="text-danger" role="alert">{{$errors->first('city')}}</span>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-6 col-md-6 mt_20 {{ $profile->two_step_verification == 1 ? '' : 'd-none' }}"
                                            id="expired_time">
                                            <div class="single_input ">
                                                        <span class="primary_label2">{{ __('setting.Two FA Expired Time') }}
                                                            <small>({{ __('setting.In Minute') }})</small></span>
                                                <input type="text" placeholder="{{ __('setting.Two FA Expired Time') }}"
                                                       class="primary_input"
                                                       name="two_fa_expired_time"
                                                       value="{{ @$profile->two_fa_expired_time }}"
                                                       id="two_fa_expired_time">
                                            </div>

                                        </div>

                                    @endif

                                    <div class="col-lg-12 mt_20 mb-3">
                                        <label class="primary_label2">{{__('common.About')}}</label>
                                        <textarea name="about" class="primary_textarea4 mb_20"
                                                  placeholder="{{__('student.Write Note here')}}"
                                                  onfocus="this.placeholder = ''"
                                                  onblur="this.placeholder = '{{__('student.Write Note here')}}'">{!! $profile->about !=""? @$profile->about:old('about') !!}</textarea>
                                    </div>

                                    <div class="col-12">
                                        <div class="preview_upload">
                                            <div class="preview_upload_thumb">
                                                <img src="" alt="" id="imgPreview"
                                                     style=" display:none;height: 100%;width: 100%;">
                                                <span id="previewTxt">{{__('student.Preview')}}</span>
                                            </div>
                                            <div class="preview_drag">
                                                <div class="preview_drag_inner">
                                                    <div class="img">
                                                        <img
                                                            src="{{asset('public/frontend/infixlmstheme')}}/img/account/gallery_icon.png"
                                                            alt="">
                                                    </div>
                                                    <p>{{__('student.Drop your file here')}}</p>
                                                    <small>{{__('student.Recommended image size')}} (330x400)</small>
                                                    <div class="chose_file">
                                                        <input type="file" name="image" id="imgInp"
                                                               onchange="readURL(this)">
                                                        {{__('student.or choose files to upload')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="font_22 f_w_700 mb_30">{{__('student.Social Links')}}</h3>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="primary_label2">{{__('student.Add your Facebook URL')}}</label>
                                        <div class="input-group custom_input_group mb_20">
                                            <div class="input-group-prepend">

                                                <span class="input-group-text"> <i class="ti-facebook"></i> <span>www.facebook.com/</span> </span>
                                            </div>
                                            <input name="facebook" type="text"
                                                   value="{{$profile->facebook !=""? @$profile->facebook:old('facebook')}}"
                                                   placeholder="{{__('student.Facebook URL')}}"
                                                   onfocus="this.placeholder = ''"
                                                   onblur="this.placeholder = '{{__('student.Facebook URL')}}'"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="primary_label2">{{__('student.Add your Twitter URL')}}</label>
                                        <div class="input-group custom_input_group mb_20">
                                            <div class="input-group-prepend">
                                                    <span class="input-group-text twitter_bg"> <i
                                                            class="ti-twitter-alt"></i> <span>www.twitter.com/</span> </span>
                                            </div>
                                            <input type="text" placeholder="{{__('student.Twitter URL')}}"
                                                   name="twitter"
                                                   onfocus="this.placeholder = ''"
                                                   onblur="this.placeholder = '{{__('student.Twitter URL')}}'"
                                                   class="form-control"
                                                   value="{{$profile->twitter !=""? @$profile->twitter:old('twitter')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="primary_label2">{{__('student.Add your LinkedIn URL')}}</label>
                                        <div class="input-group custom_input_group mb_20">
                                            <div class="input-group-prepend">
                                                    <span class="input-group-text linkedin_bg"> <i
                                                            class="ti-linkedin"></i> <span>www.linkedin.com/</span> </span>
                                            </div>
                                            <input type="text" placeholder="{{__('student.LinkedIn profile')}}"
                                                   onfocus="this.placeholder = ''"
                                                   onblur="this.placeholder = '{{__('student.LinkedIn profile')}}'"
                                                   class="form-control" name="linkedin"
                                                   value="{{$profile->linkedin !=""? @$profile->linkedin:old('linkedin')}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="primary_label2">{{__('student.Add your Youtube URL')}}</label>
                                        <div class="input-group custom_input_group mb_20">
                                            <div class="input-group-prepend">
                                                    <span class="input-group-text youtube_bg"> <i
                                                            class="ti-youtube"></i> <span>www.youtube.com/</span> </span>
                                            </div>
                                            <input type="text" placeholder="{{__('student.Youtube Profile')}}"
                                                   onfocus="this.placeholder = ''"
                                                   onblur="this.placeholder = '{{__('student.Youtube Profile')}}'"
                                                   class="form-control"
                                                   value="{{$profile->youtube !=""? @$profile->youtube:old('youtube')}}"
                                                   name="youtube">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button
                                            class="theme_btn w-100 text-center mt_40">{{__('student.Save')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
