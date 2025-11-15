<div class="row">
    @if(isset($result))
        @foreach($result as $blog)
            <div class="col-lg-6 col-xl-3 col-md-6">
                <div class="single_blog">
                    <a href="{{route('blogDetails',[$blog->slug])}}">
                        <div class="thumb">
                            <div class="thumb_inner lazy"
                                 data-src="{{ file_exists($blog->thumbnail) ? asset($blog->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                            </div>
                        </div>
                    </a>
                    <div class="blog_meta">
                        <span>{{$blog->user->name}} . {{$blog->authored_date}}</span>
                        <a href="{{route('blogDetails',[$blog->slug])}}">
                            <h4 class="noBrake" title="{{$blog->title}}">{{$blog->title}}</h4>
                        </a>
                    </div>
                </div>


            </div>
        @endforeach
    @endif

    <script>
        if ($.isFunction($.fn.lazy)) {
            $('.lazy').lazy();
        }
    </script>
</div>
