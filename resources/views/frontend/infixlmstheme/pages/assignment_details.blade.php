@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('assignment.Assignment')}}
@endsection
@section('css')
    <link href="{{asset('public/backend/css/summernote-bs5.min.css/')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/compact/css/myProfile.css')}}" rel="stylesheet"/>
    <style>
        ::file-selector-button{
            line-height: 1.4;
        }
    </style>

@endsection
@section('js')

    <script src="{{asset('public/backend/js/summernote-bs5.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            if ($('.lms_summernote').length) {
                $('.lms_summernote').summernote({
                    codeviewFilter: true,
                    codeviewIframeFilter: true,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen']],
                    ],
                    placeholder: 'Answer',
                    tabsize: 2,
                    height: 188,
                    tooltip: false
                });
            }
        });

        $(document).ready(function () {
            $('.note-toolbar').find('[data-toggle]').each(function () {
                $(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
            });
        });
        $(document).ready(function () {
            $('.note-modal').find('[data-dismiss]').each(function () {
                $(this).attr('data-bs-dismiss', $(this).attr('data-dismiss')).removeAttr('data-dismiss');
            });
        });
    </script>

@endsection


@section('mainContent')
    <style>
        .pb_50 {
            padding-bottom: 50px;
        }

        .cs_modal .modal-body input, .cs_modal .modal-body .nice_Select {
            height: 60px;
            line-height: 50px;
            padding: 0px 22px;
            border: 1px solid #F1F3F5;
            color: #707070;
            font-size: 14px;
            font-weight: 500;
            background-color: #fff;
            width: 100%;
        }
    </style>
    <div class="main_content_iner pt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="purchase_history_wrapper pb_50">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('assignment.Assignment')}} {{__('common.Details')}}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        <style>
                            .assignment_info {
                                margin-top: 10px;
                            }
                        </style>
                        <div class="row assignment_info">
                            <div class="col-lg-2">
                                {{__('common.Title')}}
                            </div>
                            <div class="col-lg-4">
                                : {{@$assignment_info->title}}
                            </div>
                            <div class="col-lg-2">
                                {{__('courses.Course')}}
                            </div>
                            <div class="col-lg-4">
                                @if ($assignment_info->course->title)
                                    : {{@$assignment_info->course->title}}
                                @else
                                    : Not Assigned
                                @endif

                            </div>
                        </div>
                        <div class="row assignment_info">
                            <div class="col-lg-2">
                                {{ __('assignment.Marks') }}
                            </div>
                            <div class="col-lg-4">
                                : {{@$assignment_info->marks}}
                            </div>
                            <div class="col-lg-2">
                                {{ __('assignment.Min Percentage') }}
                            </div>
                            <div class="col-lg-4">
                                : {{@$assignment_info->min_parcentage}}%
                            </div>
                        </div>
                        <div class="row assignment_info">
                            <div class="col-lg-2">
                                {{ __('assignment.Submit Date') }}
                            </div>
                            <div class="col-lg-4">
                                : {{showDate(@$assignment_info->last_date_submission)}}
                            </div>
                            @if (file_exists($assignment_info->attachment))

                                <div class="col-lg-2">
                                    {{__('assignment.Attachment')}}
                                </div>
                                <div class="col-lg-4">
                                    : <a href="{{asset(@$assignment_info->attachment)}}"
                                         download="{{@$assignment_info->title}}_attachment">{{__('common.Download')}}</a>
                                </div>
                            @endif
                        </div>
                        <div class="row assignment_info">
                            <div class="col-lg-2">
                                {{__('assignment.Description')}}
                            </div>
                            <div class="col-lg-12">
                                {!! @$assignment_info->description !!}
                            </div>
                        </div>

                        <hr>
                        @php
                            $todate = today()->format('Y-m-d');
                            if (Auth::check()) {
                                $submit_info=Modules\Assignment\Entities\InfixSubmitAssignment::assignmentLastSubmitted($assignment_info->id,Auth::user()->id);
                            }
                        @endphp
                        @if($todate <= $assignment_info->last_date_submission)
                            <h3>{{__('common.Submit')}} {{__('assignment.Assignment')}}</h3>
                            <form action="{{route('submitAssignment')}}" method="Post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="">{{__('subscription.Answer')}} *</label>
                                        <textarea
                                            class="textArea lms_summernote {{ @$errors->has('answer') ? ' is-invalid' : '' }}"
                                            cols="30" rows="10" name="answer">{!! @$submit_info->answer !!}

                                </textarea>
                                        <span class="text-danger" role="alert">{{$errors->first('answer')}}</span>
                                    </div>

                                    <input type="hidden" name="assignment_id"
                                           value="{{$assign_assignment->assignment->id}}">
                                    <input type="hidden" name="assign_id" value="{{$assign_assignment->id}}">
                                    <input type="hidden" name="assignment_from" value="1">
                                    <div class="col-12" style="margin-top: 20px;">
                                        <div class="preview_upload">
                                            <div class="preview_upload_thumb d-none">
                                                <img src="" alt="" id="imgPreview"
                                                     style=" display:none;height: 100%;width: 100%;">
                                                <span
                                                    id="previewTxt">{{__('assignment.Assignment')}} {{__('assignment.Upload')}}</span>
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

                                @if (isset($submit_info) && $submit_info->assigned->pass_status)
                                    @if($submit_info->assigned->pass_status!=1)
                                        <div class="row">

                                            <div class="col-12 text-center">
                                                <div class="offset-4 align-center col-lg-4">
                                                    <button
                                                        class="theme_btn w-100 text-center mt_40">{{__('student.Save')}}</button>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                @else
                                    <div class="row">

                                        <div class="col-12 text-center">
                                            <div class="offset-4 align-center col-lg-4">
                                                <button
                                                    class="theme_btn w-100 text-center mt_40">{{__('student.Save')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        @endif


                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

