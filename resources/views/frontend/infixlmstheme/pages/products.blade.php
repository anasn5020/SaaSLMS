@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{_trans('store.Products')}}
@endsection
@section('css')

    <link rel="stylesheet" href="{{ asset('Modules/Store/Resources/assets/css/front_style.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Store/Resources/assets/css/select2.min.css')}}">
@endsection

@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/classes.js')}}"></script>
    <script src="{{asset('Modules/Store/Resources/assets/js/front_script.js')}}"></script>
    <script src="{{asset('Modules/Store/Resources/assets/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            // select js
            $(".search-hide").select2({
                minimumResultsForSearch: Infinity,
            });
        });


    </script>

@endsection
@section('mainContent')
    <x-store-page-section :request="$request" :categories="$product_categories"/>
@endsection

