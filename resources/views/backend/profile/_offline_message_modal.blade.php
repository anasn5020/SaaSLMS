<div class="modal fade admin-query" id="offline_message_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{trans('profile.offline_status_message')}}
                </h4>
                <button type="button" class="close " data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{route('users.offline_status.submit')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col text-justify">
                            When your account is set to offline mode, a notification will appear on your profile to
                            inform users. Please feel free to leave a personalized message in the input provided.
                        </div>


                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{__('profile.offline_message') }}
                                    [note:maximum 500 characters]</label>
                                <textarea id="my-textarea" class="primary_input_field offline_message_input"
                                          name="offline_message" style="height: 200px"
                                          rows="3">{{@$user->userInfo->offline_message}}</textarea>
                            </div>
                            <small> <span class="offline_message_input_character_count text-danger"></span></small>

                        </div>
                    </div>

                    <div class="col-lg-12 text-center pt_15">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">
                                {{trans('common.Close')}}
                            </button>
                            <button class="primary-btn  fix-gr-bg"
                                    type="submit">
                                {{trans('common.Save')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
