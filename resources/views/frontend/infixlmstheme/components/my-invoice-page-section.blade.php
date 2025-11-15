@php use Modules\Store\Entities\ProductSku; @endphp
<div>
    <section class="admin-visitor-area up_st_admin_visitor pt-5 mt-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-9">
                    <div class="box_header common_table_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 ml-10 text-uppercase">INV-{{ $enroll->id + 1000 }}</h3>
                        </div>
                        <div class="table_btn_wrap">
                            <ul>
                                <li>
                                    <button class="primary_btn printBtn">{{ __('student.Print') }}</button>
                                </li>
                                <li>
                                    <button class="primary_btn downloadBtn">{{ __('student.Download') }}</button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- invoice print part here -->
                    <div class="invoice_print pb-5">
                        <div class="container-fluid p-0">
                            <div id="invoice_print" class="invoice_part_iner">

                                <style>
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
                                            /*background-color: red;*/
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

                                    .text_alignment {
                                        text-align: left
                                    }

                                    html[dir=rtl] .text_alignment {
                                        text-align: right
                                    }

                                    .basic_padding {
                                        padding-left: 15px;
                                    }

                                    html[dir=rtl] .table thead th {
                                        padding-right: 15px !important;
                                    }

                                    table thead tr th:nth-last-child(2), table tbody tr td:nth-last-child(2) {
                                        width: 20%;
                                        min-width: 150px;
                                    }

                                    html[dir=rtl] .text-end {
                                        text-align: left !important;
                                    }
                                </style>
                                <table style=" margin-bottom: 30px" class="table">
                                    <tbody>
                                    <td>
                                        <img style="width: 108px" src="{{ getCourseImage(Settings('logo')) }}"
                                             alt="{{ Settings('site_name') }}">
                                    </td>
                                    <td style="text-align: right">
                                        <h3 class="invoice_no black_color" style=" margin-bottom: 10px" ;>
                                            INV-{{ $enroll->id + 1000 }}</h3>
                                    </td>
                                    </tbody>
                                </table>

                                <table style="margin-bottom: 0 !important;" class="table">
                                    <tbody>
                                    <tr>
                                        <td class="w-50">
                                            @if (isModuleActive('Store'))
                                                <p class="invoice_grid"
                                                   style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                        <span class="black_color">{{ __('product.Order ID') }}:
                                                        </span><span>{{ @$enroll->order_number }}</span>
                                                </p>
                                            @endif

                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                    <span class="black_color">{{ __('student.Date') }}:
                                                    </span><span>{{ date('d F Y', strtotime(@$enroll->created_at)) }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                    <span class="black_color">{{ __('student.Pay Method') }}:
                                                    </span><span>
                                                    @if($enroll->payment_method=='Wallet')
                                                        {{__('payment.Wallet')}}
                                                    @else
                                                        {{ $enroll->payment_method }}
                                                    @endif
                                                </span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                @if ($enroll->courses->sum('purchase_price') == 0)
                                                    <span class="black_color">{{ __('student.Status') }}: </span>
                                                    <span class="black_color">{{ __('common.Paid') }}</span>

                                                @else
                                                    <span class="black_color">{{ __('student.Status') }}: </span>
                                                    @php
                                                        if (isModuleActive('Store')) {
                                                            $is_paid = $enroll->status == 1 && $enroll->is_paid == 1;
                                                        }else {
                                                            $is_paid = $enroll->status == 1;
                                                        }
                                                    @endphp
                                                    <span
                                                        class="black_color">{{ $is_paid ? __('student.Paid') : __('student.Unpaid') }}</span>
                                            </p>
                                            @endif
                                        </td>
                                        <td>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                    <span class="black_color">{{ __('student.Company') }}:
                                                    </span><span>{{ Settings('site_title') }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                    <span class="black_color">{{ __('student.Phone') }}:
                                                    </span><span>{{ Settings('phone') }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                    <span class="black_color">{{ __('student.Email') }}:
                                                    </span><span>{{ Settings('email') }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                    <span class="black_color">{{ __('student.Address') }}:
                                                    </span><span>{{ Settings('address') }}</span>
                                            </p>
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                                @if($enroll->purchase_price!= 0)
                                    <h4 style=" font-size: 16px; font-weight: 500; color: #000000; margin-top: 0; margin-bottom: 3px "
                                        class="black_color" ;>{{ __('student.Billed To') }},</h4>

                                    <table style="margin-bottom: 35px !important;" class="table">
                                        <tbody>
                                        <td>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                <span class="black_color">{{ __('student.Name') }}: </span><span>
                                                    {{ @$enroll->bill->first_name }}
                                                    {{ @$enroll->bill->last_name }}</span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                <span class="black_color">{{ __('student.Phone') }}: </span><span>
                                                    {{ @$enroll->bill->phone }} </span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                <span class="black_color">{{ __('student.Email') }}: </span><span>
                                                    {{ @$enroll->bill->email }} </span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                <span class="black_color">{{__('frontend.Company Name')}}: </span><span>
                                                    {{ @$enroll->bill->company_name }} </span>
                                            </p>
                                            <p class="invoice_grid"
                                               style="font-size:14px; font-weight: 400; color:#3C4777;">
                                                <span class="black_color">{{ __('student.Address') }}: </span>
                                                <span class="black_color">
                                                    {{ @$enroll->bill->address1 }} {{ @$enroll->bill->address2 }}
                                                    {{ @$enroll->bill->cityDetails->name }}
                                                    {{ @$enroll->bill->zip_code }}
                                                    {{ @$enroll->bill->countryDetails->name }}
                                                </span>
                                            </p>
                                        </td>
                                        </tbody>
                                    </table>
                                @endif
                                <h2 style=" font-size: 18px; font-weight: 500; color: #000000; margin-top: 50px; margin-bottom: 33px "
                                    class="black_color" ;>{{ __('student.Order List') }}</h2>

                                <table class="table custom_table3 mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text_alignment">
                                                <span class="ps-3">
                                                    {{ __('common.SL') }}
                                                </span>
                                        </th>
                                        <th colspan="2" scope="col"
                                            class="black_color text_alignment">{{ __('courses.Course') }}
                                            / {{ __('student.Product') }} {{ __('common.Name') }}</th>

                                        @if (isModuleActive('Store'))
                                            <th scope="col" class="black_color">{{ __('product.Type') }}</th>
                                            <th scope="col" class="black_color">{{ __('student.Quantity') }}
                                            </th>
                                        @endif

                                        <th scope="col" class="black_color">{{ __('student.Price') }}</th>
                                        <th colspan="2" scope="col"
                                            class="black_color text_alignment">{{ __('student.Total') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $total = 0;
                                        $language_code = auth()->user()->language_code ?? 'en';
                                        $sl = 1;
                                    @endphp
                                    @if(isModuleActive('Appointment') && $enroll->type=='appointment')
                                        @if (isset($enroll->bookings))
                                            @foreach ($enroll->bookings as $key => $item)
                                                <tr>
                                                    <td class="black_color">
                                                        <span class="ps-3">
                                                            {{ $sl++ }}
                                                        </span>
                                                    </td>
                                                    <td colspan="2" class="text_alignment">
                                                        <h5 class="black_color">
                                                            {{ @$item->userInfo->name }}
                                                            - {{showDate($item->schedule->schedule_date)}}                                                        </h5>
                                                    </td>

                                                    @php
                                                        $price = $item->purchase_price;

                                                                        $total = $total + $price;
                                                    @endphp
                                                    @if (isModuleActive('Store'))
                                                        <td>{{trans('common.N/A')}}</td>
                                                        <td>{{translatedNumber(1)}}</td>
                                                    @endif
                                                    <td class="black_color text_alignment">
                                                        {{ getPriceFormat($price,false) }}</td>
                                                    <td class="black_color text_alignment">
                                                        {{ getPriceFormat($price,false) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @elseif (isModuleActive('Gift') && $enroll->courses->count() < $enroll->cart_count)
                                        @foreach ($enroll->gifts as $gift)
                                            <tr>
                                                <td class="black_color">
                                                        <span class="ps-3">
                                                            {{ $sl++ }}
                                                        </span>
                                                </td>
                                                <td colspan="2" class="text_alignment">
                                                    <h5 class="black_color">
                                                        {{ @$gift->course->getTranslation('title', $language_code) }}
                                                    </h5>
                                                </td>
                                                @php
                                                    $price = $gift->course->discount_price != 0 ? $gift->course->discount_price : $gift->course->price;
                                                    $total = $total + $price;
                                                @endphp
                                                <td class="black_color text_alignment">
                                                    {{ getPriceFormat($gift->price,false) }}</td>
                                            </tr>
                                        @endforeach

                                    @else
                                        @if (isset($enroll->courses))
                                            @foreach ($enroll->courses as $key => $item)
                                                <tr>
                                                    <td class="black_color">
                                                        <span class="ps-3">
                                                            {{ $sl++ }}
                                                        </span>
                                                    </td>
                                                    <td colspan="2" class="text_alignment">
                                                        <h5 class="black_color">
                                                            {{ @$item->course->getTranslation('title', $language_code) }}
                                                        </h5>
                                                    </td>
                                                    @if (isModuleActive('Store'))
                                                        <td class="black_color">
                                                            {{ $item->is_store ? ($item->course->product->type == 2 ? __('product.Physical') : __('product.Virtual')) : __('product.Virtual') }}
                                                        </td>
                                                        <td class="black_color">
                                                            {{ $item->qty>0?$item->qty:1 }}
                                                        </td>
                                                    @endif
                                                    @php
                                                        $price1  =$item->purchase_price;
                                                        $price  =$item->purchase_price * ($item->qty??1);
                                                        $total = $total + $price;
                                                    @endphp
                                                    <td class="black_color text_alignment">
                                                        {{ getPriceFormat($price1,false) }}</td>
                                                    {{-- <td style="text-align: left"
                                                    class="black_color">{{ getPriceFormat($price1) }}</td> --}}
                                                    <td class="black_color text_alignment">
                                                        {{ getPriceFormat($price,false) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endif


                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        @if (isModuleActive('Store'))
                                            <td></td>
                                            <td></td>
                                        @endif
                                        <td class="text-end">{{ __('student.Sub Total') }}</td>
                                        <td>{{ getPriceFormat($total,false) }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        @if (isModuleActive('Store'))
                                            <td></td>
                                            <td></td>
                                        @endif
                                        <td class="text-end">{{ __('common.Discount') }}</td>
                                        @if ($enroll->discount == 0)
                                            <td>0</td>
                                        @else
                                            <td>{{ getPriceFormat($enroll->discount,false) }}</td>
                                        @endif
                                    </tr>
                                    @if (isModuleActive('Store'))
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end">{{ __('product.shipping_charge') }}</td>
                                            <td>{{ getPriceFormat($enroll->shipping_cost,false) }}</td>
                                        </tr>
                                    @endif
                                    @if (hasTax())
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            @if (isModuleActive('Store'))
                                                <td></td>
                                                <td></td>
                                            @endif
                                            <td class="text-end">{{ __('tax.TAX') }}</td>
                                            <td>{{ $enroll->tax == 0 ? 0 : getPriceFormat($enroll->tax,false) }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        @if (isModuleActive('Store'))
                                            <td></td>
                                            <td></td>
                                        @endif
                                        <td class="text-end">{{ __('student.Total') }}</td>
                                        <td>{{ getPriceFormat($enroll->purchase_price,false) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="editor"></div>
</div>
