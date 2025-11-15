@extends('backend.master')
@section('mainContent')
    <style>
        .propertiesname {
            text-transform: uppercase;
        }
    </style>
    {!! generateBreadcrumb() !!}


    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="mb-30">@lang('lang.meeting') @lang('lang.room')</h3>
                </div>
                <div class="col-lg-4 text-end col-md-12 mb-20">
                    @lang('lang.topic') : {{ $topic }} & @lang('lang.password') : {{ $password }}
                </div>
            </div>
            <div class="row">
                <iframe class="w-100" src="{{ $url }}"></iframe>
            </div>
        </div>
    </section>
@endsection

@section('script')

@stop



