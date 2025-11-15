@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('cpd.My CPD')}}
@endsection

@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <x-cpd/>
@endsection
