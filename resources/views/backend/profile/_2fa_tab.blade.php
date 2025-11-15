<div class="tab-pane fade" id="fa_tab">
    <div class="row">
        <div class="col-12">

            <h3>{{__('profile.2FA')}}</h3>
            <hr>
            <form action="{{route('users.2Fa.update')}}" method="POST">
                @csrf

                <div class="row">
                    @if (isModuleActive('TwoFA'))

                        <div class="col-lg-6 col-md-6 mt_20">
                            <div class="single_input">
                                <span class="primary_label2">{{ __('common.Two FA') }}  </span>
                                <select class="primary_select theme_select" name="two_step_verification"
                                        id="two_step_verification">
                                    @if(!Settings('force_two_fa'))
                                        <option value="0"
                                                @if ($user->two_step_verification == 0) selected @endif>
                                            {{ __('common.None') }}</option>
                                    @endif
                                    <option value="1"
                                            @if ($user->two_step_verification == 1) selected @endif>
                                        {{ __('common.Email') }}</option>

                                    <option value="2"
                                            @if ($user->two_step_verification == 2) selected @endif>
                                        {{ __('common.Google Auth') }}</option>
                                    @if($sms)
                                        <option value="3"
                                                @if ($user->two_step_verification ==3) selected @endif>
                                            {{ __('setting.SMS') }}</option>
                                    @endif
                                    <option value="4"
                                            @if ($user->two_step_verification == 4) selected @endif>
                                        {{ __('setting.Push Notification') }}</option>
                                </select>
                                <span class="text-danger" role="alert">{{$errors->first('city')}}</span>
                            </div>
                        </div>



                        <div
                            class="col-lg-6 col-md-6 mt_20 {{ ($user->two_step_verification == 1 || $user->two_step_verification == 3 )? '' : 'd-none' }}"
                            id="expired_time">

                            <label class="primary_input_label"
                                   for="password-field2">{{ __('setting.Two FA Expired Time') }}
                                <small>({{ __('setting.In Minute') }})</small>
                            </label>

                            <input type="text" placeholder="{{ __('setting.Two FA Expired Time') }}"
                                   class="primary_input_field"
                                   name="two_fa_expired_time"
                                   value="{{ @$user->two_fa_expired_time }}"
                                   id="two_fa_expired_time">


                        </div>

                        <div
                            class="col-lg-6 col-md-6 mt_20 {{ $user->two_step_verification == 2 ? '' : 'd-none' }}"
                            id="googleQr">

                            <label class="primary_input_label"
                                   for="password-field2">{{ __('setting.Two FA Expired Time') }}
                            </label>

                            @php
                                $google2fa = app('pragmarx.google2fa');
                                $user =auth()->user();
                                if(empty($user ->google2fa_secret)){
                                    $registration_data['google2fa_secret'] = $google2fa->generateSecretKey();
                                    \App\User::where('email', Auth::user()->email)->update(['google2fa_secret' => $registration_data['google2fa_secret']]);
                                }else{
                                    $registration_data['google2fa_secret'] =$user ->google2fa_secret;
                                }

                                $QR_Image = $google2fa->getQRCodeInline(Settings('site_title'), $user->email, $registration_data['google2fa_secret']);
                            @endphp

                            <p>{{__('setting.Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code')}}
                                <strong>{{ $registration_data['google2fa_secret'] }}</strong></p>
                            {{--                            <p>--}}
                            {{--                                <a href="{{route('2fa.regenerate')}}">{{__('frontend.Regenerate')}}</a>--}}
                            {{--                            </p>--}}
                            <div>
                                {!! $QR_Image !!}
                            </div>


                            {{--                            <label class="primary_input_label"--}}
                            {{--                                   for="password-field2">{{ __('frontend.One Time Verification Code') }} <span--}}
                            {{--                                    class="required_mark">*</span>--}}
                            {{--                            </label>--}}

                            {{--                            <input type="text" placeholder="{{ __('frontend.One Time Verification Code') }}"--}}
                            {{--                                   class="primary_input_field"--}}
                            {{--                                   name="one_time_password"--}}
                            {{--                                   value=""--}}
                            {{--                                   id="one_time_password">--}}

                        </div>

                    @endif
                </div>


                <div class="row">

                    <div class="col-12 text-end">
                        <hr>
                        <button class="primary-btn fix-gr-bg" type="submit"><i
                                class="ti-check"></i> {{__('common.Save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).on('change', '#two_step_verification', function () {
            let type = $(this).find(":selected").val();
            let expireTypeDiv = $('#expired_time');
            let googleQr = $('#googleQr');
            if (type == 1 || type == 3) {
                expireTypeDiv.removeClass('d-none');
                googleQr.addClass('d-none');
            } else if (type == 2) {
                expireTypeDiv.addClass('d-none');
                googleQr.removeClass('d-none');
            } else {
                googleQr.addClass('d-none');
                expireTypeDiv.addClass('d-none');

            }
        });
    </script>
</div>
