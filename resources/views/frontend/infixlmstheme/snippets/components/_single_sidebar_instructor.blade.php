<ul class="Check_sidebar">
    @if(isset($result))
        @foreach ($result as $user)
            @php
                $hasItem=is_array(request('user_id'));
                if ($hasItem){
                    $users =request('user_id');
                }
            @endphp
            <li>
                <label class="primary_checkbox d-flex">
                    <input type="checkbox" class="instructor"
                           value="{{$user->id}}"
                    @if($hasItem)
                        {{in_array($user->id,$users)?'checked':''}}
                        @endif
                    >
                    <span class="checkmark mr_15"></span>
                    <span class="label_name">{{$user->name}}</span>
                </label>
            </li>
        @endforeach
    @endif

</ul>
