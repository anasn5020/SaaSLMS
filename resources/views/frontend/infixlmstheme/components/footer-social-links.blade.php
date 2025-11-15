<div>
    @if(isset($social_links))
        @foreach($social_links as $social)
            <li><a target="_blank" href="{{$social->link}}" class=""
                   title="{{$social->name  }}"><i
                        class="{{$social->icon}}"></i></a></li>
        @endforeach
    @endif
</div>
