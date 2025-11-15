@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |    {{$course->title}}
@endsection
@section('css')

@endsection
@section('js')

@endsection

@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->quiz_page_banner" :title="$course->title"
                  :subTitle="trans('frontend.Quiz Result')"/>


    <x-quiz-result-page-section :quiz="$quiz" :user="$user" :course="$course"/>

@endsection


