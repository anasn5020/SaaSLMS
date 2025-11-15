@extends('errors.layout')
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('Unauthorized')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
@endsection

@section('message')
    {{__('Unauthorized')}}
@endsection
@section('details')
    {{ __($exception->getMessage() ?: 'Sorry, you are not authorized to access this page.') }}
@endsection

