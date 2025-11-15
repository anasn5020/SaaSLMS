<ul class="Check_sidebar">
    @if(isset($result))
        @foreach ($result as $lang)
            @php
                $hasItem=is_array(request('lang_id'));
                if ($hasItem){
                    $langs =request('lang_id');
                }
            @endphp
            <li>
                <label class="primary_checkbox d-flex">
                    <input type="checkbox" class="language"
                           value="{{$lang->id}}"
                    @if($hasItem)
                        {{in_array($lang->id,$langs)?'checked':''}}
                        @endif
                    >
                    <span class="checkmark mr_15"></span>
                    <span class="label_name">{{$lang->name}}</span>
                </label>
            </li>
        @endforeach
    @endif

</ul>
