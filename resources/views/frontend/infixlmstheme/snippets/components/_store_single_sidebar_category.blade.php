<ul>
    @if (isset($result))
        @foreach ($result as $cat)
            @php
                $hasItem = is_array(request('product_category'));
                if ($hasItem) {
                    $categories = request('product_category');
                }
            @endphp

            <li>
                <label for="cate-{{ $cat->id }}" class="radio">
                    <input type="radio" name="category" class="product_category" id="cate-{{ $cat->id }}"
                           value="{{ $cat->id }}"
                    @if ($hasItem)
                        {{ in_array($cat->id, $categories) ? 'checked' : '' }}
                        @endif>
                    <span class="radio-btn"> </span>
                    <span class="radio-title">{{ $cat->title }} <span>({{ $cat->products->count() }})</span></span>
                </label>
            </li>
        @endforeach
    @endif
</ul>
