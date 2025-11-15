<div class="price">
    @if(showEcommerce() && empty($text))
        <span class="prise_tag">
            <span class="current">
                @if((int)$discount!=0)
                    {{ getPriceFormat($discount) }}
                @else
                    {{ getPriceFormat($price) }}
                @endif

            </span>
            @if((int)$discount!=0)
                <del>
                    {{ getPriceFormat($price) }}
                </del>
            @endif
        </span>
    @else
        <span class="prise_tag">
            <span class="current">
                {{$text}}
            </span>
        </span>
    @endif
</div>
