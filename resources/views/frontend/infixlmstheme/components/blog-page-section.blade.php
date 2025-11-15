<div>

    <div class="lms_blog_details_area">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-xl-9 col-lg-9">
                    <div class="blog_page_wrapper pt-0">
                        <div class="container p-0">
                            <div class="row row-gap-24">
                                @if(isset($blogs))
                                    @foreach($blogs as $blog)
                                        <div class="col-lg-4">
                                            <div class="single_blog" data-category="{{$blog->category->title}}">
                                                <a href="{{route('blogDetails',[$blog->slug])}}">
                                                    <div class="thumb">

                                                        <div class="thumb_inner lazy"
                                                             data-src="{{getBlogImage($blog->thumbnail)}}">
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="blog_meta">
                                                    <span>{{$blog->user->name}} . {{ showDate(@$blog->authored_date ) }} {{ @$blog->authored_time }}</span>

                                                    <a href="{{route('blogDetails',[$blog->slug])}}">
                                                        <h4>{{$blog->title}}</h4>
                                                    </a>

                                                    <div
                                                        class="d-flex align-items-end blog_item_footer">
                                                        <div class="d-flex justify-content-between align-items-center gap-4 flex-wrap">
                                                            <a href="{{route('blogDetails',[$blog->slug])}}"
                                                               class="blog_read_more text-nowrap">{{__('common.Read More')}}</a>
                                                            @if($blog->minutes)
                                                                <p class="blog_length text-nowrap">{{MinuteFormat($blog->minutes)}} {{__('frontend.To Read')}}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @if(count($blogs)==0)
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
                            <div class="mt-4">
                                {{ $blogs->appends(Request::all())->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3">

                    <x-blog-sidebar-section :tag="''"/>


                </div>
            </div>
        </div>
    </div>
</div>
