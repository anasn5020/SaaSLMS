<div class="modal fade admin-query" id="inactive_staff_modal">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Inactive {{$user->name}}</h4>
                <button type="button" class="close " data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form id="inactive_staff_submit" method="POST">
                    @csrf
                    <input type="hidden" id="rowId" value="{{$user->id}}">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="">{{__('common.Date')}} *</label>
                                <div class="primary_datepicker_input">
                                    <div class="g-0  input-right-icon">
                                        <div class="col">
                                            <div class="">
                                                <input placeholder="{{__('common.Date')}}"
                                                       class="primary_input_field primary-input date form-control"
                                                       id="inactive_date" type="text" name="inactive_date"
                                                       value="{{date('m/d/Y')}}"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="">{{__('common.Reason')}} </label>
                                <input class="primary_input_field" value="{{ old('reason') }}"
                                       name="reason" id="reason"
                                       placeholder="-"
                                       type="text">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-center pt_15">
                        <div class="d-flex justify-content-center">
                            <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                    type="submit"><i
                                    class="ti-check"></i> {{__('common.Submit')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
