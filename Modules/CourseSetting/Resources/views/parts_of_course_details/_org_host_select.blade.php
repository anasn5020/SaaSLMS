@php
    $rand = rand(1,100);
@endphp
<div class="input-effect mt_25 pt-1">
    <div class="row">
        <div class="col-md-4">
            <input type="radio"
                   class="common-radio fileType"
                   id="{{$rand}}fileTypeExisting{{isset($editLesson)?$editLesson->id:''}}"
                   name="fileType" {{isset($editLesson)&&!$isDefault? 'checked':''}}
                   value="1">
            <label
                for="{{$rand}}fileTypeExisting{{isset($editLesson)?$editLesson->id:''}}">{{__('common.Existing')}}</label>
        </div>
        <div class="col-md-4">

            <input type="radio"
                   class="common-radio fileType"
                   id="{{$rand}}fileTypeNew{{isset($editLesson)?$editLesson->id:''}}"
                   name="fileType"
                   value="0">
            <label
                for="{{$rand}}fileTypeNew{{isset($editLesson)?$editLesson->id:''}}">{{__('common.New')}}</label>
        </div>
        <div class="col-md-4">

            <input type="radio"
                   class="common-radio fileType"
                   id="{{$rand}}fileTypeDefault{{isset($editLesson)?$editLesson->id:''}}"
                   name="fileType"
                   @if(isset($isDefault))
                   {{$isDefault?'checked':''}}
                   @endif
                   value="2">
            <label
                for="{{$rand}}fileTypeDefault{{isset($editLesson)?$editLesson->id:''}}">{{__('common.Default')}}</label>
        </div>
    </div>
</div>
<div class="input-effect mt-2 pt-1 selectOrgFile">
    <label class="primary_input_label mt-1"> {{__('org.Selected File')}} </label>
    <input
        class="primary_input_field FilePath "
        min="0" step="any" type="text" name="file_path" readonly
        autocomplete="off"
        value="{{isset($editLesson)? $editLesson->video_url:''}}">
</div>
<input type="hidden" name="file_type" class="FileType" value="{{isset($editLesson)? $editLesson->host:''}}">
<input type="hidden" name="scorm_title" class="scorm_title" value="{{isset($editLesson)? $editLesson->scorm_title:''}}">
<input type="hidden" name="scorm_version" class="scorm_version" value="{{isset($editLesson)? $editLesson->scorm_version:''}}">
<input type="hidden" name="scorm_identifier" class="scorm_identifier" value="{{isset($editLesson)? $editLesson->scorm_identifier:''}}">
