@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontendmanage.Become Instructor')}} @endsection
@section('css') @endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/become_instructor.js')}}"></script>

    @if ($errors->any())
        <script>
            $('#Instructor').modal('show');
        </script>

        @foreach ($errors->all() as $error)
            {{\Brian2694\Toastr\Facades\Toastr::error($error) }}
        @endforeach
    @endif
@endsection

@section('mainContent')
    <x-breadcrumb :banner="$frontendContent->become_instructor_page_banner"
                  :title="trans('frontend.Join Us as an Instructor')"
                  :subTitle="trans('frontend.Become Instructor')"/>

    <x-become-instructor-page-join :becomeInstructor="$becomeInstructor"/>


    <x-become-instructor-page-join-top :becomeInstructor="$becomeInstructor"/>

    <x-become-instructor-page-process :becomeInstructor="$becomeInstructor"/>

    <x-become-instructor-page-join-bottom :becomeInstructor="$becomeInstructor"/>
@endsection
