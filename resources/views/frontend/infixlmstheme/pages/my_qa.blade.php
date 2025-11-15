@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontend.My Questions')}}
@endsection
@section('css')
    <link rel="stylesheet"
          href="{{ asset('public/frontend/infixlmstheme/plugins/data-table/jquery.dataTables.min.css') }}">
    <style>
        .dataTables_paginate {
            float: right;
            padding-top: 20px;
        }

        .dataTables_paginate a {
            margin: 5px;
            overflow: hidden
        }

        .paginate_button:hover {
            cursor: pointer;
            margin: 5px;
        }

        .dataTables_filter label{
            position: relative;
        }
        .dataTables_length .nice-select{
            height: 36px;
            min-width: 66px;
        }

        .dataTables_length label{
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dataTables_length .nice-select .current{
            line-height: 36px;
        }

    </style>
@endsection
@section('js')
    <script src="{{ asset('public/frontend/infixlmstheme/plugins/data-table/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('public/js/pusher.min.js')}}"></script>
    <script>
        Pusher.logToConsole = false;
        let pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
            cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}'
        });
        let channel = pusher.subscribe('new-notification-channel');

        var table = $('#qaTable').DataTable({
            bLengthChange: true,
            "lengthChange": true,
            "lengthMenu": [[10, 25, 50, 100, 100000], [10, 25, 50, 100, "{{__('common.All')}}"]],
            "bDestroy": true,
            stateSave: true,
            processing: true,
            serverSide: true,
            order: [[0, "desc"]],
            "ajax": '{!! route('myQA.data') !!}',
            columns: [
                {data: 'DT_RowIndex', name: 'id', orderable: false},
                {data: 'course_id', name: 'course.title', orderable: false},
                {data: 'lesson_id', name: 'lesson.name', orderable: false},
                {data: 'text', name: 'text', orderable: false},
                {data: 'total_replies', name: 'total_replies', orderable: false},
                {data: 'reserved', name: 'reserved', orderable: false},
                {data: 'action', name: 'action', orderable: false},

            ],
            language: {
                sLengthMenu: "{{__("common.Show")}} _MENU_ {{__("common.Records")}}",
                sInfo: "{{__("common.Showing")}} _START_ - _END_ {{__("common.Of")}} _TOTAL_ {{__("common.Records")}}",
                sInfoEmpty: "{{__("common.Showing")}} 0 {{__("common.To")}} 0 {{__("common.Of")}} 0 {{__("common.Records")}}",
                emptyTable: "{{ __("common.No data available in the table") }}",
                search: "<i class='ti-search'></i>",
                searchPlaceholder: '{{ __("common.Quick Search") }}',
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="far fa-copy"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: '{{ __("common.Copy") }}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="far fa-file-excel"></i>',
                    titleAttr: '{{ __("common.Excel") }}',
                    title: $("#logo_title").val(),
                    margin: [10, 10, 10, 0],
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    },

                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="far fa-file-alt"></i>',
                    titleAttr: '{{ __("common.CSV") }}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="far fa-file-pdf"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: '{{ __("common.PDF") }}',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    },
                    orientation: 'landscape',
                    pageSize: 'A4',
                    margin: [0, 0, 0, 12],
                    alignment: 'center',
                    header: true,
                    customize: function (doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }

                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: '{{ __("common.Print") }}',
                    title: $("#logo_title").val(),
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i>',
                    postfixButtons: ['colvisRestore']
                }
            ],
            columnDefs: [{
                visible: false
            },
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 2},
                {responsivePriority: 2, targets: -2},
            ],
            responsive: true,
        });


        channel.bind('new-notification', function (data) {
            table.ajax.reload();
            if (data.login_user_id != '{{auth()->id()}}') {

                $.ajax({
                    url: '{{route('getNotificationUpdate')}}',
                    method: 'GET',
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        $('.notification_body').html(response.notification_body);
                        toastr.success("{{__('frontend.New notification')}}");

                    },
                    error: function (response) {
                    }
                });
            }

        });

    </script>
@endsection

@section('mainContent')
    <div>
        <div class="main_content_iner main_content_padding">
            <div class="dashboard_lg_card">
                <div class="container-fluid g-0">
                    <div class="my_courses_wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3">
                                    <h3>
                                        {{ __("frontend.My Questions") }}
                                    </h3>
                                </div>
                            </div>
                        </div>


                        <div class="row d-flex align-items-center mb-4 mb-lg-5">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table custom_table3" id="qaTable">
                                        <thead>
                                        <tr>
                                            <th scope="col"> {{__('common.SL')}}</th>
                                            <th scope="col"> {{__('courses.Course')}}</th>
                                            <th scope="col"> {{__('courses.Lesson')}}</th>
                                            <th scope="col"> {{__('common.Question')}}</th>
                                            <th scope="col">{{__("frontend.Replied")}}</th>
                                            <th scope="col">{{__('frontend.Reserved')}}</th>
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
    </div>

@endsection
