<div class="modal fade admin-query" id="Item_Edit">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('setting.Edit Timezone Info') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('timezone.update', $timezone->id) }}" method="POST" id="timezoneEditForm">
                    @csrf
                    @method('PATCH')
                    <div class="row">


                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('setting.Timezone Code') }} <strong
                                        class="text-danger">*</strong></label>

                                <select class="primary_select mb-25" name="code" id="code2" required>
                                    @foreach ($lists as $key => $item)
                                        <option value="{{$key}}" @if($timezone->code==$key) selected @endif >{{$key}}
                                            - {{ $item }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{$errors->first("code")}}</span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('setting.Timezone Name') }} <strong
                                        class="text-danger">*</strong></label>
                                <input name="time_zone" class="primary_input_field time_zone"
                                       value="{{ $timezone->time_zone }}"
                                       placeholder="Timezone Name" type="text" required>
                                <span class="text-danger">{{$errors->first("time_zone")}}</span>
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
