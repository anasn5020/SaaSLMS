@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('common.Reports')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <x-my-report-course-page-section/>
    <x-my-report-quiz-page-section/>
@endsection
