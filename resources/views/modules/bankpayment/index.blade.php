@extends('backend.master')
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor mb-3">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px"> {{ __('setting.Settings') }}</h3>

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <div class="">
                                    <form action="{{ route('bankPayment.settings') }}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="single_system_wrap">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="checkbox_wrap d-flex align-items-center ">
                                                        <label for="active_bank_payment_auto_approval" class="switch_toggle me-2">
                                                            <input
                                                                {{Settings('active_bank_payment_auto_approval') == 1 ?'checked':""}} type="checkbox"
                                                                id="active_bank_payment_auto_approval" value="1" name="active_bank_payment_auto_approval">
                                                            <i class="slider round"></i>
                                                        </label>
                                                        <label
                                                            class="mb-0">  {{ __('common.Active') }} <br>
                                                            <small>{{__('setting.By activating this feature, bank payment amount auto approved')}}</small>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <div class='input-effect mb-25'>
                                                        <label class="mb-2">
                                                            <span>{{__('setting.Maximum Fund Deposit')}}</span>
                                                        </label>
                                                        <input type="text"
                                                               value="{{Settings('bank_max_fund_deposit')}}"
                                                               class="primary-input-field form-control"
                                                                name="bank_max_fund_deposit">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-center">
                                            <div class="d-flex justify-content-center pt_20">
                                                <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                                        id="save_button_parent"><i
                                                        class="ti-check"></i>{{ __('common.Save') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">


            <div class="white-box">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-0" id="page_title">{{__('payment.Payment')}}</h3>
                        </div>
                    </div>
                    <!-- </div> -->
                    <div class="col-lg-12  mt_25">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <div class="">
                                    <table id="lms_table" class="table Crm_table_active3">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('common.SL')}}</th>
                                            <th scope="col">{{__('common.User')}}</th>
                                            <th scope="col">{{__('setting.Bank Name')}}</th>
                                            <th scope="col">{{__('setting.Branch Name')}}</th>
                                            <th scope="col">{{__('setting.Account Type')}}</th>
                                            <th scope="col">{{__('setting.Account Holder')}}</th>
                                            <th scope="col">{{__('setting.Account Number')}}</th>
                                            <th scope="col">  {{__('payment.Amount')}}</th>
                                            <th scope="col">{{__('common.Status')}}</th>
                                            <th scope="col">{{__('common.Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($payments as $key =>$payment)

                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>{{$payment->user->name}}</td>
                                                <td>{{$payment->bank_name}}</td>
                                                <td>{{$payment->branch_name}}</td>
                                                <td>{{$payment->account_type}}</td>
                                                <td>{{$payment->account_holder}}</td>
                                                <td>{{$payment->account_number}}</td>
                                                <td>{{getPriceFormat($payment->amount)}}</td>
                                                <td>
                                                    <div class="primary-btn small fix-gr-bg">
                                                        {{$payment->status==0?'Pending':'Approved'}}
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu2{{$payment->id}}"
                                                                data-bs-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false">
                                                            {{__('common.Action')}}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                             aria-labelledby="dropdownMenu2{{$payment->id}}">
                                                            @if($payment->image)
                                                                <a target="_blank" href="{{asset($payment->image)}}"
                                                                   class="dropdown-item"
                                                                >{{__('common.View')}}</a>
                                                            @endif

                                                            @if($payment->status==0)
                                                                <button data-bs-toggle="modal"
                                                                        data-bs-target="#approve{{@$payment->id}}"
                                                                        class="dropdown-item"
                                                                        type="button">{{__("common.Approve")}}
                                                                </button>
                                                            @endif
                                                            <button data-bs-toggle="modal"
                                                                    data-bs-target="#delete{{@$payment->id}}"
                                                                    class="dropdown-item"
                                                                    type="button">{{__('common.Delete')}}</button>

                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>

                                            <div class="modal fade admin-query" id="approve{{@$payment->id}}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">
                                                                Approve {{__('payment.Payment')}} </h4>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal">
                                                                <i
                                                                    class="ti-close "></i></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="text-center">

                                                                <h4>Are you sure ?</h4>
                                                            </div>

                                                            <div class="mt-40 d-flex justify-content-between">
                                                                <button type="button" class="primary-btn tr-bg"
                                                                        data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                                                <form method="post"
                                                                      action="{{route('bankPayment.update', [$payment->id])}}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button class="primary-btn fix-gr-bg"
                                                                            type="submit">Approve
                                                                    </button>
                                                                </form>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade admin-query" id="delete{{@$payment->id}}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">{{__('common.Delete')}} {{__('payment.Payment')}} </h4>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal">
                                                                <i
                                                                    class="ti-close "></i></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="text-center">

                                                                <h4>{{__('common.Are you sure to delete ?')}} </h4>
                                                            </div>

                                                            <div class="mt-40 d-flex justify-content-between">
                                                                <button type="button" class="primary-btn tr-bg"
                                                                        data-bs-dismiss="modal">{{__('common.Cancel')}}</button>

                                                                <form method="post"
                                                                      action="{{route('bankPayment.destroy', [$payment->id])}}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="primary-btn fix-gr-bg"
                                                                            type="submit">{{__('common.Delete')}}</button>
                                                                </form>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script type="application/javascript">


        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6, 7, 8]);

        let table = $('#lms_table').DataTable(dataTableOptions);


    </script>
@endpush
