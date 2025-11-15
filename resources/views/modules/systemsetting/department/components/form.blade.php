<form enctype="multipart/form-data" id="{{ $form_id }}">
    <div class="row">
        <input type="hidden" name="id" id="item_id">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="primary_input mb-25">
                <label class="primary_input_label"
                       for="">{{ __('common.Name') }} <span class="required_mark">*</span></label>
                <input name="name" class="primary_input_field name"
                       id="name" placeholder="{{ __('common.Name') }}"
                       type="text" required="1">
                <span class="text-danger" id="name_error"></span>
            </div>
        </div>
        @php
            $staffs =Modules\SystemSetting\Entities\Staff::whereHas('user',function ($q){$q->where('status',1);})->get();
        @endphp
        <div class="col-xl-12">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('leave.Department Head') }} </label>
                <select class="primary_select mb-25" name="user_id" id="user_id">
                    <option value="">{{__('common.Select')}} {{ __('leave.Department Head') }} </option>
                    @foreach ($staffs as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="primary_input mb-25">
                <label class="primary_input_label"
                       for="">{{ __('common.Details') }} </label>
                <input name="details" class="primary_input_field name"
                       id="details" placeholder="{{ __('common.Details') }}"
                       type="text">
                <span class="text-danger" id="name_error"></span>
            </div>
        </div>

        <div class="col-lg-12 text-center">
            <div class="d-flex justify-content-center pt_20">
                <button type="submit" class="primary-btn semi_large2 fix-gr-bg"><i
                        class="ti-check"></i>
                    {{ $button_level_name }}
                </button>
            </div>
        </div>

    </div>
</form>
