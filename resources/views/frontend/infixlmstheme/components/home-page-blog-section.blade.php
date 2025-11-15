<div>
    <div class="blog_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section__title text-center mb_80">
                        <h3>
                            {{@$homeContent->article_title}}
                        </h3>
                        <p>
                            {{@$homeContent->article_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(isset($blogs))
                    @foreach($blogs as $blog)
                        <div class="col-lg-6 col-xl-3 col-md-6">

                            <div class="single_blog couse_wizged">
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
                <div class="row col-md-12">
                    <div class="col-12 text-center pt_70">
                        <a href="{{route('blogs')}}"
                           class="theme_btn mb_30">{{__('frontend.View All Articles & News')}}</a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
