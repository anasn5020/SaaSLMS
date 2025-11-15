<!-- hero area:start -->
@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ __('appointment.Become Instructor') }}
@endsection
@section('css')
    <link rel="stylesheet"
          href="{{ asset('Modules\Appointment\Resources\assets\frontend\css\appointment.css') }}{{assetVersion()}}"/>
    <link rel="stylesheet"
          href="{{ asset('Modules\Appointment\Resources\assets\frontend\css\owl.carousel.min.css') }}{{assetVersion()}}"/>

@endsection
@section('mainContent')
    <x-appointment-become-instructor/>
@endsection
@section('js')
    <script src="{{asset('Modules\Appointment\Resources\assets\frontend\plugins\jquery-ui\jquery-ui.min.js')}}"></script>

    <script src="{{asset('Modules\Appointment\Resources\assets\frontend\js\owl.carousel.min.js')}}"></script>

@endsection
