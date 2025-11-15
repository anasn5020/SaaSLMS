@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontend.Courses')}} @endsection
@section('css') @endsection
@section('js')
    <script src="{{ asset('public/frontend/infixlmstheme/js/classes.js') }}"></script>
@endsection
@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->course_page_banner" :title="trans('frontend.Find What You’re Looking For')"
                  :subTitle="trans('frontend.Search')"/>

     <x-search-page-section :request="$request" :categories="$categories" :languages="$languages"
                           :categorySearch="$id"/>

@endsection

