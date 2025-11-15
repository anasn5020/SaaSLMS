<div class="modal-dialog modal_800px modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('common.Add')}} {{__('virtual-class.Record')}}</h4>
            <button type="button" class="close " data-bs-dismiss="modal">
                <i class="ti-close "></i>
            </button>
        </div>

        <div class="modal-body">

            <div class="row">


                <form class="student-details" action="{{$url}}" method="post">
                    @csrf

                    <div class="tab-content">

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('common.Title')}}
                                        <span class="required_mark">*</span>
                                    </label>
                                    <input class="primary_input_field"
                                           value=""
                                           name="title"
                                           placeholder="-" type="text">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <x-upload-file
                                    required="true"
                                    name="file"
                                    type="video"
                                    label="{{__('common.Video File') }}"
                                />
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12 text-center pt_15">
                        <div class="d-flex justify-content-center">
                            <button
                                class="primary-btn semi_large  fix-gr-bg"
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
