<div class="modal fade admin-query" id="skill_form_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{__('profile.add_or_update_skills')}}
                </h4>
                <button type="button" class="close " data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('users.skills.store')}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="skills">  {{ __('profile.skills') }} <span
                                        class="text-danger">[{{__("frontend.Note")}}: {{__('frontend.seperated by')}} " , "]</span></label>
                                <input value="{{isset($exist_skills)?$exist_skills:""}}" id="skills" type="text"
                                       data-role="tagsinput" name="skills" class="primary_input_field">
                                <small class="text-danger">{{__("frontend.Note")}}
                                    : {{__('frontend.Maximum 10 skills')}} </small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 text-center pt_15">
                        <div class="d-flex justify-content-center">
                            <button class="primary-btn semi_large2  fix-gr-bg"
                                    id="save_button_parent"
                                    type="submit"><i
                                    class="ti-check"></i> {{__('common.Save')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
