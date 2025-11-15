<div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ __('common.Edit') }} {{ __('courses.Exercise') }} {{ __('common.File') }}</h4>
            <button type="button" class="btn-close"
                    data-bs-dismiss="modal"><i
                    class="ti-close "></i></button>
        </div>

        <div class="modal-body">
            <form action="{{route('updateFile')}}"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id"
                       value="{{$edit->id}}" class=" ">
                <div class="">


                    <x-upload-file
                        name="file"
                        required="false"
                        type="all"
                        media_id="{{$edit->file_media?->media_id}}"
                        label="{{ __('common.File') }}"
                    />
                </div>
                <div class="row">

                    <div class="col-xl-12 mt-20">
                        <div class="primary_input">
                            <input
                                class="primary_input_field "
                                name="fileName"
                                required
                                value="{{$edit->fileName}}"

                                placeholder="{{__('common.File')}} {{__('common.Name')}}"
                                type="text">
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-12 mt-20 ">
                        <select
                            class="primary_select editFilePrivacy"
                            name="lock" id="">
                            <option
                                data-display="{{__('common.Select')}} {{__('courses.Privacy')}}"
                                value="">{{__('common.Select')}} {{__('courses.Privacy')}} </option>
                            <option value="0" {{$edit->lock!=1?'selected':''}}
                            >{{__('courses.Unlock')}}</option>
                            <option value="1" {{$edit->lock==1?'selected':''}}
                            >{{__('courses.Locked')}}</option>

                        </select>
                    </div>
                    <div class="col-12 mt-25">
                        <select
                            class="primary_select editFileStatus"
                            name="status" id="">
                            <option
                                data-display="{{__('common.Select')}} {{__('common.Status')}}"
                                value="">{{__('common.Select')}} {{__('common.Status')}} </option>
                            <option value="1" {{$edit->status==1?'selected':''}}
                            >{{__('courses.Active')}}</option>
                            <option value="0" {{$edit->status!=1?'selected':''}}
                            >{{__('courses.Pending')}}</option>
                        </select>
                    </div>

                </div>

                <div
                    class="mt-40 d-flex justify-content-between">
                    <button type="button"
                            class="primary-btn tr-bg"
                            data-bs-dismiss="modal"> {{__('common.Cancel')}} </button>
                    <button
                        class="primary-btn fix-gr-bg"
                        type="submit">{{__('common.Update')}}</button>
                </div>
            </form>
        </div>

    </div>
</div>
<script>
    $(document).ready(function () {

        $('select').niceSelect();
        Amaz.uploader.previewGenerate();

    });
</script>
