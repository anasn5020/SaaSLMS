@extends('setting::layouts.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor white-box">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header mb-0">
                        <div class="main-title mb-0 d-flex">
                            <h3 class="mb-20">
                                {{__('setting.Queue Setting')}}
                            </h3>


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
                                    <div class="tab-pane fade show active" id="Activation"
                                         role="tabpanel" aria-labelledby="Activation-tab">
                                        <div class="main-title mb-25">


                                            <form action="{{route('setting.queueSettingStore')}}" id="" method="POST"
                                                  enctype="multipart/form-data">

                                                @csrf

                                                <div class="single_system_wrap">
                                                    <div class="row">


                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-20">
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="primary_input_label"
                                                                               for=""> {{__('setting.Queue Driver')}}</label>
                                                                    </div>
                                                                    <div class="col-md-3 mb-25">
                                                                        <label class="primary_checkbox d-flex mr-12 align-items-center"
                                                                               for="sync">
                                                                            <input type="radio"
                                                                                   class="common-radio driverCheck"
                                                                                   id="sync"
                                                                                   name="driver"
                                                                                   value="sync"

                                                                                {{@$driver=='sync'?"checked":""}}>

                                                                            <span
                                                                                class="checkmark me-2"></span> {{__('setting.sync')}}
                                                                            <i class="ms-2 fa fa-question-circle"
                                                                               data-bs-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title="Queue will execute instant on submit."
                                                                            ></i>
                                                                        </label>
                                                                    </div>

                                                                    <div class="col-md-3 mb-25">
                                                                        <label class="primary_checkbox d-flex mr-12 align-items-center"
                                                                               for="database">
                                                                            <input type="radio"
                                                                                   class="common-radio driverCheck"
                                                                                   id="database"
                                                                                   name="driver"
                                                                                   value="database" {{@$driver=='database'?"checked":""}}>


                                                                            <span
                                                                                class="checkmark me-2"></span> {{__('setting.Database')}}
                                                                            <i class="ms-2 fa fa-question-circle ms-2 "
                                                                               data-bs-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title="Queue will store in database. Need to set cron job for execute queue on submit."
                                                                            ></i>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>


                                                <div class="submit_btn  mt-0">
                                                    <button class="primary-btn small fix-gr-bg" type="submit"
                                                            data-bs-toggle="tooltip" title=""
                                                            id="general_info_sbmt_btn"><i
                                                            class="ti-check"></i> {{ __('common.Save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <div class="tab-content mt-2" id="myTabContent">


                                        <!-- SMS  -->
                                        <div class="tab-pane fade active show " id="SMS" role="tabpanel"
                                             aria-labelledby="SMS-tab">

                                            <input type="hidden" name="g_set" value="1">

                                            <div class="General_system_wrap_area d-block">
                                                <div class="single_system_wrap">
                                                    <h5>{{__('setting.To run queue, you should set this path in cPanel Cron Command field')}}
                                                        .</h5>
                                                    <div class="single_system_wrap_inner text-center">

                                                        <p style="overflow-wrap: anywhere;">{{ 'cd ' . base_path() . '/ && php artisan queue:work >> /dev/null 2>&1' }}</p>

                                                    </div>
                                                    <h6>{{__('setting.In cPanel you should set time interval 10 min')}}
                                                        .</h6>
                                                </div>

                                            </div>
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
