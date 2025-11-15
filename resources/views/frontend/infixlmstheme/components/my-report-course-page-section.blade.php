<div>
    <style>
        .pb_50 {
            padding-bottom: 50px;
        }
    </style>
    <div class="main_content_iner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="purchase_history_wrapper pb_50">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('frontend.Learning Progress')}}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table custom_table3">
                                        <thead>
                                        <tr>
                                        <tr>
                                            <th> {{__('common.SL')}} </th>
                                            <th>{{__('courses.Course')}}</th>
                                            <th>{{__('common.Type')}}</th>
                                            <th>{{__('courses.Delivery Mode')}}</th>
                                            <th> {{__('courses.Enroll Date')}} </th>
                                            <th> {{__('courses.Completion Rate')}} </th>
                                            <th> {{__('courses.Completion Date')}} </th>
                                            <th> {{__('common.Status')}} </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(count($courses)!=0)
                                            @foreach($courses as $key=>$course)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$course->course->title}}</td>
                                                    <td>{{$course->required_type == 1 ? trans('courses.Compulsory') : trans('courses.Open')}}</td>
                                                    <td>
                                                        @php
                                                            if ($course->mode_of_delivery == 1) {
                                                              $title = trans('courses.Online');

                                                          } elseif ($course->mode_of_delivery == 2) {
                                                              $title = trans('courses.Distance Learning');
                                                          } else {
                                                              if (isModuleActive('Org')) {
                                                                  $title = trans('courses.Offline');
                                                              } else {
                                                                  $title = trans('courses.Face-to-Face');
                                                              }
                                                          }
                                                          echo $title;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        {{showDate($course->created_at)}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            if ($course->course->type == 1) {
                                                              echo $course->userTotalPercentage . '%';
                                                            }
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        {{$course->userCompleteDate}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $percentage = $course->userTotalPercentage;
                                                           if ($percentage == 0) {
                                                               echo trans('courses.Not Started yet');
                                                           }else{
                                                                 if ($course->course->type == 1) {
                                                               if ($percentage == 100) {
                                                                   echo trans('courses.Completed');
                                                               } else {
                                                                   echo trans('courses.Studying');
                                                               }
                                                           } else {
                                                               if ($percentage == 100) {
                                                                   echo trans('common.Pass');
                                                               } else {
                                                                   echo trans('common.Fail');
                                                               }
                                                           }
                                                           }

                                                        @endphp
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8">
                                                    <p class="text-center">
                                                        {{__('student.No Course Purchased Yet')}}!
                                                    </p>
                                                </td>
                                            </tr>
                                        @endif


                                        </tbody>
                                    </table>
                                    <div class="mt-4">
                                        {{ $courses->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
