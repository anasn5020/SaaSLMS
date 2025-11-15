@if(routeIs('CourseChapterShow'))
    <form class="form-horizontal" method="POST" action="{{ route('saveChapter') }}" enctype="multipart/form-data">
        @csrf
        @else
            @if(isset($editChapter) || isset($editLesson))
                <form class="form-horizontal" method="POST" action="{{ route('updateChapter') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @else
                        <form class="form-horizontal" method="POST" action="{{ route('saveChapter') }}" enctype="multipart/form-data">
                            @csrf
                            @endif
                            @endif



                            @php
    $key =$key+100;
@endphp
<input type="hidden" id="url" value="{{url('/')}}">
<input type="hidden" name="course_id" value="{{@$course->id}}">
<input type="hidden" name="chapter_id" value="{{@$chapter->id}}">
<div class="section-white-box">
    <div class="add-visitor">

        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="input_type" value="0" id="">
                <div class="lesson_div">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="input-effect mt-2 pt-1">
                                <label class="primary_input_label mt-1">{{__('courses.Lesson')}} {{__('common.Name')}}
                                    <span class="required_mark">*</span></label>
                                <input
                                    class="primary_input_field name{{ $errors->has('chapter_name') ? ' is-invalid' : '' }}"
                                    type="text" name="name"
                                    placeholder="{{__('courses.Lesson')}} {{__('common.Name')}}"
                                    autocomplete="off"
                                    value="{{isset($editLesson)? $editLesson->name:''}}">
                                <input type="hidden" name="lesson_id"
                                       value="{{isset($editLesson)? $editLesson->id: ''}}">
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
                                <label class="primary_input_label mt-1">{{__('common.Duration')}} ({{__('common.In Minute')}}) </label>
                                <input
                                    class="primary_input_field name{{ $errors->has('chapter_name') ? ' is-invalid' : '' }}"
                                    min="0" step="any" type="number" name="duration"
                                    placeholder="{{__('courses.Duration')}}"
                                    autocomplete="off"
                                    value="{{isset($editLesson)? $editLesson->duration:''}}">

                                <span class="focus-border"></span>
                                @if ($errors->has('chapter_name'))
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('chapter_name') }}</strong>
                                            </span>
                                @endif
                            </div>

                            @if(isModuleActive('Org'))
                                @include('coursesetting::parts_of_course_details._org_host_select')
                            @endif


                            <div class="defaultHost {{isModuleActive('Org')?'d-none':''}}">
                                <div class="input-effect mt-2 pt-1">
                                    <label class="primary_input_label mt-1"
                                           for=""> {{__('courses.Host')}}
                                        <span class="required_mark">*</span></label>


                                    <select class="primary_select category_id host_select" name="host"
                                            data-key="{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                            id="category_id{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}">
                                        <option data-display="{{__('common.Select')}} {{__('courses.Host')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Host')}} </option>


                                        <option
                                            value="Youtube" {{isset($editLesson) ? $editLesson->host=='Youtube'? 'selected':'':'' }} >
                                            Youtube
                                        </option>

                                        <option
                                            value="Vimeo" {{isset($editLesson) ? $editLesson->host=='Vimeo'? 'selected':'':'' }} >
                                            Vimeo
                                        </option>
                                        <option
                                            value="VdoCipher" {{isset($editLesson) ? $editLesson->host=='VdoCipher'? 'selected':'':'' }} >
                                            VdoCipher
                                        </option>
                                        <option
                                            value="Self" {{isset($editLesson) ? $editLesson->host=='Self'? 'selected':'':'' }} >
                                            Self
                                        </option>


                                        <option
                                            value="URL" {{isset($editLesson) ? $editLesson->host=='URL'? 'selected':'':'' }} >
                                            Video URL
                                        </option>
                                        <option
                                            value="Iframe" {{isset($editLesson) ? $editLesson->host=='Iframe'? 'selected':'':'' }} >
                                            Iframe embed
                                        </option>
                                        <option
                                            value="Image" {{isset($editLesson) ? $editLesson->host=='Image'? 'selected':'':'' }} >
                                            Image
                                        </option>
                                        <option
                                            value="PDF" {{isset($editLesson) ? $editLesson->host=='PDF'? 'selected':'':'' }} >
                                            PDF File
                                        </option>
                                        <option
                                            value="Word" {{isset($editLesson) ? $editLesson->host=='Word'? 'selected':'':'' }} >
                                            Word File
                                        </option>
                                        <option
                                            value="Excel" {{isset($editLesson) ? $editLesson->host=='Excel'? 'selected':'':'' }} >
                                            Excel File
                                        </option>
                                        <option
                                            value="Text" {{isset($editLesson) ? $editLesson->host=='Text'? 'selected':'':'' }} >
                                            Text File
                                        </option>
                                        <option
                                            value="Zip" {{isset($editLesson) ? $editLesson->host=='Zip'? 'selected':'':'' }} >
                                            Zip File
                                        </option>

                                        <option
                                            value="m3u8" {{isset($editLesson) ? $editLesson->host=='m3u8'? 'selected':'':'' }} >
                                            M3U8
                                        </option>

                                        <option value="GoogleDrive"
                                                @if (@$editLesson->host=='GoogleDrive') Selected
                                                @endif
                                                @if(empty(@$editLesson) && @$editLesson->host=="GoogleDrive") selected @endif >
                                            Google Drive
                                        </option>
                                        <option
                                            value="PowerPoint" {{isset($editLesson) ? $editLesson->host=='PowerPoint'? 'selected':'':'' }} >
                                            Power Point File
                                        </option>

                                        @if(isModuleActive("AmazonS3"))
                                            <option
                                                value="AmazonS3" {{isset($editLesson) ? $editLesson->host=='AmazonS3'? 'selected':'':'' }} >
                                                Amazon S3
                                            </option>
                                        @endif

                                        @if (isModuleActive('BunnyStorage'))
                                            <option
                                                value="BunnyStorage" {{isset($editLesson) ? $editLesson->host=='BunnyStorage'? 'selected':'':'' }}>
                                                Bunny Storage
                                            </option>
                                        @endif


                                        @if(isModuleActive("SCORM"))
                                            <option
                                                value="SCORM" {{isset($editLesson) ? $editLesson->host=='SCORM'? 'selected':'':'' }} >
                                                SCORM Self
                                            </option>
                                        @endif
                                        @if (isModuleActive('H5P'))
                                            <option value="H5P"
                                                {{isset($editLesson) ? $editLesson->host=='H5P'? 'selected':'':'' }}
                                            >
                                                H5P
                                            </option>
                                        @endif

                                        @if(isModuleActive("AmazonS3") && isModuleActive("SCORM"))
                                            <option
                                                value="SCORM-AwsS3" {{isset($editLesson) ? $editLesson->host=='SCORM-AwsS3'? 'selected':'':'' }} >
                                                SCORM AWS S3
                                            </option>
                                        @endif

                                        @if(isModuleActive("XAPI"))
                                            <option value="XAPI"
                                                {{isset($editLesson) ? $editLesson->host=='XAPI'? 'selected':'':'' }}
                                            >
                                                XAPI Self
                                            </option>
                                        @endif

                                        @if(isModuleActive("AmazonS3") && isModuleActive("XAPI"))
                                            <option value="XAPI-AwsS3"
                                                {{isset($editLesson) ? $editLesson->host=='XAPI-AwsS3'? 'selected':'':'' }}
                                            >
                                                XAPI AWS S3
                                            </option>
                                        @endif
                                        <option
                                            value="Storage" {{isset($editLesson) ? $editLesson->host=='Storage'? 'selected':'':'' }} >
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
                                     id="videoUrl{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                     style="display:@if((isset($editLesson) && ($editLesson->host!="Youtube"  && $editLesson->host!="URL"  && $editLesson->host!="m3u8")) || !isset($editLesson)) none  @endif">
                                    <label class="primary_input_label mt-1">{{__('courses.Video URL')}}
                                        <span class="required_mark">*</span></label>
                                    <input
                                        id="youtubeVideo"
                                        class="primary_input_field name{{ $errors->has('video_url') ? ' is-invalid' : '' }}"
                                        type="text" name="video_url"
                                        placeholder="{{__('courses.Video URL')}}"
                                        autocomplete="off"
                                        value="@if(isset($editLesson)) @if($editLesson->host=="Youtube" || $editLesson->host=="URL" || $editLesson->host=="m3u8"){{$editLesson->video_url}} @endif @endif">
                                    <span class="focus-border"></span>
                                    @if ($errors->has('video_url'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('video_url') }}</strong>
                                            </span>
                                    @endif
                                </div>

                                <div class="input-effect mt-2 pt-1"
                                     id="iframeBox{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                     style="display: @if((isset($editLesson) && ($editLesson->host!="Iframe")) || !isset($editLesson)) none  @endif">
                                    <div class="" id="">

                                        <label class="primary_input_label mt-1">{{__('courses.Iframe URL')}}
                                            <span class="required_mark">*</span></label>
                                        <input
                                            class="primary_input_field name{{ $errors->has('iframe_url') ? ' is-invalid' : '' }}"
                                            type="text" name="iframe_url"
                                            placeholder="{{__('courses.Iframe (Provide the source only)')}}"
                                            autocomplete="off"
                                            value="@if(isset($editLesson)) @if($editLesson->host=="Iframe"){{$editLesson->video_url}} @endif @endif">
                                        <span class="focus-border"></span>
                                        @if ($errors->has('video_url'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('video_url') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="input-effect mt-2 pt-1"
                                     id="vimeoUrl{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                     style="display: @if((isset($editLesson) && ($editLesson->host!="Vimeo")) || !isset($editLesson)) none  @endif">
                                    <div class="" id="">
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
                                                        for="document_file_thumb_vimeo_lesson_section_insider{{$key}}">{{__('common.Browse') }}</label>
                                                    <input type="file"
                                                           class="d-none fileUpload"
                                                           name="vimeo"
                                                           id="document_file_thumb_vimeo_lesson_section_insider{{$key}}">
                                                </button>
                                            </div>
                                        @else
                                            <select class="select2 lessonVimeo vimeoVideoLesson" name="vimeo"
                                            >
                                                <option
                                                    data-display="{{__('common.Select')}} {{__('courses.Video')}}"
                                                    value="">{{__('common.Select')}} {{__('courses.Video')}}
                                                </option>
                                                @if(isset($editLesson))
                                                    <option
                                                        value="{{$editLesson->video_url}}" selected>
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
                                         id="bunnyStreamUrl{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                         style="display: @if((isset($editLesson) && ($editLesson->host!="BunnyStorage")) || !isset($editLesson)) none  @endif">
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
                                                            for="document_file_thumb_bunny_lesson_section_insider{{$key}}">{{__('common.Browse') }}</label>
                                                        <input type="file"
                                                               class="d-none fileUpload"
                                                               name="bunny"
                                                               id="document_file_thumb_bunny_lesson_section_insider{{$key}}">
                                                    </button>
                                                </div>
                                            @else
                                                <select class="select2 lessonBunny BunnyVideoLesson" name="bunny"
                                                >
                                                    <option
                                                        data-display="{{__('common.Select')}} {{__('courses.Video')}}"
                                                        value="">{{__('common.Select')}} {{__('courses.Video')}}
                                                    </option>
                                                    @if(isset($editLesson) && $editLesson->bunnyLesson)
                                                        @if($editLesson->bunnyLesson->service_type == 'stream')
                                                            <option
                                                                value="{{$editLesson->bunnyLesson->video_id}}"
                                                                selected="selected"> {{$editLesson->bunnyLesson->video_id}}
                                                            </option>
                                                        @elseif($editLesson->bunnyLesson->service_type == 'storage')
                                                            <option
                                                                value="{{$editLesson->bunnyLesson->name}}"
                                                                selected="selected"> {{$editLesson->bunnyLesson->name}}
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
                                     id="VdoCipherUrl{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                     style="display: @if((isset($editLesson) && ($editLesson->host!="VdoCipher")) || !isset($editLesson)) none  @endif">
                                    <div class="" id="">

                                        <select class=" lessonVdocipher VdoCipherVideoLesson" name="vdocipher"

                                        >
                                            <option
                                                data-display="{{__('common.Select')}} {{__('courses.Video')}}"
                                                value="">{{__('common.Select')}} {{__('courses.Video')}}
                                            </option>
                                            @if(isset($editLesson))
                                                <option
                                                    value="{{$editLesson->video_url}}" selected>
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
                                     id="fileupload{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                     style="display: @if((isset($editLesson) &&
 (($editLesson->host=="Vimeo") ||
  ($editLesson->host=="BunnyStream") ||
    ($editLesson->host=="Youtube")||
     ($editLesson->host=="VdoCipher")||
      ($editLesson->host=="Iframe")||
                                                $editLesson->host == 'Storage' ||
                                                $editLesson->host == 'm3u8' ||

        ($editLesson->host=="URL")) ) ||
         !isset($editLesson)) none  @endif">
                                    <input type="file" class="filepond"
                                           name="file"
                                           data-file="{{isset($editLesson)? !in_array($editLesson->host,$ignoreHost)?$editLesson->video_url:'':''}}"
                                           id="">


                                </div>

                                <div class="input-effect mt-2 pt-1"
                                     id="media_upload{{isset($editSection)?'_edit_':''}}{{isset($editLesson)? $editLesson->id:$key}}"
                                     style="display: @if ((isset($editLesson) && $editLesson->host != 'Storage') || !isset($editLesson)) none @endif">

                                    <x-upload-file
                                        name="video"
                                        required="true"
                                        type="video"
                                        media_id="{{isset($editLesson)?$editLesson->video_url_media?->media_id:''}}"
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
                                        @if(isset($editLesson))
                                            <option value="0"
                                                    @if ( @$editLesson->is_lock==0) selected @endif >{{__('courses.Unlock')}}</option>
                                            <option value="1"
                                                    @if (@$editLesson->is_lock==1) selected @endif >{{__('courses.Locked')}}</option>
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
                                          rows="10">{{isset($editLesson)? $editLesson->description:''}}</textarea>


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

        <div class="row mt-40">
            <div class="col-lg-12 text-center">
                <button type="submit" class="primary-btn fix-gr-bg"
                        data-bs-toggle="tooltip">
                    <i class="ti-check"></i>
                    {{__('common.Save')}}
                </button>
            </div>
        </div>
    </div>
</div>
                        </form>
