@php
    if(auth()->user()->role_id == 3){
        $extend_file = theme('layouts.dashboard_master');
    }else{
        $extend_file = theme('layouts.master');
    }
@endphp

@extends($extend_file)

@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('coupons.My Cart')}}
@endsection
@section('css') @endsection


@section('mainContent')
    <x-my-cart-with-login-page-section/>
@endsection

