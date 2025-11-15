@extends('backend.master')
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{__('product.Store Refund & Dispute')}}</h3>
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
                                        <th scope="col">{{__('product.Order ID')}}</th>
                                        <th scope="col">{{__('common.Date')}}</th>
                                        <th scope="col">{{__('common.Status')}}</th>
                                        <th scope="col">{{ __('product.Request Sent Date') }}</th>
                                        <th scope="col">{{__('product.Order Amount')}}</th>
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

            <input type="hidden" value="{{route('users.myRefundDispute.datatable')}}" id="my_purchase_route">
            {{-- <input type="hidden" value="{{hasTax()}}" id="hasTax"> --}}
        </div>
    </section>
@endsection
@push('scripts')

    <script>
        dataTableOptions.serverSide = true;
        dataTableOptions.processing = true;
        dataTableOptions.ajax = {
            url: $('#my_purchase_route').val(),
            data: function (d) {
                d.f_date = $('.date_range_input').val()
            }
        };

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
                    let table = $('#lms_table').DataTable(dataTableOptions);
                    table.ajax.reload();
                }

            });

        })(jQuery);

    </script>

@endpush
