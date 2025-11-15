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
                                {{__('setting.Pusher Setting')}}
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


                                            <form action="{{route('pusher.setting')}}" id="" method="POST">

                                                @csrf

                                                <div class="row"
                                                     id="pusher">
                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('setting.pusher_app_id') }}</label>
                                                            <input class="primary_input_field" placeholder="-"
                                                                   type="text"
                                                                   name="pusher_app_id"
                                                                   value="{{ env('PUSHER_APP_ID') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('setting.pusher_app_key') }}</label>
                                                            <input class="primary_input_field" placeholder="-"
                                                                   type="text"
                                                                   name="pusher_app_key"
                                                                   value="{{ env('PUSHER_APP_KEY') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('setting.pusher_app_secret') }}</label>
                                                            <input class="primary_input_field" placeholder="-"
                                                                   type="text"
                                                                   name="pusher_app_secret"
                                                                   value="{{ env('PUSHER_APP_SECRET') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('setting.pusher_app_cluster') }}</label>
                                                            <input class="primary_input_field" placeholder="-"
                                                                   type="text"
                                                                   name="pusher_app_cluster"
                                                                   value="{{ env('PUSHER_APP_CLUSTER') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="submit_btn  d-flex justify-content-center align-items-center mt-0">
                                                    <button class="primary-btn   fix-gr-bg" type="submit"
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

@endpush
