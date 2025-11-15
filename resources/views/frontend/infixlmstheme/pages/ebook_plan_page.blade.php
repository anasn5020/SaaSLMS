@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('eLibrary.Ebook')}} @endsection

@section('mainContent')



    <x-breadcrumb :banner="$frontendContent->course_page_banner" :title="trans('frontend.Access Your Digital Library')"
                  :subTitle="trans('frontend.Ebook')"/>


    <!-- pricing_area::start  -->
    <div class="pricing_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="pricing_carousel owl-carousel">


                        @if(isset($categories ))
                            @foreach ($categories  as $key=>$category)

                                <div class="single_course_slide text-center">
                                    <div class="icon">
                                        <img style="width: 80px;height: 60px" src="{{asset($category->image)}}" alt="">
                                    </div>
                                    <a href="{{route('courses')}}?category={{$category->id}}"
                                       class="cat_btn">
                                        <h4>
                                            {{$category->name}}

                                        </h4>
                                        <span>{{$category->courses_count}} {{__('frontend.Courses')}}</span>
                                    </a>
                                </div>

                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">

                @if(isset($ebookPlans))
                    @foreach($ebookPlans as $plan)

                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="package_widget mb_30 d-flex flex-column">
                                <div class="package_header text-center">
                                    <h3 class="oneLine_ellipsis">{{$plan->title}}</h3>
                                    <div class="package_rating d-flex align-items-center justify-content-center">
                                        <p>({{$plan->student}} {{__('bundleSubscription.students')}})</p>
                                    </div>
                                </div>
                                <div class="package_body d-flex flex-column flex-fill">
                                    <div class="package_lists flex-fill">
                                        @foreach($plan->ebooks as $key=>$ebook)
                                            <div
                                                class="w-100 justify-content-between single_packageList {{$key>2?'d-none extra_'.$plan->id:''}}">
                                                <p>{{  Str::limit($ebook->ebook->name, 40) }}</p>
                                                <p>{{  Str::limit($ebook->ebook->author_name, 40) }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($plan->ebooks)>3)
                                        <div class="package_seperator" onclick="openAllCourse({{$plan->id}})">
                                            <span>
                                                <i class="fa fa-angle-down" id="seperator_{{$plan->id}}"></i>
                                            </span>
                                        </div>
                                    @endif
                                    <div
                                        class="package_footer d-flex justify-content-between align-items-center flex-column">

                                        <div class="prise_tag">
                                            <h4>

                                                <h4 class="text-center">{{getPriceFormat($plan->price)}}</h4>

                                            </h4>
                                            <p>{{__('bundleSubscription.Total')}} {{count($plan->ebooks)}} {{__('membership.Ebook')}}</p>
                                        </div>
                                        <a href="{{route('ebook_plan.ebook-list')}}?id={{$plan->id}}"
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


