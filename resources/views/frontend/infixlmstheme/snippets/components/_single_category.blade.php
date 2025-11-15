<div class="">
    <style>
        .package_area .single_package .icon{
            background: var(--system_primery_color);
            background-size: 200% auto;
            border-radius: 100%;
            width: 136px;
            height: 136px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    <div class="package_carousel_active owl-carousel">
        @if(isset($result ))
            @foreach($result  as $category)

                <div class="single_package">
                    <div class="icon">
                        <img src="{{asset($category->image)}}" alt="">
                    </div>
                    <a href="{{route('courses')}}?category_id[]={{$category->id}}">
                        <h4>{{$category->name}}</h4>
                    </a>
                    <p>{{translatedNumber($category->courses_count)}} {{__('frontend.Courses')}}</p>
                </div>
            @endforeach
        @endif
    </div>

    <script>

    </script>
</div>
