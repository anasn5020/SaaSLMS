<div class="modal fade admin-query" id="show_gateway_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{ __('setting.Gateway Details') }}

                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-xl-12">
                        <h4> {{ __('setting.Gateway Name') }} : {{$gateway->gateway_name}}</h4>
                    </div>
                    <div class="col-xl-12">
                        <h4> {{ __('setting.Gateway URL') }} : {{$gateway->gateway_url}}</h4>
                    </div>
                    <div class="col-xl-12">
                        <h4> {{ __('setting.Request Method') }} : {{$gateway->request_method}}</h4>
                    </div>

                    <div class="col-xl-12">
                        <h4>  {{ __('setting.Send to Parameter') }} : {{$gateway->send_to_parameter_name}}</h4>
                    </div>
                    <div class="col-xl-12">
                        <h4>  {{ __('setting.Message to Parameter') }} : {{$gateway->message_to_parameter_name}}</h4>
                    </div>
                    <div class="col-xl-12">
                        <h4> {{ __('setting.Set Authentication') }} : {{$gateway->set_auth}}</h4>
                    </div>


                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <h4>{{__('common.Logo')}}</h4>
                        <img id="logo_show" class="center image_preview"
                             src="{{isset($gateway)?showImage($gateway->gateway_logo): showImage()}}"
                             alt="Logo">
                    </div>
                </div>

                <div class="row mt-25">
                    <div class="col-md-12 d-flex align-items-center">
                        <div class="">
                            <h4 class="text-nowrap">{{__('setting.Parameters')}}</h4>
                        </div>
                        <div class="custom-hr">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <ul class="list-group list-group-flush">
                            @foreach($gateway->params as $param)
                                <li class="list-group-item">{{$param->key}}:{{$param->value}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
