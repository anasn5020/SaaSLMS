@php use Carbon\Carbon; @endphp
@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/class.css')}}"/>
@endpush
@php
    $table_name='courses';
@endphp
@section('table')
    {{$table_name}}
@stop
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h3 class="mb-20">
                                        {{__('common.Edit')}}  {{__('virtual-class.Class')}}
                                    </h3>
                                </div>


                                <form method="POST" action="{{ route('custom.meetings.update', $class->id) }}"
                                      class="form-horizontal" enctype="multipart/form-data">
                                    @csrf

                                    <div class="white-box  student-details header-menu">
                                        <div class="add-visitor">

                                            <div class="tab-content">
                                                <div role="tabpanel"
                                                     class="tab-pane fade show active  "
                                                     id="element ">
                                                    <div class="row mt-25">
                                                        <div class="col-lg-12">
                                                            <div class="input-effect">
                                                                <label
                                                                    class="primary_input_label mt-1"> {{ __('courses.Topic') }}
                                                                    <span
                                                                        class="required_mark">*</span></label>
                                                                <input type="text"
                                                                       placeholder="{{ __('courses.Topic') }}"
                                                                       class="primary_input_field name"
                                                                       name="topic"
                                                                       {{ $errors->has('title') ? ' autofocus' : '' }}
                                                                       value="{{ isset($class) ? $class->topic : old('title') }}">
                                                                <span class="focus-border textarea"></span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-25 ">
                                                        <div class="col-lg-12">
                                                            <div class="primary_input">
                                                                <label class="primary_input_label"
                                                                       for="">{{ __('common.Description') }}
                                                                </label>
                                                                <textarea class="lms_summernote  form-control" cols="0"
                                                                          rows="4"
                                                                          placeholder="{{ __('common.Description') }}"
                                                                          name="description"
                                                                          id="description">{{ isset($class) ? $class->description : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row mt-25">
                                                <div class="col-lg-12">
                                                    <div class="input-effect">
                                                        <label
                                                            class="primary_input_label mt-1"> {{ __('virtual-class.Duration') }}
                                                            ({{ __('virtual-class.in Minute') }}) <span
                                                                class="required_mark">*</span></label>
                                                        <input {{ $errors->has('duration') ? ' autofocus' : '' }}
                                                               class="primary_input_field name{{ $errors->has('duration') ? ' is-invalid' : '' }}"
                                                               type="number" name="duration" placeholder="e.g.30min"
                                                               value="{{ isset($class) ? $class->duration : (old('duration') != '' ? old('duration') : '') }}">
                                                        <span class="focus-border"></span>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-20 videoOption" id="overview_host_section">
                                                <div class="col-xl-4 mt-25">
                                                    <select class="primary_select select_host " name="host"
                                                            id="">
                                                        <option
                                                            data-display="{{__('common.Select')}} {{__('virtual-class.Host')}} *"
                                                            value="">{{__('common.Select')}}  {{__('virtual-class.Host')}}
                                                        </option>
                                                        <option
                                                            {{@old('host',$class->host)=="Youtube"?'selected':''}} value="Youtube">
                                                            {{__('courses.Youtube')}}
                                                        </option>

                                                        <option
                                                            value="Vimeo" {{@old('host',$class->host)=="Vimeo"?'selected':''}}>
                                                            {{__('courses.Vimeo')}}
                                                        </option>

                                                        <option
                                                            value="URL" {{@old('host',$class->host)=="URL"?'selected':''}}>
                                                            {{__('courses.URL')}}
                                                        </option>


                                                        <option
                                                            value="Self" {{@old('host',$class->host)=="Self"?'selected':''}}>
                                                            {{__('setting.Storage')}}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-xl-8 ">
                                                    <div class="input-effect videoUrl"
                                                         style="display:@if((isset($class) && (@$class->host!="Youtube")) || !isset($class)) none  @endif">
                                                        <label
                                                            class="primary_input_label mt-1">{{__('courses.Video URL')}}
                                                            <span class="required_mark">*</span></label>
                                                        <input
                                                            id=""
                                                            class="primary_input_field youtubeVideo name{{ $errors->has('link') ? ' is-invalid' : '' }}"
                                                            type="text" name="link"
                                                            placeholder="{{__('courses.Video URL')}}"
                                                            autocomplete="off"
                                                            value="{{$class->link}}" {{$errors->has('link') ? 'autofocus' : ''}}>
                                                        <span class="focus-border"></span>

                                                    </div>


                                                    <div class="row  videofileupload" id=""
                                                         style="display: @if((isset($class) && ((@$class->host=="Vimeo") ||  (@$class->host=="Youtube")) ) || !isset($class)) none  @endif">

                                                        <div class="col-xl-12">
                                                            <x-upload-file
                                                                name="video"
                                                                type="video"
                                                                media_id="{{isset($class)?$class->link_media?->media_id:''}}"
                                                                label="{{__('courses.Video File')}}"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-25">

                                                <div class="col-xl-12">
                                                    <div class="primary_input">
                                                        <label class="primary_input_label"
                                                               for="">{{ __('coupons.Start Date') }}</label>
                                                        <div class="primary_datepicker_input">
                                                            <div class="g-0  input-right-icon">
                                                                <div class="col">
                                                                    <div class="">
                                                                        <input placeholder="Start Date"
                                                                               class="primary_input_field primary-input date form-control  {{ @$errors->has('date') ? ' is-invalid' : '' }}"
                                                                               id="date" type="text"
                                                                               name="date"
                                                                               value="{{isset($class) && !empty($class->date)?getJsDateFormat(Carbon::createFromFormat(getActivePhpDateFormat(),$class->date)->format('m/d/Y')): getJsDateFormat(date('m/d/Y'))}}"
                                                                               autocomplete="off">

                                                                    </div>
                                                                </div>
                                                                <button class="" type="button">
                                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-25">
                                                <div class="col-lg-12">
                                                    <label class="primary_input_label mt-1">{{__('virtual-class.Time')}}
                                                        <span
                                                            class="required_mark">*</span></label>
                                                    <div class="primary_input">
                                                        <input required
                                                               class="primary-input primary_input_field  time form-control{{ @$errors->has('time') ? ' is-invalid' : '' }}"
                                                               type="text" name="time"
                                                               value="{{ isset($class) ? old('time',$class->time): old('time')}}">

                                                    </div>


                                                </div>
                                            </div>


                                            <div class="row mt-25">
                                                <div class="col-lg-12 d-flex justify-content-center align-items-center">
                                                    <button type="submit" class="primary-btn fix-gr-bg"
                                                            data-bs-toggle="tooltip">
                                                        <i class="ti-check"></i>
                                                        {{ __('common.Update') }}
                                                        {{ __('virtual-class.Class') }}
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>

        $('.select_host').change(function () {
            let select_host = $(this).find(":selected").val();
            console.log(select_host);
            if (select_host === 'Youtube' || select_host === 'URL' || select_host === 'Vimeo') {
                $(this).closest('.videoOption').find('.videoUrl').show();
                $(this).closest('.videoOption').find('.videofileupload').hide();

            } else if (select_host === 'Self') {
                $(this).closest('.videoOption').find('.videofileupload').show();
                $(this).closest('.videoOption').find('.videoUrl').hide();

            } else {
                $(this).closest('.videoOption').find('.videofileupload').hide();
                $(this).closest('.videoOption').find('.videoUrl').hide();
            }
        });
        $(document).ready(function () {
            $('.select_host').find(":selected").trigger('change')
        });


    </script>
@endpush
