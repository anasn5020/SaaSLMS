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
                        <div class="col-lg-12">
                            <label class="primary_label2" for="skills"> {{ __('profile.skills') }} <span
                                    class="text-danger">[Note: seperated by " , "]</span></label>
                            <input id="skills" name="skills" placeholder="{{__('common.Name')}}" data-role="tagsinput"
                                   onfocus="this.placeholder = ''"
                                   onblur="this.placeholder = '{{ __('profile.skills') }}'"
                                   class="primary_input" {{$errors->first('skills') ? 'autofocus' : ''}}
                                   value="{{isset($exist_skills)?$exist_skills:""}}" type="text">
                            <small class="text-danger d-block mt-2">Note: Maximum 10 skills </small>
                            <span class="text-danger" role="alert">{{$errors->first('skills')}}</span>
                        </div>
                    </div>


                    <div class="col-lg-12 text-center mt_20">
                        <div class="d-flex justify-content-center">
                            <button class="theme_btn small_btn text-center"
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
