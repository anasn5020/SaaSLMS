<div class="modal fade admin-query" id="Item_Edit">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('setting.Edit City Info') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('city.update', $city->id) }}" method="POST" id="cityEditForm">
                    @csrf
                    @method('PATCH')
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.State') }} <strong
                                        class="text-danger">*</strong></label>
                                <select class="primary_select" name="state" id="state_edit">
                                    <option data-display="{{__('common.Select')}} {{__('common.Country')}}"
                                            value="">{{__('common.Select')}} {{__('common.Country')}}</option>
                                    @foreach($states as $state)
                                        <option
                                            value="{{$state->id}}" {{$state->id==$city->state_id?'selected':''}}>{{@$state->name}} </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{$errors->first("state")}}</span>
                            </div>
                        </div>


                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Name') }} <strong
                                        class="text-danger">*</strong></label>
                                <input name="name" class="primary_input_field name" value="{{ $city->name }}"
                                       placeholder="Language Name" type="text" required>
                                <span class="text-danger">{{$errors->first("name")}}</span>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent">
                                    <i class="ti-check"></i>{{ __('common.Update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
