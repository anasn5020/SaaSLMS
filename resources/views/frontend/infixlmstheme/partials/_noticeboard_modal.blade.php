@php

    $group =$noticeboard->group==1?trans('noticeboard.General'):trans('courses.Course');
$type =$noticeboard->noticeType;
      $courses =[];
    if ($noticeboard->group==2){
      $assigns =$noticeboard->assign;
      foreach ($assigns as $assign){

              if(!$assign->course->isLoginUserEnrolled){
                                    continue;
                                }
          $courses[] =$assign->course;
      }
    }
@endphp

<div class="modal-content">
    <button class="noticeboard-modal-close bg-transparent border-0 p-0" data-bs-dismiss="modal"><i class="ti-close"></i>
    </button>
    <div class="modal-body">
        <h3 class="">{{__('noticeboard.Notice')}}
            <svg width="37" height="38" viewBox="0 0 41 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.909 11.3075H17.8941M12.6831 21.0008H18.6683M12.6831 30.6947H18.6683M38.18 17.4863H26.2775C24.0034 4.80455 29.7449 1.90723 33.0996 2.00224C40.0671 3.06617 39.5025 12.7683 38.18 17.4863ZM24.4512 38.481C32.9942 28.7011 18.2483 6.09712 31.9548 2.0023H9.50368C-3.63039 6.09712 9.9681 29.4521 2 37.7054C2 37.7054 4.70877 40 13.024 40C21.3392 40 24.4512 38.481 24.4512 38.481Z"
                    stroke="#5C6574" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span style="background: {{$type->color}}">{{$type->title}}</span>
        </h3>
        @if ($noticeboard->group==2)

            <ul>

                <li class="d-flex">
                    {{__('courses.Course')}}:
                    <div class="pl-2">
                        @foreach($courses as $key=>$course)
                            <span class="theme-text">{{$course->title}}{{$key+1!=count($courses) ? ',' :''}}</span>
                            <br>
                        @endforeach
                    </div>
                </li>

            </ul>
        @else
            <ul>

                <li class="d-flex">
                    {{__('noticeboard.General')}}

                </li>

            </ul>
        @endif

        <div class="modal-body-wrapper">
            <p>{!! $noticeboard->message !!}</p>
        </div>
    </div>
</div>
