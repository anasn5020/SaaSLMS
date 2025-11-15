@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('quiz.Quiz')}}@endsection
@section('css') @endsection

@section('js')
    <script src="{{ asset('public/frontend/infixlmstheme/js/classes.js') }}"></script>
@endsection
@section('mainContent')

    <x-breadcrumb :banner="trans('common.N/A')"
                  :title="trans('frontend.Choose the Right Plan for Your Needs')"
                  :subTitle="trans('frontend.SAAS Plan')"/>


    <x-quiz-page-section :request="$request" :categories="$categories" :languages="$languages"/>



@endsection






