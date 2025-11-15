@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('noticeboard.Noticeboard')}}
@endsection
@section('css')

@endsection
@section('js')
    <script>


    </script>
@endsection

@section('mainContent')
    <x-noticeboard :request="$request"/>
@endsection
