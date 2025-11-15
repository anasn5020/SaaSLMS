<div role="tabpanel" class="tab-pane fade"
     id="fixer">
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
                                        <label class="pb-2">{{__('setting.Fixer Key')}}
                                        </label>
                                        <input class="primary_input_field form-control"
                                               type="text" name="fixer_key"
                                               autocomplete="off"
                                               value="{{Settings('fixer_key')}}">

                                        <span class="focus-border"></span>
                                        <span
                                            class="modal_input_validation red_alert"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <code><a target="_blank"
                                             title="Foreign exchange rates and currency conversion"
                                             href="https://fixer.io/">{{__('setting.Click Here to Get Fixer Api Key')}}</a></code>
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
