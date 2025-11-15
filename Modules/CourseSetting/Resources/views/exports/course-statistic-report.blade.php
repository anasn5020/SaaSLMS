<table>
    <tr>
        <th scope="col">{{__('SL')}}</th>
        <th scope="col">{{__('courses.Course')}}</th>
        @if(isModuleActive('Org'))
            <th scope="col">{{__('courses.Required Type')}}</th>
        @endif
        <th scope="col">{{__('courses.Enrolled')}}</th>
        <th scope="col">{{__('courses.Not Started yet')}}</th>
        <th scope="col">{{__('courses.In Progress')}}</th>
        <th scope="col">{{__('courses.Finished')}}</th>
        <th scope="col">{{__('courses.Finish Rate')}}</th>
    </tr>
    @foreach($courses  as $key=>$course)
        @php
            $statistic =$course->totalStatistic();
           $finished =$statistic['finished'];
                 $total = $course->total_enrolled;
                 $percentage = 0;
                 if ($total != 0) {
                     $percentage = ($finished / $total) * 100;
                     if ($percentage > 100) {
                         $percentage = 100;
                     }
                 }
                 $percentage= round($percentage) . '%';
        @endphp
        <tr>
            <td>{{++$key}}</td>
            <td>{{$course->title}}</td>
            @if(isModuleActive('Org'))
                <td>{{$course->required_type == 1 ? trans('courses.Compulsory') : trans('courses.Open')}}</td>
            @endif
            <td>{{$course->total_enrolled}}</td>
            <td>{{$statistic['not_start']}}</td>
            <td>{{$statistic['in_process']}}</td>
            <td>{{$statistic['finished']}}</td>
            <td>{{$percentage}}</td>
        </tr>
    @endforeach
</table>
