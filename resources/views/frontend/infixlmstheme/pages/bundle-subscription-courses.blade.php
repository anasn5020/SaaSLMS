@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('bundleSubscription.Bundle Course')}}
@endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')

    <x-bundle-subscription-my-course-page-section/>

@endsection
