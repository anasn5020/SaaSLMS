<tr>
    <td>
        @for($i=2;$i<=$level;$i++)
            <span class="text-white">=></span>
        @endfor
        {{$branch->group}}
    </td>

</tr>
@if(isset($branch->childs))
    @if(count($branch->childs)!=0)
        @foreach($branch->childs as $child)
            @include('coursesetting::parts_of_course_details._branch_file_option',['branch'=>$child,'level'=>$level + 1])
        @endforeach
    @endif
@endif
