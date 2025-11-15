@extends('errors.layout')
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{ __('Page Expired')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
@endsection

@section('message')
    {{ __('Page Expired') }}
@endsection
@section('details')
    {{ __('Sorry, your session has expired. Please refresh and try again.')}}
@endsection

