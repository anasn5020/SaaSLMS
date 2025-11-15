<script>
    $(function () {
        // Find elements with class .note-btn.dropdown-toggle
        $('.note-btn.dropdown-toggle').each(function () {
            const $this = $(this);

            // Check if the element has 'data-toggle' attribute
            const toggleAttr = $this.attr('data-toggle');
            if (toggleAttr) {
                // Convert 'data-toggle' to 'data-bs-toggle' and remove 'data-toggle'
                $this.attr('data-bs-toggle', toggleAttr).removeAttr('data-toggle');
            }
        });

        // Initialize Bootstrap dropdown
        $('.note-btn.dropdown-toggle').dropdown();
    });

</script>

<style>
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        width: 100%;
        height: 46px;
        line-height: 46px;
        font-size: 13px;
        padding: 3px 20px;
        padding-left: 20px;
        font-weight: 300;
        border-radius: 30px;
        color: var(--base_color);
        border: 1px solid #ECEEF4
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
        position: absolute;
        top: 1px;
        right: 20px;
        width: 20px;
        color: var(--text-color);
    }

    .select2-dropdown {
        background-color: white;
        border: 1px solid var(--backend-border-color);
        border-radius: 4px;
        box-sizing: border-box;
        display: block;
        position: absolute;
        left: -100000px;
        width: 100%;
        width: 100%;
        background: var(--bg_white);
        overflow: auto !important;
        border-radius: 0px 0px 10px 10px;
        margin-top: 1px;
        z-index: 9999 !important;
        border: 0;
        box-shadow: 0px 10px 20px rgb(108 39 255 / 30%);
        z-index: 1051;
        min-width: 200px;
    }

    .select2-search--dropdown .select2-search__field {
        padding: 4px;
        width: 100%;
        box-sizing: border-box;
        box-sizing: border-box;
        background-color: #fff;
        border: 1px solid rgba(130, 139, 178, 0.3) !important;
        border-radius: 3px;
        box-shadow: none;
        color: #333;
        display: inline-block;
        vertical-align: middle;
        padding: 0px 8px;
        width: 100% !important;
        height: 46px;
        line-height: 46px;
        outline: 0 !important;
    }

    .select2-container {
        width: 100% !important;
        min-width: 90px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--dynamic-text-color);
        line-height: 40px;
    }


    .makeResize.responsiveResize:last-child.col-xl-6 {
        margin-top: 30px;
    }

    #durationBox {
        /*margin-top: 30px;*/
    }

    @media (max-width: 1199px) {
        .responsiveResize2 {
            margin-top: 30px;
        }
    }
    .note-editor .note-editable p {
        margin-bottom: 0;
    }
