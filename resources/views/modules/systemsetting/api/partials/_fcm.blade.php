@php use Illuminate\Support\Facades\Storage; @endphp
<div role="tabpanel" class="tab-pane fade"
     id="fcm">
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

                                    <label class="primary_input_label"
                                           for="">{{__('setting.FCM Admin SDK JSON File')}}</label>
                                    <div class="primary_file_uploader">
                                        <input
                                            class="primary-input filePlaceholder"
                                            type="text"
                                            accept="application/json"
                                            placeholder="{{__('common.Browse')}} {{__('setting.FCM Admin SDK JSON File')}}"
                                            readonly="">
                                        <button class="" type="button">
                                            <label
                                                class="primary-btn small fix-gr-bg"
                                                for="document_file_public_key_{{@$payment_method->id}}">{{__('common.Browse')}}</label>
                                            <input type="file"
                                                   class="d-none fileUpload"
                                                   name="fcm_json"
                                                   accept="application/json"
                                                   id="document_file_public_key_{{@$payment_method->id}}"
                                            >
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <code><a target="_blank"
                                             title=""
                                             href="https://console.firebase.google.com/">{{__('setting.Click Here to Get Firebase Cloud Messaging(FCM) Api Credentials')}}</a></code>
                                </div>

                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="primary-btn fix-gr-bg">
                                        <i class="ti-check"></i>
                                        {{__('common.Update')}}
                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
        <hr>

        @php

            $json = Storage::get(SaasDomain() . '-firebase-service-account.json');
               $data = json_decode($json, true);
        @endphp
        @if($data)
            <div class="row mt-3">
                <div class="col-lg-6 mb-10">
                    <div class="input-effect">
                        <label class="pb-2">{{__('setting.FCM Project ID')}}
                        </label>
                        <input class="primary_input_field form-control"
                               type="text" name="fcm_project_id"
                               autocomplete="off"
                               value="{{$data['project_id']??''}}">
                    </div>
                </div>

                <div class="col-lg-6 mb-10">
                    <div class="input-effect">
                        <label class="pb-2">{{__('setting.FCM Client Email')}}
                        </label>
                        <input class="primary_input_field form-control"
                               type="text" name="fcm_client_email"
                               autocomplete="off"
                               value="{{$data['client_email']??''}}">
                    </div>
                </div>


                <div class="col-lg-12 mb-10">
                    <div class="input-effect">
                        <label class="pb-2">{{__('setting.FCM Private Key')}}
                        </label>
                        <textarea rows="15" class=" form-control"
                                  name="fcm_private_key">{!! $data['private_key']??'' !!}</textarea>
                    </div>
                </div>
            </div>
        @endif
</div>
