<div class="modal fade admin-query" id="payout_account_modal">
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
                        <h4>{{ __('common.Title') }} : {{$payout_account->title}}</h4>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <h4>{{__('common.Logo')}} : <img id="logo_show" class="center image_preview p-1"
                                                         src="{{isset($payout_account)?showImage($payout_account->logo): showImage()}}"
                                                         alt="Logo"></h4>

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
                        <ul class="list-group list-group-flush payout_list">
                            @foreach($payout_account->specifications as $sp)
                                <li class="list-group-item">{{$sp->title}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


