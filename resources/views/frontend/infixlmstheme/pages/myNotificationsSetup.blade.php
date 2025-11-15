@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('setting.Notification Setup')}}
@endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <x-notification-setup/>
@endsection
