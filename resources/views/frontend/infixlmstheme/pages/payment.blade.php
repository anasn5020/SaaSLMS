@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | @lang('frontendmanage.Payment Method')
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/select2.min.css')}}{{assetVersion()}}" rel="stylesheet"/>
    <link href="{{asset('public/frontend/infixlmstheme/css/checkout.css')}}{{assetVersion()}}" rel="stylesheet"/>
    <style>
        .thumb img {
            object-fit: cover;
            object-position: center;
            height: 100%;
        }
    </style>

@endsection
@section('mainContent')
    @php
        $invoice = isset($invoice) ? $invoice : null;
    @endphp

    <x-breadcrumb :banner="$frontendContent->about_page_banner" :title="trans('frontend.Secure Your Purchase')"
                  :subTitle="trans('frontend.Payment')"/>
    <x-payment-page-section :invoice="$invoice"/>

@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/select2.min.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/checkout.js')}}{{assetVersion()}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/city.js')}}{{assetVersion()}}"></script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.billingUpdate', function () {
                $('.billingUpdateForm').removeClass('d-none');
                $('.billingUpdateShow').removeClass('d-none');
                $('.biling_body_content').addClass('d-none');
                $('.billingUpdate').addClass('d-none');
            })
            $(document).on('click', '.billingUpdateShow', function () {
                $('.billingUpdateForm').addClass('d-none');
                $('.billingUpdateShow').addClass('d-none');
                $('.billingUpdate').removeClass('d-none');
                $('.biling_body_content').removeClass('d-none');

                let tracking_id = $('#tracking_id').val();
                let billing_detail_id = $('#billing_detail_id').val();
                billingData(tracking_id, billing_detail_id);
            })
            $(document).on('click', '#billingUpdateBtn', function (e) {
                e.preventDefault();
                var _token = $('meta[name="csrf-token"]').attr('content');
                var url = $('#baseUrl').val();
                var first_name = $('#first_name').val();
                var last_name = $('#last_name').val();
                var company_name = $('#company_name').val();
                var country = $('#country').val();
                var address1 = $('#address1').val();
                var address2 = $('#address2').val();
                var state = $('#state').val();
                var city = $('#city').val();
                var zip_code = $('#zip_code').val();
                var details = $('#details').val();
                let tracking_id = $('#tracking_id').val();
                let billing_detail_id = $('#billing_detail_id').val();
                var formData = {
                    _token: _token,
                    first_name: first_name,
                    last_name: last_name,
                    company_name: company_name,
                    country: country,
                    address1: address1,
                    address2: address2,
                    state: state,
                    city: city,
                    zip_code: zip_code,
                    details: details,
                    tracking_id: tracking_id,
                    billing_detail_id: billing_detail_id,
                }

                $.ajax({
                    type: "GET",
                    data: formData,
                    dataType: "JSON",
                    url: url + '/billing-update-student',
                    success: function (data) {
                        console.log(data);
                        setTimeout(function () {
                            toastr.success("Operation successful", 'Success', {
                                timeOut: 5000,
                            });
                        }, 500);

                        $('.billingUpdateForm').addClass('d-none');
                        $('.billingUpdate').addClass('d-none');
                        $('.billingUpdateShow').removeClass('d-none');
                        $('.biling_body_content').removeClass('d-none');
                        billingData(tracking_id, billing_detail_id);

                    },
                    error: function () {
                        setTimeout(function () {
                            toastr.error("Operation Failed", 'Error', {
                                timeOut: 5000,
                            });
                        }, 500);
                    }
                })
            })

            function billingData(tracking_id, billing_detail_id) {
                var url = $('#baseUrl').val();
                $.ajax({
                    type: "get",
                    data: {tracking_id: tracking_id, billing_detail_id: billing_detail_id},
                    dataType: "HTML",
                    url: url + '/billing-data',
                    success: function (data) {
                        $('.biling_body_content').html('');
                        $('.biling_body_content').html(data);
                    },
                    error: function () {

                    }
                })
            }
        })
    </script>
@endsection
