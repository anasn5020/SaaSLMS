<table>
    <tr>
        <th> {{__('common.SL')}} </th>
        <th> {{__('quiz.Student')}} </th>
        @if(isModuleActive('Org'))
            <th> {{__('org.Employee ID')}} </th>
            <th> {{__('org.Branch')}} </th>
            <th>{{__('org.Position')}}</th>
        @endif
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
    @foreach($quizzes as  $key=>$quiz)
        .
        <tr>
            <td> {{++$key}} </td>
            <td>{{$quiz->user->name}}</td>
            @if(isModuleActive('Org'))
                <td>{{$quiz->user->employee_id}}</td>
                <td>{{$quiz->user->org_chart_code}}</td>
                <td>{{$quiz->user->org_position_code}}</td>
            @endif
            <td>{{$quiz->course->title}}</td>
            <td>{{$quiz->quiz->title}}</td>
            <td>{{$quiz->quiz->percentage}}%</td>
            <td>
                @php
                    $totalCorrect = $quiz->details->where('status', 1)->sum('mark');
                    $totalMark = $quiz->quiz->totalMarks();

                    echo $totalCorrect . '/' . $totalMark;
                @endphp
            </td>


            <td>
                @php
                    $totalCorrect = $quiz->details->where('status', 1)->sum('mark');
                 $totalMark = $quiz->quiz->totalMarks();

                if ($totalMark == 0 || $totalCorrect == 0) {
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
</table>
