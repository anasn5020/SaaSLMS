<script src="{{asset('public/modules/profile/repeater/repeater.js')}}"></script>
<script src="{{asset('public/modules/profile/repeater/indicator-repeater.js')}}"></script>

<div class="modal fade admin-query" data-bs-backdrop="static" tabindex="-1" role="dialog" id="payout_account_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @if(isset($payout_account))
                        {{ __('setting.Edit Payout Account') }}
                    @else
                        {{ __('setting.Add Payout Account') }}
                    @endif

                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST"
                      id="{{isset($payout_account)?"update_payout_form":"create_payout_form"}}">
                    @isset($payout_account)
                        @method('PATCH')
                        <input type="hidden" name="id" value="{{$payout_account->id}}" id="rowId">
                    @endisset


                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="title">{{ __('common.Title') }} <strong
                                        class="text-danger">*</strong></label>
                                <input name="title" class="primary_input_field"
                                       value="{{ isset($payout_account)?$payout_account->title:old('title') }}"
                                       placeholder="{{ __('common.Title') }}" type="text" id="title">
                                <span class="text-danger" id="error_title"></span>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="  mb-35">
                                <x-upload-file
                                    name="logo"
                                    required="true"
                                    type="image"
                                    media_id="{{isset($payout_account)?$payout_account->logo_media?->media_id:''}}"
                                    label="{{__('common.Logo')}}"
                                />


                            </div>
                            <span class="text-danger" id="error_logo"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 d-flex align-items-center">
                            <div class="">
                                <h4 class="text-nowrap">{{__('setting.Specifications')}}</h4>
                            </div>
                            <div class="custom-hr">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 mt-repeater no-extra-space">

                            <div data-repeater-list="specifications">
                                @if(isset($payout_account))
                                    @foreach($payout_account->specifications as $sp)
                                        <div data-repeater-item class="mt-repeater-item">

                                            <div class="mt-repeater-row">

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="specification"> {{__('setting.Specification')}} <span class="required_mark">*</span></label>
                                                            <input value="{{$sp->title}}" name="specification"
                                                                   class="primary_input_field specification"
                                                                   placeholder="-" type="text">
                                                        </div>
                                                        <span class="text-danger error_specification"></span>
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <div class="position-relative form-group ">
                                                            <a href="javascript:void(0);" data-repeater-delete
                                                               class="primary-btn small icon-only fix-gr-bg mt-35  mt-repeater-delete">
                                                                <i class="fas fa-trash m-0"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div data-repeater-item class="mt-repeater-item">

                                    <div class="mt-repeater-row">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="specification"> {{__('setting.Specification')}} <span class="required_mark">*</span></label>
                                                    <input name="specification"
                                                           class="primary_input_field specification"
                                                           placeholder="-" type="text">
                                                </div>
                                                <span class="text-danger error_specification"></span>
                                            </div>

                                            <div class="col-lg-1">
                                                <div class="position-relative form-group ">
                                                    <a href="javascript:void(0);" data-repeater-delete
                                                       class="primary-btn small icon-only fix-gr-bg mt-35  mt-repeater-delete">
                                                        <i class="fas fa-trash m-0"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <a href="javascript:void(0);" data-repeater-create
                                       class="primary-btn radius_30px  fix-gr-bg mt-repeater-add w-fit"><i
                                            class="fa fa-plus"></i>{{__('common.Add More')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">


                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent">
                                    <i class="ti-check"></i>
                                    @isset($payout_account)
                                        {{ __('common.Update') }}
                                    @else
                                        {{ __('common.Save') }}
                                    @endisset
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


