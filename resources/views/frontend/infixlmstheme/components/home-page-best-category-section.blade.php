<div>
    <div class="package_area"
         style="background-image: url('{{asset(@$homeContent->best_category_banner)}}')">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9">
                    <div class="section__title text-center mb_80">
                        <h3>
                            {{@$homeContent->best_category_title}}
                        </h3>
                        <p>
                            {{@$homeContent->best_category_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="package_carousel_active owl-carousel">
                        @if(isset($categories ))
                            @foreach($categories  as $category)

                                <div class="single_package">
                                    <div class="icon">
                                        <img src="{{asset($category->image)}}" alt="">
                                    </div>
                                    <a href="{{route('courses')}}?category={{$category->id}}">
                                        <h4>{{$category->name}}</h4>
                                    </a>
                                    <p>{{$category->courses_count}} {{__('frontend.Courses')}}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
