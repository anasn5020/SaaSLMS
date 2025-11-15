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
    <script>
        $(document).ready(function () {
            $(document).on('click', '.view_gift_message', function (e) {
                console.log('clicked');
                e.preventDefault();
                var message = $(this).data('message');
                $('#messageModal').modal('show');
                $('#messageModal .modal-body').html(message);
            });
        });
    </script>
@endsection

@section('mainContent')
    <div class="main_content_iner main_content_padding">
        <div class="row">
            @php
                $total_installmets=$purchase_request->installmentPayments->where('type','step');
            @endphp
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="dashboard_card text-center">
                    <div class="icon mx-auto">
                        <img src="{{asset('Modules/Installment/Resources/assets/images/installment/5.png')}}" alt="">

                    </div>
                    <span>{{_trans('installment.Total Installment')}}</span>
                    <h4>
                        {{@$total_installmets->count()}}
                    </h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="dashboard_card text-center">
                    <div class="icon mx-auto">
                        <img src="{{asset('Modules/Installment/Resources/assets/images/installment/6.png')}}" alt="">

                    </div>
                    <span>{{_trans('installment.Remained Installment')}}</span>
                    <h4>
                        {{@$total_installmets->where('status','unpaid')->count()}}
                    </h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="dashboard_card text-center">
                    <div class="icon mx-auto">
                        <img src="{{asset('Modules/Installment/Resources/assets/images/installment/7.png')}}" alt="">

                    </div>
                    <span>{{_trans('installment.Remained Amount')}}</span>
                    <h4>
                        {{showPrice(@$total_installmets->where('status','unpaid')->sum('amount'))}}
                    </h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="dashboard_card text-center">
                    <div class="icon mx-auto">
                        <img src="{{asset('Modules/Installment/Resources/assets/images/installment/8.png')}}" alt="">

                    </div>
                    <span>{{_trans('installment.Overdue Amount')}}</span>
                    <h4>
                        {{showPrice(@$total_installmets->where('status','unpaid')->where('due_date','<',date('Y-m-d'))->sum('amount'))}}
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
                                        <h3 class="mb-0">{{ _trans('installment.Installment Payment History') }}</h3>
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
                                                <td>
                                                    {{ _trans('common.SL') }}
                                                </td>
                                                <td width="20%">
                                                    {{ _trans('installment.Title') }}
                                                </td>
                                                <td>
                                                    {{ _trans('installment.Amount') }}
                                                </td>
                                                <td>
                                                    {{ _trans('installment.Due Date') }}
                                                </td>
                                                <td>
                                                    {{ _trans('installment.Payment Date') }}
                                                </td>
                                                <td>
                                                    {{ _trans('installment.Status') }}
                                                </td>
                                                <td>
                                                    {{_trans('common.Action')}}
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse ($purchase_request->installmentPayments as $key => $installment_payment)

                                                <tr>
                                                    <td>
                                                        {{ @$loop->iteration }}
                                                    </td>
                                                    <td>
                                                        {{isset($installment_payment->step) ? @$installment_payment->step->payment_title : ($key==0 ? _trans('installment.Upfront') : _trans('installment.Installment'))}}

                                                    </td>
                                                    <td>
                                                        {{ getPriceFormat(@$installment_payment->amount) }}
                                                    </td>
                                                    <td>
                                                        {{showDate(@$installment_payment->due_date)}}

                                                    </td>
                                                    <td>
                                                        {{showDate(@$installment_payment->payment_date)}}

                                                    </td>


                                                    <td>
                                                        {{ _trans('installment.'.Str::ucfirst(@$installment_payment->status)) }}
                                                        @if($installment_payment->status=='unpaid' && $installment_payment->due_date<date('Y-m-d'))
                                                            <button class="btn">
                                                                <span
                                                                    class="badge badge-danger">{{_trans('installment.Overdue')}}</span>
                                                            </button>
                                                        @endif
                                                    </td>


                                                    <td>
                                                        @if($installment_payment->status!='paid')
                                                            <a class="theme_btn small_btn3"
                                                               href="{{route('installment.student_installment.pay_installment',$installment_payment->id)}}">{{ _trans('installment.Make Payment') }}</a>
                                                        @else
                                                            {{trans('common.N/A')}}
                                                        @endif
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center" colspan="7">
                                                        {{__('common.No data available in the table')}}
                                                    </td>
                                                </tr>
                                            @endforelse

                                            </tbody>
                                        </table>
                                        {{-- <div class="mt-4">
                                            {{ @$purchase_requests->links() }}
                                        </div> --}}
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
