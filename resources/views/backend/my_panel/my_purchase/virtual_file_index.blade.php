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
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.SL')}}</th>
                                        <th scope="col">{{__('common.Total Courses')}}
                                            / {{ __('product.Products') }}</th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($packages))
                                        @foreach ($packages as $key=> $product)
                                            <tr>
                                                <td scope="row">{{$key+1}}</td>
                                                <td>{{@$product->course->title}}</td>
                                                <td>
                                                    @if ($product->course->product?->soft_file)
                                                        <a href="@if (isset($product->course->product?->soft_file)) {{ route('users.downloadVirtualFile', [$product->course->slug]) }} @else javascript:void(0) @endif"
                                                           class="btn btn-secondary text-white">{{__('product.Download')}}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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
