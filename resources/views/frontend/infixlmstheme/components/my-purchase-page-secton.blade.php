<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div>
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('payment.Purchase history')}}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @if(count($enrolls)==0)
                                <div class="col-xl-12">
                                    <div class="section__title3 margin_50">
                                        <p class="text-center">{{__('student.No Course Purchased Yet')}}!</p>
                                    </div>
                                </div>
                            @else
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('common.SL')}}</th>

                                                <th scope="col">{{__('common.Date')}}</th>

                                                <th scope="col">{{__('common.Total Courses')}}   </th>
                                                <th scope="col">{{__('payment.Total Price')}}</th>
                                                <th scope="col">{{__('common.Discount')}}</th>
                                                @if(hasTax())
                                                    <th scope="col">{{__('tax.TAX')}}</th>
                                                @endif
                                                <th scope="col">{{__('common.Payment Type')}}</th>
                                                <th scope="col"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach ($enrolls as $key=>$enroll)
                                                <tr>
                                                    <td scope="row">{{@$key+1}}</td>
                                                    <td>{{ showDate($enroll->updated_at) }}</td>
                                                    <td>
                                                        @if(count($enroll->courses)==0)
                                                            1
                                                        @else
                                                            {{count($enroll->courses)}}
                                                        @endif
                                                    </td>
                                                    <td>{{getPriceFormat($enroll->purchase_price,false)}}</td>

                                                    <td> {{getPriceFormat($enroll->discount,false)}}  </td>
                                                    @if(hasTax())
                                                        <td>{{getPriceFormat($enroll->tax,false)}} </td>
                                                    @endif


                                                    <td>
                                                        @if($enroll->payment_method=='Wallet')
                                                            {{__('payment.Wallet')}}
                                                        @elseif($enroll->payment_method=='None')
                                                            {{__('common.None')}}
                                                        @else
                                                            {{ $enroll->payment_method }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{route('invoice',$enroll->id)}}"
                                                           class="link_value theme_btn small_btn4">{{__('common.View')}}</a>

                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            {{ $enrolls->links() }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isModuleActive("Store"))
        <div class="dashboard_lg_card mt-5">
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-12">
                        <div class="p-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{__('store.Order History')}}</h3>
                                        <h4></h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @if(count($orders)==0)
                                    <div class="col-xl-12">
                                        <div class="section__title3 margin_50">
                                            <p class="text-center">{{__('student.No Product Purchased Yet!')}}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table custom_table3">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{__('common.SL')}}</th>
                                                    <th scope="col">{{__('product.Order ID')}}</th>

                                                    <th scope="col">{{__('common.Date')}}</th>

                                                    <th scope="col"> {{ __('common.Total') }} {{ __('product.Products') }} </th>
                                                    <th scope="col">{{__('payment.Total Price')}}</th>
                                                    <th scope="col">{{__('common.Discount')}}</th>
                                                    @if(hasTax())
                                                        <th scope="col">{{__('tax.TAX')}}</th>
                                                    @endif
                                                    <th scope="col">{{__('product.Delivery Fee')}}</th>

                                                    <th scope="col">{{__('common.Status')}}</th>

                                                    <th scope="col">{{__('common.Payment Type')}}</th>
                                                    <th scope="col"></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach ($orders as $key=>$order)
                                                    <tr>
                                                        <td scope="row">{{@$key+1}}</td>

                                                        <td>{{ $order->order_number }}</td>

                                                        <td>{{ showDate($order->updated_at) }}</td>

                                                        <td>
                                                            {{ $order->courses->sum('qty') }}
                                                        </td>
                                                        <td>

                                                            {{getPriceFormat($order->purchase_price,false)}}

                                                        </td>


                                                        <td>
                                                            {{getPriceFormat($order->discount,false)}}
                                                        </td>


                                                        @if(hasTax())
                                                            <td>
                                                                {{getPriceFormat($order->tax,false)}}
                                                            </td>
                                                        @endif
                                                        <td>
                                                            {{ getPriceFormat($order->shipping->cost,false) }}

                                                        </td>

                                                        <td>
                                                            @php
                                                                if (isModuleActive('Store')) {
                                                                    $is_paid = $order->status == 1 && $order->is_paid == 1;
                                                                }else {
                                                                    $is_paid = $order->status == 1;
                                                                }
                                                            @endphp
                                                            {{ $is_paid ? __('student.Paid') : __('student.Unpaid') }}
                                                        </td>

                                                        <td>
                                                            @if($order->payment_method=='Wallet')
                                                                {{__('payment.Wallet')}}
                                                            @elseif($order->payment_method=='None')
                                                                {{__('common.None')}}
                                                            @else
                                                                {{ $order->payment_method }}
                                                            @endif
                                                        </td>
                                                        <td>

                                                            <div class="btn-group">
                                                                <button type="button"
                                                                        class="dropdown-toggle link_value theme_btn small_btn4"
                                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    {{trans('common.Action')}}
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a href="{{route('invoice',$order->id)}}"
                                                                       class="dropdown-item">{{__('common.View')}}</a>
                                                                    @php
                                                                        $is_store = 0;
                                                                        $is_virtual = 0;
                                                                        foreach (@$order->courses as $key => $value) {
                                                                            $is_store += $value->course->product_type==2?1:0;
                                                                            $is_virtual += $value->course->product_type==1?1:0;
                                                                        }
                                                                    @endphp
                                                                    @if ($is_store > 0)
                                                                        <a href="{{ route('my_purchase_order_detail', $order->id) }}"
                                                                           class="dropdown-item">{{__('product.Tracking Details')}}</a>
                                                                    @endif
                                                                    @if ($is_virtual > 0)
                                                                        <a href="{{ route('my_virtual_file_download', $order->id) }}"
                                                                           class="dropdown-item">{{__('product.Virtual Files')}}</a>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                            <div class="mt-4">
                                                {{ $orders->links() }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(isModuleActive("Subscription"))
        <div class="dashboard_lg_card mt-5">
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-12">
                        <div class="p-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{__('subscription.Subscription History')}}</h3>
                                        <h4></h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @if(count($checkouts)==0)
                                    <div class="col-xl-12">
                                        <div class="section__title3 margin_50">
                                            <p class="text-center">{{__('student.No Subscription Purchased Yet')}}!</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table custom_table3 mb-0">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{__('common.SL')}}</th>
                                                    <th scope="col">{{__('subscription.Plan')}}</th>
                                                    <th scope="col">{{__('subscription.Start Date')}}</th>
                                                    <th scope="col">{{__('subscription.End Date')}}</th>
                                                    <th scope="col">{{__('subscription.Days')}}</th>
                                                    <th scope="col">{{__('subscription.Price')}}</th>
                                                    <th scope="col">{{__('subscription.Payment Method')}}</th>
                                                    <th scope="col">{{__('subscription.Status')}}</th>
                                                    <th scope="col">{{__('payment.Invoice')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(isset($checkouts))

                                                    @foreach ($checkouts as $key=>$checkout)
                                                        <tr>
                                                            <td scope="row">{{@$key+1}}</td>
                                                            <td>{{$checkout->plan->title}}</td>

                                                            <td>{{ showDate($checkout->start_date) }}</td>
                                                            <td>{{ showDate($checkout->end_date) }}</td>


                                                            <td> {{$checkout->days}}    </td>
                                                            <td> {{$checkout->price}}    </td>
                                                            <td> {{$checkout->payment_method}}    </td>
                                                            <td>
                                                                @php
                                                                    $date_of_subscription = $checkout->end_date;
                                                                    $now = new DateTime();
                                                                    $startdate = new DateTime($checkout->start_date);
                                                                    $enddate = new DateTime($checkout->end_date);

                                                                    if($startdate <= $now && $now <= $enddate) {
                                                                        echo "Valid";
                                                                    }else{
                                                                        echo "Expire";
                                                                    }
                                                                @endphp
                                                            </td>
                                                            <td>
                                                                <a href="{{route('subInvoice',$checkout->id)}}"
                                                                   class="link_value theme_btn small_btn4">{{__('common.View')}}</a>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                            <div class="mt-4">
                                                {{ $checkouts->links() }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
