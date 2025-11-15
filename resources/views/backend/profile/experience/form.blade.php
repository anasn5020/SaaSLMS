<div class="modal fade admin-query" id="experience_form_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{isset($experience) ? trans('profile.edit_experience') : trans('profile.add_experience')}}
                </h4>
                <button type="button" class="close " data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form id="{{isset($experience) ? 'user_experience_update_form' : 'user_experience_form'}}" action="#"
                      method="POST" enctype="multipart/form-data">
                    @isset($experience)
                        @method('PUT')
                        <input type="hidden" name="id" value="{{$experience->id}}" id="rowId">
                    @endisset
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="title">{{__('common.Title')}}
                                    <strong class="text-danger">*</strong>
                                </label>
                                <input class="primary_input_field" name="title" placeholder="EX: Sales Manager"
                                       type="text" id="title"
                                       value="{{ isset($experience)?$experience->title:old('title') }}">
                                <span class="text-danger" id="error_title"></span>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="company_name">{{__('profile.company_name')}}
                                    <strong class="text-danger">*</strong>
                                </label>
                                <input class="primary_input_field" name="company_name" placeholder="EX: Aorasoft"
                                       type="text" id="company_name"
                                       value="{{isset($experience)?$experience->company_name:old('company_name') }}">
                                <span class="text-danger" id="error_company_name"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-25">
                            <div class="checkbox_wrap d-flex align-items-center">
                                <label for="is_currently_working" class="switch_toggle me-2">
                                    <input
                                        {{isset($experience) && $experience->currently_working?'checked':'' }}  type="checkbox"
                                        id="is_currently_working" value="1" name="is_currently_working">
                                    <i class="slider round"></i>
                                </label>
                                <label
                                    class="mb-0">{{ __('profile.i_am_currently_working') }}</label>
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
                                                       value="{{ isset($experience) && $experience->start_date? date('m/d/Y',strtotime($experience->start_date)): old('start_date') }}"
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
                        <div class="col-lg-6 end_date_div">
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
                                                       value="{{ isset($experience) && $experience->end_date? date('m/d/Y',strtotime($experience->end_date)): old('end_date') }}"
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
                                {{isset($experience)?trans('common.Update'): trans('common.Save')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
