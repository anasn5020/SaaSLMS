@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontend.Subscription')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/subscription.css')}}{{assetVersion()}}" rel="stylesheet"/>
@endsection


@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->saas_banner??''"
                  :title="$frontendContent->saas_title??''"
                  :subTitle="$frontendContent->saas_sub_title??''"/>

    <x-saas-page-section/>

@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/subscription.js')}}{{assetVersion()}}"></script>
@endsection
