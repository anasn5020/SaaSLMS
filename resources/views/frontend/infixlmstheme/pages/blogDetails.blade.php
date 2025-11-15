@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{$blog->title??''}}
@endsection
@section('css') @endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/blogs.js')}}"></script>
@endsection
@section('og_image')
    {{getBlogImage($blog->image)}}
@endsection
@section('mainContent')

    <x-blog-details-page-section :blog="$blog"/>

@endsection
