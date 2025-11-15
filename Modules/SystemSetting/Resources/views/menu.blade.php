<li>
    <a href="#" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small">
            <span class="fas fa-users"></span>
        </div>
        <div class="nav_title">
            <span>{{__('instructor.Instructors')}}</span>
        </div>
    </a>
    <ul>
        @if (permissionCheck('allInstructor'))
            <li>
                <a href="{{ route('allInstructor') }}">{{ __('courses.All') }} {{__('instructor.Instructors')}}</a>
            </li>
        @endif
        @if (permissionCheck('admin.instructor.payout') && function_exists('showEcommerce') && showEcommerce())
            <li>
                <a href="{{ route('admin.instructor.payout') }}">{{__('common.Instructor Payout')}}</a>
            </li>
        @endif
        @if (isModuleActive('OrgInstructorPolicy') && permissionCheck('org.policy'))
            <li>
                <a href="{{ route('org.policy.index') }}">{{__('policy.Group')}} {{__('policy.Policy')}}
                    @if(env('APP_SYNC'))
                        <span class="demo_addons_sub">Addon</span>
                    @endif
                </a>
            </li>
        @endif
    </ul>
</li>
