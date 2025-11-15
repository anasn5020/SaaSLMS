<x-breadcrumb :banner="$frontendContent->about_page_banner" :title="$blog->title"
              :subTitle="trans('frontend.Blog Details')"/>

<div class="lms_blog_details_area">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-xxl-9 col-lg-8">
                <div class="blog_details_inner">
                    <div class="blog_details_banner">
                        <img class="w-100" src="{{getBlogImage($blog->image)}}" alt="">
                    </div>
                    <div class="content">
                        <div class="d-flex gap-12 blog_meta align-items-center flex-wrap">
                            <a href="{{$blog->user->username?route('profileUniqueUrl',$blog->user->username):''}}">
                                <div class="blog_meta_name d-flex align-items-center gap-2">
                                    <img src="{{asset($blog->user->image)}}" alt="user">
                                    {{$blog->user->name}}
                                </div>
                            </a>
                            <div class="blog_meta_date">
                                {{ showDate(@$blog->authored_date ) }} {{ @$blog->authored_time }}
                            </div>

                            @if($blog->category)
                                <div class="blog_meta_category">
                                    {{$blog->category->title}}
                                </div>
                            @endif
                        </div>
                        <h3>{{$blog->title}}</h3>
                        <p class="mb_25">

                            {!! $blog->description !!}
                        </p>
                        <br>

                        <h4 class="blog_share_title">Share This Article</h4>
                        <x-blog-details-share-section :blog="$blog"/>
                    </div>
                </div>
                @if(Settings('hide_blog_comment')!=1)
                    <div class="blog_reviews">
                        <h3 class="font_30 f_w_700 mb_50 lh-1">{{__('frontend.Comments')}}</h3>
                        <div class="blog_reviews_inner">
                            @foreach($blog->comments as $comment)
                                @php
                                    if (empty($comment->user_id)){
                                        $name =$comment->name;
                                    }else{
                                        $name =$comment->user->name;
                                    }

                                @endphp
                                <div class="lms_single_reviews position-relative">
                                    <div class="thumb">
                                        {{substr($name,0,2)}}
                                    </div>
                                    <div class="review_content flex-grow-1">
                                        <div
                                            class="review_content_head d-flex justify-content-between align-items-start flex-wrap flex-column flex-md-row">
                                            <div
                                                class="review_content_head_left d-flex align-items-start align-items-md-center gap-10 flex-wrap flex-column flex-md-row">
                                                <h4 class="f_w_500 font_24 font_md_18 font_sm_16">{{$name}}</h4>
                                                <div class="rated_customer m-0 d-flex align-items-center">
                                                    <span
                                                        class="blog_comment_time">{{$comment->created_at->diffforhumans()}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p>{{$comment->comment}}</p>

                                        <div
                                            class="comment_box_text mt_30 link d-flex align-items-center justify-content-between gap-4">
                                            <a class="reply_btn p-0"
                                               data-comment="{{@$comment->id}}" href="#">
                                                {{__('frontend.Reply') }}
                                            </a>
                                            @if(blogCommentCanDelete())
                                                <a class="deleteBtn p-0" title="{{__('common.Delete')}}" href="#"
                                                   data-bs-toggle="modal"
                                                   onclick="deleteCommnet('{{route('deleteBlogComment',$comment->id)}}','{{$comment->id}}_single_comment')"
                                                   data-bs-target="#deleteComment">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047"
                                                            stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path
                                                            d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97"
                                                            stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path
                                                            d="M18.8484 9.13965L18.1984 19.2096C18.0884 20.7796 17.9984 21.9996 15.2084 21.9996H8.78844C5.99844 21.9996 5.90844 20.7796 5.79844 19.2096L5.14844 9.13965"
                                                            stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M10.3281 16.5H13.6581" stroke="currentColor"
                                                              stroke-width="1.5" stroke-linecap="round"
                                                              stroke-linejoin="round"/>
                                                        <path d="M9.5 12.5H14.5" stroke="currentColor"
                                                              stroke-width="1.5" stroke-linecap="round"
                                                              stroke-linejoin="round"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>

                                        <div class="new_replay_add_form">
                                            <div class=" replyBox d-none inputForm reply_form_{{@$comment->id}} w-100">
                                                <form action="{{route('blogCommentSubmit')}}" method="post">
                                                    <input type="hidden" name="blog_id" value="{{$blog->id}}">
                                                    <input type="hidden" name="type" value="2">
                                                    @csrf
                                                    <input type="hidden" name="comment_id"
                                                           value="{{@$comment->id}}">
                                                    <div class="container p-0">
                                                        <div class="row">
                                                            @guest()
                                                                <div class="col-lg-6">
                                                                    <input name="name"
                                                                           placeholder="{{__('common.Enter Full Name')}}"
                                                                           onfocus="this.placeholder = ''"
                                                                           onblur="this.placeholder = '{{__('common.Enter Full Name')}}'"
                                                                           class="primary_input5 bg_style1   "
                                                                           required="" type="text">

                                                                </div>
                                                                <div class="col-6">
                                                                    <input name="email"
                                                                           placeholder="{{__('common.Enter Email Address')}}"
                                                                           onfocus="this.placeholder = ''"
                                                                           onblur="this.placeholder = '{{__('common.Enter Email Address')}}'"
                                                                           class="primary_input5  "
                                                                           required="" type="email">

                                                                </div>
                                                            @endguest
                                                            <div class="col-12">
                                                                <textarea name="comment"
                                                                          placeholder="{{__('common.Write your comments here')}}…"
                                                                          onfocus="this.placeholder = ''"
                                                                          onblur="this.placeholder = '{{__('common.Write your comments here')}}…'"
                                                                          class="primary_textarea5   "
                                                                          required=""></textarea>
                                                            </div>
                                                            <div class="col-12">
                                                                <button type="submit"
                                                                        class="theme_btn small_btn2 text-center">
                                                                    {{__('frontend.Reply')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="blog_reply_container">
                                    @foreach ($comment->replies as $replay)
                                        @php
                                            if (empty($replay->user_id)){
                                                $name =$replay->name;
                                            }else{
                                                $name =$replay->user->name;
                                            }

                                        @endphp
                                        <div class="lms_single_reviews replyBox flex-column flex-md-row">
                                            <div class="thumb">
                                                {{substr($name,0,2)}}
                                            </div>
                                            <div class="review_content flex-grow-1">
                                                <div
                                                    class="review_content_head d-flex justify-content-between align-items-start flex-wrap flex-column flex-md-row">
                                                    <div
                                                        class="review_content_head_left d-flex align-items-start align-items-md-center gap-10 flex-wrap flex-column flex-md-row">
                                                        <h4 class="f_w_500 font_24 font_md_18 font_sm_16">{{$name}}</h4>
                                                        <div class="rated_customer m-0 d-flex align-items-center">
                                                            <span
                                                                class="blog_comment_time">{{$replay->created_at->diffforhumans()}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="comment_box_text link">
                                                        @if(blogCommentCanDelete())
                                                            <a class="deleteBtn pe-0"
                                                               title="{{__('common.Delete')}}" href="#"
                                                               data-bs-toggle="modal"
                                                               onclick="deleteCommnet('{{route('deleteBlogComment',$replay->id)}}','{{$replay->id}}_single_reply_comment')"
                                                               data-bs-target="#deleteComment">
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path
                                                                        d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path
                                                                        d="M18.8484 9.13965L18.1984 19.2096C18.0884 20.7796 17.9984 21.9996 15.2084 21.9996H8.78844C5.99844 21.9996 5.90844 20.7796 5.79844 19.2096L5.14844 9.13965"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path d="M10.3281 16.5H13.6581"
                                                                          stroke="currentColor" stroke-width="1.5"
                                                                          stroke-linecap="round"
                                                                          stroke-linejoin="round"/>
                                                                    <path d="M9.5 12.5H14.5" stroke="currentColor"
                                                                          stroke-width="1.5" stroke-linecap="round"
                                                                          stroke-linejoin="round"/>
                                                                </svg>

                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p> {{$replay->comment}}</p>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="blog_reply_box mb_30 blogComment">
                        <h3 class="font_30 f_w_700  lh-1 mb_5 mb-4">{{__('frontend.Leave a comment')}}</h3>
                        <form action="{{route('blogCommentSubmit')}}" method="post">
                            <input type="hidden" name="blog_id" value="{{$blog->id}}">
                            <input type="hidden" name="type" value="1">
                            @csrf
                            <div class="row row-gap-24">
                                @guest()
                                    <div class="col-lg-6">
                                        <input name="name" placeholder="{{__('common.Enter Full Name')}}"
                                               onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = '{{__('common.Enter Full Name')}}'"
                                               class="primary_input5 bg_style1   "
                                               required="" type="text">

                                    </div>
                                    <div class="col-lg-6">
                                        <input name="email" placeholder="{{__('common.Enter Email Address')}}"
                                               onfocus="this.placeholder = ''"
                                               onblur="this.placeholder = '{{__('common.Enter Email Address')}}'"
                                               class="primary_input5  "
                                               required="" type="email">

                                    </div>
                                @endguest
                                <div class="col-12">
                                <textarea name="comment" placeholder="{{__('common.Write your comments here')}}…"
                                          onfocus="this.placeholder = ''"
                                          onblur="this.placeholder = '{{__('common.Write your comments here')}}…'"
                                          class="primary_textarea5   " required=""></textarea>

                                </div>
                                <div class="col-12">
                                    <button type="submit"
                                            class="theme_btn small_btn2 w-100  text-center text-center">
                                        {{__('frontend.Comment')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
            <div class="col-xxl-3 col-lg-4">
                <x-blog-sidebar-section :tag="$blog->tags"/>
            </div>
        </div>
    </div>
    @include(theme('partials._delete_model'))
</div>
