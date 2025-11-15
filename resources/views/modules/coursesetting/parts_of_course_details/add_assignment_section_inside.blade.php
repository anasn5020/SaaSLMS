@php
    $id='assignment_'.uniqid();
@endphp
<div class="mt-20 ">
    @if (isset($edit))
        <form action="{{route('course_assignment_update')}}" method="POST" id="coupon-form" name="coupon-form"
              enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{$edit->id}}">
            @else
                <form action="{{route('course_assignment_store') }}" method="POST" id="coupon-form"
                      name="coupon-form" enctype="multipart/form-data">
                    @endif
                    @csrf

                    <input type="hidden" id="url" value="{{url('/')}}">
                    <input type="hidden" name="course_id" value="{{@$course->id}}">
                    <input type="hidden" name="chapter_id" value="{{@$chapter->id}}">
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
                                       value="{{isset($edit)?$edit->title:''}}" {{$errors->has('title') ? 'autofocus' : ''}}>
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
                                       value="{{isset($edit)?$edit->marks:old('marks')}}">
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
                                       value="{{isset($edit)?$edit->min_parcentage:old('min_parcentage')}}">
                                @if ($errors->has('min_parcentage'))
                                    <span class="invalid-feedback d-block mb-10" role="alert">
                                                                <strong>{{ @$errors->first('min_parcentage') }}</strong>
                                                            </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        {{-- input Amount  --}}
                        <div class="col-xl-6">
                            <div class=" mb-35">
                                <x-upload-file
                                    name="attachment"
                                    media_id="{{isset($edit)?$edit->attachment_media?->media_id:''}}"
                                    label="{{ __('assignment.Attachment') }}"
                                />
                            </div>
                        </div>
                        {{-- Start Date Input --}}
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
                                                       value="{{isset($edit)?  date('m/d/Y', strtotime(@$edit->last_date_submission)) : date('m/d/Y')}}"
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

                        {{-- End Date Input --}}
                        <div class="col-lg-12">
                            <div class="input-effect">
                                <label class="primary_input_label"> {{__('assignment.Description')}} *</label>
                                <textarea
                                    class="primary_textarea {{ @$errors->has('description') ? ' is-invalid' : '' }}"
                                    cols="30" rows="10"
                                    name="description">{{isset($edit)? $edit->description:(old('description')!=''?(old('description')):'')}}</textarea>

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
                                        <span class="required_mark">*</span> </label>
                                    <select class="primary_select" name="is_lock">
                                        <option
                                            data-display="{{__('common.Select')}} {{__('courses.Privacy')}} "
                                            value="">{{__('common.Select')}} {{__('courses.Privacy')}} </option>
                                        @if(isset($lesson))
                                            <option value="0"
                                                    @if ( @$lesson->is_lock==0) selected @endif >{{__('courses.Unlock')}}</option>
                                            <option value="1"
                                                    @if (@$lesson->is_lock==1) selected @endif >{{__('courses.Locked')}}</option>
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
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large fix-gr-bg"
                                        data-bs-toggle="tooltip" title=""
                                        id="save_button_parent">
                                    <i class="ti-check"></i>
                                    @if(!isset($edit))
                                        {{ __('common.Save') }}
                                    @else
                                        {{ __('common.Update') }}
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
</div>
