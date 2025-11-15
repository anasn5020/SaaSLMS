@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | Calendar
@endsection
@section('css')
    <link rel="stylesheet"
          href="{{asset('Modules/Calendar/Resources/assets/js/frontend/calender_js/core/main.css')}}{{assetVersion()}}">
    <link rel="stylesheet"
          href="{{asset('Modules/Calendar/Resources/assets/js/frontend/calender_js/daygrid/main.css')}}{{assetVersion()}}">
    <link rel="stylesheet"
          href="{{asset('Modules/Calendar/Resources/assets/js/frontend/calender_js/timegrid/main.css')}}{{assetVersion()}}">
    <link rel="stylesheet"
          href="{{asset('Modules/Calendar/Resources/assets/js/frontend/calender_js/list/main.css')}}{{assetVersion()}}">

    <link rel="stylesheet"
          href="{{asset('Modules/Calendar/Resources/assets/css/frontend_claendar.css')}}{{assetVersion()}}">
    <style>
        .fc-event-container .fc-content .fc-title {
            padding-left: 15px;
        }

        .fc-timeGridWeek-button {
            display: none;
        }

        .fc-day-grid-event {
            padding: 10px 15px;
        }
    </style>
@endsection
@section('js')
    <script src="{{asset('Modules/Calendar/Resources/assets/js')}}/frontend/calender_js/core/main.js"></script>
    <script src="{{asset('Modules/Calendar/Resources/assets/js')}}/frontend/calender_js/daygrid/main.js"></script>
    <script src="{{asset('Modules/Calendar/Resources/assets/js')}}/frontend/calender_js/timegrid/main.js"></script>
    <script src="{{asset('Modules/Calendar/Resources/assets/js')}}/frontend/calender_js/interaction/main.js"></script>
    <script src="{{asset('Modules/Calendar/Resources/assets/js')}}/frontend/calender_js/list/main.js"></script>

    <script>
        $(document).ready(function () {
            $('.fc-timeGridWeek-button').hide();
        });
        if ($("#calendar").length > 0) {
            document.addEventListener("DOMContentLoaded", function () {
                var calendarEl = document.getElementById("calendar");
                var today_date = document.getElementById("today_date").value;
                let data =<?php echo $calendars; ?>;

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ["dayGrid", "timeGrid", "list", "interaction"],
                    initialView: "timeGridWeek",
                    header: {
                        left: "prev, title , next",
                        center: "dayGridMonth,timeGridWeek",
                        right: "title",
                    },
                    height: "",
                    defaultDate: today_date,
                    navLinks: true,
                    editable: false,
                    eventLimit: true,

                    events: data,


                    eventClick: function (info, event) {
                        let system_url = $('#system_url').val();
                        let selectedDateView = info.event.start;
                        var date = new Date(selectedDateView);
                        var date = date.toLocaleDateString();
                        var date = new Date(date);
                        let formatedDate = date.toDateString();

                        let new_end_date = "";
                        let formatedend_date = "";
                        if (info.event.end == null) {
                            new_end_date = info.event.start;
                        } else {
                            new_end_date = info.event.end;
                            let selectedEndDateView = new_end_date;

                            let end_date = new Date(selectedEndDateView);
                            end_date = end_date.toLocaleDateString();
                            end_date = new Date(end_date);
                            formatedend_date = " - " + end_date.toDateString();
                        }


                        $('#calendar_title').html(info.event.title);
                        $('#calendar_date_time').html(formatedDate + formatedend_date);
                        if (info.event.extendedProps.calendar_url != null) {
                            $('#calendar_link').attr('href', info.event.extendedProps.calendar_url);
                        } else {
                            $('#calendar_link').hide();
                        }
                        $('#calendar_banner').attr("src", system_url + "/" + info.event.extendedProps.banner);
                        $('.description_text').html(info.event.extendedProps.description);

                        let host_name = "";
                        if (info.event.extendedProps.course_id == null) {
                            host_name = info.event.extendedProps.event.host;
                            $('#host_title').html('{{__('calender.Event Host')}}');
                            $('#host_image').attr('src', system_url + '/public/demo/user/admin.jpg');
                        } else {
                            host_name = info.event.extendedProps.course.user.name;
                            $('#host_title').html(info.event.extendedProps.course.user.role.name);
                            $('#host_image').attr('src', system_url + '/' + info.event.extendedProps.course.user.image);
                        }
                        $('#host_name').html(host_name);
                        console.log(host_name);

                        $("#lms_view_modal").modal("show");
                    },
                    dateClick: function (date, jsEvent, view) {
                    },

                });
                calendar.render();
            });
        }

    </script>

@endsection

@section('mainContent')
    <x-breadcrumb :banner="trans('common.N/A')"
                  :title="trans('frontend.View Our Event Calendar')"
                  :subTitle="trans('frontend.Calendar')"/>
    <x-calendar-view/>
@endsection
