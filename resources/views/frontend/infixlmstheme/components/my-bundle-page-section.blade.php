<div>
    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/package.css')}}">

    <div class="main_content_iner main_content_padding">

        <div class="dashboard_lg_card">
            <div class="container-fluid g-0">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title3 mb_40">
                            <h3 class="mb-0">
                                {{__('frontend.My Bundle')}}
                            </h3>
                        </div>
                    </div>
                    <div class="col-12">
                        @if(isset($BundleCourse))
                            @forelse($BundleCourse as $value)
                                @php
                                    $oldPrice = 0;
                                    foreach ($value->course as $raw){
                                      $oldPrice += $raw->course->price;
                                    }

                                @endphp
                                <div class="col-lg-4 col-md-6">
                                    <div class="package_widget mb_30">
                                        <div class="package_header text-center">
                                            <h3>{{$value->title}}</h3>
                                            <div
                                                class="package_rating d-flex align-items-center justify-content-center">
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
                                                    <div
                                                        class="single_packageList {{$key>2?'d-none extra_'.$value->id:''}}">
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
                                                    <h4>
                                                        @if($oldPrice!=0)
                                                            <span>{{getPriceFormat($oldPrice)}}</span>
                                                            {{getPriceFormat((int)$value->price)}}
                                                        @else
                                                            <h4 class="text-center">{{getPriceFormat((int)$value->price)}}</h4>
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
                            @empty
                                <p class="text-center">
                                    {{__('common.No data available in the table')}}
                                </p>
                            @endforelse
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


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
</div>
