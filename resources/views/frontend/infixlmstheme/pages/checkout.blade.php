@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('common.Checkout')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/select2.min.css')}}{{assetVersion()}}" rel="stylesheet"/>
@endsection
@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->about_page_banner" :title="trans('frontend.Complete Your Purchase')"
                  :subTitle="trans('frontend.Checkout')"/>

    <x-checkout-page-section :request="$request"/>

@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/select2.min.js')}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/checkout.js')}}"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/city.js')}}"></script>
@endsection
