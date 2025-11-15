<div class="tab-pane active" id="basic_information_tab">
    <div class="row">
        <div class="col-12">

            <h3>{{__('profile.basic_information')}}</h3>
            <hr>

            <form action="{{route('users.basic_info.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="name">{{__('common.Name')}} <strong
                                    class="text-danger">*</strong></label>
                            <input class="primary_input_field" name="name" id="name"
                                   type="text" value="{{old('name')??@$user->name}}"
                                   placeholder="-" {{$errors->first('name') ? 'autofocus' : ''}}>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="email">{{__('common.Email')}}
                                <strong
                                    class="text-danger">*</strong></label>
                            <input class="primary_input_field" name="email" value="{{old("email")??@$user->email}}"
                                   id="email" placeholder="-"
                                   type="email" {{$errors->first('email') ? 'autofocus' : ''}}>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="phone">{{__('common.Phone')}}
                                <small>({{__('profile.With Country Code without plus')}}
                                    )</small></label>
                            <input class="primary_input_field" name="phone" value="{{old("phone")??@$user->phone }}"
                                   id="phone" placeholder="-" type="text">
                        </div>
                    </div>
                    <div class="col-md-6 mb-25">
                        <label class="primary_input_label"
                               for="currency">{{__('common.Currency')}}</label>
                        <select class="primary_select theme_select" name="currency" id="currency">
                            <option value=""> {{__('profile.select_one')}}</option>
                            @foreach ($currencies as $currency)
                                <option
                                    value="{{@$currency->id}}"
                                    @if(old('currency'))
                                        @if (old('currency')==$currency->id) selected @endif
                                    @else
                                        @if(@$user->currency_id==$currency->id) selected @endif
                                    @endif>
                                    {{@$currency->name}} ({{$currency->code}})
                                </option>
                            @endforeach

                        </select>
                    </div>


                    <div class="col-md-6 mb-25">
                        <label class="primary_input_label"
                               for="language">{{__('common.Language')}} </label>
                        <select class="primary_select theme_select" name="language" id="language">
                            <option value=""> {{__('profile.select_one')}}</option>
                            @foreach ($languages as $language)
                                <option value="{{@$language->id}}"
                                        @if(old('language'))
                                            @if(old('language')==$language->id) selected @endif
                                        @else
                                            @if(@$user->language_id==$language->id) selected @endif
                                    @endif>
                                    {{@$language->native}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-25">
                        <label class="primary_input_label"
                               for="timezone">{{__('profile.timezone')}} </label>
                        <select class="primary_select theme_select" name="timezone" id="timezone">
                            <option value=""> {{__('profile.select_one')}}</option>
                            @foreach ($timezones as $timezone)
                                <option value="{{@$timezone->id}}"
                                        @if(old('timezone'))
                                            @if(old('timezone')==$timezone->id) selected @endif
                                        @else
                                            @if(@$user->userInfo->timezone_id == $timezone->id) selected @endif
                                    @endif>
                                    {{@$timezone->code}}
                                </option>
                            @endforeach
                        </select>
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

