@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |
    @if( routeIs('myCpd'))
        \

        {{__('cpd.My CPD')}}
    @else
        {{__('cpd.My CPD')}}
    @endif
@endsection
@section('css') @endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/my_course.js')}}"></script>
@endsection

@section('mainContent')

    <x-my-cpd-courses-page-section :request="$request" :cpdId="$cpd_id"/>
@endsection
