@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('elibrary.E-Library')}}
@endsection

@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <x-elibrary/>
@endsection
