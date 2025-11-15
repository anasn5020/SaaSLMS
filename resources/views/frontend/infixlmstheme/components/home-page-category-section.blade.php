<div class="category_area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                @if(isset($homeContent))
                    @if($homeContent->show_key_feature==1)

                        <div class="couses_category">
                            <div class="row">


                                <div class="col-xl-4 col-md-4">
                                    <div class="single_course_cat">
                                        <div class="icon">
                                            @if(!empty($homeContent->key_feature_logo1))
                                                <img
                                                    src="{{asset($homeContent->key_feature_logo1)}}"
                                                    alt="">
                                            @endif
                                        </div>
                                        <div class="course_content">
                                            <h4>
                                                @if(!empty($homeContent->feature_link1))
                                                    <a
                                                        href="{{$homeContent->feature_link1}}"> @endif
                                                        {{$homeContent->key_feature_title1}}
                                                        @if(!empty($homeContent->feature_link1))   </a>
                                                @endif
                                            </h4>
                                            <p>{{$homeContent->key_feature_subtitle1}} </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4">
                                    <div class="single_course_cat">
                                        <div class="icon">
                                            @if(!empty($homeContent->key_feature_logo2))
                                                <img
                                                    src="{{asset($homeContent->key_feature_logo2)}}"
                                                    alt="">
                                            @endif
                                        </div>
                                        <div class="course_content">
                                            <h4>
                                                @if(!empty($homeContent->feature_link2))
                                                    <a
                                                        href="{{$homeContent->feature_link2}}"> @endif
                                                        {{$homeContent->key_feature_title2}}
                                                        @if(!empty($homeContent->feature_link2))   </a>
                                                @endif
                                            </h4>
                                            <p>{{$homeContent->key_feature_subtitle2}} </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-4">
                                    <div class="single_course_cat">
                                        <div class="icon">
                                            @if(!empty($homeContent->key_feature_logo3))
                                                <img
                                                    src="{{asset($homeContent->key_feature_logo3)}}"
                                                    alt="">
                                            @endif
                                        </div>
                                        <div class="course_content">
                                            <h4>
                                                @if(!empty($homeContent->feature_link3))
                                                    <a
                                                        href="{{$homeContent->feature_link3}}"> @endif
                                                        {{$homeContent->key_feature_title3}}
                                                        @if(!empty($homeContent->feature_link3))   </a>
                                                @endif
                                            </h4>
                                            <p>{{$homeContent->key_feature_subtitle3}} </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                @endif

            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section__title mb_40">
                    <h3>
                        {{@$homeContent->category_title}}
                    </h3>
                    <p>
                        {{@$homeContent->category_sub_title}}
                    </p>

                    <a href="{{route('courses')}}"
                       class="line_link">{{__('frontend.View All Courses')}}</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        @if(isset($categories ))
                            @foreach ($categories  as $key=>$category)
                                @if($key==0)
                                    <div class="category_wiz mb_30">
                                        <div class="thumb cat1"
                                             style="background-image: url('{{asset($category->thumbnail)}}')">
                                            <a href="{{route('courses')}}?category={{$category->id}}"
                                               class="cat_btn">{{$category->name}}</a>
                                        </div>
                                    </div>
                                    <a href="{{route('courses')}}"
                                       class="brouse_cat_btn ">
                                        {{__('frontend.Browse all of other categories')}}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <div class="col-lg-6 col-md-6">
                        @if(isset($categories ))
                            @foreach ($categories  as $key=>$category)

                                @if($key==1)
                                    <div class="category_wiz mb_30">
                                        <div class="thumb cat2"
                                             style="background-image: url('{{asset($category->thumbnail)}}')">
                                            <a href="{{route('courses')}}?category={{$category->id}}"
                                               class="cat_btn">{{$category->name}}</a>
                                        </div>
                                    </div>
                                @elseif($key==2)
                                    <div class="category_wiz mb_30">
                                        <div class="thumb  cat3"
                                             style="background-image: url('{{asset($category->thumbnail)}}')">
                                            <a href="{{route('courses')}}?category={{$category->id}}"
                                               class="cat_btn">{{$category->name}}</a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
