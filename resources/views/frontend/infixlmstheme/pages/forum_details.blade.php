@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('forum.Forum')}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/forum.css')}}{{assetVersion()}}">
    <link href="{{asset('public/backend/css/summernote-bs4.min.css')}}" rel="stylesheet">

@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/forum.js')}}"></script>
    <script src="{{asset('public/backend/js/summernote-bs5.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.forum_reply').summernote({
                placeholder: 'Write your reply here',
                tabsize: 2,
                height: 188,
                tooltip: false
            });
        });
        $(document).ready(function () {
            $('.note-toolbar').find('[data-toggle]').each(function () {
                $(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
            });
        });
        $(document).ready(function () {
            $('.note-modal').find('[data-dismiss]').each(function () {
                $(this).attr('data-bs-dismiss', $(this).attr('data-dismiss')).removeAttr('data-dismiss');
            });
        });
    </script>
    @if($errors->any())
        <script>  toastr.warning("Reply field is required", "Required", {timeOut: 5000}); </script>
    @endif
    <script src="{{asset('Modules/Forum/Resources/assets/js/forum.js')}}"></script>
@endsection
<input type="hidden" id="forum_url" value="{{url('/forum')}}">



@section('mainContent')
    <x-breadcrumb :banner="trans('common.N/A')"
                  :title="trans('frontend.Join the Discussion in Our Forum')"
                  :subTitle="trans('frontend.Forum')"/>
    <style>
        .theme_search_field.style2 {
            width: 100%;
        }
    </style>
    <!-- fourm_area::start  -->
    <div class="fourm_area section_spacing4">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 offset-xl-1">
                    <div class="fourm_header d-flex align-items-center justify-content-between">
                        <div class="fourm_header_left">
                            <select class="fourm_select" id="course_list">
                                <option value="0" data-display="Select Courses">Select Courses</option>
                                @foreach ($courses as $course)
                                    <option
                                        {{isset($forum->course_id) ? $forum->course_id==$course->id? 'selected':'':''}} value="{{$course->id}}">{{$course->title}} </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="fourm_header d-flex align-items-center justify-content-between">
                        @csrf
                        <div class="input-group theme_search_field style2">
                            <div class="input-group-prepend">
                                <button class="btn" type="submit" id="button-addon1"><i class="ti-search"></i></button>
                            </div>
                            <input type="text" autocomplete="off" id="forum_search_input" class="form-control"
                                   placeholder="Search…">
                        </div>
                    </div>
                    <input type="hidden" id="loader_icon"
                           value="{{asset('Modules/Forum/Resources/assets/img/LoaderIcon.gif')}}">
                    <div class="forum_suggestion">
                        <ul class="list" id="forum_suggestion_list" style="display: none">

                        </ul>

                    </div>
                    <input type="text" hidden id="course_id" value="{{$forum->course_id}}">
                    <div class="fourm_body">
                        <div class="tab-content mb_20 " id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                 aria-labelledby="nav-home-tab">
                                <div class="forum_replay_wrapper">
                                    <div class="topic_replay">

                                        <div class="col-lg-12 p-0 d-flex">
                                            <div class="col-lg-11 p-0">
                                                <h3>
                                                    {{@$forum->title}}
                                                    @if ($forum->privacy==1)
                                                        <span class="topic_info">Private</span>
                                                    @endif
                                                </h3>
                                            </div>
                                            <div class="col-lg-1 p-0">
                                                @if (Auth::user()->id == $forum->created_by || Auth::user()->role_id==1)
                                                    <div class="dropdown">
                                                        <button class="btn btn-default dropdown-toggle" type="button"
                                                                id="dropdownMenu1" data-bs-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="true"
                                                                style="width:50px;height:50px">
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu forum_option"
                                                            aria-labelledby="dropdownMenu1">
                                                            <li class="option"><a
                                                                    href="{{route('forum.EditForum',$forum->id)}}">Edit</a>
                                                            </li>
{{--                                                            <li class="option"><a href="#">Delete</a></li>--}}
                                                            @if ($forum->is_closed==1)
                                                                <li class="option"><a
                                                                        href="{{route('forum.OpenForum',$forum->id)}}">Open</a>
                                                                </li>
                                                            @else
                                                                <li class="option"><a
                                                                        href="{{route('forum.CloseForum',$forum->id)}}">Close</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>

                                                @endif
                                            </div>
                                        </div>

                                        <p class="complete">{!! $forum->description !!}</p>
                                        <span class="category_tag ">
                                        {{@$forum->user->name}}
                                    </span>
                                    </div>
                                    @if ($forum->replies->count()>0)

                                        <div class="forum_replay" id="1">
                                            @foreach ($forum->replies as $key=> $reply)

                                                <div class="forum_replay_single">
                                                    <div
                                                        class="forum_replay_head d-flex align-items-center gap_15  flex-wrap">
                                                        <div class="thumb">
                                                            <div
                                                                class="profile_info profile_img collaps_icon d-flex align-items-center">
                                                                <div class="studentProfileThumb"
                                                                     style="background-image: url('{{getProfileImage($reply->user->image,$reply->user->name)}}');margin: 0"></div>
                                                            </div>
                                                            <!-- user_hover_card ::start -->
                                                            <div class="user_hover_card">
                                                                <div class="user_card_top">
                                                            <span>
                                                                <div class="thumb">
                                                                    <div
                                                                        class="profile_info profile_img collaps_icon d-flex align-items-center">
                                                                        <div class="studentProfileThumb"
                                                                             style="background-image: url('{{getProfileImage($reply->user->image,$reply->user->name)}}');margin: 0"></div>
                                                                    </div>
                                                                </div>
                                                            </span>

                                                                    <h3>{{$reply->user->name}}</h3>
                                                                    <p>{{ \Carbon\Carbon::parse($reply->user->created_at)->diffForhumans() }}
                                                                        .
                                                                        Joined {{showDate($reply->user->created_at)}}</p>
                                                                </div>
                                                                <div class="user_points">
                                                                    <span>Point’s</span>
                                                                    <h3>{{$reply->user->forumReply->sum('points')}}</h3>
                                                                </div>
                                                                <div class="user_card_info">
                                                                    <p>Post’s
                                                                        <span> - {{$reply->user->forums->count()}}</span>
                                                                    </p>
                                                                    <p>Reply
                                                                        <span> - {{$reply->user->forumReply->count()}}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <!-- user_hover_card ::end -->
                                                        </div>
                                                        <div class="forum_head_text">
                                                            <h3>{{$reply->user->name}}</h3>
                                                            <p>{{showDate($reply->created_at)}}
                                                                , {{date("H:i:s A",strtotime($reply->created_at))}}</p>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="forum_body multi-collapse collapse show reply_{{$reply->id}}"
                                                        id="show_reply_{{$reply->id}}">
                                                        <p> {!! @$reply->reply !!}</p>
                                                    </div>
                                                    {{-- Start Reply Update --}}
                                                    <div
                                                        class="commnet_replay_box reply_{{$reply->id}} flex-fill multi-collapse collapse"
                                                        id="reply_update_box_{{$reply->id}}">
                                                        <form action="{{route('forum.ForumReplyUpdate')}}"
                                                              method="post">
                                                            @csrf
                                                            <input type="hidden" name="forum_id"
                                                                   value="{{@$forum->id}}">
                                                            <input type="hidden" name="reply_id"
                                                                   value="{{@$reply->id}}">
                                                            <textarea class="primary_textarea3 style3 forum_reply"
                                                                      name="reply"
                                                                      placeholder="Write your reply here"> {!! @$reply->reply !!}</textarea>
                                                            <button type="submit"
                                                                    class="theme_btn small_btn5 text-end mt-2">Update
                                                            </button>
                                                        </form>
                                                    </div>
                                                    {{-- End Reply Update --}}
                                                    <div class="forum_foot d-flex align-items-center flex-wrap gap_15">
                                                        <div class="forum_left flex-fill">
                                                            <a href="#">{{$reply->repliesofReply->count()}} Replies</a>
                                                        </div>
                                                        <div class="forum_right">
                                                            @if ($forum->is_closed!=1)
                                                                <a data-bs-toggle="collapse"
                                                                   data-bs-target=".reply_{{$reply->id}}" href="#"
                                                                   data-reply_id="{{$reply->id}}" role="button"
                                                                   aria-expanded="false"
                                                                   aria-controls="reply_update_box_{{$reply->id}} show_reply_{{$reply->id}}">
                                                                    <img
                                                                        src="{{asset('Modules/Forum/Resources/assets/img/edit.svg')}}"
                                                                        alt="#">
                                                                    Edit
                                                                </a>
                                                            @endif
                                                            <a data-bs-toggle="modal"
                                                               data-bs-target="#replyDelete{{$reply->id}}" href="#">
                                                                <img
                                                                    src="{{asset('Modules/Forum/Resources/assets/img/trash.svg')}}"
                                                                    alt="#"> Delete</a>
                                                            <a data-bs-toggle="collapse"
                                                               href="#collapseExample{{$reply->id}}" role="button"
                                                               aria-expanded="false" aria-controls="collapseExample">
                                                                <img
                                                                    src="{{asset('Modules/Forum/Resources/assets/img/reply.svg')}}"
                                                                    alt="#"> Reply</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal cs_modal fade admin-query"
                                                     id="replyDelete{{$reply->id}}" role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{__('forum.Delete Forum Reply')}} </h5>
                                                                <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"><i
                                                                        class="ti-close "></i></button>
                                                            </div>
                                                            <form action="{{route('forum.ReplyDelete')}}" method="POST"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="reply_id"
                                                                           value="{{$reply->id}}">
                                                                    <h4>{{__('forum.Are You Sure To Delete?')}}</h4>
                                                                </div>
                                                                <div class="modal-footer justify-content-center">
                                                                    <div class="mt-40 d-flex justify-content-between">
                                                                        <button type="button"
                                                                                class="theme_line_btn me-2"
                                                                                data-bs-dismiss="modal">{{ __('common.Cancel') }}
                                                                        </button>
                                                                        <button class="theme_btn "
                                                                                type="submit">{{ __('common.Submit') }}</button>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="collapse" id="collapseExample{{$reply->id}}">
                                                    @foreach ($reply->repliesofReply as $second_reply)
                                                        <div class="forum_replay_single">
                                                            <div
                                                                class="forum_replay_head d-flex align-items-center gap_15  flex-wrap">
                                                                <div class="thumb">
                                                                    <div
                                                                        class="profile_info profile_img collaps_icon d-flex align-items-center">
                                                                        <div class="studentProfileThumb"
                                                                             style="background-image: url('{{getProfileImage($second_reply->user->image,$second_reply->user->name)}}');margin: 0"></div>
                                                                    </div>
                                                                    <!-- user_hover_card ::start -->
                                                                    <div class="user_hover_card">
                                                                        <div class="user_card_top">
                                                            <span>
                                                                <div class="thumb">
                                                                    <div
                                                                        class="profile_info profile_img collaps_icon d-flex align-items-center">
                                                                        <div class="studentProfileThumb"
                                                                             style="background-image: url('{{getProfileImage($second_reply->user->image,$second_reply->user->name)}}');margin: 0"></div>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                                            <h3>{{$second_reply->user->name}}</h3>
                                                                            <p>{{ \Carbon\Carbon::parse($second_reply->user->created_at)->diffForhumans() }}
                                                                                .
                                                                                Joined {{showDate($second_reply->user->created_at)}}</p>
                                                                        </div>
                                                                        <div class="user_points">
                                                                            <span>Point’s</span>
                                                                            <h3>{{$second_reply->user->forumReply->sum('points')}}</h3>
                                                                        </div>
                                                                        <div class="user_card_info">
                                                                            <p>Post’s
                                                                                <span> - {{$second_reply->user->forums->count()}}</span>
                                                                            </p>
                                                                            <p>Reply
                                                                                <span> - {{$second_reply->user->forumReply->count()}}</span>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <!-- user_hover_card ::end -->
                                                                </div>
                                                                <div class="forum_head_text">
                                                                    <h3>{{$second_reply->user->name}}</h3>
                                                                    <p>{{showDate($second_reply->created_at)}}
                                                                        , {{date("H:i:s A",strtotime($second_reply->created_at))}}</p>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="forum_body multi-collapse collapse show second_reply_{{$second_reply->id}}"
                                                                id="second_show_reply_{{$second_reply->id}}">
                                                                <p> {!! @$second_reply->reply !!}</p>
                                                            </div>
                                                            <div
                                                                class="commnet_replay_box second_reply_{{$second_reply->id}} flex-fill multi-collapse collapse"
                                                                id="second_reply_update_box_{{$second_reply->id}}">
                                                                <form action="{{route('forum.RepliesReplyUpdate')}}"
                                                                      method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="forum_id"
                                                                           value="{{@$forum->id}}">
                                                                    <input type="hidden" name="reply_id"
                                                                           value="{{@$reply->id}}">
                                                                    <input type="hidden" name="second_reply_id"
                                                                           value="{{@$second_reply->id}}">
                                                                    <textarea
                                                                        class="primary_textarea3 style3 forum_reply "
                                                                        name="reply"
                                                                        placeholder="Write your reply here"> {!! @$second_reply->reply !!}</textarea>
                                                                    <button type="submit"
                                                                            class="theme_btn small_btn5 text-end mt-2">
                                                                        Update
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            <div
                                                                class="forum_foot d-flex align-items-center flex-wrap gap_15">
                                                                <div class="forum_left flex-fill">
                                                                    {{-- <a href="#">03 Replies</a> --}}
                                                                </div>
                                                                <div class="forum_right">
                                                                    @if ($forum->is_closed!=1)
                                                                        <a data-bs-toggle="collapse"
                                                                           data-bs-target=".second_reply_{{$second_reply->id}}"
                                                                           href="#"
                                                                           data-second_reply_id="{{$second_reply->id}}"
                                                                           role="button" aria-expanded="false"
                                                                           aria-controls="second_reply_update_box_{{$second_reply->id}} show_second_reply_{{$second_reply->id}}">
                                                                            <img
                                                                                src="{{asset('Modules/Forum/Resources/assets/img/edit.svg')}}"
                                                                                alt="#">
                                                                            Edit
                                                                        </a>
                                                                    @endif
                                                                    <a data-bs-toggle="modal"
                                                                       data-bs-target="#secondReplyDelete{{$second_reply->id}}"
                                                                       href="#"> <img
                                                                            src="{{asset('Modules/Forum/Resources/assets/img/trash.svg')}}"
                                                                            alt="#"> Delete</a>
                                                                    {{-- <a  href="#"> <img src="{{asset('Modules/Forum/Resources/assets/img/trash.svg')}}" alt="#"> Delete</a> --}}
                                                                    {{-- <a href="#"> <img src="{{asset('Modules/Forum/Resources/assets/img/reply.svg')}}" alt="#"> Reply</a> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal cs_modal fade admin-query"
                                                             id="secondReplyDelete{{$second_reply->id}}" role="dialog">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Delete Forum Reply </h5>
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"><i
                                                                                class="ti-close "></i></button>
                                                                    </div>

                                                                    <form action="{{route('forum.ReplyofReplyDelete')}}"
                                                                          method="Post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <input type="hidden" name="reply_id"
                                                                                   value="{{$second_reply->id}}">
                                                                            <h4>Are You Sure To Delete?</h4>
                                                                        </div>
                                                                        <div
                                                                            class="modal-footer justify-content-center">
                                                                            <div
                                                                                class="mt-40 d-flex justify-content-between">
                                                                                <button type="button"
                                                                                        class="theme_line_btn me-2"
                                                                                        data-bs-dismiss="modal">{{ __('common.Cancel') }}
                                                                                </button>
                                                                                <button class="theme_btn "
                                                                                        type="submit">{{ __('common.Submit') }}</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @if ($forum->is_closed!=1)

                                                        <div class="forum_replay_single">
                                                            <div
                                                                class="forum_replay_head d-flex align-items-start gap_15  flex-wrap">
                                                                <div class="thumb position-relative">
                                                                    <div
                                                                        class="profile_info profile_img collaps_icon d-flex align-items-center">
                                                                        <div class="studentProfileThumb"
                                                                             style="background-image: url('{{getProfileImage(Auth::user()->image,Auth::user()->name)}}');margin: 0"></div>
                                                                    </div>

                                                                </div>
                                                                <div class="commnet_replay_box flex-fill">
                                                                    <form action="{{route('forum.RepliesReply')}}"
                                                                          method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="forum_id"
                                                                               value="{{@$forum->id}}">
                                                                        <input type="hidden" name="reply_id"
                                                                               value="{{@$reply->id}}">
                                                                        <textarea
                                                                            class="primary_textarea3 style3 forum_reply "
                                                                            name="reply"
                                                                            placeholder="Write your reply here"></textarea>
                                                                        <button type="submit"
                                                                                class="theme_btn small_btn5 text-end mt-2">
                                                                            Reply
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- End Reply of reply --}}
                                            @endforeach

                                        </div>
                                    @endif
                                    @if ($forum->is_closed!=1)
                                        <div class="forum_replay" style="margin-top: 20px">
                                            <div class="forum_replay_single">
                                                <div
                                                    class="forum_replay_head d-flex align-items-start gap_15  flex-wrap">
                                                    <div class="thumb position-relative">
                                                        <div
                                                            class="profile_info profile_img collaps_icon d-flex align-items-center">
                                                            <div class="studentProfileThumb"
                                                                 style="background-image: url('{{getProfileImage(Auth::user()->image,Auth::user()->name)}}');margin: 0"></div>
                                                        </div>

                                                    </div>
                                                    <div class="commnet_replay_box flex-fill">
                                                        <form action="{{route('forum.ForumReply')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="forum_id"
                                                                   value="{{@$forum->id}}">
                                                            <textarea class="primary_textarea3 style3 forum_reply"
                                                                      name="reply"
                                                                      placeholder="Write your reply here"></textarea>
                                                            <button type="submit"
                                                                    class="theme_btn small_btn5 text-end mt-2">Reply
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                 aria-labelledby="nav-profile-tab">...
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                 aria-labelledby="nav-contact-tab">...
                            </div>
                            <div class="tab-pane fade" id="nav-contact2" role="tabpanel"
                                 aria-labelledby="nav-contact-tab2">...
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3">

                    <div class="fourm_cat_boxes mb_20 mt-20">
                        <h3 class="cat_title f_s_20 f_w_700 mb-2">Recent Discussion</h3>
                        <div class="discussion_lists">
                            @forelse ($recent_discussion as $forum)
                                <div class="single_discussion">
                                    <h3><a href="{{route('forum.ViewForum',$forum->id)}}">{{@$forum->title}}</a></h3>
                                    <p>{{showDate($forum->created_at)}}
                                        , {{date("H:i:s A",strtotime($forum->created_at))}}</p>
                                </div>
                            @empty
                                <p>Related Forum Not Found</p>
                            @endforelse


                        </div>
                    </div>
                    <div class="fourm_cat_boxes mb_20 mt-0">
                        @php
                            $category_list= Modules\CourseSetting\Entities\Category::with('courses')->whereHas('courses.forums')->where('status',1)->get();
                        @endphp
                        <h3 class="cat_title f_s_20 f_w_700">Categories</h3>
                        <ul class="Check_sidebar" id="category_list">
                            @foreach ($category_list as $category)

                                <li>
                                    <label class="primary_checkbox d-flex">
                                        <input type="checkbox" name="category[]"
                                               {{isset($categories)? in_array($category->id,$categories)? 'checked':'':''}} class="category_select"
                                               value="{{$category->id}}">
                                        <span class="checkmark mr_10"></span>
                                        <span class="label_name font_16 f_w_400">{{$category->name}}</span>
                                    </label>
                                </li>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- fourm_area::end  -->


    @if($errors->any())
        <script>  toastr.success("Reply field is required", "Required", {timeOut: 5000}); </script>
    @endif

@endsection
