<div class="tab-pane fade" id="change_password_tab">
    <div class="row">
        <div class="col-12">

            <h3>{{__('profile.change_password')}}</h3>
            <hr>
            <form action="{{route('updatePassword')}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <label class="primary_label2"
                               for="current_password">{{__('common.Current')}} {{__('common.Password')}}
                            <span class="required_mark">*</span></label>
                        <input id="current_password" name="current_password"
                               placeholder="{{__('common.Current')}} {{__('common.Password')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('common.Current')}} {{__('common.Password')}}'"
                               class="primary_input" {{$errors->first('current_password') ? 'autofocus' : ''}}
                               type="password">
                        <span class="text-danger" role="alert">{{$errors->first('current_password')}}</span>
                    </div>
                </div>

                <div class="row mt_20">
                    <div class="col-lg-6">
                        <label class="primary_label2" for="new_password">{{__('common.New')}}  {{__('common.Password')}}
                            <span class="required_mark">*</span></label>
                        <input id="new_password" name="new_password"
                               placeholder="{{__('common.New')}}  {{__('common.Password')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('common.New')}}  {{__('common.Password')}}'"
                               class="primary_input" {{$errors->first('new_password') ? 'autofocus' : ''}}
                               type="password">
                        <span class="text-danger" role="alert">{{$errors->first('new_password')}}</span>
                    </div>
                </div>

                <div class="row mt_20">
                    <div class="col-lg-6">
                        <label class="primary_label2" for="confirm_password">{{__('common.Re-Type Password')}}
                            <span class="required_mark">*</span></label>
                        <input id="confirm_password" name="confirm_password"
                               placeholder="{{__('common.Re-Type Password')}}"
                               onfocus="this.placeholder = ''"
                               onblur="this.placeholder = '{{__('common.Re-Type Password')}}'"
                               class="primary_input" {{$errors->first('confirm_password') ? 'autofocus' : ''}}
                               type="password">
                        <span class="text-danger" role="alert">{{$errors->first('confirm_password')}}</span>
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