</style>
<div class="modal-dialog modal-dialog-centered modal-lg student-details">
    <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title">
                @if($edit)
                    {{__('common.Edit')}}
                @else
                    {{__('common.Add')}}
                @endif
                {{__('courses.Lesson')}}
            </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form
                @if($edit)
                    class="form-horizontal" method="POST" action="{{ route('updateChapter') }}"
                enctype="multipart/form-data">
                @method('PUT')
                @else
                    class="form-horizontal" method="POST" action="{{ route('saveChapter') }}"
                    enctype="multipart/form-data">
                @endif
                @csrf
                <input type="hidden" name="course_id" value="{{@$course_id}}">
                <input type="hidden" name="chapter_id" value="{{@$chapter_id}}">

                <div class="row">
                    <div class="col-lg-12">
                        <input type="hidden" name="input_type" value="0" id="">
                        <div class="lesson_div">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="input-effect mt-2 pt-1">
                                        <label
                                            class="primary_input_label mt-1">{{__('courses.Lesson')}} {{__('common.Name')}}
                                            <span class="required_mark">*</span></label>
                                        <input
                                            class="primary_input_field name{{ $errors->has('chapter_name') ? ' is-invalid' : '' }}"
                                            type="text" name="name"
                                            placeholder="{{__('courses.Lesson')}} {{__('common.Name')}}"
                                            autocomplete="off"
                                            value="{{$edit->name??""}}">
                                        <input type="hidden" name="lesson_id"
                                               value="{{$edit->id??""}}">
                                        <span class="focus-border"></span>
                                        @if ($errors->has('chapter_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('chapter_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">

                                    <div class="input-effect mt-2 pt-1">
                                        <label class="primary_input_label mt-1">{{__('common.Duration')}}
                                            ({{__('common.In Minute')}}) </label>
                                        <input
                                            class="primary_input_field name{{ $errors->has('chapter_name') ? ' is-invalid' : '' }}"
                                            min="0" step="any" type="number" name="duration"
                                            placeholder="{{__('courses.Duration')}}"
                                            autocomplete="off"
                                            value="{{$edit->duration??""}}">

                                        <span class="focus-border"></span>
                                        @if ($errors->has('chapter_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('chapter_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                    <div class="defaultHost">
                                        <div class="input-effect mt-2 pt-1">
                                            <label class="primary_input_label mt-1"
                                                   for=""> {{__('courses.Host')}}
                                                <span class="required_mark">*</span></label>

                                            <select class="primary_select category_id host_select" name="host"
                                                    data-key="{{isset($edit)?'_edit_':''}}{{$edit->id??''}}"
                                                    id="category_id{{isset($edit)?'_edit_':''}}{{$edit->id??""}}">
                                                <option data-display="{{__('common.Select')}} {{__('courses.Host')}}"
                                                        value="">{{__('common.Select')}} {{__('courses.Host')}} </option>


                                                <option
                                                    value="Youtube" {{($edit->host??'')=='Youtube'? 'selected':'' }} >
                                                    Youtube
                                                </option>

                                                <option
                                                    value="Vimeo" {{($edit->host??'')=='Vimeo'? 'selected':'' }} >
                                                    Vimeo
                                                </option>
                                                <option
                                                    value="VdoCipher" {{($edit->host??'')=='VdoCipher'? 'selected':'' }} >
                                                    VdoCipher
                                                </option>
                                                <option
                                                    value="Self" {{($edit->host??'')=='Self'? 'selected':'' }} >
                                                    Self
                                                </option>


                                                <option
                                                    value="URL" {{($edit->host??'')=='URL'? 'selected':'' }} >
                                                    Video URL
                                                </option>
                                                <option
                                                    value="Iframe" {{($edit->host??'')=='Iframe'? 'selected':'' }} >
                                                    Iframe embed
                                                </option>
                                                <option
                                                    value="Editor" {{($edit->host??'')=='Editor'? 'selected':'' }} >
                                                    Editor
                                                </option>
                                                <option
                                                    value="Image" {{($edit->host??'')=='Image'? 'selected':''}} >
                                                    Image
                                                </option>
                                                <option
                                                    value="PDF" {{($edit->host??'')=='PDF'? 'selected':''}} >
                                                    PDF File
                                                </option>
                                                <option
                                                    value="Word" {{($edit->host??'')=='Word'? 'selected':'' }} >
                                                    Word File
                                                </option>
                                                <option
                                                    value="Excel" {{($edit->host??'')=='Excel'? 'selected':'' }} >
                                                    Excel File
                                                </option>
                                                <option
                                                    value="Text" {{($edit->host??'')=='Text'? 'selected':'' }} >
                                                    Text File
                                                </option>
                                                <option
                                                    value="Zip" {{($edit->host??'')=='Zip'? 'selected':'' }} >
                                                    Zip File
                                                </option>

                                                <option
                                                    value="m3u8" {{($edit->host??'')=='m3u8'? 'selected':'' }} >
                                                    M3U8
                                                </option>

                                                <option value="GoogleDrive"
                                                    {{@($edit->host??'')=='GoogleDrive'? 'selected':''}} >
                                                    Google Drive
                                                </option>
                                                <option
                                                    value="PowerPoint" {{($edit->host??'')=='PowerPoint'? 'selected':'' }} >
                                                    Power Point File
                                                </option>

                                                @if(isModuleActive("AmazonS3"))
                                                    <option
                                                        value="AmazonS3" {{($edit->host??'')=='AmazonS3'? 'selected':'' }} >
                                                        Amazon S3
                                                    </option>
                                                @endif

                                                @if (isModuleActive('BunnyStorage'))
                                                    <option
                                                        value="BunnyStorage" {{($edit->host??'')=='BunnyStorage'? 'selected':''}}>
                                                        Bunny Storage
                                                    </option>
                                                @endif


                                                @if(isModuleActive("SCORM"))
                                                    <option
                                                        value="SCORM" {{($edit->host??'')=='SCORM'? 'selected':'' }} >
                                                        SCORM Self
                                                    </option>
                                                @endif
                                                @if (isModuleActive('H5P'))
                                                    <option value="H5P"
                                                        {{($edit->host??'')=='H5P'? 'selected':'' }}
                                                    >
                                                        H5P
                                                    </option>
                                                @endif

                                                @if(isModuleActive("AmazonS3") && isModuleActive("SCORM"))
                                                    <option
                                                        value="SCORM-AwsS3" {{($edit->host??'')=='SCORM-AwsS3'? 'selected':'' }} >
                                                        SCORM AWS S3
                                                    </option>
                                                @endif

                                                @if(isModuleActive("XAPI"))
                                                    <option value="XAPI"
                                                        {{($edit->host??'')=='XAPI'? 'selected':'' }}
                                                    >
                                                        XAPI Self
                                                    </option>
                                                @endif

                                                @if(isModuleActive("AmazonS3") && isModuleActive("XAPI"))
                                                    <option value="XAPI-AwsS3"
                                                        {{($edit->host??'')=='XAPI-AwsS3'? 'selected':'' }}
                                                    >
                                                        XAPI AWS S3
                                                    </option>
                                                @endif
                                                <option
                                                    value="Storage" {{($edit->host??'')=='Storage'? 'selected':'' }} >
                                                    Storage
                                                </option>
                                            </select>
                                            @if ($errors->has('host'))
                                                <span class="invalid-feedback invalid-select"
                                                      role="alert">
                                                                        <strong>{{ $errors->first('host') }}</strong>
                                                                    </span>
                                            @endif
                                        </div>


                                        <div class="input-effect mt-2 pt-1"
                                             id="editorBox{{isset($edit)?'_edit_':''}}{{$edit->id??""}}"
                                             style="display:@if((isset($edit) && ($edit->host!="Youtube"  && $edit->host!="URL"  && $edit->host!="m3u8" && $edit->host!="Editor")) || !isset($edit)) none  @endif">
                                            <label class="primary_input_label mt-1">{{__('courses.Text')}}
                                                <span class="required_mark">*</span></label>
                                            <textarea name="editor" id="lms_editor" cols="30"
                                                      rows="10">{!! $edit->editor??"" !!}</textarea>
                                        </div>

                                        <div class="input-effect mt-2 pt-1"
                                             id="videoUrl{{isset($edit)?'_edit_':''}}{{$edit->id??""}}"
                                             style="display:@if((isset($edit) && ($edit->host!="Youtube"  && $edit->host!="URL"  && $edit->host!="m3u8")) || !isset($edit)) none  @endif">
                                            <label class="primary_input_label mt-1">{{__('courses.Video URL')}}
                                                <span class="required_mark">*</span></label>
                                            <input
                                                id="youtubeVideo"
                                                class="primary_input_field name{{ $errors->has('video_url') ? ' is-invalid' : '' }}"
                                                type="text" name="video_url"
                                                placeholder="{{__('courses.Video URL')}}"
                                                autocomplete="off"
                                                value="@if(isset($edit)) @if(($edit->host??'')=="Youtube" || ($edit->host??'')=="URL" || ($edit->host??'')=="m3u8"){{$edit->video_url}} @endif @endif">
                                            <span class="focus-border"></span>
                                            @if ($errors->has('video_url'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('video_url') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="input-effect mt-2 pt-1"
                                             id="iframeBox{{isset($edit)?'_edit_':''}}{{$edit->id??''}}"
                                             style="display: @if((isset($edit) && ($edit->host!="Iframe")) || !isset($edit)) none  @endif">
                                            <div class="" id="">

                                                <label class="primary_input_label mt-1">{{__('courses.Iframe URL')}}
                                                    <span class="required_mark">*</span></label>
                                                <input
                                                    class="primary_input_field name{{ $errors->has('iframe_url') ? ' is-invalid' : '' }}"
                                                    type="text" name="iframe_url"
                                                    placeholder="{{__('courses.Iframe (Provide the source only)')}}"
                                                    autocomplete="off"
                                                    value="@if(isset($edit)) @if(($edit->host??'')=="Iframe"){{$edit->video_url}} @endif @endif">
                                                <span class="focus-border"></span>
                                                @if ($errors->has('video_url'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('video_url') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="input-effect mt-2 pt-1"
                                             id="vimeoUrl{{isset($edit)?'_edit_':''}}{{$edit->id??''}}"
                                             style="display: @if((isset($edit) && ($edit->host!="Vimeo")) || !isset($edit)) none  @endif">
                                            <div class="w-100" id="">
                                                @if(config('vimeo.connections.main.upload_type')=="Direct")
                                                    <div class="primary_file_uploader">
                                                        <input
                                                            class="primary-input filePlaceholder"
                                                            type="text"
                                                            id=""
                                                            {{$errors->has('image') ? 'autofocus' : ''}}
                                                            placeholder="{{__('courses.Browse Video file')}}"
                                                            readonly="">
                                                        <button class="" type="button">
                                                            <label
                                                                class="primary-btn small fix-gr-bg"
                                                                for="document_file_thumb_vimeo_lesson_section_insider{{$key??1}}">{{__('common.Browse') }}</label>
                                                            <input type="file"
                                                                   class="d-none fileUpload"
                                                                   name="vimeo"
                                                                   id="document_file_thumb_vimeo_lesson_section_insider{{$key??1}}">
                                                        </button>
                                                    </div>
                                                @else
                                                    <select class="select2 lessonVimeo vimeoVideoLesson" name="vimeo"
                                                    >
                                                        <option
                                                            data-display="{{__('common.Select')}} {{__('courses.Video')}}"
                                                            value="">{{__('common.Select')}} {{__('courses.Video')}}
                                                        </option>
                                                        @if(isset($edit))
                                                            <option
                                                                value="{{$edit->video_url}}" selected>
                                                            </option>
                                                        @endif
                                                    </select>
                                                @endif
                                                @if ($errors->has('vimeo'))
                                                    <span class="invalid-feedback invalid-select"
                                                          role="alert">
                                            <strong>{{ $errors->first('vimeo') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if (isModuleActive('BunnyStorage'))
                                            <div class="input-effect mt-2 pt-1"
                                                 id="bunnyStreamUrl{{isset($edit)?'_edit_':''}}{{$edit->id??''}}"
                                                 style="display: @if((isset($edit) && ($edit->host!="BunnyStorage")) || !isset($edit)) none  @endif">
                                                <div class="" id="">
                                                    @if(saasEnv('BUNNY_UPLOAD_TYPE')=="Direct")
                                                        <div class="primary_file_uploader">
                                                            <input
                                                                class="primary-input filePlaceholder"
                                                                type="text"
                                                                id=""
                                                                {{$errors->has('image') ? 'autofocus' : ''}}
                                                                placeholder="{{__('courses.Browse Video file')}}"
                                                                readonly="">
                                                            <button class="" type="button">
                                                                <label
                                                                    class="primary-btn small fix-gr-bg"
                                                                    for="document_file_thumb_bunny_lesson_section_insider{{$key??1}}">{{__('common.Browse') }}</label>
                                                                <input type="file"
                                                                       class="d-none fileUpload"
                                                                       name="bunny"
                                                                       id="document_file_thumb_bunny_lesson_section_insider{{$key??1}}">
                                                            </button>
                                                        </div>
                                                    @else
                                                        <select class="select2 lessonBunny BunnyVideoLesson"
                                                                name="bunny"
                                                        >
                                                            <option
                                                                data-display="{{__('common.Select')}} {{__('courses.Video')}}"
                                                                value="">{{__('common.Select')}} {{__('courses.Video')}}
                                                            </option>
                                                            @if(isset($edit) && $edit->bunnyLesson)
                                                                @if($edit->bunnyLesson->service_type == 'stream')
                                                                    <option
                                                                        value="{{$edit->bunnyLesson->video_id}}"
                                                                        selected="selected"> {{$edit->bunnyLesson->video_id}}
                                                                    </option>
                                                                @elseif($edit->bunnyLesson->service_type == 'storage')
                                                                    <option
                                                                        value="{{$edit->bunnyLesson->name}}"
                                                                        selected="selected"> {{$edit->bunnyLesson->name}}
                                                                    </option>
                                                                @endif
                                                            @endif
                                                        </select>
                                                    @endif
                                                    @if ($errors->has('bunny'))
                                                        <span class="invalid-feedback invalid-select"
                                                              role="alert">
                                            <strong>{{ $errors->first('bunny') }}</strong>
                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <div class="input-effect mt-2 pt-1"
                                             id="VdoCipherUrl{{isset($edit)?'_edit_':''}}{{$edit->id??''}}"
                                             style="display: @if((isset($edit) && ($edit->host!="VdoCipher")) || !isset($edit)) none  @endif">
                                            <div class="" id="">

                                                <select class=" lessonVdocipher VdoCipherVideoLesson" name="vdocipher"

                                                >
                                                    <option
                                                        data-display="{{__('common.Select')}} {{__('courses.Video')}}"
                                                        value="">{{__('common.Select')}} {{__('courses.Video')}}
                                                    </option>
                                                    @if(isset($edit))
                                                        <option
                                                            value="{{$edit->video_url}}" selected>
                                                        </option>
                                                    @endif
                                                </select>
                                                @if ($errors->has('vdocipher'))
                                                    <span class="invalid-feedback invalid-select"
                                                          role="alert">
                                                                            <strong>{{ $errors->first('vdocipher') }}</strong>
                                                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $ignoreHost=[
                                                'SCORM',
                                                'SCORM-AwsS3',
                                                'XAPI'.
                                                'XAPI-AwsS3',
                                                'H5P'
                                                ];
                                        @endphp
                                        <div class="input-effect mt-2 pt-1"
                                             id="fileupload{{isset($edit)?'_edit_':''}}{{$edit->id??''}}"
                                             style="display: @if((isset($edit) &&
 ((($edit->host??'')=="Vimeo") ||
  (($edit->host??'')=="BunnyStream") ||
    (($edit->host??'')=="Youtube")||
     (($edit->host??'')=="VdoCipher")||
      (($edit->host??'')=="Iframe")||
                                                $edit->host == 'Storage' ||
                                                $edit->host == 'm3u8' ||

        (($edit->host??'')=="URL")) ) ||
         !isset($edit)) none  @endif">
                                            <input type="file" class="filepond"
                                                   name="file"
                                                   data-file="{{isset($edit)? !in_array($edit->host,$ignoreHost)?$edit->video_url:'':''}}"
                                                   id="">


                                        </div>

                                        <div class="input-effect mt-2 pt-1"
                                             id="media_upload{{isset($edit)?'_edit_':''}}{{$edit->id??''}}"
                                             style="display: @if ((isset($edit) && $edit->host != 'Storage') || !isset($edit)) none @endif">

                                            <x-upload-file
                                                name="video"
                                                required="true"
                                                type="video"
                                                media_id="{{isset($edit)?$edit->video_url_media?->media_id:''}}"
                                                label="{{ __('common.File') }}"
                                            />

                                        </div>

                                    </div>


                                    <div class="input-effect mt-2 pt-1">
                                        <div class="" id="">
                                            <label class="primary_input_label mt-1"
                                                   for="">{{__('courses.Privacy')}}
                                                <span class="required_mark">*</span> </label>
                                            <select class="primary_select" name="is_lock">
                                                <option
                                                    data-display="{{__('common.Select')}} {{__('courses.Privacy')}} "
                                                    value="">{{__('common.Select')}} {{__('courses.Privacy')}} </option>
                                                @if(isset($edit))
                                                    <option value="0"
                                                            @if ( @$edit->is_lock==0) selected @endif >{{__('courses.Unlock')}}</option>
                                                    <option value="1"
                                                            @if (@$edit->is_lock==1) selected @endif >{{__('courses.Locked')}}</option>
                                                @else
                                                    <option
                                                        value="0">{{__('courses.Unlock')}}</option>
                                                    <option value="1"
                                                            selected>{{__('courses.Locked')}}</option>
                                                @endif


                                            </select>
                                            @if ($errors->has('is_lock'))
                                                <span class="invalid-feedback invalid-select"
                                                      role="alert">
                                                                            <strong>{{ $errors->first('is_lock') }}</strong>
                                                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="input-effect mt-2 pt-1">
                                        <label class="primary_input_label mt-1">{{__('common.Description')}}
                                        </label>

                                        <textarea class="primary_textarea height_128" name="description"

                                                  id="description" cols="30"
                                                  rows="10">{{$edit->description??""}}</textarea>


                                        <span class="focus-border"></span>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class=" d-flex justify-content-between mt-3">
                    <button type="button" class="primary-btn tr-bg"
                            data-bs-dismiss="modal">@lang('common.Cancel')</button>

                    <button class="primary-btn fix-gr-bg"
                            type="submit">
                        <i class="ti-check"></i>
                        @lang('common.Submit')</button>
                </div>
            </form>

        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        $('.primary_select').niceSelect();
    })

    initFilePond();


</script>
<script>
    $(document).on('change', '.category_id', function () {
        let key = $(this).data('key');

        let category_id = $('#category_id' + key).find(":selected").val();
        if (category_id === 'Youtube' || category_id === 'URL' || category_id === 'm3u8') {
            $("#iframeBox" + key).hide();
            $("#videoUrl" + key).show();
            $("#vimeoUrl" + key).hide();
            $("#VdoCipherUrl" + key).hide();
            $("#vimeoVideo" + key).val('');
            $("#youtubeVideo" + key).val('');
            $("#fileupload" + key).hide();
            $("#bunnyStreamUrl" + key).hide();
            $("#media_upload" + key).hide();
            $("#editorBox" + key).hide();

        } else if ((category_id === 'Self') || (category_id === 'Zip') || (category_id === 'GoogleDrive') || (category_id === 'PowerPoint') || (category_id === 'Excel') || (category_id === 'Text') || (category_id === 'Word') || (category_id === 'PDF') || (category_id === 'Image') || (category_id === 'AmazonS3') || (category_id === 'SCORM') || (category_id === 'SCORM-AwsS3') || (category_id === 'XAPI') || (category_id === 'XAPI-AwsS3') || (category_id === 'H5P')) {

            $("#iframeBox" + key).hide();
            $("#fileupload" + key).show();
            $("#videoUrl" + key).hide();
            $("#vimeoUrl" + key).hide();
            $("#vimeoVideo" + key).val('');
            $("#youtubeVideo" + key).val('');
            $("#VdoCipherUrl" + key).hide();
            $("#bunnyStreamUrl" + key).hide();
            $("#media_upload" + key).hide();
            $("#editorBox" + key).hide();

        } else if (category_id === 'Vimeo') {
            $("#iframeBox" + key).hide();
            $("#videoUrl" + key).hide();
            $("#vimeoUrl" + key).show();
            $("#vimeoVideo" + key).val('');
            $("#youtubeVideo" + key).val('');
            $("#fileupload" + key).hide();
            $("#VdoCipherUrl" + key).hide();
            $("#bunnyStreamUrl" + key).hide();
            $("#media_upload" + key).hide();
            $("#editorBox" + key).hide();

        } else if (category_id === 'VdoCipher') {
            $("#iframeBox" + key).hide();
            $("#videoUrl" + key).hide();
            $("#vimeoUrl" + key).hide();
            $("#VdoCipherUrl" + key).show();
            $("#vimeoVideo" + key).val('');
            $("#youtubeVideo" + key).val('');
            $("#fileupload" + key).hide();
            $("#bunnyStreamUrl" + key).hide();
            $("#media_upload" + key).hide();
            $("#editorBox" + key).hide();

        } else if (category_id === 'Iframe') {
            $("#iframeBox" + key).show();
            $("#videoUrl" + key).hide();
            $("#vimeoUrl" + key).hide();
            $("#vimeoVideo" + key).val('');
            $("#youtubeVideo" + key).val('');
            $("#fileupload" + key).hide();
            $("#VdoCipherUrl" + key).hide();
            $("#bunnyStreamUrl" + key).hide();
            $("#media_upload" + key).hide();
            $("#editorBox" + key).hide();
        } else if (category_id === 'BunnyStorage') {
            $("#iframeBox" + key).hide();
            $("#videoUrl" + key).hide();
            $("#vimeoUrl" + key).hide();
            $("#bunnyStreamUrl" + key).show();
            $("#vimeoVideo" + key).val('');
            $("#youtubeVideo" + key).val('');
            $("#fileupload" + key).hide();
            $("#VdoCipherUrl" + key).hide();
            $("#media_upload" + key).hide();
            $("#editorBox" + key).hide();

        } else if (category_id === 'Storage') {
            $("#iframeBox" + key).hide();
            $("#videoUrl" + key).hide();
            $("#vimeoUrl" + key).hide();
            $("#bunnyStreamUrl" + key).hide();
            $("#vimeoVideo" + key).val('');
            $("#youtubeVideo" + key).val('');
            $("#fileupload" + key).hide();
            $("#VdoCipherUrl" + key).hide();
            $("#media_upload" + key).show();
            $("#editorBox" + key).hide();
        } else if (category_id === 'Editor') {
            $("#iframeBox" + key).hide();
            $("#videoUrl" + key).hide();
            $("#vimeoUrl" + key).hide();
            $("#bunnyStreamUrl" + key).hide();
            $("#vimeoVideo" + key).val('');
            $("#youtubeVideo" + key).val('');
            $("#fileupload" + key).hide();
            $("#VdoCipherUrl" + key).hide();
            $("#media_upload" + key).hide();
            $("#editorBox" + key).show();
        } else {
            $("#iframeBox" + key).hide();
            $("#videoUrl" + key).hide();
            $("#vimeoUrl" + key).hide();
            $("#vimeoVideo" + key).val('');
            $("#youtubeVideo" + key).val('');
            $("#fileupload" + key).hide();
            $("#VdoCipherUrl" + key).hide();
            $("#bunnyStreamUrl" + key).hide();
            $("#media_upload" + key).hide();
            $("#editorBox" + key).hide();


        }

    });
</script>
<script>


    @if(isModuleActive("BunnyStorage"))
    getBunnyListForLesson()

    function getBunnyListForLesson() {
        $('.BunnyVideoLesson').select2({
            ajax: {
                url: '{{ route('bunny_stream.get_lesson') }}',
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term,
                        page: params.page || 1,
                    }
                },
                // processResults: function (response) {
                //     return {
                //         results: response,
                //         pagination: {
                //             more: true
                //         }
                //     };
                // },
                cache: true
            }
        });
    }
    @endif



    function getVdoCipherListForLesson() {
        $('.VdoCipherVideoLesson').select2({
            ajax: {
                url: '{{ route('getAllVdocipherData') }}',
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term,
                        page: params.page || 1,
                    }
                },
                cache: false
            }
        });
    }

    function getVimeoListForLesson() {
        $('.vimeoVideoLesson').select2({
            ajax: {
                url: '{{ route('getAllVimeoData') }}',
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term,
                        page: params.page || 1,
                    }
                },
                cache: false
            }
        });
    }


    $(document).ready(function () {

        getVdoCipherListForLesson();
        getVimeoListForLesson();

        @if(isset($edit) &&$edit->host=='Vimeo')

        $.ajax({
            url: "{{ url('admin/course/vimeo/video') }}?uri={{$edit->video_url}}",
            success: function (data) {
                $(".vimeoVideoLesson option:selected").text(data.name)
                getVimeoListForLesson();
            },
            error: function () {
                console.log('failed')
            }
        });
        @elseif(isset($edit) &&$edit->host=='VdoCipher')
                    $.ajax({
                        url: "{{ url('admin/course/vdocipher/video') }}/{{$edit->video_url}}",
                        success: function (data) {
                            $(".lessonVdocipher option:selected").text(data.title)
                            getVdoCipherListForLesson();
                        },
                        error: function () {
                            console.log('failed')
                        }
                    });
        @endif


    });
    @if ($edit)
    var editLesson = $('#category_id_edit_{{ $edit->id }}');
    editLesson.trigger('change');


    @endif

    $('#lms_editor').summernote({
        placeholder: '',
        tabsize: 2,
        height: 150,
        tooltip: true,
        callbacks: {
            onImageUpload: function (files) {
                sendFile(files, '#lms_editor')
            }
        }
    });

</script>
