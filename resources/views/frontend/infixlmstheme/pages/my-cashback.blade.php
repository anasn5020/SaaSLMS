@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{_trans('cashback.My Cashback')}}
@endsection
@section('css') @endsection
@section('js')
@endsection

@section('mainContent')

    <div class="main_content_iner main_content_padding">

        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title3 mb_40">
                            <h3 class="mb-0">
                                {{_trans('cashback.Cashback history')}}
                            </h3>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="table-responsive">
                            <table class="table custom_table3 mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('common.SL')}}</th>
                                    <th scope="col">{{__('common.Date')}}</th>
                                    <th scope="col">{{__('payment.Amount')}}
                                        @if (Settings('hide_multicurrency') == 1)
                                            ({{auth()->user()->currency->symbol}})
                                        @else
                                             ({{auth()->user()->currency->symbol}})
                                        @endif
                                    </th>
                                    <th scope="col">{{_trans('cashback.Source')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($data['cashbackDetails'] as $cashbackDetail)
                                    <tr>
                                        <td>{{@$loop->iteration}}</td>
                                        <td>{{showDate($cashbackDetail->created_at) }}</td>
                                        <td>{{getPriceFormat(@$cashbackDetail->cashback_amount)}}   </td>
                                        <td>{{Str::ucfirst(@$cashbackDetail->product_type)}}</td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td class="text-center" colspan="4">
                                            {{__('common.No data available in the table')}}
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                            <div class="mt-4">
                                @if($data['cashbackDetails'] != null)
                                    {{ $data['cashbackDetails']->links() }}
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .modal-dialog {
            max-width: 1000px;
        }
    </style>
@endsection
