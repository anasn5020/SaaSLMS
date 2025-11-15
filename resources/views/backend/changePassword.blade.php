@extends('backend.master')
@push('styles')
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            width: 100%;
            height: 46px;
            line-height: 46px;
            font-size: 13px;
            padding: 3px 20px;
            padding-left: 20px;
            font-weight: 300;
            border-radius: 30px;
            color: var(--base_color);
            border: 1px solid var(--backend-border-color);
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            position: absolute;
            top: 1px;
            right: 20px;
            width: 20px;
            color: var(--text-color);
        }

        .select2-dropdown {
            background-color: white;
            border: 1px solid var(--backend-border-color);
            border-radius: 4px;
            box-sizing: border-box;
            display: block;
            position: absolute;
            left: -100000px;
            width: 100%;
            width: 100%;
            background: var(--bg_white);
            overflow: auto !important;
            border-radius: 0px 0px 10px 10px;
            margin-top: 1px;
            z-index: 9999 !important;
            border: 0;
            box-shadow: 0px 10px 20px rgb(108 39 255 / 30%);
            z-index: 1051;
            min-width: 200px;
        }

        .select2-search--dropdown .select2-search__field {
            padding: 4px;
            width: 100%;
            box-sizing: border-box;
            box-sizing: border-box;
            background-color: #fff;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
            border-radius: 3px;
            box-shadow: none;
            color: #333;
            display: inline-block;
            vertical-align: middle;
            padding: 0px 8px;
            width: 100% !important;
            height: 46px;
            line-height: 46px;
            outline: 0 !important;
        }

        .select2-container {
            width: 100% !important;
            min-width: 90px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 40px;
        }
    </style>
