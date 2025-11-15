@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('common.Enrollment Cancellation')}}
@endsection
@section('css') @endsection
@section('js')
    <script>
        $(document).on('click', '.show_reason', function (event) {
            event.preventDefault();
            let reason = $(this).data('reason');
            let heading = $(this).data('heading');
            $('#reason_body').html(reason);
            $('#reason_heading').html(heading);
            $("#reasonShowModal").modal('show');
        });
    </script>
@endsection

@section('mainContent')
    <x-enrollment-cancellation-page-section/>
@endsection
