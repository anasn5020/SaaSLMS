<div>
    @if (Auth::check())
        @if(auth()->user()->role_id == 1)

            <a href="{{route('continueCourse',[$course->slug])}}"
               class="theme_btn d-block text-center height_50 mb_10">{{__('common.Continue Watch')}}</a>
        @else

            @if ($is_following)
                <a data-bs-toggle="tooltip" data-placement="right"
                   title="{{__("frontend.You'll get notified about course publish")}}"
                   href="{{route('upcoming_courses.unfollow',$course->id)}}"
                   class="theme_btn d-block text-center height_50 mb_10">{{__('frontend.Unfollow')}}</a>
            @else
                <a data-bs-toggle="tooltip" data-placement="right"
                   title="{{__("frontend.You'll get notified about course publish")}}"
                   href="{{route('upcoming_courses.following',$course->id)}}"
                   class="theme_btn d-block text-center height_50 mb_10">{{__('frontend.Following')}}</a>
            @endif


            @if($is_booked)
                <a href="javascript:void(0);"
                   class="theme_line_btn d-block text-center height_50 mb_20">{{__('frontend.Already Booked')}}</a>
            @else
                @if($course->is_allow_prebooking)
                    <a href="{{route('upcoming_courses.prebooking',encrypt($course->id))}}"
                       class="theme_line_btn d-block text-center height_50 mb_20">{{__('frontend.Pre Booking')}}</a>
                @endif
            @endif

        @endif

    @else
        <a data-bs-toggle="tooltip" data-placement="right"
           title="{{__("frontend.You'll get notified about course publish")}}"
           href="{{route('upcoming_courses.following',$course->id)}}"
           class="theme_btn d-block text-center height_50 mb_10">{{__('frontend.Following')}}</a>

        @if($course->is_allow_prebooking)

            <a href="{{route('upcoming_courses.prebooking',encrypt($course->id))}}"
               class="theme_line_btn d-block text-center height_50 mb_20">{{__('frontend.Pre Booking')}}</a>
        @endif
    @endif

</div>
