<div>
    <section class="admin-visitor-area up_st_admin_visitor pt-5 mt-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-9">
                    <div class="box_header common_table_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 ml-10 text-uppercase">INV-{{$enroll->id+1000}}</h3>
                        </div>
                    </div>

                    <!-- invoice print part here -->
                    <div class="invoice_print pb-5">
                        <div class="container-fluid p-0">
                            <div id="invoice_print" class="invoice_part_iner">

                                <style>
                                    .shipping_gatway {
                                        /* font-size: 16px; */
                                        padding-top: 7px;
                                    }

                                    p.font_14 {
                                        margin-left: 5px !important;
                                        margin-top: 3px !important;
                                    }


                                    .invoice_part_iner b {
                                        font-size: 18px;
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

                                    .order_prise .form-check {
                                        margin-right: 50px;
                                    }

                                    .product_img {
                                        height: 50px;
                                    }

                                    .thumb {
                                        width: 100px !important;
                                    }

                                    @media print {
                                        .table {
                                            width: 100%;
                                            margin-bottom: 1rem;
                                            color: #212529;
                                            font-family: Jost, sans-serif;
                                        }

                                        td h3 {
                                            font-size: 24px;
                                            font-weight: 500;
                                            color: var(--system_secendory_color);
                                        }

                                        .w-50 {
                                            width: 50% !important;
                                        }

                                        .invoice_grid {
                                            display: grid;
                                            grid-template-columns: 90px auto;
                                            margin-bottom: 10px;
                                            grid-gap: 25px;
                                        }

                                        b {
                                            line-height: 25px;
                                        }

                                        .custom_table3 {
                                            border-radius: 5px;
                                            background-color: red;
                                        }

                                        .custom_table3 tr {
                                            border-bottom: 1px solid #f1f2f3;
                                        }

                                        .table tr th {
                                            background-color: #fafafa !important;
                                        }

                                        .table thead th {
                                            vertical-align: bottom;
                                        }

                                        .table.custom_table3 thead tr th {
                                            font-weight: 600;
                                            border-top: 0;
                                            font-family: Cerebri Sans;
                                            padding: 15px 30px 15px 0;
                                        }

                                        .table.custom_table3 tbody tr td,
                                        .table.custom_table3 thead tr th {
                                            font-size: 16px;
                                            color: #373737;
                                            white-space: nowrap;
                                        }

                                        th p span,
                                        td p span {
                                            color: #212E40;
                                        }

                                        .text-end {
                                            text-align: right !important;
                                        }

                                    }
                                </style>
                                <table style=" margin-bottom: 30px" class="table">
                                    <tbody>
                                    <td>
                                        <img style="width: 108px" src="{{getCourseImage(Settings('logo') )}}"
                                             alt="{{ Settings('site_name')  }}">
                                    </td>
                                    <td style="text-align: right">
                                        <h3 class="invoice_no black_color" style=" margin-bottom: 10px" ;>
                                            INV-{{$enroll->id+1000}}</h3>
                                    </td>
                                    </tbody>
                                </table>
                                {{-- tracking start --}}
                                <div class="dashboard_white_box_body dashboard_orderDetails_body">
                                    @foreach ($refund_request->refund_details as $key => $refund_detail)
                                        <div class="order_details_progress style2">
                                            @php
                                                $next_step = null;
                                            @endphp
                                            @foreach ($processes as $key => $process)
                                                <div
                                                    class="single_order_progress position-relative d-flex align-items-center flex-column">
                                                    <div class="icon position-relative ">
                                                        @if ($refund_detail->processing_state >= $process->id)
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                                 height="30" viewBox="0 0 30 30">
                                                                <g data-name="1" transform="translate(-613 -335)">
                                                                    <circle data-name="Ellipse 239" cx="15" cy="15"
                                                                            r="15" transform="translate(613 335)"
                                                                            fill="#50cd89"></circle>
                                                                    <path data-name="Path 4193"
                                                                          d="M95.541,18.379a1.528,1.528,0,0,1-1.16-.533l-3.665-4.276a1.527,1.527,0,0,1,2.319-1.988l2.4,2.8L103,5.245c1.172-1.642,2.4-.733,1.222.916L96.784,17.739a1.528,1.528,0,0,1-1.175.638Z"
                                                                          transform="translate(530.651 338.622)"
                                                                          fill="#fff"></path>
                                                                </g>
                                                            </svg>
                                                            @php
                                                                $next_step = $key + 1;
                                                            @endphp
                                                        @else
                                                            @if($next_step == $key)
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                                     height="30" viewBox="0 0 30 30">
                                                                    <g data-name="1" transform="translate(-613 -335)">
                                                                        <g data-name="Ellipse 239"
                                                                           transform="translate(613 335)" fill="none"
                                                                           stroke="#50cd89" stroke-width="2">
                                                                            <circle cx="15" cy="15" r="15"
                                                                                    stroke="none"></circle>
                                                                            <circle cx="15" cy="15" r="14"
                                                                                    fill="none"></circle>
                                                                        </g>
                                                                        <circle data-name="Ellipse 240" cx="5" cy="5"
                                                                                r="5" transform="translate(623 345)"
                                                                                fill="#50cd89"></circle>
                                                                    </g>
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                                     height="30" viewBox="0 0 30 30">
                                                                    <g data-name="1" transform="translate(-613 -335)">
                                                                        <g data-name="Ellipse 239"
                                                                           transform="translate(613 335)" fill="none"
                                                                           stroke="#f1ece8" stroke-width="2">
                                                                            <circle cx="15" cy="15" r="15"
                                                                                    stroke="none"></circle>
                                                                            <circle cx="15" cy="15" r="14"
                                                                                    fill="none"></circle>
                                                                        </g>
                                                                        <circle data-name="Ellipse 240" cx="5" cy="5"
                                                                                r="5" transform="translate(623 345)"
                                                                                fill="#f1ece8"></circle>
                                                                    </g>
                                                                </svg>
                                                            @endif

                                                        @endif
                                                    </div>
                                                    <h5 class=" text-nowrap">{{ $process->name }}</h5>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div
                                            class="d-flex align-items-center gap_20 flex-wrap gray_color_1 dashboard_orderDetails_head  justify-content-between theme_border">
                                            <div class="d-flex flex-column  ">
                                                <div class="d-flex align-items-center flex-wrap gap_5">
                                                    <b class=" lh-base">{{__('product.order_id')}}
                                                        <span class="pe-2">:</span> </b>
                                                    <p class=" lh-base">{{ $refund_request->order->order_number }}</p>
                                                </div>
                                                <div class="d-flex align-items-center flex-wrap gap_5">
                                                    <b class=" lh-base">{{__('product.order_date')}}
                                                        <span class="pe-2">:</span> </b>
                                                    <p class=" lh-base">{{ $refund_request->order->created_at->format('d-m-Y h:i:s A') }}</p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column ">
                                                <div class="d-flex align-items-center flex-wrap gap_5">
                                                    <b class=" lh-base">{{__('product.Status')}}
                                                        <span class="pe-2">:</span> </b>
                                                    <p class=" lh-base"> {{ $refund_request->CheckConfirmed }}</p>
                                                </div>
                                                <div class="d-flex align-items-center flex-wrap gap_5">
                                                    <b class=" lh-base">{{__('product.request_sent_date')}}
                                                        <span class="pe-2">:</span> </b>
                                                    <p class=" lh-base"> {{ $refund_request->created_at->format('d-m-Y h:i:s A') }} </p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column  ">
                                                <div class="d-flex align-items-center flex-wrap gap_5">
                                                    <b class=" lh-base">{{__('product.order_amount')}}
                                                        <span class="pe-2">:</span> </b>
                                                    <p class=" lh-base"> {{ single_price( $refund_request->total_return_amount) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive mb-5 mt-5">
                                            <table class="table amazy_table3 style2 mb-0">
                                                <tbody>
                                                {{-- @dd($refund_detail->refund_products) --}}
                                                @foreach ($refund_detail->refund_products as $key => $refund_product)

                                                    <tr>
                                                        <td>
                                                            <a href="{{ courseDetailsUrl(@$refund_product->product->id, @$refund_product->product->type, @$refund_product->product->slug) }}"
                                                               class="d-flex align-items-center gap_20 cart_thumb_div">
                                                                <div class="thumb">
                                                                    <img class="img-fluid"
                                                                         src="{{ getCourseImage($refund_product->product->image) }}"
                                                                         alt="" title="">
                                                                </div>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="summery_pro_content">
                                                                <h5 class="font_16 f_w_700 text-nowrap m-0 theme_hover">{{ @$refund_product->product->title }}</h5>

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font_16 f_w_500 m-0 text-nowrap">{{__('product.qty')}}
                                                                : {{ $refund_product->return_qty }}</h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="font_16 f_w_500 m-0 text-nowrap">
                                                                @php
                                                                    if ($refund_product->product->discount_price != null) {
                                                                        $price = $refund_product->product->discount_price;
                                                                    } else {
                                                                        $price = $refund_product->product->price;
                                                                    }
                                                                @endphp
                                                                {{ getPriceFormat($price) }}
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach

                                    <div
                                        class="d-flex align-items-center gap_20 mb_20 flex-wrap gray_color_1 dashboard_orderDetails_head2  justify-content-between theme_border">
                                        <div class="d-flex flex-column  ">
                                            <div class="d-flex align-items-center flex-wrap gap_5 mb_7">
                                                <b class=" lh-base">{{__('product.order_id')}}
                                                    <span class="pe-2">:</span> </b>
                                                <p class=" lh-base">{{ $refund_request->order->order_number }}</p>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap gap_5 mb_7">
                                                <b class=" lh-base">{{__('product.order_date')}}
                                                    <span class="pe-2">:</span> </b>
                                                <p class=" lh-base">{{ $refund_request->order->created_at->format('d-m-Y h:i:s A') }}</p>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap gap_5">
                                                <b class=" lh-base">{{__('product.refund_method')}}
                                                    <span class="pe-2">:</span> </b>
                                                <p class=" lh-base">{{ strtoupper(str_replace("_"," ",$refund_request->refund_method)) }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column ">
                                            <div class="d-flex align-items-center flex-wrap gap_5 mb_7">
                                                <b class=" lh-base">{{__('product.Status')}}<span class="pe-2">:</span> </b>
                                                <p class=" lh-base"> {{ $refund_request->CheckConfirmed }}</p>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap gap_5 mb_7">
                                                <b class=" lh-base">{{__('product.request_sent_date')}}
                                                    <span class="pe-2">:</span> </b>
                                                <p class=" lh-base"> {{ $refund_request->created_at->format('d-m-Y h:i:s A') }}</p>
                                            </div>
                                            <div class="d-flex align-items-center flex-wrap gap_5">
                                                <b class=" lh-base">{{__('product.shipping_method')}}
                                                    <span class="pe-2">:</span> </b>
                                                <p class=" lh-base"> {{ strtoupper(str_replace("_"," ",$refund_request->shipping_method)) }} </p>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column  ">
                                            <div class="d-flex align-items-center flex-wrap gap_5">
                                                <b class=" lh-base">{{__('product.order_amount')}}
                                                    <span class="pe-2">:</span> </b>
                                                <p class=" lh-base"> {{ getPriceFormat( $refund_request->total_return_amount) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order_details_list_box">
                                        <div class="summery_order_body d-flex flex-wrap">
                                            @if ($refund_request->shipping_method == "courier")
                                                <div class="summery_lists flex-fill">
                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <b class="font_16 f_w_700 text-nowrap m-0 theme_hover">{{__('product.pick_up_info')}} </b>
                                                        </div>
                                                    </div>
                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <h5 class="">{{__('product.shipping_gateway')}}</h5>
                                                            <span class="pe-2">:</span>
                                                        </div>
                                                        <p class="">{{ @$refund_request->shipping_gateway->method_name }}</p>
                                                    </div>
                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <h5 class="">{{__('product.name')}}</h5>
                                                            <span class="pe-2">:</span>
                                                        </div>
                                                        <p class="">{{ @$refund_request->pick_up_address_customer->name }}</p>
                                                    </div>
                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <h5 class="">{{__('product.email')}} </h5>
                                                            <span class="pe-2">:</span>
                                                        </div>
                                                        <p class="">{{ @$refund_request->pick_up_address_customer->email }}</p>
                                                    </div>
                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <h5 class="">{{__('product.phone_number')}}</h5>
                                                            <span class="pe-2">:</span>
                                                        </div>
                                                        <p class="">{{ @$refund_request->pick_up_address_customer->phone }}</p>
                                                    </div>
                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <h5 class="">{{__('product.address')}}</h5>
                                                            <span class="pe-2">:</span>
                                                        </div>
                                                        <p class="">
                                                            {{ @$refund_request->pick_up_address_customer->address1 }}
                                                            {{ @$refund_request->pick_up_address_customer->address2 }}
                                                        </p>
                                                    </div>

                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <h5 class="">{{__('product.city')}}</h5>
                                                            <span class="pe-2">:</span>
                                                        </div>
                                                        <p class="">{{ @$refund_request->pick_up_address_customer->cityDetails->name }}</p>
                                                    </div>
                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <h5 class="">{{__('product.state')}}</h5>
                                                            <span class="pe-2">:</span>
                                                        </div>
                                                        <p class="">{{ @$refund_request->pick_up_address_customer->stateDetails->name }}</p>
                                                    </div>
                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <h5 class="">{{__('product.postcode')}}</h5>
                                                            <span class="pe-2">:</span>
                                                        </div>
                                                        <p class=""> {{ @$refund_request->pick_up_address_customer->zip_code }}</p>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="summery_lists flex-fill">
                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <b class="font_16 f_w_700 text-nowrap m-0 theme_hover">{{__('product.drop_off_info')}} </b>
                                                        </div>
                                                    </div>
                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <h5 class=" shipping_gatway">{{__('product.shipping_gateway')}}
                                                                : </h5>
                                                        </div>
                                                        <p class="">{{ @$refund_request->shipping_gateway->method_name }}</p>
                                                    </div>
                                                    <div class="single_summery_list d-flex align-items-start gap_20">
                                                        <div
                                                            class="order_text_head d-flex align-items-center justify-content-between font_14 f_w_500 ">
                                                            <h5 class=" shipping_gatway">{{__('product.address')}}
                                                                : </h5>
                                                        </div>
                                                        <p class="">{{ $refund_request->drop_off_address }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- tracking end --}}
                            </div>
                        </div>
                    </div>
                    <!-- invoice print part end -->
                </div>
            </div>
        </div>
    </section>
    <!-- cancel order modal -->


    <div class="modal fade" id="orderCancelReasonModal" tabindex="-1"
         role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {{__('frontend.Enter Your Password To Continue')}}</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('frontend.my_purchase_order_package_cancel')}}"
                      method="post">@csrf


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
                            <input type="hidden" id="order_id" name="order_id" class="form-control order_id" required>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{__('product.Close')}}
                        </button>
                        <button type="submit"
                                class="link_value theme_btn small_btn4">{{__('product.send')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- cancel order modal -->
    <div id="editor"></div>
</div>
