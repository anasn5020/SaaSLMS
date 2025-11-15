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
                        <div class="col-lg-12">
                            <label class="primary_label2" for="institution">{{__('profile.institution')}}
                                <span class="required_mark">*</span></label>
                            <input id="institution" name="institution" placeholder="Ex: Boston University"
                                   onfocus="this.placeholder = ''"
                                   onblur="this.placeholder = 'Ex: Boston University'"
                                   class="primary_input" {{$errors->first('institution') ? 'autofocus' : ''}}
                                   value="{{ isset($education)?$education->institution:old('institution') }}"
                                   type="text">
                            <span class="text-danger" id="error_institution"></span>
                        </div>

                        <div class="col-lg-12 mt_20">
                            <label class="primary_label2" for="degree">{{__('profile.degree')}}
                                <span class="required_mark">*</span></label>
                            <input id="degree" name="degree" placeholder="Ex: Bachelor's"
                                   onfocus="this.placeholder = ''"
                                   onblur="this.placeholder = 'Ex: Bachelor'"
                                   class="primary_input" {{$errors->first('degree') ? 'autofocus' : ''}}
                                   value="{{  isset($education)?$education->degree:old('degree') }}" type="text">
                            <span class="text-danger" id="error_degree"></span>
                        </div>

                        <div class="col-lg-6 mt_20">
                            <label class="primary_label2" for="start_date">{{__('common.Start Date')}}
                            </label>
                            <input id="start_date" name="start_date" placeholder="{{__('common.Date')}}"
                                   class="primary_input"
                                   value="{{ isset($education) && $education->start_date? date('m/d/Y',strtotime($education->start_date)): old('start_date') }}"
                                   type="text">
                            <span class="text-danger" id="error_start_date"></span>
                        </div>

                        <div class="col-lg-6 mt_20 end_date_div">
                            <label class="primary_label2" for="end_date">{{__('common.End Date')}}
                            </label>
                            <input id="end_date" name="end_date" placeholder="{{__('common.Date')}}"
                                   class="primary_input"
                                   value="{{ isset($education) && $education->end_date? date('m/d/Y',strtotime($education->end_date)): old('end_date') }}"
                                   type="text">
                            <span class="text-danger" id="error_end_date"></span>
                        </div>


                    </div>

                    <div class="col-lg-12 text-center mt_20">
                        <div class="d-flex justify-content-center">
                            <button class="theme_btn small_btn text-center"
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
