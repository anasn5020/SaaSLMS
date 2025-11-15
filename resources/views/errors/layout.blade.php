@php
    use Illuminate\Support\Facades\DB;
try {
    $isConnected = DB::connection()->getPdo();
 }catch (\Exception $exception){
    $isConnected =false;

 }
@endphp

@if($isConnected)
    @include(theme('partials._header'))
    @include(theme('partials._menu'))

    @if(Settings('frontend_active_theme') == 'kidslms')
        <section class="error-page">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8 col-md-10 text-center">
                        <div class="img">
                            <img src="{{themeAsset('img/shape/404-v1.png')}}" alt="error:page not found">
                        </div>
                        <h2>@yield('message')</h2>
                        <p>@yield('details')</p>
                        <a href="/" class="theme-btn fw-500">{{__('frontend.Back To Homepage')}}</a>
                    </div>
                </div>
            </div>
        </section>
    @else
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
    @endif

    @yield('mainContent')
    @include(theme('partials._footer'))
@else
    @include('errors.static')
@endif

