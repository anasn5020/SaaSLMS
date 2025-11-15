<div class="main_content_iner main_content_padding">
    <div class="dashboard_lg_card">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('product.Store Refund & Dispute')}}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        @if(count($enrolls)==0)
                            <div class="col-12">
                                <div class="section__title3 margin_50">
                                    <p class="text-center">{{__('student.No Course Purchased Yet')}}!</p>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('common.SL')}}</th>
                                                <th scope="col">{{__('product.Order ID')}}</th>
                                                <th scope="col">{{__('common.Date')}}</th>
                                                <th scope="col">{{__('common.Status')}}</th>
                                                <th scope="col">{{ __('product.Request Sent Date') }}</th>
                                                <th scope="col">{{__('product.Order Amount')}}</th>
                                                <th scope="col"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if(isset($enrolls))
                                                @foreach ($enrolls as $key=>$enroll)
                                                    <tr>
                                                        <td scope="row">{{@$key+1}}</td>
                                                        <td>{{ $enroll->order->order_number }}</td>
                                                        <td>{{ showDate($enroll->order->created_at) }}</td>
                                                        <td>
                                                            {{ $enroll->CheckConfirmed }}
                                                        </td>
                                                        <td>
                                                            {{showDate($enroll->created_at)}}
                                                        </td>
                                                        <td>
                                                            {{ getPriceFormat($enroll->total_return_amount) }}
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                        class="link_value theme_btn small_btn4 dropdown-toggle"

                                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    {{trans('common.Action')}}
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a href="{{ route('refund.frontend.my_refund_order_detail', $enroll->id) }}"
                                                                       class="dropdown-item">{{__('product.Tracking Details')}}</a>
                                                                </div>
                                                            </div>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            {{ $enrolls->links() }}
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
