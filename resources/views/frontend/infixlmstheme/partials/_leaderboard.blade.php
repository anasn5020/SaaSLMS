@if($type=='how_to_point')
    <div class="point-table">
        <ul>
            @if(Settings('gamification_point_each_login_status'))
                <li>{{__('setting.Each login gives')}} {{Settings('gamification_point_each_login_point')}}  {{ __('setting.Points') }}</li>
            @endif
            @if(Settings('gamification_point_each_unit_complete_status'))
                <li>{{__('setting.Each unit completion gives')}} {{Settings('gamification_point_each_unit_complete_point')}}    {{ __('setting.Points') }}</li>
            @endif
            @if(Settings('gamification_point_each_course_complete_status'))
                <li>{{__('setting.Each course completion gives')}} {{Settings('gamification_point_each_course_complete_point')}}    {{ __('setting.Points') }}</li>
            @endif
            @if(Settings('gamification_point_each_certificate_status'))
                <li>{{__('setting.Each certificate gives')}} {{Settings('gamification_point_each_certificate_point')}}    {{ __('setting.Points') }}</li>
            @endif
            @if(Settings('gamification_point_each_test_complete_status'))
                <li>{{__('setting.Each successful test completion gives')}} {{Settings('gamification_point_each_test_complete_point')}}    {{ __('setting.Points') }}</li>
            @endif
            @if(Settings('gamification_point_each_assignment_complete_status'))
                <li>{{__('setting.Each successful assignment completion gives')}} {{Settings('gamification_point_each_assignment_complete_point')}}    {{ __('setting.Points') }}</li>
            @endif
            @if(Settings('gamification_point_each_comment_status'))
                <li>{{__('setting.Each discussion topic or comment gives')}} {{Settings('gamification_point_each_comment_point')}}    {{ __('setting.Points') }}</li>
            @endif
        </ul>

        <div class="d-flex justify-content-center actions">
            <button type="button" onclick="loadData('point')" class="theme_btn small_btn4">
                {{__('frontend.back')}}
            </button>
        </div>
    </div>
@elseif($type=='how_to_level')
    <div class="point-table">
        <ul>
            @if(Settings('gamification_level_entry_point_status'))
                <li>{{__('setting.Upgrade level every')}} {{Settings('gamification_level_entry_point')}}  {{ __('setting.Points') }}</li>
            @endif
            @if(Settings('gamification_level_entry_complete_status'))
                <li>{{__('setting.Upgrade level every')}} {{Settings('gamification_level_entry_complete_point')}} {{ __('setting.completed courses') }}</li>
            @endif
            @if(Settings('gamification_level_entry_badge_status'))
                <li>{{__('setting.Upgrade level every')}} {{Settings('gamification_level_entry_badge_point')}} {{ __('setting.badges') }}</li>
            @endif
        </ul>
        <div class="d-flex justify-content-center actions">
            <button type="button" onclick="loadData('level')" class="theme_btn small_btn4">
                {{__('frontend.back')}}
            </button>
        </div>
    </div>
@elseif($type=='show_badge')
    <div class="point-table">
        <div class="reward-leader-content">
            <ul>
                <li class="position-relative d-flex gap-2">
                    {{--                    <div class="reward-leader-badge">{{$student->user_level}}</div>--}}
                    <div class="reward-leader-item d-flex align-items-center justify-content-between">
                        <div class="reward-leader-profile">
                            <div class="img">
                                <img src="{{getProfileImage($student->image,$student->name)}}" alt="">
                            </div>
                            <div class="content">
                                <p>   {{$student->name}}</p>
                            </div>
                        </div>
                        <div class="reward-leader-content ">
                            <h4>  {{$student->user_badges_count}}</h4>
                            <p>{{__('setting.badges')}}</p>
                        </div>

                    </div>
                    <div class="reward-leader-position
                            @if($student->user_level==1)
                            one
                            @elseif($student->user_level==2)
                            two
                            @elseif($student->user_level==3)
                            three
                            @endif
                            ">
                        {{$student->user_level}}
                    </div>
                </li>

            </ul>
        </div>

        <div class="point-table-inner d-flex flex-wrap align-items-center">
            @foreach($student->userBadges as $item)
                @php
                    $badgeType=$item->badge->type;
                    if ($badgeType=='activity'){
                        $badgeType= trans('setting.logins');
                    }  elseif ($badgeType=='learning'){
                        $badgeType= trans('setting.completed courses');
                    }  elseif ($badgeType=='learning'){
                        $badgeType= trans('setting.completed courses');
                    }  elseif ($badgeType=='test'){
                        $badgeType= trans('setting.passed tests');
                    } elseif ($badgeType=='perfectionism'){
                        $badgeType= trans('setting.Perfectionism badges');
                    }elseif ($badgeType=='perfectionism'){
                        $badgeType= trans('setting.Perfectionism badges');
                    }elseif ($badgeType=='communication'){
                        $badgeType= trans('setting.communication');
                    }elseif ($badgeType=='certification'){
                        $badgeType= trans('setting.certification');
                    }elseif ($badgeType=='certification'){
                        $badgeType= trans('setting.certification');
                    }elseif ($badgeType=='assignment'){
                        $badgeType= trans('setting.assignment');
                    }elseif ($badgeType=='survey'){
                        $badgeType= trans('setting.survey');
                    }elseif ($badgeType=='forum'){
                        $badgeType= trans('setting.forum');
                    }
                @endphp
                <img src="{{asset($item->badge->image)}}" alt="{{$item->badge->title}}" class="badge-img"
                     data-bs-toggle="tooltip"
                     data-placement="top"
                     title="{{ucfirst($item->badge->type)}} {{$item->badge->title}} ({{$item->badge->point}} {{$badgeType}})">
            @endforeach
        </div>

        <div class="d-flex justify-content-center actions">
            <button type="button" onclick="loadData('badge')" class="theme_btn small_btn4">
                {{__('frontend.back')}}
            </button>
        </div>
    </div>
