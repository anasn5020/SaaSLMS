@extends('backend.master')

@push('css')
    <link rel="stylesheet" href="{{asset('public/backend/css/zoom.css')}}{{assetVersion()}}"/>
@endpush

@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                @include('zoom::meeting.includes.form')
                @include('zoom::meeting.includes.list')
            </div>
        </div>
    </section>
    <input type="hidden" name="get_user" class="get_user" value="{{ url('get-user-by-role') }}">

@endsection

@push('scripts')
    <script src="{{asset('public/backend/js/zoom.js')}}"></script>
@endpush
