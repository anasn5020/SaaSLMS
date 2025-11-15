@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('store.Refund Request')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/my_invoice.css')}}{{assetVersion()}}" rel="stylesheet"
          media="screen,print"/>
    <style>
        .thumb img {
            height: 70px;
        }


        .product_img_div img {
            height: 70px;
        }

        .single_img img {
            height: 80px;
            margin-right: 10px;
        }

        .invoice_part_iner h4 {
            font-size: 17px;
        }

        .order_details_progress {
            display: flex;
            margin: 40px 0 75px 0;
            position: relative;
        }

        .order_details_progress .single_order_progress:not(:last-child)::before {
            content: "";
            position: absolute;
            left: calc(50% + 20px);
            height: 1px;
            background: #f1ece8;
            top: 15px;
            right: calc(-50% + 20px);
        }

        .order_details_progress .single_order_progress {
            flex: 1 0 0;
        }

        .thumb {
            width: 100px !important;
        }

        .theme_select:after {
            right: 33px;
            top: 25px;
            color: #afafaf;
            font-size: 12px;
        }

    </style>
@endsection
@section('mainContent')
    <x-my-order-refund-request-page-section :id="$id"/>
@endsection
@section('js')
    <script src="{{ asset('public/frontend/infixlmstheme') }}/js/html2pdf.bundle.js"></script>
    <script src="{{ asset('public/frontend/infixlmstheme/js/my_invoice.js') }}"></script>

    <script type="text/javascript">
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $(document).on('change', '#money_get_method', function () {
                    $('#pre-loader').show();
                    var method = this.value;
                    if (method == "bank_transfer") {
                        $('.bank_info_div').removeClass('d-none');
                    } else {
                        $('.bank_info_div').addClass('d-none');
                    }
                    $('#pre-loader').hide();
                });
                $(document).on('change', '#shipping_way', function () {
                    $('#pre-loader').show();
                    var way = this.value;
                    if (way == "courier") {
                        $('.shipment_info_div1').removeClass('d-none');
                        $('.shipment_info_div2').addClass('d-none');
                    } else {
                        $('.shipment_info_div1').addClass('d-none');
                        $('.shipment_info_div2').removeClass('d-none');
                    }
                    $('#pre-loader').hide();
                });
                $(document).on('change', '.upload_img_for_product', function (event) {
                    let upload_div = $(this).data('upload_div');
                    let count = $(this).data('count');
                    uploadImage($(this)[0], upload_div, count);
                });

                function uploadImage(data, divId, count) {
                    if (data.files) {
                        if (data.files.length > 6) {
                            toastr.error("{{__('defaultTheme.maximum_6_image_can_upload')}}", "{{__('common.error')}}");
                            data.value = '';
                        } else {
                            $.each(data.files, function (key, value) {
                                $(divId).empty();
                                $(count).text(data.files.length + '/6');
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    $(divId).append(
                                        `<div class="single_img">
                                        <img src="` + e.target.result + `" alt="">
                                    </div>`);
                                };
                                reader.readAsDataURL(value);
                            });
                        }
                    }
                }
            });
        })(jQuery);
    </script>

@endsection
