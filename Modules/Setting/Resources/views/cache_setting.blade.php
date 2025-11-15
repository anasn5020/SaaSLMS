@extends('setting::layouts.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">

                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="">
                        <div class="row">

                            <div class="col-lg-12">
                                <!-- tab-content  -->
                                <div class="tab-content " id="myTabContent">
                                    <!-- General -->
                                    <div class="tab-pane fade white-box show active" id="Activation"
                                         role="tabpanel" aria-labelledby="Activation-tab">
                                        <div class="main-title mb-25">


                                            <form action="{{route('setting.cacheSettingStore')}}" id="" method="POST"
                                                  enctype="multipart/form-data">

                                                @csrf

                                                <div class="single_system_wrap">
                                                    <div class="row">


                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="primary_input_label"
                                                                               for=""> {{__('setting.Cache Driver')}}</label>
                                                                    </div>
                                                                    <div class="col-md-3 mb-25">
                                                                        <label class="primary_checkbox d-flex mr-12"
                                                                               for="file">
                                                                            <input type="radio"
                                                                                   class="common-radio driverCheck"
                                                                                   id="file"
                                                                                   name="driver"
                                                                                   value="file" {{@$driver=='file'?"checked":""}}>
                                                                            <span
                                                                                class="checkmark me-2"></span> {{__('setting.File')}}
                                                                        </label>
                                                                    </div>

                                                                    <div class="col-md-3 mb-25">
                                                                        <label class="primary_checkbox d-flex mr-12"
                                                                               for="array">
                                                                            <input type="radio"
                                                                                   class="common-radio driverCheck"
                                                                                   id="array"
                                                                                   name="driver"
                                                                                   value="array" {{@$driver=='array'?"checked":""}}>
                                                                            <span
                                                                                class="checkmark me-2"></span> {{__('setting.Array')}}
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-md-3 mb-25">
                                                                        <label class="primary_checkbox d-flex mr-12"
                                                                               for="redis"> <input type="radio"
                                                                                                   class="common-radio driverCheck"
                                                                                                   id="redis"
                                                                                                   name="driver"
                                                                                                   value="redis" {{@$driver=='redis'?"checked":""}}>
                                                                            <span
                                                                                class="checkmark me-2"></span> {{__('setting.Redis')}}
                                                                        </label>
                                                                    </div>

                                                                    <div class="col-md-3 mb-25">
                                                                        <label class="primary_checkbox d-flex mr-12"
                                                                               for="memcached">
                                                                            <input type="radio"
                                                                                   class="common-radio driverCheck"
                                                                                   id="memcached"
                                                                                   name="driver"
                                                                                   value="memcached" {{@$driver=='memcached'?"checked":""}}>
                                                                            <span
                                                                                class="checkmark me-2"></span> {{__('setting.Memcached')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="row redis">
                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('setting.Redis Host')}}</label>
                                                                <input class="primary_input_field"
                                                                       placeholder="Redis Host" type="text"
                                                                       id="redis_host"
                                                                       name="redis_host" value="{{env('REDIS_HOST')}}">
                                                            </div>
                                                        </div>


                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('setting.Redis Password')}}</label>
                                                                <input class="primary_input_field"
                                                                       placeholder="Redis Password" type="text"
                                                                       id="redis_password"
                                                                       name="redis_password"
                                                                       value="{{env('REDIS_PASSWORD')}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('setting.Redis Port')}}</label>
                                                                <input class="primary_input_field"
                                                                       placeholder="Redis Password" type="text"
                                                                       id="redis_port"
                                                                       name="redis_port" value="{{env('REDIS_PORT')}}">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row memcached">
                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('setting.Memcached Persistent ID')}}</label>
                                                                <input class="primary_input_field"
                                                                       placeholder="Persistent ID" type="text"
                                                                       id="memcached_persistent_id"
                                                                       name="memcached_persistent_id"
                                                                       value="{{env('MEMCACHED_PERSISTENT_ID')}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('setting.Memcached Host')}}</label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('setting.Memcached Host')}}"
                                                                       type="text"
                                                                       id="memcached_host"
                                                                       name="memcached_host"
                                                                       value="{{env('MEMCACHED_HOST')}}">
                                                            </div>
                                                        </div>


                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('setting.Memcached Username')}}</label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('setting.Memcached Username')}}"
                                                                       type="text"
                                                                       id="memcached_username"
                                                                       name="memcached_username"
                                                                       value="{{env('MEMCACHED_USERNAME')}}">
                                                            </div>
                                                        </div>


                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('setting.Memcached Password')}}</label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('setting.Memcached Password')}}"
                                                                       type="text"
                                                                       id="memcached_password"
                                                                       name="memcached_password"
                                                                       value="{{env('MEMCACHED_PASSWORD')}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-4">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('setting.Memcached Port')}}</label>
                                                                <input class="primary_input_field"
                                                                       placeholder="{{__('setting.Memcached Port')}}"
                                                                       type="text"
                                                                       id="memcached_port"
                                                                       name="memcached_port"
                                                                       value="{{env('MEMCACHED_PORT')}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="submit_btn text-center mt-10">
                                                    <button class="primary-btn fix-gr-bg" type="submit"
                                                            data-bs-toggle="tooltip" title=""
                                                            id="general_info_sbmt_btn"><i
                                                            class="ti-check"></i> {{ __('common.Save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let memcached = $('.memcached');
        memcached.hide();
        let redis = $('.redis');
        redis.hide();


        //
        $(document).on("click", ".driverCheck", function () {
            let driver = $("input[name='driver']:checked").val();
            if (driver === "redis") {
                redis.show();
                memcached.hide();
            } else if (driver === "memcached") {
                redis.hide();
                memcached.show();
            } else {
                redis.hide();
                memcached.hide();
            }
        });

        $("document").ready(function () {
            $("input[name='driver']:checked").trigger('click');

        });
    </script>
@endpush
