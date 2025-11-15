@if (routeIs('CourseChapterShow'))
    <form class="form-horizontal" method="POST" action="{{ route('saveChapter') }}" enctype="multipart/form-data">
        @csrf
        @else
            @if (isset($editChapter) || isset($editLesson))
                <form class="form-horizontal" method="POST" action="{{ route('updateChapter') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @else
                        <form class="form-horizontal" method="POST" action="{{ route('saveChapter') }}" enctype="multipart/form-data">
                            @csrf
                            @endif
                            @endif


                            <input type="hidden" id="url" value="{{ url('/') }}">
<input type="hidden" name="course_id" value="{{ @$course->id }}">
<div class="section-white-box">
    <div class="add-visitor">

        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="input_type" value="0" id="">
                <div class="lesson_div">
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="primary_input_label mt-1" for=""> {{ __('courses.Chapter') }}
                                <span class="required_mark">*</span></label>
                            <select class="primary_select" name="chapter_id">
                                <option data-display="{{ __('common.Select') }} {{ __('courses.Chapter') }}"
                                        value="">{{ __('common.Select') }} {{ __('courses.Chapter') }} </option>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ @$chapter->id }}"
                                        {{ isset($editLesson) ? ($editLesson->chapter_id == $chapter->id ? 'selected' : '') : '' }}>
                                        {{ @$chapter->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <div class="input-effect mt-2 pt-1">
                                <label class="primary_input_label mt-1">{{ __('courses.Lesson') }} {{ __('common.Name') }}
                                    <span class="required_mark">*</span></label>
                                <input
                                    class="primary_input_field name{{ $errors->has('chapter_name') ? ' is-invalid' : '' }}"
                                    type="text" name="name"
                                    placeholder="{{ __('courses.Lesson') }} {{ __('common.Name') }}"
                                    autocomplete="off" value="{{ isset($editLesson) ? $editLesson->name : '' }}">
                                <input type="hidden" name="lesson_id"
                                       value="{{ isset($editLesson) ? $editLesson->id : '' }}">
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
                                <label class="primary_input_label mt-1">{{ __('common.Duration') }} ({{ __('common.In Minute') }}) </label>
                                <input
                                    class="primary_input_field name{{ $errors->has('chapter_name') ? ' is-invalid' : '' }}"
                                    min="0" step="any" type="number" name="duration"
                                    placeholder="{{ __('courses.Duration') }}" autocomplete="off"
                                    value="{{ isset($editLesson) ? $editLesson->duration : '' }}">

                                <span class="focus-border"></span>
                                @if ($errors->has('chapter_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('chapter_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @if (isModuleActive('Org'))

                                @include('coursesetting::parts_of_course_details._org_host_select')

                            @endif

                            <div class="defaultHost {{ isModuleActive('Org') ? 'd-none' : '' }}">

                                <div class="input-effect mt-2 pt-1">
                                    <label class="primary_input_label mt-1" for=""> {{ __('courses.Host') }}
                                        <span class="required_mark">*</span></label>


                                    <select class="primary_select host_select" name="host" id="category_id">
                                        <option data-display="{{ __('common.Select') }} {{ __('courses.Host') }}"
                                                value="">{{ __('common.Select') }} {{ __('courses.Host') }}
                                        </option>
                                        <option value="Youtube" @if (@$editLesson->host == 'Youtube') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'Youtube') selected @endif>
                                            Youtube
                                        </option>

                                        <option value="Vimeo" @if (@$editLesson->host == 'Vimeo') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'Vimeo') selected @endif>
                                            Vimeo
                                        </option>
                                        <option value="Self" @if (@$editLesson->host == 'Self') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'Self')  selected @endif>
                                            Self
                                        </option>
                                        <option value="VdoCipher" @if (@$editLesson->host == 'VdoCipher') Selected
                                                @endif
                                                @if (empty(@$editLesson) && @$editLesson->host == 'VdoCipher') selected @endif>
                                            VdoCipher
                                        </option>
                                        <option value="URL" @if (@$editLesson->host == 'URL') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'URL') selected @endif>
                                            Video URL
                                        </option>

                                        <option value="Iframe" @if (@$editLesson->host == 'Iframe') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'Iframe') selected @endif>
                                            Iframe embed
                                        </option>

                                        <option value="Image" @if (@$editLesson->host == 'Image') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'Image') selected @endif>
                                            Image
                                        </option>

                                        <option value="PDF" @if (@$editLesson->host == 'PDF') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'PDF') selected @endif>
                                            PDF File
                                        </option>

                                        <option value="Word" @if (@$editLesson->host == 'Word') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'Word') selected @endif>
                                            Word File
                                        </option>


                                        <option value="Excel" @if (@$editLesson->host == 'Excel') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'Excel') selected @endif>
                                            Excel File
                                        </option>

                                        <option value="PowerPoint" @if (@$editLesson->host == 'PowerPoint') Selected
                                                @endif
                                                @if (empty(@$editLesson) && @$editLesson->host == 'PowerPoint') selected @endif>
                                            Power Point File
                                        </option>


                                        <option value="Text" @if (@$editLesson->host == 'Text') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'Text') selected @endif>
                                            Text File
                                        </option>


                                        <option value="Zip" @if (@$editLesson->host == 'Zip') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'Zip') selected @endif>
                                            Zip File
                                        </option>

                                        <option value="m3u8" @if (@$editLesson->host == 'm3u8') Selected @endif
                                        @if (empty(@$editLesson) && @$editLesson->host == 'm3u8') selected @endif>
                                            M3U8
                                        </option>

                                        <option value="GoogleDrive" @if (@$editLesson->host == 'GoogleDrive') Selected
                                                @endif
                                                @if (empty(@$editLesson) && @$editLesson->host == 'GoogleDrive') selected @endif>
                                            Google Drive
                                        </option>

                                        @if (isModuleActive('AmazonS3'))
                                            <option value="AmazonS3" @if (@$editLesson->host == 'AmazonS3') Selected
                                                    @endif
                                                    @if (empty(@$editLesson) && @$editLesson->host== 'AmazonS3') selected @endif>
                                                Amazon S3
                                            </option>
                                        @endif

                                        @if (isModuleActive('BunnyStorage'))
                                            <option value="BunnyStream"
                                                    @if (@$editLesson->host == 'BunnyStream') Selected
                                                    @endif
                                                    @if (empty(@$editLesson) &&  @$editLesson->host == 'BunnyStream') selected @endif
                                            >

                                                Bunny Stream
                                            </option>
                                        @endif


                                        @if (isModuleActive('SCORM'))
                                            <option value="SCORM"
                                                    @if (empty(@$editLesson) && @$editLesson->host == 'SCORM') selected @endif>
                                                SCORM Self
                                            </option>
                                        @endif
                                        @if (isModuleActive('H5P'))
                                            <option value="H5P"
                                                    @if (empty(@$editLesson) && @$editLesson->host == 'H5P') selected @endif>
                                                H5P
                                            </option>
                                        @endif

                                        @if (isModuleActive('AmazonS3') && isModuleActive('SCORM'))
                                            <option value="SCORM-AwsS3"
                                                    @if (empty(@$editLesson) && @$editLesson->host== 'SCORM-AwsS3') selected @endif>
                                                SCORM AWS S3
                                            </option>
                                        @endif

                                        @if (isModuleActive('XAPI'))
                                            <option value="XAPI"
                                                    @if (empty(@$editLesson) && @$editLesson->host== 'XAPI') selected @endif>
                                                XAPI Self
                                            </option>
                                        @endif

                                        @if (isModuleActive('AmazonS3') && isModuleActive('XAPI'))
                                            <option value="XAPI-AwsS3"
                                                    @if (empty(@$editLesson) && @$editLesson->host== 'XAPI-AwsS3') selected @endif>
                                                XAPI AWS S3
                                            </option>
                                        @endif


                                        <option value="Storage"
                                                @if (empty(@$editLesson) && @$editLesson->host== 'Storage') selected @endif>
                                            Storage
                                        </option>

                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="input-effect mt-2 pt-1" id="videoUrl"
                                     style="display:@if ((isset($editLesson) && ($editLesson->host != 'Youtube' && $editLesson->host != 'URL' && $editLesson->host != 'm3u8')) || !isset($editLesson)) none @endif">
                                    <label class="primary_input_label mt-1">{{ __('courses.Video URL') }}
                                        <span class="required_mark">*</span></label>
                                    <input id="youtubeVideo"
                                           class="primary_input_field name{{ $errors->has('video_url') ? ' is-invalid' : '' }}"
                                           type="text" name="video_url" placeholder="{{ __('courses.Video URL') }}"
                                           autocomplete="off"
                                           value="@if (isset($editLesson)) @if ($editLesson->host == 'Youtube' || $editLesson->host == 'URL' || $editLesson->host == 'm3u8'){{ $editLesson->video_url }} @endif @endif">
                                    <span class="focus-border"></span>
                                    @if ($errors->has('video_url'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('video_url') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="input-effect mt-2 pt-1" id="iframeBox"
                                     style="display: @if ((isset($editLesson) && $editLesson->host != 'Iframe') || !isset($editLesson)) none @endif">
                                    <div class="" id="">

                                        <label class="primary_input_label mt-1">{{ __('courses.Iframe URL') }}
                                            <span class="required_mark">*</span></label>
                                        <input
                                            class="primary_input_field name{{ $errors->has('iframe_url') ? ' is-invalid' : '' }}"
                                            type="text" name="iframe_url"
                                            placeholder="{{ __('courses.Iframe (Provide the source only)') }}"
                                            autocomplete="off"
                                            value="@if (isset($editLesson)) @if ($editLesson->host == 'Iframe'){{ $editLesson->video_url }} @endif @endif">
                                        <span class="focus-border"></span>
                                        @if ($errors->has('video_url'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('video_url') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="input-effect mt-2 pt-1" id="vimeoUrl"
                                     style="display: @if ((isset($editLesson) && $editLesson->host != 'Vimeo') || !isset($editLesson)) none @endif">
                                    <div class="" id="">
                                        @if (config('vimeo.connections.main.upload_type') == 'Direct')
                                            <div class="primary_file_uploader">
                                                <input class="primary-input filePlaceholder" type="text"
                                                       id="" {{ $errors->has('image') ? 'autofocus' : '' }}
                                                       placeholder="{{ __('courses.Browse Video file') }}"
                                                       readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="document_file_thumb_vimeo_lesson_section">{{ __('common.Browse') }}</label>
                                                    <input type="file" class="d-none fileUpload" name="vimeo"
                                                           id="document_file_thumb_vimeo_lesson_section">
                                                </button>
                                            </div>
                                        @else
                                            <select class="select2 lessonVimeo vimeoVideoLesson" name="vimeo">
                                                <option
                                                    data-display="{{ __('common.Select') }} {{ __('courses.Video') }}"
                                                    value="">{{ __('common.Select') }}
                                                    {{ __('courses.Video') }}
                                                </option>

                                            </select>
                                        @endif
                                        @if ($errors->has('vimeo'))
                                            <span class="invalid-feedback invalid-select" role="alert">
                                                <strong>{{ $errors->first('vimeo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if (isModuleActive('BunnyStorage'))

                                    <div class="input-effect mt-2 pt-1" id="bunnyStreamUrl"
                                         style="display: @if ((isset($editLesson) && $editLesson->host != 'Vimeo') || !isset($editLesson)) none @endif">
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
                                                            for="document_file_thumb_bunny_lesson_section_insider">{{__('common.Browse') }}</label>
                                                        <input type="file"
                                                               class="d-none fileUpload"
                                                               name="bunny"
                                                               id="document_file_thumb_bunny_lesson_section_insider">
                                                    </button>
                                                </div>
                                            @else
                                                <select class="select2 lessonBunny BunnyVideoLesson" name="bunny"
                                                >
                                                    <option
                                                        data-display="{{__('common.Select')}} {{__('courses.Video')}}"
                                                        value="">{{__('common.Select')}} {{__('courses.Video')}}
                                                    </option>

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


                                <div class="input-effect mt-2 pt-1" id="VdoCipherUrl"
                                     style="display: @if ((isset($editLesson) && $editLesson->host != 'VdoCipher') || !isset($editLesson)) none @endif">
                                    <div class="" id="">

                                        <select class="select2 lessonVdocipher VdoCipherVideoLesson" name="vdocipher"
                                                id="VdoCipherVideo">
                                            <option
                                                data-display="{{ __('common.Select') }} {{ __('courses.Video') }}"
                                                value="">{{ __('common.Select') }} {{ __('courses.Video') }}
                                            </option>
                                        </select>
                                        @if ($errors->has('vdocipher'))
                                            <span class="invalid-feedback invalid-select" role="alert">
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


                                <div class="input-effect mt-2 pt-1" id="fileupload"
                                     style="display: @if (
                                        (isset($editLesson) &&
                                            ($editLesson->host == 'Vimeo' ||
                                                $editLesson->host == 'Youtube' ||
                                                $editLesson->host == 'vdocipher' ||
                                                $editLesson->host == 'Iframe' ||
                                                $editLesson->host == 'Storage' ||
                                                $editLesson->host == 'm3u8' ||
                                                $editLesson->host == 'URL')) ||
                                            !isset($editLesson)) none @endif">
                                    <input type="file" class="filepond" name="file" id=""
                                           data-file="{{isset($editLesson)? !in_array($editLesson->host,$ignoreHost)?$editLesson->video_url:'':''}}">
                                </div>


                                <div class="input-effect mt-2 pt-1" id="media_upload"
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
                                           for="">{{ __('courses.Privacy') }}
                                        <span class="required_mark">*</span> </label>
                                    <select class="primary_select" name="is_lock">
                                        <option data-display="{{ __('common.Select') }} {{ __('courses.Privacy') }} "
                                                value="">{{ __('common.Select') }} {{ __('courses.Privacy') }}
                                        </option>
                                        @if (isset($editLesson))
                                            <option value="0" @if (@$editLesson->is_lock == 0) selected @endif>
                                                {{ __('courses.Unlock') }}</option>
                                            <option value="1" @if (@$editLesson->is_lock == 1) selected @endif>
                                                {{ __('courses.Locked') }}</option>
                                        @else
                                            <option value="0">{{ __('courses.Unlock') }}</option>
                                            <option value="1" selected>{{ __('courses.Locked') }}</option>
                                        @endif


                                    </select>
                                    @if ($errors->has('is_lock'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('is_lock') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="input-effect mt-2 pt-1">
                                <label class="primary_input_label mt-1">{{ __('common.Description') }}
                                </label>
                                <input
                                    class="primary_input_field name{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                    type="text" name="description" placeholder="{{ __('common.Description') }}"
                                    autocomplete="off" value="{{ isset($editLesson) ? $editLesson->description : '' }}">
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
                <button type="submit" class="primary-btn fix-gr-bg" data-bs-toggle="tooltip">
                    <i class="ti-check"></i>
                    {{ __('common.Save') }}
                </button>
            </div>
        </div>
    </div>
</div>

                        </form>
<script>
    $('#category_id').trigger('change');
    $('#category_id1').trigger('change');
</script>
