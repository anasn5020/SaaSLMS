@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontend.Bundle')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/package.css')}}" rel="stylesheet">
    <link href="{{asset('Modules/AoraPageBuilder/Resources/assets/css/style1.css')}}" rel="stylesheet">
@endsection

@section('mainContent')


    <x-breadcrumb :banner="trans('frontend.Explore Our Course Bundles')"
                  :title="trans('frontend.Explore Our Course Bundles')"
                  :subTitle="trans('frontend.Bundle')"/>



    <!-- pricing_area::start  -->
    <div class="pricing_area">
        <div class="container">
            @if(Settings('hide_category_for_bundle_subscription')!=1)
                <div class="row">
                    <div class="col-12">
                        <div class="pricing_carousel owl-carousel">


                            @if(isset($categories ))
                                @foreach ($categories  as $key=>$category)

                                    <div class="single_course_slide text-center">
                                        <div class="icon">
                                            <img style="width: 80px!important;height: 60px"
                                                 src="{{asset($category->thumbnail)}}" alt="">
                                        </div>
                                        <a href="{{route('courses')}}?category={{$category->id}}"
                                           class="cat_btn">
                                            <h4>
                                                {{$category->name}}

                                            </h4>
                                            <span>{{translatedNumber($category->courses_count)}} {{__('frontend.Courses')}}</span>
                                        </a>
                                    </div>

                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-5"></div>
            @endif
            <div class="row">

                @if(isset($BundleCourse))
                    @foreach($BundleCourse as $value)
                        @php
                            $oldPrice = 0;
                            foreach ($value->course as $raw){
                              $oldPrice += empty($raw->course->discount_price)?$raw->course->price:$raw->course->discount_price;
                            }

                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="package_widget mb_30 d-flex flex-column">
                                <div class="package_header text-center">
                                    <h3 class="oneLine_ellipsis">{{$value->title}}</h3>
                                    <div class="package_rating d-flex align-items-center justify-content-center">
                                        @if(Settings('show_review_for_bundle_subscription'))
                                            <div class="feedmak_stars d-flex align-items-center">
                                                @php
                                                    $star = 5;
                                                @endphp
                                                @for($x=0; $x < $value->reviews->avg('star'); $x++)
                                                    <i class="fas fa-star"></i>
                                                    @php
                                                        $star -= 1;
                                                    @endphp
                                                @endfor
                                                @for($x=0; $x < $star; $x++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            </div>
                                        @endif
                                        <p>({{$value->student}} {{__('bundleSubscription.students')}})</p>
                                    </div>
                                </div>
                                <div class="package_body d-flex flex-column flex-fill">
                                    <div class="package_lists flex-fill">
                                        @foreach($value->course as $key=>$raw)
                                            <div
                                                class="w-100 justify-content-between single_packageList {{$key>2?'d-none extra_'.$value->id:''}}">
                                                <p>{{  Str::limit($raw->course->title, 40) }}</p>
                                                <span>{{getPriceFormat(empty($raw->course->discount_price)?$raw->course->price:$raw->course->discount_price)}}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($value->course)>3)
                                        <div class="package_seperator" onclick="openAllCourse({{$value->id}})">
  <span>
                                <i class="fa fa-angle-down" id="seperator_{{$value->id}}"></i>
                            </span>
                                        </div>
                                    @endif
                                    <div
                                        class="package_footer d-flex justify-content-between align-items-center flex-column">

                                        <div class="prise_tag">
                                            <h4>
                                                @if($oldPrice!=0)
                                                    <span>{{getPriceFormat($oldPrice)}}</span>
                                                    {{getPriceFormat($value->price)}}
                                                @else
                                                    <h4 class="text-center">{{getPriceFormat($value->price)}}</h4>
                                                @endif
                                            </h4>
                                            <p>{{__('bundleSubscription.Total')}} {{count($value->course)}} {{__('bundleSubscription.Course')}}</p>
                                        </div>
                                        <a href="{{route('bundle.show')}}?id={{$value->id}}"
                                           class="theme_btn small_btn2 w-100 text-center">{{__('bundleSubscription.View Details')}}</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- pricing_area::end  -->
@endsection

@section('js')

    <script>
        function openAllCourse(plan_id) {
            var seperator = $('#seperator_' + plan_id);
            var seperator_class = seperator.attr('class');
            if (seperator_class == "fa fa-angle-down") {
                seperator.removeClass("fa fa-angle-down");
                seperator.addClass("fa fa-angle-up");
                $('.extra_' + plan_id).removeClass('d-none');
            } else if (seperator_class == "fa fa-angle-up") {
                seperator.removeClass("fa fa-angle-up");
                seperator.addClass("fa fa-angle-down");
                $('.extra_' + plan_id).addClass('d-none');


            }
        }
    </script>

@endsection


