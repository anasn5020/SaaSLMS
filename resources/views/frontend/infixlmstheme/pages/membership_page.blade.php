@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('membership.Membership')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/subscription.css')}}{{assetVersion()}}" rel="stylesheet"/>
@endsection


@section('mainContent')
    <x-breadcrumb :banner="trans('common.N/A')"
                  :title="trans('frontend.Explore Membership Options')"
                  :subTitle="trans('frontend.Membership')"/>


    <x-membership-page-section/>

@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/subscription.js')}}"></script>
@endsection
