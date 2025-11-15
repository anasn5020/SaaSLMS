<div>
    <div class="blog_sidebar_wrap mb_30">
        <input type="hidden" class="blog_route" name="blog_route" value="{{route('blogs')}}">
        <form action="{{route('blogs')}}" method="GET">

            <div class="input-group  theme_search_field4 w-100 mb_20 style2">
                <div class="input-group-prepend">
                    <button class="btn" type="button"><i class="ti-search"></i></button>
                </div>
                <input type="text" name="query" value="{{request('query')}}" class="form-control search"
                       placeholder="{{__('common.Search')}}…">
            </div>
        </form>

        <div class="blog_sidebar_box mb_30">
            <h4 class="font_24 f_w_500 mb-4">
                {{__('frontend.Recent Posts')}}
            </h4>
            <div class="news_lists">
                @foreach($latestPosts as $post)
                    <div class="single_newslist d-flex gap-3 align-items-center">
                        <div>
                            <img src="{{getBlogImage($post->thumbnail)}}" class="thumb" alt="{{$post->title}}">
                        </div>
                        <div>
                            <a href="{{route('blogDetails',[$post->slug])}}" class="details_link">
                                {{$post->title}}
                            </a>
                            {{--<p>{{ showDate(@$post->authored_date ) }} / {{$post->category->title}}</p>--}}
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <div class="blog_sidebar_box mb_30">
            <h4 class="font_18 f_w_700 mb-4">
                {{__('frontend.Blog categories')}}
            </h4>
            {{--<div class="home6_border w-100 mb_20"></div>--}}
            <ul class="Check_sidebar mb-0">
                @foreach($categories as $cat)
                    <li>
                        <label class="primary_checkbox d-flex">
                            <input type="checkbox" value="{{$cat->id}}"
                                   class="category" {{in_array($cat->id,explode(',',$category))?'checked':''}}>
                            <span class="checkmark mr_15"></span>
                            <span class="label_name">{{$cat->title}}</span>
                        </label>
                    </li>
                @endforeach

            </ul>
        </div>

        @if(count($tags)!=0)
            <div class="blog_sidebar_box mb_30 p-0 border-0">
                <h4 class="font_18 f_w_700 mb-4">
                    {{__('frontend.Keywords')}}
                </h4>
                {{--<div class="home6_border w-100 mb_20"></div>--}}
                <div class="keyword_lists d-flex align-items-center flex-wrap gap_10">
                    @foreach($tags as $tag)
                        <a href="#">{{$tag}}</a>
                    @endforeach

                </div>
            </div>
        @endif
    </div>
</div>
