@extends('backend.master')


@php
    $url =route('qa.questions.data');

@endphp

@section('table')
    lesson_questions
@stop
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white-box">

                <div class="row justify-content-center mt-0">
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px" id="page_title">{{__('frontend.Questions')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table">

                                <div>
                                    <table id="lms_table" class="table classList">
                                        <thead>
                                        <tr>
                                            <th scope="col"> {{__('common.SL')}}</th>
                                            <th scope="col"> {{__('courses.Course')}}</th>
                                            <th scope="col"> {{__('courses.Lesson')}}</th>
                                            <th scope="col"> {{__('common.User')}}</th>
                                            <th scope="col"> {{__('common.Question')}}</th>
                                            <th scope="col">{{__("frontend.Replied")}}</th>
                                            <th scope="col">{{__('frontend.Reserved')}}</th>

                                            <th scope="col">{{__('common.Status')}}</th>
                                            <th scope="col">{{__('common.Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>


            </div>
        </div>
    </section>
    @include('backend.partials.delete_modal')
@endsection
@push('scripts')

    {{--    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>--}}

    <script src="{{asset('public/js/pusher.min.js')}}"></script>
    <script>
        Pusher.logToConsole = false;
        let pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
            cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}'
        });
        let channel = pusher.subscribe('new-notification-channel');


        dataTableOptions.serverSide = true
        dataTableOptions.processing = true
        dataTableOptions.ajax = '{!! $url !!}';
        dataTableOptions.columns = [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'course_id', name: 'course.title'},
            {data: 'lesson_id', name: 'lesson.name'},
            {data: 'user_id', name: 'user.name'},
            {data: 'text', name: 'text'},
            {data: 'total_replies', name: 'total_replies'},
            {data: 'reserved', name: 'reserved'},
            {data: 'status', name: 'search_status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false},
        ]

        dataTableOptions = updateColumnExportOption(dataTableOptions, [0, 1, 2, 3, 4, 5, 6]);

        let table = $('.classList').DataTable(dataTableOptions);


        channel.bind('new-notification', function (data) {
            table.ajax.reload();
            if (data.login_user_id != '{{auth()->id()}}' && data.type != 'Reply') {


                $.ajax({
                    url: '{{route('getNotificationUpdate')}}',
                    method: 'GET',
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        console.log(response.total);
                        $('.Notification_body').html(response.notification_body);
                        $('.notification_count').html(response.total);
                        toastr.success("{{__('frontend.New notification')}}");

                    },
                    error: function (response) {
                    }
                });
            }

        });

    </script>
@endpush
