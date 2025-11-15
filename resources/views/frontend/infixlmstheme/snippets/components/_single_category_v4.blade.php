<div class="">
    <div class="category-items d-flex justify-content-center flex-wrap">
        @if(isset($result ))
            @foreach($result as $category)
                <a href="{{route('courses')}}?category_id[]={{$category->id}}"
                   class="category-item d-flex flex-wrap align-items-center gap-3">
                    <div class="icon bg-1"> {{-- need to dynamic bg class 1 to 8--}}
                        <img src="{{asset($category->image)}}" alt="">
                    </div>
                    <div class="content">
                        <h5 class="fw-500 lh-1 mb-2">{{$category->name}}</h5>
                        <p class="lh-1 fs-14">   {{translatedNumber($category->total_courses)}} {{__('frontend.Courses')}}</p>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
</div>



