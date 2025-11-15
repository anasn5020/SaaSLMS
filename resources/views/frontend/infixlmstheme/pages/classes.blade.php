@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('virtual-class.Live Classes')}} @endsection
@section('css') @endsection

@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/classes.js')}}"></script>
@endsection
@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->class_page_banner" :title="trans('frontend.Browse Our Classes')"
                  :subTitle="trans('frontend.Classes')"/>

    <x-class-page-section :request="$request" :categories="$categories" :languages="$languages"/>


@endsection

