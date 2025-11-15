{{--<div class="col-lg-12 text-end d-flex gap-10 justify-content-end flex-wrap mb-3">--}}
{{--    @if(auth()->user()->role_id==1)--}}
{{--        <a class="primary-btn radius_30px   fix-gr-bg"--}}
{{--           href="{{ url('public/backend/img/google_drive.pdf') }}"--}}
{{--           download="google_drive.pdf"><i--}}
{{--                class="ti-file"></i>{{__('setting.Documentation')}}</a>--}}
{{--    @endif--}}
{{--    @if (auth()->user()->googleToken)--}}
{{--        <div class="dropdown CRM_dropdown ml-10">--}}
{{--            <button class="btn btn-secondary dropdown-toggle" type="button"--}}
{{--                    data-bs-toggle="dropdown"--}}
{{--                    aria-haspopup="true"--}}
{{--                    aria-expanded="false">--}}
{{--                {{ auth()->user()->googleToken->google_email }}--}}
{{--            </button>--}}
{{--            <div class="dropdown-menu dropdown-menu-right"--}}
{{--                 aria-labelledby="dropdownMenu2">--}}
{{--                <a href="{{ route('setting.google.login') }}"--}}
{{--                   class="dropdown-item">{{__('setting.Switch Account')}}</a>--}}
{{--                <a href="{{ route('setting.google.logout') }}"--}}
{{--                   class="dropdown-item">{{__('common.Logout')}}</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @else--}}
{{--        <a href="{{ route('setting.google.login') }}"--}}
{{--           class="primary-btn radius_30px   fix-gr-bg"><i--}}
{{--                class="ti-google"></i> {{ trans('common.Login') }}--}}
{{--        </a>--}}
{{--    @endif--}}
{{--</div>--}}
<input type="hidden" name="google" value="1">
<div class="col-xl-12">
    <div class="primary_input mb-25">
        <label class="primary_input_label"
               for="">{{__('setting.Client ID')}}
            *</label>
        <input class="primary_input_field" placeholder="-" type="text"
               name="gdrive_client_id"
               value="{{ config('filesystems.disks.google.clientId') }}">
    </div>
</div>

<div class="col-xl-12">
    <div class="primary_input mb-25">
        <label class="primary_input_label"
               for="">{{__("setting.Client Secret")}}
            *</label>
        <input class="primary_input_field" placeholder="-" type="text"
               name="gdrive_client_secret"
               value="{{ config('filesystems.disks.google.clientSecret') }}">
    </div>
</div>


<div class="col-lg-12">
    <span>{{__('setting.Callback URL')}}: </span>
    <code>
        {{route('setting.google.callback')}}
    </code>
</div>
