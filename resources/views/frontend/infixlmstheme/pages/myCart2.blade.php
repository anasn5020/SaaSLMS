@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('coupons.My Cart')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')


    <x-breadcrumb :banner="trans('frontend.Shopping Cart')"
                  :title="trans('frontend.Shopping Cart')"
                  :subTitle="trans('frontend.Cart')"/>

    <x-my-cart-with-out-login-page-section/>



@endsection
