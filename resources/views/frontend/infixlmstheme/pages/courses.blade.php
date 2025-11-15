@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('courses.Courses')}} @endsection
@section('css') @endsection

@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/classes.js')}}"></script>
@endsection
@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->course_page_banner" :title="trans('frontend.Join the Millions for better learning experience')"
                  :subTitle="trans('frontend.Courses')"/>

    <x-course-page-section :request="$request" :categories="$categories" :languages="$languages"/>
@endsection

