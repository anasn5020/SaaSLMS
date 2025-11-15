<ul>
    @if(isset($result))
        @foreach($result as $l)

            @php
                $hasItem=is_array(request('user_id'));
                if ($hasItem){
                    $user =request('user_id');
                }
            @endphp

            <li>
                <label for="ins-{{$l->id}}" class="radio">
                    <input type="radio" name="user_id" class="instructor" id="ins-{{$l->id}}"
                           value="{{$l->id}}" @if($hasItem)
                        {{in_array($l->id,$user)?'checked':''}}
                        @endif>
                    <span class="radio-btn"> </span>
                    <span class="radio-title">{{$l->name}}
        <span>({{ $l->products->count() }})</span>
    </span>
                </label>
            </li>
        @endforeach
    @endif
</ul>
