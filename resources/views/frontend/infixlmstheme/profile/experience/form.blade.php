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

                        <div class="col-lg-12">
                            <label class="primary_label2" for="title">{{__('common.Title')}}
                                <span class="required_mark">*</span></label>
                            <input id="title" name="title" placeholder="EX: Sales Manager"
                                   onfocus="this.placeholder = ''"
                                   onblur="this.placeholder = 'EX: Sales Manager'"
                                   class="primary_input" {{$errors->first('institution') ? 'autofocus' : ''}}
                                   value="{{ isset($experience)?$experience->title:old('title') }}" type="text">
                            <span class="text-danger" id="error_title"></span>
                        </div>

                        <div class="col-lg-12 mt_20">
                            <label class="primary_label2" for="company_name">{{__('profile.company_name')}}
                                <span class="required_mark">*</span></label>
                            <input id="company_name" name="company_name" placeholder="EX: Aorasoft"
                                   onfocus="this.placeholder = ''"
                                   onblur="this.placeholder = 'EX: Aorasoft'"
                                   class="primary_input" {{$errors->first('company_name') ? 'autofocus' : ''}}
                                   value="{{isset($experience)?$experience->company_name:old('company_name') }}"
                                   type="text">
                            <span class="text-danger" id="error_company_name"></span>
                        </div>

                        <div class="col-lg-12 mt_20">
                            <div class="remember_forgot_passs d-flex align-items-center">
                                <label class="primary_checkbox d-flex" for="is_currently_working">
                                    <input id="is_currently_working" value="1" name="is_currently_working"
                                           {{isset($experience) && $experience->currently_working?'checked':'' }} type="checkbox">
                                    <span class="checkmark mr_15"></span>
                                    <p>{{ __('profile.i_am_currently_working') }}</p>
                                </label>

                            </div>
                        </div>

                        <div class="col-lg-6 mt_20">
                            <label class="primary_label2" for="start_date">{{__('common.Start Date')}}
                            </label>
                            <input id="start_date" name="start_date" placeholder="{{__('common.Date')}}"
                                   class="primary_input"
                                   value="{{ isset($experience) && $experience->start_date? date('m/d/Y',strtotime($experience->start_date)): old('start_date') }}"
                                   type="text">
                            <span class="text-danger" id="error_start_date"></span>
                        </div>

                        <div class="col-lg-6 mt_20 end_date_div">
                            <label class="primary_label2" for="end_date">{{__('common.End Date')}}
                            </label>
                            <input id="end_date" name="end_date" placeholder="{{__('common.Date')}}"
                                   class="primary_input"
                                   value="{{ isset($experience) && $experience->end_date? date('m/d/Y',strtotime($experience->end_date)): old('end_date') }}"
                                   type="text">
                            <span class="text-danger" id="error_end_date"></span>
                        </div>

                    </div>

                    <div class="col-lg-12 text-center mt_20">
                        <div class="d-flex justify-content-center">
                            <button class="theme_btn small_btn text-center"
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
