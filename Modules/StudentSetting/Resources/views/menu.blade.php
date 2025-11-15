<li>
    <a href="javascript:;" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small">
            <span class="fas fa-graduation-cap"></span>
        </div>
        <div class="nav_title">
            <span>{{__('student.Students')}}</span>
        </div>
    </a>
    <ul>

        @if (permissionCheck('student.student_list'))
            <li>
                <a href="{{ route('student.student_list') }}">{{__('student.Students List')}}</a>
            </li>
        @endif

        @if (permissionCheck('regular_student_import') && !isModuleActive('Org'))
            <li>
                <a href="{{ route('regular_student_import') }}">{{__('student.Regular Student Import')}}</a>
            </li>
        @endif

        @if(isModuleActive('Org') && permissionCheck('org.branch'))
            <li>
                <a href="{{ route('org.branch') }}">{{__('org.Branch')}}
                    @if(env('APP_SYNC'))
                        <span class="demo_addons_sub">Addon</span>
                    @endif
                </a>
            </li>
        @endif
        @if(isModuleActive('Org') && permissionCheck('org.position'))
            <li>
                <a href="{{ route('org.position') }}">{{__('org.Position')}}
                    @if(env('APP_SYNC'))
                        <span class="demo_addons_sub">Addon</span>
                    @endif
                </a>
            </li>
        @endif
        @if (permissionCheck('student.new_enroll') && !isModuleActive('Org'))
            <li>
                <a href="{{ route('student.new_enroll') }}">{{__('student.New Enroll')}}</a>
            </li>
        @endif


        @if (permissionCheck('student.student_field'))
            <li>
                <a href="{{ route('student.student_field') }}">{{__('student.Settings')}}</a>
            </li>
        @endif
        @if(isModuleActive('TeachOffline'))
            <li>
                <a href="{{ route('offline.student_list') }}">{{__('student.Offline Student')}}
                    @if(env('APP_SYNC'))
                        <span class="demo_addons_sub">Addon</span>
                    @endif
                </a>
            </li>
        @endif



        @if (permissionCheck('admin.enrollLogs')  && !isModuleActive('Org'))
            <li>
                <a href="{{ route('admin.enrollLogs') }}">{{__('student.Enrolled Student')}}</a>
            </li>
        @endif

        @if (permissionCheck('admin.cancelLogs')  && !isModuleActive('Org'))
            <li>
                <a href="{{ route('admin.cancelLogs') }}">{{__('student.Canceled Student')}}</a>
            </li>
        @endif

    </ul>
</li>
