<div class="tab-pane fade" id="identity_tab">
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center">
                <h3>{{__('profile.identity_and_documents')}}</h3>
            </div>
            <hr>
            <form action="{{route('users.document.update')}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="from" value="frontend">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single_input mb-35">
                            <label class="primary_label2">{{__('profile.passport')}}</label>
                            <label for="passport" class="form-uploader mb-0">
                                <input type="file" name="passport" class="d-none" id="passport"
                                       accept="image/*"
                                >
                                <span id="placeholderPassportName">{{__('common.Browse File')}}</span>
                                <a class="theme_btn rounded-pill">{{__('common.Browse')}}</a>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <img id="passport_show" class="center image_preview object-fit-contain p-1"
                             src="{{$passport_document?($passport_document->document): showImage()}}"
                             alt="Passport">
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="single_input mb-35">
                            <label class="primary_label2"
                                   for="">{{__('profile.nid')}}</label>
                            <label for="nid" class="form-uploader mb-0">
                                <input type="file" name="nid" class="d-none" id="nid"
                                       accept="image/*"

                                >
                                <span id="placeholderNidName">{{__('common.Browse File')}}</span>
                                <a class="theme_btn rounded-pill">{{__('common.Browse')}}</a>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <img id="nid_show" class="center image_preview object-fit-contain p-1"
                             src="{{$nid_document?($nid_document->document): showImage()}}" alt="NID">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 d-flex align-items-center gap-3">
                        <div class="">
                            <h4 class="text-sm-nowrap">{{__('profile.certificates_or_other_documents')}}</h4>
                        </div>
                        <div class="custom-hr d-sm-block d-none">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        @foreach($others_documents as $document)
                            <div class="row">


                                <div class="col-lg-3">
                                    {{--                                    <input type="hidden" name="ex_ids[]" value="{{$document->id}}">--}}
                                    <label class="primary_label2" for="">{{__('profile.document_name')}}</label>
                                    <input value="{{$document->name}}" name="document_name[]"
                                           placeholder="e.g personal cv"
                                           class="primary_input4 rounded-pill document_name_input"
                                           {{$errors->first('name') ? 'autofocus' : ''}}
                                           type="text">
                                </div>

                                <div class="col-lg-3">
                                    <div class="single_input mb-25">
                                        <label class="primary_label2"
                                               for="">{{__('profile.document')}}</label>

                                        <label for="ex_document_{{$document->id}}"
                                               class="form-uploader mb-0 ex_label_id">
                                            <input accept="image/*" data-id="{{$document->id}}" type="file"
                                                   name="document_image[]"

                                                   class="d-none ex_file_input_field"
                                                   id="ex_document_{{$document->id}}">
                                            <span class="ex_placeholder_field" data-id="{{$document->id}}"
                                                  id="exPlaceholderDocumentName_{{$document->id}}">{{__('common.Browse File')}}</span>
                                            <a class="theme_btn rounded-pill">{{__('common.Browse')}}</a>
                                        </label>
                                    </div>


                                </div>

                                <div class="col-lg-3">
                                    <img data-id="{{$document->id}}" id="ex_document_show_{{$document->id}}"
                                         class="center image_preview object-fit-contain ex_document_show p-2"
                                         src="{{($document->document)}}" alt="Document">
                                </div>


                                <div class="col-lg-1">
                                    <div class="position-relative form-group ">
                                        <a href="{{route('users.document.destroy',$document->id)}}" data-repeater-delete
                                           class="link_value theme_btn small_btn4 fix-gr-bg mt-35  delete_item  mt-repeater-delete">
                                            <i class="fas fa-trash"></i>
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
                                    <div class="row mt_20 row-gap-3">

                                        <div class="col-lg-3">
                                            <label class="primary_label2" for="">{{__('profile.document_name')}}</label>
                                            <input name="document_name" placeholder="e.g personal cv"
                                                   class="primary_input4 rounded-pill document_name_input"
                                                   {{$errors->first('name') ? 'autofocus' : ''}}
                                                   type="text">
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="single_input mb-25">
                                                <label class="primary_label2"
                                                       for="">{{__('profile.document')}}</label>

                                                <label for="document_1" class="form-uploader mb-0 label_id">
                                                    <input data-id="1" type="file" name="document"
                                                           accept="image/*"
                                                           class="d-none file_input_field" id="document_1">
                                                    <span class="placeholder_field" data-id="1"
                                                          id="placeholderDocumentName_1">{{__('common.Browse File')}}</span>
                                                    <a class="theme_btn rounded-pill">{{__('common.Browse')}}</a>
                                                </label>
                                            </div>


                                        </div>

                                        <div class="col-lg-3">
                                            <img data-id="1" id="document_show_1"
                                                 class="center image_preview object-fit-contain document_show p-2"
                                                 src="{{showImage()}}" alt="Document">
                                        </div>


                                        <div class="col-lg-1">
                                            <div class="position-relative form-group ">
                                                <a href="javascript:void(0);" data-repeater-delete
                                                   class="link_value theme_btn small_btn4 fix-gr-bg mt-32 mt-repeater-delete">
                                                    <i class="fas fa-trash"></i>
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
                                   class="link_value theme_btn small_btn4 mt-repeater-add document_add "><i
                                        class="fa fa-plus me-1"></i>{{__('common.Add More')}}</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">

                    <div class="col-12 text-end">
                        <hr class="d-block">
                        <button class="theme_btn small_btn text-center" type="submit"><i
                                class="ti-check"></i> {{__('common.Save')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
