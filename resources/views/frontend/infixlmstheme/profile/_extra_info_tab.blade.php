<div class="tab-pane fade" id="extra_info_tab">
    <div class="account_profile_form row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center">
                <h3>{{__('profile.extra_information')}}</h3>
            </div>
            <hr>
            <form action="{{route('users.extra_info.update')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-6 col-md-6 mt_20">
                        <div class="single_input">
                            <span class="primary_label2">{{__('common.gender')}} </span>
                            <select class="theme_select wide mb_20 rounded-pill"
                                    name="gender" {{$errors->first('gender') ? 'autofocus' : ''}}>
                                <option data-display="{{__('common.Select')}} {{__('common.gender')}}"
                                        value="">{{__('common.Select')}} {{__('common.gender')}} </option>
                                <option {{@$user->gender == 'male' ?'selected':''}} value="male">Male</option>
                                <option {{@$user->gender == 'female' ?'selected':''}} value="female">Female</option>
                                <option {{@$user->gender == 'other' ?'selected':''}} value="other">Other</option>
                            </select>
                            <span class="text-danger" role="alert">{{$errors->first('gender')}}</span>
                        </div>
                    </div>
                    <div class="col-lg-6 mt_20">
                        <label class="primary_label2" for="dob">{{__('common.Date of Birth')}}</label>
                        <input id="dob" name="dob" data-prevent-future="1"  placeholder="{{__('common.Date of Birth')}}"
                               class="primary_input datepicker"
                               value="{{old('dob')??@$user->dob?date('m/d/Y',strtotime(@$user->dob)):''}}" type="text"
                               autocomplete="off" {{$errors->first('dob') ? 'autofocus' : ''}}>
                        <span class="text-danger" id="error_end_date"></span>
                    </div>

                </div>

                <div class="row mt_20">
                    <div class="col-md-12 d-flex align-items-center">
                        <h4 class="mb-0">{{__('profile.region')}}</h4>
                        <div class="custom-hr ms-2 mt-1"></div>


                    </div>
                    <div class="col-md-6 mt_20">
                        <div class="single_input ">
                            <span class="primary_label2">{{__('common.Country')}} </span>
                            <select id="country" class="theme_select rounded-pill wide mb_20"
                                    name="country" {{$errors->first('country') ? 'autofocus' : ''}}>
                                @foreach ($countries as $country)
                                    <option value="{{@$country->id}}"
                                            @if (@$user->country==$country->id) selected @endif>{{@$country->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" role="alert">{{$errors->first('country')}}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mt_20">
                        <div class="single_input " id="state_div">
                            <span class="primary_label2">{{__('common.State')}} </span>
                            <select class="wide rounded-pill mb_20 stateList" name="state"
                                    id="state" {{$errors->first('state') ? 'autofocus' : ''}}>
                                <option data-display="{{__('common.State')}}"
                                        value="#">{{__('common.Select')}} {{__('common.State')}}</option>
                                @foreach ($states as $state)
                                    <option value="{{@$state->id}}"
                                            @if (@$user->state==$state->id) selected @endif>{{@$state->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" role="alert">{{$errors->first('state')}}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mt_20">
                        <div class="single_input " id="city_div">
                            <span class="primary_label2">{{__('common.City')}}  </span>
                            <select class="rounded-pill wide mb_20 cityList" name="city"
                                    id="city" {{$errors->first('city') ? 'autofocus' : ''}}>
                                <option data-display="{{__('common.City')}}"
                                        value="#">{{__('common.Select')}} {{__('common.City')}}</option>
                                @foreach ($cities as $city)
                                    <option value="{{@$city->id}}"
                                            @if (@$user->city==$city->id) selected @endif>{{@$city->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" role="alert">{{$errors->first('city')}}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mt_20">
                        <label class="primary_label2" for="zip">{{__('common.Zip Code')}}
                        </label>
                        <input id="zip" name="zip" placeholder="{{__('common.Zip Code')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('common.Zip Code')}}'"
                               class="primary_input rounded-pill" {{$errors->first('zip') ? 'autofocus' : ''}}
                               value="{{old('zip')??@$user->zip}}" type="text">
                        <span class="text-danger" role="alert">{{$errors->first('zip')}}</span>
                    </div>
                    <div class="col-md-6 mt_20">
                        <label class="primary_label2" for="address">{{__('common.Address')}}
                        </label>
                        <input id="address" name="address" placeholder="{{__('common.Address')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('common.Address')}}'"
                               class="primary_input rounded-pill" {{$errors->first('address') ? 'autofocus' : ''}}
                               value="{{old('address')??@$user->address}}" type="text">
                        <span class="text-danger" role="alert">{{$errors->first('address')}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <hr class="d-block">
                        <button class="theme_btn small_btn text-center" type="submit"><i
                                class="ti-check"></i> {{__('common.Save')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
