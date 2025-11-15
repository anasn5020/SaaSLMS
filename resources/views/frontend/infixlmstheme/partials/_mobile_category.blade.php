<li>
    <a href="{{route('categoryCourse',[$category->id,$category->slug])}}">{{$category->name}}
        @if(isset($category->childs))
            @if(count($category->childs)!=0)
                <i id="dropdown" class="fa fa-caret-down"></i>
            @endif
        @endif
    </a>
    @if(isset($category->childs))
        @if(count($category->childs)!=0)
            <ul>
                @foreach( $category->childs as $child)

                    @include(theme('partials._mobile_category'),['category'=>$child,'level'=>$level + 1 ])

                @endforeach
            </ul>
        @endif
    @endif
</li>
