@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontend.Contact Us')}}
@endsection
@section('css') @endsection

@section('mainContent')


    <x-breadcrumb :banner="$frontendContent->contact_page_banner" :title="trans('frontend.We’re here with you every step way')"
                  :subTitle="trans('frontend.Contact Us')"/>


    <x-contact-page-section/>

    @if(@$frontendContent->show_map==1)
        <x-contact-page-map/>
    @endif


    <input type="hidden" name="lat" class="lat" value="{{Settings('lat') }}">
    <input type="hidden" name="lng" class="lng" value="{{Settings('lng') }}">
    <input type="hidden" name="zoom" class="zoom" value="{{Settings('zoom_level')}}">
@endsection
@section('js')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{Settings('gmap_key') }}"></script>
    <script src="{{ asset('public/frontend/infixlmstheme') }}/js/map.js"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/contact.js')}}"></script>
@endsection
