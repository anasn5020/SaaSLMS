<div class="modal fade admin-query admin_view_modal" id="viewAttachment{{$submitted->id}}">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('common.View')}} {{__('assignment.Attachment')}}</h4>
                <button type="button" class="close " data-bs-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                {!! @$submitted->answer !!}
                <hr>
                @php
                    $std_file =$submitted->file;
                    $ext =strtolower(str_replace('"]','',pathinfo($std_file, PATHINFO_EXTENSION)));
                    $attached_file=str_replace('"]','',$std_file);
                    $attached_file=str_replace('["','',$attached_file);
                    $preview_files=['jpg','jpeg','png','heic','mp4','mov','mp3','mp4','pdf'];
                @endphp
                @if ($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='heic')
                    <img class="img-responsive mt-20" style="width: 100%; height:auto" src="{{asset($attached_file)}}">
                @elseif($ext=='mp4' || $ext=='mov')
                    <video class="mt-20 video_play" width="100%" controls>
                        <source src="{{asset($attached_file)}}" type="video/mp4">
                        <source src="mov_bbb.ogg" type="video/ogg">
                        Your browser does not support HTML video.
                    </video>
                @elseif($ext=='mp3')
                    <audio class="mt-20 audio_play" controls style="width: 100%">
                        <source src="{{asset($attached_file)}}" type="audio/ogg">
                        <source src="horse.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                @elseif($ext=='pdf')
                    <object data='{{asset($attached_file)}}' type="application/pdf" width="100%" height="800">
                        <iframe src='{{asset($attached_file)}}' width="100%" height="800">
                            <p>This browser does not support PDF!</p>
                        </iframe>
                    </object>
                @endif
                @if (!in_array($ext,$preview_files))
                    <div class="alert alert-warning">
                        {{$ext}} File Not Previewable</a>.
                    </div>
                @endif
                <div class="mt-40 d-flex justify-content-between" style="margin-top: 40px;">
                    {{-- <button type="button" class="primary-btn tr-bg" data-bs-dismiss="modal">@lang('lang.cancel')</button> --}}
                    @php
                        $set_filename=time().'_'.$std_file;
                    @endphp
                    @if (file_exists($attached_file))

                        <a class="link_value theme_btn small_btn4" download="{{$set_filename}}"
                           href="{{asset($attached_file)}}"> <span
                                class="pl ti-download"> {{__('common.Download')}}</span></a>
                    @endif
                    {{-- {{route('download-uploaded-content-admin',$uploadedContent->id)}} --}}


                </div>
                <hr>
            </div>

        </div>
    </div>
</div>

