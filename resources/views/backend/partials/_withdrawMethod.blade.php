@if($withdraw->method=="Bank Payment")

    <a href="#" data-bs-toggle="modal"
       data-bs-target="#show_{{@$withdraw->id}}">{{$withdraw->method}}</a>


    <div class="modal fade admin-query" id="show_{{@$withdraw->id}}">
        <div class="modal-dialog   modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('setting.Payment Details')}}</h4>
                    <button type="button" class="close " data-bs-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table">
                        <tr>
                            <th>{{__('setting.Bank Name')}}</th>
                            <td>
                                @if($withdraw->user->bank_name)
                                    {{$withdraw->user->bank_name}}
                                @else
                                    N/A
                                @endif</td>
                        </tr>

                        <tr>
                            <th>{{__('setting.Branch Name')}}</th>
                            <td>
                                @if($withdraw->user->branch_name)
                                    {{$withdraw->user->branch_name}}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>{{__('setting.Account Number')}}</th>
                            <td>
                                @if($withdraw->user->branch_name)
                                    {{$withdraw->user->bank_account_number}}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>{{__('setting.Account Holder')}}</th>
                            <td>
                                @if($withdraw->user->account_holder_name)
                                    {{$withdraw->user->account_holder_name}}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{__('setting.Account Type')}}</th>
                            <td>
                                @if($withdraw->user->bank_type)
                                    {{$withdraw->user->bank_type}}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>

                    </table>


                </div>
            </div>
        </div>
    </div>
@elseif($withdraw->method=="Bkash")
    {{$withdraw->method}} <br>
    {{@$withdraw->user->bkash_number}}
@else
    {{$withdraw->method}} <br>
    {{@$withdraw->user->payout_email}}
@endif
