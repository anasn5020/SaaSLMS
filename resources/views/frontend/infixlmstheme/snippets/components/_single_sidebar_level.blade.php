<ul class="Check_sidebar">
    @if(isset($result))
        @foreach($result as $l)

            @php
                $hasItem=is_array(request('level'));
                if ($hasItem){
                    $levels =request('level');
                }
            @endphp
            <li>
                <label class="primary_checkbox d-flex">
                    <input name="level" type="checkbox" value="{{$l->id}}"
                           class="level"
                    @if($hasItem)
                        {{in_array($l->id,$levels)?'checked':''}}
                        @endif
                       >
                    <span class="checkmark mr_15"></span>
                    <span class="label_name">{{$l->title}}</span>
                </label>
            </li>
        @endforeach
    @endif
</ul>
