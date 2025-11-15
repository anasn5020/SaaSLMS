<ul>
    <li>
        <label for="st-1" class="radio">

            @php
                $hasItem=is_array(request('sort_by'));
                if ($hasItem){
                    $user =request('sort_by');
                }
            @endphp

            <input type="radio" name="sort_by" class="sort_by" id="st-1"
                   value="latest" {{ isset($user)?$user[0] == 'latest' ? 'checked':'':'' }}>
            <span class="radio-btn"> </span>
            <span class="radio-title">{{ __('product.Latest') }}</span>
        </label>
    </li>
    <li>
        <label for="st-2" class="radio">
            <input type="radio" name="sort_by" class="sort_by" id="st-2"
                   value="oldest" {{ isset($user)?$user[0] == 'oldest' ? 'checked':'':'' }}>
            <span class="radio-btn"> </span>
            <span class="radio-title">{{ __('product.Oldest') }}</span>
        </label>
    </li>
    <li>
        <label for="st-3" class="radio">
            <input type="radio" name="sort_by" class="sort_by" id="st-3"
                   value="asc" {{ isset($user)?$user[0] == 'asc' ? 'checked':'':'' }}>
            <span class="radio-btn"> </span>
            <span class="radio-title">{{ __('product.Product Title (a-z)') }}</span>
        </label>
    </li>
    <li>
        <label for="st-4" class="radio">
            <input type="radio" name="sort_by" class="sort_by" id="st-4"
                   value="desc" {{ isset($user)?$user[0] == 'desc' ? 'checked':'':'' }}>
            <span class="radio-btn"> </span>
            <span class="radio-title">{{ __('product.Product Title (z-a)') }}</span>
        </label>
    </li>
</ul>


