

<div class="tab-pane fade" id="delete_account_tab">
    <div class="row">
        <div class="col-12">

            <h3>{{__('profile.delete_account')}}</h3>
            <hr>

            <div class="row">
                <div class="col-6">
                    <img class="profile_delete_photo"
                         src="{{asset('public/frontend/infixlmstheme/img/account/delete_account.png')}}" alt="photo">
                </div>
                <div class="col-6" style="padding-top:10% ; ">
                    <div class="account_title">
                        <h3 class="font_22 f_w_700 ">{{__('profile.delete_account_request')}}</h3>
                        <p class="mb_25 font_1 f_w_500 theme_text2">{{__('student.If you delete your account, your data will be gone forever')}}
                        </p>
                    </div>
                    <form action="{{route('users.account.delete')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="email">{{__('common.Email')}}</label>
                                    <input readonly class="primary_input_field" name="email" value="{{@$user->email}}"
                                           id="email" placeholder="-"
                                           type="email" {{$errors->first('email') ? 'autofocus' : ''}}>
                                </div>
                            </div>
                        </div>

                        <div class="row">


                            <div class="col-md-8">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="password-field11111">{{__('frontend.Existing Password')}}
                                        <strong class="text-danger">*</strong></label>
                                    <div>

                                        <input class="primary_input_field" name="old_password"
                                               {{$errors->first('current_password') ? 'autofocus' : ''}}
                                               placeholder="{{__('frontend.Existing Password')}}"
                                               id="password-field11111"
                                               type="password">
                                        <span toggle="#password-field11111" class="fa fa-fw fa-eye field-icon toggle-password4"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 ">
                                <button class="primary-btn fix-gr-bg" type="submit">{{__('student.Delete account')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
