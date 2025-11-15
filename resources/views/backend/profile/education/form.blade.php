<div class="modal fade admin-query" id="education_form_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{isset($education) ? trans('profile.edit_education') : trans('profile.add_education')}}
                </h4>
                <button type="button" class="close " data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form id="{{isset($education) ? 'user_education_update_form' : 'user_education_form'}}" action="#"
                      method="POST"
                      enctype="multipart/form-data">
                    @isset($education)
                        @method('PUT')
                        <input type="hidden" name="id" value="{{$education->id}}" id="rowId">
                    @endisset

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="institution">{{__('profile.institution')}}
                                    <strong class="text-danger">*</strong>
                                </label>
                                <input class="primary_input_field" name="institution"
                                       placeholder="Ex: Boston University"
                                       type="text" id="institution"
                                       value="{{ isset($education)?$education->institution:old('institution') }}">
                                <span class="text-danger" id="error_institution"></span>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="degree">{{__('profile.degree')}}
                                    <strong class="text-danger">*</strong>
                                </label>
                                <input class="primary_input_field" name="degree" placeholder="Ex: Bachelor's"
                                       type="text" id="degree"
                                       value="{{  isset($education)?$education->degree:old('degree') }}">
                                <span class="text-danger" id="error_degree"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                       for="">{{__('common.Start Date')}}
                                </label>
                                <div class="primary_datepicker_input">
                                    <div class="g-0  input-right-icon">
                                        <div class="col">
                                            <div class="">
                                                <input placeholder="{{__('common.Date')}}"
                                                       class="primary_input_field primary-input date form-control"
                                                       id="startDate" type="text" name="start_date"
                                                       value="{{ isset($education) && $education->start_date? date('m/d/Y',strtotime($education->start_date)): old('start_date') }}"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger" id="error_start_date"></span>
                        </div>
                        <div class="col-lg-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                       for="">{{__('common.End Date')}}
                                </label>
                                <div class="primary_datepicker_input">
                                    <div class="g-0  input-right-icon">
                                        <div class="col">
                                            <div class="">
                                                <input placeholder="{{__('common.Date')}}"
                                                       class="primary_input_field primary-input date form-control"
                                                       id="startDate" type="text" name="end_date"
                                                       value="{{ isset($education) && $education->end_date? date('m/d/Y',strtotime($education->end_date)): old('end_date') }}"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger" id="error_end_date"></span>
                        </div>


                    </div>

                    <div class="col-lg-12 text-center pt_15">
                        <div class="d-flex justify-content-center">
                            <button class="primary-btn  fix-gr-bg"
                                    type="submit"><i
                                    class="ti-check"></i>
                                {{isset($education)?trans('common.Update'): trans('common.Save')}}

                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
