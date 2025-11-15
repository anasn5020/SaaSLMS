<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{trans('common.Action')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">


        @if(request('location')!='invite')
            <a target="_blank"
               href="{{courseDetailsUrl($query->id, $query->type, $query->slug)}}"
               class="dropdown-item"
            > {{trans('courses.Frontend View')}}</a>

            @if(permissionCheck('courseDetails') &&  $query->type == 1)
                <a href="{{route('courseDetails', [$query->id])}}" class="dropdown-item">
                    {{__('courses.Add Lesson')}}</a>
            @endif
            @php
                if (@$query->discount_price != null) {
                     $course_price = $query->discount_price;
                 } else {
                     $course_price = $query->price;
                 }
            @endphp
            @if(permissionCheck('courseDetails') && isModuleActive('EarlyBird') && $course_price>0)
                <a href="{{route('courseDetails', [$query->id])}}?type=earlyBirdPrice" class="dropdown-item">
                    {{ __('price_plan.Price Plan') }}
                </a>
            @endif


            @if($query->feature == 0)
                <a href="{{route('courseMakeAsFeature', [$query->id, 'make'])}}" class="dropdown-item">
                    {{trans('courses.Mark As Feature')}}
                </a>
            @else
                <a href="{{route('courseMakeAsFeature', [$query->id, 'remove'])}}" class="dropdown-item">
                    {{ trans('courses.Remove Feature') }}
                </a>
            @endif


            @if (permissionCheck('course.edit'))
                <a href="{{route('courseDetails', [$query->id]) . '?type=courseDetails'}}" class="dropdown-item">
                    {{__('common.Edit') }}
                </a>
            @endif

            @if (permissionCheck('course.view'))
                <a href="{{route('courseDetails', [$query->id])}}" class="dropdown-item">
                    {{trans('common.View')}}
                </a>
            @endif

            @if (permissionCheck('course.delete'))
                <a onclick="confirm_modal('{{route('course.delete', $query->id)}}')"
                   class="dropdown-item edit_brand">{{trans('common.Delete') }}</a>
            @endif

            @if (permissionCheck('course.enrolled_students') && $query->type == 1)
                <a href="{{route('course.enrolled_students', $query->id)}}" class="dropdown-item edit_brand">
                    {{trans('student.Students')}}
                </a>
            @endif

            @if(isModuleActive('UpcomingCourse') && permissionCheck('admin.upcoming_courses.followers') && $query->is_upcoming_course)
                <a href="{{route('admin.upcoming_courses.followers', $query->id)}}"
                   class="dropdown-item">{{trans('courses.Followers')}}</a>
            @endif
            @if(isModuleActive('UpcomingCourse') && permissionCheck('admin.upcoming_courses.pre_booking') && $query->is_upcoming_course && $query->is_allow_prebooking)
                <a href="{{route('admin.upcoming_courses.pre_booking', $query->id)}}"
                   class="dropdown-item">{{trans('courses.Prebooking')}}</a>
            @endif

            @if(isModuleActive('UpcomingCourse') && permissionCheck('admin.upcoming_courses.publish') && $query->is_upcoming_course && $query->publish_status == 'pending')
                <a href="{{route('admin.upcoming_courses.publish', $query->id)}}"
                   class="dropdown-item publish_course">{{trans('courses.Publish')}}</a>
            @endif

        @endif
        @if (isModuleActive('CourseInvitation') && permissionCheck('course.courseInvitation') && $query->type == 1)
            <a href="{{route('course.courseInvitation', $query->id)}}"
               title="{{ trans('common.Sending invitation may take some time') }}"
               data-bs-toggle="tooltip" data-bs-placement="top"
               class="dropdown-item edit_brand">{{trans('common.Send Invitation')}}</a>
        @endif
    </div>
</div>


