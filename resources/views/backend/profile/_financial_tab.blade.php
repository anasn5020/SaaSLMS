<div class="tab-pane fade" id="financial_tab">
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center">
                <h3>{{__('profile.financial')}}</h3>
            </div>
            <hr>
            <form action="{{route('users.finance.account')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-25">
                        <label class="primary_input_label"
                               for="account_type">{{__('profile.account_type')}}</label>
                        <select class="primary_select" name="account_type" id="account_type">
                            <option value=""> {{__('profile.select_one')}}</option>
                            @foreach($payout_accounts as $payout_account)
                                <option
                                    {{@$user->userPayoutAccount->payout_accounts_id == $payout_account->id ?'selected':""}} value="{{$payout_account->id}}">{{$payout_account->title}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div id="payout_data_div">

                </div>


                <div class="row">

                    <div class="col-12 text-end">
                        <hr class="d-block">
                        <button class="primary-btn fix-gr-bg" type="submit"><i
                                class="ti-check"></i> {{__('common.Save')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
