<div class="tab-pane fade" id="extra_info_tab">
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center">
                <h3>{{__('profile.extra_information')}}</h3>
            </div>
            <hr>
            <form action="{{route('users.extra_info.update')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-xl-6 mb-25">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="gender">{{__('common.gender')}}</label>
                            <select class="primary_select" name="gender" id="gender">
                                <option data-display="{{__('common.Select')}} {{__('common.gender')}}"
                                        value="">{{__('common.Select')}} {{__('common.gender')}} </option>
                                <option {{@$user->gender == 'male' ?'selected':''}} value="male">Male</option>
                                <option {{@$user->gender == 'female' ?'selected':''}} value="female">Female</option>
                                <option {{@$user->gender == 'other' ?'selected':''}} value="other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for="">{{__('common.Date of Birth')}}
                            </label>
                            <div class="primary_datepicker_input">
                                <div class="g-0  input-right-icon">
                                    <div class="col">
                                        <div class="">
                                            <input placeholder="{{__('common.Date')}}"
                                                   class="primary_input_field primary-input date form-control"
                                                   id="startDate" type="text" name="dob" data-prevent-future="1"
                                                   value="{{@$user->dob?date('m/d/Y',strtotime(@$user->dob)):''}} "
                                                   autocomplete="off" {{$errors->first('dob') ? 'autofocus' : ''}}>
                                        </div>
                                    </div>
                                    <button class="" type="button">
                                        <i class="ti-calendar" id="start-date-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>{{__('profile.region')}}</h4>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-25">
                        <label class="primary_input_label"
                               for="country">{{__('common.Country')}} </label>
                        <select class="primary_select" name="country" id="country">
                            @foreach ($countries as $country)
                                <option value="{{@$country->id}}"
                                        @if (@$user->country==$country->id) selected @endif>{{@$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-25">
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
                </div>
                <div class="row">
                    <div class="col-md-6 mb-25">
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
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="zip">{{__('common.Zip Code')}} </label>
                            <input class="primary_input_field" name="zip" value="{{@$user->zip }}"
                                   id="zip" placeholder="-" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="zip">{{__('common.Address')}} </label>
                            <input class="primary_input_field" name="address" value="{{@$user->address }}"
                                   id="address" placeholder="-" type="text">
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-12 text-end">
                        <hr class="d-block">
                        <button class="primary-btn fix-gr-bg" type="submit"><i
                                class="ti-check"></i> {{__('common.Save')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
