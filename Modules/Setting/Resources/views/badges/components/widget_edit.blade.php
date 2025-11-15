<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('setting.Edit Badge')}}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="ti-close "></i></button>
        </div>
        <form method="POST" action="{{route('gamification.badges.update')}}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="hidden" name="id" id="widgetEditId" value="{{$badge->id}}">

            <div class="modal-body">

                <div class="row">
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="editTitle">{{ __('common.Title') }}
                                <strong
                                    class="text-danger">*</strong></label>
                            <input name="title"

                                   required
                                   class="primary_input_field name  "
                                   placeholder="{{ __('common.Title') }}"
                                   type="text"
                                   value="{{old('title',$badge->title)}}">
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="editPoint">{{ __('common.Condition') }}
                                <strong
                                    class="text-danger">*</strong></label>
                            <input name="point"
                                   id="editPoint"
                                   required
                                   class="primary_input_field name  "
                                   placeholder="{{ __('common.Condition') }}"
                                   type="number"
                                   value="{{old('point',$badge->point)}}">
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for="">{{ __('courses.Image') }}<small>(200x200)</small> </label>
                            <div class="primary_file_uploader">
                                <input class="primary-input filePlaceholder"
                                       type="text"
                                       id="editImage"
                                       value="{{$badge->image}}"
                                       placeholder="{{__('setting.Browse file')}}"
                                       readonly="">
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg"
                                           for="document_file_image_3">{{ __('common.Browse') }}</label>
                                    <input type="file" class="d-none fileUpload"
                                           name="image"
                                           id="document_file_image_3">
                                </button>
                            </div>
                        </div>
                    </div>
                    {{--

                                        <div class="col-lg-12">

                                            <div class="  mb-15">
                                                <x-upload-file
                                                    name="image"
                                                    type="image"
                                                    media_id="{{isset($badge)?$badge->image_media?->media_id:''}}"
                                                    label="{{ __('common.Image') }}"
                                                    note="{{__('student.Recommended size')}} (200x200)"
                                                />

                                            </div>
                                        </div>
                    --}}

                </div>

                <div class="row">


                    <div class="col-lg-12 mt-30">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="primary-btn tr-bg me-3 "
                                    data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                            <button type="submit" class="primary-btn fix-gr-bg tooltip-wrapper "
                                    data-original-title="" title="">
                                <i class="ti-check"></i>
                                {{__('common.Update')}} </button>

                        </div>
                    </div>
                </div>


            </div>
        </form>
    </div>
</div>

<script>
    // $(document).ready(function () {
    //     Amaz.uploader.clearUploaderSelected();
    //     Amaz.uploader.initForInput();
    //     Amaz.uploader.removeAttachment();
    //     Amaz.uploader.sortImage();
    //     Amaz.uploader.previewGenerate();
    // })
</script>
