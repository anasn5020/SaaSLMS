@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('blog.My Blogs')}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('Modules/Blog/Resources/views/assets/frontend.css')}}{{assetVersion()}}"/>
@endsection
@section('js') @endsection

@section('mainContent')
    <x-my-blog-page-section/>
@endsection
