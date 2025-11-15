<div>
    <section class="admin-visitor-area up_st_admin_visitor pt-5 mt-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-9">

                    <!-- invoice print part here -->
                    <div class="invoice_print pb-5">
                        <div class="container-fluid p-0">
                            <div id="invoice_print" class="invoice_part_iner">


                                <table style=" margin-bottom: 30px" class="table">
                                    <tbody>
                                    <td>
                                        <img style="width: 108px" src="{{ getCourseImage(Settings('logo')) }}"
                                             alt="{{ Settings('site_name') }}">
                                    </td>
                                    <td style="text-align: right">
                                        <h3 class="invoice_no black_color" style=" margin-bottom: 10px" ;>
                                            INV-{{ $order->id + 1000 }}</h3>
                                    </td>
                                    </tbody>
                                </table>
                                <div class="amazy_dashboard_area dashboard_bg section_spacing6">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xl-10 offset-xl-1">
                                                <div class="white_box style2 bg-white mb_20">
                                                    <div
                                                        class="white_box_header d-flex align-items-center gap_20 flex-wrap  amazy_bb3 justify-content-between ">
                                                        <div class="d-flex flex-column  ">
                                                            <div class="d-flex align-items-center flex-wrap gap_5">
                                                                <h4 class="font_14 f_w_500 m-0 lh-base">
                                                                    {{ __('product.package_code') }}: </h4>
                                                                <p class="font_14 f_w_400 m-0 lh-base">
                                                                    {{ $package->package_code }}</p>
                                                            </div>
                                                            <div class="d-flex align-items-center flex-wrap gap_5">
                                                                <h4 class="font_14 f_w_500 m-0 lh-base">
                                                                    {{ __('product.order_id') }}: </h4>
                                                                <p class="font_14 f_w_400 m-0 lh-base">
                                                                    {{ @$package->order->order_number }}</p>
                                                            </div>
                                                            <div class="d-flex align-items-center flex-wrap gap_5">
                                                                <h4 class="font_14 f_w_500 m-0 lh-base">
                                                                    {{ __('product.seller') }}: </h4>
                                                                <p class="font_14 f_w_400 m-0 lh-base">
                                                                    {{ Settings('site_title') }}
                                                                </p>
                                                            </div>

                                                        </div>
                                                        <div class="d-flex flex-column ">
                                                            <div class="d-flex align-items-center flex-wrap gap_5">
                                                                <h4 class="font_14 f_w_500 m-0 lh-base">
                                                                    {{ __('common.Status') }}: </h4>
                                                                <p class="font_14 f_w_400 m-0 lh-base">
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
                                                                </p>

                                                            </div>
                                                            <div class="d-flex align-items-center flex-wrap gap_5">
                                                                <h4 class="font_14 f_w_500 m-0 lh-base">
                                                                    {{ __('product.order_date') }}: </h4>
                                                                <p class="font_14 f_w_400 m-0 lh-base">
                                                                    {{ $package->created_at }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            @php
                                                                $grand_total = $package->products->sum('total_price') + $package->shipping_cost;
                                                            @endphp
                                                            <div class="d-flex align-items-center flex-wrap gap_5">
                                                                <h4 class="font_14 f_w_500 m-0 lh-base">
                                                                    {{ __('product.order_amount') }}: </h4>
                                                                <p class="font_14 f_w_400 m-0 lh-base">
                                                                    {{ single_price($grand_total) }}</p>
                                                            </div>
                                                            <div class="d-flex align-items-center flex-wrap gap_5">
                                                                <h4 class="font_14 f_w_500 m-0 lh-base">
                                                                    {{ __('product.payment') }}
                                                                    : </h4>
                                                                <p class="font_14 f_w_400 m-0 lh-base">
                                                                    @if ($package->order->is_paid == 1)
                                                                        {{ __('product.paid') }}
                                                                    @else
                                                                        {{ __('product.pending') }}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('refund.refund_make_request_store') }}"
                                                          method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        @php
                                                            $e_items = [];
                                                        @endphp
                                                        <div class="dashboard_white_box_body">
                                                            <div class="table-responsiveX mb_10">
                                                                <table
                                                                    class="table amazy_table3 style2 mb-0 min-height-250 refund_product_list">
                                                                    <tbody>
                                                                    <input type="hidden" name="order_id"
                                                                           value="{{ $package->order->id }}">
                                                                    <input type="hidden" name="package_id"
                                                                           value="{{ $package->id }}">

                                                                    @php
                                                                        $all_product = Modules\Store\Entities\OrderPackageDetail::with('packageProductDetail')->where(['order_id' => $package->order_id, 'seller_id' => $package->seller_id])->get();
                                                                    @endphp
                                                                    @foreach ($all_product as $k => $package_product)
                                                                        @php
                                                                            $e_items[] = [
                                                                                'item_id' => $package_product->packageProductDetail->course->id,
                                                                                'item_name' => $package_product->packageProductDetail->course->title,
                                                                                'price' => $package_product->packageProductDetail->price,
                                                                            ];
                                                                        @endphp
                                                                        <input type="hidden" name='e_items'
                                                                               value="{{ json_encode($e_items) }}">
                                                                        <input type="hidden" name='product_id'
                                                                               value="{{ $package_product->packageProductDetail->course->id }}">
                                                                        <tr>
                                                                            <td>
                                                                                <a href="{{ courseDetailsUrl(@$package_product->packageProductDetail->course->id, @$package_product->packageProductDetail->course->type, @$package_product->packageProductDetail->course->slug) }}"
                                                                                   class="d-flex align-items-center gap_20 cart_thumb_div">
                                                                                    <label
                                                                                        class="primary_checkbox d-flex"
                                                                                        for="product_id{{ $package_product->packageProductDetail->id }}">
                                                                                        <input type="checkbox"
                                                                                               name="product_ids[]"
                                                                                               id="product_id{{ $package_product->packageProductDetail->id }}"
                                                                                               checked
                                                                                               value="{{ $package->id }}-{{ $package->packageProductDetail->course->product_id }}-{{ $package_product->packageProductDetail->price }}-{{ $package_product->packageProductDetail->course->id }}">
                                                                                        <span
                                                                                            class="checkmark"></span>
                                                                                    </label>
                                                                                    <div class="thumb ms-2">
                                                                                        <img
                                                                                            src="{{ getCourseImage(@$package_product->packageProductDetail->course->product->thumbnail) }}"
                                                                                            alt="">
                                                                                    </div>
                                                                                    <div
                                                                                        class="summery_pro_content">
                                                                                        <h4
                                                                                            class="font_16 f_w_700 m-0 theme_hover">
                                                                                            {{ @$package_product->packageProductDetail->course->product->product_name, 30 }}
                                                                                        </h4>

                                                                                    </div>
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <h4
                                                                                    class="font_16 f_w_500 m-0 text-nowrap">
                                                                                    {{ $package_product->packageProductDetail->qty }}
                                                                                    X
                                                                                    {{ getPriceFormat($package_product->packageProductDetail->price) }}
                                                                                </h4>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="product_number_count style_4"
                                                                                    data-bs-target="amount-1">
{{--                                                                                    <button type="button"--}}
{{--                                                                                            value="-"--}}
{{--                                                                                            class="count_single_item inumber_decrement">--}}
{{--                                                                                        <i class="ti-minus"></i>--}}
{{--                                                                                    </button>--}}
                                                                                    <input
                                                                                        class="count_single_item input-number qty"
                                                                                        type="text"
                                                                                        name="qty[]"
                                                                                        maxlength="{{ $package_product->packageProductDetail->qty }}"
                                                                                        minlength="1"
                                                                                        value="{{ $package_product->packageProductDetail->qty }}"
                                                                                        readonly>
{{--                                                                                    <button type="button"--}}
{{--                                                                                            value="+"--}}
{{--                                                                                            class="count_single_item number_increment">--}}
{{--                                                                                        <i--}}
{{--                                                                                            class="ti-plus"></i>--}}
{{--                                                                                    </button>--}}
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <select
                                                                                    class="theme_select wide rounded-0"
                                                                                    required
                                                                                    {{-- id="reason_id" --}}
                                                                                    name="reason_id[]">
                                                                                    @foreach ($reasons as $key => $reason)
                                                                                        <option
                                                                                            value="{{ $reason->id }}">
                                                                                            {{ $reason->reason }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                                @error('product_ids')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="amazy_bb3 mt-2 mb-3"></div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <label
                                                                        class="primary_label2 style2 ">{{ __('product.additional_information') }}</label>
                                                                    <textarea name="additional_info"
                                                                              id="additional_info" maxlength="255"
                                                                              placeholder="{{ __('product.additional_information') }}"
                                                                              class="primary_textarea4  rounded-0 mb_25"></textarea>
                                                                    <span class="text-danger"
                                                                          id="error_message"></span>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label
                                                                        class="primary_label2 style2 ">{{ __('product.set_prefered_option') }}
                                                                    </label>
                                                                    <select
                                                                        class="theme_select wide rounded-0 mb_30"
                                                                        name="money_get_method"
                                                                        id="money_get_method">
                                                                        <option value="wallet">
                                                                            {{ __('product.wallet') }}</option>
                                                                        <option value="bank_transfer">
                                                                            {{ __('product.bank_transfer') }}
                                                                        </option>
                                                                    </select>
                                                                    <div class="bank_info_div row d-none">
                                                                        <div class="col-md-12">
                                                                            <h5>{{ __('product.bank_information_to_recieve_money') }}
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label
                                                                                class="primary_label2 style2 ">{{ __('product.bank_name') }}
                                                                                <span>*</span></label>
                                                                            <input type="text" id="bank_name"
                                                                                   name="bank_name"
                                                                                   placeholder="{{ __('product.bank_name') }}"
                                                                                   class="primary_input3 style4 mb_30">
                                                                            @error('bank_name')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label
                                                                                class="primary_label2 style2 ">{{ __('product.branch_name') }}
                                                                                <span>*</span></label>
                                                                            <input type="text" id="branch_name"
                                                                                   name="branch_name"
                                                                                   placeholder="{{ __('product.branch_name') }}"
                                                                                   class="primary_input3 style4 mb_30">
                                                                            @error('branch_name')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label
                                                                                class="primary_label2 style2 ">{{ __('product.account_name') }}
                                                                                <span>*</span></label>
                                                                            <input type="text"
                                                                                   id="account_name"
                                                                                   name="account_name"
                                                                                   placeholder="{{ __('product.account_name') }}"
                                                                                   class="primary_input3 style4 mb_30">
                                                                            @error('account_name')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label
                                                                                class="primary_label2 style2 ">{{ __('product.account_number') }}
                                                                                <span>*</span></label>
                                                                            <input type="text" id="account_no"
                                                                                   name="account_no"
                                                                                   placeholder="{{ __('product.account_number') }}"
                                                                                   class="primary_input3 style4 mb_30">
                                                                            @error('account_no')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label
                                                                        class="primary_label2 style2 ">{{ __('product.set_shipment_option') }}
                                                                    </label>
                                                                    <select
                                                                        class="theme_select wide rounded-0 mb_30"
                                                                        name="shipping_way" id="shipping_way">
                                                                        <option value="courier">
                                                                            {{ __('product.courier_pick_up') }}
                                                                        </option>
                                                                        <option value="drop_off">
                                                                            {{ __('product.drop_off') }}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="row shipment_info_div1">
                                                                        <div class="col-12">
                                                                            <label
                                                                                class="primary_label2 style2 ">{{ __('product.courier_address') }}
                                                                                <span>*</span></label>
                                                                            <select
                                                                                class="theme_select wide rounded-0 mb_30"
                                                                                name="pick_up_address_id"
                                                                                id="pick_up_address_id">
                                                                                @foreach (auth()->user()->customerAddresses as $key_num => $address)
                                                                                    <option
                                                                                        value="{{ $address->id }}">
                                                                                        {{ $address->address1 }}
                                                                                        , {{ @$address->cityDetails->name }}
                                                                                        ,
                                                                                        {{ @$address->stateDetails->name }}
                                                                                        ({{ $address->phone }})
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('pick_up_address_id')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="shipment_info_div2 row d-none col-lg-12">
                                                                    <div class="col-12">
                                                                        <label
                                                                            class="primary_label2 style2 ">{{ __('product.courier_address') }}
                                                                            <span>*</span></label>
                                                                        <input id="drop_off_courier_address"
                                                                               name="drop_off_courier_address"
                                                                               placeholder="{{ __('product.courier_address') }}"
                                                                               class="primary_input3 style4 mb_30"
                                                                               type="text">
                                                                        @error('drop_off_courier_address')
                                                                        <span
                                                                            class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="photo_uploader_lists col-lg-12">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <label
                                                                                class="primary_label2 style2 ">{{ __('product.image') }}</label>
                                                                            <div
                                                                                class="img_upload_group d-flex align-items-center flex-wrap">
                                                                                <label for="photo_12"
                                                                                       class="photo_uploader">
                                                                                    <i class="fas fa-camera"></i>
                                                                                    <p id="count_12">0/6</p>
                                                                                    <input
                                                                                        class="d-none upload_img_for_product"
                                                                                        type="file"
                                                                                        id="photo_12"
                                                                                        name="product_images_{{ @$product->giftCard->id }}[]"
                                                                                        data-upload_div="#img_upload_div_12"
                                                                                        data-count="#count_12"
                                                                                        max="6" multiple>
                                                                                </label>
                                                                                <div
                                                                                    class="flex-wrap d-flex img_upload_div ms-2"
                                                                                    id="img_upload_div_12">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit"
                                                                        class="link_value theme_btn small_btn4">{{ __('product.send') }}</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- tracking end --}}
                    </div>
                </div>
            </div>
            <!-- invoice print part end -->
        </div>
    </section>
    <!-- cancel order modal -->


    <div class="modal fade" id="orderCancelReasonModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {{ __('frontend.Enter Your Password To Continue') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('frontend.my_purchase_order_package_cancel') }}" method="post">@csrf


                    <div class="row">
                        <div class="col-md-12 mb_30">
                            <div class="form-group input_div_mb">
                                <label class="primary_label2 style4">{{ __('refund.reason') }} <span>*</span></label>
                                <select class="primary_input3 radius_3px style6" name="reason" id="reason"
                                        autocomplete="off">
                                    @foreach ($cancel_reasons as $key => $cancel_reason)
                                        <option value="{{ $cancel_reason->id }}">{{ $cancel_reason->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="order_id" name="order_id" class="form-control order_id"
                                   required>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('common.Close') }}
                        </button>
                        <button type="submit"
                                class="link_value theme_btn small_btn4">{{ __('common.send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
