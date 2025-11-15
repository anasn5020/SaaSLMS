<div role="tabpanel" class="tab-pane fade "
     id="googleMap">
    @if (permissionCheck('api.setting'))
        <form class="form-horizontal" action="{{route('save.api.setting')}}"
              method="POST" enctype="multipart/form-data">
            @endif
            @csrf
            <div>
                <div class="col-md-12 ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-12 mb-30">
                                    <div class="input-effect">
                                        <label class="pb-2">{{__('setting.Google Map API Key')}} </label>
                                        <input class="primary_input_field form-control "
                                               type="text" name="gmap_key"
                                               autocomplete="off"
                                               value="{{Settings('gmap_key')}}">

                                        <span
                                            class="text-danger">{{$errors->first('gmap_key')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-30">
                                    <div class="input-effect">
                                        <label class="pb-2">{{__('setting.Zoom Level')}}
                                        </label>
                                        <input class="primary_input_field form-control"
                                               type="number" name="zoom_level"
                                               id="zoom_level" autocomplete="off"
                                               value="{{Settings('zoom_level')}}">

                                        <span class="focus-border"></span>
                                        <span
                                            class="text-danger">{{$errors->first('zoom_level')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-30">
                                    <div class="input-effect">
                                        <label class="pb-2">{{__('setting.Latitude')}}
                                        </label>
                                        <input class="primary_input_field form-control "
                                               type="text" name="lat"
                                               autocomplete="off"
                                               value="{{Settings('lat')}}">

                                        <span class="focus-border"></span>
                                        <span
                                            class="text-danger">{{$errors->first('lat')}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-30">
                                    <div class="input-effect">
                                        <label class="pb-2">{{__('setting.Longitude')}}
                                        </label>
                                        <input class="primary_input_field form-control"
                                               type="text" name="lng"
                                               id="lng" autocomplete="off"
                                               value="{{Settings('lng')}}">

                                        <span class="focus-border"></span>
                                        <span
                                            class="text-danger">{{$errors->first('lng')}}</span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <code><a target="_blank" title="Google map api key"
                                             href="https://developers.google.com/maps/documentation/javascript/get-api-key">{{__('setting.Click Here to Get Google Map Api Key')}}</a></code>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="primary-btn fix-gr-bg">
                                <i class="ti-check"></i>
                                {{__('common.Update')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
</div>
