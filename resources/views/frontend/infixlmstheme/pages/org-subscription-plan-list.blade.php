@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |
    {{__('org-subscription.My Plan')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/org-subscription.css')}}{{assetVersion()}}"
          rel="stylesheet"/>
    <style>
        .twoLine_ellipsis {
            -webkit-line-clamp: 2;
            text-align: justify-all;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            white-space: normal;
            text-overflow: ellipsis;
            overflow: hidden;
        }
    </style>
@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/my_course.js')}}"></script>
@endsection

@section('mainContent')
    <x-my-org-subscription-plan-list-section :plan="$planId" :request="$request"/>
@endsection
