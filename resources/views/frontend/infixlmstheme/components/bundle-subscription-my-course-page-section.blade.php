<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">

                    <div class="purchase_history_wrapper mt-0 pt-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('bundleSubscription.Bundle Course')}}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        @if(count($checkouts)==0)
                            <div class="col-12">
                                <div class="section__title3 margin_50">
                                    <p class="text-center">{{__('bundleSubscription.No Bundle Purchased Yet')}}!</p>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <div class="table-responsive">
                                            <table class="table custom_table3">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{__('common.SL')}}</th>
                                                    <th scope="col">{{__('common.Title')}}</th>
                                                    <th scope="col">{{__('common.Date')}}</th>
                                                    <th scope="col">{{__('common.Total Courses')}}</th>
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
                                                @if(isset($checkouts))
                                                    @foreach ($checkouts as $key=>$checkout)
                                                        <tr>
                                                            <td scope="row">{{@$key+1}}</td>

                                                            <td>{{ $checkout->bundle->title }}</td>
                                                            <td>{{ showDate($checkout->created_at) }}</td>

                                                            <td>
                                                                @if(count($checkout->courses)==0)
                                                                    1
                                                                @else
                                                                    {{count($checkout->courses)}}
                                                                @endif

                                                            </td>
                                                            <td>

                                                                {{getPriceFormat($checkout->purchase_price)}}

                                                            </td>


                                                            <td>
                                                                @if($checkout->discount!=0)

                                                                    {{getPriceFormat($enroll->discount)}}
                                                                @endif
                                                            </td>
                                                            @if(hasTax())
                                                                <td>
                                                                    @if($checkout->tax)

                                                                        {{getPriceFormat($enroll->tax)}}
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            <td>
                                                                {{$checkout->payment_method}}
                                                            </td>
                                                            <td>
                                                                <a href="{{route('bundle.show')}}?id={{$checkout->bundle->id}}"
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
                                </div>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
