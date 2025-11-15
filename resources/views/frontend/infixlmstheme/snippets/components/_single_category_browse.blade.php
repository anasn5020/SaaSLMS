<div class="row">
    <div class="col-lg-6 col-md-6">
        @if(isset($result ))
            @foreach ($result  as $key=>$category)
                @if($key==0)
                    <div class="category_wiz mb_30">
                        <div class="thumb cat1"
                             style="background-image: url('{{asset($category->thumbnail)}}')">
                            <a href="{{route('courses')}}?category_id[]={{$category->id}}"
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
        @if(isset($result ))
            @foreach ($result  as $key=>$category)

                @if($key==1)
                    <div class="category_wiz mb_30">
                        <div class="thumb cat2"
                             style="background-image: url('{{asset($category->thumbnail)}}')">
                            <a href="{{route('courses')}}?category_id[]={{$category->id}}"
                               class="cat_btn">{{$category->name}}</a>
                        </div>
                    </div>
                @elseif($key==2)
                    <div class="category_wiz mb_30">
                        <div class="thumb  cat3"
                             style="background-image: url('{{asset($category->thumbnail)}}')">
                            <a href="{{route('courses')}}?category_id[]={{$category->id}}"
                               class="cat_btn">{{$category->name}}</a>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>


</div>
