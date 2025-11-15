<li class="mega_menu_dropdown {{$level>3?'third_sub':''}} ">
    <a href="{{route('categoryCourse',[$category->id,$category->slug])}}">{{$category->name}}</a>
    @if(isset($category->childs))
        @if(count($category->childs)!=0)
            <ul>
                <li>
                    <div class="menu_dropdown_iner d-flex  pe-0">
                        <div class="single_menu_dropdown">

                            {{--                            <h4>{{__('courses.Sub Category')}}</h4>--}}
                            <ul>
                                @foreach( $category->childs as $child)

                                    @include(theme('partials._category'),['category'=>$child,'level'=>$level + 1 ])

                                @endforeach

                            </ul>

                        </div>

                    </div>
                </li>
            </ul>
        @endif
    @endif
</li>
