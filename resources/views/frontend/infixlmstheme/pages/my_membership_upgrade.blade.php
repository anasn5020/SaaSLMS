@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |
    @if( routeIs('myMembership'))
        {{__('membership.My Membership')}}
    @else
        {{__('membership.My Membership')}}
    @endif
@endsection
@section('css') @endsection
@section('js')

@endsection

@section('mainContent')

    <x-membership-level-upgrade :planId="$plan_id"/>

@endsection
