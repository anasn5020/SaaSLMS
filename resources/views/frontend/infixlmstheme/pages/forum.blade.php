@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('forum.Forum')}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/forum.css')}}{{assetVersion()}}">
@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/forum.js')}}"></script>
@endsection

@section('mainContent')

    <x-breadcrumb :banner="trans('common.N/A')"
                  :title="trans('frontend.Join the Discussion in Our Forum')"
                  :subTitle="trans('frontend.Forum')"/>


    <div class="fourm_area section_spacing4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="fourm_header d-flex align-items-center justify-content-between flex-wrap gap_15">

                    </div>
                    <div class="fourm_body">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                 aria-labelledby="nav-home-tab">
                                <!-- content  -->
                                <div class="table-responsive">
                                    <table class="table fourm_table mb-0">
                                        <thead>
                                        <tr>
                                            <th>{{__('courses.Course')}}</th>
                                            <th>{{__('common.User')}}</th>
                                            <th>{{__('courses.Category')}}</th>
                                            <th>{{__('forum.Replies')}}</th>
                                            <th>{{__('forum.Views')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($courses as $course)

                                            <tr>
                                                <td>
                                                    <a href="{{route('forum.CourseForum',$course->id)}}">
                                                        <div class="topic_name">
                                                            <h3>
                                                                {{@$course->title}}
                                                            </h3>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <ul class="users_list">
                                                        @forelse ($course->uniqueForums->take(10) as $forum_key => $forum)
                                                            @php
                                                                if($forum_key > 2){
                                                                    continue;
                                                                }
                                                            @endphp

                                                            <li>
                                                                <div class="single_user style3">
                                                                    <div class="thumb ">
                                                                        <div
                                                                            class="profile_info profile_img collaps_icon d-flex align-items-center">
                                                                            <div class="studentProfileThumb"
                                                                                 style="background-image: url('{{getProfileImage($forum->user->image,$forum->user->name)}}');margin: 0"></div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="user_hover_card">
                                                                    <div class="user_card_top">
                                                            <span>
                                                                <div class="thumb">
                                                                    <div
                                                                        class="profile_info profile_img collaps_icon d-flex align-items-center">
                                                                        <div class="studentProfileThumb"
                                                                             style="background-image: url('{{getProfileImage($forum->user->image,$forum->user->name)}}');margin: 0"></div>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                                        <h3>{{$forum->user->name}}</h3>
                                                                        <p>{{ \Carbon\Carbon::parse($forum->user->created_at)->diffForhumans() }}
                                                                            .
                                                                            {{__('forum.Joined')}} {{showDate($forum->user->created_at)}}</p>
                                                                    </div>
                                                                    <div class="user_points">
                                                                        <span>{{__('forum.Total')}} {{__('forum.Point')}}</span>
                                                                        <h3>{{translatedNumber($forum->user->forumReply->sum('points'))}}</h3>
                                                                    </div>
                                                                    <div class="user_card_info">
                                                                        <p>{{__('forum.Total')}} {{__('forum.Post')}}
                                                                            <span> - {{translatedNumber($forum->user->forums->count())}}</span>
                                                                        </p>
                                                                        <p>{{__('forum.Total')}} {{__('forum.Reply')}}
                                                                            <span> - {{translatedNumber($forum->user->forumReply->count())}}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @empty
                                                            <li>
                                                                <span class="ti-more-alt dot_icon"></span>
                                                            </li>
                                                        @endforelse

                                                    </ul>

                                                </td>
                                                <td>
                                                    <div class="category_mark d-flex align-items-center ">
                                                        <span class="squire_bulet"> </span> {{@$course->category->name}}
                                                    </div>
                                                </td>
                                                <td>

                                                    @php
                                                        $replies=0;
                                                        foreach($course->forums as $forum){
                                                            $replies+=$forum->replies->count();
                                                        }
                                                        echo translatedNumber($replies);
                                                    @endphp

                                                </td>
                                                <td>
                                                @php
                                                    $views=0;
                                                    foreach($course->forums as $forum){
                                                        $views+=$forum->views->count();
                                                    }
                                                    echo translatedNumber($views);
                                                @endphp
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div
                                    class="fourm_footer d-flex align-items-center justify-content-between gap_15 flex-wrap">
                                    {{ $courses->links() }}
                                    <p>{{__('common.Showing')}} {{translatedNumber($data_from)}}
                                        –{{translatedNumber($data_to)}}
                                        {{__('common.of')}} {{ translatedNumber($courses->total()) }} {{__('common.results')}} </p>
                                </div>
                                <!-- content  -->
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
