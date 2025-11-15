@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('public/backend/css/daterangepicker.css') }}{{assetVersion()}}">
@endpush
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if(Settings('enable_refund_request'))
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="white_box mb_30">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-20">
                                        <h3 class="mb-0">{{__('frontend.Refund Request')}}</h3>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <form action="{{route('enrollmentCancellationSubmit')}}" method="POST">
                                        @csrf
                                        <div class="row">

                                            <div class="col-lg-12 mb-25">
                                                <label class="primary_input_label" for="course">{{__('courses.Course')}}
                                                    <span
                                                        class="required_mark">*</span></label>
                                                <select class="primary_select" name="course" id="course">
                                                    <option
                                                        value="">{{__('common.Select')}} {{__('courses.Course')}}</option>
                                                    @if(isset($courses))
                                                        @foreach ($courses as $course)
                                                            <option
                                                                value="{{$course->id}}"
                                                            >{{@$course->course->title}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{__('frontend.Reason') }}
                                                        <span
                                                            class="required_mark">*</span>
                                                    </label>
                                                    <textarea id="my-textarea" class="primary_input_field"
                                                              name="reason" style="height: 200px"
                                                              rows="3">{{old('reason')}}</textarea>
                                                </div>

                                            </div>
                                            <div class="col-lg-12 mb-30">

                                                <button class="primary-btn semi_large2  fix-gr-bg"
                                                        id="save_button_parent"
                                                        type="submit">
                                                    <i class="ti ti-check"></i>
                                                    {{__('common.Submit') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{__('courses.Advanced Filter')}} </h4>
                        </div>
                        <form action="#" method="POST">
                            @csrf
                            <div class="row">


                                <div class="col-lg-3">
                                    <div class="primary_input mb-15 date_range">
                                        <div class="primary_datepicker_input filter">
                                            <label class="primary_input_label" for="">{{__('common.Date')}}</label>
                                            <div class="g-0  input-right-icon">
                                                <input placeholder="{{__('common.Date')}}" readonly
                                                       class="primary_input_field date_range_input" type="text"
                                                       name="date_range_filter" value="">
                                                <button class="" type="button">
                                                    <i class="fa fa-refresh" id="reset-date-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-1 ">
                                    <div class="search_course_btn">
                                        <a href="{{route('users.my_refund.index')}}" class="primary-btn fix-gr-bg theme_btn_mini theme_btn mt-2 fit-b ">{{__('common.Reset')}} </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="white-box">

                                <div class="col-12">
                                    <div class="box_header common_table_header">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('frontend.Refund & Cancellation')}} {{__('common.History')}}</h3>
                                        </div>
                                    </div>
                                </div>

                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('courses.Request')}} {{__('common.Date')}} </th>
                                        <th scope="col">{{__('courses.Course')}}</th>
                                        <th scope="col">{{__('common.Price')}}</th>
                                        <th scope="col">{{__('courses.Request From')}}</th>
                                        <th scope="col">{{__('common.Type')}} </th>
                                        <th scope="col">{{__('common.Status')}} </th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" value="{{route('users.my_refund.datatable')}}" id="my_refund_route">
            <div class="modal fade admin-query" id="reasonShowModal">
                <div class="modal-dialog modal_650px modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="reason_heading"></h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ti-close "></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="reason_body"></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('public/backend/js/daterangepicker.min.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('public/modules/common/date_range_init.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('public/modules/my_panel/my_refund.js')}}{{assetVersion()}}"></script>
@endpush
