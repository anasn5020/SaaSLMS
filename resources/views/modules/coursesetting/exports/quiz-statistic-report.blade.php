<table>
    <thead>
    <tr>
        <th scope="col">{{__('SL')}}</th>
        <th scope="col">{{__('quiz.Quiz')}}</th>
        @if(isModuleActive('Org'))
            <th scope="col">{{__('courses.Required Type')}}</th>
        @endif
        <th scope="col">{{__('courses.Enrolled')}}</th>
        <th scope="col">{{__('courses.Not Started yet')}}</th>
        <th scope="col">{{__('common.Fail')}}</th>
        <th scope="col">{{__('common.Pass')}}</th>
        <th scope="col">{{__('quiz.Taken Pass Rate')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($quizzes as $key=>$quiz)
        @php
            $statistic =$quiz->totalQuizStatistic();

             $pass = $statistic['pass'];
                $total = $quiz->total_enrolled;
                $percentage = 0;
                if ($total != 0) {
                    $percentage = ($pass / $total) * 100;
                    if ($percentage > 100) {
                        $percentage = 100;
                    }
                }
                $percentage= $percentage . '%';
        @endphp
        <tr>

            <td>{{++$key}}</td>
            <td>{{$quiz->title}}</td>
            @if(isModuleActive('Org'))
                <td>{{$quiz->required_type == 1 ? trans('courses.Compulsory') : trans('courses.Open')}}</td>
            @endif
            <td>{{$quiz->total_enrolled}}</td>
            <td>{{$statistic['not_start']}}</td>
            <td>{{$statistic['fail']}}</td>
            <td>{{$statistic['pass']}}</td>
            <td>{{$percentage}}</td>

        </tr>
    @endforeach
    </tbody>
</table>
