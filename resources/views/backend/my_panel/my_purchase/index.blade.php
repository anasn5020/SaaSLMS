@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('public/backend/css/daterangepicker.css') }}{{assetVersion()}}">
@endpush
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

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
                                        <a href="{{route('users.my_purchase.index')}}" class="primary-btn fix-gr-bg theme_btn_mini theme_btn mt-2 fit-b ">{{__('common.Reset')}} </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title"> {{__('payment.Purchase history')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        @if (isModuleActive('Store'))
                                            <th scope="col">{{__('common.Order No')}}</th>
                                        @endif

                                        <th scope="col">{{__('common.Date')}}</th>
                                        <th scope="col">{{__('common.Total Courses')}} @if(isModuleActive('Store'))
                                                / {{ __('product.Products') }}
                                            @endif</th>
                                        <th scope="col">{{__('payment.Total Price')}}</th>

                                        @if (isModuleActive('Store'))
                                            <th scope="col">{{__('product.Delivery Fee')}}</th>
                                        @endif

                                        <th scope="col">{{__('common.Discount')}}</th>
                                        @if(isModuleActive('Tax'))

                                            <th scope="col">{{__('tax.TAX')}}</th>
                                        @endif
                                        <th scope="col">{{__('common.Payment Type')}}</th>
                                        <th scope="col">{{__('payment.Invoice')}}</th>
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

            <input type="hidden" value="{{route('users.my_purchase.datatable')}}" id="my_purchase_route">
            <input type="hidden" value="{{hasTax()}}" id="hasTax">
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('public/backend/js/daterangepicker.min.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('public/modules/common/date_range_init.js')}}{{assetVersion()}}"></script>

    <script>

        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = {
            url: $('#my_purchase_route').val(),
            data: function (d) {
                d.f_date = $('.date_range_input').val()
            }
        };

        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id'},
                @if(isModuleActive('Store'))
            {
                data: 'order_number', name: 'order_number', orderable: false, searchable: false
            },
                @endif
            {
                data: 'updated_at', name: 'updated_at'
            },
            {data: 'total_courses', name: 'total_courses', searchable: false},
            {data: 'purchase_price', name: 'purchase_price'},
                @if(isModuleActive('Store'))
            {
                data: 'delivery_fee', name: 'delivery_fee', orderable: false, searchable: false
            },
                @endif
            {
                data: 'discount', name: 'discount'
            },
                @if(isModuleActive('Tax'))

            {
                data: 'tax', name: 'tax', visible: hasTax, orderable: false, searchable: false
            },
                @endif
            {
                data: 'payment_method', name: 'payment_method'
            },
            {data: 'invoice', name: 'invoice', orderable: false, searchable: false},

        ]
        const hasTax = $("#hasTax").val();
        let table = $('#lms_table').DataTable(dataTableOptions);
        (function ($) {
            "use strict";
            $(document).ready(function () {

                $(document).on('click', '.reset_btn', function (event) {
                    event.preventDefault();
                    $('.date_range_input').val('');
                    resetAfterChange();
                });

                function resetAfterChange() {
                    let table = $('#lms_table').DataTable();
                    table.ajax.reload();
                }

            });

        })(jQuery);
    </script>
@endpush
