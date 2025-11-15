@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('common.Dashboard')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/class_details.css')}}{{assetVersion()}}" rel="stylesheet"/>

@endsection

@section('mainContent')
    @if(auth()->user()->student_type == 'membership')
        <x-my-membership-dashboard-page-section/>
    @else
        <x-my-dashboard-page-section/>
    @endif
@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/class_details.js')}}"></script>
@endsection
