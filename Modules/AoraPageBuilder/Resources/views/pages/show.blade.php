@extends('aorapagebuilder::layouts.master')
@section('og_image'){{asset(Settings('logo'))}}@endsection

@section('content')
    {!! htmlspecialchars_decode($details)!!}
@endsection


@section('scripts')
    @php
        $route =request()->route()->getName();
    @endphp
    @if($route=='blogs')
        <script src="{{asset('public/frontend/infixlmstheme/js/blogs.js')}}"></script>
    @elseif($route=='contact')
{{--        <script src="https://maps.googleapis.com/maps/api/js?key={{Settings('gmap_key') }}"></script>--}}
{{--        <script src="{{ asset('public/frontend/infixlmstheme') }}/js/map.js"></script>--}}
    @else
        <script src="{{asset('public/frontend/infixlmstheme/js/courses.js'.assetVersion())}}"></script>
    @endif
    @if (isModuleActive("Store") && \Illuminate\Support\Facades\Route::currentRouteName()=="store.products")
        <script src="{{asset('public/frontend/infixlmstheme/js/store.js')}}"></script>
    @endif

    <script>
        $('.ui-resizable-resizer').remove()
    </script>

@endsection
