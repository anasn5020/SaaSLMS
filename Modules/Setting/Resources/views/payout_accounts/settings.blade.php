@extends('backend.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor mb-20 student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box mb_30 ">
                        <form action="{{route('admin.payout.settings.submit')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="">{{ __('setting.Minimum Payout Amount') }}</label>
                                        <input class="primary_input_field"
                                               value="{{Settings('minimum_payout_amount')}}"
                                               name="minimum_payout_amount" id="minimum_payout_amount"
                                               placeholder="-"
                                               type="number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="submit_btn d-flex justify-content-center align-items-center">
                                        <button class="primary-btn fix-gr-bg" type="submit"><i
                                                class="ti-check"></i> {{ __('common.Update') }}</button>
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
