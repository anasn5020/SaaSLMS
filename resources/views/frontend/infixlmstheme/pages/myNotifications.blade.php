@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontendmanage.Notifications')}}
@endsection
@section('css')

@endsection
@section('js')
    <script>


        $('.unread_notification').on('click', function (e) {
            e.preventDefault();
            let notification_id = $(this).attr('data-notification_id');
            $(this).css('color', 'red');

            $('.notify_' + notification_id).addClass('notify_normal');
            $('.notify_' + notification_id).removeClass('notifi_par');

            let url = $('#url').val();

            let formData = {
                id: notification_id
            };
            $.ajax({
                type: "GET",
                data: formData,
                dataType: 'json',
                url: url + '/' + 'ajaxNotificationMakeRead',
                success: function (data) {
                    console.log(data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    </script>
@endsection

@section('mainContent')
    <x-notification :request="$request"/>
@endsection
