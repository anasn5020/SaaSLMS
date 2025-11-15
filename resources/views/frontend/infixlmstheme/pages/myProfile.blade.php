@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontendmanage.My Profile')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/select2.min.css')}}{{assetVersion()}}" rel="stylesheet"/>
    <link href="{{asset('public/frontend/infixlmstheme/css/checkout.css')}}{{assetVersion()}}" rel="stylesheet"/>
    <link href="{{asset('public/frontend/infixlmstheme/css/myProfile.css')}}{{assetVersion()}}" rel="stylesheet"/>
@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/select2.min.js')}}{{assetVersion()}}"></script>
    <script src="{{ asset('public/frontend/infixlmstheme/js/my_profile.js') }}{{assetVersion()}}"></script>

    <script src="{{asset('public/frontend/infixlmstheme/js/city.js')}}{{assetVersion()}}"></script>


    <script src="{{asset('public/backend/js/summernote-bs5.min.js')}}{{assetVersion()}}"></script>
    <script>
        $(document).ready(function () {
            $('.primary_textarea4 ').summernote({
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
                placeholder: 'Write here',
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
        $('#two_step_verification').on('change', function () {
            let test = $(this).val();
            if (test == 0) {
                $('#expired_time').addClass('d-none');
            } else if (test == 1) {
                $('#expired_time').removeClass('d-none');
            } else if (test == 2) {
                $('#expired_time').addClass('d-none');
            }
        });

        $('.select2').select2();

    </script>
@endsection

@section('mainContent')

    <x-my-profile-page-section/>

@endsection
