@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{$privacy_policy->page_banner_title}} @endsection
@section('css') @endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/scrollIt.js')}}"></script>
@endsection

@section('mainContent')


    @if($privacy_policy->page_banner_status==1)
        <x-breadcrumb :banner="$privacy_policy->page_banner" :title="trans('frontend.How We Protect Your Information')"
                      :subTitle="trans('frontend.Privacy Policy')"/>
    @endif


    <x-privacy-page-section :privacy="$privacy_policy"/>


@endsection
