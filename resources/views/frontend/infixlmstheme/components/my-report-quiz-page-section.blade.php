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
                    <div class="purchase_history_wrapper pb_50 pt-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('frontend.Quiz Result History')}}</h3>
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
                                            <th>{{__('quiz.Quiz')}}</th>
                                            <th>{{__('common.Pass Rate')}}</th>
                                            <th> {{__('common.Marks')}} </th>
                                            <th> {{__('common.Result')}} </th>
                                            <th> {{__('common.Start At')}} </th>
                                            <th> {{__('common.End At')}} </th>
                                            <th> {{__('common.Duration')}} </th>
                                            <th> {{__('common.Status')}} </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(count($quizzes)!=0)
                                            @foreach($quizzes as $key=>$quiz)
                                                <tr>
                                                    <td> {{++$key}} </td>

                                                    <td>{{$quiz->course->title}}</td>
                                                    <td>{{$quiz->quiz->title}}</td>
                                                    <td>{{$quiz->quiz->percentage}}%</td>
                                                    <td>
                                                        @php
                                                            $totalCorrect = $quiz->details->where('status', 1)->sum('mark');
                                                            $totalMark = $quiz->quiz->total_marks;

                                                            echo $totalCorrect . '/' . $totalMark;
                                                        @endphp
                                                    </td>


                                                    <td>
                                                        @php
                                                            $totalCorrect = $quiz->details->where('status', 1)->sum('mark');
                                                         $totalMark = $quiz->quiz->totalMarks();

                                                        if ($totalCorrect == 0 || $totalMark==0) {
                                                             $result = 0;
                                                         } else {
                                                             $result = ($totalCorrect / $totalMark) * 100;
                                                         }
                                                         echo $result . '%';
                                                        @endphp
                                                    </td>

                                                    <td>{{$quiz->start_at}} </td>
                                                    <td>{{$quiz->end_at}} </td>
                                                    <td>{{$quiz->duration.' '.trans('common.Min')}} </td>

                                                    <td>
                                                        @php
                                                            if ($quiz->pass == 1) {
                                                                    echo trans('common.Pass');
                                                                } else {
                                                                    echo trans('common.Fail');
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
                                        {{ $quizzes->links() }}
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
