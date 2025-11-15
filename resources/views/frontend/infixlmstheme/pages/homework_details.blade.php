@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{_trans('homework.Homework')}} {{__('common.Details')}}
@endsection
@section('css')
    <link href="{{asset('public/backend/css/summernote-bs5.min.css')}}{{assetVersion()}}" rel="stylesheet">
    <link href="{{asset('public/frontend/compact/css/myProfile.css')}}{{assetVersion()}}" rel="stylesheet"/>
@endsection
@section('js')
    <script src="{{asset('public/backend/js/summernote-bs5.min.js')}}"></script>
    <script>
        $(document).ready(function () {
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

    <script>
        $('.assignment_file').change(function () {
            let file_name = $(this).val();
            file_name = file_name.replace(/C:\\fakepath\\/i, '');
            $('#show_file_name').html(file_name);
        });
    </script>
@endsection

@section('mainContent')
    <x-homework-details :id="$id"/>
@endsection
