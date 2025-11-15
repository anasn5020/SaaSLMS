<option value="{{$category->id}}"
    {{$category_search==$category->id?'selected':''}}
>
    @for($i=2;$i<=$level;$i++)
        &#160; &#160;
    @endfor
    {{$category->name}}
</option>


@if(isset($category->childs))
    @if(count($category->childs)!=0)
        @foreach($category->childs as $child)
            @include('coursesetting::parts_of_course_details.category_select_option',['category'=>$child,'level'=>$level + 1])
        @endforeach
    @endif
@endif

