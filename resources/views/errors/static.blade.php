<link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/app.css"
      media="screen,print">
<link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/frontend_style.css"
      media="screen,print">
<script src="{{asset('public/js/common.js')}}"></script>
<link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/css/custom.css') }}">
<div class="error_wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="error_wrapper_info text-center">
                    <div class="thumb">
                        <img src="{{asset('public/errors/'.$exception->getStatusCode().'.png')}}" alt="">
                    </div>
                    <h3>@yield('message')</h3>
                    <p>@yield('details')</p>
                    <a href="{{url('/')}}" class="theme_btn ">
                        {{__('frontend.Back To Homepage')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
