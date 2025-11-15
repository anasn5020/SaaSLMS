@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('payment.Pre Booking')}}
@endsection
@section('css')
    <style>
        .modal_400px {
            max-width: 400px !important;
        }

    </style>
@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/deposit.js')}}"></script>

@endsection

@section('mainContent')
    <x-pre-booking-page-section :id="$id"/>
@endsection
