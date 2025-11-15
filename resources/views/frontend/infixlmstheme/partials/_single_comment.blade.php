<div class="conversition_box">
    <div class="single_comment_box" id="{{$comment->id}}_single_comment">
        <div class="comment_box_inner">
            <div class="comment_box_info">
                <div class="thumb">
                    <div
                        class="profile_info profile_img collaps_icon d-flex align-items-center">
                        <div class="studentProfileThumb"
                             style="background-image: url('{{getProfileImage(@$comment->user['image']??'',$comment->user['name']??'')}}');margin: 0"></div>

                    </div>

                </div>
                <div class="comment_box_text link">
                    @if(commentCanDelete($comment->id,$comment->instructor_id))
                        <a class="deleteBtn pe-0" href="#"
                           data-bs-toggle="modal"
                           onclick="deleteCommnet('{{route('deleteComment',$comment->id)}}','{{$comment->id}}_single_comment')"
                           data-bs-target="#deleteComment">
                            <svg  class="delete_svg_icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M18.8484 9.13965L18.1984 19.2096C18.0884 20.7796 17.9984 21.9996 15.2084 21.9996H8.78844C5.99844 21.9996 5.90844 20.7796 5.79844 19.2096L5.14844 9.13965" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10.3281 16.5H13.6581" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9.5 12.5H14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    @endif
                    <a href="#">
                        <h5>{{$comment->user['name']}}</h5>
                    </a>
                    <span>{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}  </span>


                    <p>{{@$comment->comment}}</p>

                    @if ($isEnrolled)
                        <a class="reply_btn mb-3 mt-2  @if(commentCanDelete($comment->id,$comment->instructor_id)) @endif"
                           data-comment="{{@$comment->id}}" href="#">

                            {{__('frontend.Reply') }}
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @endif

                </div>
            </div>
        </div>
        <div
            class="d-none inputForm comment_box_inner comment_box_inner_reply reply_form_{{@$comment->id}}">

            <form action="{{route('submitCommnetReply')}}" method="post">
                @csrf
                <input type="hidden" name="comment_id"
                       value="{{@$comment->id}}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="single_input mb_25">
                                                                                            <textarea
                                                                                                placeholder="Leave a reply"
                                                                                                rows="2" name="reply"
                                                                                                class="primary_textarea gray_input h-25"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 mb_30">
                        @if ($isEnrolled)
                            <button type="submit"
                                    class="theme_btn small_btn4">
                                <i class="fas fa-reply"></i>
                                {{__('frontend.Reply') }}
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        @if(isset($comment->replies))
            @foreach ($comment->replies->where('reply_id',null) as $replay)

                <div class="comment_box_inner comment_box_inner_reply" id="{{$replay->id}}_single_comment_reply">
                    <div class="comment_box_info ">

                        <div class="thumb">
                            <div
                                class="profile_info profile_img collaps_icon d-flex align-items-center">
                                <div class="studentProfileThumb"
                                     style="background-image: url('{{getProfileImage($replay->user['image']??'',$replay->user['name']??'')}}');margin: 0"></div>

                            </div>

                        </div>

                        <div class="comment_box_text link">
                            @if(ReplyCanDelete($replay->user_id,$course->user_id))
                                <a class="position_right" href="#"
                                   data-bs-toggle="modal"
                                   onclick="deleteCommnet('{{route('deleteCommentReply',$replay->id)}}','{{$replay->id}}_single_comment_reply')"
                                   data-bs-target="#deleteComment">
                                    <svg  class="delete_svg_icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M18.8484 9.13965L18.1984 19.2096C18.0884 20.7796 17.9984 21.9996 15.2084 21.9996H8.78844C5.99844 21.9996 5.90844 20.7796 5.79844 19.2096L5.14844 9.13965" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.3281 16.5H13.6581" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.5 12.5H14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            @endif
                            <a href="#">
                                <h5>{{@$replay->user['name']}}</h5>
                            </a>
                            <span>
                                                                            {{ \Carbon\Carbon::parse($replay->created_at)->diffForHumans() }}
                                                             </span>
                            <p>{{@$replay->reply}}</p>

                            @if ($isEnrolled)
                                <a class="reply2_btn mb-3 mt-2 @if(ReplyCanDelete($replay->user_id,$course->user_id)) @endif"
                                   data-reply="{{@$replay->id}}" href="#">

                                    {{__('frontend.Reply') }}
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @endif

                        </div>

                    </div>
                </div>
                <div
                    class="d-none inputForm comment_box_inner comment_box_inner_reply reply2_form_{{@$replay->id}}">

                    <form action="{{route('submitCommnetReply')}}"
                          method="post">
                        @csrf
                        <input type="hidden" name="comment_id"
                               value="{{@$comment->id}}">
                        <input type="hidden" name="reply_id"
                               value="{{@$replay->id}}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="single_input mb_25">
                                                                                            <textarea
                                                                                                placeholder="Leave a reply"
                                                                                                rows="2" name="reply"
                                                                                                class="primary_textarea gray_input h-25"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 mb_30">
                                @if ($isEnrolled)
                                    <button type="submit"
                                            class="theme_btn small_btn4">
                                        <i class="fas fa-reply"></i>
                                        {{__('frontend.Reply') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>


                @foreach ($comment->replies->where('reply_id',$replay->id) as $replay)

                    <div class="comment_box_inner comment_box_inner_reply2" id="{{$replay->id}}_single_comment_reply_reply">
                        <div class="comment_box_info ">
                            <div class="thumb">
                                <div
                                    class="profile_info profile_img collaps_icon d-flex align-items-center">
                                    <div class="studentProfileThumb"
                                         style="background-image: url('{{getProfileImage($replay->user['image']??'',$replay->user['name']??'')}}');margin: 0"></div>

                                </div>

                            </div>

                            <div class="comment_box_text ">
                                <a href="#">
                                    <h5>{{@$replay->user['name']}}</h5>
                                </a>
                                <span>
                                {{ \Carbon\Carbon::parse($replay->created_at)->diffForHumans() }} </span>
                                <p>{{@$replay->reply}}</p>

                            </div>

                            <div class="comment_box_text link">
                                @if(ReplyCanDelete($replay->user_id,$course->user_id))
                                    <a class="position_right" href="#"
                                       data-bs-toggle="modal"
                                       onclick="deleteCommnet('{{route('deleteCommentReply',$replay->id)}}','{{$replay->id}}_single_comment_reply_reply')"
                                       data-bs-target="#deleteComment">
                                        <svg  class="delete_svg_icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21 5.98047C17.67 5.65047 14.32 5.48047 10.98 5.48047C9 5.48047 7.02 5.58047 5.04 5.78047L3 5.98047" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M18.8484 9.13965L18.1984 19.2096C18.0884 20.7796 17.9984 21.9996 15.2084 21.9996H8.78844C5.99844 21.9996 5.90844 20.7796 5.79844 19.2096L5.14844 9.13965" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M10.3281 16.5H13.6581" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M9.5 12.5H14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            @endforeach
        @endif

    </div>
</div>
</div>
