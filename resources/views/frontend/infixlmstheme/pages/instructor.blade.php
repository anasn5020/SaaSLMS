@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |   {{$instructor->name}} @endsection
@section('css')
    <style>
        .course_less_students {
            margin-bottom: 30px;
        }
    </style>
@endsection
@section('js')

    <script>

        var SITEURL = "{{route('instructorDetails',[$instructor->id,Str::slug($instructor->name,'-')])}}";
        var page = 1;
        load_more(page);
        $(window).scroll(function () { //detect page scroll
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 400) {
                page++;
                load_more(page);
            }


        });

        function load_more(page) {
            $.ajax({
                url: SITEURL + "?page=" + page,
                type: "get",
                datatype: "html",
                beforeSend: function () {
                    $('.ajax-loading').show();
                }
            })
                .done(function (data) {
                    if (data.length == 0) {

                        //notify user if nothing to load
                        $('.ajax-loading').html("");
                        return;
                    }
                    $('.ajax-loading').hide(); //hide loading animation once data is received
                    $("#results").append(data); //append data into #results element


                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('No response from server');
                });

        }
    </script>
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

@section('mainContent')

    @if ($InstructorSetup->show_instructor_page_banner)

        <x-breadcrumb :banner="$frontendContent->instructor_page_banner"
                      :title="trans('frontend.Learn More About Your Instructor')"
                      :subTitle="trans('frontend.Instructor Details')"/>
    @endif


    <x-instructor-page-section :instructor="$instructor" :id="$id"/>


    <div class="course_by_author">
        <div class="container">
            <div class="theme_border"></div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_80">
                        <h3>{{__('frontend.More Courses by Author')}}</h3>
                    </div>
                </div>
            </div>
            <div class="row row-gap-24" id="results">

            </div>
        </div>
    </div>
    @if(Settings('show_bundle_in_instructor_profile'))
        @if(isModuleActive('BundleSubscription'))
            <!-- course_by_author ::start  -->
            <div class="course_by_author">
                <div class="container">
                    <div class="theme_border"></div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="section__title text-center mb_80">
                                <h3>{{__('bundleSubscription.More Bundle Courses by Author')}}</h3>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        @foreach($BundleCourse as $value)
                            @php
                                $oldPrice = 0;
                                foreach ($value->course as $raw){
                                  $oldPrice += $raw->course->price;
                                }

                            @endphp
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="package_widget mb_30">
                                    <div class="package_header text-center">
                                        <h3>{{$value->title}}</h3>
                                        <div class="package_rating d-flex align-items-center justify-content-center">
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
                                            <p>({{$value->student}} {{__('bundleSubscription.students')}})</p>
                                        </div>
                                    </div>
                                    <div class="package_body">
                                        <div class="package_lists">
                                            @foreach($value->course as $key=>$raw)
                                                <div class="single_packageList {{$key>2?'d-none extra_'.$value->id:''}}">
                                                    <p>{{  Str::limit($raw->course->title, 40) }}</p>
                                                    <span>{{getPriceFormat($raw->course->price)}}</span>
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
                                                <h4><span>{{getPriceFormat($oldPrice)}}</span> {{getPriceFormat($value->price)}}
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
                    </div>
                </div>
            </div>

        @endif
    @endif

@endsection

