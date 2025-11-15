@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |
    @if( routeIs('myclass'))
        {{__('class.My Class')}}
    @else
        {{__('class.My Class')}}
    @endif
@endsection
@section('css') @endsection
@section('js')

@endsection

@section('mainContent')

    <x-membership-level-upgrade-checkout :levelId="$level_id" :checkoutId="$checkout_id"/>

@endsection
