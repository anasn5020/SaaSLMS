<option value="{{$branch->code}}"
    {{$org_branch_code_search==$branch->code?'selected':''}}
>
    @for($i=2;$i<=$level;$i++)
        &#160; &#160;
    @endfor
    {{$branch->group}}
</option>


@if(isset($branch->childs))
    @if(count($branch->childs)!=0)
        @foreach($branch->childs as $child)
            @include('coursesetting::_single_select_option',['branch'=>$child,'level'=>$level + 1])
        @endforeach
    @endif
@endif
