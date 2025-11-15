@extends('errors.layout')
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{  __('Service Unavailable')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
@endsection

@section('message')
    {{ __('Service Unavailable')}}
@endsection
@section('details')
    {{__($exception->getMessage() ?: 'Service Unavailable')}}
@endsection

