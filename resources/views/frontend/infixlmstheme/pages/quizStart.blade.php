@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |    {{$course->title}}
@endsection
@section('css')
    <link href="{{asset('public/backend/css/summernote-bs5.min.css')}}{{assetVersion()}}" rel="stylesheet">
    <link href="{{asset('public/backend/css/jquery-ui.css')}}{{assetVersion()}}" rel="stylesheet">
 @endsection
@section('js')
    <script src="{{ asset('public/backend/js/jquery-ui.js') }}{{assetVersion()}}"></script>
    <script src="{{ asset('public/backend/js/jquery.ui.touch-punch.min.js') }}{{assetVersion()}}"></script>
    <script src="{{ asset('public/frontend/infixlmstheme/js/quiz_start.js') }}{{assetVersion()}}"></script>
    <script src="{{asset('public/backend/js/summernote-bs5.min.js')}}{{assetVersion()}}"></script>
    <script>
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
                placeholder: '',
                tabsize: 2,
                height: 188,
                tooltip: false
            });
        }
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



    <x-breadcrumb :banner="$frontendContent->quiz_page_banner" :title="$course->title"
                  :subTitle="trans('frontend.Quiz Start')"/>


    <x-quiz-start-page-section :course="$course" :quizId="$quiz_id"/>


    @include(theme('partials._quiz_submit_confirm_modal'))
    @include(theme('partials._quiz_start_confirm_modal'))

@endsection

