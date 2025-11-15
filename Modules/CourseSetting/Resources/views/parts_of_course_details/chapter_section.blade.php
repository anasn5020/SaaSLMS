@if(isset($editChapter) || isset($editLesson))
    <form class="form-horizontal" method="POST" action="{{ route('updateChapter') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @else
            <form class="form-horizontal" method="POST" action="{{ route('saveChapter') }}" enctype="multipart/form-data">
                @csrf
                @endif


                <input type="hidden" id="url" value="{{url('/')}}">
<input type="hidden" name="course_id" value="{{@$course->id}}">
<input type="hidden" name="input_type" value="1">
<input type="hidden" name="is_lock" value="1">
<div class="section-white-box">
    <div class="add-visitor">
        <div class="input-effect mt-2 pt-1 mb-20">
            <label class="primary_input_label mt-1">{{__('quiz.Chapter')}} {{__('common.Name')}}
                <span class="required_mark">*</span></label>
            <input
                class="primary_input_field name{{ $errors->has('chapter_name') ? ' is-invalid' : '' }}"
                type="text" name="chapter_name" placeholder="{{ __('common.Title') }}"
                autocomplete="off"
                value="{{isset($editChapter)? $editChapter->name:''}}">
            <input type="hidden" name="chapter"
                   value="{{isset($editChapter)? $editChapter->id: ''}}">
            <span class="focus-border"></span>
            @if ($errors->has('chapter_name'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('chapter_name') }}</strong>
                    </span>
            @endif
        </div>
        <div class="row mt-40" style="visibility: hidden">
            <div class="col-lg-12 text-center">
                <button type="submit" class="primary-btn fix-gr-bg"
                        data-bs-toggle="tooltip">
                    <i class="ti-check"></i>
                    {{__('common.Save')}}
                </button>
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
