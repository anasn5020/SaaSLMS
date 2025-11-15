<div>
    <style>
        .pb_50 {
            padding-bottom: 50px;
        }
    </style>
    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-12">
                        <div class="p-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{ __('invoice.Invoice List') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{ __('common.SL') }}</th>
                                                <th scope="col">{{ __('invoice.Invoice Number') }}</th>
                                                <th scope="col">{{ __('common.Date') }}</th>
                                                <th scope="col">{{ __('common.Total Courses') }}</th>
                                                <th scope="col">{{ __('payment.Total Price') }}</th>
                                                <th scope="col">{{ __('common.Status') }}</th>
                                                <th scope="col">{{ __('common.Payment Type') }}</th>
                                                <th scope="col">{{ __('payment.Invoice') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            @forelse ($myInvoices as $key => $invoice)

                                                <tr>
                                                    <td class="m-2"><strong>{{ $loop->iteration }}</strong></td>
                                                    <td>{{ $invoice->invoice_number }} </td>
                                                    <td>{{ showDate($invoice->created_at) }}</td>
                                                    <td class="text-center">{{ $invoice->courses_count }}</td>
                                                    <td>{{ getPriceFormat($invoice->purchase_price) }}</td>
                                                    <td>
                                                        @if($invoice->offlinePayment)
                                                            <strong>{{__('invoice.Pending')}}</strong>
                                                        @elseif ($invoice->status != 'paid')
                                                            <a href="{{ route('invoice.orderPayment', @$invoice->encryptId()) }}"
                                                               class="link_value theme_btn small_btn4">{{ __('invoice.Pay Now') }}</a>
                                                        @elseif($invoice->status == 'paid')
                                                            <strong>{{__('invoice.Paid')}}</strong>
                                                        @endif
                                                    </td>
                                                    <td>{{ $invoice->payment_type == 1 ? 'Online' : 'Offline' }}
                                                        {{ $invoice->status == 'paid' ?  '['. $invoice->payment_method.']' : '' }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('invoice.student.show', @$invoice->encryptId()) }}"
                                                           class="link_value theme_btn small_btn4">{{ __('common.View') }}</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8">
                                                        <p class="text-center">
                                                            {{ __('invoice.No Invoice Generate Yet') }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforelse

                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            {{ $myInvoices->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
