<div class="modal fade admin-query" id="user_payout_account_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{ __('setting.Payout Account') }}

                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-xl-12">
                        <h4>{{ __('common.Title') }} : {{$user_payout_account->payoutAccount->title}}</h4>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <h4>{{__('common.Logo')}}</h4>
                        <img id="logo_show" class="center image_preview p-1"
                             src="{{isset($user_payout_account)?showImage($user_payout_account->payoutAccount->logo): showImage()}}"
                             alt="Logo">
                    </div>
                </div>

                <div class="row mt-25">
                    <div class="col-md-12 d-flex align-items-center">
                        <div class="">
                            <h4 class="text-nowrap">{{__('setting.Specifications')}}</h4>
                        </div>
                        <div class="custom-hr">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <ul class="list-group list-group-flush">
                            @foreach($user_payout_account_specifications as $sp)
                                <li class="list-group-item d-flex">
                                    <span class=" ">{{$sp->specification->title}} :</span>
                                    <span> {{$sp->value}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