@else
    @if($type=='point' && Settings('gamification_leaderboard_filter_status')==1 && $modal==0)
        <div class="leaderboardFilter d-flex gap-10 ">
            @if(Settings('gamification_leaderboard_filter_course_level_status')==1)
                <select name="leaderboard_filter_course_level" id="leaderboard_filter_course_level" class="nice_Select leaderboard_filter"
                        onchange="">
                    <option value="">{{__('common.All')}} {{__('common.Levels')}}</option>
                    @foreach($course_levels as $level)
                        <option value="{{$level->id}}" {{request()->get('level')==$level->id?'selected':''}}>{{$level->title}}</option>
                    @endforeach
                </select>
            @endif
            @if(Settings('gamification_leaderboard_filter_class_status')==1)

                <select name="leaderboard_filter_class" id="leaderboard_filter_class" class="nice_Select leaderboard_filter"
                        onchange="">
                    <option value="">{{__('common.All')}} {{__("courses.Courses")}}</option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}" {{request()->get('course')==$course->id?'selected':''}}>{{$course->title}}</option>
                    @endforeach
                </select>
            @endif
            @if(Settings('gamification_leaderboard_filter_institute_status')==1)
                <select name="leaderboard_filter_institute" id="leaderboard_filter_institute" class="nice_Select leaderboard_filter"
                        onchange="">
                    <option value="">{{__('common.All')}} {{__('common.Institutes')}}</option>
                    @foreach($institutes as $institute)
                        <option value="{{$institute->id}}" {{request()->get('institute')==$institute->id?'selected':''}}> {{$institute->name}}</option>
                    @endforeach
                </select>
            @endif
        </div>
    @endif

    <div class="point-table">
        <div class="point-table-body overflow-auto">
            <div class="reward-leader-content">
                @php
                    $i=1;
                     $pre_point=0;
                     $point=0;
                    if (count($students)!=0){
                        if($type=='certificate'){
                        $pre_point =$students[0]->certificate_records_count;
                        }elseif($type=='courses'){
                        $pre_point =$students[0]->student_courses_count;
                        } elseif($type=='badge'){
                        $pre_point =$students[0]->user_badges_count;
                        } elseif($type=='level')
                        $pre_point =$students[0]->user_level;
                        elseif($type=='point'){
                        $pre_point =$students[0]->gamification_total_points;
                        }
                    }



                @endphp
                <ul>


                    @foreach($students as $key=> $student)
                        @php
                            $point =0;
                            if($type=='certificate'){
                            $point =$student->certificate_records_count;
                            }elseif($type=='courses'){
                            $point = $student->student_courses_count;
                            } elseif($type=='badge'){
                            $point =$student->user_badges_count;
                            } elseif($type=='level')
                            $point = $student->user_level;
                            elseif($type=='point'){
                            $point = $student->gamification_total_points;
                            }
                            if ($pre_point>$point){
                                $i++;
                                $pre_point=$point;
                                }

                            if ($point==0){
                                continue;
                            }
                        @endphp


                        <li class="position-relative d-flex gap-2">
                            {{--                            <div class="reward-leader-badge">{{$i}}</div>--}}
                            <div class="reward-leader-item d-flex align-items-center justify-content-between">
                                <div class="reward-leader-profile">
                                    <div class="img">
                                        <img src="{{getProfileImage($student->image,$student->name)}}" alt="">
                                    </div>
                                    <div class="content">
                                        <p>   {{$student->name}}</p>
                                    </div>
                                </div>
                                <div class="reward-leader-content  @if($type=='badge') reward-click-btn @endif"
                                     @if($type=='badge') onclick="loadData('show_badge',{{$student->id}})" @endif>
                                    <h4>  {{$point}}</h4>
                                    @if(!$modal)
                                        <p>{{__('setting.'.pluralize($point,ucfirst($type=='courses'?'course':$type)))}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="reward-leader-position
                            @if($i==1)
                            one
                            @elseif($i==2)
                            two
                            @elseif($i==3)
                            three
                            @endif
                            ">
                                {{$i}}
                            </div>

                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
        @if($modal==0)
            @if($type=='point')
                <div class="d-flex justify-content-center actions">
                    <button type="button" onclick="loadData('how_to_point')" class="theme_btn small_btn4">
                        {{__('frontend.How to collect points')}}
                    </button>
                </div>
            @elseif($type=='level')
                <div class="d-flex justify-content-center actions">
                    <button type="button" onclick="loadData('how_to_level')" class="theme_btn small_btn4">
                        {{__('frontend.How to level up')}}
                    </button>
                </div>
            @endif
        @endif
    </div>
@endif
<script>
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip()
    })
    @if($type=='point' && Settings('gamification_leaderboard_filter_status')==1)
    $('.nice_Select').niceSelect();

    @endif

</script>
