<option
    value="{{$category->id}}" {{request('category')==$category->id?'selected':''}} {{ isset($edit->category_id)?$edit->category_id==$category->id?'selected':'':'' }}>
    @for($i=2;$i<=$level;$i++)
        &#160; &#160;
    @endfor
    {{$category->name}}


</option>


@if(isset($category->childs))
    @if(count($category->childs)!=0)
        @foreach($category->childs as $child)
            @include('backend.categories._single_select_option',['category'=>$child,'level'=>$level + 1])
        @endforeach
    @endif
@endif
