<ul class="Check_sidebar">
    @if(isset($result))
        @foreach ($result  as $cat)
            @php
                $hasItem=is_array(request('category_id'));
                if ($hasItem){
                    $categories =request('category_id');
                }
            @endphp
            <li>
                <label class="primary_checkbox d-flex">
                    <input type="checkbox" value="{{$cat->id}}"
                           class="category" @if($hasItem)
                        {{in_array($cat->id,$categories)?'checked':''}}
                        @endif >
                    <span class="checkmark mr_15"></span>
                    <span class="label_name">{{$cat->name}}</span>
                </label>
            </li>
        @endforeach
    @endif
</ul>
