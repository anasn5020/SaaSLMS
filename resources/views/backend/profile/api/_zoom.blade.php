<div class="row">
    <div class="col-12">
        <div class="">
            <h4 class="text-nowrap">{{__('profile.zoom_api')}}</h4>
        </div>
        <div class="custom-hr">
        </div>
    </div>
    <div class="col-lg-12">
        <form action="{{route('users.zoom.settings.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label"
                               for="zoom_account_id">{{__('zoom.Account ID')}} <strong
                                class="text-danger">*</strong></label>
                        <input class="primary_input_field" name="zoom_account_id" id="zoom_account_id"
                               type="text" value="{{old('zoom_account_id')??@$zoom_settings->zoom_account_id}}"
                               placeholder="-" {{$errors->first('name') ? 'autofocus' : ''}}>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="zoom_client_id">{{__('zoom.Client ID')}}
                            <strong
                                class="text-danger">*</strong></label>
                        <input class="primary_input_field" name="zoom_client_id"
                               value="{{old('zoom_client_id')??@$zoom_settings->zoom_client_id}}"
                               id="zoom_client_id" placeholder="-"
                               type="text" {{$errors->first('email') ? 'autofocus' : ''}}>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label"
                               for="zoom_client_secret">{{__('zoom.Client secret')}} <strong
                                class="text-danger">*</strong></label>
                        <input class="primary_input_field" name="zoom_client_secret"
                               value="{{old('zoom_client_secret')??@$zoom_settings->zoom_client_secret }}"
                               id="zoom_client_secret" placeholder="-" type="text">
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-12 text-end">
                    {{--                    <hr class="d-block">--}}
                    <button class="primary-btn fix-gr-bg" type="submit"><i
                            class="ti-check"></i> {{__('common.Save')}}</button>
                </div>
            </div>
        </form>
    </div>

</div>

