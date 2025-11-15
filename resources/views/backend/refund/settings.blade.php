@extends('backend.master')

@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="white-box mb_30 ">

                        <form action="{{route('refund.settings.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">


                                <div class="col-lg-3 mb-25">
                                    <div class="checkbox_wrap d-flex align-items-center">
                                        <label for="enable_refund_request" class="switch_toggle me-2">
                                            <input
                                                {{Settings('enable_refund_request') == 1 ?'checked':""}} type="checkbox"
                                                id="enable_refund_request" value="1" name="enable_refund_request">
                                            <i class="slider round"></i>
                                        </label>
                                        <label
                                            class="mb-0">  {{ __('student.Enable Refund Request') }}</label>
                                    </div>
                                </div>


                                <div class="col-lg-6 refund_days_div">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="allow_refund_days">{{ __('student.Allow How Many Days For Refund After Enroll') }}
                                            <small>({{ __('coupons.0 means unlimited') }})</small></label>
                                        <input class="primary_input_field" name="allow_refund_days"
                                               id="allow_refund_days"
                                               type="number"
                                               value="{{Settings('allow_refund_days') ?Settings('allow_refund_days'): 0}}">
                                    </div>
                                </div>

                            </div>


                            <div class="row">

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center  ">
                                        <button type="submit" class="primary-btn semi_large fix-gr-bg"
                                                data-bs-toggle="tooltip"
                                                id="save_button_parent">
                                            <i class="ti-check"></i>
                                            {{ __('common.Update') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        enableRefundToggle();
        $(document).on('change', '#enable_refund_request', function (event) {
            enableRefundToggle();
        });

        function enableRefundToggle() {
            if ($('#enable_refund_request').is(':checked')) {
                $('.refund_days_div').removeClass('d-none');
            } else {
                $('.refund_days_div').addClass('d-none');
            }
        }
    </script>

@endpush
