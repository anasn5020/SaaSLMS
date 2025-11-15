@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('common.About')}}
@endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')

    <x-breadcrumb :banner="$frontendContent->about_page_banner" :title="trans('frontend.Learn More About Us')"
                  :subTitle="trans('frontend.About US')"/>

    <x-about-page-who-we-are :whoWeAre="$about->who_we_are" :bannerTitle="$about->banner_title"/>

    <x-about-page-gallery :about="$about"/>

    <x-about-page-counter :about="$about"/>

    @if($about->show_testimonial)
        <x-about-page-testimonial :frontendContent="$frontendContent"/>
    @endif
    @if($about->show_brand)
        <x-about-page-brand/>
    @endif
    @if($about->show_become_instructor)
        <x-about-page-become-instructor :frontendContent="$frontendContent"/>
    @endif
@endsection
