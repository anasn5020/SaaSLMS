<div role="tabpanel" class="tab-pane fade"
     id="exchangerate">
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
                                <div class="col-lg-12 mb-10">
                                    <div class="input-effect">
                                        <label class="pb-2">{{__('setting.Exchangerate Access Key')}}
                                        </label>
                                        <input class="primary_input_field form-control"
                                               type="text" name="exchangerate_access_key"
                                               autocomplete="off"
                                               value="{{Settings('exchangerate_access_key')}}">

                                        <span class="focus-border"></span>
                                        <span
                                            class="modal_input_validation red_alert"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <code><a target="_blank"
                                             title="Foreign exchange rates and currency conversion"
                                             href="https://exchangerate.host/dashboard">{{__('setting.Click Here to Get Exchangerate Access Key')}}</a></code>
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
