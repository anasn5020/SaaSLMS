<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-xl-12">
                    <!-- account_profile_wrapper  -->
                    <div class="account_profile_wrapper p-4">
                        <div class="account_profile_thumb text-center mb_30">
                            <div class="thumb mb-15">
                                <img class="w-100 h-100" src="{{getProfileImage($account->image,$account->name)}}"
                                     alt="">
                            </div>

                            <h4>{{$account->name}}</h4>
                            <p>{{$account->headline}}</p>
                        </div>
                        <div class="account_profile_form">
                            <div class="account_title">
                                <h3 class="font_22 f_w_700 ">{{__('student.Account Settings')}}</h3>
                                <p class="mb_25 font_1 f_w_500 theme_text2">{{__('student.Edit your account settings and change your password here')}}
                                    .</p>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="primary_label2">{{__('student.Email Address')}}</label>
                                    <div class="">
                                        <input name="email" placeholder="{{__('student.Email Address')}}"
                                               value="{{$account->email}}"
                                               onfocus="this.placeholder = ''"
                                               readonly
                                               onblur="this.placeholder = '{{__('student.Email Address')}}'"
                                               class="primary_input" type="email">

                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class=" mb_30 ">
                                    </div>
                                </div>
                            </div>
                            <form action="{{route('MyUpdatePassword')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                                            <span class="primary_label2">{{__('frontend.Existing Password')}} <span
                                                                    class="text-danger">*</span></span>
                                        <input type="password" placeholder="{{__('student.Type existing password')}}"
                                               class="primary_input  {{ @$errors->has('existing_password') ? ' is-invalid' : '' }}"
                                               name="old_password" {{$errors->has('old_password') ? 'autofocus' : ''}}>


                                    </div>
                                    <div class="col-lg-12 mt_20">
                                                   <span
                                                       class="primary_label2">{{__('common.New')}} {{__('common.Password')}} <span
                                                           class="text-danger">*</span></span>
                                        <input type="password" placeholder="{{__('student.Type new password')}}"
                                               class="primary_input  {{ @$errors->has('new_password') ? ' is-invalid' : '' }}"
                                               name="new_password" {{$errors->has('new_password') ? 'autofocus' : ''}}>
                                    </div>


                                    <div class="col-lg-12 mt_20">


                                            <span class="primary_label2">{{__('frontend.Re-Type Password')}} <span
                                                    class="text-danger">*</span></span>
                                        <input type="password" placeholder="{{__('student.Re-type new password')}}"
                                               class="primary_input  {{ @$errors->has('confirm_password') ? ' is-invalid' : '' }}"
                                               name="confirm_password" {{$errors->has('confirm_password') ? 'autofocus' : ''}}>
                                    </div>


                                    <div class="col-12">

                                    </div>
                                    <div class="col-12">
                                        <button type="submit"
                                                class="theme_btn w-100 mt-3 text-center">{{__('frontend.Change Password')}}</button>
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
