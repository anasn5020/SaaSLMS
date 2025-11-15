@extends('backend.master')
@section('mainContent')
    <style>
        .product_img_div img {
            height: 70px;
        }

        .single_img img {
            height: 80px;
            margin-right: 10px;
        }
    </style>
    {!! generateBreadcrumb() !!}
    @php
        $grand_total = $package->products->sum('total_price') + $package->shipping_cost;
    @endphp




    <div class="box_header common_table_header">
        <div class="main-title d-md-flex">
            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.Refund Request') }}</h3>
        </div>
    </div>
    <form action="{{ route('users.instructor_refund_make_request_store') }}" method="post"
          enctype="multipart/form-data">
        @csrf
        @php
            $e_items = [];
        @endphp
        <div class="white-box mb-20 col-md-10 mx-auto">
            <div class="row">

                <div class="col-lg-4">
                    <div class="primary_input mb-15">
                        <label class="primary_input_label" for=""> {{ __('product.package_code') }}
                            : {{ $package->package_code }}</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="primary_input mb-15">
                        <label class="primary_input_label" for=""> {{ __('product.order_id') }}
                            : {{ @$package->order->order_number }}</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="primary_input mb-15">
                        <label class="primary_input_label" for=""> {{ __('common.Status') }}:
                            @if ($package->order->is_cancelled == 1)
                                {{ __('product.cancelled') }}
                            @elseif($package->order->is_completed == 1)
                                {{ __('product.completed') }}
                            @else
                                @if ($package->order->is_confirmed == 1)
                                    {{ __('product.confirmed') }}
                                @elseif ($package->order->is_confirmed == 2)
                                    {{ __('product.declined') }}
                                @else
                                    {{ __('product.pending') }}
                                @endif
                            @endif
                        </label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="primary_input mb-15">
                        <label class="primary_input_label" for=""> {{ __('product.order_date') }}
                            : {{ $package->created_at }}</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="primary_input mb-15">
                        <label class="primary_input_label" for=""> {{ __('product.order_amount') }}
                            : {{ getPriceFormat($grand_total) }}</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="primary_input mb-15">
                        <label class="primary_input_label" for=""> {{ __('product.payment') }}:
                            @if ($package->order->is_paid == 1)
                                {{ __('product.paid') }}
                            @else
                                {{ __('product.pending') }}
                            @endif
                        </label>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="QA_table ">
                        <!-- table-responsive -->
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th scope="col" style="text-align: left">

                                    </th>
                                    <th colspan="2" scope="col" style="text-align: left" class="black_color">
                                        {{ __('common.Image') }}</th>

                                    <th colspan="2" scope="col" style="text-align: left" class="black_color">
                                        {{ __('courses.Course') }} /
                                        {{ __('student.Product') }} {{ __('common.Name') }}</th>

                                    <th scope="col" class="black_color">{{ __('product.Type') }}
                                    </th>
                                    <th scope="col" class="black_color">{{ __('student.Quantity') }}
                                    </th>


                                    <th scope="col" class="black_color">{{ __('student.Price') }}
                                    </th>
                                </tr>


                                <input type="hidden" name="order_id" value="{{ $package->order->id }}">
                                <input type="hidden" name="package_id" value="{{ $package->id }}">
                                @php
                                    $all_product = Modules\Store\Entities\OrderPackageDetail::with('packageProductDetail')
                                        ->where(['order_id' => $package->order_id, 'seller_id' => $package->seller_id])
                                        ->get();
                                @endphp
                                @foreach ($all_product as $k => $package_product)
                                    @php
                                        $e_items[] = [
                                            'item_id' => $package_product->packageProductDetail->course->id,
                                            'item_name' => $package_product->packageProductDetail->course->title,
                                            'price' => $package_product->packageProductDetail->price,
                                        ];
                                    @endphp
                                    <input type="hidden" name='e_items' value="{{ json_encode($e_items) }}">
                                    <input type="hidden" name='product_id'
                                           value="{{ $package_product->packageProductDetail->course->id }}">

                                    <tr>
                                        <td class="black_color">
                                            <span>
                                                <label class="primary_checkbox d-flex"
                                                       for="product_id{{ $package_product->packageProductDetail->id }}">
                                                    <input type="checkbox" name="product_ids[]"
                                                           id="product_id{{ $package_product->packageProductDetail->id }}"
                                                           checked
                                                           value="{{ $package->id }}-{{ $package->packageProductDetail->course->product_id }}-{{ $package_product->packageProductDetail->price }}-{{ $package_product->packageProductDetail->course->id }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </span>
                                        </td>
                                        <td colspan="2" style="text-align: left">
                                            <div class="product_img_div">
                                                <img
                                                    src="{{ getCourseImage(@$package_product->packageProductDetail->course->product->thumbnail) }}"
                                                    alt="">
                                            </div>
                                        </td>
                                        <td colspan="2" style="text-align: left">
                                            <h5 class="black_color">
                                                {{ @$package_product->packageProductDetail->course->title }}
                                            </h5>
                                        </td>

                                        <td class="black_color">
                                            {{ getPriceFormat($package_product->packageProductDetail->price) }}
                                        </td>
                                        <td class="black_color">
                                            {{ $package_product->packageProductDetail->qty }}
                                            <input class="count_single_item input-number qty" type="hidden" name="qty[]"
                                                   maxlength="{{ $package_product->packageProductDetail->qty }}"
                                                   minlength="1"
                                                   value="{{ $package_product->packageProductDetail->qty }}"
                                                   readonly>
                                        </td>

                                        <td style="text-align: left" class="black_color">
                                            <select class="primary_select wide rounded-0" required
                                                    {{-- id="reason_{{ $package_product->packageProductDetail->course->id }}" --}}
                                                    name="reason_id[]">
                                                @foreach ($reasons as $key => $reason)
                                                    <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="primary_input mb-15">
                        <label class="primary_input_label"
                               for="">{{ __('product.additional_information') }}</label>
                        <textarea class="primary_textarea height_112" name="additional_info" id="additional_info"
                                  placeholder="{{ __('product.additional_information') }}"></textarea>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="primary_input mb-5">
                        <label class="primary_input_label" for="">{{ __('product.set_prefered_option') }}</label>
                        <select class="primary_select wide rounded-0 mb_30" name="money_get_method"
                                id="money_get_method">
                            <option value="wallet">{{ __('product.wallet') }}</option>
                            <option value="bank_transfer">{{ __('product.bank_transfer') }}</option>
                        </select>
                    </div>
                    <div class="bank_info_div d-none">
                        <h6>{{ __('product.bank_information_to_recieve_money') }}</h6>
                        <div class="primary_input mb-3">
                            <label class="primary_input_label" for="">{{ __('product.bank_name') }}</label>
                            <input class="primary_input_field" id="bank_name" name="bank_name"
                                   placeholder="{{ __('product.bank_name') }}" type="text"
                                   value="{{ old('bank_name') }}">
                        </div>
                        <div class="primary_input mb-3">
                            <label class="primary_input_label" for="">{{ __('product.branch_name') }}</label>
                            <input class="primary_input_field" id="branch_name" name="branch_name"
                                   placeholder="{{ __('product.branch_name') }}" type="text"
                                   value="{{ old('branch_name') }}">
                        </div>
                        <div class="primary_input mb-3">
                            <label class="primary_input_label" for="">{{ __('product.account_name') }}</label>
                            <input class="primary_input_field" id="account_name" name="account_name"
                                   placeholder="{{ __('product.account_name') }}" type="text"
                                   value="{{ old('account_name') }}">
                        </div>
                        <div class="primary_input mb-3">
                            <label class="primary_input_label" for="">{{ __('product.account_number') }}</label>
                            <input class="primary_input_field" id="account_no" name="account_no"
                                   placeholder="{{ __('product.account_number') }}" type="text"
                                   value="{{ old('account_number') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary_input mb-3">
                        <label class="primary_input_label" for="">{{ __('product.set_shipment_option') }}</label>
                        <select class="primary_select wide rounded-0 mb_30" name="shipping_way" id="shipping_way">
                            <option value="courier">{{ __('product.courier_pick_up') }}</option>
                            <option value="drop_off">{{ __('product.drop_off') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 shipment_info_div1">
                    <div class="primary_input mb-3">
                        <label class="primary_input_label" for="">{{ __('product.courier_address') }}</label>
                        <select class="primary_select wide rounded-0 mb_30" name="pick_up_address_id"
                                id="pick_up_address_id">
                            @foreach (auth()->user()->customerAddresses as $key_num => $address)
                                <option value="{{ $address->id }}">{{ $address->address1 }}, {{ @$address->city }}
                                    , {{ @$address->stateDetails->name }} ({{ $address->phone }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 shipment_info_div2 d-none">
                    <div class="primary_input mb-3">
                        <label class="primary_input_label" for="">{{ __('product.courier_address') }}</label>
                        <input class="primary_input_field" id="drop_off_courier_address" name="drop_off_courier_address"
                               placeholder="{{ __('product.courier_address') }}" type="text"
                               value="{{ old('drop_off_courier_address') }}">
                    </div>
                </div>


                <div class="photo_uploader_lists col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="primary_label2 style2 ">{{ __('product.image') }}</label>
                            <div class="img_upload_group d-flex align-items-center">
                                <label for="photo_12" class="photo_uploader">
                                    <i class="fas fa-camera"></i>
                                    <p id="count_12">0/1</p>
                                    <input class="d-none upload_img_for_product" type="file" id="photo_12"
                                           name="product_images_{{ @$product->giftCard->id }}[]"
                                           data-upload_div="#img_upload_div_12" data-count="#count_12" max="6"
                                           multiple>
                                </label>
                                <div class="img_upload_div d-flex" id="img_upload_div_12">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-12 text-center">
                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i
                            class="ti-check"></i>{{ __('product.send') }}</button>
                </div>

            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.order_cancel_by_id', function (e) {
                e.preventDefault();
                $('#orderCancelReasonModal').modal('show');
                $('.order_id').val($(this).attr('data-id'));
            });
        });
    </script>


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
                            toastr.error("{{ __('defaultTheme.maximum_6_image_can_upload') }}",
                                "{{ __('common.error') }}");
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
@endpush