@endpush
@section('mainContent')
    @include("backend.partials.alertMessage")

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{__('common.My Profile')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="common_grid_wrapper">
                        <!-- white_box -->
                        <div class="white-box">
                            <div class="main-title mb-25">
                                <h3 class="mb-0">{{__('common.Profile Settings')}}</h3>
                            </div>
                            <form action="{{route('update_user')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="name">{{__('common.Name')}} <strong
                                                    class="text-danger">*</strong></label>
                                            <input class="primary_input_field" name="name" value="{{@$user->name}}"
                                                   id="name" placeholder="" required
                                                   type="text" {{$errors->first('name') ? 'autofocus' : ''}}>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="role">{{__('common.Role')}} </label>
                                            <input class="primary_input_field" name="" readonly
                                                   id="role" value="{{@$user->role->name}}" placeholder="-" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="email">{{__('common.Email')}}
                                                <strong
                                                    class="text-danger">*</strong></label>
                                            <input class="primary_input_field" name="email" value="{{@$user->email}}"
                                                   id="email" placeholder="-"
                                                   type="email" {{$errors->first('email') ? 'autofocus' : ''}}>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="phone">{{__('common.Phone')}} </label>
                                            <input class="primary_input_field" name="phone" value="{{@$user->phone }}"
                                                   id="phone" placeholder="-" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-25">
                                        <label class="primary_input_label"
                                               for="country">{{__('common.Country')}} </label>
                                        <select class="primary_select" name="country" id="country">
                                            @foreach ($countries as $country)
                                                <option value="{{@$country->id}}"
                                                        @if (@$user->country==$country->id) selected @endif>{{@$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-25">
                                        <label class="primary_input_label"
                                               for="state">{{__('common.State')}} </label>
                                        <select class="select2  stateList" name="state" id="state">
                                            <option
                                                data-display=" {{__('common.Select')}} {{__('common.State')}}"
                                                value="">{{__('common.Select')}} {{__('common.State')}}
                                            </option>
                                            @foreach ($states as $state)
                                                <option value="{{@$state->id}}"
                                                        @if (@$user->state==$state->id) selected @endif>{{@$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <label class="primary_input_label"
                                               for="city">{{__('common.City')}} </label>
                                        <select class="select2  cityList" name="city" id="city">
                                            <option
                                                data-display=" {{__('common.Select')}} {{__('common.City')}}"
                                                value="">{{__('common.Select')}} {{__('common.City')}}
                                            </option>
                                            @foreach ($cities as $city)
                                                <option value="{{@$city->id}}"
                                                        @if (@$user->city==$city->id) selected @endif>{{@$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="zip">{{__('common.Zip Code')}} </label>
                                            <input class="primary_input_field" name="zip" value="{{@$user->zip }}"
                                                   id="zip" placeholder="-" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-25">
                                        <label class="primary_input_label"
                                               for="currency">{{__('common.Currency')}}</label>
                                        <select class="primary_select" name="currency" id="currency">
                                            <option data-display="{{__('common.Select')}} Currency"
                                                    value="">{{__('common.Select')}} Currency
                                            </option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{@$currency->id}}"
                                                        @if (@$user->currency_id==$currency->id) selected @endif>{{@$currency->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-25">
                                        <label class="primary_input_label"
                                               for="language">{{__('common.Language')}} </label>
                                        <select class="primary_select" name="language" id="language">
                                            <option data-display="{{__('common.Select')}} Language"
                                                    value="">{{__('common.Select')}}
                                                {{__('passwords.Language')}}</option>
                                            @foreach ($languages as $language)
                                                <option value="{{@$language->id}}"
                                                        @if (@$user->language_id==$language->id) selected @endif>{{@$language->native}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="facebook">{{__('common.Facebook URL')}} </label>
                                            <input class="primary_input_field" name="facebook" id="facebook"
                                                   value="{{@$user->facebook}}" placeholder="-" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="twitter">{{__('common.Twitter URL')}} </label>
                                            <input class="primary_input_field" name="twitter" id="twitter"
                                                   value="{{@$user->twitter}}" placeholder="-" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="linkedin">{{__('common.LinkedIn URL')}} </label>
                                            <input class="primary_input_field" name="linkedin" id="linkedin"
                                                   value="{{@$user->linkedin}}" placeholder="-" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="instagram">{{__('common.Instagram URL')}} </label>
                                            <input class="primary_input_field" name="instagram" id="instagram"
                                                   value="{{@$user->instagram}}" placeholder="-" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="shortDetails">{{__('common.Short Description')}} </label>
                                            <input class="primary_input_field" name="short_details"
                                                   id="shortDetails" value="{{@$user->short_details}}" placeholder="-"
                                                   type="text">
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="about">{{__('common.Description')}} </label>
                                            <textarea class="lms_summernote" name="about"

                                                      id="about" cols="30"
                                                      rows="10">{!!@$user->about!!}</textarea>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="primary_input mb-35">
                                            <label class="primary_input_label"
                                                   for="">{{__('common.Browse')}}  {{__('common.Avatar')}} </label>
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="placeholderFileOneName"
                                                       placeholder="{{showPicName($user->image)}}" readonly="">
                                                <button class="primary-btn small fix-gr-bg" type="button">
                                                    <label class="primary-btn small fix-gr-bg"

                                                           for="document_file_1">{{__('common.Browse')}} </label>
                                                    <input type="file" class="d-none" name="image" id="document_file_1">
                                                </button>
                                            </div>
                                        </div>


                                    </div>

                                    @auth()
                                        @if(\Illuminate\Support\Facades\Auth::user()->role_id==1)
                                            <div class="col-12">
                                                <div class="col-md-12 mb-25">
                                                    <label class="primary_input_label"
                                                           for="subscription_method">{{__('common.Subscription Method')}} </label>
                                                    <select class="primary_select" name="subscription_method">
                                                        <option value="">{{__('common.None')}}</option>
                                                        <option
                                                            value="Mailchimp"
                                                            @if($user->subscription_method=="Mailchimp") selected @endif>{{__('newsletter.Mailchimp')}}</option>

                                                        <option
                                                            value="GetResponse"
                                                            @if($user->subscription_method=="GetResponse") selected @endif >{{__('newsletter.GetResponse')}}</option>

                                                    </select>
                                                </div>
                                                <div class="col-md-12 mb-25" style="    margin-top: 70px;">

                                                    <label class="primary_input_label"
                                                           for="subscription_api_key">{{__('common.Subscription Api Key')}}
                                                        <small>({{$user->subscription_api_status==1?'Connected':'Not Connected'}}
                                                            )</small> </label>
                                                    <input class="primary_input_field" name="subscription_api_key"
                                                           value="{{@$user->subscription_api_key }}"
                                                           id="subscription_api_key" placeholder="-" type="text">

                                                </div>

                                                <div class="col-md-12">

                                                </div>
                                            </div>
                                        @endif

                                        @if (isModuleActive('TwoFA') && Settings('enable_two_fa'))

                                            <div class="col-12">
                                                <div class="col-md-12 mb-25">
                                                    <label class="primary_input_label"
                                                           for="two_step_verification">{{ __('common.Two FA') }} </label>
                                                    <select class="primary_select" name="two_step_verification"
                                                            id="two_step_verification">
                                                        <option value="0"
                                                                @if ($user->two_step_verification == 0) selected @endif>
                                                            {{ __('common.N/A') }}</option>

                                                        <option value="1"
                                                                @if ($user->two_step_verification == 1) selected @endif>
                                                            {{ __('common.Email') }}</option>

                                                        <option value="2"
                                                                @if ($user->two_step_verification == 2) selected @endif>
                                                            {{ __('common.Google Auth') }}</option>

                                                    </select>
                                                </div>
                                                <div id="expired_time"
                                                     class="col-md-12 mb-25 {{ $user->two_step_verification == 1 ? '' : 'd-none' }}"
                                                     style="    margin-top: 70px;">

                                                    <label class="primary_input_label"
                                                           for="two_fa_expired_time">{{ __('setting.Two FA Expired Time') }}
                                                        <small>({{ __('setting.In Minute') }})</small>

                                                    </label>
                                                    <input class="primary_input_field" name="two_fa_expired_time"
                                                           value="{{ @$user->two_fa_expired_time }}"
                                                           id="two_fa_expired_time"
                                                           placeholder="-" type="text">

                                                </div>
                                            </div>
                                        @endif
                                    @endauth

                                    <div class="col-12 mb-10">
                                        <div class="submit_btn text-center">
                                            <button class="primary-btn fix-gr-bg" type="submit"><i
                                                    class="ti-check"></i> {{__('common.Save')}} </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- white_box  -->
                        <div class="white-box">
                            <div class="main-title mb-25">
                                <h3 class="mb-0">{{__('common.Change')}}  {{__('common.Password')}} </h3>
                            </div>
                            <form action="{{route('updatePassword')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="password-field">{{__('common.Current')}} {{__('common.Password')}}
                                                <strong
                                                    class="text-danger">*</strong></label>
                                            <div>

                                                <input class="primary_input_field" name="current_password"
                                                       {{$errors->first('current_password') ? 'autofocus' : ''}}
                                                       placeholder="{{__('common.Current')}} {{__('common.Password')}}"
                                                       id="password-field"
                                                       type="password">
                                                <span toggle="#password-field"
                                                      class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="password-field2">{{__('common.New')}}  {{__('common.Password')}}
                                                <strong
                                                    class="text-danger">*</strong>
                                                <small>({{__('common.Minimum 8 characters')}})</small>
                                            </label>
                                            <input class="primary_input_field" name="new_password"
                                                   placeholder="{{__('common.New')}}  {{__('common.Password')}} "
                                                   id="password-field2"
                                                   type="password" {{$errors->first('new_password') ? 'autofocus' : ''}}>
                                            <span toggle="#password-field2"
                                                  class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="password-field3">{{__('common.Re-Type Password')}}
                                                <strong class="text-danger">*</strong></label>
                                            <input class="primary_input_field" name="confirm_password"
                                                   {{$errors->first('confirm_password') ? 'autofocus' : ''}}
                                                   id="password-field3" placeholder="{{__('common.Re-Type Password')}}"
                                                   type="password">
                                            <span toggle="#password-field3"
                                                  class="fa fa-fw fa-eye field-icon toggle-password3"></span>
                                        </div>
                                    </div>


                                    <div class="col-12 mb-10">
                                        <div class="submit_btn text-center">
                                            <button class="primary-btn fix-gr-bg" type="submit"><i
                                                    class="ti-check"></i> {{__('common.Update')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>



    @include('backend.partials.delete_modal')
@endsection

@push('scripts')

    <script>
        $('.cityList').select2({
            ajax: {
                url: '{{route('ajaxCounterCity')}}',
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1,
                        id: $('#state').find(':selected').val(),
                    }
                    return query;
                },
                cache: false
            }
        });

        $('.stateList').select2({
            ajax: {
                url: '{{route('ajaxCounterState')}}',
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1,
                        id: $('#country').find(':selected').val(),
                    }
                    return query;
                },
                cache: false
            }
        });
    </script>

@endpush
