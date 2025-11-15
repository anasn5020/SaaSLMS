<div class="single_comment_box" id="{{$qna->id}}_single_comment">
    <div class="comment_box_inner">
        <div class="comment_box_info">
            <div class="thumb">
                <div
                    class="profile_info profile_img collaps_icon d-flex align-items-center">
                    <div class="studentProfileThumb"
                         style="background-image: url('{{getProfileImage(@$qna->user->image??'',$qna->user->name??'')}}');margin: 0"></div>

                </div>

            </div>
            <div class="comment_box_text link">
                <a href="#">
                    <h5>{{$qna->user->name}}</h5>
                </a>
                <span>{{ \Carbon\Carbon::parse($qna->created_at)->diffForHumans() }}  </span>

                <p>{!! $qna->text !!}</p>

            </div>
        </div>
    </div>


    @foreach ($qna->child as $reply)

        <div class="comment_box_inner comment_box_inner_reply" id="{{$reply->id}}_single_comment_reply">
            <div class="comment_box_info ">

                <div class="thumb">
                    <div
                        class="profile_info profile_img collaps_icon d-flex align-items-center">
                        <div class="studentProfileThumb"
                             style="background-image: url('{{getProfileImage($reply->user->image,$reply->user->name)}}');margin: 0"></div>

                    </div>

                </div>

                <div class="comment_box_text link">


                    <a href="#">
                        <h5>{{@$reply->user->name}}</h5>
                    </a>
                    <span>
                                                                            {{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}
                                                             </span>
                    <p>{!! $reply->text !!}</p>

                </div>

            </div>
        </div>

    @endforeach


</div>
