@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | @lang('frontendmanage.Payment Method')
@endsection
@section('css')
@endsection
@section('mainContent')

    <x-membership-payment-page-section :cart="$cart" :bill="$bill" :plan="$plan"/>

@endsection
@section('js')
@endsection
