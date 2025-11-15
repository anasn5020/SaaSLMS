<div class="tab-pane fade" id="change_password_tab">
    <div class="row">
        <div class="col-12">

            <h3>{{__('profile.change_password')}}</h3>
            <hr>
            <form action="{{route('updatePassword')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
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
                </div>
                <div class="row">
                    <div class="col-md-6">
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

                    <div class="col-md-6">
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
