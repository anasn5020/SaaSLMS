<div class="theme_according mb_100" id="accordion1">
    <div class="row">

        @foreach($result as $key=>$category)
            @php
                if($category->parnt_id){
                    continue;
                }

            @endphp
            <div class="col-md-3 pb-3">
                <h2 class="w-100"><a
                        href="{{route('categoryCourse',[$category->id,convertToSlug($category->name)])}}">{{$category->name}}</a>
                </h2>
                <ul>
                    @foreach($category->activeSubcategories as $sub)
                        <li>
                            <a class="text-dark"
                               href="{{route('categoryCourse',[$sub->id,convertToSlug($sub->name)])}}">{{$sub->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

        @endforeach
    </div>
</div>
