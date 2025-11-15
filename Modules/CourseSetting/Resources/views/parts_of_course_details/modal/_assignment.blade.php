<div class="modal-dialog modal-lg modal-dialog-centered student-details">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                @if($edit)
                    {{__('common.Edit')}}
                @else
                    {{__('common.Add')}}
                @endif
                {{__('assignment.Assignment')}}
            </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form
                @if (isset($edit))
                action="{{route('course_assignment_update')}}" method="POST" id="coupon-form" name="coupon-form"
                enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{$edit->assignmentInfo->id}}">
                @else
                    action="{{route('course_assignment_store')}}"
                    method="POST"
                    name="coupon-form" enctype="multipart/form-data">
                @endif
                @csrf
                <input type="hidden" name="course_id" value="{{$course_id}}">
                <input type="hidden" name="chapter_id" value="{{$chapter_id}}">
                <input type="hidden" name="lesson_id" value="{{isset($edit)?$edit->id:0}}">
                <input type="hidden" name="assignment_from" value="2">


                <div class="row">

                    {{-- input title  --}}
                    <div class="col-xl-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="title">{{ __('common.Title') }} <strong
                                    class="text-danger">*</strong></label>
                            <input name="title" id="title"
                                   class="primary_input_field name {{ @$errors->has('title') ? ' is-invalid' : '' }}"
                                   placeholder="{{ __('common.Title') }}"
                                   type="text"
                                   value="{{isset($edit)?$edit->assignmentInfo->title:old('title')}}" {{$errors->has('title') ? 'autofocus' : ''}}>
                            @if ($errors->has('title'))
                                <span class="invalid-feedback d-block mb-10" role="alert">
                                                                            <strong>{{ @$errors->first('title') }}</strong>
                                                                        </span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="row">

                    {{-- input marks  --}}
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="number">{{ __('assignment.Marks') }}<strong
                                    class="text-danger">*</strong> </label>
                            <input name="marks"
                                   class="primary_input_field name {{ @$errors->has('marks') ? ' is-invalid' : '' }}"
                                   placeholder="{{ __('assignment.Marks') }}"
                                   type="text" id="number" min="0" step="any"
                                   {{$errors->has('marks') ? 'autofocus' : ''}}
                                   value="{{isset($edit)?$edit->assignmentInfo->marks:old('marks')}}">
                            @if ($errors->has('marks'))
                                <span class="invalid-feedback d-block mb-10" role="alert">
                                                                        <strong>{{ @$errors->first('marks') }}</strong>
                                                                    </span>
                            @endif
                        </div>
                    </div>

                    {{-- input Amount  --}}
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label"
                                   for="number2">{{ __('assignment.Min Percentage') }}
                                <strong
                                    class="text-danger">*</strong></label>
                            <input name="min_parcentage"
                                   {{$errors->has('min_parcentage') ? 'autofocus' : ''}}
                                   class="primary_input_field name {{ @$errors->has('code') ? ' is-invalid' : '' }}"
                                   placeholder="{{ __('assignment.Min Percentage') }}"
                                   type="number" id="number2" min="0" step="any"
                                   value="{{isset($edit)?$edit->assignmentInfo->min_parcentage:old('min_parcentage')}}">
                            @if ($errors->has('min_parcentage'))
                                <span class="invalid-feedback d-block mb-10" role="alert">
                                                                        <strong>{{ @$errors->first('min_parcentage') }}</strong>
                                                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class=" mb-35">
                            <x-upload-file
                                name="attachment"
                                media_id="{{isset($edit)?$edit->assignmentInfo->attachment_media?->media_id:''}}"
                                label="{{ __('assignment.Attachment') }}"
                            />

                            @if (isset($edit) && file_exists($edit->assignmentInfo->attachment))
                                 <a href="{{ asset(@$edit->assignmentInfo->attachment) }}" class="primary-btn small fix-gr-bg text-nowrap text-white btn-fit"
                                     download="{{ @$edit->assignmentInfo->title }}_attachment">{{ __('common.Download') }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label"
                                   for="start_date">{{ __('assignment.Submit Date') }}</label>
                            <div class="primary_datepicker_input">
                                <div class="g-0  input-right-icon">
                                    <div class="col">
                                        <div class="">
                                            <input placeholder="{{ __('assignment.Submit Date') }}"
                                                   class="primary_input_field primary-input date form-control  {{ @$errors->has('last_date_submission') ? ' is-invalid' : '' }}"
                                                   id="start_date" type="text"
                                                   name="last_date_submission"
                                                   value="{{isset($edit)?  date('m/d/Y', strtotime(@$edit->assignmentInfo->last_date_submission)) : date('m/d/Y')}}"
                                                   autocomplete="off" required>
                                        </div>
                                    </div>
                                    <button class="" type="button">
                                        <i class="ti-calendar"></i>
                                    </button>
                                </div>
                                @if ($errors->has('start_date'))
                                    <span class="invalid-feedback d-block mb-10"
                                          role="alert">
                                                            <strong>{{ @$errors->first('start_date') }}</strong>
                                                            </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                     <div class="col-lg-12">
                        <div class="input-effect">
                            <label class="primary_input_label"> {{__('assignment.Description')}}
                                <strong
                                    class="text-danger">*</strong>
                            </label>
                            <textarea
                                class="primary_textarea {{ @$errors->has('description') ? ' is-invalid' : '' }}"
                                cols="30" rows="10"
                                name="description">{{isset($edit)? $edit->assignmentInfo->description:(old('description')!=''?(old('description')):'')}}</textarea>

                            <span class="focus-border textarea"></span>
                            @if ($errors->has('description'))
                                <span
                                    class="error text-danger"><strong>{{ $errors->first('description') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-effect mt-2 pt-1">
                            <div class="" id="">
                                <label class="primary_input_label mt-1"
                                       for="">{{__('courses.Privacy')}}
                                    <span class="required_mark">*</span>
                                <select class="primary_select" name="is_lock">
                                    <option
                                        data-display="{{__('common.Select')}} {{__('courses.Privacy')}} "
                                        value="">{{__('common.Select')}} {{__('courses.Privacy')}} </option>
                                    <option
                                        value="0" {{isset($edit) && $edit->is_lock!=1?'selected':''}}>
                                        {{__('courses.Unlock')}}
                                    </option>

                                    <option
                                        value="1" {{isset($edit) && $edit->is_lock==1?'selected':''}}>
                                        {{__('courses.Locked')}}
                                    </option>


                                </select>
                                @if ($errors->has('is_lock'))
                                    <span class="invalid-feedback invalid-select"
                                          role="alert">
                                                                        <strong>{{ $errors->first('is_lock') }}</strong>
                                                                    </span>
                                @endif
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
@include('backend.partials/media_script')
<script>
    $(document).ready(function () {
        $('select').niceSelect();

    })
    $('.primary-input.date').datepicker({
        autoclose: true,
        setDate: new Date()
    });
</script>
