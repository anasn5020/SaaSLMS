<div class="modal fade admin-query" id="bankModel">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('payment.Bank Payment')}}</h4>
                <button type="button" class="close " data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form name="bank_payment" enctype="multipart/form-data" action="{{route('depositSubmit')}}"
                      class="single_account-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="modal-title mb-3">{{__('payment.Bank Payment')}}</h5>
                            <input type="hidden" name="method" value="Bank Payment">
                            <input type="hidden" name="deposit_amount" value="{{$amount}}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="bank_name">@lang('setting.Bank Name')<strong
                                                class="text-danger">*</strong></label>
                                        <input required class="primary_input_field" name="bank_name" id="bank_name"
                                               type="text" value="{{@old('bank_name')}}"
                                               placeholder="Bank Name">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="branch_name">@lang('setting.Branch Name')<strong
                                                class="text-danger">*</strong></label>
                                        <input required class="primary_input_field" name="branch_name" id="branch_name"
                                               type="text" value="{{@old('branch_name')}}"
                                               placeholder="Branch Name">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="account_number">@lang('setting.Account Number')<strong
                                                class="text-danger">*</strong></label>
                                        <input required class="primary_input_field" name="account_number"
                                               id="account_number"
                                               type="text" value="{{@old('account_number')}}"
                                               placeholder="Account Number">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="account_holder">@lang('setting.Account Holder')<strong
                                                class="text-danger">*</strong></label>
                                        <input required class="primary_input_field" name="account_holder"
                                               id="account_holder"
                                               type="text" value="{{@old('account_holder')}}"
                                               placeholder="Account Holder">
                                    </div>

                                </div>

                                <div class="col-md-6 mb-25">
                                    <label class="primary_input_label"
                                           for="type">@lang('setting.Account Type')</label>
                                    <select class="primary_select" name="type" id="type">
                                        <option
                                            data-display="{{__('common.Select')}}  {{__('setting.Account Type')}}"
                                            value="">{{__('common.Select')}} {{__('setting.Account Type')}}</option>
                                        <option
                                            value="Current Account" {{(env('ACCOUNT_TYPE')? env('ACCOUNT_TYPE') : '')=='Current Account'?'selected':''}}>
                                            {{__('payment.Current Account')}}

                                        </option>
                                        <option
                                            value="Savings Account" {{(env('ACCOUNT_TYPE')? env('ACCOUNT_TYPE') : '')=='Savings Account'?'selected':''}}>
                                            {{__('payment.Savings Account')}}
                                        </option>
                                        <option
                                            value="Salary Account" {{(env('ACCOUNT_TYPE')? env('ACCOUNT_TYPE') : '')=='Salary Account'?'selected':''}}>
                                            {{__('payment.Salary Account')}}
                                        </option>
                                        <option
                                            value="Fixed Deposit" {{(env('ACCOUNT_TYPE')? env('ACCOUNT_TYPE') : '')=='Fixed Deposit'?'selected':''}}>
                                            {{__('payment.Fixed Deposit')}}
                                        </option>

                                    </select>
                                </div>

                                <div class="col-lg-6">
                                    <div class="primary_input mb-35">
                                        <label class="primary_input_label"
                                               for="">Cheque Slip <strong
                                                class="text-danger">*</strong></label>
                                        <input required type="file" name="image" id="image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="modal-title mb-3">{{__('common.Bank Account Info')}}</h5>
                            <ul class="list-group">
                                <li class="list-group-item d-flex  align-items-center">
                                    <span>@lang('setting.Bank Name') :</span>
                                    <span class="ml-10">{{getPaymentEnv('BANK_NAME')}}</span>
                                </li>
                                <li class="list-group-item d-flex  align-items-center">
                                    <span>@lang('setting.Branch Name') :</span>
                                    <span class="ml-10">{{getPaymentEnv('BRANCH_NAME')}}</span>
                                </li>
                                <li class="list-group-item d-flex  align-items-center">
                                    <span>@lang('setting.Account Type') :</span>
                                    <span class="ml-10">{{getPaymentEnv('ACCOUNT_TYPE')}}</span>
                                </li>
                                <li class="list-group-item d-flex  align-items-center">
                                    <span>@lang('setting.Account Number') :</span>
                                    <span class="ml-10">{{getPaymentEnv('ACCOUNT_NUMBER')}}</span>
                                </li>
                                <li class="list-group-item d-flex  align-items-center">
                                    <span>@lang('setting.Account Holder') :</span>
                                    <span class="ml-10">{{getPaymentEnv('ACCOUNT_HOLDER')}}</span>
                                </li>

                            </ul>
                        </div>

                    </div>

                    <div class="col-lg-12 text-center pt_15 mt-20">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">@lang('common.Cancel')</button>
                            <button class="primary-btn semi_large2 fix-gr-bg"
                                    type="submit"> @lang('payment.Payment')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
