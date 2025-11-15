@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('common.Dashboard')}}
@endsection
@section('css')

    <link href="{{ asset('public/frontend/infixlmstheme/css/class_details.css') }}{{assetVersion()}}" rel="stylesheet"/>

@endsection

@section('mainContent')
    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="my_courses_wrapper">
                    <div class="row">


                        @foreach($data as $value)
                            <div class="recommended_courses">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="section__title3 margin_50">
                                            <h3>{{ $value->title }}</h3>
                                            <span style="color: red">Expiry Date : {{ $value->expire }}</span> <span><a
                                                    href="{{ route('bundle.renew',['bundle_id'=>$value->id]) }}"> {{__('bundleSubscription.Renew')}} </a> </span>
                                            <p>{{ $value->about }}</p>
                                        </div>
                                    </div>

                                    @foreach($value->course as $raw)

                                        <div class="col-xl-4 col-md-6">
                                            <div class="quiz_wizged">

                                                <a href="{{route('continueCourse',[$raw->course->slug])}}">
                                                    <div class="thumb">
                                                        <div class="thumb_inner lazy"
                                                             data-src="{{ file_exists($raw->course->thumbnail) ? asset($raw->course->thumbnail) : asset('public/\uploads/course_sample.png') }}">

<span class="prise_tag">
      @if (@$raw->course->discount_price!=null)
        {{getPriceFormat($raw->course->discount_price)}}
    @else
        {{getPriceFormat($raw->course->price)}}
    @endif
</span>


                                                        </div>

                                                    </div>
                                                </a>

                                                <div class="course_content">
                                                    <a href="{{route('continueCourse',[$raw->course->slug])}}">
                                                        <h4 class="noBrake"
                                                            title="{{$raw->course->title}}"> {{$raw->course->title}}</h4>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                        @endforeach
                        @if(count($data)==0)
                            <div class="col-12">
                                <div class="section__title3 margin_50">
                                    <p class="text-center">{{__('bundleSubscription.No Bundle Purchased Yet')}}!</p>
                                </div>
                            </div>
                        @endif

                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/class_details.js')}}"></script>
@endsection
