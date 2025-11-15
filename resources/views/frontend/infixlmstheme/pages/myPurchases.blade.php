@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('payment.Purchase history')}}
@endsection
@section('css')
    <style>
        .thumb img {
            object-fit: cover;
            object-position: center;
            height: 100%;
        }
    </style>
@endsection

@section('js') @endsection

@section('mainContent')
    <x-my-purchase-page-secton/>
@endsection
