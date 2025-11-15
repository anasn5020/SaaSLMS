<div class="container">
    <div class="row">
        @if(isset($result))
            @foreach($result as $blog)
                <div class="col-lg-6">
                    <div class="single_blog">
                        <a href="{{route('blogDetails',[$blog->slug])}}">
                            <div class="thumb">

                                <div class="thumb_inner lazy"
                                     data-src="{{getBlogImage($blog->thumbnail)}}">
                                </div>
                            </div>
                        </a>
                        <div class="blog_meta">
                            <span>{{$blog->user->name}} . {{ showDate(@$blog->authored_date ) }} {{ translatedNumber($blog->authored_time )}}</span>

                            <a href="{{route('blogDetails',[$blog->slug])}}">
                                <h4>{{$blog->title}}</h4>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if(count($result)==0)
            <div class="col-lg-12">
                <div
                    class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
                    <div class="thumb">
                        <img style="width: 50px"
                             src="{{ asset('public/frontend/infixlmstheme/img/not-found.png') }}"
                             alt="">
                    </div>
                    <h1>
                        {{__('frontend.No Post Found')}}
                    </h1>
                </div>
            </div>
        @endif

    </div>
    <script>
        $(function () {
            if ($.isFunction($.fn.lazy)) {
                $('.lazy').lazy();
            }
        });
    </script>
</div>
