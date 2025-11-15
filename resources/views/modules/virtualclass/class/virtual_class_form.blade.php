@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/class.css')}}"/>
@endpush
@php
    $table_name='courses';
@endphp
@section('table')
    {{$table_name}}
@stop
@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                @include('virtualclass::class.partials._meeting_form')
             </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script src="{{ asset('/') }}/Modules/Membership/Resources/assets/js/app.js"></script>
    <script>
        $(document).ready(function () {
            let status = false;
            divHideSHow(status);

            $(document).on('click', '#all_level_member', function () {
                let status = $(this).is(':checked');

                divHideSHow(status);
            });

            function divHideSHow(status) {

                if (status == true) {
                    $('#membership_level_div').addClass('d-none');
                    $('#membership_level_member_div').addClass('d-none');
                } else {
                    $('#membership_level_div').removeClass('d-none');
                    $('#membership_level_member_div').removeClass('d-none');
                }
            }
        })
    </script>


    <script src="{{asset('/')}}/Modules/CourseSetting/Resources/assets/js/course.js"></script>
    <script src="{{asset('public/backend/js/zoom.js')}}"></script>

    <script>

        $(document).on('click', '.is_recurring', function () {
            let recurrence_section = $('.recurrence_section');
            if ($("input[name='is_recurring']:checked").val() == 0) {
                recurrence_section.addClass('d-none');
            } else {
                recurrence_section.removeClass('d-none');
            }
        })
        $(document).on('change', '#recurring_type', function () {
            let type = $(this).val();
            let day_hide = $(".day_hide");
            if (type != 2) {
                day_hide.addClass('d-none');
            } else {
                day_hide.removeClass('d-none');
            }

        })
    </script>

@endpush
