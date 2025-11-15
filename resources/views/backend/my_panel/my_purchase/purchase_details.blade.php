@extends('backend.master')
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor pt-5 mt-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-9">
                    <!-- invoice print part here -->
                    <div class="white_box invoice_print pb-5">
                        <div class="container-fluid p-0">
                            <div id="invoice_print" class="invoice_part_iner">

                                <style>
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

                                        h4 {
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
                                    @php
                                        $p_total = 0;
                                        $p_qty = 0;
                                    @endphp
                                    @foreach ($packages as $key => $package)
                                        <div
                                            class="order_prise d-flex justify-content-between gap-2 flex-wrap amazy_bb2 pb_11 mb_10">
                                            <h4 class="font_16 f_w_700 m-0">{{__('product.Package')}}
                                                : {{ $package->package_code }}</h4>

                                            <h4 class="font_16 f_w_700 m-0">{{__('product.sold_by')}}
                                                : {{ $package->seller->name }} </h4>

                                            @if($package->delivery_status==4)
                                                {{-- <div class="form-check">
                                                    <label class="primary_checkbox d-flex">
                                                        <input type="checkbox" class="attr_checkbox" value="1" id="is_received" data-package_id="{{$package->id}}" data-id="{{$order->id}}">
                                                        <span class="checkmark mr_10"></span>
                                                        <span class="label_name f_w_700">{{__('product.Is Received?')}}</span>
                                                    </label>
                                                </div> --}}
                                                <ul class="permission_list sms_list">
                                                    <li>
                                                        <label class="primary_checkbox d-flex mr-12 ">
                                                            <input class="attr_checkbox" type="checkbox" value="1"
                                                                   id="is_received" data-package_id="{{$package->id}}"
                                                                   data-id="{{$order->id}}">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{__('product.Is Received?')}}</p>
                                                    </li>
                                                </ul>
                                            @endif
                                        </div>
                                        @if($package->is_cancelled == 0)
                                            <p class="font_14 f_w_400">{{ $package->shipping_date }}</p>
                                            <div class="order_details_progress ">
                                                @if($package->carrier->slug == 'Shiprocket')
                                                    @php
                                                        $status = $order_status[$package->id];
                                                        $ready_to_ship = false;
                                                        $pickup= false;
                                                        $ship= false;
                                                        $delivered= false;
                                                        switch ($status){
                                                            case "READY TO SHIP":
                                                                $ready_to_ship = true;
                                                                break;
                                                            case 'PICKUP':
                                                            $ready_to_ship = true;
                                                            $pickup= true;
                                                            break;
                                                            case 'SHIPPED':
                                                            $ready_to_ship = true;
                                                            $pickup= true;
                                                            $ship= true;
                                                            break;
                                                            case 'DELIVERED':
                                                            $ready_to_ship = true;
                                                            $pickup= true;
                                                            $ship= true;
                                                            $delivered= true;
                                                            break;
                                                        }
                                                    @endphp
                                                    <div
                                                        class="single_order_progress position-relative d-flex align-items-center flex-column">
                                                        <div class="icon position-relative order_process_icon">
                                                            @if ($package->delivery_status >= 1)
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
                                                        </div>
                                                        <h5 class="font_14 f_w_500 m-0 text-nowrap">{{__('common.pending')}}</h5>
                                                    </div>
                                                    <div
                                                        class="single_order_progress position-relative d-flex align-items-center flex-column">
                                                        <div class="icon position-relative order_process_icon">
                                                            @if ($ready_to_ship)
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
                                                            @elseif($package->delivery_status >= 1 && !$ready_to_ship)
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

                                                        </div>
                                                        <h5 class="font_14 f_w_500 m-0 text-nowrap">{{__('shipping.ready_to_ship')}}</h5>
                                                    </div>
                                                    <div
                                                        class="single_order_progress position-relative d-flex align-items-center flex-column">
                                                        <div class="icon position-relative order_process_icon">
                                                            @if ($pickup)
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
                                                            @elseif($ready_to_ship && !$pickup)
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
                                                        </div>
                                                        <h5 class="font_14 f_w_500 m-0 mute_text  text-nowrap">{{__('shipping.pickup')}}</h5>
                                                    </div>
                                                    <div
                                                        class="single_order_progress position-relative d-flex align-items-center flex-column">
                                                        <div class="icon position-relative order_process_icon">
                                                            @if ($ship)
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
                                                            @elseif($pickup && !$ship)
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
                                                        </div>
                                                        <h5 class="font_14 f_w_500 m-0 mute_text text-nowrap">{{__('common.shipped')}}</h5>
                                                    </div>
                                                    <div
                                                        class="single_order_progress position-relative d-flex align-items-center flex-column">
                                                        <div class="icon position-relative order_process_icon">
                                                            @if ($delivered)
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
                                                            @elseif($ship && !$delivered)
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
                                                        </div>
                                                        <h5 class="font_14 f_w_500 m-0 mute_text text-nowrap">{{__('order.delivered')}}</h5>
                                                    </div>
                                                @else
                                                    @php
                                                        $next_step = null;
                                                    @endphp
                                                    @foreach ($processes as $key => $process)
                                                        <div
                                                            class="single_order_progress position-relative d-flex align-items-center flex-column">
                                                            <div class="icon position-relative order_process_icon">

                                                                @if ($package->delivery_status >= $process->id)
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30"
                                                                         height="30" viewBox="0 0 30 30">
                                                                        <g data-name="1"
                                                                           transform="translate(-613 -335)">
                                                                            <circle data-name="Ellipse 239" cx="15"
                                                                                    cy="15" r="15"
                                                                                    transform="translate(613 335)"
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
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             width="30" height="30" viewBox="0 0 30 30">
                                                                            <g data-name="1"
                                                                               transform="translate(-613 -335)">
                                                                                <g data-name="Ellipse 239"
                                                                                   transform="translate(613 335)"
                                                                                   fill="none" stroke="#50cd89"
                                                                                   stroke-width="2">
                                                                                    <circle cx="15" cy="15" r="15"
                                                                                            stroke="none"></circle>
                                                                                    <circle cx="15" cy="15" r="14"
                                                                                            fill="none"></circle>
                                                                                </g>
                                                                                <circle data-name="Ellipse 240" cx="5"
                                                                                        cy="5" r="5"
                                                                                        transform="translate(623 345)"
                                                                                        fill="#50cd89"></circle>
                                                                            </g>
                                                                        </svg>
                                                                    @else
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             width="30" height="30" viewBox="0 0 30 30">
                                                                            <g data-name="1"
                                                                               transform="translate(-613 -335)">
                                                                                <g data-name="Ellipse 239"
                                                                                   transform="translate(613 335)"
                                                                                   fill="none" stroke="#f1ece8"
                                                                                   stroke-width="2">
                                                                                    <circle cx="15" cy="15" r="15"
                                                                                            stroke="none"></circle>
                                                                                    <circle cx="15" cy="15" r="14"
                                                                                            fill="none"></circle>
                                                                                </g>
                                                                                <circle data-name="Ellipse 240" cx="5"
                                                                                        cy="5" r="5"
                                                                                        transform="translate(623 345)"
                                                                                        fill="#f1ece8"></circle>
                                                                            </g>
                                                                        </svg>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            <h5 class="font_14 f_w_500 m-0 text-nowrap">{{ $process->name }}</h5>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div
                                                class="d-flex align-items-center gap_20 flex-wrap gray_color_1 dashboard_orderDetails_head  justify-content-between theme_border">
                                                <div class="d-flex flex-column ">
                                                    <div class="d-flex align-items-center flex-wrap gap_5">
                                                        <h4 class="font_14 f_w_500 m-0 lh-base">{{__('product.package_code')}}
                                                            : </h4>
                                                        <p class="font_14 f_w_400 m-0 lh-base"> {{ $package->package_code }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div
                                                class="d-flex align-items-center gap_20 flex-wrap gray_color_1 dashboard_orderDetails_head  justify-content-between theme_border">
                                                <h5 class="text-danger mt_20 w-100 text-center">{{__('product.order_cancelled')}}</h5>
                                            </div>
                                        @endif

                                        <div class="table-responsive mb_10">
                                            <table class="table style2 mb-0">
                                                <tbody>
                                                @php
                                                    $physical_product = 0;
                                                    $total = 0;
                                                    $qty = 0;
                                                    $all_product = Modules\Store\Entities\OrderPackageDetail::where(['order_id' => $enroll->id , 'seller_id' => $package->seller_id])->get();
                                                @endphp
                                                @foreach ($all_product as $key => $package_product)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ courseDetailsUrl(@$package_product->course->id, @$package_product->course->type, @$package_product->course->slug) }}"
                                                               class="d-flex align-items-center gap_20 cart_thumb_div">

                                                                <img class="img-fluid product_img"
                                                                     src="{{ getCourseImage($package_product->course->image) }}"
                                                                     alt="" title="">

                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="summery_pro_content">
                                                                <h4 class="font_16 f_w_700 text-nowrap m-0 theme_hover">{{ @$package_product->course->title }}</h4>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h4 class="font_16 f_w_500 m-0 text-nowrap">{{__('product.qty')}}
                                                                : {{ $package_product->number_of_product }}</h4>
                                                        </td>
                                                        <td>
                                                            <h4 class="font_16 f_w_500 m-0 text-nowrap">
                                                                @php
                                                                    $price = $package_product->course->discount_price != 0 ? $package_product->course->discount_price : $package_product->course->price;

                                                                    if ($package_product->is_store == 1) {
                                                                        $price1 = $package_product->course->discount_price != 0 ? $package_product->course->discount_price : $package_product->course->price;
                                                                        $price = $price1 * $package_product->number_of_product;
                                                                    } else {
                                                                        $price = $package_product->course->discount_price != 0 ? $package_product->course->discount_price : $package_product->course->price;
                                                                        $price1 = $price;
                                                                    }
                                                                    $total = $total + $price;
                                                                    $qty = $qty+$package_product->tax_amount;
                                                                @endphp

                                                                {{ getPriceFormat($price) }}
                                                            </h4>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @php
                                                    $p_total = $p_total + $total;
                                                    if (isModuleActive('Tax')) {
                                                        $p_qty = $p_qty + $qty;
                                                    }
                                                @endphp
                                                </tbody>
                                            </table>
                                            <div class="d-flex flex-column mt_10">
                                                <div
                                                    class="d-flex align-items-center flex-wrap gap_5 justify-content-end">
                                                    @if ($order->is_confirmed == 0 && $package->is_cancelled == 0 || $order->is_confirmed == 1 && $package->is_cancelled == 0 && $package->delivery_status <= 2)
                                                        <a href="javascript:void(0)"
                                                           data-id="{{ $package->id }}" class="amaz_primary_btn
                                                           gray_bg_btn radius_3px order_cancel_by_id
                                                        ">{{__('product.cancel_order')}}</a>
                                                    @elseif ($order->is_completed == 1 || $package->delivery_status >= 5)
                                                        @if (\Carbon\Carbon::now() <= $order->created_at->addDays(Settings('refund_times')) && $package->is_cancelled == 0 && $package->course->product->type == 2 && !$package->refundPackage && Settings('refund_status'))
                                                            <a href="{{ route('users.instructor_make_request', encrypt($package->id)) }}"
                                                               class="amaz_primary_btn gray_bg_btn radius_3px">{{__('product.open_dispute')}}</a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($package->carrier->type == 'Manual' && $package->carrier_order_id)
                                        <div
                                            class="d-flex align-items-center gap_20 flex-wrap gray_color_1 dashboard_orderDetails_head  justify-content-between theme_border">
                                            <div class="d-flex flex-column ">
                                                <div class="d-flex align-items-center flex-wrap gap_5">
                                                    <h4 class="font_14 f_w_500 m-0 lh-base">{{__('shipping.shipping_by')}}
                                                        : </h4>
                                                    <p class="font_14 f_w_400 m-0 lh-base"> {{@$package->carrier->name }}</p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column  ">
                                                <div class="d-flex align-items-center flex-wrap gap_5">
                                                    <h4 class="font_14 f_w_500 m-0 lh-base">{{__('shipping.tracking_id')}}
                                                        : </h4>
                                                    <p class="font_14 f_w_400 m-0 lh-base"> {{@$package->carrier_order_id }}</p>
                                                </div>
                                            </div>
                                            @if(@$package->carrier->tracking_url)
                                                <div class="d-flex flex-column  ">
                                                    <div class="d-flex align-items-center flex-wrap gap_5">
                                                        <h4 class="font_14 f_w_500 m-0 lh-base">{{__('shipping.tracking_url')}}
                                                            : </h4> <a class="font_14 f_w_400 m-0 lh-base text_color"
                                                                       target="_blank"
                                                                       href="{{ str_replace("@",@$package->carrier_order_id,$package->carrier->tracking_url)}}"> {{__('common.click_here')}}</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="row mt-30">

                                        <div class="col-md-6 col-lg-6">
                                            <table class="table-borderless clone_line_table">
                                                <tr>
                                                    <td><strong>{{ __('product.Billing Info') }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.Name') }}</td>
                                                    <td>
                                                        : {{ @$enroll->bill->first_name }} {{ @$enroll->bill->last_name }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.Phone') }}</td>
                                                    <td>: {{ @$enroll->bill->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.Address') }}</td>
                                                    <td>: {{ @$enroll->bill->address1 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.Address') }} 2</td>
                                                    <td>: {{ @$enroll->bill->address2 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.Country') }}</td>
                                                    <td>: {{ @$enroll->bill->countryDetails->name }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.City') }}</td>
                                                    <td>: {{ @$enroll->bill->cityDetails->name }} </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-md-6 col-lg-6">
                                            <table class="table-borderless clone_line_table">
                                                <tr>
                                                    <td>
                                                        <strong>{{ __('product.Shipping Info') }} @if ($enroll->delivery_type == 'pickup_location')
                                                                (Collect from Pickup location)
                                                            @endif
                                                        </strong></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.Name') }}</td>
                                                    <td>
                                                        : {{ @$enroll->bill->first_name }} {{ @$enroll->bill->last_name }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.Phone') }}</td>
                                                    <td>: {{ @$enroll->bill->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.Address') }}</td>
                                                    <td>: {{ @$enroll->bill->address1 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.Address') }} 2</td>
                                                    <td>: {{ @$enroll->bill->address2 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.Country') }}</td>
                                                    <td>: {{ @$enroll->bill->countryDetails->name }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.City') }}</td>
                                                    <td>: {{ @$enroll->bill->cityDetails->name }} </td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>

                                    <div class="row mt-30">

                                        <div class="col-md-6 col-lg-6">
                                            <table class="table-borderless clone_line_table">
                                                <tr>
                                                    <td><strong>{{ __('product.Payment Info') }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('product.Payment Method') }}</td>
                                                    <td>: {{ $enroll->payment_method }}</td>
                                                </tr>

                                                <tr>
                                                    <td>{{ __('product.Tracking Id') }}</td>
                                                    <td>: {{ @$enroll->tracking }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.Date') }}</td>
                                                    <td>:
                                                        {{ showDate($enroll->updated_at) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('product.Payment Status') }}</td>
                                                    <td>:
                                                        @if ($enroll->is_paid == 1)
                                                            <span>{{ __('common.Paid') }}</span>
                                                        @else
                                                            <span>{{ __('common.Pending') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if(hasTax())
                                                    <tr>
                                                        <td>{{ __('product.Tax') }}</td>
                                                        <td>:
                                                            {{$enroll->tax==0?0:getPriceFormat($p_qty)}}
                                                            {{-- {{$enroll->tax==0?0:getPriceFormat($enroll->tax)}} --}}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>{{ __('common.Total') }}</td>
                                                    <td>:
                                                        {{ getPriceFormat($p_qty + $p_total + $enroll->shipping_cost) }}
                                                        {{-- {{getPriceFormat($enroll->purchase_price)}} --}}
                                                    </td>
                                                </tr>


                                            </table>
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
                        {{__('product.cancel_order')}}</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('frontend.my_purchase_order_package_cancel')}}"
                      method="post">@csrf


                    <div class="col-xl-12 p-3">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('product.reason') }} </label>
                            <select class="primary_select mb-25" name="reason" id="reason" autocomplete="off">
                                @foreach ($cancel_reasons as $key => $cancel_reason)
                                    <option value="{{ $cancel_reason->id }}">{{ $cancel_reason->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <input type="hidden" id="order_id" name="order_id" class="form-control order_id" required>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{__('common.Close')}}
                        </button>
                        <button type="submit" class="primary-btn small_btn4 fix-gr-bg"><i
                                class="ti-check"></i>
                            {{__('common.Send')}}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.order_cancel_by_id', function (e) {
                e.preventDefault();
                $('#orderCancelReasonModal').modal('show');
                $('.order_id').val($(this).attr('data-id'));
            });

            $(document).on('click', '#is_received', function () {
                var order_id = $(this).data('id');
                var package_id = $(this).data('package_id');
                // console.log(order_id);
                $("#pre-loader").show();
                $.post('{{ route('users.change_receive_status_by_customer') }}', {
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    package_id: package_id
                }, function (data) {
                    if (data == 1) {
                        toastr.success("{{__('product.order_has_been_recieved')}}", "{{__('common.Success')}}");
                    } else {
                        toastr.error("{{__('product.order_not_recieved')}} {{__('common.error_message')}}", "{{__('common.Error')}}");
                    }
                    $("#pre-loader").hide();
                    window.location.reload();
                });
            });

        });
    </script>
@endpush
