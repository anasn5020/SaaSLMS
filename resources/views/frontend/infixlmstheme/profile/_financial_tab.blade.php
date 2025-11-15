<div class="tab-pane fade" id="financial_tab">
    <div class="account_profile_form row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center">
                <h3>{{__('profile.financial')}}</h3>
            </div>
            <hr>
            <form action="{{route('users.finance.account')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-6 col-md-6 mt_20">
                        <div class="single_input ">
                            <span class="primary_label2">{{__('profile.account_type')}} </span>
                            <select class="theme_select wide mb_20"
                                    name="account_type"
                                    {{$errors->first('account_type') ? 'autofocus' : ''}} id="account_type">
                                <option value=""> {{__('profile.select_one')}}</option>
                                @foreach($payout_accounts as $payout_account)
                                    <option
                                        {{@$user->userPayoutAccount->payout_accounts_id == $payout_account->id ?'selected':""}} value="{{$payout_account->id}}">{{$payout_account->title}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" role="alert">{{$errors->first('account_type')}}</span>
                        </div>

                    </div>
                </div>


                <div id="payout_data_div">

                </div>


                <div class="row">

                    <div class="col-12 text-end">
                        <hr class="d-block">
                        <button class="theme_btn small_btn text-center" type="submit"><i
                                class="ti-check"></i> {{__('common.Save')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
