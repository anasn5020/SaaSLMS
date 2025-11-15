<div class="modal fade admin-query" id="Item_Edit">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('setting.Edit Language Info') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('languages.update', $language->id) }}" method="POST" id="languageEditForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Name') }} <strong
                                        class="text-danger">*</strong></label>
                                <input name="name" class="primary_input_field name" value="{{ $language->name }}"
                                       placeholder="Language Name" type="text" required>
                                <span class="text-danger">{{$errors->first("name")}}</span>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('setting.Code') }} <strong
                                        class="text-danger">*</strong></label>
                                <input name="code" class="primary_input_field name" value="{{ $language->code }}"
                                       placeholder="Language Code" type="text" required>
                                <span class="text-danger">{{$errors->first("code")}}</span>
                            </div>
                        </div>

                        <div class="col-xl-12 ">
                            <div class="primary_file_uploader  mb-25">
                                <label class="primary_input_label" for="">{{ __('setting.Flag') }}</label>
                                <input class="primary-input filePlaceholder" type="text"
                                       id=""
                                       placeholder="{{__('courses.Browse Image file')}}"
                                       readonly="">
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg" style="top: 25px;"
                                           for="document_file_add">{{__('common.Browse') }}</label>
                                    <input type="file" class="d-none fileUpload" name="flag_img"
                                           id="document_file_add">
                                </button>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('setting.Native Name') }} <strong
                                        class="text-danger">*</strong></label>
                                <input name="native" class="primary_input_field name" value="{{ $language->native }}"
                                       placeholder="Native Name" type="text" required>
                                <span class="text-danger">{{$errors->first("native")}}</span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <label class="primary_input_label"
                                               for=""> {{__('setting.Direction')}} <strong
                                                class="text-danger">*</strong>
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-25">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" id="type1"
                                                   name="rtl"
                                                   {{$language->rtl == 0 ?'checked':''}}
                                                   value="0">
                                            <span class="checkmark me-2"></span>LTL
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-25">
                                        <label class="primary_checkbox d-flex mr-12">
                                            <input type="radio" id="type2"
                                                   name="rtl"
                                                   value="1"
                                                {{$language->rtl == 1 ?'checked':''}}
                                            >
                                            <span class="checkmark me-2"></span>RTL</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent">
                                    <i class="ti-check"></i>{{ __('common.Update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
