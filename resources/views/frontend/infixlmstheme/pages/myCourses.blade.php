@extends(theme('layouts.dashboard_master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} |
    @if (routeIs('myClasses'))
        {{ __('courses.Live Class') }}
    @elseif(routeIs('myQuizzes'))
        {{ __('courses.My Quizzes') }}
    @else
        {{ __('courses.My Courses') }}
    @endif
@endsection
@section('css')
    <style>
        .course_less_students {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .course_less_students a {
            margin: 0 !important;
        }

        .course_less_students .cpd {
            cursor: pointer;
            color: var(--system_primery_color) !important;
        }

        .modal-header {
            align-items: center;
        }

        .modal .close {
            font-size: 16px;
            transition: all .3s ease-in-out;
            margin-top: 0px;
        }

        /*.modal .close:hover {*/
        /*    color: var(--system_primery_color);*/
        /*}*/

        .theme_btn.bg-transparent {
            border-color: var(--system_primery_color);
            color: var(--system_primery_color);
        }

        .theme_btn.bg-transparent:hover {
            background: var(--system_primery_color) !important;
            color: #ffffff;
        }

        .input-control label {
            color: var(--system_secendory_color);
            display: block;
            margin-bottom: 10px;
        }

        .modal-body .nice-select {
            width: 100%;
            position: relative;
            border-radius: 4px;
        }

        .modal-body .nice-select .list {
            padding: 0px;
        }

        .modal-body .nice-select::after,
        .modal-body .nice-select .nice-select-search-box {
            display: none;
        }

        .modal-body .nice-select::before {
            content: "\e64b";
            font-family: 'themify';
            font-size: 14px;
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            transition: all .3s ease-in-out;
        }

        .modal-body .nice-select.open::before {
            content: "\e648";
            transition: all .3s ease-in-out;
        }

        .mntop {
            margin-top: 100px;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('public/frontend/infixlmstheme/js/my_course.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.cpdValue', function () {
                let course_id = $(this).data('course_id');
                $('#cpd_course_id').val(course_id);
            })
        })
    </script>
@endsection
@section('mainContent')
    <x-my-courses-page-section :request="$request"/>
@endsection
