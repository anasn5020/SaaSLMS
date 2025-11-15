@extends(theme('auth.layouts.app'))
@section('content')

    <style>
        .error_wrapper {
            padding: 243px 0 250px 0;

        }
    </style>

    <div class="error_wrapper">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-12">
                    <div class="error_wrapper_info text-center">
                        <div class="thumb">
                            <img src="{{asset('/public/infixlmstheme/')}}/img/banner/error_thumb.png" alt="">
                        </div>
                        <h3>{{ __('frontend.Thanks For Registration') }} !!!</h3>
                        <h2>
                            {{ __('frontend.Please Wait For Approval') }}
                        </h2>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
