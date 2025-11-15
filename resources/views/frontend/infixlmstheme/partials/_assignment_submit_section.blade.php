<hr>

<h3>{{__('common.Submit')}} {{__('assignment.Assignment')}}</h3>
<form action="{{route('submitAssignment')}}" method="Post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <label for="">{{__('subscription.Answer')}} *</label>
            <textarea class="textArea lms_summernote {{ @$errors->has('answer') ? ' is-invalid' : '' }}"
                      cols="30" rows="10" name="answer"> {!! @$submit_info->answer !!}

                              </textarea>
            <span class="text-danger" role="alert">{{$errors->first('answer')}}</span>
        </div>

        <input type="hidden" name="assignment_id" value="{{@$assignment_info->id}}">
        <input type="hidden" name="lesson_id" value="{{@$lesson->id}}">
        <input type="hidden" name="course_id" value="{{@$course->id}}">
        <input type="hidden" name="assignment_from" value="2">
        <div class="col-12 mt-3">
            <div class="preview_upload">
                <div class="preview_upload_thumb d-none">
                    <img src="" alt="" id="imgPreview"
                         style=" display:none;height: 100%;width: 100%;">
                    <span id="previewTxt">{{__('assignment.Assignment')}} {{__('assignment.Upload')}}</span>
                </div>
                <div class="preview_drag">
                    <div class="preview_drag_inner">
                        <div class="chose_file">
                            <input type="file" name="attached_file" id="imgInp">
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="row">

        <div class="col-12 text-center">
            <div class="align-center">
                <button class="theme_btn   text-center ">{{__('student.Save')}}</button>
            </div>
        </div>
    </div>
</form>
