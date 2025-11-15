@extends('errors.layout')
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('Permission Denied')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
@endsection

@section('message')
    {{__('Permission Denied')}}
@endsection
@section('details')
    {{ __($exception->getMessage() ?: 'Permission Denied, you have no permission to access this page !') }}
@endsection

