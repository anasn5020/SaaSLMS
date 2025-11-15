@extends(theme('layouts.dashboard_master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ _trans('installment.My Installments') }}
@endsection
@section('css')
    <style>
        .modal-dialog {
            max-width: 500px !important;
        }
    </style>
@endsection
@section('js')
@endsection

@section('mainContent')
    <div class="main_content_iner main_content_padding">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="dashboard_card text-center">
                    <div class="icon mx-auto">
                        <img src="{{asset('Modules/Installment/Resources/assets/images/installment/1.png')}}" alt="">
                    </div>
                    <span>{{_trans('installment.Open Installment')}}</span>
                    <h4>
                        {{@$user_installment_overview['open']}}
                    </h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="dashboard_card text-center">
                    <div class="icon mx-auto">
                        <img src="{{asset('Modules/Installment/Resources/assets/images/installment/2.png')}}" alt="">
                    </div>
                    <span>{{_trans('installment.Pending Verification')}}</span>
                    <h4>
                        {{@$user_installment_overview['pending_verification']}}
                    </h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="dashboard_card text-center">
                    <div class="icon mx-auto">
                        <img src="{{asset('Modules/Installment/Resources/assets/images/installment/3.png')}}" alt="">
                    </div>
                    <span>{{_trans('installment.Finished Installments')}}</span>
                    <h4>
                        {{@$user_installment_overview['complete']}}
                    </h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="dashboard_card text-center">
                    <div class="icon mx-auto">
                        <img src="{{asset('Modules/Installment/Resources/assets/images/installment/4.png')}}" alt="">
                    </div>
                    <span>{{_trans('installment.Overdue Installments')}}</span>
                    <h4>
                        {{@$user_installment_overview['overdue']}}
                    </h4>
                </div>
            </div>
        </div>
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="row">

                    <div class="col-12">
                        <div class="p-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{ _trans('installment.Installment history') }}</h3>
                                        <h4></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3">
                                            <thead>
                                            <tr>
                                                <td colspan="4">

                                                </td>
                                                <td colspan="3" class="text-center">
                                                    {{ _trans('installment.Installment Overview') }}
                                                </td>
                                                <td></td>


                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ _trans('common.SL') }}
                                                </td>
                                                <td width="30%">
                                                    {{ _trans('installment.Product') }}
                                                </td>
                                                <td>
                                                    {{ _trans('installment.Purchase Date') }}
                                                </td>
                                                <td>
                                                    {{ _trans('installment.Upfront') }}
                                                </td>
                                                <td>
                                                    {{ _trans('installment.Total') }}
                                                </td>

                                                <td>
                                                    {{ _trans('installment.Remaining') }}
                                                </td>
                                                <td>
                                                    {{ _trans('installment.Upcoming') }}
                                                </td>
                                                <td>
                                                    {{ _trans('common.Action') }}
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse ($purchase_requests as $key => $purchase_request)
                                                @php
                                                    $upfront_info = $purchase_request->installmentPayments->where('type', 'upfront')->first();
                                                    $InstallmentPurchaseController = new \Modules\Installment\Http\Controllers\InstallmentPurchaseController();
                                                    $installmentOverviewData = $InstallmentPurchaseController->installmentOverviewData($purchase_request->topic_id, $purchase_request->plan_id);
                                                    $installmentOverviewData = $installmentOverviewData['installment_overview'];

                                                    $unpaid_installments = $purchase_request->installmentPayments->where('status', '!=', 'paid');
                                                    $next_installment = $unpaid_installments->first();
                                                @endphp
                                                <tr style="background-color:{{$next_installment ? ($next_installment->amount > 0 ? '#fff0d7;' :''):''}}">
                                                    <td class="text-center">
                                                        {{ @$loop->iteration }}
                                                    </td>
                                                    <td>
                                                        <a target="_blank"
                                                           href="{{ route('courseDetailsView', [$purchase_request->topic->slug]) }}">{{ @$purchase_request->topic->title }}</a>

                                                    </td>
                                                    <td>
                                                        {{ showDate(@$upfront_info->payment_date) }}

                                                    </td>
                                                    <td>
                                                        {{ getPriceFormat(@$upfront_info->amount) }}
                                                    </td>
                                                    <td>
                                                        {{ @$installmentOverviewData['total_installment_count'] . ' ' . _trans('installment.Parts') }}
                                                        <br>
                                                        {{ '(' . @$installmentOverviewData['total_installment_amount'] . ')' }}
                                                    </td>


                                                    <td>
                                                        @if ($unpaid_installments->count() > 0)
                                                            {{ @$unpaid_installments->count() . ' ' . _trans('installment.Parts') }}
                                                            <br>
                                                            {{ '(' . showPrice(@$unpaid_installments->sum('amount')) . ')' }}
                                                        @else
                                                            {{ '-' }}
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($next_installment)
                                                            {{ showDate(@$next_installment->due_date) }} <br>
                                                            ({{ showPrice(@$next_installment->amount) }})
                                                        @else
                                                            {{ '-' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!in_array($purchase_request->payment_status, ['incomplete', 'paid']))
                                                            <a class="theme_btn small_btn3"
                                                               href="{{ route('installment.student_installment.purchase_request_details', $purchase_request->id) }}">{{ _trans('common.Details') }}</a>
                                                        @else
                                                            {{ _trans('installment.Pending') }}
                                                        @endif
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center" colspan="7">
                                                        {{ __('common.No data available in the table') }}
                                                    </td>
                                                </tr>
                                            @endforelse

                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            {{ @$purchase_requests->links() }}
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
    <div class="modal fade admin-query admin_view_modal" id="messageModal">
        <div class="modal-dialog modal_1000px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4> {{ _trans('gift.View Gift Message') }}</h4>
                    <button type="button" class="close " data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
