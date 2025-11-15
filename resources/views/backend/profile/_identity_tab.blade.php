<div class="tab-pane fade" id="identity_tab">
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center">
                <h3>{{__('profile.identity_and_documents')}}</h3>
            </div>
            <hr>
            <form action="{{route('users.document.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class=" mb-35">

                            <x-upload-file
                                name="passport"
                                type="image"
                                media_id="{{$passport_document?$passport_document->document_media?->media_id:''}}"
                                label="{{ __('profile.passport') }}"
                            />

                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class=" mb-35">
                            <x-upload-file
                                name="nid"
                                type="image"
                                media_id="{{$nid_document?$nid_document->document_media?->media_id:''}}"
                                label="{{ __('profile.nid') }}"
                            />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 d-flex align-items-center">
                        <div class="">
                            <h4 class="text-nowrap">{{__('profile.certificates_or_other_documents')}}</h4>
                        </div>
                        <div class="custom-hr">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        @foreach($others_documents as $key=>$document)
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="name"> {{__('profile.document_name')}}</label>
                                        <input value="{{$document->name}}" name="document_name[{{$key}}]"
                                               class="primary_input_field document_name" placeholder="-" type="text">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class=" mb-25">
                                        <x-upload-file
                                            name="document_image[{{$key}}]"
                                            type="image"
                                            media_id="{{isset($document)?$document->document_media?->media_id:''}}"
                                            label="{{ __('common.Image') }}"
                                        />
                                    </div>

                                </div>


                                <div class="col-lg-2">
                                    <div class="position-relative form-group ">
                                        <a href="{{route('users.document.destroy',$document->id)}}" data-repeater-delete
                                           class="primary-btn small icon-only fix-gr-bg mt-35  delete_item  mt-repeater-delete">
                                            <i class="fas fa-trash m-0"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-xl-12 mt-repeater no-extra-space">
                        <div data-repeater-list="other_documents">
                            <div data-repeater-item class="mt-repeater-item document_items">
                                <div class="mt-repeater-row document_item">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="name"> {{__('profile.document_name')}}</label>
                                                <input name="document_name" class="primary_input_field document_name"
                                                       placeholder="-" type="text">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class=" mb-25">
                                                <x-upload-file
                                                    name="document_image[]"
                                                    type="image"
                                                    label="{{ __('common.Image') }}"
                                                />
                                            </div>


                                        </div>


                                        <div class="col-lg-2">
                                            <div class="position-relative form-group ">
                                                <a href="javascript:void(0);" data-repeater-delete
                                                   class="primary-btn small icon-only fix-gr-bg mt-35   mt-repeater-delete">
                                                    <i class="fas fa-trash m-0"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <a href="javascript:void(0);" data-repeater-create
                                   class="primary-btn radius_30px  fix-gr-bg mt-repeater-add document_add w-fit "><i
                                        class="fa fa-plus"></i>{{__('common.Add More')}}</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">

                    <div class="col-12 text-end">
                        <hr class="d-block">
                        <button class="primary-btn fix-gr-bg" type="submit"><i
                                class="ti-check"></i> {{__('common.Save')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>

</script>
